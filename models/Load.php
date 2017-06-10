<?php
namespace app\models;

use Yii;
use app\models\ArLoginfo;
use app\models\ArMessage;
use app\models\ArAuthinfo;

class Load
{
    public function loadLogin($file,$mode=1){
        $loginfo = new \DOMDocument();
        $loginfo->load($file);
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        $count = 0;
        $attr = (new ArLoginfo())->attributes();
        $dif = array('id',);
        $attr = array_diff($attr,$dif);
        foreach($items as $item){
          foreach($attr as $a){
              if(!isset($item->getElementsByTagName($a)[0])){return $a;}
              $info[$a] = \trim($item->getElementsByTagName($a)[0]->nodeValue);
                     }
          $del = array('last'=>'','status'=>'');
          $search = array_diff_key($info,$del);
          $dbitem = ArLoginfo::findOne($search);
          if (!$dbitem['id']) {
            $data = new ArLoginfo();
            $data->setAttributes($info);
            $data->save();
            $count++;
          }else if($dbitem['status']!=$info['status']&&$mode){
            $dbitem['last'] = $info['last'];
            $dbitem['status'] = $info['status'];
            $dbitem->save();
            $count++;
          }else{
              }
          $infos[] = $info;
          $info = [];
        }
        return $count;
    }
    public function loadMessage($file){
        $loginfo = new \DOMDocument();
        $loginfo->load($file);
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        $count = 0;
        $attr = (new ArMessage())->attributes();
        $dif = array('id',);
        $attr = array_diff($attr,$dif);
        foreach($items as $item){
          foreach($attr as $a){
              if(!isset($item->getElementsByTagName($a)[0])){return $a;}
              $info[$a] = \trim($item->getElementsByTagName($a)[0]->nodeValue);
          }
        $search = $info;
        $dbitem = ArMessage::findOne($search);
          if (!$dbitem['id']) {
            $data = new ArMessage();
            $data->setAttributes($info);
            $data->save();
            $count++;
             }
          $infos[] = $info;
          $info = [];
        }
        return $count;
        //return $attr;
    }
    public function loadAuth($file){
        $loginfo = new \DOMDocument();
        $loginfo->load($file);
        $items = $loginfo->getElementsByTagName('item');
        $infos =[];
        $count = 0;
        $attr = (new ArAuthinfo())->attributes();
        $dif = array('id',);
        $attr = array_diff($attr,$dif);
        foreach($items as $item){
          foreach($attr as $a){
              if(!isset($item->getElementsByTagName($a)[0])){return $a;}
              $node = $item->getElementsByTagName($a)[0];
              if(isset($node)){
              $info[$a] = \trim($item->getElementsByTagName($a)[0]->nodeValue);
              }else{
                  return $a;
                  }
          }
        $search = $info;
        $dbitem = ArAuthinfo::findOne($search);
          if (!$dbitem['id']) {
            $data = new ArAuthinfo();
            $data->setAttributes($info);
            $data->save();
            $count++;
             }
          $infos[] = $info;
          $info = [];
        }
        return $count;
    }

}

?>
