<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Loanapplications;
use common\models\Credittype;
use common\models\Title;



$baseUrl = Yii::$app->request->baseUrl;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}
$ProfileID = $identity->ProfileID;
$customerid=$identity->Userid;


/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
if (!isset($msg)) { $msg = '';}
//$url = $model->isNewRecord ? 'create' : 'update?id='.$model['AssignmentID'];
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
                            <li class="stick bg-green"><a href="#"><span class="mif-share icon"
                             ></span>Loans Management</a></li>
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>


<div class="clearfix"></div>
<div class="center">
<h4>Raise a Case</h4>
<div id="msg" style="color:#F00"><?php echo $msg; ?></div>



<?= Html::beginForm(['customerelationship/create']) ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2">

		<input type="hidden" name="CustomerID" value="<?php echo $customerid ;?>" />
		<tr>
			<td>
				<label>Category <span style="color:#F00">*</span></label>
				<div data-role="select">
					<select name="CategoryID"  id="Category" class="input-control full-size" >
						<option value="0" selected="selected" >Select </option>
						<option value="1" > Complaint </option>
						<option value="2" > Request </option>
						<option value="3" > Suggestion </option>
					</select>
				</div>
			</td>
		</tr>

		<tr>
			<td>
				<label>Title <span style="color:#F00">*</span></label>
					<div data-role="select"> 
				<select name="Title"  id="Title" class="input-control full-size">
					<option value="0" selected="selected"></option>
					<?php 
					$result = Title::find()->asArray()->orderBy('Name')->all();                    
					foreach ($result AS $key => $row)
					{
						$s_id = $row["Code"];
						$s_name = $row["Name"];
						if ($model->Title==$s_id) 
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
			
			<td width="50%">
            <label>Description <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Description" type="text"  id="Description"  >          
			</div>
		</td>

	<tr>

		<td width="50%">
            <label>Status <span style="color:#F00">*</span></label>    
			<div class="input-control text full-size">                   	
				<input name="Status" type="text" style="background-color: #D3D3D3; readonly="readonly" id="LeaveStatus" value="<?=  $model['Status']; ?>" >  
			

			</div>
		</td>
		</tr>

		<tr>
			<td>
				<?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Save', ['class' => $model->isNewRecord ? 'button primary' : 'button primary']) ?>
				<?= Html::a('Cancel', ['index'], ['class' => 'button']) ?>
	
			</td>
		</tr>
		
	</table>
	
</form>
</div>
<div class="pure-u-1"></div>
<?php Html::endForm(); ?>
