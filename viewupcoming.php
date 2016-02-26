<?php include("mytcg/settings.php");
ob_start();
include("$header");
$deck = $_GET['deck'];
$query="SELECT * FROM `$table_upcoming` WHERE filename='$deck'";
$result=mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Viewing $row[deckname] | Wild Thing",$buffer);
echo $buffer;
	?>
	<h1><a href="/upcoming.php">Upcoming cards</a> &gt; <?php echo $row[deckname]; ?></h1>
	<table width="100%">
	<tr><td valign="top" width="50%"><b>Deck Name:</b> <?php echo "$row[deckname]"; ?> (<?php echo "$row[filename]"; ?>)<br />
	<b>#/$:</b> <?php
	if($row[filename]=="member") {
		$select2 = mysql_query("SELECT * FROM `$table_members` WHERE `membercard`='Yes'");
		$memnum = mysql_num_rows($select2);
		echo "$memnum";
	}
	else {
		echo "$row[count]";
	}
	?>/<?php echo "$row[worth]"; ?><br />
	<b>Season:</b> <?php echo "$row[season]"; ?><br />
	<strong>Donated:</strong> <?php echo "$row[Donated]"; ?><br />
	<b>Masterable?</b> <?php echo "$row[masterable]"; ?><br />
	<b>Masters:</b> <?php echo "$row[masters]"; ?>
	</td><td valign="top" align="right" width="50%"><?php echo "<img src=\"$tcgcardurl"."$deck";echo "00.$ext\" />";; ?> <?php echo "<img src=\"$tcgcardurl"."$deck";echo "-master.$ext\" />";; ?>
	</td></tr>
	</table><blockquote><?php echo "$row[description]"; ?></blockquote>
	
	<center><div id="decks">
	<?php
	if($deck=="member") {
		$query2 = "SELECT * FROM $table_members WHERE `membercard`='Yes' ORDER BY `name`";
		$result2=mysql_query($query2);
		while($row2=mysql_fetch_assoc($result2)) {
			echo "<img src=\"/cards/mc-$row2[name].$ext\" />\n";
		}
	}
	else {
		for($x=1;$x<=$row[count];$x++) {
			if($x<10) {
				echo "<img src=\"$tcgcardurl$row[filename]";
				echo "0";
				echo "$x.$ext\" />\n";
			}
			else {
				echo "<img src=\"$tcgcardurl$row[filename]$x.$ext\" />\n";
			}
		}
	}
	
echo "</div></center>";
}
include("$footer"); ?>