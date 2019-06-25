<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$baseUrl = Yii::$app->request->baseUrl;
//print_r($baseUrl);exit;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $baseUrl ?>/images/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="<?= $baseUrl; ?>/metro/js/jquery-2.1.3.js"></script>
    <script src="<?= $baseUrl; ?>/metro/js/metro.js"></script>
    <script src="<?php echo $baseUrl; ?>/js/jquery.dataTables.min.js"></script>
    <!--    <script src="--><? //= $baseUrl; ?><!--/metro/js/cards.js"></script>-->
    <script src="<?= $baseUrl; ?>/js/sha512.js"></script>
    <script src="<?= $baseUrl; ?>/js/forms.js"></script>
    <script src="<?= $baseUrl; ?>/js/scripts.js"></script>
    
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script> -->
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.36/jspdf.plugin.autotable.js"></script>-->
    <style>
    .app-bar {
    display: block;
    width: 100%;
    position: relative;
    background-color: #228B22;
    color: #ffffff;
    height: 3.125rem;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    
}</style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <header class="margin20 no-margin-left no-margin-right no-margin-top">
        <div class="container">
            <div class="pure-g">
                <div class="pure-u-1 pure-u-md-1-2">
                    <div class="image-container">
                        <div class="frame" style="padding-top : 10px; padding-bottom:10px"><!--<img src="<?= $baseUrl; ?>/images/logo saints.png" width="100px" height="50px"/>--></div>
                    </div>
                </div>
                <div class="pure-u-1 pure-u-md-1-2">

                </div>
            </div>
        </div>
        <?php
        if (Yii::$app->user->isGuest) {
            include 'menu1.php';
        } else {
            $identity = Yii::$app->user->identity;
            if ($identity->AccountTypeID == 1) {
                include 'menu3.php';
            } else {
                include 'menu3.php';
            }
        } ?>
    </header>
    <section class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => 'home',
                'template' => '<li><a href=' . Url::home() . '><span class="icon mif-home fg-kra-red"></span></a></li><li><a href=' . Url::home() . '>Home</a></li>'
            ],
            'activeItemTemplate' => "<li>{link}</li>\n",
            'options' => ['class' => 'breadcrumbs no-padding-top no-padding-left']
        ]) ?>
        <?= $content ?>
    </section>
    <div class="push"></div>
</div>

<footer class="footer">
    <div class="bg-black">
        <div class="container">
            <div class="pure-g">
                <div class="pure-u-1 pure-u-md-3-5">
                    <p class="align-left fg-white">&copy; Kencom 2017. All Rights Reserved.</p>
                </div>
                <div class="pure-u-1 pure-u-md-2-5">
                    <p class="align-center fg-white">Powered By: Winnie</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
