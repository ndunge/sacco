
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 
 */
;
$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Registration';
$error = (isset($error)) ? $error : '';
$url = $baseUrl . '/site/register';
$this->params['breadcrumbs'][] = $this->title;

?>
<head>
<script src="/js/yii.activeForm.js" ></script>
<script src="/js/yii.captcha.js" ></script>
<script src="/js/yii.gridView.js" ></script>
<script src="/js/yii.js" ></script>
<script src="/js/yii.validation.js" ></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
/*
jQuery(document).ready(function () {

jQuery('#register-form').yiiActiveForm(
[{"id":"profiles-verifycode",
"name":"verifyCode",
"container":".field-profiles-verifycode",
"input":"#profiles-verifycode",
"error":".help-block.help-block-error",
"validate":function (attribute, value, messages, deferred, $form) 
{yii.validation.required(value, messages, 
{"message":"Verification Code cannot be blank."});
yii.validation.captcha(value, messages, {"hash":760,"hashKey":"yiiCaptcha/site/captcha","caseSensitive":false,"message":"The verification code is incorrect."});}},

], []);
});
*/
</script>
<?php $this->registerJs("
    $('#refresh-captcha').on('click', function(e){
        e.preventDefault();

        $('#my-captcha-image').yiiCaptcha('refresh');
    })
"); ?>

</head>
<div class="pure-u-1"></div>
<div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-3">
        <div id="message" style="color:#F00">
			<div id="error" style="color:#F00"><?= $error; ?></div>
			<?= isset($message)?$message:''; ?>
		</div>	
		
      
         <?php $form = ActiveForm::begin( [
                                        'action' => $url,
                                        'method' => 'POST',
										
                                        'options' => ['id' => 'register-form','data-role'=>'validator' ,
										 'enableAjaxValidation'   => true,
										'enableClientValidation' => false,
										'onsubmit' => false
										],
                                    ] ); ?>
			<!--
			<form id="file-form" action="<?= $url; ?>" method="POST" onsubmit="return false;" enctype="multipart/form-data">	
			-->
			
            <label>First Name <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="FirstName" type="text" id="FirstName" value="<?= $model['FirstName']; ?>"/>
            </div>
            <label>Last Name <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="LastName" type="text" id="LastName" value="<?= $model['LastName']; ?>"/>
            </div>
            <label>Email <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="Email" type="text" id="Email" value="<?= $model['Email']; ?>"/>
            </div>            
            <label>Password <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="Password" type="password" id="Password" value=""/>
            </div>
            <label>Confirm Password <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="ConfirmPassword" type="password" id="ConfirmPassword" value=""/>
            </div>
			
			 <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
			
									'options'=>[
									'data-validate-func'=>'minlength',
									'data-validate-arg'=>'6',
									'data-validate-hint'=>'This field must contains a valid Verification Code!'
									],
                                    'imageOptions' => [
                                        'id' => 'my-captcha-image',
                                    ]
                                ]); ?>
			
								
			<?php echo Html::button('Refresh Verification Code', ['id' => 'refresh-captcha', 'class'=>'button large-button success']);?>
			
            <button class="button large-button danger bg-hover-darkRed" type="button" onclick="validateThenRegister(event, this.form)">
			
                <h5 class="align-left">
                    <span class="mif-pencil place-left"></span>&nbsp;
                    <span class="text-shadow">Register </span></h5>
            </button>
        </form>
    </div>