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
use common\models\Students;
use common\models\Customers;

$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
$customerid=$identity->Userid;
//print_r($customerid);exit;

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
?>
<script>
	function loadsemester()
	{
		var Programme = document.getElementById('Current Programme').value;
		var CurrentSemester = document.getElementById('semester').value;
		var CurrentStage = document.getElementById('stage').value;

		if (Programme != '')
		{
			var url = '/courseregistration/getsemester?Programme='+Programme;
			var response = fetch_data(url);
			populate_option("Current Semester", CurrentSemester, response);
			var url1 = '/courseregistration/getstage?Programme='+Programme;
			var response1 = fetch_data(url1);
			populate_option("Current Stage", CurrentStage, response1);
			/*
			fetch_data(url,function(response)
			{
				console.log('23232');
				populate_option("Current Semester", "0", response);
				var url = '/courseregistration/getstage?Programme='+Programme;
				fetch_data(url,function(response1)
				{
					populate_option("Current Stage", "0", response1);
				});
			});*/
		}
	}
	
	function populate_option(ElementName, Value, obj)
	{
		var x = document.getElementById(ElementName);
		for (i = 1; i < obj.length; i++)
		{
			xid = obj[i].sID;
			xname = obj[i].sName;
			var option = document.createElement('option');
			option.text = obj[i].sName;
			option.value = obj[i].sID;

			if (Value == obj[i].sID)
			{
				option.selected = true;
			}
			x.add(option);
		}
	}
	
	window.onload = function() 
	{
		loadsemester();
	};
</script>
<div id="msg" style="color:#F00"><?php echo $msg; ?></div>
<form id="data_form" method="POST" action="<?= $url; ?>" enctype="multipart/form-data" onload="loadsemester()">
	<input type="hidden" name="profileID" value="<?= $profileID;?>" />
	
	<h5><b>SECTION 1: PERSONAL DATA</b></h5>
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
	
	
	

	

    	
	</table>
	<div class="pure-u-1"></div>
	<?= Html::submitButton($model2->isNewRecord ? 'Create' : 'Save', ['class' => $model2->isNewRecord ? 'button primary' : 'button primary']) ?>
	<?= Html::a('Cancel', ['site/index'], ['class' => 'button']) ?>
</form>
<div class="pure-u-1"></div>
<div class="pure-u-1"></div>