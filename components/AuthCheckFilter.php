<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\ForbiddenHttpException;

class AuthCheckFilter extends ActionFilter
{
    public $type;
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        if($this->type != Yii::$app->user->identity->getType()){
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
          }   
        return parent::beforeAction($action);
    }
}
