<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$baseUrl = Yii::$app->request->baseUrl;

$this->title = 'Registration';
$error = (isset($error)) ? $error : '';
$url = $baseUrl.'/site/profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-3">
		<p style="color:#F00"><?= $error; ?></p>
	<form id="file-form" action="<?= $url; ?>" method="POST" enctype="multipart/form-data">	
		 <label>Full Names <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="fullnames" type="text" id="fullnames" value="<?= $model['fullnames']; ?>"/>
            </div>
            <label>MEMBER NUMBER <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="userid" type="text" id="userid" value="<?= $model['Userid']; ?>"/>
            </div> 
            <label>ID NUMBER <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="idnumber" type="text" id="idnumber" value="<?= $model['idnumber']; ?>"/>
            </div>
		   <label>Email <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">
                <input name="Email" type="text" id="Email" value="<?= $model['Email']; ?>"/>
            </div>
		    <label>Your Username <span style="color:#F00">*</span></label>
		<div class="input-control text full-size">
			<input name="Email" type="text" id="Email" value="<?= $model['Email'];?>" disabled/>
		</div>				
	<?= Html::submitButton('Save', ['class' => 'button primary']) ?>
	<?= Html::a('Cancel', ['/studentapplication'], ['class' => 'button']) ?>	
	</form>
	</div>
</div>