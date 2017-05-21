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
    
    public function actionReport()
    {
        return $this->render('report');    
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

     public function actionTimeline(){
         return\yii\helpers\Json::encode(ArLoginfo::timeline());
     }

     public function actionRate(){
         return\yii\helpers\Json::encode(ArLoginfo::rate());
     }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ArLoginfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

