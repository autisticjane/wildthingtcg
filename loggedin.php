<?php session_start();include_once("mytcg/settings.php");$userName = $_POST["username"];$password = $_POST["password"];$errMsg="";if($userName != "" && $password != "") {	$encryptPassword = md5($password);	$authSql = "SELECT * FROM `$table_members` WHERE email='$userName' AND password='$encryptPassword'";	$authResult = mysql_query($authSql)OR die('Couldn\'t Authenticate Visitor:'.mysql_error());	$authRow = mysql_fetch_assoc($authResult);	$userID = $authRow['id'];	$userStatus = $authRow['status'];	if($userID!=0) {		$_SESSION[USER_ID] = $userID;		$_SESSION[USR_LOGIN] = $userName;		$_SESSION[USR_STATUS] = $userStatus;

		$date=date("M j, Y");

		$thefile = "$authRow[name].txt"; 		$towrite = "<br /><br /><u>$date</u><br />"; 		$openedfile = fopen($thefile, "w");
		fwrite($openedfile, $towrite);
		header("Location: mem_panel.php");	}	else {	header("Location: login.php?msg=invalid");	}}else {	header ("Location: login.php?msg=missing");}?>