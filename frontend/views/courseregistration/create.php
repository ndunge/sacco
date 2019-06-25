<?php

use yii\helpers\Html;
$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}

/* @var $this yii\web\View */
/* @var $model app\models\Institution */

$this->title = 'New Session Registration';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [ 
	'SemesterCode' => $SemesterCode, 'StageCode' => $StageCode,
	'model' => $model, 'ProgrammeName' => $ProgrammeName, 
	'SemesterName' => $SemesterName, 'StageName' => $StageName,
	'ModeName' => $ModeName, 'CampusName' =>$CampusName
]) ?>