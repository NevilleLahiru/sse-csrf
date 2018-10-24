<?php
session_start();
$data['Token']=NULL;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_COOKIE['customSessionID'])){ //check for session ID in cookie
	
		//generate token from cookie+secret+sessionStartTime
		$sID = $_COOKIE['customSessionID'];
		$sTime = $_SESSION['stime'];
		$secret = "SERVER-SECRET";
		$data['Token'] = sha1($sID.$secret.$sTime);
		$data['Status'] = "Success";
	}
	else $data['Err'] = "No session found";
}

echo json_encode($data);
?>