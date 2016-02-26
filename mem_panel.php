<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Member panel | Wild Thing",$buffer);
echo $buffer;
?>
<h1>Member Panel</h1>
Welcome to your member panel! From here you can submit various forms, edit your info, and play all of the games here at <?php echo $tcgname; ?>!
<br /><br />

<h1>Navigation</h1>
<?php
$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
while($row=mysql_fetch_assoc($select)) {
	if($row[status]=="Pending") {
		?>
		It looks like you recently joined <?php echo $tcgname; ?> and your account hasn't been activated yet. You must be approved by an adminstrator before you can play any games here. Your account should be activated soon. If you joined more than 2 weeks ago and haven't received your activation email, please email us at <?php echo $tcgemail; ?>
		<br /><br />
		&raquo; <a href="forms_edit.php">Edit Your Information</a><br />
		&raquo; <a href="changepass.php">Change Your Password</a><br />
		&raquo; <a href="logout.php">Log Out</a>
		<?php
	}
	elseif($row[status]=="Hiatus") {
		?>
		It looks like you haven't been active in the past two months and have been placed on the Inactive list. In order to plays games here you must <a href="activate.php">reactivate</a> your account.
		<br /><br />
		&raquo; <a href="forms_edit.php">Edit Your Information</a><br />
		&raquo; <a href="changepass.php">Change Your Password</a><br />
		&raquo; <a href="logout.php">Log Out</a>
		<?php
	}
	else {
		?>
		&raquo; <a href="forms.php">Forms</a><br />
		&raquo; <a href="interactive.php">Interactive</a><br />
		&raquo; <a href="templog.php">Temporary Log</a><br />
		&raquo; <a href="logout.php">Log Out</a>
	<?php
	}
}
include("$footer"); ?>