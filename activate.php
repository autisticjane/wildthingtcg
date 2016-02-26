<?php session_start();if (isset($_SESSION['USR_LOGIN'])=="") {	header("Location:login.php");}
include("mytcg/settings.php");include("$header");

$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
while($row=mysql_fetch_assoc($select)) {
	$update = "UPDATE `$table_members` SET `status`='Pending' WHERE `id`='$row[id]'";
	$recipient = "$tcgemail";
	$subject = "Reactivate an Account";
			
	$message = "The following member has requested their account be reactivated:\n";
	$message .= "Name: $row[name]\n";
	$message .= "Email: $row[email]\n";
	$message .= "To reactive their account, simply log in to your admin panel and approve them from there\n";
		
	$headers = "From: $tcgname <$tcgemail> \n";
	$headers .= "Reply-To: $tcgname <$tcgemail>";	    	if (mail($recipient,$subject,$message,$headers)) {
	    		if(mysql_query($update, $connect)) {		    	    echo "<h1>Success</h1>\n";
		    	    echo "Your request has been successfully sent.";
	    		}
	    		else {
	    			echo "<h1>Success</h1>\n";
	    			echo "Your request has been successfully sent.";
	    		}
	    	}
	    	else {
		    		echo "<h1>Error</h1>\n";		    	    echo "It looks like there was an error in processing your form. Send the information to $tcgemail and we will process your request ASAP. Thank you and sorry for the inconvenience.";
	    	}
}
include('$footer'); ?>