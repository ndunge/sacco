<?php

use yii\helpers\Html;
use yii\grid\GridView;
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Loan Applications';
// $this->params['breadcrumbs'][] = $this->title;
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
    <title>Kencom Sacco Portal</title>

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
    margin-top: -480px;
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
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>


<div class="clearfix"></div>
<div class="center">
<div class="loancalculator-index">
<?php //print_r($model); 

$loanNumber = $model['Loan Number'];
$Installment = $model['Installment'];
$PaymentDate = $model['Payment Date'];
$Principal = $model['Loan Balance'];
$LoanBalance = $model['Loan Balance'];
$LoanRepayment = $model['Loan Repayment'];
$LoanMonthlyRepayment = $model['Loan Monthly Repayment'];
$LoanInterestRepayment = $model['Loan Interest Repayment'];
$ResetDocNo_ = $model['Reset Doc No_'];
$ResetSchedule = $model['Reset Schedule'];





?>
    <h1><?= Html::encode($this->title) ?></h1>
   <table>
   <thead>
       <th>Payment Date</th>
       <th>Monthly Repayment</th>
       <th>Loan Interest Repayment</th>
       <th>Principal Amount</th>
       <th>Loan Balance</th>
   </thead>
   <tbody>
   <?php  ?>
    <?php for($i=0; $i<$Installment; $i++){
    
        $LoanInterestRepayment= $LoanBalance * 0.01;
        $Principal= $LoanMonthlyRepayment-$LoanInterestRepayment;
        $LoanBalance -=( $LoanMonthlyRepayment-$LoanInterestRepayment);?>
       <tr>
        <td><?= $PaymentDate?></td>  
        <td><?=number_format($LoanMonthlyRepayment,2)?></td>
        <td><?=number_format($LoanInterestRepayment,2)?></td>
        <td><?=number_format($Principal,2)?></td>
        <td><?=number_format($LoanBalance,2)?></td> 
       </tr>
      <?php 
              if ($LoanBalance<=$LoanMonthlyRepayment)

    {

  break;
 echo  $LoanBalance=0.00;

    }


       };?> 
   </tbody>
   </table> 
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'showOnEmpty' => false,
        'columns' => [
            

            
            
            'Payment Date',
                [
                'header' => '<div style="text-align: right">Monthly Repayment</div>',
                'attribute' => 'Loan Monthly Repayment',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],
               [
                'header' => '<div style="text-align: right">Loan Interest Repayment</div>',
                'attribute' => 'Loan Interest Repayment',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],

                [
                'header' => '<div style="text-align: right">Principal Amount</div>',
                'attribute' => 'Loan Repayment',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],
             
           
              
            
               [
                'header' => '<div style="text-align: right">Loan Balance</div>',
                'attribute' => 'Loan Balance',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],

         
              
            
            // 'Approved Amount',
            // 'Loan Status',
            // 'Issued Date',
            // 'Instalment',
            // 'Repayment',
            // 'Flat Rate Principal',
            // 'Flat Rate Interest',
            // 'Interest Rate',
            // 'No Series',
            // 'Interest Calculation Method',
            // 'Employee No',
            // 'Employee Name',
            // 'Payroll Group',
            // 'Description',
            // 'Opening Loan',
            // 'Interest',
            // 'Interest Imported',
            // 'principal imported',
            // 'Interest Rate Per',
            // 'Reference No',
            // 'Interest Deduction Code',
            // 'Deduction Code',
            // 'Debtors Code',
            // 'External Document No',
            // 'HELB No_',
            // 'University Name',
            // 'Stop Loan',
            // 'Select',
            // 'StopagePeriod',
            // 'Reason',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </section>
<div class="clearfix"></div>
</div>
