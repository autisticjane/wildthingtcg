<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
include("$header");

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
		<h1>Quit</h1>
	
		<form method="post" action="forms_quit.php?sent">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<input type="hidden" name="name" value="<?php echo $row[name]; ?>" />
		<input type="hidden" name="email" value="<?php echo $row[email]; ?>" />
		<input type="hidden" name="url" value="<?php echo $row[url]; ?>" />
		<table width="100%">
		<tr><td valign="top"><b>Reason for Leaving:</b></td><td><textarea name="message" rows="5" cols="40">Type your message here.</textarea></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Send! " /></td></tr>
		</table>
		</form>
		<br /><br />
		<?php
	}
}

elseif($_SERVER['QUERY_STRING']=="sent") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
		exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
		$exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
		$profanity = "/(beastial|bestial|blowjob|clit|cock|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
		$spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
		$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";
		
		if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
			exit("<h1>Error</h1>\nKnown spam bots are not allowed.<br /><br />");
			}
			foreach ($_POST as $key => $value) {
				$value = trim($value);
				if (empty($value)) {
					exit("<h1>Error</h1>\nEmpty fields are not allowed. Please go back and fill in the form properly.<br /><br />");
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
			
			$recipient = "$tcgemail";
			$subject = "Quit Form";
			
			$message = "The following member has quit: \n";
			$message .= "Name: {$_POST['name']} \n";
			$message .= "Email: {$_POST['email']} \n";
			$message .= "URL: {$_POST['url']} \n";
			$message .= "Message: {$_POST['message']} \n";
			
			$headers = "From: {$_POST['name']} <{$_POST['email']}> \n";
			$headers .= "Reply-To: <{$_POST['email']}>";
			
			if (mail($recipient,$subject,$message,$headers)) {
				?>
				<h1>Quit</h1>
				Sorry to see you leave. Hopefully you change your mind and join us in the future!
				<?php
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your form. Send the information to <?php echo $tcgemail; ?> and we will send you a reply ASAP. Thank you and sorry for the inconvenience.
				<?php
			}
	}
}
include($footer); ?>