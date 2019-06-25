<?php
use yii\helpers\Url;

$UserName = "Joseph";
?>
<div class="app-bar blue" data-role="appbar">
	<div class="container">
		<ul class="app-bar-menu">
			<li data-flexorder="1" data-flexorderorigin="0"><a href="<?= Url::to(['site/login'])?>">Home</a></li>

			<li data-flexorder="7" data-flexorderorigin="6"><a href="<?= $baseUrl; ?>/site/about">About us</a></li>
			<li data-flexorder="8" data-flexorderorigin="7"><a href="<?= $baseUrl; ?>/site/support">Support</a></li
		</ul>
	</div>
</div>      