<?php include("mytcg/settings.php");
include("$header");
?>
		<h1>Quitter Generator</h1>
		<center><form method="post" action="random_quitter.php?pickup">
		<textarea name="cards" style="width: 300px; height: 100px" placeholder="Your cards separated by commas"></textarea><br />
		<input type="submit" name="submit" value=" Go! " />
		</form></center>
		<br /><br />
		<?php

if($_SERVER['QUERY_STRING']=="pickup") {
	if (!isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] != "POST") {
		exit("<p>You did not press the submit button; this page should not be accessed directly.</p>");
	}
	else {
		$exploits = "/(content-type|bcc:|cc:|document.cookie|onclick|onload|javascript|alert)/i";
		$profanity = "/(beastial|bestial|blowjob|clit|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuck|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
		$spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|backgammon|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
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
				?>

				
				<center><textarea onclick="this.focus();this.select()" style="width: 75%;"><?php
				echo "[card]";
				$find[] = ', ';
				$replace[] = '[/card] [card]';
				$text = str_replace($find, $replace, $_POST['cards']);
				print_r($text);
				?>[/card]</textarea>
				</center>
				<br /><br />
				<?php
			}
}
include("$footer");
?>