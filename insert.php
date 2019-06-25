<?php
$myServer = "NDUNGE\TESTER";
$myUser   = "sa";
$myPass   = '123';
$myDB     = "kencom";
$DatabaseCompanyName="[dbo].[TRAINED DB$";
// Create connection
$connectionInfo = array("UID" => $myUser, "PWD" => $myPass, "Database"=> $myDB, "ReturnDatesAsStrings" => true);
$db = sqlsrv_connect( $myServer, $connectionInfo);
if($db){
//echo "Connected";
}else{
//echo"Failled to connect";
}

//$SessionID = $myrow['SessionID'];
$DatabaseCompanyName = "dbo.TRAINED DB$";
		$Userid    = '1234c';
		$Username    = 'winnie';
		$Blocked    = '0';
		$Password    = $_POST['password'];
		$email    = $_POST['email'];
		$idnumber    = $_POST['idnumber'];
		$fullnames    = $_POST['fullnames'];

		//$email = $StartTime.' TO '.$EndTime.': '.$Venue;
		//echo "$SessionID <br>";
		$reg_session_sql="INSERT INTO [".$DatabaseCompanyName."online users] 
							(
							 Userid	
							,Username
							,Blocked	
							,password
							,email
							,idnumber
							,fullnames

							)
							VALUES
							(
                             '$Userid'
							,'$Username'
							,'$Blocked'
							,'$Password'	
							,'$email'
							,'$idnumber'
							,'$fullnames'		
							)";
							print_r($reg_session_sql);exit;
		$reg_session_result = sqlsrv_query($db, $reg_session_sql);
		//print_r($reg_session_result);exit;
		if($reg_session_result){
			echo "working";
		
		} else {
			$errorTrackError = 0;
		}
?>

