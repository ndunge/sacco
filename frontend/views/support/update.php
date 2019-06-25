<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Customerelationship */

$this->title = 'Update Support: ' . $model->CaseID;
$this->params['breadcrumbs'][] = ['label' => 'support', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CaseID, 'url' => ['view', 'id' => $model->CaseID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customerelationship-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
