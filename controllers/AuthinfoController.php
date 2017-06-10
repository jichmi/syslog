<?php

namespace app\controllers;

use Yii;
use app\components\AuthCheckFilter;
use app\components\Loger;
use app\models\ArAuthinfo;
use app\models\AuthinfoSearch;
use app\models\Load;
use app\models\UploadForm;
use yii\web\UploadedFile;
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
           'loger' =>[
              'class' =>Loger::className(),
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
    
    public function actionReport()
    {
        return $this->render('report');    
    }

    public function actionDownload(){
         header('Content-Type:text/html;chatset=utf-8');
         $xml = simplexml_load_file("../script/seed.xml");
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

     public function actionUserTimeline(){
         return \yii\helpers\Json::encode(ArAuthinfo::userTimeline());
     }

     public function actionGrantorTimeline(){
         return \yii\helpers\Json::encode(ArAuthinfo::grantorTimeline());
     }

     public function actionUserRate(){
         return \yii\helpers\Json::encode(ArAuthinfo::userRate());
     }

     public function actionGrantorRate(){
         return \yii\helpers\Json::encode(ArAuthinfo::grantorRate());
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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ArAuthinfo::findOne($id)) !== null) {
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
                 $info = Load::loadAuth($path,0).'条记录已载入';
                 return $this->render('success',['info' => $info]);
             }
         }
         return $this->render('upload', ['model' => $model]);
     }
}
