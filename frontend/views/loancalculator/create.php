<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Leaveapplication */

// $this->title = 'Create Leave Application';
// $this->params['breadcrumbs'][] = ['label' => 'Leaveapplications', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="loancalculator-create">

    

    <?= $this->render('_form', [
        'model'=> $model,
        'Credittypes' => $Credittypes,
        
    ]
    ) ?>

</div>
