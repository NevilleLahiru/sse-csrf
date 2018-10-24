<?php
$data;
session_start();


if(isset($_REQUEST['logout'])){
	$_SESSION['loggedIn'] = FALSE;
	session_destroy();
	
}

if(isset($_REQUEST['btnContact'])){
	
	// check if request has a CSRF token
	if(!isset($_REQUEST['CSRF'])){
		echo "No CSRF Token Found";
	}
	else{
		$tk = $_REQUEST['CSRF']; // token from client side
		
		if(isset($_COOKIE['customSessionID'])){ //check for session ID in cookie
			
			//generate token from cookie+secret+sessionStartTime
			$sID = $_COOKIE['customSessionID'];
			$sTime = $_SESSION['stime'];
			$secret = "SERVER-SECRET";
			if ( $tk === sha1($sID.$secret.$sTime)){ //validate token
				echo "<h3>Contact request accepted</h3>";
				$data['Status'] = "Success";
			}
			else echo "<h3>Request Failed. Invalid CSRF token.</h3>";
			
		}
		else  echo "Request Failed. No session cookie found.";
	}
	
}

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==TRUE) $data="You're logged in.";
else header("Location: index.php");




?>
<!DOCTYPE html>


<html>
	<head>
		<title>Protected</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body>
		<div><?php //echo json_encode($data); ?></div>
		
		<h1>Protected</h1>	
		
	<form method="post" action="protected.php">
		<input type="hidden" value="true" name="logout" />
		<input type="submit" value="Logout" />
	</form>	
	<hr />
	
	<form id="contactForm" method="post" action="protected.php">
		<h4>Contact</h4>
		<input type="text" name="name"  placeholder="Name" /> <br/>
		<input type="text" name="mail"  placeholder="Email" /><br/>
		<input type="text" name="msg"  placeholder="Message" /><br/>
		<input type="submit" name="btnContact" value="Submit" />
	</form>
	</body>
<script>
$(document).ready(function(){
	
	//AJAX call to server to get CSRF token
	$.ajax({
		url: 'get-token.php',
		method: 'post',
		dataType: 'json',
		success: function(data){
			console.log(data.Token);
			$('#contactForm').append('<input type="hidden" name="CSRF" value="'+data.Token+'"/>');
		}
	});
});
</script>
</html>