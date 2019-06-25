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
    margin-top: -520px;
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
                            <li class="stick bg-green"><a href="<?= $baseUrl; ?>/customerelationship/"><span class="mif-contacts-mail icon"></span>Customer Relations</a></li>

                            <li class="title">Reports</li>
                            <li><a href="#">Member Statement</a></li>
                            <li><a href="#">Accounts Statement</a></li>
                            <li><a href="#">Loans Register</a></li>
                           
                         
                        </ul>

<div class="clearfix"></div>
<div class="center">

    <table border=0>
  <tr><th>Loan Statements</th></tr>
  <section>
<button id="create_pdf" class="button primary" onclick="return demoPDF();"> Download Statement </button>
</section>
</table>




<?= GridView::widget([
        'dataProvider' => $summary,
       
       

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],
             

            
          'Product Code',
            'Posting Date',
                    [
                'label' => 'Posting Type',
                'format' => 'raw',                
                'value' => function ($dataProvider)     {
                    // print_r();
                   
                    return ($dataProvider['Posting Type'] == 1 ? 'Loan Debit' : 'Loan Credit');
                 },
            ],
           'Document No_',         
               [
                'header' => '<div style="text-align: right">Debit Amount</div>',
                'attribute' => 'Debit Amount',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],
            
              [
                'header' => '<div style="text-align: right">Credit Amount</div>',
                'attribute' => 'Credit Amount',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],
            
             
                [
                'header' => '<div style="text-align: right">Balance</div>',
                'attribute' => 'Balance',
                'format' => ['decimal', 2],
                'contentOptions' => ['style' => 'text-align: right; width:10%']
            ],
              
            // 'Appointment_Date',
            // 'Creation_date',
            // 'Subject
            // 'Comments',
            // 'Appointment_Time',

            // ['class' => 'yii\grid\ActionColumn'],
        
       
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
    <?php 
          foreach ($model as $key => $value) {

    
   
    
   
    //print_r($model);exit;
    // $students_exams[$name]['']
  }

      ?>

    <table id="report-sheet"  class="table striped hovered">
    <thead style="background: #d5d5d5;" >
      <tr >
        <td style="width: 5% ">Loan  Number</td>
        
        

        <td style="width: 30% ">Posting Date</td>
        <td style="width: 30% ">Posting Type</td>
        <td style="width: 30% ">Document No</td>
        <td style="width: 30% ">Debit Amount</td>
        <td style="width: 30% ">Credit Amount</td>
        <td style="width: 30% "> Amount</td>
        
        <td style="width: 5% ">Balance</td>
        
      </tr>
    </thead>
  <tbody>
    <?php $i = 0; ?>
      <?php $total = 0; ?>
      <?php $i += 1; ?>
      <? foreach($i as $key =>$value) ?>
      <tr> 
        <td>
          <input type="text" 
            name="<?= 'LoanNumber_' . '_' . $i ?>"
            value="<?= $value['LoanNumber']; ?>"> 
            
        </td>
       <td>
          <input type="text" 
            name="<?= 'LoanNumber_' . '_' . $i ?>"
            value="<?= $value['LoanNumber']; ?>"> 
            
        </td>
        <td>
          <?= $key ?>
        </td>
          <td>
          <?= $key ?>
        </td>

        
          
          <!-- <div class="text full-size" >  -->
         
          <td>
           
             
             
                 
            
            
            <td>
              
            </td>
                
                
          
          </td>
          <td>
            <? $value['PostingDate'];  ?>
          </td>
           <td>
            <? $value['DocumentNo_'];  ?>
          </td>
        

          <!-- <td>
            <input type="text" class="text full-size combat" value="30">
          </td> --> 
          <!-- </div>  -->
        <? endforeach; ?>
         <td>
            <? $value['DocumentNo_'];  ?>
          </td>
        <? endforeach; ?>
         <td>
            <? $value['PostingDate'];  ?>
          </td>

        <? endforeach ?>
        <? endforeach ?>
        <? endforeach ?>
        
        
        <!--
        <td class="total-grade"></td> -->
      </tr>     
    <? endforeach ?>
  </tbody>
  </table>

    <script type="text/javascript">

function calculate(input) {
  var mark = $(input).val()
  var exam = $(input).attr('name')
  var index = exam.split("_")[1];
  var studentid = $(input).data().student
  
  var other = (exam.split("_")[0] == 'CAT' ? 'FINAL EXAM' : 'CAT') + '_' + index
  var other_sel = "input.mark[name='" + other + "'] "
  
  var sum_sel = "input." + studentid + " "  
  //var mod_sel = "textarea#" + studentid + " " 
  var sum = parseFloat(mark) + parseFloat($(other_sel).val());
  
  $(sum_sel).val(sum);
  //$(mod_sel).val(sum);
  console.log(index, exam, other, studentid, mark, other_sel, sum, $(sum_sel).first()  )
}

/* 
$(document).ready(function(){
    $("input").each(function() {
        var that = this; // fix a reference to the <input> element selected
        $(this).keyup(function(){
            newSum.call(that);// pass in a context for newsum():
                               // call() redefines what "this" means
                               // so newSum() sees 'this' as the <input> element
        });
    });
});
  function newSum() {
    /* $('tr').each(function () {
      //the value of sum needs to be reset for each row, so it has to be set inside the row loop
      var sum = 0
      var thisRow = $(this).closest('tr');

      //console.log(thisRow)
      //find the combat elements in the current row and sum it 
      thisRow.find('td:not(.combat) input:text').each( function(){
        sum += parseFloat(this.value); // or parseInt(this.value,10) if appropriate
        //console.log('this.value', this.value)
      });
      
      thisRow.find('input.mark ').each( function(){
        sum += parseFloat(this.value); // or parseInt(this.value,10) if appropriate
        console.log('this.value', this.value)
      });

      //set the value of currents rows sum to the total-combat element in the current row
      $('.total-combat', this).html(sum);
    }); 
    $('input.mark ').each( function(){
      //sum += parseFloat(this.value); // or parseInt(this.value,10) if appropriate
      console.log('this.value', $(this).val())
    });
  // thisRow.find('td.total').val(sum); // It is an <input>, right?
} */

</script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"> </script> 
<script src="//rawgit.com/someatoms/jsPDF-AutoTable/master/dist/jspdf.plugin.autotable.js"> </script> 
<script src="//cdnjs.cloudflare.com/ajax/libs/jcanvas/16.7.3/jcanvas.min.js"> </script>  
<script type="text/javascript" src="//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js"></script>

   <script> 

  function demoPDF() {
    var pdfsize = 'a0';
    var pdf = new jsPDF('l', 'pt', pdfsize);

    var res = pdf.autoTableHtmlToJson(document.getElementById("report-sheet"));
    pdf.autoTable(res.columns, res.data, {
    startY: 25,
    styles: {
      overflow: 'linebreak',
      fontSize: 30,
      //rowHeight: 60,
      columnWidth: 'wrap'
    },
    columnStyles: {
      1: {columnWidth: 'auto'}
    }
    });

    pdf.save(new Date() + ".pdf");
  };

  //demoPDF();
</script>

</div>
<div class="pure-u-1"></div>
