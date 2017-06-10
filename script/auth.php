<?php
include dirname(__FILE__)."/../models/const.php";
  header('Content-Type:text/html;chatset=utf-8');

  $filePath = '/var/log/auth.log';
  $file = fopen($filePath,'r') or die("cannot open file");
  $xml = simplexml_load_file("seed.xml");
  $content = [];
  $item = [];
  $count = 0;
  if($file){
       while(!feof($file)){
           $line = fgets($file);
           $a_str = explode(': ',$line,2);
           if(count($a_str)!=2) break;
           $xnode = $xml->addChild('item');
           $date = preg_split('/\s+/',$a_str[0],5);
           $item['date']='2017-'.$_MONTH[$date[0]].'-'.$date[1].' '.$date[2];
           $item['date'] = date("Y-m-d h:i:s",strtotime($item['date'])); 
           $xnode->addChild('datetime',$item['date']);
           $item['domean'] = $date[3];
           $xnode->addChild('domean',$item['domean']);
           $item['grantor']  = preg_replace('/\[[0-9]{1,}\]/','',$date[4]);
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
         $count++;
       }
    }
  else{
      exit("fail to open");
     }
     $fxml = $xml->asXML();
     file_put_contents('./auths.xml',$fxml);
     //echo 'load auth info success\n';
     echo $count;
