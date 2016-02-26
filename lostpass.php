<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Reset password | Wild Thing",$buffer);
echo $buffer;

if(!$_SERVER['QUERY_STRING']) {
	?>
	<h1>Lost Password</h1>
	<form method="post" action="lostpass.php?reset">
	<table width="100%" class="wildthing">
	<tr><td>Email:</td><td><input type="text" name="email" value="" /></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Reset! " /></td></tr>
	</table>
	</form>
	<?php
}

elseif($_SERVER['QUERY_STRING']=="reset") {
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
			$value = trim($value);

			if (empty($value)) {
				exit("<h1>Error</h1>\nAll fields must be filled out Please go back and fill out the form again.<br /><br />");
			}
			elseif (preg_match($exploits, $value)) {
				exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.<br /><br />");
			}
			elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
				exit("<h1>Error</h1>\nThat kind of language is not allowed through our form.<br /><br />");
			}				
			$_POST[$key] = stripslashes(strip_tags($value));
		}
			
		if (!ereg("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,6})$",strtolower($_POST['email']))) {
			exit("<h1>Error</h1>\nThat e-mail address is not valid, please use another.<br /><br />");
		}
		
		$password = substr(md5(date("c")), 0, 8);
		$email = escape_sql(CleanUp($_POST['email']));
		$scrampass = md5($password);

		$query=mysql_query("SELECT * FROM `$table_members` WHERE email='$email'");
		$num=mysql_num_rows($query);
		while($row=mysql_fetch_assoc($query)) {
			if($num==0) {
				exit("<h1>Error</h1>\nThat email address does not exist in our database. Please go back and check your spelling and try again.");
			}
			else {
		
				$id = $row[id];
						
				$recipient = "$email";
				$subject = "$tcgname: Reset Your Password";
			
				$message = "Your password has been reset to $password. Please log in and change it.\n";
			
				$headers = "From: $tcgname <$tcgemail> \n";
				$headers .= "Reply-To: $tcgname <$tcgemail>";
			
				$update = "UPDATE `$table_members` SET password='$scrampass' WHERE id='$id'";
			
				if (mail($recipient,$subject,$message,$headers)) {
					if(mysql_query($update, $connect)) {
						?>
						<h1>Success!</h1>
						Your password has been reset and sent to the email you provided. Please log in and change your password once you have checked your email.
						<br /><br />
						<?php
					}
					else {
						?>
						<h1>Error</h1>
						It looks like there was an error in processing your form. Send the information to <?php echo $tcgemail; ?> and we will send you a new password ASAP. Thank you and sorry for the inconvenience.
						<?php
					}
				}
				else {
					?>
					<h1>Error</h1>
					It looks like there was an error in processing your form. Send the information to <?php echo $tcgemail; ?> and we will send you a new password ASAP. Thank you and sorry for the inconvenience.
					<?php
				}
			}
		}
	}
}

include("$footer"); ?>