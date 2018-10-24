<?php

$data['r']=$_POST;
session_start();


if(isset($_REQUEST['username'])){
	echo "parameter ok \n";
	$data['loginStaus']=check_login($_REQUEST['username'], $_REQUEST['password']);
	if($data['loginStaus']==TRUE){
		$_SESSION['loggedIn']=TRUE;
		$_SESSION['user']=$_REQUEST['username'];
		
		//generate session ID
		$sID = md5(uniqid(rand(), TRUE));
		$sTime = time();
		
		//store session ID & start time 
		$_SESSION['sid'] = $sID;
		$_SESSION['stime'] = $sTime;
		
		//generate CSRF token
		setcookie("customSessionID", $sID, time() + (86400 * 30), "/");
		$secret="SERVER-SECRET";
		$csrfToken = sha1($sID.$secret.$sTime);
		
		header("Location: protected.php");
	}
	else echo "Invalid login info.";
}
else echo "No login info submitted";


function check_login($u, $p){
	$uname = "user007";
	$hash = "qwerty";
	if($uname != $u ){$data['x'] = "uname mismatch"; return FALSE;} 
	else if($hash == $p) return TRUE;
	else return FALSE;
}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<div><?php echo json_encode($data); ?></div>
		<form method="post" action="index.php">
			<input type="text" name="username" maxlength="15" placeholder="Username" value="user0"/>
			<input type="text" name="password" maxlength="15" placeholder="Password" value="jinx"/>
			<button type="submit">Login</button>
		</form>
		
	</body>
</html>