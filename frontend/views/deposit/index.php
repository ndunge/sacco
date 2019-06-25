<?php

use yii\helpers\Html;
use yii\grid\GridView;
$baseUrl = Yii::$app->request->baseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

 $this->title = 'Deposit Statement';
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
                            <li class="title">Title 1</li>
                            <li class="active"><a href="#"><span class="mif-home icon"></span>Dashboard</a></li>
                            <li class="stick bg-red"><a href="#"><span class="mif-cog icon"></span>Loans Hub</a></li>
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
                            <li class=""><a href="#">Thread item</a></li>
                            <li class="disabled"><a href="#">Disabled item</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>


<div class="clearfix"></div>
<div class="center">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
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

            ['class' => 'yii\grid\ActionColumn'],
          
       
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
</section>
<div class="clearfix"></div>