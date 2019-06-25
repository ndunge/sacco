<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Leaveapplication */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Leaveapplications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model['No_']], ['class' => 'button primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model['No_']], [
            'class' => 'button danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Close', ['index'], ['class' => 'button warning']) ?>
    </p>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
     <tr>
        <td>
            <label>Application No</label>
            <div class="input-control text full-size">                      
                <input type="text" value="<?= $model['No_']; ?>" disabled>          
            </div>
        </td>
         
    </tr>
       <td>
            <label>Applicant Name</label>
            <div class="input-control text full-size">                      
                <input type="text" value="<?= $model['Name']; ?>" disabled>          
            </div>
        </td>  
   
  <tr>
    <td width="50%">
            <label>ID No. <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">                      
                <input name="ID No" type="text" id="ID No" value="<?= $model['National ID']; ?>"  >          
            </div>
        </td>
      
        
    </tr>

   

   
  
    </table>

    

</div>
