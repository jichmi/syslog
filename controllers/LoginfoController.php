<?php

namespace app\controllers;

use Yii;
use app\components\AuthCheckFilter;
use app\components\Loger;
use app\models\ArLoginfo;
use app\models\Load;
use app\models\LoginfoSearch;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'except' => [],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'checkType' =>[
              'class' =>AuthCheckFilter::className(),
              'only'  =>['index',],
              'type'  =>'admin',
              ],
            'loger' =>[
              'class' =>Loger::className(),
              ],
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
         $xml = simplexml_load_file("../script/seed.xml");
         $items = ArLoginfo::find()->all();
         foreach($items as $item){
           $xnode = $xml->addChild('item');
           $xnode->addChild('name',$item['name']);
           $xnode->addChild('ip',$item['ip']);
           $xnode->addChild('ter',$item['ter']);
           $xnode->addChild('datetime',$item['datetime']);
           $xnode->addChild('last',$item['last']==NULL?'  ':$item['last']);
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
     public function actionUpload()
     {
         $model = new UploadForm();

         if (Yii::$app->request->isPost) {
             $model->xmlFile = UploadedFile::getInstance($model, 'xmlFile');
             if ($path = $model->upload()) {
                 $info = Load::loadLogin($path,0).'条记录已载入';
                 return $this->render('success',['info' => $info]);
             }
         }
         return $this->render('upload', ['model' => $model]);
     }
}

