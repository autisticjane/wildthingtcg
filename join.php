<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Join | Wild Thing",$buffer);
echo $buffer;
if(!$_SERVER['QUERY_STRING']) {
	?>
	<h1>Rules</h1>
	<ul>
		<li>You need a valid email address and website.</li>
		<li>Additionally, you must be at least <strong>13</strong> (thirteen) years of age to join.</li>
		<li>You must use a realistic name or nickname. If your name is already taken on the member list, please add a number or change your name. Profanity and sTiCkY cApS are unacceptable in usernames.</li>
		<li>You must upload your starter pack with <strong>2</strong> (two) weeks. If you need more time, please let us know. You will not be accepted until your starter pack is up.</li>
		<!--<li>You must update your trade post at least once per month. After two months of inactivity, your status will be changed to <strong>inactive</strong>, and you will have <strong>3</strong> (three months) to reactivate your membership to continue playing and not lose your account. If you do not reactivate your account within three months after being moved to the Inactive list, you'll be moved to the Troubled list and your account prepared for deletion. If you're going to be away/can't update on time, change your status to Hiatus or Semi-Active. You may continue playing and trading whilst on hiatus, if you wish. More info on activity may be found <a href="/info.php?activity">here</a>.</li>-->
		<li>You <strong>may</strong> direct link cards. Should this prove to be problematic in the future, this rule will be ammended.</li>
		<li><a href="/info.php?basics">I don't care if you cheat.</a> I've owned multiple TCGs, and this isn't a battle I want in owning future ones. If you choose to cheat the game, you'll ruin the fun for yourself. If you're doing it because you love the risk of getting caught, well&hellip;obviously, it doesn't exist here.</li>
		<li>You must provide a password to gain access to the form and interactive section. This password is encoded in the database and cannot be retrieved or viewed by anyone&mdash;even the administrators of this TCG. For your security, and for the TCG's security as a whole, please make this password unique to this site and <em>not</em> something you also use elsewhere.</li>
	</ul>
	
	
	<h2>Join</h2>
	<form method="post" action="join.php?thanks">
	<input type="hidden" name="status" value="Pending" />
	<input type="hidden" name="level" value="1" />
	<input type="hidden" name="membercard" value="No" />
	<input type="hidden" name="mastered" value="None" />
	<input type="hidden" name="wishlist" value="Coming Soon" />
	<input type="hidden" name="biography" value="Coming Soon" />
	<?php
	for($i=1; $i<=$num_startchoice; $i++) {
		$digit=$digits[array_rand($digits,1)];
		echo "<input type=\"hidden\" name=\"choice$i\" value=\"$digit\" />\n";
	}
	for($i=1; $i<=$num_startreg; $i++) {
		$randtype = 'regular';
		echo "<input type=\"hidden\" name=\"random$i\" value=\"";
			include ("mytcg/random.php");
		echo "\" />\n";
	}
	if($num_startspc!=0) {
		for($i=1; $i<=$num_startspc; $i++) {
			$randtype = 'special';
			echo "<input type=\"hidden\" name=\"special$i\" value=\"";
				include ("mytcg/random.php");
			echo "\" />\n";
		}
	}
	?>
	<table width="100%">
	<tr><td>Name:</td><td><input type="text" name="name" value="" /></td></tr>
	<tr><td>Email:</td><td><input type="text" name="email" value="" /></td></tr>
	<tr><td>Trade Post:</td><td><input type="text" name="url" value="http://" /></td></tr>
	<tr><td>Collecting:</td><td><select name="collecting">
	<option value="">-----</option>
	<?php
	$query="SELECT * FROM `$table_cards` WHERE worth='1' ORDER BY description ASC";
	$result=mysql_query($query);

	while($row=mysql_fetch_assoc($result)) {
		$name=stripslashes($row['filename']);
		$description=stripslashes($row['deckname']);
		echo "<option value=\"$name\">$description ($name)</option>\n";
	}
	?>
	</select></td></tr>
	<tr><td>Referral:</td><td><input type="text" name="refer" value="" /></td></tr>	
	<tr><td>Birthday:</td><td><select name="birthday">
	<option value="None">-----</option>
	<option value="January">January</option>
	<option value="February">February</option>
	<option value="March">March</option>
	<option value="April">April</option>
	<option value="May">May</option>
	<option value="June">June</option>
	<option value="July">July</option>
	<option value="August">August</option>
	<option value="September">September</option>
	<option value="October">October</option>
	<option value="November">November</option>
	<option value="December">December</option>
	</select></td></tr>	
	<tr><td valign="top">Password:<br />
	(type twice)</td><td><input type="password" name="password" value="" /><br />
	<input type="password" name="password2" value="" /></td></tr>	
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Join! " /></td></tr>
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
		$profanity = "/(beastial|bestial|blowjob|clit|cum|cunilingus|cunillingus|cunnilingus|cunt|ejaculate|fag|felatio|fellatio|fuk|fuks|gangbang|gangbanged|gangbangs|hotsex|jism|jiz|kock|kondum|kum|kunilingus|orgasim|orgasims|orgasm|orgasms|phonesex|phuk|phuq|porn|pussies|pussy|spunk|xxx)/i";
		$spamwords = "/(viagra|phentermine|tramadol|adipex|advai|alprazolam|ambien|ambian|amoxicillin|antivert|blackjack|backgammon|texas|holdem|poker|carisoprodol|ciara|ciprofloxacin|debt|dating|porn)/i";
		$bots = "/(Indy|Blaiz|Java|libwww-perl|Python|OutfoxBot|User-Agent|PycURL|AlphaServer)/i";
		
		if (preg_match($bots, $_SERVER['HTTP_USER_AGENT'])) {
			exit("<h1>Error</h1>\nKnown spam bots are not allowed.<br /><br />");
		}
		foreach ($_POST as $key => $value) {
			$value = trim($value);
			$check1=mysql_query("SELECT * FROM `$table_members` WHERE email='$_POST[email]'");
			$num_check1=mysql_num_rows($check1);
			$check2=mysql_query("SELECT * FROM `$table_members` WHERE name='$_POST[name]'");
			$num_check2=mysql_num_rows($check2);

			if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['url']) || empty($_POST['collecting'])) {
				exit("<h1>Error</h1>\nYou must provide your name, email, url, and collecting deck. Please go back and fill in the form properly.<br /><br />");
			}
			elseif (preg_match($exploits, $value)) {
				exit("<h1>Error</h1>\nExploits/malicious scripting attributes aren't allowed.<br /><br />");
			}
			elseif (preg_match($profanity, $value) || preg_match($spamwords, $value)) {
				exit("<h1>Error</h1>\nThat kind of language is not allowed through our form.<br /><br />");
			}
			elseif ($_POST[password2]!=$_POST[password]) {
				exit("<h1>Error</h1>\nThe passwords you entered do not match, please go back and make sure they are they same.");
			}
			elseif ($num_check1!=0) {
				exit("<h1>Error</h1>\nSomeone has already signed up with that email address. Please go back and use another email address. If you are a current member and have lost your password, please <a href=\"/lostpass.php\">reset</a> your password.");
			}
			elseif ($num_check2!=0) {
				exit("<h1>Error</h1>\nSomeone has already joined $tcgname with that name. Please go back and use another name.");
			}
				
			$_POST[$key] = stripslashes(strip_tags($value));
		}
			
		if (!ereg("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,6})$",strtolower($_POST['email']))) {
			exit("<h1>Error</h1>\nThat e-mail address is not valid, please use another.<br /><br />");
		}
		
			$name = escape_sql(CleanUp($_POST['name']));
			$email = escape_sql(CleanUp($_POST['email']));
			$url = escape_sql(CleanUp($_POST['url']));
			$birthday = escape_sql(CleanUp($_POST['birthday']));
			$referral = escape_sql(CleanUp($_POST['refer']));
			$password = md5(escape_sql(CleanUp($_POST['password'])));
			$password2 = escape_sql(CleanUp($_POST['password2']));
			$status = escape_sql(CleanUp($_POST['status']));
			$level = escape_sql(CleanUp($_POST['level']));
			$collecting = escape_sql(CleanUp($_POST['collecting']));
			$membercard = escape_sql(CleanUp($_POST['membercard']));
			$mastered = escape_sql(CleanUp($_POST['mastered']));
			$wishlist = escape_sql(CleanUp($_POST['wishlist']));
			$biography = escape_sql(CleanUp($_POST['biography']));

			$recipient = "$tcgemail";
			$subject = "Join Form";
			
			$message = "The following member has joined $tcgname: \n";
			$message .= "Name: $name \n";
			$message .= "Email: $email \n";
			$message .= "Trade Post: $url \n";
			$message .= "Collecting: $collecting \n";
			$message .= "Referral: $referral \n";
			$message .= "Birthday: $birthday \n\n";
			$message .= "To add them to the approved member list, go to your admin panel. ($tcgurl/admin/login.php)\n";
			
			$headers = "From: $name <$email> \n";
			$headers .= "Reply-To: $name <$email>";
			
			$insert = "INSERT INTO `$table_members` (`id`, `name`, `email`, `url`, `birthday`, `password`, `status`, `level`, `collecting`, `membercard`, `mastered`, `wishlist`, `biography`) VALUES ('', '$name', '$email', '$url', '$birthday', '$password', '$status', '$level', '$collecting', '$membercard', '$mastered', '$wishlist', '$biography')";
			
			if (mail($recipient,$subject,$message,$headers)) {
				if(mysql_query($insert, $connect)) {
				?>
				<h1>Welcome!</h1>
				Welcome to <?php echo $tcgname; ?>! Below is your starter pack. Once your trading post and starter pack are up, you may go ahead and start trading and playing games, but you can take cards from updates posted on or after <?php echo date("j F, Y"); ?>.
				
				<center>
				<?php
				for($i=1; $i<=$num_startchoice; $i++) {
					$card = "choice$i";
					echo "<img src=\"$tcgcardurl$collecting";
					echo $_POST[$card];
					echo ".$ext\" />\n";
					}
				for($i=1; $i<=$num_startreg; $i++) {
					$card = "random$i";
					echo "<img src=\"$tcgcardurl";
					echo $_POST[$card];
					echo ".$ext\" />\n";
				}
				if($num_startspc!=0) {
					for($i=1; $i<=$num_startspc; $i++) {
						$card = "special$i";
						echo "<img src=\"$tcgcardurl";
						echo $_POST[$card];
						echo ".$ext\" />\n";
					}
				}
				?>
				<br /><br />
				<b>Starter Pack:</b> <?php
				for($i=1; $i<=$num_startchoice; $i++) {
					$card = "choice$i";
					echo $collecting;
					echo $_POST[$card];
					echo ", ";
				}
				for($i=1; $i<=$num_startreg; $i++) {
					$card = "random$i";
					echo $_POST[$card];
					echo ", ";
				}
				if($num_startspc!=0) {
					for($i=1; $i<=$num_startspc; $i++) {
						$card = "special$i";
						echo $_POST[$card];
						echo ", ";
					}
				}
				?>
				</center>
				<?php
				$recipient2 = "$email";
				$subject2 = "$tcgname: Starter Pack";
			
				$message2 = "Thanks for joining $tcgname, $name! We are very excited that you are going to be joining us. Your account is currently pending approval. You may go ahead and start playing games and trading with other players once your starter pack is up. Below is a copy of your starter pack, in case you did not pick it up from the site. \n\n";
				for($i=1; $i<=$num_startchoice; $i++) {
					$card = "choice$i";
					$message2 .= "$tcgcardurl$collecting";
					$message2 .= $_POST[$card];
					$message2 .= ".$ext\n";
				}
				for($i=1; $i<=$num_startreg; $i++) {
					$card = "random$i";
					$message2 .= "$tcgcardurl";
					$message2 .= $_POST[$card];
					$message2 .= ".$ext\n";
				}
				if($num_startspc!=0) {
					for($i=1; $i<=$num_startspc; $i++) {
						$card = "special$i";
						$message2 .= "$tcgcardurl";
						$message2 .= $_POST[$card];
						$message2 .= ".$ext\n";
					}
				}
				$message2 .= "\nThanks again for joining and happy trading!\n\n";
				$message2 .= "-- $tcgowner\n";
				$message2 .= "$tcgname: $tcgurl\n";
			
				$headers2 = "From: $tcgname <$tcgemail> \n";
				$headers2 .= "Reply-To: $tcgname <$tcgemail>";
				
				mail($recipient2,$subject2,$message2,$headers2);
			}
			else {
				?>
				<h1>Error</h1>
				It looks like there was an error in processing your join form. Send the information to <?php echo $tcgemail; ?> and we will send you your starter pack ASAP. Thank you and sorry for the inconvenience.
				<?php
			}
	}
	}
}

include("$footer"); ?>