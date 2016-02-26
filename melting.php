<?php session_start();
include("mytcg/settings.php");
include("$header");
if (isset($_SESSION['USR_LOGIN'])=="") { ?>
	<h1>Error</h1>
<center>You must be logged in to view this page.</center>
<?php }

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>

		<h1>Melting Pot</h1>
	<center>Use the form below trade a card from the melting pot. You may melting 2 cards once a week, but there may never be 2 cards from the same deck.</center>

		<form method="post" action="melting.php?thanks">
		<input type="hidden" name="name" value="<?php echo $row[name]; ?>" />
		<table border="0" width="80%">
		<tr><td width="20%"><b>Taking:</b><td width="20%"><select name="card1">
	<option value="">-----</option>
	<?php
	$query="SELECT * FROM melting ORDER BY card";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$card=stripslashes($row['card']);
		echo "<option value=\"$card\">$card</option>\n";
	}
	?>
	</select></td>
		<td width="20%"><b>Giving:</b></td><td width="20%"><select name="give1">
	<option value="">-----</option>
	<?php
	$query="SELECT * FROM cards ORDER BY filename";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$card=stripslashes($row['filename']);
		echo "<option value=\"$card\"\>$card</option>\n";
	}
	?>
	</select><input type="text" name="give2" size="1" value="00" /></td>
		<td width="20%" align="center"><input type="submit" name="submit" value=" Send! " /></td></tr>
		<tr><td colspan="5" align=center><?php
		$result2=mysql_query("SELECT * FROM melting ORDER BY card"); 
		$count2 = mysql_num_rows($result2);
		if($count2==0) {
		echo "There are no more cards. Come back next week.";
		}
		else {
		while($row2=mysql_fetch_array($result2)) {
		echo "<img src=\"$tcgcardurl";
		echo "$row2[card].png\" alt=\"$row2[card]\" title=\"$row2[card]\" /> "; } }?>
		</td></tr>
		<tr><td class=title>Logs</td></tr>
		<tr><td class=cell>	<?php
	$query="SELECT * FROM melting_logs ORDER BY date ";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$name=stripslashes($row['name']);
		$take=stripslashes($row['take']);
		$give=stripslashes($row['give']);
		$date=stripslashes($row['date']);
		echo "$name exchanged $give for $take on $date<br>";
	}
	?></td></tr>
		</table>
		</form>
		<br /><br />
		<?php
	}
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
			
	   		$name = htmlspecialchars(strip_tags($_POST['name']));
	   		$card1 = htmlspecialchars(strip_tags($_POST['card1']));
			$give1 = htmlspecialchars(strip_tags($_POST['give1']));
			$give2 = htmlspecialchars(strip_tags($_POST['give2']));
			$date = date("m/d/Y");

	   		$card2 = "$give1$give2";

			$query="SELECT * FROM melting WHERE card = '".$card2."'";
			$result=mysql_query($query);
			$num = mysql_num_rows($result);

			$data = "SELECT `card` FROM `melting` WHERE SUBSTR(`card`,1,CHAR_LENGTH(`card`) - 2) = '$give1'";
			$result2 = mysql_query($data);
			$num2 = mysql_num_rows($result2);
			
			if ($num > 0) {
			echo "<b>Error!</b> That card is already in the pile.";
			}
			elseif ($num2 > 0) {
			echo "<b>Error!</b> That deck is already in the pile.";
			}
			else {

			$delete1 = "DELETE FROM melting WHERE `card`='$card1' LIMIT 1";
			mysql_query($delete1, $connect) or die(mysql_error());

			$insert2 = "INSERT INTO melting_logs (`id`, `name`, `take`, `give`, `date`) VALUE ('', '$name', '$card1', '$card2', '$date')";
			mysql_query($insert2, $connect) or die(mysql_error());

			$insert1 = "INSERT INTO melting (`id`, `card`) VALUE ('', '$card2')";
			if (mysql_query($insert1, $connect)) {
				?>
				<h1>Melting Pot</h1>
<center><img src="<?php echo "$tcgcardurl"; echo "$card2.png"; ?>"><br>
<b>Melting Pot:</b> <?php echo $card2; ?></center>
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
}
include("$footer"); ?>