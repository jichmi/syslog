<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ComTop extends Model
{

    private $_Task =[];
    private $_Cpu  =[];
    private $_Mem  =[];
    private $_Swap =[];
    private $_OverView=[];

    function __construct(){
      parent::__construct();
      exec('top -b -n 1 -d 3',$out); 
      $rule1 = '/\s[0-9]+.[0-9]+/';
      $rule2 = '/\s[0-9]+/';
      $rule3 = '/\s[0-9]+:[0-9]+,/';
      $rule4 = '/\s[0-9]+:[0-9]+:[0-9]+/';
      $rule5 = '/\s[0-9]+\s/';
      $rule6 = '/\s[0-9].[0-9]+/';
      
      preg_match_all($rule3,$out[0],$Temp);
      $Temp = $Temp[0];
     // $this->_OverView['run-time'] = explode(' ',$out[0])[4];//str_replace(array(',',' '),'',$Temp)[0];
      preg_match_all($rule4,$out[0],$Temp);
      $this->_OverView['now'] = $Temp[0][0];
      preg_match_all($rule5,$out[0],$Temp);
      $this->_OverView['online-user'] = $Temp[0][0];
      //load-average -> la
      preg_match_all($rule6,$out[0],$Temp);
      $this->_OverView['la1'] = $Temp[0][0];
      $this->_OverView['la2'] = $Temp[0][1];
      $this->_OverView['la3'] = $Temp[0][2];
      preg_match_all($rule2,$out[1],$Task);
      $Task = $Task[0];
      $this->_Task['total']     = $Task[0];
      $this->_Task['run']       = $Task[1];
      $this->_Task['sleeping']  = $Task[2];
      $this->_Task['stopped']   = $Task[3];
      $this->_Task['zombie']    = $Task[4];

      preg_match_all($rule1,$out[2],$Cpu);
      $Cpu = $Cpu[0];
      $this->_Cpu['us'] = $Cpu[0]; 
      $this->_Cpu['sy'] = $Cpu[1];
      $this->_Cpu['ni'] = $Cpu[2];
      $this->_Cpu['id'] = $Cpu[3];
      $this->_Cpu['wa'] = $Cpu[4];

      preg_match_all($rule2,$out[3],$Mem);
      $Mem = $Mem[0];
      $this->_Mem['total']    = intval($Mem[0]/1024); 
      $this->_Mem['used']     = intval($Mem[1]/1024);
      $this->_Mem['free']     = intval($Mem[2]/1024);
      $this->_Mem['buffers']  = intval($Mem[3]/1024);

      preg_match_all($rule2,$out[4],$Swap);
      $Swap = $Swap[0];
      $this->_Swap['total']    = intval($Swap[0]/1024); 
      $this->_Swap['used']     = intval($Swap[1]/1024);
      $this->_Swap['free']     = intval($Swap[2]/1024);
      $this->_Swap['cached']   = intval($Swap[3]/1024);
      }
  public  function getTask(){
     return $this->_Task;
     }
  public  function getCpu(){
     return $this->_Cpu;
     }
  public  function getMem(){
     return $this->_Mem;
     }
  public  function getSwap(){
     return $this->_Swap;
     }
  public  function getOv(){
     return $this->_OverView;
     }
}
