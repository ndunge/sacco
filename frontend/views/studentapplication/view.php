<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\Dimensionvalue;
use common\models\Academicyear;
use common\models\Country;
use common\models\Postcode;
use common\models\Religion;
use common\models\Religions;
use common\models\Academicyearsessions;
use common\models\Customers;

$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
$customerid=$identity->Userid;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index'); 
}

$model2= Customers::findbysql('SELECT * from [TRAINED DB$Customer] where No_ = \''.$customerid.'\'')->one();
//print_r($model2);exit;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
$profileID = $identity->ProfileID;

if (!isset($msg)) { $msg = '';}
$url = $model2->isNewRecord ? 'create' : 'update?id='.$model2['No_'];
$DateofBirth = $model2['DOB_'];

if ($DateofBirth == '1753-01-01 00:00:00.000')
{
	$DateofBirth = date('Y-m-d');
} else
{
	$DateofBirth = date('Y-m-d',strtotime($model['Date Of Birth']));
}
 
/* @var $this yii\web\View */
/* @var $model app\models\Institution */

$this->title = 'View Application : '. $model2->No_;
?>
<ul class="breadcrumbs no-padding-top no-padding-bottom">
		<li><a href="../"><span class="icon mif-home fg-kra-red"></span></a></li>
		<li><a href="../">Home</a></li>
		<li><?= $this->title; ?></li>
</ul>
<div>
	<div>
		<?php 
			// //$full_path = Yii::$app->params['documentpath'] . $model->FileName;
			// $relative_path = explode('htdocs', $full_path)[1];
			// $path = explode('\\', $relative_path);
			// $url = join('/', $path);
		?>
	
	</div>
</div>
<div class="pure-u-1"> </div>
<p>		
        <?= Html::a('Edit', ['update', 'id' => $model2->No_], ['class' => 'button primary']) ?>
		
       
		<?= Html::a('Close', ['index'], ['class' => 'button warning']) ?>
		<?php
		// if (($model['Offer Accepted']== 0) AND ($model['Offer Defered']== 0) AND $model['ApprovalStatus'] == 2)
		// { ?>
			
		 	<?php

		// } ?>	
</p>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<hr class="thin bg-grayLighter">
		<td width="50%">
			<label>Names<sspan style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Name" type="text" id="Name" value="<?= $model2['Name']; ?>" disabled >          
			</div>
		</td>
		<td width="50%">
			<label>PASSPORT/ID NO <span style="color:#F00"></span></label>
			<div class="input-control text full-size">                   	
				<input name="ID No" type="text" id="ID No" value="<?= $model2['National ID']; ?>" disabled >          
			</div>
		</td>
	</tr>

		<tr>
	<td>
			<label>Email <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="E-Mail" type="text" id="E-Mail" value="<?= $model2['E-Mail']; ?>" disabled >          
			</div>
		</td>
		
        <td>
			<label>Telephone/Mobile No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Phone No_" type="text" id="Phone No_" value="<?= $model2['Phone No_']; ?>"  >          
			</div>
		</td>
	</tr>

	<tr>
		
		<td width="50%">
            <label>Date Of Birth <span style="color:#F00">*</span></label><br/>    
			<div class="input-control text" data-role="datepicker" data-preset="<?= $DateofBirth; ?>" data-format="yyyy-mm-dd" style="width:200px">
				<input name="Date Of Birth" type="text" id="Date Of Birth">
				<button class="button"> <span class="mif-calendar"></span></button>
			</div>
        </td>
		<td>
			<label>City <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="City" type="text" id="City" value="<?= $model2['City']; ?>"  >          
			</div>
		</td>	
	</tr>		
	<tr>
		<td>
			<label>Gender</label>
			<?php 
				$result = array('0'=>'Male', '1' => 'Female' ) ; 
			?>
			<div class="input-control text full-size">                   	
				<input type="text" value="<?= $result[$model2->Gender]; ?>" disabled>          
			</div>
		</td>

		<td>
			<label>Marital Status</label>
			<?php 
				$result = array('0'=>'SINGLE', '1' => 'MARRIED' ) ; 
			?>
			<div class="input-control text full-size">                   	
				<input type="text" value="<?= $result[$model2->MaritalStatus]; ?>" disabled>          
			</div>
		</td>
				
	</tr>
	

	
	

	
	
	
					
	</table>
<div class="pure-u-1"></div>