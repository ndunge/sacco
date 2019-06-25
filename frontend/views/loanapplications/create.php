<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Loanapplications */

//$this->title = 'Create Loanapplications';

?>
<div class="loanapplications-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'Credittypes' => $Credittypes,
        'customerDetails' => $customerDetails,
        'nextLoanNo' => $nextLoanNo,
    ]) ?>

</div>
