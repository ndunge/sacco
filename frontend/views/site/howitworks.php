<?php
use yii\helpers\Html;
$this->title = 'Support/Contacts';
if (!isset($msgArray)) {$msgArray= array();}
?>
<ul class="breadcrumbs no-padding-top no-padding-bottom">
  <li><a href="../"><span class="icon mif-home fg-kra-red"></span></a></li>
  <li><a href="../">Home</a></li>
  <li><?= $this->title; ?></li>
</ul>
<div class="pure-u-1"></div>
<div class="pure-g">
 <div class="pure-u-1 pure-u-md-2-5">
  <h4>Call Center</h4>
  <br/>
  <p class="lh-small fg-kra-red">
   <span class="icon bg-transparent mif-phone fg-kra-red"></span>&nbsp;+254 <br/>
   <span class="icon bg-transparent mif-phone fg-kra-red"></span>&nbsp;+254 <br/>
   <span class="icon bg-transparent mif-phone fg-kra-red"></span>&nbsp;+254 <br/>
  </p>
  <p class="lh-small fg-kra-red">
   <span class="icon mif-mail bg-transparent fg-kra-red"></span>&nbsp; <a href="mailto:support@bizleads.co.ke">support@cuea.edu</a>
   <br/>
   <br/> 
   <span class="icon mif-mail bg-transparent fg-kra-red"></span>&nbsp; <a href="mailto:sales@bizleads.co.ke">support@cuea.edu</a>
  </p>
 </div>
 <div class="pure-u-1 pure-u-md-2-5">
  <h4>Raise a support Query</h4>
  <br/>
  <div style="color:#F00">
  <?php
   //print_r($msgArray); exit;
   foreach ($msgArray AS $key => $value)
   {
    echo $value[0] . '<br/>'; 
   }
  ?>
  </div> 
  <form id="file-form" action="support" method="POST">
   <label>Name <span style="color:#F00">*</span></label>
   <div class="input-control text full-size">
    <input name="Name" type="text" id="Name" value=""/>
   </div>
   <label>Mobile <span style="color:#F00">*</span></label>
   <div class="input-control text full-size">
    <input name="Mobile" type="text" id="Mobile" value=""/>
   </div> 
   <label>Email <span style="color:#F00">*</span></label>
   <div class="input-control text full-size">
    <input name="Email" type="text" id="Email" value=""/>
   </div>   
   <label>Subject <span style="color:#F00">*</span></label>
   <div class="input-control text full-size">
    <input name="Subject" type="text" id="Subject" value=""/>
   </div> 
   <label>Message <span style="color:#F00">*</span></label>
   <div class="input-control textarea full-size">
    <textarea name="Message" rows="7" id="Message"><?= ''; ?></textarea>
   </div>
   <?= Html::submitButton('Submit', ['class' => 'button primary']) ?>
   <?= Html::a('Cancel', ['support'], ['class' => 'button']) ?>
  </form> 
 </div>
</div>
<div class="pure-u-1"></div>