<?php
  include dirname(__FILE__)."/../models/const.php";
  header('Content-Type:text/html;chatset=utf-8');

  $filePath = '/var/log/auth.log';
  $file = fopen($filePath,'r') or die("cannot open file");
  $xml = simplexml_load_file("auth.xml");
  $content = [];
  $item = [];
  if($file){
       while(!feof($file)){
           $line = fgets($file);
           $a_str = explode(': ',$line,2);
           if(count($a_str)!=2) break;
           $xnode = $xml->addChild('item');
           $date = explode(' ',$a_str[0],5);
           $item['date']='2017-'.$_MONTH[$date[0]].'-'.$date[1].' '.$date[2];
           $item['date'] = date("Y-m-d h:i:s",strtotime($item['date'])); 
           $xnode->addChild('date',$item['date']);
           $item['domean'] = $date[3];
           $xnode->addChild('domean',$item['domean']);
           $item['grantor']  = $date[4];
           $xnode->addChild('grantor',$item['grantor']);
           $shl = explode(': ',$a_str[1],2);
           if(count($shl)==2){
              $item['user'] = $shl[0];
              $item['order'] = $shl[1];
           }
           else{
              $item['user'] = 'unknow';
              $item['order'] = $shl[0];
             }
         $xnode->addChild('user',$item['user']);
         $xnode->addChild('order',$item['order']);
//         print_r($line);
//         print_r($item);
       }
    }
  else{
      exit("fail to open");
     }
     $fxml = $xml->asXML();
     file_put_contents('../data/auth.xml',$fxml);
     echo $fxml;
 //     }
//  }
