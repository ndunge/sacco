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

/* @var $this yii\web\View */
/* @var $model frontend\models\Courseregistration */

$this->title = $model['Reg_ Transacton ID'];
$this->params['breadcrumbs'][] = $this->title;

$msg = '';
if (isset($code))
{
	if (($code==1) or ($code==2))
	{
		$msg = "You do not have sufficient Funds to register for the semester";
	} elseif ($code == 3)
	{
		$msg = "The system is unable to complete your request.  Please contact the sytem administrator";
	}
}
?>
<div style="color:red"><?= $msg; ?></div>
<div class="pure-u-1"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td>
			<label>Programme <span style="color:#F00">*</span></label>
			<div class="input-control text full-size">  
				<input disabled type="text" value="<?= $ProgrammeName; ?>" >
			</div>
		</td>
		<td>
			<label>Accademic Year <span style="color:#F00">*</span></label>
			<div data-role="select"> 
				<select disabled name="Academic Year"  id="Academic Year" class="input-control full-size" disabled>
					<option value="0" selected="selected"></option>
					<?php 
					$result = Academicyear::find()->asArray()->orderBy('Description')->all();                    
					foreach ($result AS $key => $row)
					{
						$s_id = $row["Code"];
						$s_name = $row["Description"];
						if ($model['Academic Year']==$s_id) 
						{
							$selected = 'selected="selected"';
						} else
						{
							$selected = '';
						}												
						?>
						<option value="<?php echo $s_id; ?>" <?php echo $selected; ?>><?php echo $s_name; ?></option>
						<?php 
					}  ?>                        
				</select>
			</div>
		</td>	
	</tr>
		<tr>
			<td>
				<label>Semester <span style="color:#F00">*</span></label>
				<div class="input-control text full-size">                   	
					<input disabled type="text" value="<?= $SemesterName; ?>" >          
				</div>
			</td>
			<td>
				<label>Stage</label>
				<div class="input-control text full-size">                   	
					<input disabled type="text" value="<?= $StageName; ?>" >          
				</div>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<label>Mode of Study</label>
				<div class="input-control text full-size">                   	
					<input disabled type="text" value="<?= $ModeName; ?>" >          
				</div>
			</td>
			
			<td width="50%"></td>
		</tr>						
	</table>
	<div class="pure-g">
		<div class="pure-u-1 pure-u-md-1-2">
			<h5 style="font-weight:bold">Your will be charged the Following Fees</h5>
			<table width="100%" border="0" cellspacing="0" cellpadding="3" class="table striped hovered">
			<thead>
				<tr>
					<th class="text-left">Description</th>
					<th class="text-right" width="20%">Amount</th>
				</tr>
			</thead>
			<tbody>	
				<?php
				$TotalAmount = 0;
				foreach ($Fees AS $key => $row)
				{
					$Description = $row["Description"];
					$Amount = $row["Amount"];
					$TotalAmount += $Amount;
					?>
					<tr>		
						<td><?= $Description; ?></td>
						<td><div style="text-align:right"><?= number_format($Amount,2); ?></div></td>	
					</tr>	
				<?php
				} ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="text-left">Total</th>
					<th class="text-right"><div style="text-align:right"><?= number_format($TotalAmount,2); ?></div></th>
				</tr>
			</tfoot>			
			</table>
			<div class="pure-u-1"></div>
			<h5 style="font-weight:bold">Your account balance is <?= number_format($balance,2); ?></h5>
		</div>
	</div>
	<div class="pure-u-1"></div>
	<?= ($model->Status == 0) ? Html::a('Complete Registration', ['submit', 'id' => $id], ['class' => 'button primary']) : '' ?>
	<?= Html::a('Close', ['index'], ['class' => 'button']) ?>
<div class="pure-u-1"></div>