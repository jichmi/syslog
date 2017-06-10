<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ArSetting;
use app\models\ArAuthinfo;
use app\models\ArLoginfo;
use app\models\ArMessage;
use app\models\Load;

class MaintenanceController extends Controller
{
    public function actionIndex()
    {
       $set = ArSetting::findOne(['name'=>'系统数据有效期']);
       $now = date("Y-m-d h:i:s");
       $setting = date("Y-m-d h:i:s",strtotime('-'.$set['value'].' days'));
       echo 'before '.$setting.' ';
       $data = ArMessage::deleteAll('datetime < :setting',array(':setting'=>$setting));
       print_r($data);
    }
    public function actionsTest()
    {
        print_r(Load::load(ArAuthinfo,'../data/auths.xml'));
    }
}
