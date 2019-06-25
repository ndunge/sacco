<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Leaveapplication */


$baseUrl = Yii::$app->request->baseUrl;
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
<div class="pure-u-1"></div>
<div class="center">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model['No_']], ['class' => 'button primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model['No_']], [
            'class' => 'button danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Close', ['index'], ['class' => 'button warning']) ?>
    </p>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
     <tr>
        <td>
            <label>Application No</label>
            <div class="input-control text full-size">                      
                <input type="text" value="<?= $model['No_']; ?>" disabled>          
            </div>
        </td>

          <td>
            <label>Applicant Name</label>
            <div class="input-control text full-size">                      
                <input type="text" value="<?= $model['Name']; ?>" disabled>          
            </div>
        </td> 
         
    </tr>
      
   
  <tr>
    <td width="50%">
            <label>ID No. <span style="color:#F00">*</span></label>
            <div class="input-control text full-size">                      
                <input name="ID No" type="text" id="ID No" value="<?= $model['National ID']; ?>" disabled >          
            </div>
        </td>

         <td>
            <label>Telephone/Mobile No <span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="Phone No_" type="text" id="Phone No_" value="<?= $model['Phone No_']; ?>" disabled   >          
            </div>
        </td>
      
        
    </tr>
       <td>
            <label>MPESA Mobile No <span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="MPESA Mobile No" type="text" id="MPESA Mobile No" value="<?= $model['MPESA Mobile No']; ?>" disabled    >          
            </div>
        </td>

        <td>
            <label>Email <span style="color:#F00">*</span></label>
            
            <div class="input-control text full-size">                      
                <input name="E-Mail" type="text" id="E-Mail" value="<?= $model['E-Mail']; ?>" disabled>          
            </div>
        </td>

    <tr>
        <td>
            <label>Share Capital Contribution(Kshs) <span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="Share Capital Contribution" type="text" id="Share Capital Contribution" value="<?= $model['Share Capital Contribution']; ?>" disabled   >          
            </div>
        </td>
        
        <td>
            <label>Registration Fee Contribution <span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="Registration Fee Contribution" type="text" id="Registration Fee Contribution" value="<?= $model['Registration Fee Contribution']; ?>" disabled   >          
            </div>
        </td>
    </tr>

<tr>
        <td>
            <label>Bank Name<span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="Bank Code" type="text" id="Bank Code" value="<?= $model['Bank Code']; ?>" disabled   >          
            </div>
        </td>
        <td>
            <label> Bank Branch<span style="color:#F00">*</span></label>    
            <div class="input-control text full-size">                      
                <input name="Bank Branch Code" type="text" id="Bank Branch Code" value="<?= $model['Bank Branch Code']; ?>" disabled   >          
            </div>
        </td>
</tr>

   
  
    </table>

    

</div>
