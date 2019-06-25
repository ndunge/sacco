<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\Dimensionvalue;
use common\models\Academicyear;
use common\models\Country;
use common\models\Postcode;
use common\models\Religions;
use common\models\Stream;
use common\models\Courses;
use common\models\Examregistration;
use common\models\Lecturerunits;

?>

<?php

//print_r($model);exit;
//print_r($model[0]['ProgrammeCourseID']);exit;

//$this->title = $model[0]['Exam Type ID']. '-'.$model[0]['ProgrammeCourseID'];

//print_r($model);exit;

/* @var $this yii\web\View */
/* @var $model frontend\models\Courseregistration */

//$this->title = $model[0]['Exam Type ID']. '-'.$model[0]['ProgrammeCourseID'];
// $ProgrammeID = $model[0]['Programme ID'];
// $TermID =  $model[0]['Term ID'];
// $StageID = $model[0]['Stage ID'];
// $AcademicYear = $model[0]['Academic Year'];
// $ExamTypeID = $model[0]['Exam Type ID'];
// $ProgrammeCourseID = $model[0]['ProgrammeCourseID'];

// $url = "view?ProgrammeID=$ProgrammeID&TermID=$TermID&StageID=$StageID&AcademicYear=$AcademicYear&ExamTypeID=$ExamTypeID&ProgrammeCourseID=$ProgrammeCourseID";
//print_r($model);exit;
//$model = $model;

if ( count($model) > 0 ) {
	
	$this->title = $model[0]['Exam Type ID']. '-'.$model[0]['ProgrammeCourseID'];
	$ProgrammeID = $model[0]['Programme ID'];
	$TermID =  $model[0]['Term ID'];
	$StageID = $model[0]['Stage ID'];
	$AcademicYear = $model[0]['Academic Year'];
	$ExamTypeID = $model[0]['Exam Type ID'];
	$ProgrammeCourseID = $model[0]['ProgrammeCourseID'];
	
	//$model2= Dimensionvalue::find()->where['Code']=$ProgrammeID;
	$model2= Dimensionvalue::findbysql('SELECT * from [CUEA$Dimension Value] where Code = \''.$ProgrammeID.'\'')->one();
	//print_r($model2);exit;
    
	//print_r($model3);exit;
	//print_r($CampusCode);exit;
	//$url = "view?ProgrammeID=$ProgrammeID&TermID=$TermID&AcademicYear=$AcademicYear&ProgrammeCourseID=$ProgrammeCourseID&ExamTypeID=$ExamTypeID";
	$url = "view?ProgrammeID=$ProgrammeID&TermID=$TermID&StageID=$StageID&AcademicYear=$AcademicYear&ExamTypeID=$ExamTypeID&ProgrammeCourseID=$ProgrammeCourseID";
	$identity = Yii::$app->user->identity;
		//print_r($identity);exit;
		$ProfileID = $identity->ProfileID;
        $CustomerID = $identity->EmployeeID;
		//print_r($CustomerID);exit;
		//$model3=Lecturerunits::find()->where['Lecturer']=$CustomerID;
		$model3= Lecturerunits::findbysql('SELECT * from [CUEA$Lecturers Qualified Units] where Lecturer = \''.$CustomerID.'\'')->one();
		//print_r($model3);exit;
	//$url = "view?ProgrammeID=$ProgrammeID&ProgrammeCourseID=$ProgrammeCourseID";
	
	$exam_types = array();
	foreach ($model as $key => $value) {
		array_push($exam_types, $value['Exam Type ID']);		
	}	
	array_push($exam_types, 'Moderated Mark');		
	array_push($exam_types, 'External Examiner Comments');	
	$exam_types = array_unique($exam_types);
	//print_r($model);exit;
	$students_exams = [];
	foreach ($model as $key => $value) {
		
		$name = $value['Student Name'];
		$exam = $value['Exam Type ID'];
		$Submitted = $value['Submitted'];
		
		$students_exams[$name][$exam] = number_format($value['Actual Mark'], 2);
		$students_exams[$name]['Submitted'] = $Submitted;
		$students_exams[$name]['StudentID'] = $value['Student ID'];
		$students_exams[$name]['Moderated Mark'] = $value['InternalExaminer'];
		$students_exams[$name]['External Examiner Comments'] = $value['ExternalExaminer'];
		//print_r($model);exit;
		// $students_exams[$name]['']
	}
	//print_r($students_exams); exit;
	//$ProgrammeID = $model[0]['Programme ID'];
	//print_r($model);exit;
}
?>

<style>

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

</style>

<?php if ( count($model) > 0 ): ?>
<ul class="breadcrumbs no-padding-top no-padding-bottom no-padding-left">
		<li><a href="../"><span class="icon mif-home fg-kra-red"></span></a></li>
		<li><a href="../">Home</a></li>
		<li><?= $this->title; ?></li>
</ul>

<section>
<button id="create_pdf" class="button danger" onclick="return demoPDF();"> Download Marksheet </button>
</section>

<form id="data_form" method="POST" action="<?= $url ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="3" >
<input name="ProgrammeCourseID" type="hidden" value="<?= $model[0]['ProgrammeCourseID'] ?>" >   
<input name="AcademicYear" type="hidden" value="<?= $model[0]['Academic Year'] ?>" >   
<input name="ExamTypes" type="hidden" value="<?= implode(",", $exam_types) ?>" >   
<!-- <input name="StudentID" type="hidden" value="<?= $model[0]['Student ID'] ?>" >   -->
<tr>
		<td>
			<label><b>Programme Code</b></label>
			<div class="input-control text full-size">                  	
				<input name="ProgrammeID" 
				type="text" value="<?= $model[0]['Programme ID']  ?> " readonly >          
			</div>
		</td>
		<td>
			<label><b>Academic Year <span style="color:#F00">*</span></b></label>
			<div class="input-control text full-size">                   	
				<input name="AcademicYear" 
					type="text" value="<?= $model[0]['Academic Year'] ?>" readonly >          
			</div>
		</td>
</tr>
<tr>
<td>
			<label><b>Programme Description</b></label>
			<div class="input-control text full-size">                  	
				<input name="ProgrammeID" 
				type="text" value="<?= $model2->Name ?>" readonly >          
			</div>
		</td>
		
		<td>
			<label><b>Campus Code</b></label>
			<div class="input-control text full-size">                  	
				<input name="ProgrammeID" 
				type="text" value="<?= $model3['Campus Code'] ?>" readonly >          
			</div>
		</td>

</tr>


<!--<tr>
		<td>
			<label>Semester <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">                   	
				<input name="TermID" type="text" value="<?= $model[0]['Term ID'] ?>">          
			</div>
		</td>
		<td>
			<label>Stage</label>
			<div class="input-control text full-size">                   	
				<input name="StageID" type="text" value="<?= $model[0]['Stage ID'] ?>"           
			</div>
		</td>	
	</tr>-->
			
</table>		


<table   class="table striped hovered">
	<thead style="background: #d5d5d5">
		<tr >
			<td style="width: 5% ">Student  No</td>
			<td style="width: 30% ">Student Name</td>
			<?php foreach ($exam_types as $key => $value): ?>
				<td style="width: <?= ($exam_types == 'CAT' || $exam_types == 'FINAL EXAM') ? '5%' : '15%' ?> "> <?= $value ?></td>	
			<?php endforeach ?>
			<td style="width: 5% ">Total</td>
			<td style="width: 5% ">Grade</td>
			
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		<?php foreach ($students_exams as $key => $value): ?>
			<?php $total = 0; ?>
			<?php $i += 1; ?>
			<tr> 
				<td>
					<input type="text" 
						name="<?= 'StudentID_' . '_' . $i ?>"
						value="<?= $value['StudentID'] ?>" > 
						
				</td>
				<td>
					<?= $key ?>
				</td>
				<?php foreach ($exam_types as $key => $exam): ?>
					<?php $total += isset($value[$exam]) ? $value[$exam] : 0; ?>
					<!-- <div class="text full-size" >  -->
					<?= $mode = $value['Submitted'] == 1 ? 'readonly' : '' ?>
					<td>
						<?php if($exam == 'Moderated Mark' || $exam == 'External Examiner Comments'): ?>
						 
							<textarea 
								id="<?= $value['StudentID'] ?>"
								name="<?= $exam . '_' . $i ?>"
								type="text" 
								class="text full-size combat"   
								rows="2"
								 > 
								 <?= trim($value[$exam]) ?>
								 </textarea>
								 
						<?php else: ?>
						
							<input 
								name="<?= $exam . '_' . $i ?>"
								type="text" 
								onchange="calculate(this)"
								data-student="<?= $value['StudentID'] ?>"
								class="text full-size combat mark"    
								value="<?=  isset($value[$exam]) ? $value[$exam] : '' ?>"  
								<?= $mode ?>
								
								
						<?php endif; ?>
					</td>
					
				

					<!-- <td>
						<input type="text" class="text full-size combat" value="30">
					</td> --> 
					<!-- </div>	 -->
				<?php endforeach ?>
				
				<td    >
					<input type="text" disabled value="<?= $total  ?>" 
						class="<?= $value['StudentID'] ?>" >
				</td>
				<!--
				<td class="total-grade"></td> -->
			</tr>			
		<?php endforeach ?>
	</tbody>
</table>
<?php
// $submitted = true;
// // print_r($model); exit;
// foreach ($model as $key => $value) {
// 	if($value['Submitted'] == 0) {
// 		$submitted = false;
// 	}
// }
?>
<?=  Html::submitButton('Save', ['class' => 'button primary']) ?>

</form>
<div class="pure-u-1"></div>

<section style="display: none;">

	<table id="report-sheet"  class="table striped hovered">
		<thead style="background: #d5d5d5">
			<tr >
				<td style="width: 5% ">Student  No</td>
				<td style="width: 30% ">Student Name</td>
				<?php foreach ($exam_types as $key => $value): ?>
					<td style="width: <?= ($exam_types == 'CAT' || $exam_types == 'FINAL EXAM') ? '5%' : '15%' ?> "> <?= $value ?></td>	
				<?php endforeach ?>
				<td style="width: 5% ">Total</td>
				
			</tr>
		</thead>
		<tbody>
			<?php $i = 0; ?>
			<?php foreach ($students_exams as $key => $value): ?>
				<?php $total = 0; ?>
				<?php $i += 1; ?>
				<tr> 
					<td class="combat">
						<?= $value['StudentID'] ?>
							
					</td>
					<td>
						<?= $key ?>
					</td>
					<?php foreach ($exam_types as $key => $exam): ?>
						<?php $total += isset($value[$exam]) ? $value[$exam] : 0; ?>
						<!-- <div class="text full-size" >  -->
						<?= $mode = $value['Submitted'] == 1 ? 'readonly' : '' ?>
						<td class="">
							<?php if($exam == 'Moderated Mark' || $exam == 'External Examiner Comments'): ?>
							 
								<?= trim($value[$exam]) ?>
									 
							<?php else: ?>
							
								<?=  isset($value[$exam]) ? $value[$exam] : '' ?>
									
							<?php endif; ?>
						</td>
						
					

						<!-- <td>
							<input type="text" class="text full-size combat" value="30">
						</td> --> 
						<!-- </div>	 -->
					<?php endforeach ?>
					
					<td class="total-combat"  >
						<?= $total  ?>
					</td>
					<!--
					<td class="total-grade"></td> -->
				</tr>			
			<?php endforeach ?>
		</tbody>
	</table>

</section>


<div class="pure-u-1"></div>
<?php else: ?>
<p> there is no student who has registered for this course unit </p>
<?php endif ?>





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