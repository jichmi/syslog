<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;
use app\models\ArLog;

class Loger extends ActionFilter
{
    
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $ilog = new ArLog();
        $ilog->user = Yii::$app->user->identity->getId();
        $ilog->action = $action->controller->id.'/'.$action->id;
        $para = Yii::$app->getRequest()->get();
        //TODO post信息获取与判定
        if(array_key_exists('r',$para)){
            unset($para['r']);
          }
        $ilog->para =  json_encode($para);
        $ilog->datetime = date('y-m-d h:i:s',time());;
        $ilog->save();

        return parent::afterAction($action, $result);
    }
}
