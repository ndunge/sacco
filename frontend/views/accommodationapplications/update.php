<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accommodationapplications */

$this->title = 'Update Accommodationapplications: ' . $model->No_;
$this->params['breadcrumbs'][] = ['label' => 'Accommodationapplications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->No_, 'url' => ['view', 'id' => $model->No_]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accommodationapplications-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
