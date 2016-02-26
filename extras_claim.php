<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("login.php");
}
include("mytcg/settings.php");
include("$header");

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
<?php
$select_ccount = mysql_query("SELECT * FROM `cardclaims`");
$num_claims = mysql_num_rows($select_ccount);
?>
		<h1>Card Claim</h1>
		You can claim 2 cards per week. Don't forget to log what you receive! There are <?php echo $num_claims; ?> cards left out of 50 total.<br><b>Last Updated With New Cards:</b> 2/1/13<br><br>
		<form method="post" action="extras_claim.php?thanks">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<input type="hidden" name="name" value="<?php echo $row[name]; ?>" />
		<input type="hidden" name="email" value="<?php echo $row[email]; ?>" />
		<input type="hidden" name="url" value="<?php echo $row[url]; ?>" />
		<center><table width="60%">
		<tr><td><b>Claiming:</b></td><td><select name="filename">
		<option value="">-----</option>
		<?php
		$query="SELECT * FROM `cardclaims` ORDER BY filename ASC";
		$result=mysql_query($query);
	
		while($row3=mysql_fetch_assoc($result)) {
			$name=stripslashes($row3['filename']);
			echo "<option value=\"$name\">$name</option>\n";
		}
		?>
		</select></td>
		<td><input type="submit" name="submit" value=" Send! " class="button" /></td></tr>
		</table>
		</form></center>
		<br /><br />
		
		<center><div id="decks">
		<?php
		$query="SELECT * FROM `cardclaims` ORDER BY filename ASC";
		$result=mysql_query($query);
	
		while($row2=mysql_fetch_assoc($result)) {
			$name=stripslashes($row2['filename']);
			echo "<img src=\"$tcgcardurl";
			echo "$name";
			echo ".png\" alt=\"$name\" title=\"$name\"> ";
		}
		?></div></center>
		<br><br>

		<h2>Log</h2>
		<?php echo "<center><textarea style=\"width:96%\" rows=6>";
		$query="SELECT * FROM `cardclaimslog` ORDER BY id DESC";
		$result=mysql_query($query);
	
		while($row4=mysql_fetch_assoc($result)) {
			$log=stripslashes($row4['log']);
			echo "$log\n";
		}
		echo "</textarea></center>";
		?>
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
			
			if (!ereg("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,6})$",strtolower($_POST['email']))) {
				exit("<h1>Error</h1>\nThat e-mail address is not valid, please use another.<br /><br />");
			}

		    $filename = escape_sql(CleanUp($_POST['filename']));
		    $name = escape_sql(CleanUp($_POST['name']));

			$delete = "DELETE FROM `cardclaims` WHERE filename='$filename'";


					$date = date("F j, Y");
					
					$log = "".$date." - ".$name." claimed ".$filename.".";

			mysql_query("INSERT cardclaimslog SET log='$log'");
	
				if(mysql_query($delete, $connect)) {
					$name = $_POST[name];
					$date = date("m/d/y");
					$thefile = "/home/secretss/public_html/memlogs/$name.txt";
					$towrite = "<b>Card Claim:</b> {$_POST['filename']}";
					$towrite .= "<br />";
					$openedfile = fopen($thefile, "a");
					fwrite($openedfile, $towrite);
				?>
				<h1>Card Claim</h1>
				<center>Here is your card. Want to <a href="extras_claim.php">claim another?</a><br>
				<?php
				echo "<img src=\"/cards/";
				echo "{$_POST['filename']}";
				echo ".png\"><br>";
				echo "<b>Card Claim:</b> {$_POST['filename']}";
				?>
				</center>
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
include("$footer"); ?>