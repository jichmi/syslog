<?php

function menu($items ){
  foreach($items as $item){
      if(isset($item['items'])){
        echo  '<a href="#'.$item['label'].'" class="nav-header list-group-item" data-toggle="collapse"><i class="icon-dashboard"></i>'.$item['label'].'</a> 
               <div id="'.$item['label'].'" class="nav nav-list collapse "> ';
        menu($item['items']);
        echo '</div>';
        }
      else if(isset($item['href'])){
        echo '<a href="'.$item['href'].'"class="list-group-item">'.$item['label'].'</a> ';
        }
  }
}
