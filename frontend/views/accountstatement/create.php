<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Custledgerentry */

$this->title = 'Create Custledgerentry';
$this->params['breadcrumbs'][] = ['label' => 'Custledgerentries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custledgerentry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
