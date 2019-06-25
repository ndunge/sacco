<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\Dimensionvalue;
use common\models\Additionalservices;
use common\models\Academicyear;
use common\models\Country;
use common\models\Postcode;
use common\models\Religions;
use common\models\Stream;
use common\models\Courses;
use common\models\Studentunits;
use common\models\ProgrammeCourse;
use common\models\Feestructure;

/* @var $this yii\web\View */
/* @var $model frontend\models\Courseregistration */

$this->title = $model['Reg_ Transacton ID'];
$this->params['breadcrumbs'][] = $this->title;
/*
$program = $DetailsArray['Programme'];
$ModeCode = $DetailsArray['ModeCode'];
$Semester = $DetailsArray['SemesterCode'];
$StageCode = $DetailsArray['StageCode'];
$fee_struct = Feestructure::find()
	->where("[Programme Code] = '$program'")
	->andWhere("[Mode of Study] = '$ModeCode'")
	//->andWhere("[Semester] = '$Semester'")
	->andWhere("[Stage Code] = '$StageCode'")
	->asArray()->all();
//print_r($fee_struct); exit;
*/
//print_r($model);exit;
?>
<?= Html::a('Close', ['index'], ['class' => 'button warning']) ?>

<style>
	thead > tr > th {
		text-align: left;
		padding: .5rem;
	}
	td {
		padding: .5rem;
	}
</style>
<div style="border: 1px solid #d5d5d5">
<table style="width: 100%">
	
	<tbody>
		<?php /* foreach($fee_struct as $entry_key => $entry_info): ?>
			<tr>
				
				<td> <?= $entry_info['Description'] ?> </td>
				<td> <?= number_format($entry_info['Amount'], 2) ?> </td>
			</tr>
		<?php endforeach */?>
	</tbody>
</table>

</div>

<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-2">
		<h5 style="font-weight:bold">Programme : <?= $DetailsArray['programme']; ?></h5>
		<h5 style="font-weight:bold">Academic Year : <?= $DetailsArray['Academicyear']; ?></h5>
		<h5 style="font-weight:bold">Balance : <?= number_format($DetailsArray2['Balance'],2); ?></h5>
	</div>
	<div class="pure-u-1 pure-u-md-1-2">
		<h5 style="font-weight:bold">Semester : <?= $DetailsArray['Semester']; ?></h5>
		<h5 style="font-weight:bold">Stage : <?= $DetailsArray['Stage']; ?></h5>
	</div>		
</div>	
	<table class="table striped hovered" id="dataTables-1">
	<thead>
		<tr>
			<th class="text-left" width="20%">Code</th>
			<th class="text-left">Description</th>
			<th class="text-right" width="20%"><div style="text-align:right">Unit Fee</div></th>
		</tr>		
	</thead>
	<tbody>	
		<?php
		//print_r($DetailsArray);
		//print_r($model['Reg_ Transacton ID']);exit;
		//print_r($Studentunits);exit;
		
		$TotalAmount = 0;
		foreach ($Studentunits AS $key => $row)
		{
			$s_id = $row["Unit"];
			$TotalAmount += $row["Amount"];
			//print_r($Studentunits);exit;
			
			?>
			<tr>		
				<td><?= $row["Unit"] ?></td>
				<td><?= $row["Description"] ?></td>				
				<td><div style="text-align:right"><?= number_format($row["Amount"],2) ?></div></td>	
			    
			</tr>	
			<?php
			
		} 
		if (empty($Studentunits))
		{
			?>
			<tr>
			<td colspan="3"> No Data to Display</td>
			</tr>
			<?php
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="text-left" colspan="2">Total</th>
			
		</tr>
		<tr>
		
		</tr>
	</tfoot>		
	</table>
	
	<div class="pure-u-1">
	</div>
	<div class="place-left">
	<?= ( count($Studentunits) > 0 ) ? Html::a('Drop Unit',
		[ 'dropunit','id'=>$model['Reg_ Transacton ID'], 
			'unit' => count($Studentunits) > 0 ? $Studentunits[0]['Unit'] : '' ], 
		['class' => 'button danger', 'onclick' => 'return show_alert();'] ) : '' ?>
	</div>
	<div class="place-right">
	
	<?= Html::a('Close', ['index'], ['class' => 'button']) ?>
	</div>
	<div class="pure-u-1"></div>
	<script type="text/javascript">
        function show_alert() {
    var strconfirm = confirm("Are you sure you want to drop this unit?");
    if (strconfirm == true) {
        return true;
    }
	if (strconfirm == false) {
        return false;
    }
}
</script>