<?php session_start();if (isset($_SESSION['USR_LOGIN'])=="") {	header("Location:login.php");}
include("mytcg/settings.php");include("$header");
$game = $_GET['game'];

$select=mysql_query("SELECT * FROM `$table_games` WHERE id='$game'");
while($row=mysql_fetch_assoc($select)) {
	$name = stripslashes($row[name]);
	$description = stripslashes($row[description]);
	$clue = stripslashes($row[pass_clue]);
	$answer = stripslashes($row[pass_answer]);
	$extras = stripslashes($row[extras]);
	if(!isset($_POST['submit'])) {
		?>
		<h1><?php echo $name; ?></h1>
		<?php echo $description; ?>
		<br /><br />
		<center>
		<?php
		if($row[pass_type]=="image") {
			echo "<img src=\"$clue\" />";
		}
		else {
			echo $clue;
		}
		?>
		<br /><br />
		<form method="post" action="viewgame.php?game=<?php echo $row[id]; ?>">
		<?php
		$regular=$row[regular];
		$special=$row[special];
		if($regular!=0) {
			for($i=1; $i<=$regular; $i++) {
				$randtype = 'regular';
				echo "<input type=\"hidden\" name=\"random$i\" value=\"";
				include ("mytcg/random.php");
				echo "\" />\n";
			}
		}
		if($special!=0) {
			for($i=1; $i<=$special; $i++) {
				$randtype = 'special';
				echo "<input type=\"hidden\" name=\"special$i\" value=\"";
				include ("mytcg/random.php");
				echo "\" />\n";
			}
		}
		?>
		<input type="text" name="guess" /> 
		<input type="submit" value=" Guess! " name="submit" />
		</form>
		</center>
		<?php
	}

	else {
		if($_POST['guess']=="$row[password]") {
			$select2 = mysql_query("SELECT * FROM `$table_members` WHERE email='$_SESSION[USR_LOGIN]'");
			while($row2=mysql_fetch_assoc($select2)) {
				$name2=$row2[name];
				$thefile = "$name2.txt"; /* Our filename as defined earlier */				$towrite = "<b>$name:</b>";				if($row[regular]!=0) {
					for($i=1; $i<=$row[regular]; $i++) {
						$card = "random$i";
						$towrite .= $_POST[$card];
						$towrite .= ", ";
					}
				}
				if($row[special]!=0) {
					for($i=1; $i<=$row[special]; $i++) {
						$card = "special$i";
						$towrite .= $_POST[$card];
						$towrite .= ", ";
					}
				}
				$towrite .= "<br />";
				$openedfile = fopen($thefile, "a");
				fwrite($openedfile, $towrite);
			}
			?>
			<h1>Correct!</h1>
			Congrats, <?php echo $answer; ?> is the correct answer! Take everything you see below:
			<br /><br />
			<?php
			if($row[regular]!=0) {
				for($i=1; $i<=$row[regular]; $i++) {
					$card = "random$i";
					echo "<img src=\"$tcgcardurl";
					echo $_POST[$card];
					echo ".$ext\" />\n";
				}
			}
			if($row[special]!=0) {
				for($i=1; $i<=$row[special]; $i++) {
					$card = "special$i";
					echo "<img src=\"$tcgcardurl";
					echo $_POST[$card];
					echo ".$ext\" />\n";
				}
			}
			if($extras!="") {
				echo $extras;
			}
			?>
			<br /><br />
			<b><?php echo $name; ?>:</b> <?php
			if($row[regular]!=0) {
				for($i=1; $i<=$row[regular]; $i++) {
					$card = "random$i";
					echo $_POST[$card];
					echo ", ";
				}
			}
			if($row[special]!=0) {
				for($i=1; $i<=$row[special]; $i++) {
					$card = "special$i";
					echo $_POST[$card];
					echo ", ";
				}
			}
		}
		else {
			?>
			<h1>Oops!</h1>
			Oops, that isn't the correct answer. Why don't you go back and try again?
			<?php
		}
	}
}
include($footer); ?>