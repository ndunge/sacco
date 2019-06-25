<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Employees;
use common\models\Dimensionvalue;
use common\models\User;
use common\models\Profiles;
use common\models\Units;
use common\models\ModeOfStudy;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Profiles */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
	select {
		display: none !important;
	}
	.select2-container  {
		display: block !important;
		width: 100% !important;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />

<div class="profiles-form">
<script  src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
  <script type="text/javascript">
      // $(document).ready(function(){
      //     $.get( "<?= Url::toRoute('employee') ?>", { empno: $('#No_').val() } )
      //         .done(function(data) {
      //             console.log('data', data !== null, data)
      //             if (data !== null) {
      //               $email=JSON.parse(data).email;
      //               $idno=JSON.parse(data).idno;
      //               $UserName=JSON.parse(data).UserName;
      //               $AccountTypeID=JSON.parse(data).AccountTypeID;
      //                $("#AccountTypeID").val($AccountTypeID);
      //               $("#Email").val($email);
      //               $("#IDNumber").val($idno);
      //               $("#UserName").val($UserName);
      //             }
      //
      //         }
      //     );
      // });

  </script>
  <ul class="breadcrumbs no-padding-top no-padding-bottom no-padding-left">
          <li><a href="../"><span class="icon mif-home fg-kra-red"></span></a></li>
          <li><a href="../">Home</a></li>
          <li><?= $this->title; ?></li>
  </ul>
  <?php if (Yii::$app->getSession()->hasFlash('msg')): ?>
    <div class="" style="padding: .2rem; border: 1px solid red; margin: 1rem auto; width: 60%; margin-top: 2rem; font-weight: bold">
      <p style="padding: 0; margin: 0"> <?= Yii::$app->getSession()->getFlash('msg') ?> </p>
    </div>
  <?php endif; ?>
  <div class="" style="margin: 0 auto; width: 50%;">
         <?= Html::beginForm(['profiles/create']) ?>
              <label>Lecturer Name <span style="color:#F00">*</span></label>
              <div data-role="select">
                  <?= Html::dropDownList('No_', $selection=$model['CustomerID'], $employees ,
                 [
                      'class' => 'input-control full-size',
                      'id' => 'No_',
                      'prompt' => '',
                      'onchange'=>'
                          $.get( "'.Url::toRoute('employee').'", { empno: $(this).val() } )
                              .done(function(data) {
                                  $profile = JSON.parse(data);
                                  console.log($profile)
                                  $email=JSON.parse(data).email;
                                  $idno=JSON.parse(data).idno;
                                  $UserName=JSON.parse(data).UserName;
                                  $AccountTypeID=JSON.parse(data).AccountTypeID;
                                  $("#AccountTypeID").val($AccountTypeID);
                                  $("#Email").val($profile[\'Company E-Mail\']);
								  $("#EmpNo").val($profile[\'No_\']);
                                  $("#IDNumber").val($idno);
                                  $("#UserName").val($UserName);
                              }
                          );
                      ',
                  ]) ?>
              </div>
              <!-- <label>Portal Username <span style="color:#F00">*</span></label>
              <div class="input-control text full-size">
                  <input name="UserName" type="text" id="UserName" value=""/>
              </div> -->
              <!-- <label>Id Number <span style="color:#F00">*</span></label>
              <div class="input-control text full-size">
                  <input name="IDNumber" type="text" id="IDNumber" value="" readonly="" />
              </div> -->

              <label>Email <span style="color:#F00">*</span></label>
              <div class="input-control text full-size">
                  <input name="Email" type="text" id="Email" />
              </div>
			  
			  
              <label>Employee No <span style="color:#F00">*</span></label>
              <div class="input-control text full-size">
                  <input name="EmpNo" type="text" id="EmpNo"/>
              </div>

              <label>Staff Rank<span style="color:#F00">*</span></label>
              <div data-role="select">
                  <select name="AccountTypeID"  id="AccountTypeID" class="input-control full-size">
                   <!--   <option value="0" ></option> -->
                     <!-- <option value="1" <?php echo $model['AccountTypeID']==1?'selected':'' ?>>Admin</option>-->
					 <option value="4" <?php// echo $model['AccountTypeID']==2?'selected':'' ?></option>
                      <option value="4" <?php// echo $model['AccountTypeID']==2?'selected':'' ?>Lecturer</option>
                       <option value="4" <?php// echo $model['AccountTypeID']==2?'selected':'' ?>Senior Lecturer</option>
					   <option value="4" <?php// echo $model['AccountTypeID']==2?'selected':'' ?>Tutorial fellow</option>
				  </select>
              </div>
			  
			  <?php 
				$programmes = Dimensionvalue::find()
					->where([ 'Dimension Code' => 'PROGRAMME' ])
					->orderBy('Name')->asArray()->all();
			  ?>
              <label>Programme<span style="color:#F00">*</span></label>
              <div data-role="select">
                  <select 
					name="ProgrammeCode"  
					id="ProgrammeCode" 
					class="input-control full-size"
					onchange="promptCourses()" > 
					<option value="0" selected="selected">---</option>
					<?php foreach($programmes as $key => $prog): ?>
						<option value="<?= $prog['Code'] ?>" > <?= $prog['Name'] ?> </option>
					<?php endforeach ?>
                  </select>
              </div>
			  
			  
			 <!-- <label>Year<span style="color:#F00">*</span></label>-->
			 <!-- <div data-role="select">-->
				<!--  <select -->
					<!--name="ProgrammeStage"  
					id="ProgrammeStage" 
					class="input-control full-size"
					onchange="promptCourses()" > 
					<option value='0' selected='selected'>---</option> 
				  </select>
			  </div>-->
			  
			  <label>Course<span style="color:#F00">*</span></label>
			  <div data-role="select">
				  <select multiple
					name="ProgrammeCourses[]"  
					id="ProgrammeCourses" 
					class="input-control full-size"  > 
					<option value='0' selected='selected'>---</option> 
				  </select>
			  </div>
			  <label>Campus Code <span style="color:#F00">*</span></label>
			  	<div data-role="select"> 
				<select name="Campus Code"  id="Campus Code" class="input-control full-size" onchange="loadsemester()">
					<option value="0" selected="selected"></option>
					<?php 
					$result = Dimensionvalue::find()->asArray()->where("[Dimension Code] = 'CAMPUS'")->orderBy('Name')->all();                    
					foreach ($result AS $key => $row)
					{
						$s_id = $row["Code"];
						$s_name = $row["Name"];
						if ($model['Campus Code']==$s_id) 
						{
							//print_r($model['Campus Code']);exit;
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
			
			
			
		
			  
			 
           
              <form action="create" method="get">
              <button id="submit-button" class="button large-button" onclick="submit_form(this.form)">
                  <h5 class="align-left">
                      <span class="mif-pencil place-left"></span>&nbsp;
                      <span class="text-shadow"> Add Lecturer </span></h5>
              </button>
			  </form>
          <?php Html::endForm(); ?>
		  <div class="pure-u-1"></div>
		  <div class="pure-u-1"></div>
      </div>
  </div>
</div>

<script type="text/javascript">
	$("#Code").select2();
  function submit_form(form) {
    console.log(form)
    $('#submit-button').prop('disabled', true);
    // regformhash(form)
    form.submit()
  }
  function promptCourses(ev) { 
	  var prog = $( "select#ProgrammeCode option:checked" ).val();

	  var url = "/api/stages?prog=" + prog;
	  console.log(url);
	  $.get( url, function( res ) {
		var data = JSON.parse(res);
		console.log(data);
		populateCourses('#ProgrammeCourses', data)
		  console.log( data );
		  
		  //alert( "Load was performed." );
	  });
  }
  
  
  function populateCourses(el, data) {
	  var opts = "<option value='0' selected='selected'>---</option>";
	  data.map(function(d) {
		  opts += "<option value=' " +  d['CourseCode'] + "' > " 
		  + d['CourseCode'] + " : " + d['Description']  + "</option>";
	  });
	  $(el).empty().append(opts);
	  console.log( $(el) );
  }
  
   function promptStage(ev) {
	  //console.log(ev.target, $( "select#ProgrammeCode option:checked" ).val() );
	  var prog = $( "select#ProgrammeCode option:checked" ).val();
	  var url = "/api/stages?prog=" + prog;
	  console.log(url);
	$.get( url, function( res ) {
		var data = JSON.parse(res);
		populateStages('#ProgrammeStage', data)
		  console.log( data );
		  //alert( "Load was performed." ); 
	});
  }
  
  function populateStages(el, data) {
	  var opts = "<option value='0' selected='selected'>---</option>";
	  data.map(function(d) {
		  opts += "<option value=' " +  d['Programme Stage'] + "' > " + d['Programme Stage'] + "</option>";
	  });
	  $(el).empty().append(opts);
	  console.log( $(el) );
  }
</script>
