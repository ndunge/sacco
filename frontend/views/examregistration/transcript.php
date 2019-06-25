<?php

use common\models\Examregistration;
use common\models\Finalexam;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use frontend\assets\DatatablesAsset;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Examregistration */
/* @var $listAcademicYear common\models\Examregistration */
/* @var $listSemester common\models\Examregistration */

DatatablesAsset::register($this);
//print_r($model);exit;
$this->title = 'Transcript: '. $CustomerID;
  
$this->params['breadcrumbs'][] = $this->title;
$csrfToken = Yii::$app->request->getCsrfToken();
$urlActionResult = Url::to(['/examregistration/result']);



$jsRenderResult = <<<JS

    $('#session-dropdown').change(function () {
        $.ajax({
            url: '$urlActionResult',
            type: 'post',
            data: {
                academicYear: $("#academic-dropdown").val(),
                semester: $("#session-dropdown").val(),
                _csrf: '$csrfToken'
            },
           beforeSend: function () {
               $('#transcript-grid').empty();
               $('#render-image').show(
                   "<img src='images/ajax-loader.gif' align='center'  style='height: 100px;width: 100px;'/> loading..."
               );
           },
            complete: function (data) {
                $('#render-image').hide();
                console.log(data.responseText)
            },
            success: function (data) {
                $('#transcript-grid').append(data);
                
            }
        });
    });
JS;

$this->registerJs($jsRenderResult, View::POS_READY);
?>
<script type="text/javascript">
    $(document).ready(function() {
     $('#DataTables_Table_1').DataTable( {
            dom: 'Bfrtip',
            paging:false,
            bFilter: false,
            bSort: false,
            bSearchable:false,
            bInfo:false,
            buttons: [
                {
                    extend: 'csv',
                    text: 'Save CSV',
                    
                },
                {
                    extend: 'excel',
                    text: 'Save Excel',
                    orientation: 'landscape',
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 9; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Save PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    },
                    header: true,
                    orientation: 'landscape',
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 9; //<-- set fontsize to 16 instead of 10
                    }
                },
                {
                    extend: 'print',
                    text: 'Print License',
                    orientation: 'landscape',
                },
                'copy',
            ],
            "oLanguage": {
                "sEmptyTable": "No Clearances are required for your selection."

            },
        } );

} );
</script>
<?php $form = ActiveForm::begin(['id' => 'transcript-form']); 


?>
<!--<h4>Please select an Academic Year followed by Semester</h4>-->

 </b></tr><br><br> 

<?php 

	$sql="select AcademicYr, UnitCode,UnitDesc,MeanScore,MeanGrade  from [CUEA\$Final Exam Results] where StudentID='$CustomerID' ORDER BY [AcademicYr],[UnitCode] asc";
	$Results = Finalexam::findBySql($sql)->asArray()->all();
//print_r($Results);exit;
	$grouped_results = array();
	/*
	[AcademicYr] => 1999/2000
	[UnitCode] => CAC 110
	[UnitDesc] => Fundamentals of Accounting II
	[MeanScore] => 70
	[MeanGrade] => A
	*/
	foreach($Results as $key => $res) {
		$_year = $res['AcademicYr'];
		$grouped_results[$_year][] = $res;
	}
	//print_r($grouped_results); exit;
	
	//print_r($CustomerID );exit;
?>

<?php foreach($grouped_results as $academicYear => $yearResults): ?>
	<div style="border: 1px solid #bdbdbd; width: 100%; margin: 1rem">
		<h3 style="border-bottom: 1px solid #bdbdbd; padding: .5rem" > Results for Academic Year <?= $academicYear; ?> </h3>
		<table style="width: 100%" class="table bordered">
			<thead>
				<th> <b>Unit Code</b> </th>
				<th> <b>Unit Description</b> </th>
				<th> <b>Score</b> </th>
				<th> <b>Grade</b> </th>
			</thead>
			<tbody>
				<?php foreach($yearResults as $index => $results): ?>
				<tr>
					<td> <b> <?php echo $results['UnitCode'];  ?> </b> </td>
					<td> <b> <?php echo $results['UnitDesc'];  ?> </b> </td>
					<td> <b> <?php echo $results['MeanScore'];  ?> </b> </td>
					<td> <b> <?php echo $results['MeanGrade'];  ?> </b> </td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
<?php endforeach ?>



<table width="100%" border="0" cellspacing="0" cellpadding="3" >
<?php 
 //$CustomerID = '1000003';
 
 
 //$CustomerID=$model['StudentID'];
//print_r($CustomerID);exit; ?>





    <tbody>
	
	
	


    
	<?php 
	
	$CustomerID = Yii::$app->user->identity->CustomerID;
	$sql="select AcademicYr, UnitCode,UnitDesc,MeanScore,MeanGrade  from [CUEA\$Final Exam Results] where StudentID='$CustomerID'  ";
          $Results = Finalexam::findBySql($sql)->asArray()->all();
		  
		$grouped_results = array();
		/*
		[AcademicYr] => 1999/2000
            [UnitCode] => CAC 110
            [UnitDesc] => Fundamentals of Accounting II
            [MeanScore] => 70
            [MeanGrade] => A
			*/
		?>
<?php		
		foreach($Results as $key => $res) {
			$_year = $res['AcademicYr'];
			$grouped_results[$_year] = $res;
		}
		 //print_r($grouped_results);exit;
		 
		 
		 //print_r($Results);exit;
		  
		?> 
		 
		
	
    <p> CWA is  </p>    
  
	
    </tbody>
</table>
<?php ActiveForm::end(); ?>
<hr style="margin-top: 0;">
<section id="transcript-grid" >
    <div id="render-image">

    </div>
</section>


