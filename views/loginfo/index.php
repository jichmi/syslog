<?php
  foreach($content as $data){
    //print_r($data);
    foreach($data as $a){
      if($a == "still"){
        if(count($data)==10)
          echo $data[0]."  ".$data[1]."  ".$data[2]."<br/>";
        else
          echo $data[0]."  ".$data[1]."<br/>";
       //print_r($data);
      }
    }
    //print_r($data);
  }
?>  
