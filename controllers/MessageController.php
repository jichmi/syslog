<?php

namespace app\controllers;

use Yii;
use app\models\ArMessage;
use app\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for ArMessage model.
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArMessage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionDownload(){
         header('Content-Type:text/html;chatset=utf-8');
         $xml = simplexml_load_file("../script/message.xml");
         $items = ArMessage::find()->all();
         foreach($items as $item){
           $xnode = $xml->addChild('item');
           $xnode->addChild('creator',$item['creator']);
           $xnode->addChild('lv',$item['lv']);
           $xnode->addChild('type',$item['type']);
           $xnode->addChild('datetime',$item['datetime']);
           $xnode->addChild('content',$item['content']);
         }
         $fxml = $xml->asXML();
         $fname = "message".time().".xml";
         $file = fopen("../data/".$fname, "w") or die("Unable to open file!");
         fwrite($file,$fxml);
         fclose($file);
         $res=\YII::$app->response;
         $res->sendfile('../data/'.$fname);
      }

     public function actionCount(){
      $connection  = Yii::$app->db;
      $sql  = "SELECT `creator` as name,DATE_FORMAT(`datetime`,'%Y-%m-%d') as date,COUNT(*) as count FROM `message` ";
      $para = Yii::$app->request->get('name');
      if($para != ''){
        $sql .= " where `creator`!='". $para."'";
        }
      $sql .=" GROUP BY DATE_FORMAT( `datetime`, '%Y-%m-%d' ),`creator`";
      $command = $connection->createCommand($sql);
      $res     = $command->queryAll();
      $user  =array();
      $date   = array();
      foreach(array_unique(array_column($res,'date')) as $idate){
          array_push($date,$idate);
        }
      foreach(array_unique(array_column($res,'name')) as $name){
          $iuser['name']=$name;
          $iuser['data']=[];
          array_push($user,$iuser);
        }
      foreach($res as $item){
         $dpos = array_search($item['date'],$date);
         $upos = array_search($item['name'],array_column($user,'name'));
         $user[$upos]['data'][$dpos] = \intval($item['count']);
       }
      foreach($user as &$u){
          if(count($u['data']) < count($date)){
              for($i = 0; $i<count($date);$i++){
                  if(!isset($u['data'][$i])){
                      $u['data'][$i] = 0;
                    }
                }
            }
            ksort($u['data']);
        }
       return\yii\helpers\Json::encode(['date'=>$date,'user'=>$user]);
     }


    /**
     * Updates an existing ArMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ArMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
