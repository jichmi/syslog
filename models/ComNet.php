<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ComNet extends Model
{

    private $_Task =[];

    function __construct(){
      parent::__construct();
      exec('cat /proc/net/sockstat',$out); 
      $inuse = '/inuse\s+[0-9]+.[0-9]+/';
      $orphan = '/orphan\s+[\s0-9]+/';
      $tw = '/tw\s+[\s0-9]+/';
      $alloc = '/alloc\s+[\s0-9]+/';
      $mem = '/mem\s+[\s0-9]+/';
      $num = '/\s[0-9]+/';
      preg_match_all($rule4,$out[0],$Temp);
      $this->_OverView['now'] = $Temp[0][0];
}
