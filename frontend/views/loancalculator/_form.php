<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Dimensionvalue;
use common\models\Leaveapplication;
use common\models\LeaveTypes;
use common\models\Employees;
use yii\helpers\Url;



$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
//$ProfileID = $identity->ProfileID;

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
if (!isset($msg)) { $msg = '';}
//$url = $model->isNewRecord ? 'create' : 'update?id='.$model['Application No'];

$jsCalcLeaveBalance = <<<JS
	var result =   document.getElementById("LeaveEntitlment").value -  document.getElementById("DaysApplied").value;
 	document.getElementById("Leavebalance").value = result;
JS;
?>
<script>

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function calcvalues()
{
	if (!document.getElementById("DaysApplied").value)
	{
		alert("You must enter the days applied");
		return;
	}

if (!isNumeric(document.getElementById("DaysApplied").value))
	{
		alert("Invalid days applied");
		return;
	}
	var result =   document.getElementById("LeaveEntitlment").value -  document.getElementById("DaysApplied").value;
 	document.getElementById("Leavebalance").value = result;
}	


</script>

<script>

function calcDate()
{
	
var result2 =   new Date(document.getElementById("StartDate").value);
var result3 =   new Date(document.getElementById("ResumptionDate").value);
var result1=result2.addDays(parseInt(document.getElementById("DaysApplied").value));
// var result1 = result2 + parseInt(document.getElementById("DaysApplied").value);
	alert(result1);
 var result4=	document.getElementById("EndDate").value = result1.format("yyyy-mm-dd");;
 var result5=	document.getElementById("ResumptionDate").value = result1.format("yyyy-mm-dd");;

}
Date.prototype.addDays = function(days)
 {
 	alert(days);
    this.setDate(this.getDate() + parseInt(days));
    return this;
};
</script>
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
	margin-top: -480px;
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
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>


<div class="clearfix"></div>
<!-- <script>

        $this->registerJs("$('#Leavetype').on('change',function(){
    $.ajax({
        url: '".yii\helpers\Url::toRoute("Leaveapplication/Leave")."',
        dataType: 'json',
        method: 'GET',
        data: {id: $(this).val()},
        success: function (data, textStatus, jqXHR) {
            $('#LeaveEntitlment').val(data.Days);
            
        },
        beforeSend: function (xhr) {
            alert('loading!');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request');
        }
    });
});"); 

      </script>
</head>
</head>

<script>
	var serverurl = 'http://localhost:90/ritman/frontend/web';
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
	
	
	
	
    
    
</script> -->
 <div class="center">
<div id="msg" style="color:#F00"><?php echo $msg; ?></div>
<?= Html::beginForm(['loancalculator/create']) ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">


	<tr>
		

		<td>
			<label>Loan Type <span style="color:#F00">*</span></label>		 
<?= Html::dropDownList('Credit Code', ' ', $Credittypes , [
                    'class' => 'input-control full-size',
                    'id' => 'Credittype',
                    'prompt' => '',
                     'onchange'=>'
                        
                        
                        $.get( "'.Url::toRoute('loancalculator/leave').'", { code: $(this).val() } )

                            .done(function(data) {
                            	var amount = parseFloat($.parseJSON(data));
                            	var installment = parseInt($.parseJSON(data));
                            	
                            	$("#LoanAmount").val(amount);
                            	

                            }
                        );
                             $.get( "'.Url::toRoute('loancalculator/leavee').'", { code: $(this).val() } )

                            .done(function(dataa) {
                            	
                            	var installment = parseInt($.parseJSON(dataa));
                            	
                            	
                            	$("#Installment").val(installment);

                            }
                        );

                            $.get( "'.Url::toRoute('loancalculator/leav').'", { code: $(this).val() } )

                            .done(function(dat) {
                            	
                            	var repayment = parseInt($.parseJSON(dat));
                            	
                            	
                            	$("#repayment").val(repayment);

                            }
                        );
                              $.get( "'.Url::toRoute('loancalculator/loan').'", { code: $(this).val() } )

                            .done(function(datt) {
                            	
                            	var repaymentmethod = parseInt($.parseJSON(datt));
                            	
                            	
                            	$("#repaymentmethod").val(repaymentmethod);

                            }
                        );

                                 $.get( "'.Url::toRoute('loancalculator/interest').'", { code: $(this).val() } )

                            .done(function(dati) {
                            	
                            	var interest = parseInt($.parseJSON(dati));
                            	
                            	
                            	$("#interestrate").val(interest);

                            }
                        );

                         $.get( "'.Url::toRoute('loancalculator/repayment').'", { code: $(this).val() } )

                            .done(function(dats) {
                            	
                            	var estimaterepayment = parseInt($.parseJSON(dats));
                            	
                            	$("#totalmonthly").val(estimaterepayment);

                            }
                        );
                    '
                 
                ]) ?>
                      
		</td>
		
	</tr>

	<tr>
	    <td width="50%">
            <label>Loan Amount <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Loan Amount" type="text" id="LoanAmount" value="" onchange="calcvalues()"/>         
			</div>
		</td>
		</tr>
		<tr>
	  <td width="50%">
            <label>Repayment Period <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Installment" type="text" id="Installment" value="" onchange="calcvalues()"/>         
			</div>
		</td>
		</tr>
		<tr>
		 <td width="50%">
            <label>Repayment Frequency <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="repayment" type="text" id="repayment" value="" onchange="calcvalues()"/>         
			</div>
		</td>
			
		</tr>
		<tr>
			 <td width="50%">
            <label>Repayment Method <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="repaymentmethod" type="text" id="repaymentmethod" value="" onchange="calcvalues()"/>         
			</div>
		</td>
		</tr>
		<tr>
			<tr>
			 <td width="50%">
            <label>Estimated Monthly repayments <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="totalmonthly" type="text" id="totalmonthly" value="" onchange="calcvalues()"/>         
			</div>
		</td>
		</tr>
		<tr>
			 <td width="50%">
            <label>Minimum Interest Rate <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="interestrate" type="text" id="interestrate" value="" onchange="calcvalues()"/>         
			</div>
		</td>
		</tr>
		<tr>
				<td width="50%">
            <label>First Payment Date <span style="color:#F00">*</span></label>    
			<div class="input-control text" data-role="datepicker" data-preset="<?= date('Y-m-d') ?>" data-format="yyyy-mm-dd" style="width:200px">
				<input name="first payment Date" type="text" id="first payment date" style="background-color: #D3D3D3; >
				<button class="button"> <span class="mif-calendar"></span></button>
			</div>
        </td>
		</tr>
	

     
	

	
	
	   
								
	</table>
	<div class="pure-u-1"></div>
	<?= Html::submitButton($model->isNewRecord ? 'Generate Loan Repayment Loan' : 'Save', ['class' => $model->isNewRecord ? 'button primary' : 'button primary']) ?>
	<div id="schedule" >
		<table>
		<thead>
			<th>#</th>
			<th>Due Date</th>
			<th>Principle Amount</th>
			<th>Monthly Interest</th>
			<th>Monthly Repayment</th>
			<th>Loan Balance</th>
		</thead>
		<tbody>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>
		</tbody>	
		</table>		

	</div>

	</div>
	
	<div class="pure-u-1"></div>
<?php Html::endForm(); ?>

