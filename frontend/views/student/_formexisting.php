<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Dimensionvalue;
use common\models\Academicyear;
use common\models\Country;
use common\models\Postcode;
use common\models\Religions;
use common\models\Academicyearsessions;
use common\models\CatholicClergy;
use common\models\Religion;
use common\models\ModeOfStudy;
use common\models\SponsorDetails;
use common\models\Miscellaneous;
use common\models\Months;

$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
$profileID = $identity->ProfileID;

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
if (!isset($msg)) { $msg = '';}
$serverpath = Yii::$app->params['serverpath'];
?>
<head>
<script src="/js/yii.validation.js" ></script></head>
<div id="msg" style="color:#F00"><?php echo $msg; ?></div>
<form id="data_form" method="POST" action="existing" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<input type="hidden" name="profileID" value="<? $profileID;?>" />
	<tr>
	<h5><b>Account Validation</b></h5>
	
	<hr class="thin bg-grayLighter">
		<td width="50%">
			<label>Student Number <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="StudentNo" type="text" id="StudentNo" value="<?= $model['StudentNo']; ?>" >          
			</div>
		</td>

		
		<td width="50%">
			<label>Activation Code <span style="color:#F00"></span></label>
			<div class="input-control text full-size">                   	
				<input name="ActivationCode" type="text" id="ActivationCode" value="<?= $model['ActivationCode']; ?>" >          
			</div>
		</td>
	</tr>	 
	</table>
	<div class="pure-u-1"></div>
	<?= Html::submitButton('Validate', ['class' => 'button primary']) ?>
	<?= Html::a('Cancel', ['create'], ['class' => 'button']) ?>
</form>
<div class="pure-u-1"></div>