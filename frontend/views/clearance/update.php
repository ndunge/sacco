<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Clearance */

$this->title = 'Update Clearance: ' . $model->No_;
$this->params['breadcrumbs'][] = ['label' => 'Clearances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->No_, 'url' => ['view', 'id' => $model->No_]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clearance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
