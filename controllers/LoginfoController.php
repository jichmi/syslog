<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionStillLogin()
    {
      exec("last",$dataA);
      foreach($dataA as &$data){
        $data =explode(" ",$data);
        $data =array_filter($data);
      }
      $content = [];
      foreach($dataA as $data){
        foreach($data as $a){
          $c[] = $a;
        }
        Array_push($content,$c);
        $c=[];
      }
      return $this->render('index',['content'=>$content]);
    }
    public function actionIndex(){
      $dataS = file_get_contents("/home/jcm/test/bak");
      $dataA = 
      print_r($dataS);
    }
    public function actionFailLogin(){
          
    }
    public function actionSuccessLogin(){
          
    }
    public function actionCrash(){
          
    }
}
