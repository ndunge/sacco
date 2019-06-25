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
use common\models\Academicyearsessions;

/* @var $this yii\web\View */
/* @var $model frontend\models\Courseregistration */

$this->title = $model['Student No_'];
$this->params['breadcrumbs'][] = $this->title;

$program = $DetailsArray['ProgrammeCode'];
$ModeCode = $DetailsArray['ModeCode'];
$Semester = $DetailsArray['SemesterCode'];
$StageCode = $DetailsArray['StageCode'];
//$CampusCode = $DetailsArray['CampusCode'];
$fee_struct = Feestructure::find()
	->where("[Programme Code] = '$program'")
	->andWhere("[Mode of Study] = '$ModeCode'")
	->andWhere("[Semester] = '$Semester'")
	->andWhere("[Stage Code] = '$StageCode'")
	//->andWhere("[Campus] = '$CampusCode'")
	->asArray()->all();

	//print_r($fee_struct);exit;
	
//$AdminFeeAmnt
//print_r($fee_struct); exit;
?>
<!--<?//= Html::a('Close', ['index'], ['class' => 'button warning']) ?>-->

<style>
	thead > tr > th {
		text-align: left;
		padding: .5rem;`
	}
	td {
		padding: .5rem;
	}
</style>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-2">
		<h5 style="font-weight:bold">Programme : <?= $DetailsArray['programme']; ?></h5>
		<h5 style="font-weight:bold">Academic Year : <?= $DetailsArray['Academicyear']; ?></h5>
		
		<h5 style="font-weight:bold">Opening Balance : <?= number_format($DetailsArray2['Balance'],2); ?></h5>
	</div>
	<div class="pure-u-1 pure-u-md-1-2">
		<h5 style="font-weight:bold">Semester : <?= $DetailsArray['Semester']; ?></h5>
		<h5 style="font-weight:bold">Stage : <?= $DetailsArray['StageCode']; ?></h5>
	</div>		
</div>	
<div style="border: 1px solid #d5d5d5">
<table style="width: 100%">
	<thead>
		<tr>
			
			<th class="text-left" width="20%">Description </th>
			<th class="text-right" width="20%"><div style="text-align:right">Amount</div></th>
			<th class="text-right" width="5%"><div style="text-align:right"></div></th>
		</tr>
	</thead>
	<tbody>
	<?
	
	?>
		<?php $SubtotalAmount = 0; 
		foreach($fee_struct as $entry_key => $entry_info): ?>
			<tr>
				
				<td> <?= $entry_info['Description'] ?> </td>
                <td><div style="text-align:right"><?= number_format($entry_info['Amount'], 2) ?></div></td>
				
				<?php $SubtotalAmount += $entry_info["Amount"];
				
				//print_r($SubtotalAmount);exit;
				?>
				
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<td ><b>Administration Fee Total</b></td>
			 		
			<td><div style="text-align:right"><b><?= number_format($SubtotalAmount,2); ?></b></div></td>	
			 
		</tr>
	</tfoot>
</table>

</div>


	<table class="table striped hovered" id="dataTables-1">
	<thead>
		<tr>
			<th class="text-left" width="20%">Code</th>
			<th class="text-left">Description</th>
			<th class="text-right" width="20%"><div style="text-align:right">Unit Fee</div></th>
		    <th class="text-right" width="5%"><div style="text-align:right">Billed</div></th>
		</tr>		
	</thead>
	<tbody>	
		<?php
		//print_r($DetailsArray);
		//print_r($model);exit;
		//print_r($Studentunits);exit;
		$SessionCode=$model['Session Code'];
		
		$sql="select [Registration Start Date], [Registration End Date],
(CASE
        WHEN GETDATE() between [Registration Start Date] and [Registration End Date] THEN 1
        ELSE 0
        END) AS Active 
from [CUEA\$Academic Year Sessions] where [Session Code]='$SessionCode'";
       $result3= Academicyearsessions::findBySql($sql)->asArray()->one();
	   $displayButton2=$result3['Active'];
	   //print_r($result3);exit;
		
		$TotalAmount = 0;
		foreach ($Studentunits AS $key => $row)
		{
			$s_id = $row["Unit"];
			$TotalAmount += $row["Amount"];
			
			?>
			<tr>		
				<td><?= $row["Unit"] ?></td>
				<td><?= $row["Description"] ?></td>				
				<td><div style="text-align:right"><?= number_format($row["Amount"],2) ?></div></td>	
			    <!--<td><a href="/courseregistration/unitdetails?id=<?= $model['Reg_ Transacton ID']; ?>&unit=<?= $row["Unit"]; ?>">View</a></td>-->
			    <td><div style="text-align:right"><?= $row["Status"]==1?'':'Billed' ?></div></td>
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
		<?php
		
		$one=number_format($DetailsArray2['Balance'],2);
		$numone =str_replace(',', '', $one);
		$two=number_format($SubtotalAmount,2);
		$numtwo= str_replace(',', '', $two);
		$three=number_format($TotalAmount,2);
		$numthree = str_replace(',', '', $three);
		
		$netbalance=$numone-($numtwo+$numthree);
		//print_r($netbalance);exit;
		
		?>
	<tfoot>
	
	    <tr>
			<th class="text-left" colspan="2">Unit Fee Total</th>
			<th class="text-right"><div style="text-align:right"><?= number_format($TotalAmount,2); ?></div></th>
		</tr>
		
		<tr>
			<th class="text-left" colspan="2">Net Balance </th>
			<th class="text-right"><div style="text-align:right"><?= number_format($netbalance,2); ?></div></th>
		</tr>
	</tfoot>

    	
	</table>
	
	
	
	<div class="place-left">
	
	<p>
        <?php  echo Html::a('Add Units',['units','id'=>$model['Reg_ Transacton ID']], ['class' => 'button primary']); ?>
    </p>
	</div>
	<div class="pure-u-1"></div>
	
	
	<?=($TotalAmount<= $DetailsArray2['Balance'] && $model['BillingStatus']==0 ) ? ( Html::a('Submit and Bill', ['submitunits?id='.$model['Reg_ Transacton ID']], ['class' => 'button success']) ) : '' ?>
	</div>
	
	<div class="place-right">
	
	<?= Html::a('Close', ['index'], ['class' => 'button danger']) ?>
	</div>
	<div class="pure-u-1"></div>
	<div class="pure-u-1"></div>