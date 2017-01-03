<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
<?php
    include("/var/www/syslog/views/layouts/bframe.php");
$items = [
  ['label'=>'登录记录','items'=>
    [
      ['label'=>'当前登录','href'=>Url::toRoute(['loginfo/index'])],
      ['label'=>'登陆失败','href'=>'#'],
      ['label'=>'登陆成功','href'=>'#'],
      ['label'=>'掉线记录','href'=>'#'],
    ],
  ],
  ['label'=>'服务器状态','items'=>
    [
      ['label'=>'内存信息','href'=>'#'],
      ['label'=>'磁盘信息','href'=>'#'],
      ['label'=>'数据报情况','href'=>'#'],
      ['label'=>'保持连接数量','href'=>'#'],
    ],
  ],
  ['label'=>'执行记录','items'=>
    [
      ['label'=>'授权情况','href'=>'#'],
      ['label'=>'进程执行','href'=>'#'],
      ['label'=>'登陆成功','href'=>'#'],
      ['label'=>'计划任务','href'=>'#'],
    ],
  ],
];
?>
<div class="container">
  <div class="row">
    <div class = "col-lg-3">
        <?php
        if (!Yii::$app->user->isGuest) {
             menu($items);
        }
        ?>
    </div>
    <div class="col-lg-9">
    <?=$content?>
   </div>
  </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
