<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\Query;
$this->title = 'Forgot Password';
if (!isset($msg)) { $msg = '';}
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="msg" style="color:#F00; height:20px"><?= $msg; ?></div>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-3">
		<form id="data_form" action="forgotpassword" method="POST">
			<label>Enter Email Address <span style="color:#F00">*</span></label>
			<div class="input-control textarea full-size">
				<input name="Email" type="text" id="Email" placeholder="" />
			</div>
			<?= Html::submitButton('Change Password', ['class' => 'button primary']) ?>
			<input type="reset" value="Cancel" onClick="location.href = '../'">
		</form>
	</div>
</div>
<div class="pure-u-1"></div>