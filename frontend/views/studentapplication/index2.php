<?php

use yii\helpers\Html;
use yii\grid\GridView;



$baseUrl = Yii::$app->request->baseUrl;
//print_r($baseUrl);exit;
$identity = Yii::$app->user->identity;
if (empty($identity))
{
	Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
}

if (!isset($msg)) { $msg = '';}

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Member Details';
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
.container{
	width: 1500px;
}
.center{
	width: 1000px;
	align:center;
	float: left;
	margin-left: 280px;
	margin-top: -400px;
}
	
</style>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
<script>
	$(function() 
	{
		var dataSet = <?php echo $json; ?>;
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
                            
                            <li class="active"><a href="#"><span class="mif-home icon"></span>Dashboard</a></li>
                            <li class="stick bg-green">
                                <a class="dropdown-toggle" href="#"><span class="mif-tree icon"></span>Statistical Information</a>
                                <ul class="d-menu" data-role="dropdown">
                                    <li><a href="<?= $baseUrl; ?>/ledgerentry/"><span class="mif-vpn-lock icon"></span> Share Capital</a></li>
                                    <li><a href="<?= $baseUrl; ?>/deposit/">Deposit Statement</a></li>
                                    <li><a href="<?= $baseUrl; ?>/schoolfees/">School fees Savings</a></li>
                                    <li><a href="<?= $baseUrl; ?>/children/">Children</a></li>
                                    <li><a href="">Loan Balances</a></li>
                                    <li><a href="">Interest Balances</a></li>
                                    <li class="disabled"><a href="">Subitem 5</a></li>
                                </ul>
                            </li>

                             <li class="stick bg-red"><a href="<?= $baseUrl; ?>/loansposted/"><span class="mif-cog icon"></span>Loans Posted List</a></li>
                            <li class=""><a href="#">Loans Management</a></li>
                            <li class="disabled"><a href="#">Disabled item</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>


<div class="clearfix"></div>

            <div class="center">
            <table class="table striped hovered" id="dataTables-1">
                <thead>
                  <tr>
                   <!-- <th class="text-left"><a href="<?= $baseUrl;?>/studentapplication/create">New</a></th>-->
                    <th colspan="3" class="text-center" style="color:#F00"><?php echo $msg; ?></th>
                  </tr>
                <tr>
					<th class="text-left" width="10%">MemberNo.</th>
					<th class="text-left" >Names</th>
                    <th class="text-left" width="25%">Address</th>
					<th class="text-left" width="15%">Date of Join</th>
                </tr>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                <tr>
					<th colspan="4">&nbsp;</th>
                </tr>
                </tfoot>
            </table>
            </div>
            </section>
            </body>
            </html>
<div class="pure-u-1"></div>

