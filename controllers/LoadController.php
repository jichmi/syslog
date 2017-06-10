<?php

namespace app\controllers;

use Yii;
use app\models\ArLoginfo;
use app\models\ArMessage;
use app\models\ArAuthinfo;
use app\models\Load;
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
    public function actionLogin()
    {
        echo Load::loadLogin('../data/login.xml');
    }
    public function actionMessage()
    {
        echo Load::loadMessage('../data/messages.xml');
    }
    public function actionAuth()
    {
        echo Load::loadAuth('../data/auths.xml');
   }
}
