<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Leaveapplication */

$this->title = 'Account Application';
$this->params['breadcrumbs'][] = ['label' => 'Leaveapplications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
       
        'nextContactNo' => $nextContactNo,
    ]) ?>

</div>
