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
use common\models\Contact;

$baseUrl = Yii::$app->request->baseUrl;
// $identity = Yii::$app->user->identity;
// if (empty($identity))
// {
// 	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
// }

// $profileID = $identity->ProfileID;
// $customerid=$identity->Userid;

$Contact= new Contact();


$DateofBirth = $Contact['DOB_'];

if ($DateofBirth == '1753-01-01 00:00:00.000')
{
	$DateofBirth = date('Y-m-d');
} else
{
	$DateofBirth = date('Y-m-d',strtotime($Contact['DOB_']));
}

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
// if (!isset($msg)) { $msg = '';}
// $url = $model2->isNewRecord ? 'create' : 'update?id='.$model2->No_;
// $serverpath = Yii::$app->params['serverpath'];
// $model2= Customers::findbysql('SELECT * from [TRAINED DB$Customer] where No_ = \''.$customerid.'\'')->one();
// $model3= Profiles::findbysql('SELECT * from [TRAINED DB$online users] where Userid = \''.$customerid.'\'')->one();
// print_r($model3);exit;

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
    <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>Sidebar :: Metro UI CSS - The front-end framework for developing projects on the web in Windows Metro Style</title>

    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/docs.css" rel="stylesheet">

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
    <script src="js/docs.js"></script>
    <script src="//cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="js/ga.js"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>

<body>
<section class="container">
<style type="text/css">
.app-bar {
    display: block;
    width: 1500px;
    position: relative;

    background-color: #228B22;
    color: #ffffff;
    height: 3.125rem;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.sidebar2 {
  text-align: left;
  background: #ffffff;
  max-width: 15.625rem;
  list-style: none inside none;
  margin: -20px;
  margin-left: -10px;
  padding: 0;
  position: relative;
  width: auto;
  float: left;
  border-collapse: separate;
  border: 1px #eeeeee solid;
  width: 100%;
}
.sidebar2 li.title {
  padding: 20px 20px 10px 20px;
  font-size: 14px;
  font-weight: bold;
  border: 0;
}
.sidebar2 li.active a {
  background-color: #71b1d1;
  color: #ffffff;
  font-size:16px;
}
.container{
	width: 1500px;
}
.center{
	width: 1000px;
	align:center;
	float: left;
	margin-left: 280px;
	margin-top: -600px;
}
	
</style>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px"
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
<script>
	$(function() 
	{
		var dataSet = <?php// echo $json; ?>;
        $('#dataTables-1').dataTable( 
			{
				"bProcessing": true,
				"data": dataSet,
                                           
			} 
		);	
		$('#dataTables-1 tbody').on( 'click', 'tr', function () 
			{
				var data = $('#dataTables-1').DataTable().row(this).data();
				var No = data[0]; 
						
				location.href = '<?= $baseUrl; ?>/studentapplication/view?id='+No;
			} 
		);									
	});
</script>


<div class="row cells2">
      <ul class="sidebar2 "> 
                            <li class="title">GENERAL</li>
                            <li class="active"><a href="#"><span class="mif-home icon"></span>Dashboard</a></li>
                            <li class="stick bg-green">
                                <a  href="<?= $baseUrl; ?>/ledgerentry/"><span class="mif-tree icon"></span>Statistical Information</a>
                                
                            </li>

                             <li class="stick bg-red"><a class="dropdown-toggle" href="#"><span class="mif-cog icon"></span>Loans Hub</a>
                                 <ul class="d-menu" data-role="dropdown">
                                    <li><a href="<?= $baseUrl; ?>/loanapplications/create">New Loan Application</a></li>
                                    <li><a href="<?= $baseUrl; ?>/loansposted/">Loans Posted list</a></li>
                                    
                                    <li><a href="<?= $baseUrl; ?>/schoolfees/">School fees Savings</a></li>
                                    <li><a href="<?= $baseUrl; ?>/children/">Children</a></li>
                                    <li><a href="">Loan Balances</a></li>
                                    <li><a href="">Interest Balances</a></li>
                                    <li class="disabled"><a href="">Subitem 5</a></li>
                                </ul>
                             </li>

                          
                            <li class="stick bg-green"><a class="dropdown-toggle" href="#"><span class="mif-calculator2 icon"
                             ></span>Loans Management</a>
                                 <ul class="d-menu" data-role="dropdown">
                                    <li><a href="<?= $baseUrl; ?>/loancalculator/create">Loan Calculator</a></li>
                                    <li><a href="<?= $baseUrl; ?>/loansposted/">Loans Posted list</a></li>
                                    
                                    <li><a href="<?= $baseUrl; ?>/schoolfees/">School fees Savings</a></li>
                                    <li><a href="<?= $baseUrl; ?>/children/">Children</a></li>
                                    <li><a href="">Loan Balances</a></li>
                                    <li><a href="">Interest Balances</a></li>
                                    <li class="disabled"><a href="">Subitem 5</a></li>
                                </ul>
                            
                             </li>
                               <li class="stick bg-green"><a class="dropdown-toggle" href="#"><span class="mif-calculator2 icon"
                             ></span>Loans Guarantor Management</a>
                                 <ul class="d-menu" data-role="dropdown">
                                    <li><a href="<?= $baseUrl; ?>/loancalculator/create">Loan Guarantors</a></li>
                                    <li><a href="<?= $baseUrl; ?>/loansecurities/">Loans Guaranteed</a></li>
                                    
                                    
                                </ul>
                            
                             </li>
                                <li class="stick bg-red"><a class="dropdown-toggle" href="#"><span class="mif-cog icon"></span>Online Requests</a>
                                 <ul class="d-menu" data-role="dropdown">
                                    <li><a href="#">Dividend Requests</a></li>
                                    <li><a href="#">Standing Orders</a></li>
                                    
                                    <li><a href="#">Adjusting Deposits</a></li>
                                    
                                </ul>
                             </li>
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Reports</li>
                            <li><a href="#">Member Statement</a></li>
                            <li><a href="#">Accounts Statement</a></li>
                            <li><a href="#">Loans Guarantors</a></li>
                           
                         
                        </ul>


<div class="clearfix"></div>
<div class="pure-u-1"></div>

            <div class="center">
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

<div id="msg" style="color:#F00"><?php// echo $msg; ?></div>
<?= Html::beginForm(['site/create']) ?>
	
	
	<h5><b>SECTION 1: PERSONAL DATA- ACCOUNT OPENING</b></h5>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		  <td width="50%">
            <label>Application No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="No_" type="text" style="background-color: #D3D3D3;" id="No_" style="background-color: #D3D3D3; value="APP<?= $nextContactNo ?>" readonly>          
			</div>
		</td>
	</tr>
	<tr>
		<hr class="thin bg-grayLighter">
		<td width="50%">
			<label>Names<sspan style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Name" type="text" id="Name" >          
			</div>
		</td>
		<td width="50%">
			<label>ID No. <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="ID No" type="text" id="ID No"   >          
			</div>
		</td>
	</tr>
	<tr>
	<td width="50%">
			<label>Postal Address<sspan style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Address" type="text" id="Address"  >          
			</div>
		</td>

		<td>
			<label>City <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="City" type="text" id="City"  >          
			</div>
		</td>
		
	</tr>	
	<tr>
	<td>
			<label>Email <span style="color:#F00">*</span></label>
			
			<div class="input-control text full-size">                   	
				<input name="E-Mail" type="text" id="E-Mail"  >          
			</div>
		</td>
		
        <td>
			<label>Telephone/Mobile No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Phone No_" type="text" id="Phone No_"   >          
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
						if ($Contact->Gender==$s_id) 
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
						if ($Contact['MaritalStatus']==$s_id) 
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
						if ($Contact['Employed']==$s_id) 
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
			<label>Staff No <span style="color:#F00">(Optional)</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Staff No" type="text" id="Staff No"   >          
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
				<input name="MPESA Mobile No" type="text" id="MPESA Mobile No"   >          
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
						if ($Contact['Account Types']==$s_id) 
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
			<label>Suggested Monthly Contribution(Kshs) <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Share Capital Contribution" type="text" id="Share Capital Contribution"   >          
			</div>
		</td>

	</tr>
	<tr>
			<td>
			<label>Registration Fee Contribution <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Registration Fee Contribution" type="text" id="Registration Fee Contribution"   >          
			</div>
		</td>

		<td>
			<label>Bank Name<span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Bank Name" type="text" id="Bank Name"   >          
			</div>
		</td>

		
	</tr>
	<tr>
		

		<td>
			<label>Branch<span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Branch" type="text" id="Branch"   >          
			</div>
		</td>

		<td>
			<label>Account No<span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Account No" type="text" id="Account No"   >          
			</div>
		</td>

	</tr>
	<tr>
		

		<td>
			<label>Your Photo <span style="color:#F00">Optional</span></label>    
			<div >                   	
				<input name="file" type="file" id="file"   >          
			</div>
		</td>
		
	</tr>
	
	</table>
	

           

    
	
	<div class="pure-u-1"></div>
	<?= Html::submitButton($Contact->isNewRecord ? 'Apply Membership' : 'Save', ['class' => $Contact->isNewRecord ? 'button primary' : 'button primary']) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'button']) ?>
</form>
</div>
<div class="pure-u-1"></div>
<div class="pure-u-1"></div>
<?php Html::endForm(); ?>