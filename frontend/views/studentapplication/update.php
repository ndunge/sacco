<?php

use yii\helpers\Html;
$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;

//print_r($json1);exit;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
/* @var $this yii\web\View */
/* @var $model app\models\Institution */

$this->title = 'Update Personal details: ' . ' ' . $model2->No_;
?>
<ul class="breadcrumbs no-padding-top no-padding-bottom">
		<li><a href="../"><span class="icon mif-home fg-kra-red"></span></a></li>
		<li><a href="../">Home</a></li>
		<li><?= $this->title; ?></li>
</ul>
<div class="pure-u-1"></div>

<?= $this->render('_form', ['model2' => $model2, ]) ?>

