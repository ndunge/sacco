<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Library */

$this->title = $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Libraries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Subject], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Subject], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'timestamp',
            'Subject',
            'Title',
            'ISBN',
            'Author',
            'Call Number',
            'Publisher',
        ],
    ]) ?>

</div>
