<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$baseUrl = Yii::$app->request->baseUrl;

//echo "working";exit;

$this->title = 'Login';
$error = (isset($error)) ? $error : '';
$url = $baseUrl.'/site/login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-3">
		<h5>Please enter your login details below</h5> 
		<div id="error" style="color:#F00"><?= $error; ?></div>		
		<form id="file-form" action="<?= $url; ?>" method="POST" onsubmit="return false;" enctype="multipart/form-data">	
			<label>Your Email <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">
				<input name="UserName" type="text" id="UserName" value=""/>
			</div>		
			<label>Password <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">
				<input name="Password" type="password" id="Password"  value=""/>
			</div>	
			<button class="button large-button danger bg-hover-darkRed" onclick="formhash(this.form)">
									<h5 class="align-left">
									<span class="mif-pencil place-left"></span>&nbsp;
									<span class="text-shadow">Login </span></h5>
			</button>	
			<div class="pure-u-1"></div>
			Not Registered? </br>
			<?= Html::a('Create Account', ['registerr'], ['class' => 'button success']) ?>
			<div class="pure-u-1"></div>
			<?= Html::a('Forgot Password?', ['forgotpassword'], ['class' => 'link']) ?>
		</form>
	</div>
	
</div>