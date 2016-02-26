<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Affiliates | Wild Thing",$buffer);
echo $buffer;
if(!$_SERVER['QUERY_STRING']) {
	?>
	<h1>Affiliates</h1>
	<center>
	<?php
	$query=mysql_query("SELECT * FROM $table_affiliates WHERE status='Active' ORDER by tcgname ASC");
	$num_affs=mysql_num_rows($query);
	if($num_affs==0) {
		echo "There are currently no affiliates.\n";
	}
	else {
		while($row=mysql_fetch_assoc($query)) {
			echo "<a href=\"$row[url]\" target=\"_blank\"><img src=\"$buttonurl$row[button]\" title=\"$row[tcgname]\"></a>\n";
		}
	}
	?>
	</center>
	<br /><br />
	Want to become one? Simply fill out the form below:<br />
	<form method="post" action="affiliates.php?thanks">
	<input type="hidden" name="status" value="Pending" />
	<table width="100%">
	<tr><td><b>Owner's Name:</b></td><td><input type="text" name="name" /></td></tr>
	<tr><td><b>Email:</b></td><td><input type="text" name="email" /></td></tr>
	<tr><td><b>TCG Name:</b></td><td><input type="text" name="tcgname" /></td></tr>
	<tr><td><b>URL:</b></td><td><input type="text" name="url" /></td></tr>
	<tr><td><b>Button URL:</b></td><td><input type="text" name="button" /></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Apply! " /></td></tr>
	</table>
	</form>
	<?php
}

elseif($_SERVER['QUERY_STRING']=="thanks") {
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

			$name = escape_sql(CleanUp($_POST['name']));
			$email = escape_sql(CleanUp($_POST['email']));
			$tcgname = escape_sql(CleanUp($_POST['tcgname']));
			$url = escape_sql(CleanUp($_POST['url']));
			$button = escape_sql(CleanUp($_POST['button']));
			$status = escape_sql(CleanUp($_POST['status']));
		
			$insert = "INSERT INTO `$table_affiliates` (`id`, `name`, `email`, `tcgname`, `url`, `button`, `status`) VALUES ('', '$name', '$email', '$tcgname', '$url', '$button', '$status')";
			
			$recipient = "$tcgemail";
			$subject = "Affiliate Form";
			
			$message = "The following site would like to become an affiliate with $tcgname: \n";
			$message .= "TCG Name: {$_POST['name']} \n";
			$message .= "Email: {$_POST['email']} \n";
			$message .= "TCG URL: {$_POST['url']} \n";
			$message .= "To approve this affiliate, go to your admin panel.\n\n";
			
			$headers = "From: {$_POST['name']} <{$_POST['email']}> \n";
			$headers .= "Reply-To: <{$_POST['email']}>";
			
			if (mail($recipient,$subject,$message,$headers)) {
				if (mysql_query($insert, $connect)) {
					?>
					<h1>Thanks!</h1>
					Thanks for submitting an affiliate form. You should hear back from us ASAP. Make sure you've linked back to us using a text link or button.
					<br /><br />
					<?php
				}
				else {
					?>
					<h1>Thanks!</h1>
					Thanks for submitting an affiliate form. You should hear back from us ASAP. Make sure you've linked back to us using a text link or button.
					<?php
				}
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your affiliate form. Send the information to <?php echo $tcgemail; ?> and we will reply ASAP. Thank you and sorry for the inconvenience.
				<?php
			}
	}
}

include("$footer"); ?>