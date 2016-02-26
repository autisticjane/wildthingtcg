<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location: /login.php");
}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Card Claim | Wild Thing",$buffer);
echo $buffer;

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
		<h1>Card Claim</h1>
		<p><strong>Directions:</strong> Claim 2 cards of choice from different decks below.</p>

		<form method="post" action="cardclaim.php?claim">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<input type="hidden" name="name" value="<?php echo $row[name]; ?>" />
		<input type="hidden" name="email" value="<?php echo $row[email]; ?>" />
		<input type="hidden" name="url" value="<?php echo $row[url]; ?>" />
		<table border="0" width="80%" align="center">
		<tr><td width="20%">Card #1:</td><td width="20%"><select name="card1">
	<option value="">-----</option>
	<?php
	$query="SELECT * FROM claim ORDER BY card ASC";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$card=stripslashes($row['card']);
		$id1=stripslashes($row['id']);
		echo "<option value=\"$card\">$card</option>\n";
	}
	?>
	</select></td>
		<td width="20%">Card #2:</td><td width="20%"><select name="card2">
	<option value="">-----</option>
	<?php
	$query="SELECT * FROM claim ORDER BY card ASC";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$card=stripslashes($row['card']);
		$id2=stripslashes($row['id']);
		echo "<option value=\"$card\"\>$card</option>\n";
	}
	?>
	</select></td>
		<td width="20%" align="center"><input type="submit" name="submit" value=" Send! " /></form></td></tr></table>
		<div id="decks" style="text-align: center"><?php
		$result2=mysql_query("SELECT * FROM claim ORDER BY card ASC"); 
		$count2 = mysql_num_rows($result2);
		if($count2==0) {
		echo "There are no more cards. Come back next week.";
		}
		else {
		while($row2=mysql_fetch_array($result2)) {
		echo "<img src=\"$tcgcardurl";
		echo "$row2[card].png\" alt=\"$row2[card]\" title=\"$row2[card]\" /> "; } }?>
		</div>
		<h2>Logs</h2>
		<?php
	$query="SELECT * FROM claim_logs ORDER BY date DESC";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$name=stripslashes($row['name']);
		$card1=stripslashes($row['card1']);
		$card2=stripslashes($row['card2']);
		$date=stripslashes($row['date']);
		echo "<strong>$name</strong> took $card1 and $card2 on <em>$date</em><br />";
	}
	?>
		<br /><br />
		<?php
	}
}

elseif($_SERVER['QUERY_STRING']=="claim") {
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
			
			$name = htmlspecialchars(strip_tags($_POST['name']));
			$email = htmlspecialchars(strip_tags($_POST['email']));
	   		$card1 = htmlspecialchars(strip_tags($_POST['card1']));
			$card2 = htmlspecialchars(strip_tags($_POST['card2']));
			$currentDate = date("F j");
			$date = date("m/d/Y");

			$card1trim = substr($card1, 0, -2); 
			$card2trim = substr($card2, 0, -2); 

		if ($card1trim!=$card2trim) {
			$insert = "INSERT INTO claim_logs (`id`, `name`, `card1`, `card2`, `date`) VALUE ('', '$name', '$card1', '$card2', '$date')";
			mysql_query($insert, $connect) or die(mysql_error());

			$delete1 = "DELETE FROM claim WHERE card='$card1' LIMIT 1";
			mysql_query($delete1, $connect) or die(mysql_error());

			$delete2 = "DELETE FROM claim WHERE card='$card2' LIMIT 1";
			if (mysql_query($delete2, $connect)) {
				?>
				<h1>Card Claim</h1>
<p class="center">Success!<br /><img src="<?php echo "$tcgcardurl"; echo "$_POST[card1].png"; ?>"> <img src="<?php echo "$tcgcardurl"; echo "$_POST[card2].png"; ?>"><br />
<strong>Card Claim (<?php echo $currentDate; ?>):</strong> <?php echo $_POST[card1]; ?>, <?php echo $_POST[card2]; ?></p>
				<?php
			}
			else {
				?>
				<h1>Error</h1>
				<p>It looks like there was an error in processing your form. Send the information to <?php echo $tcgemail; ?> and we will send you a reply ASAP. Thank you and sorry for the inconvenience.</p>
				<?php
			}
}
else {
?>
				<h1>Error</h1>
				<p>You may not take more than one card from the same deck.</p>
<?php 
		}
	}
}
include("$footer"); ?>