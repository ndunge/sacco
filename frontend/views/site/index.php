<!DOCTYPE html>
<html lang="en">
<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$baseUrl = Yii::$app->request->baseUrl;
//print_r($baseUrl);exit;
$this->title = 'Login';
$error = (isset($error)) ? $error : '';
$url = $baseUrl.'/site/login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
  function hidePage(){
    document.getElementById("myDIV").style.display = "none";
  }
  function loadPage(){
    document.getElementById("myDIV").style.display = "block";
  }
</script>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Kencom SACCO</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="no-skin" style="background-color:#228B22;">

  <!--This is the default bootstrap nav bar-->

    <div class="container">
     
 

    <div class="row">
    <div class="col-md-18 col-md-offest-0">
    <div class="space-6" style="margin-top:80px"></div>
    <div class="panel panel-default" style="margin-left:380px; margin-right:450px; margin-top:-90px;">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Welcome to the Kencom Sacco Portal</strong></h3>
    </div>
    
    <div class="panel-body">
    <div class="center">
      <h5 class="green"><strong>Kencom SACCO</strong></h5>
        <div>
    
      <p><strong>You need to <?= Html::a('Login', ['login'], ['class' => 'link']) ?> or <?= Html::a('Sign Up', ['register'], ['class' => 'link']) ?> to access the  portal</strong></p>
      <div id="error" style="color:#F00"><?= $error; ?></div> 
   <img src="<?= $baseUrl; ?>/images/kcb-logo.jpg"" height="100" width="206" border="1px">
    </div>
    <input type="radio" name="accountypeid" value="new"  checked="checked" onclick="hidePage()"><b> Existing Member</b></t>
    <input type="radio" name="accountypeid" value="continuing" onclick="window.location = 'site/create';"><b> New Member</b><br><br>
  </div>
    <div class="space-6"></div>
    <div class="space-6"></div>
    <span class="red"></span>
    <div class="space-6"></div>
    <form id="file-form" action="<?= $url; ?>" method="POST" onsubmit="return false;" enctype="multipart/form-data">
    
  <!--   <div class="form-group">
         
             <label name="Email">Booze Category</label>
             <select class="form-control">
  <option> Category1</option>
  <option>Category2</option>
  <option>Category3</option>
  <option>Category4</option>
  <option>Category5</option>
</select>
     </div> -->

     <div class="form-group">      
             <label name="subject">Email</label>
             <input id="Email" name="Email" class="form-control" placeholder="Your Email here">

       </div>
     
       <div class="form-group">      
             <label name="subject">Password</label>
             <input id="Password" type="password" name="Password" class="form-control" placeholder="Your password here">

       </div> 
        <button class="button large-button success bg-hover-darkBlue" style="height:50px; width:100px;" onclick="formhash(this.form)">
									<h5 class="align-left">
									<span class="mif-pencil place-left"></span>&nbsp;
									<span class="text-shadow">Login </span></h5>
			</button>	
			
			<?= Html::a('Sign Up', ['register'], ['class' => 'link']) ?>
			<div class="pure-u-1"></div>
			<?= Html::a('Forgot Password?', ['forgotpassword'], ['class' => 'link']) ?>

       </div> 

     </div>


     </form>
     </div>
     </div>
     </div>
     </div>
     </div>
     

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>