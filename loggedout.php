<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Logged out | Wild Thing",$buffer);
echo $buffer;
?>
<h1>Logged Out</h1>
<p>You have successfully logged out of your <strong><?php echo $tcgname; ?></strong> member panel.</p>

<h2>Log back in</h2>
<form method="post" action="loggedin.php">
	<table width="25%" class="wildthing">
	<tr><td width="5%"><label for="username">Email</label></td><td width="95%"><input type="text" id="username" name="username" /></td></tr>
	<tr><td><label for="password">Password</label></td><td><input type="password" id="password" name="password" /></td></tr>
	<tr><td></td><td><input type="submit" name="submit" value="Login!"></td></tr>
	</table>
	</form>
<?php include("$footer"); ?>