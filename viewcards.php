<?php include("mytcg/settings.php");
ob_start();
include("$header");
$deck = $_GET['deck'];
$query="SELECT * FROM `$table_cards` WHERE filename='$deck'";
$result=mysql_query($query);
while($row=mysql_fetch_assoc($result)) {
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Viewing $row[deckname] | Wild Thing",$buffer);
echo $buffer;
	?>
	<h1><a href="/cards.php">Cards</a> &gt; <a href="/viewset.php?set=<?php echo $row[set1]; ?>"><?php echo $row[set1]; ?></a> &gt; <?php echo $row[deckname]; ?></h1>
	<table width="100%">
	<tr><td valign="top" width="80%"><b>Deck Name:</b> <?php echo "$row[deckname]"; ?> (<?php echo "$row[filename]"; ?>)<br />
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
	<b>Masterable?</b> <?php echo "$row[masterable]"; ?>
	</td><td width="20%" valign="top" align="center"><?php echo "<img src=\"$tcgcardurl$deck";
	echo "00.$ext\" />"; ?></td></tr>
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
	
echo "</div></center><h2>Masters</h2>";
echo "<table width=\"100%\" align=\"center\"><tr>";
echo "<td width=\"80%\" valign=\"top\" align=\"left\"><?php echo \"$row[masters]\"; ?></td>";
echo "<td width=\"20%\" valign=\"top\" align=\"right\"><img src=\"$tcgcardurl$deck-master.$ext\" /></td>";
echo "</tr></table>";
}
include("$footer"); ?>