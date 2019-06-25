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
if (!isset($msg)) { $msg = '';}
$this->title = 'Update Personal Data: ' . ' ' . $model2['No_'];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', ['model2' => $model2, 'msg' => $msg]) ?>

