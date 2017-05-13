<?php

namespace app\controllers;

use Yii;
use app\models\ArAuthinfo;
use app\models\AuthinfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthinfoController implements the CRUD actions for ArAuthinfo model.
 */
class AuthinfoController extends Controller
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
     * Lists all ArAuthinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthinfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArAuthinfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDownload(){
         header('Content-Type:text/html;chatset=utf-8');
         $xml = simplexml_load_file("../script/auth.xml");
         $items = ArAuthinfo::find()->all();
         foreach($items as $item){
           $xnode = $xml->addChild('item');
           $xnode->addChild('user',$item['user']);
           $xnode->addChild('grantor',$item['grantor']);
           $xnode->addChild('datetime',$item['datetime']);
           $xnode->addChild('order',$item['order']);
         }
         $fxml = $xml->asXML();
         $fname = "auth".time().".xml";
         $file = fopen("../data/".$fname, "w") or die("Unable to open file!");
         fwrite($file,$fxml);
         fclose($file);
         $res=\YII::$app->response;
         $res->sendfile('../data/'.$fname);
      }
    /**
     * Creates a new ArAuthinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArAuthinfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

     public function actionCount(){
      $connection  = Yii::$app->db;
      $sql     = "SELECT `user` as name,DATE_FORMAT(`datetime`,'%Y-%m-%d') as date,COUNT(*) as count FROM `authinfo` GROUP BY DATE_FORMAT( `datetime`, '%Y-%m-%d' ),`user`";
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
       return\yii\helpers\Json::encode(['date'=>$date,'user'=>$user]);
     }

    /**
     * Updates an existing ArAuthinfo model.
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
     * Deletes an existing ArAuthinfo model.
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
     * Finds the ArAuthinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArAuthinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArAuthinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
