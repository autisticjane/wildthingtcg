<?php include("mytcg/settings.php");include("$header");

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
			
			$id = $_POST['id'];
			$query="SELECT * FROM `$table_members` WHERE id='$id'";
			$result=mysql_query($query);
			$row=mysql_fetch_assoc($result);
			
			$recipient = "$row[email]";
			$subject = "$tcgname: Trade Request";
			
			$message = "The following member has sent you a trade request: \n";
			$message .= "Name: {$_POST['name']} \n";
			$message .= "Email: {$_POST['email']} \n";
			$message .= "URL: {$_POST['url']} \n";
			$message .= "Offering: {$_POST['giving']} \n";
			$message .= "For: {$_POST['for']} \n";
			$message .= "Member Cards?: {$_POST['member']} \n";
			
			$headers = "From: {$_POST['name']} <{$_POST['email']}> \n";
			$headers .= "Reply-To: <{$_POST['email']}>";
			
			if (mail($recipient,$subject,$message,$headers)) {
				?>
				<h1>Success!</h1>
				Your trade request has been successfully sent! The member should (hopefully) respond within a week.
				<br /><br />
				<?php
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your trade form. Why don't you check out their website to see if they have a trade form there?
				<?php
			}
	}
include("$footer"); ?>