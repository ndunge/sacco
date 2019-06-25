<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $model common\models\Leaveapplication */

//$this->title = $model->Name;

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
    margin-top: -470px;
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
                            <li><a href="#">Loans Register</a></li>
                           
                         
                        </ul>

<div class="clearfix"></div>
<div class="center">

    <table border=0>
  <tr><th>Share Capital</th></tr>
</table>





       <?= GridView::widget([
        'dataProvider' => $dataProvider1,
        'layout' => "\n{items}\n<div class='row'><div class='text-xs-left col-md-6'></div><div class='text-xs-right col-md-6'>{pager}</div></div>",
        'columns' => [
           
            
            'Posting Date',
                  [
                'label' => 'Posting Type',
                'format' => 'raw',                
                'value' => function ($dataProvider)     {
                    // print_r();
                   
                    return ($dataProvider['Posting Type'] == 10 ? 'Share Capital' : 'Deposit');
                 },
            ],
            'Document No_',
            'Customer No_',

             [
                'header' => '<div style="text-align: right">Amount</div>',
                'attribute' => 'Amount',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],

            
            
            
            // 'Appointment_Date',
            // 'Creation_date',
            // 'Subject',
            // 'Comments',
            // 'Appointment_Time',

         
          
       
        ],


        'tableOptions' => [
            
            'class' => 'dataTable striped border hovered bordered',
            'data-role' => 'datatable',
            'data-searching' => 'false',
            'data-paging' => 'false',
            'data-ordering' => 'false',
            'data-info' => 'false'
        ],
    ]); ?>

</div>
