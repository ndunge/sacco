<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Customerelationship */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'support', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerelationship-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
