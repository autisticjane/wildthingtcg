<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Login | Wild Thing",$buffer);
echo $buffer;
$msg = $_GET['msg'];

if($msg=="invalid") {
	?>
	<h1>Error</h1>
	Oops, it looks like the email and/or password you entered is not in our database. Check your spelling and try again or contact us at <?php echo $tcgemail; ?>.
	<?php
}

elseif($msg=="missing") {
	?>
	<h1>Error</h1>
	Oops, it looks like one or more values from the form were not entered. Please go back and try again.
	<?php
}

else {
	?>
	<h1>Log In</h1>
	<p>Below is the login form for the member panel here at <?php echo $tcgname; ?>. <b>This is only for current members</b>. If you would like to join, please click <a href="/join.php">here</a> to see the rules and join.</p>
	<form method="post" action="loggedin.php">
	<table width="100%">
	<tr><td>Email</td><td><input type="text" name="username" /></td></tr>
	<tr><td>Password</td><td><input type="password" name="password" /></td></tr>
	<tr><td><a href="lostpass.php">Lost Password?</a></td><td><input type="submit" name="submit" value="Login!"></td></tr>
	</table>
	</form>
	<?php
}
include("$footer"); ?>