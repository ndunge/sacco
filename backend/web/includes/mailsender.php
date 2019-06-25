<?php
require_once 'PHPMailer-master/PHPMailerAutoload.php';

function SendMail($EmailArray,$Subject,$Message)
{
	// Send mail
	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
			
	// SMTP Configuration
	$mail->Port = 587; // optional if you don't want to use the default 
	//$mail->SMTPDebug = 3;
	//$mail->SMTPDebug = true;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;                  // enable SMTP authentication
	$mail->Host = "smtp.gmail.com"; // SMTP server
	$mail->Username = "support@cuea.edu";
	$mail->Password = "M@yaiMbili1"; 
	           
	//$mail->Port = 25; // optional if you don't want to use the default 
			
	$mail->From = "support@cuea.edu";
	$mail->FromName = "Administrator";
	$mail->Subject = $Subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
	$mail->MsgHTML($Message);
			 
	// Add as many as you want
	foreach($EmailArray AS $key => $row)
	{
		extract($row);
		$mail->AddAddress($Email, $Name);
	}		
	// If you want to attach a file, relative path to it
	//$mail->AddAttachment("images/phpmailer.gif");             // attachment
			
	$response= NULL;
	if(!$mail->Send()) 
	{
		$msg = "Mailer Error: " . $mail->ErrorInfo;
		$Sent = 0;
	} else {
		$msg = "Message sent!";
		$Sent = 1;
	}
	return $Sent;
}	

function Sendattachment($EmailArray,$Subject,$Message, $Filename)
{
	// Send mail
	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
			
	// SMTP Configuration
	//$mail->Port = 465; // optional if you don't want to use the default 
	//$mail->SMTPDebug = 3;
	
	$mail->SMTPAuth = true;                  // enable SMTP authentication
	$mail->Host = "smtp.sendgrid.net"; // SMTP server
	$mail->Username = "ngugi.joseph@attain-es.com";
	$mail->Password = "M@yaiMbili1"; 
	           
	//$mail->Port = 25; // optional if you don't want to use the default 
			
	$mail->From = "ngugi.joseph@attain-es.com";
	$mail->FromName = "Administrator";
	$mail->Subject = $Subject;
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	//$mail->MsgHTML($issue . "<br /><br />" . $comment);
	$mail->MsgHTML($Message);
			 
	// Add as many as you want
	foreach($EmailArray AS $key => $row)
	{
		extract($row);
		$mail->AddAddress($Email, $Name);
	}		
	// If you want to attach a file, relative path to it
	$mail->AddAttachment($Filename);  // attachment
			
	$response= NULL;
	if(!$mail->Send()) 
	{
		$msg = "Mailer Error: " . $mail->ErrorInfo;
		$Sent = 0;
	} else {
		$msg = "Message sent!";
		$Sent = 1;
	}
	//echo $msg; exit;
	return $Sent;
}	