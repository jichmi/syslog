<?php

/* @var $this yii\web\View */

$this->title = $model["key"];
?>
<div class="site-index">
<div class="container-fluid">
  <div class="row-fluid">
      <div class="span12">
            <ul class="nav nav-list">
            <?php foreach($model["list"] as $list)
            if($list != null )
              echo'
            <li class="active">
              <a href="/index.php?r=post%2Fget-post-detail&id='.$list->id.'">'.$list->title.'</a>
            </li>';
            else
              echo'空';
            ?>
            </ul>
      </div>
  </div>
</div>
</div>
