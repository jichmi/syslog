<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ComLastb extends Model
{

    private $_out =[];

    function __construct(){
      parent::__construct();
      $file = fopen("../data/lastb.out", "r") or exit("Unable to open file!");
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
          $item['date']  =$data[3].' '.$data[4].' '.$data[5];
          $this->_out[]=$item;
          unset($item);
      }
      }
  public  function getOut(){
     return $this->_out;
     }
}
