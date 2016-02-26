<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
include("$header"); ?>
<h1>Forms</h1>
&raquo; <a href="forms_general.php">General Contact</a><br />
&raquo; <a href="forms_edit.php">Edit Your Info</a><br />
&raquo; <a href="forms_level.php">Level Up</a><br />
&raquo; <a href="forms_master.php">Mastery</a><br />
&raquo; <a href="forms_quit.php">Quit</a><br />
<?php include($footer); ?>