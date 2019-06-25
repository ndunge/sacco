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
use common\models\Customers;
use common\models\Profiles;

$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}

$profileID = $identity->ProfileID;
$customerid=$identity->Userid;
// print_r($customerid);exit;


$DateofBirth = $model2['DOB_'];

if ($DateofBirth == '1753-01-01 00:00:00.000')
{
	$DateofBirth = date('Y-m-d');
} else
{
	$DateofBirth = date('Y-m-d',strtotime($model2['Date Of Birth']));
}

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
if (!isset($msg)) { $msg = '';}
$url = $model2->isNewRecord ? 'create' : 'update?id='.$model2->No_;
$serverpath = Yii::$app->params['serverpath'];
$model2= Customers::findbysql('SELECT * from [TRAINED DB$Customer] where No_ = \''.$customerid.'\'')->one();
// print_r($model2);exit;
$model3= Profiles::findbysql('SELECT * from [TRAINED DB$online users] where Userid = \''.$customerid.'\'')->one();
// print_r($model3);exit;

?>
<head>
<script src="/js/yii.validation.js" ></script></head>

<script>


    
    //console.log()

    $(function() 
    {
        
        $('#dataTables-1').dataTable( 
            {
                "bProcessing": true,
                "data": dataSet,
                "searching": false,
                "paging":false,
                "ordering": false,
                "info": false,
                "filter": false,
                
            

            } 
        );                                  
    })
    ;
</script>
<script>

    
    //console.log()

    $(function() 
    {
       
        $('#dataTables-2').dataTable( 
            {
                "bProcessing": true,
                "data": dataSet,
                "searching": false,
                "paging":false,
                "ordering": false,
                "info": false,
                "filter": false,
                
            

            } 
        );                                  
    })
    ;
</script>
<script>
	//var serverurl = 'http://localhost:8080/ritman/frontend/web';
	var serverurl="<?= $serverpath;  ?>";
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
	function clear_option(ElementName)
{
 var select = document.getElementById(ElementName);
 var length = select.options.length;
 for (i = 0; i < length; i++) 
 {
  select.options[i] = null;
 }
}
	
	function fetch_data(url,mydata)
	{	
		access_token = '';
		UserID = localStorage.getItem("UserID");
		var obj = [];
		jQuery.ajax( {
			url: serverurl+url,
			type: 'GET',
			dataType: "json",
			data: { 'UserID': UserID },
			beforeSend : function( xhr ) 
			{
				xhr.setRequestHeader( "Authorization", access_token );
			},
			success: function( response ) 
			{
				// response
				mydata(response);		
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) 
			{ 
				var rest = '{ "name": "Success", "message" : "Validated", "code": "00", "status": 200}';			
				obj = JSON.parse(rest);
				//mydata(obj);
			} 
		});	
	}
	
	function loadsemester1()
	{
		var Programme = document.getElementById('ProgrammeID').value;
		if (Programme != '') 
		{
			var url = '/courseregistration/getsemester?Programme='+Programme;
			fetch_data(url,function(response) 
			{
				populate_option("IntakeID", "0", response);
				var url = '/courseregistration/getstage?Programme='+Programme;
				fetch_data(url,function(response1) 
				{
					clear_option("StageID");
					populate_option("StageID", "0", response1);
				});
			});
		}
	}

	function loadsemester()
	{
		var Programme = document.getElementById('ProgrammeID').value;
		if (Programme != '') 
		{
			var url = '/courseregistration/getstage?Programme='+Programme;
			fetch_data(url,function(response1) 
			{
				clear_option("StageID");
				populate_option("StageID", "0", response1);
			});
		}
	}

	function loadsession()
	{
		var AcademicYearID = document.getElementById('AcademicYearID').value;
		if (AcademicYearID != '') 
		{
			var url = '/courseregistration/getsession?AcademicYear='+AcademicYearID;
			fetch_data(url,function(response1) 
			{
				populate_option("Academic Session", "0", response1);
			});
		}
	}

	function loadstream()
	{
		var Programme = document.getElementById('Programme').value;
		var AcademicYear = document.getElementById('Academic Year').value;
		var Semester = document.getElementById('Semester').value;
		var Stage = document.getElementById('Stage').value;

		if ((Programme != '') && (AcademicYear != '') && (Semester != '') && (Stage != ''))
		{
			var url = '/courseregistration/getstream?Programme='+Programme+'&AcademicYear='+AcademicYear+'&Semester='+Semester+'&Stage='+Stage;
			fetch_data(url,function(response) 
			{
				populate_option("Student Stream", "0", response);
			});
		}
	}
</script>

<script type="text/javascript">
	function hidePage(){
		document.getElementById("myDIV").style.display = "none";
	}
	function loadPage(){
		document.getElementById("myDIV").style.display = "block";
	}
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
	<td width="50%">
			<label>Address<sspan style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Address" type="text" id="Address" value="<?= $model2['Address']; ?>" disabled >          
			</div>
		</td>

		<td>
			<label>City <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="City" type="text" id="City" value="<?= $model2['City']; ?>" disabled >          
			</div>
		</td>
		
	</tr>	
	<tr>
	<td>
			<label>Email <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="E-Mail" type="text" id="E-Mail" value="<?= $model3['Email']; ?>" disabled >          
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
		<td>
			<label>Gender <span style="color:#F00">*</span></label>
			<div data-role="select"> 
				<select name="Gender"  id="Gender" class="input-control full-size" disabled>
					<option value="0" selected="selected"></option>
					<?php 
					$result = array('0'=>'Male', '1' => 'Female' ) ;                   
					foreach ($result AS $key => $value)
					{
						$s_id = $key;
						$s_name = $value;
						if ($model2->Gender==$s_id) 
						{
							$selected = 'selected="selected"';
						} else
						{
							$selected = '';
						}												
						?>
						<option value="<?php echo $s_id; ?>" <?php echo $selected; ?>><?php echo $s_name; ?></option>
						<?php 
					}  ?>                        
				</select>
			</div>
		</td>
		<td>
			<label>Marital Status <span style="color:#F00">*</span></label>
			<div data-role="select"> 
				<select name="maritalstatus"  id="maritalstatus" class="input-control full-size" disabled>
					<option value="0" selected="selected"></option>
					<?php 
					$result = array('0'=>'SINGLE', '1' => 'MARRIED' ) ;                   
					foreach ($result AS $key => $value)
					{
						$s_id = $key;
						$s_name = $value;
						if ($model2['MaritalStatus']==$s_id) 
						{
							$selected = 'selected="selected"';
						} else
						{
							$selected = '';
						}												
						?>
						<option value="<?php echo $s_id; ?>" <?php echo $selected; ?>><?php echo $s_name; ?></option>
						<?php 
					}  ?>                        
				</select>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label>Employed<span style="color:#F00">*</span></label>
			<div data-role="select"> 
				<select name="Employed"  id="Employes" class="input-control full-size" disabled>
					<option value="0" selected="selected"></option>
					<?php 
					$result = array('0'=>'YES', '1' => 'NO' ) ;                   
					foreach ($result AS $key => $value)
					{
						$s_id = $key;
						$s_name = $value;
						if ($model2['Employed']==$s_id) 
						{
							$selected = 'selected="selected"';
						} else
						{
							$selected = '';
						}												
						?>
						<option value="<?php echo $s_id; ?>" <?php echo $selected; ?>><?php echo $s_name; ?></option>
						<?php 
					}  ?>                        
				</select>
			</div>
		</td>
		<td>
			<label>Staff No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Staff No" type="text" id="Staff No" value="<?= $model2['Staff No']; ?>"  >          
			</div>
		</td>
	</tr>
	<tr>
		<td width="50%">
            <label>Date Of Join <span style="color:#F00">*</span></label><br/>    
			<div class="input-control text" data-role="datepicker" data-preset="<?= $DateofBirth; ?>" data-format="yyyy-mm-dd" style="width:200px">
				<input name="Date Of Birth" type="text" id="Date Of Birth">
				<button class="button"> <span class="mif-calendar"></span></button>
			</div>
        </td>
         <td>
			<label>MPESA Mobile No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="MPESA Mobile No" type="text" id="MPESA Mobile No" value="<?= $model2['MPESA Mobile No']; ?>"  >          
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<label>Account Types <span style="color:#F00">*</span></label>
			<div data-role="select"> 
				<select name="Account Types"  id="Account Types" class="input-control full-size">
					<option value="0" selected="selected"></option>
					<?php 
					$result = array('0'=>'Individual', '1' => 'Group', '2' => 'Company') ;                   
					foreach ($result AS $key => $value)
					{
						$s_id = $key;
						$s_name = $value;
						if ($model2['Account Types']==$s_id) 
						{
							$selected = 'selected="selected"';
						} else
						{
							$selected = '';
						}												
						?>
						<option value="<?php echo $s_id; ?>" <?php echo $selected; ?>><?php echo $s_name; ?></option>
						<?php 
					}  ?>                        
				</select>
			</div>
		</td>

		<td>
			<label>Share Capital Contribution <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Share Capital Contribution" type="text" id="Share Capital Contribution" value="<?= $model2['Share Capital Contribution']; ?>"  >          
			</div>
		</td>

	</tr>
	<tr>
			<td>
			<label>Registration Fee Contribution <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Registration Fee Contribution" type="text" id="Registration Fee Contribution" value="<?= $model2['Registration Fee Contribution']; ?>"  >          
			</div>
		</td>

		<td>
			<label>Your Photo <span style="color:#F00">*</span></label>    
			<div >                   	
				<input name="file" type="file" id="file" value="<?= $model2['Picture']; ?>"  >          
			</div>
		</td>
		
	</tr>
	
	</table>
	

           

    
	
	<div class="pure-u-1"></div>
	<?= Html::submitButton($model2->isNewRecord ? 'Create' : 'Save', ['class' => $model2->isNewRecord ? 'button primary' : 'button primary']) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'button']) ?>
</form>
<div class="pure-u-1"></div>
<div class="pure-u-1"></div>