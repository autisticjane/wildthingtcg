<?php session_start();if (isset($_SESSION['USR_LOGIN'])=="") {	header("Location:login.php");}
include("mytcg/settings.php");include("$header");

if(!$_SERVER['QUERY_STRING']) {
	$select = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
	while($row=mysql_fetch_assoc($select)) {
		?>
		<h1>Master Form</h1>
		Congratulations on collecting enough cards to master a deck! Fill out the form below to receive your rewards. <b>Please fill out one form for each mastered deck!</b>
		<br /><br />
	
		<form method="post" action="forms_master.php?thanks">
		<input type="hidden" name="id" value="<?php echo $row[id]; ?>" />
		<input type="hidden" name="name" value="<?php echo $row[name]; ?>" />
		<input type="hidden" name="email" value="<?php echo $row[email]; ?>" />
		<?php
		for($i=1; $i<=$num_masreg; $i++) {
			$randtype = 'regular';
			echo "<input type=\"hidden\" name=\"random$i\" value=\"";
			include ("mytcg/random.php");
			echo "\" />\n";
		}
		if($num_masspc!=0) {
			for($i=1; $i<=$num_masspc; $i++) {
				$randtype = 'special';
				echo "<input type=\"hidden\" name=\"special$i\" value=\"";
					include ("mytcg/random.php");
				echo "\" />\n";
			}
		}
		?>
		<table>
		<tr><td>Mastered:</td><td><select name="mastered">
		<option value="">-----</option>
		<?php
		$select2=mysql_query("SELECT * FROM `$table_cards` WHERE masterable='Yes' ORDER BY filename ASC");
		while($row2=mysql_fetch_assoc($select2)) {
			echo "<option value=\"$row2[filename]\">$row2[description] ($row2[filename])</option>\n";
		}
		?>
		</select></td></tr>
		<tr><td>Now Collecting:</td><td><select name="new">
		<option value="">-----</option>
		<?php
		$select3=mysql_query("SELECT * FROM `$table_cards` WHERE masterable='Yes' ORDER BY filename ASC");
		while($row3=mysql_fetch_assoc($select3)) {
			echo "<option value=\"$row3[filename]\">$row3[description] ($row3[filename])</option>\n";
		}
		?>
		</select></td></tr>
		<tr><td valign="top">Choice Card:</td><td><?php
		for($i=1; $i<=$num_maschoice; $i++) {
			echo "<select name=\"choice$i\">\n";
			echo "<option value=\"\">---</option>\n";
			$query="SELECT * FROM `$table_cards` WHERE masterable='Yes' ORDER BY filename ASC";
			$result=mysql_query($query);

			while($row2=mysql_fetch_assoc($result)) {
				$filename=stripslashes($row2['filename']);
				echo "<option value=\"$filename\">$row2[description] ($filename)</option>\n";
			}
			echo "</select> <input type=\"text\" name=\"choicenum$i\" value=\"00\" size=\"4\" maxlength=\"2\" /><br />";
		}
		echo "</td></tr>\n";
		?>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Level Up! " /></td></tr>
		</table>
		</form>
		<?php
	}
}

elseif($_SERVER['QUERY_STRING']=="thanks") {
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
			
			$id = escape_sql(CleanUp($_POST['id']));
			$name = escape_sql(CleanUp($_POST['name']));
			$email = escape_sql(CleanUp($_POST['email']));
			$mastered = escape_sql(CleanUp($_POST['mastered']));
			$new = escape_sql(CleanUp($_POST['new']));
			
			$selectmas=mysql_query("SELECT * FROM `$table_members` WHERE id='$id'");
			while($rowmas=mysql_fetch_assoc($selectmas)) {
				if($rowmas[mastered]!="None") {
					$mast1="$rowmas[mastered], ";
				}
				else {
					$mast1="";
				}
			}

			$update = "UPDATE `$table_members` SET collecting='$new', mastered='$mast1$mastered' WHERE id='$id'";

			$selectmas2=mysql_query("SELECT * FROM `$table_cards` WHERE filename='$mastered'");
			while($rowmas2=mysql_fetch_assoc($selectmas2)) {
				if($rowmas2[masters]!="None") {
					$mast2="$rowmas2[masters], ";
				}
				else {
					$mast2="";
				}
			}

			$update2 = "UPDATE `$table_cards` SET masters='$mast2$name' WHERE filename='$mastered'";
			mysql_query($update2, $connect);

			$recipient = "$tcgemail";
			$subject = "Master Form";
			
			$message = "The following member has mastered a deck: \n";
			$message .= "Name: $name \n";
			$message .= "Email: $email \n";
			$message .= "Mastered: $mastered \n";
			$message .= "Now Collecting: $new \n";
			
			$headers = "From: $name <$email> \n";
			$headers .= "Reply-To: <$email>";

			$recipient2 = "$email";
			$subject2 = "$tcgname: Mastered $mastered Rewards";
			
			$message2 = "Congrats on mastered $mastered at $tcgname! Although you probably already picked up your rewards on the site, this copy has been sent to you as well in case you didn't or if you need to restore your card log.\n";
			for($i=1; $i<=$num_maschoice; $i++) {
				$card = "choice$i";
				$card2 = "choicenum$i";
				$message2 .= "$tcgcardurl";
				$message2 .= $_POST[$card];
				$message2 .= $_POST[$card2];
				$message2 .= ".$ext\n";
			}
			for($i=1; $i<=$num_masreg; $i++) {
				$card = "random$i";
				$message2 .= "$tcgcardurl";
				$message2 .= $_POST[$card];
				$message2 .= ".$ext\n";
			}
			if($num_masspc!=0) {
				for($i=1; $i<=$num_masspc; $i++) {
					$card = "special$i";
					$message2 .= "$tcgcardurl";
					$message2 .= $_POST[$card];
					$message2 .= ".$ext\n";
				}
			}
			$message2 .= "\nCongrats again and happy trading!\n";
			$message2 .= "-- $tcgowner\n";
			$message2 .= "$tcgname: $tcgurl\n";
			
			$headers2 = "From: $tcgname <$tcgemail> \n";
			$headers2 .= "Reply-To: <$tcgemail>";

			
			if (mail($recipient,$subject,$message,$headers)) {
				if(mysql_query($update, $connect)) {
					$thefile = "$name.txt";					$towrite = "<i>Mastered $mastered:</i>";
					for($i=1; $i<=$num_maschoice; $i++) {
						$card = "choice$i";
						$card2 = "choicenum$i";
						$towrite .= $_POST[$card];
						$towrite .= $_POST[$card2];
						$towrite .= ", ";
					}
					for($i=1; $i<=$num_masreg; $i++) {
						$card = "random$i";
						$towrite .= $_POST[$card];
						$towrite .= ", ";
					}
					if($num_masspc!=0) {
						for($i=1; $i<=$num_masspc; $i++) {
							$card = "special$i";
							$towrite .= $_POST[$card];
							$towrite .= ", ";
						}
					}
					$towrite .= "<br />";
					$openedfile = fopen($thefile, "a");
					fwrite($openedfile, $towrite);
					mail($recipient2,$subject2,$message2,$headers2);
					?>
					<h1>Congrats!</h1>
					Congrats on mastering <?php echo $mastered; ?>, <?php echo $name; ?>! Here are your rewards. If you have mastered more than one deck, please do not use the back button to fill out another form (you will receive the same random cards if you do). A copy of these rewards have been emailed to you.
					<br /><br />
				
					<center>
					<?php
					for($i=1; $i<=$num_maschoice; $i++) {
						$card = "choice$i";
						$card2 = "choicenum$i";
						echo "<img src=\"$tcgcardurl";
						echo $_POST[$card];
						echo $_POST[$card2];
						echo ".$ext\" />\n";
					}

					for($i=1; $i<=$num_masreg; $i++) {
						$card = "random$i";
						echo "<img src=\"$tcgcardurl";
						echo $_POST[$card];
						echo ".$ext\" />\n";
					}
					if($num_masspc!=0) {
						for($i=1; $i<=$num_masspc; $i++) {
							$card = "special$i";
							echo "<img src=\"$tcgcardurl";
							echo $_POST[$card];
							echo ".$ext\" />\n";
						}
					}
					?>
					</center>
					<br /><br />
					<b>Mastered <?php echo $mastered; ?>:</b> <?php
					for($i=1; $i<=$num_maschoice; $i++) {
						$card = "choice$i";
						$card2 = "choicenum$i";
						echo $_POST[$card];
						echo $_POST[$card2];
						echo ", ";
					}
					for($i=1; $i<=$num_masreg; $i++) {
						$card = "random$i";
						echo $_POST[$card];
						echo ", ";
					}
					if($num_masspc!=0) {
						for($i=1; $i<=$num_masspc; $i++) {
							$card = "special$i";
							echo $_POST[$card];
							echo ", ";
						}
					}
				}
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your level up form. Send the information to <?php echo $tcgemail; ?> and we will send you your rewards ASAP. Thank you and sorry for the inconvenience.
				<?php
			}
	}
}

include("$footer"); ?>