<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Upcoming Cards | Wild Thing",$buffer);
echo $buffer;?>
<table width="100%" class="wildthing" align="center"><td width="20%"><a href="/cards.php">sets</a></td><td width="20%"><a href="/cards.php?abcsets">sets list</a></td><td width="20%"><a href="/cards.php?alpha">decks abc</a></td><td width="20%"><a href="/upcoming.php">upcoming</a></td><td width="20%"><a href="/cards.php?fillers">fillers</a></td></table>
<h1>Upcoming Cards</h1>
<p>Decks with a &#10003; after the category are completed decks/decks I have the images for that are waiting to be made.</p>

<p>There is a total of <?php
$select_count = mysql_query("SELECT * FROM `$table_upcoming` WHERE ip='c'");
$num_cards = mysql_num_rows($select_count);
?><b><?php echo $num_cards; ?></b> unreleased decks.</p>

<h2>Recently made</h2>
	<div class="center"> <?php $resultnd=mysql_query("SELECT `filename` FROM `$table_upcoming` WHERE worth='1' ORDER BY id DESC LIMIT 5"); while($rownd=mysql_fetch_array($resultnd)) {echo "<a href=\"viewupcoming.php?deck=$rownd[filename]\"><img src=\"$tcgcardurl$rownd[filename]" . $digits[array_rand($digits,1)] . ".png\" border=\"0\" style=\"padding: 0px;\" /></a> "; } ?></div>

<h2>Deck list</h2>
<?php
$select2 = mysql_query("SELECT * FROM `$table_upcoming` ORDER BY `category`, `description`, `deckname`, `season`, `filename`");
$count = mysql_num_rows($select2);

if($count==0) {
}
else {
	echo "<table width=\"100%\" class=\"wildthing\">\n";
	echo "<tr><th width=\"15%\">Category</th><th width=\"30%\">Filename</th><th width=\"50%\">Deck name</td><th width=\"5%\" class=\"alignright\"><abbr title=\"In progress\">IP?</abbr></th></tr>\n";
	while($row2=mysql_fetch_assoc($select2)) {
		$categories=$row2[category];
		echo "<tr><td>$category[$categories]</td><td><a href=\"viewupcoming.php?deck=$row2[filename]\">$row2[filename]</a></td><td>$row2[deckname]</td>";
		if ($row2[count] != 0 or $row2[worth] != 0) {
			echo "<td class=\"alignright\">&#10003;</td></tr>\n";
		}
		else {
			echo "<td class=\"alignright\">-</td></tr>\n";
		}
	}
	echo "</table>\n";
	echo "<br /><br />\n";
}

include("$footer"); ?>