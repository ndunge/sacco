<?php
// use common\models\Studentapplication;
// use common\models\Courseregistration;
$identity = Yii::$app->user->identity;
$UserName = $identity->fullnames;
$CustomerID = $identity->Userid;

$baseUrl = Yii::$app->request->baseUrl;
//print_r($CustomerID);exit;


?>
<div class="app-bar brown" data-role="appbar" style="background-color:#228B22;">
	<div class="container">
		<a class="app-bar-element branding">Kencom</a>
        <span class="app-bar-divider"></span>
		<ul class="app-bar-menu">
			<li data-flexorder="1" data-flexorderorigin="0"><a href="#">Home</a></li>
			<li data-flexorder="2" data-flexorderorigin="1"><a href="#">Loan Statement</a></li>
			<li data-flexorder="3" data-flexorderorigin="2"><a href="#"></a></li>
			<li data-flexorder="7" data-flexorderorigin="6"><a href="#">Statistical information</a></li> 
			<li data-flexorder="7" data-flexorderorigin="6"><a href="#">Deposit Statement</a></li> 
			<li data-flexorder="8" data-flexorderorigin="7"><a href="<?= $baseUrl; ?>/support/create">Support</a></li>
			<li><a href="<?php echo $baseUrl; ?>/site/logout" style="padding-left:20px">Logout</a></li>
		</ul>
		<div class="app-bar-element place-right">
			
			<span class="dropdown-toggle"><span class="mif-cog"></span> <?php echo "$UserName"; ?></span> 


			<ul class="d-menu place-right" data-role="dropdown">
				<li><a href="<?php echo $baseUrl; ?>/site/profile" style="padding-left:20px">My Profile Details</a></li>
				<li><a href="<?php echo $baseUrl; ?>/student/update?id=<?=$CustomerID;?>" style="padding-left:20px">My Details</a></li>
				<li><a href="<?php echo $baseUrl; ?>/site/changepassword" style="padding-left:20px">Change Password</a></li>
				<li class="divider"></li>
				<li><a href="<?php echo $baseUrl; ?>/site/logout" style="padding-left:20px">Logout</a></li>
			</ul>
		</div> 
	</div>
</div>
<body>
	<p>Welcome to Kencom Sacco</p>
</body>