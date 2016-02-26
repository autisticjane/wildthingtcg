<?php session_start();if (isset($_SESSION['USR_LOGIN'])=="") {	header("Location:login.php");}
include("mytcg/settings.php");include("$header");

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
		<h1>Change Your Password</h1>
		Use this form to change your password. <b>You will be logged out after this change</b>. Make sure you have any card activity logged before this, because your temporary log will be wiped clean.
		<br /><br />
		<form method="post" action="changepass.php?changed">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<table width="100%">
		<tr><td>Current Password:</td><td><input type="password" name="current" value="" /></td></tr>
		<tr><td>New Password:<br />
		(type twice)</td><td><input type="password" name="password" value="" /><br />
		<input type="password" name="password2" value="" /></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Change! " /></td></tr>
		</table>
		</form>
		<?php
	}
}

elseif($_SERVER['QUERY_STRING']=="changed") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
		exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
		$exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
		$profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
		$spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
		$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";
		
		if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
			exit("<h1>Error</h1>\nKnown spam bots are not allowed.<br /><br />");
		}
		foreach ($_POST as $key => $value) {
			$check1=mysql_query("SELECT * FROM `$table_members` WHERE id='$_POST[id]'");
			$row=mysql_fetch_assoc($check1);
			$value = trim($value);

			if (empty($value)) {
				exit("<h1>Error</h1>\nYou must fill out all fields. Please go back and fill in the form properly.<br /><br />");
			}
			elseif (preg_match($exploits, $value)) {
				exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.<br /><br />");
			}
			elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
				exit("<h1>Error</h1>\nThat kind of language is not allowed through our form.<br /><br />");
			}				
			elseif ($_POST[password2]!=$_POST[password]) {
				exit("<h1>Error</h1>\nThe new passwords you entered do not match, please go back and make sure they are they same.");
			}
			elseif (md5($_POST[current])!=$row[password]) {
				exit("<h1>Error</h1>\nThe current password you entered does not match our records. Please go back and make sure you entered it correctly.");
			}
			$_POST[$key] = stripslashes(strip_tags($value));
		}
		
		$password = escape_sql(CleanUp($_POST['password']));
		$scrampass = md5($password);

		$query=mysql_query("SELECT * FROM `$table_members` WHERE id='$row[id]'");
		while($row=mysql_fetch_assoc($query)) {
			$id = $row[id];
						
			$recipient = "$row[email]";
			$subject = "$tcgname: Changed Your Password";
			
			$message = "Your password has been changed to $password. Please keep this email in a safe place, as we cannot recover lost passwords.\n";
			
			$headers = "From: $tcgname <$tcgemail> \n";
			$headers .= "Reply-To: $tcgname <$tcgemail>";
			
			$update = "UPDATE `$table_members` SET password='$scrampass' WHERE id='$id'";
			
			if (mail($recipient,$subject,$message,$headers)) {
				if(mysql_query($update, $connect)) {
				session_destroy();
				?>				<h1>Success</h1>
				Your password was successfully changed and you have been logged out. Would you like to <a href="login.php">log back in</a>?
				<?php
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your form. Send the information to <?php echo $tcgemail; ?> and we will change it manually ASAP. Thank you and sorry for the inconvenience.
				<?php
			}
	}
	}
}
}

include("$footer"); ?>