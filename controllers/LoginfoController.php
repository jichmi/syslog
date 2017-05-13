<?php

namespace app\controllers;

use Yii;
use app\models\ArLoginfo;
use app\models\LoginfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginfoController implements the CRUD actions for ArLoginfo model.
 */
class LoginfoController extends Controller
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
     * Lists all ArLoginfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoginfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,]);
    }

    /**
     * Displays a single ArLoginfo model.
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
     * download all data
     */
    public function actionDownload()
    {
         header('Content-Type:text/html;chatset=utf-8');
         $xml = simplexml_load_file("../script/message.xml");
         $items = ArLoginfo::find()->all();
         foreach($items as $item){
           $xnode = $xml->addChild('item');
           $xnode->addChild('name',$item['name']);
           $xnode->addChild('ip',$item['ip']);
           $xnode->addChild('ter',$item['ter']);
           $xnode->addChild('datetime',$item['datetime']);
           $xnode->addChild('last',$item['last']);
           $xnode->addChild('status',$item['status']);
         }
         $fxml = $xml->asXML();
         $fname = "loginfo".time().".xml";
         $file = fopen("../data/".$fname, "w") or die("Unable to open file!");
         fwrite($file,$fxml);
         fclose($file);
         $res=\YII::$app->response;
         $res->sendfile('../data/'.$fname);
  }

    /**
     * Updates an existing ArLoginfo model.
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
     public function actionCount(){
      $connection  = Yii::$app->db;
      $sql     = "SELECT `name`,DATE_FORMAT(`datetime`,'%Y-%m-%d') as date,COUNT(*) as count FROM `loginfo` GROUP BY DATE_FORMAT( `datetime`, '%Y-%m-%d' ),`name`";
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
        }
        //print_r($user);
       return\yii\helpers\Json::encode(['date'=>$date,'user'=>$user]);
     }
/*      
    public function actionCount(){
      $connection  = Yii::$app->db;
      $sql     = "SELECT `name`,DATE_FORMAT(`datetime`,'%Y-%m-%d') as date,COUNT(*) as count FROM `loginfo` GROUP BY DATE_FORMAT( `datetime`, '%Y-%m-%d' ),`name`";
      $command = $connection->createCommand($sql);
      $res     = $command->queryAll();
      return $this->render("list",['data'=>$res]);
    }
    */
    /**
     * Deletes an existing ArLoginfo model.
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
     * Finds the ArLoginfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArLoginfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArLoginfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

