<?php

namespace app\controllers;

use Yii;
use app\models\ArLoginfo;
use app\models\ArMessage;
use app\models\ArAuthinfo;
use app\models\LoginfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FileController extends Controller
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
    public function actionindex(){
        echo 'connot visit';
    }
    public function actionDownlogin(){
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
         $fname = "loginfo".date('Y-m-d').".xml";
         $file = fopen("../data/".$fname, "w") or die("Unable to open file!");
         fwrite($file,$fxml);
         fclose($file);
         $res=\YII::$app->response;
         $res->sendfile('../data/'.$fname);
      }
    public function actionDownauth(){
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
    public function actionDownmessage(){
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
}
