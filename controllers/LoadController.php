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

class LoadController extends Controller
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

    public function actionIndex()
    {
        $loginfo = new \DOMDocument();
        $loginfo->load('../data/login.xml');
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        foreach($items as $item){
          $info['name']   = \trim($item->getElementsByTagName('name')[0]->nodeValue);
          $info['ip']     = \trim($item->getElementsByTagName('ip')[0]->nodeValue);
          $info['ter']    = \trim($item->getElementsByTagName('ter')[0]->nodeValue);
          $info['datetime'] = \trim($item->getElementsByTagName('datetime')[0]->nodeValue);
          $info['last']   = \trim($item->getElementsByTagName('last')[0]->nodeValue);
          $info['status'] = \trim($item->getElementsByTagName('status')[0]->nodeValue);
          $count = ArLoginfo::findOne([
            'name'=>$info['name'],
            'ip'=>$info['ip'],
            'ter'=>$info['ter'],
            'datetime'=>$info['datetime'],
          ]);
          if (!$count['id']) {
            $data = new ArLoginfo();
            $data->name = $info['name'];
            $data->ip = $info['ip'];
            $data->ter = $info['ter'];
            $data->datetime = $info['datetime'];
            $data->last = $info['last'];
            $data->status = $info['status'];
            $data->save();
          }else{
            $count['last'] = $info['last'];
            $count['status'] = $info['status'];
            $count->save();
            }
          $info['count'] = $count['id'];
          $infos[] = $info;
          $info = [];
        }
        return json_encode($infos);
   }
    public function actionMessage()
    {
        $loginfo = new \DOMDocument();
        $loginfo->load('../data/messages.xml');
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        foreach($items as $item){
          $info['creator'] = \trim($item->getElementsByTagName('crter')[0]->nodeValue);
          $info['lv'] = \trim($item->getElementsByTagName('lv')[0]->nodeValue);
          $info['datetime'] = \trim($item->getElementsByTagName('date')[0]->nodeValue);
          $info['type'] = 'sys';
          $info['content'] = \trim($item->getElementsByTagName('content')[0]->nodeValue);
          $count = ArMessage::findOne($info);
          if (!$count['id']) {
          $data = new ArMessage();
          $data->creator = \trim($info['creator']);
          $data->type = \trim($info['type']) ;
          $data->content = \trim($info['content']) ;
          $data->datetime = \trim($info['datetime']);
          $data->lv = \trim($info['lv']);
          $count = $data->save();
          }
          $info['count'] = $count['id'];
          $infos[] = $info;
          $info = [];
        }
        return json_encode($infos);
   }
    public function actionAuth()
    {
        $loginfo = new \DOMDocument();
        $loginfo->load('../data/auths.xml');
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        foreach($items as $item){
          $info['user'] = \trim($item->getElementsByTagName('user')[0]->nodeValue);
          $info['grantor'] = \trim($item->getElementsByTagName('grantor')[0]->nodeValue);
          $info['datetime'] = \trim($item->getElementsByTagName('date')[0]->nodeValue);
          $info['order'] = \trim($item->getElementsByTagName('order')[0]->nodeValue);
          $count = ArAuthinfo::findOne($info);
          if (!$count['id']) {
          $data = new ArAuthinfo();
          $data->user = \trim($info['user']);
          $data->grantor = \trim($info['grantor']) ;
          $data->order = \trim($info['order']) ;
          $data->datetime = \trim($info['datetime']);
          $count = $data->save();
          }
          $info['count'] = $count['id'];
          $infos[] = $info;
          $info = [];
        }
        return json_encode($infos);
   }
}
