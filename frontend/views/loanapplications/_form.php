<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Loanapplications;
use common\models\Credittype;



$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
$ProfileID = $identity->ProfileID;

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
if (!isset($msg)) { $msg = '';}
$url = $model->isNewRecord ? 'create' : 'update?id='.$model['AssignmentID'];
//$serverroute = Yii::$app->params['serverroute'];

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
		//var dataSet = <?php// echo $json; ?>;
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
                                    <li><a href="<?= $baseUrl; ?>/loanguarantors">Loan Guarantors</a></li>
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
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/create"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Reports</li>
                            <li><a href="#">Member Statement</a></li>
                            <li><a href="#">Accounts Statement</a></li>
                            <li><a href="#">Loans Guarantors</a></li>
                           
                         
                        </ul>


<div class="clearfix"></div>
<div class="center">
<h4>New Loan Application</h4>
<div id="msg" style="color:#F00"><?php echo $msg; ?></div>
<?= Html::beginForm(['loanapplications/create']) ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<tr>
		   <td width="50%">
            <label>Loan No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="LoanNo" type="text"  id="LoanNo" value="LN<?= $nextLoanNo ?>" readonly>          
			</div>
		</td>

			<td width="50%">
            <label>Member No <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="No_"  type="text" id="No_"  value="<?= $customerDetails['No_'] ?>" readonly>          
			</div>
		</td>
		<tr>
			<td width="50%">
            <label>Name <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="No_"  type="text" id="No_"  value="<?= $customerDetails['Name'] ?>" readonly>          
			</div>
		</td>

				<td>
			<label>Loan Type<span style="color:#F00">*</span></label>
				<select name="Credit Code"  id="Credit Code" class="input-control full-size">
					<option value="0" selected="selected"></option>
					<?php 
					$result = Credittype::find()->asArray()->orderBy('Credit Name')->all();                    
					foreach ($result AS $key => $row)
					{
						$s_id = $row["Credit Code"];
						$s_name = $row["Credit Name"];
						if ($model['Credit Code']==$s_id) 
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
		</td>
			
		</tr>
		
	</tr>

		<td>
			<label>Loan Amount <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="Loanamount" type="text" id="Loanamount" placeholder="KSH" >          
			</div>
		</td>
		<td>
			<label>Repayment Period <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="Repaymentperiod" type="text" id="Repaymentperiod" placeholder="Months" >          
			</div>
		</td>	
	</tr>
	<tr>
			<td width="50%">
            <label>Loan Application Date <span style="color:#F00">*</span></label><br/>    
			<div class="input-control text" data-role="datepicker" data-preset="<?= date('Y-m-d') ?>" data-format="yyyy-mm-dd" style="width:200px">
				<input name="Application Date" type="text" id="ApplicationDate" style="background-color: #D3D3D3; >
				<button class="button"> </button>
			</div>
        </td>
	</tr>
	<tr>
		
		<td>
			<label>Basic Salary <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="Basicsalary" type="text" id="Basicsalary" placeholder="0" >          
			</div>
		</td>
		<td width="50%">
			<label>Allowances <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="Allowances" type="text" id="Allowances" placeholder="0" >          
			</div>
		</td>	
	</tr>	
	<tr>
		
       <td width="50%">
			<label>Deductions+PAYE <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="deductions" type="text" id="deductions" placeholder="0" >          
			</div>
		</td>

		 <td width="50%">
			<label>Net Salary <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="Net Salary" type="text" id="Net Salary" placeholder="0" >          
			</div>
		</td>

	</tr>
    
							
	</table>
	<!--<input name="AssignmentID" type="hidden" id="AssignmentID">-->
	<?= Html::submitButton($model->isNewRecord ? 'Apply Loan' : 'Save', ['class' => $model->isNewRecord ? 'button primary' : 'button primary']) ?>
	<?= Html::a('Cancel', ['index'], ['class' => 'button']) ?>
</form>
</div>
<div class="pure-u-1"></div>
<?php Html::endForm(); ?>