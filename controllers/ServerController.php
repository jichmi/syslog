<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\ComTop;
use app\models\LoginForm;
use app\models\ContactForm;

class ServerController extends Controller
{   /**
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
   public function actionIndex()
    {
        exec('top -b -n 1 -d 3',$out);  
        $Cpu = explode('  ', $out[2]);  
        $Mem = explode('  ', $out[3]);  
        $Swap = explode('  ', $out[4]);  
        var_dump($Cpu,$Mem,$Swap);  
                           
 
    }
   public function actionTask(){
     $top = new ComTop;
     $content  = $top->getTask();
     return $this->render('output',['content'=>$content]);
    }
   public function actionCpu(){
     $top = new ComTop;
     $content  = $top->getCpu();
     return $this->render('output',['content'=>$content]);
    }
    public function actionMem(){
     $top = new ComTop;
     $content  = $top->getMem();
     return $this->render('output',['content'=>$content]);
    }
    public function actionSwap(){
     $top = new ComTop;
     $content  = $top->getSwap();
     return $this->render('output',['content'=>$content]);
    }
    public function actionOver(){
     $top = new ComTop;
     $content  = $top->getOv();
     return $this->render('output',['content'=>$content]);
    }
}
