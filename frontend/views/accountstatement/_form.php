<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Custledgerentry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custledgerentry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'Entry No_')->textInput() ?>

    <?= $form->field($model, 'Customer No_')->textInput() ?>

    <?= $form->field($model, 'Posting Date')->textInput() ?>

    <?= $form->field($model, 'Document Type')->textInput() ?>

    <?= $form->field($model, 'Document No_')->textInput() ?>

    <?= $form->field($model, 'Description')->textInput() ?>

    <?= $form->field($model, 'Currency Code')->textInput() ?>

    <?= $form->field($model, 'Sales (LCY)')->textInput() ?>

    <?= $form->field($model, 'Profit (LCY)')->textInput() ?>

    <?= $form->field($model, 'Inv_ Discount (LCY)')->textInput() ?>

    <?= $form->field($model, 'Sell-to Customer No_')->textInput() ?>

    <?= $form->field($model, 'Customer Posting Group')->textInput() ?>

    <?= $form->field($model, 'Global Dimension 1 Code')->textInput() ?>

    <?= $form->field($model, 'Global Dimension 2 Code')->textInput() ?>

    <?= $form->field($model, 'Salesperson Code')->textInput() ?>

    <?= $form->field($model, 'User ID')->textInput() ?>

    <?= $form->field($model, 'Source Code')->textInput() ?>

    <?= $form->field($model, 'On Hold')->textInput() ?>

    <?= $form->field($model, 'Applies-to Doc_ Type')->textInput() ?>

    <?= $form->field($model, 'Applies-to Doc_ No_')->textInput() ?>

    <?= $form->field($model, 'Open')->textInput() ?>

    <?= $form->field($model, 'Due Date')->textInput() ?>

    <?= $form->field($model, 'Pmt_ Discount Date')->textInput() ?>

    <?= $form->field($model, 'Original Pmt_ Disc_ Possible')->textInput() ?>

    <?= $form->field($model, 'Pmt_ Disc_ Given (LCY)')->textInput() ?>

    <?= $form->field($model, 'Positive')->textInput() ?>

    <?= $form->field($model, 'Closed by Entry No_')->textInput() ?>

    <?= $form->field($model, 'Closed at Date')->textInput() ?>

    <?= $form->field($model, 'Closed by Amount')->textInput() ?>

    <?= $form->field($model, 'Applies-to ID')->textInput() ?>

    <?= $form->field($model, 'Journal Batch Name')->textInput() ?>

    <?= $form->field($model, 'Reason Code')->textInput() ?>

    <?= $form->field($model, 'Bal_ Account Type')->textInput() ?>

    <?= $form->field($model, 'Bal_ Account No_')->textInput() ?>

    <?= $form->field($model, 'Transaction No_')->textInput() ?>

    <?= $form->field($model, 'Closed by Amount (LCY)')->textInput() ?>

    <?= $form->field($model, 'Document Date')->textInput() ?>

    <?= $form->field($model, 'External Document No_')->textInput() ?>

    <?= $form->field($model, 'Calculate Interest')->textInput() ?>

    <?= $form->field($model, 'Closing Interest Calculated')->textInput() ?>

    <?= $form->field($model, 'No_ Series')->textInput() ?>

    <?= $form->field($model, 'Closed by Currency Code')->textInput() ?>

    <?= $form->field($model, 'Closed by Currency Amount')->textInput() ?>

    <?= $form->field($model, 'Adjusted Currency Factor')->textInput() ?>

    <?= $form->field($model, 'Original Currency Factor')->textInput() ?>

    <?= $form->field($model, 'Remaining Pmt_ Disc_ Possible')->textInput() ?>

    <?= $form->field($model, 'Pmt_ Disc_ Tolerance Date')->textInput() ?>

    <?= $form->field($model, 'Max_ Payment Tolerance')->textInput() ?>

    <?= $form->field($model, 'Last Issued Reminder Level')->textInput() ?>

    <?= $form->field($model, 'Accepted Payment Tolerance')->textInput() ?>

    <?= $form->field($model, 'Accepted Pmt_ Disc_ Tolerance')->textInput() ?>

    <?= $form->field($model, 'Pmt_ Tolerance (LCY)')->textInput() ?>

    <?= $form->field($model, 'Amount to Apply')->textInput() ?>

    <?= $form->field($model, 'IC Partner Code')->textInput() ?>

    <?= $form->field($model, 'Applying Entry')->textInput() ?>

    <?= $form->field($model, 'Reversed')->textInput() ?>

    <?= $form->field($model, 'Reversed by Entry No_')->textInput() ?>

    <?= $form->field($model, 'Reversed Entry No_')->textInput() ?>

    <?= $form->field($model, 'Prepayment')->textInput() ?>

    <?= $form->field($model, 'Payment Method Code')->textInput() ?>

    <?= $form->field($model, 'Applies-to Ext_ Doc_ No_')->textInput() ?>

    <?= $form->field($model, 'Recipient Bank Account')->textInput() ?>

    <?= $form->field($model, 'Message to Recipient')->textInput() ?>

    <?= $form->field($model, 'Exported to Payment File')->textInput() ?>

    <?= $form->field($model, 'Dimension Set ID')->textInput() ?>

    <?= $form->field($model, 'Direct Debit Mandate ID')->textInput() ?>

    <?= $form->field($model, 'Global Dimension 3 Code')->textInput() ?>

    <?= $form->field($model, 'Apply to')->textInput() ?>

    <?= $form->field($model, 'Amount Applied')->textInput() ?>

    <?= $form->field($model, 'Recovery Priority')->textInput() ?>

    <?= $form->field($model, 'Remarks')->textInput() ?>

    <?= $form->field($model, 'Pay Mode')->textInput() ?>

    <?= $form->field($model, 'Payment Type')->textInput() ?>

    <?= $form->field($model, 'Form_To')->textInput() ?>

    <?= $form->field($model, 'Charge ID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
