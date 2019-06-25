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

/* @var $this yii\web\View */
/* @var $model frontend\models\Courseregistration */

$this->title = $model['Reg_ Transacton ID'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Html::a('Close', ['index'], ['class' => 'button warning']) ?>
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
<form id="data_form" method="POST" action="units?id=<?= $model['Reg_ Transacton ID']; ?>">	
	<table width="100%" border="0" cellspacing="0" cellpadding="3" id="units-table" class="table striped hovered">
	<thead>
		<tr>
			<th class="text-left" width="5%"></th>
			<th class="text-left" width="20%">Code</th>
			<th class="text-left">Description</th>
			<th class="text-right" width="20%"><div style="text-align:right">Unit Fee</div></th>
		</tr>
		
	</thead>
	<tbody>	
		<?php
		//print_r($Selected);
		$TotalAmount = 0;
		foreach ($Units AS $key => $row)
		{
			$s_id = $row["CourseCode"];
			$Checked = '';
			$Checked = (isset($Selected[$s_id])) ? 'checked' : '';
			$Disabled = (isset($StatusArray[$s_id])) ? 'disabled' : '';
			$included = (array_key_exists($s_id, $Selected)) ? 'true' : 'false';
			if (isset($Selected[$s_id]))
			{
				$TotalAmount += $row["Amount"];
			}
			?>
			<tr>		
				<td>
					<input id="sunits[<?= $s_id; ?>]" class="units-selector" name="sunits[<?= $s_id; ?>]['include']" type="checkbox" <?= $Checked; ?> />
					<input id="sunits[<?= $s_id; ?>]" class="units-selector" name="sunits[<?= $s_id; ?>]['included']" type="hidden" value="<?= $included; ?>" />
					<input id="sunits[<?= $s_id; ?>]" class="units-selector" name="sunits[<?= $s_id; ?>]['amount']" type="hidden" value="<?= $row["Amount"]; ?>" <?= $Disabled; ?>/>
					<input id="sunits[<?= $s_id; ?>]" class="units-selector" name="sunits[<?= $s_id; ?>]['description']" type="hidden" value="<?= $row["Description"]; ?>" <?= $Checked; ?> <?= $Disabled; ?>/>
				</td>
				<td><?= $row["CourseCode"] ?></td>
				<td><?= $row["Description"] ?></td>					
				<td><div style="text-align:right"><?= number_format($row["Amount"],2) ?></div></td>	
			</tr>	
			<?php
		} 
		if (empty($Studentunits))
		{
			?>
			<tr>
			<td colspan="4"> No Data to Display</td>
			</tr>
			<?php
		} ?>
		</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th class="text-left" colspan="2">Total</th>
			<th class="text-right"><div style="text-align:right"><?= number_format($TotalAmount,2); ?></div></th>
		</tr>
	</tfoot>		
	</table>
			
	<div class="pure-u-1"></div>
	<?= Html::submitButton('Save', ['class' => 'button primary']) ?>
	<?= Html::a('Close', ['index'], ['class' => 'button']) ?>
	
	<div class="place-right">
	<!-- ($TotalAmount<= $balance) ? Html::a('Submit and Bill', ['submitunits','id'=>$id], ['class' => 'button success']) : '' -->
	</div>
	<div class="pure-u-1"></div>
</form>
<script type="text/javascript">
	function getunits(evt){
		$.post('getyearunits',{'year': evt,  'ProgrammeCode': <?=$ProgrammeCode;?>}, function(data){
			$('#units-table').html(data);
			console.log(data);
		});
	}
</script>