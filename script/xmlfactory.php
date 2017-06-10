<?php
include dirname(__FILE__)."/../models/const.php";
     function test($a_str){
       $date = preg_split('/\s+/',$a_str,5);
       $item['date']='2017-'.$_MONTH[$date[0]].'-'.$date[1].' '.$date[2];
       $item['date'] = date("Y-m-d h:i:s",strtotime($item['date'])); 
           $item['domean'] = $date[3];
           $item['crter']  = preg_replace('/\[[0-9]{1,}\]/','',$date[4]);
           print_r($item);
        }
