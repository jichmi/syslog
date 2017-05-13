<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ComLast extends Model
{

    private $_out =[];
//    private $_monTable =[''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,''=>,];

    function __construct(){
      parent::__construct();
      $file = fopen("../data/last.out", "r") or exit("Unable to open file!");
      while(!feof($file))
      {
          $dataA[] = fgets($file);
      }
      fclose($file);
      foreach($dataA as $data){
        $data =explode("|",$data);
        if($data[0]=='')break;
          $item=[];
          $item['user']   =$data[0];
          $item['tel']    =$data[1];
          $item['ip']     =$data[2];
          $item['login']  =$data[3].' '.$data[4].' '.$data[5];
          if($data[6]=="logged"){
            $item['last']   ='-';
            $item['type']   ="inline";
            }
          else if($data[6]=="crash"||$data[6]=="down"){
            $item['last']   =$data[7];
            $item['type']   =$data[6];
            }
          else{
            $item['last']   =$data[7];
            $item['type']   ="logout";
            }
          $this->_out[]=$item;
          unset($item);
      }
      }
  public  function getOut($status = ''){
    if($status == '') return $this->_out;
    foreach($this->_out as $item){
        if($item['type']==$status)
          $content[]=$item;
      }
     return $content;
     }
   private function tranTime($year = null,$mon,$day){
     }
}
