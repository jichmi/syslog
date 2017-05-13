<?php
  echo "<table class='table'>\n";
  $head = array_keys($data[0]);
  echo "<thead>\n";
  foreach($head as $h){
        echo "<th>".$h."</th>\n";
    }
  echo "</thead>\n";
  echo "<tbody>\n";
  foreach($data as $content){
  echo "<tr>\n";
    foreach($head as $h){
        echo "<td>".$content[$h]."</td>\n";
      }
  echo "</tr>\n";
  }
  echo "</tbody>\n";
  echo "</table>\n";
?>  
