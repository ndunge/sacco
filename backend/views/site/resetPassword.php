<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
if (!isset($msg)) { $msg = '';}
?>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-3">
		<div id="msg" style="color:#F00; height:40px"><?= $msg; ?></div>
		<form id="data_form" action="reset?id=<?= urlencode($id); ?>" method="POST" onsubmit="return false;">
			<label>New Password <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">
				<input  name="NewPassword" type="password" id="NewPassword" placeholder="" />
			</div>
			<label>Confirm Password <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">
				<input name="ConfirmPassword" type="password" id="ConfirmPassword" placeholder="" />
			</div>
			<input name="save" class="button primary" type="button" id="save" onclick="resetphash(this.form, this.form.NewPassword, this.form.ConfirmPassword)" value="Change Password">
			<input type="reset" value="Cancel" onClick="location.href = '../'"> 
		</form>
	</div>
</div>
