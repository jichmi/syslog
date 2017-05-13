<?php

//print_r($model);?>
<div class ="container-fluid">
  <div class ="row-fluid">
    <div class ="span12">
      <div class = "page-header">
        <h1>
          <?=$model->title?>
		    </h1>
      </div>
      <blockquote>
      <p>
        <?=$model->summary?>
       </p>
       <small>关键词<cite><?=$model->tags?></cite></small>
      </blockquote>
		</div>
	</div>
	<div class ="row-fluid">
	  <div class ="content span8">
      <?=$model->content?>
		</div>
  </div>
</div>
