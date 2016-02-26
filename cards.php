<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Cards | Wild Thing",$buffer);
echo $buffer;?>
	<table width="100%" class="wildthing" align="center"><td width="20%"><a href="/cards.php">sets</a></td><td width="20%"><a href="?abcsets">sets list</a></td><td width="20%"><a href="?alpha">decks abc</a></td><td width="20%"><a href="/upcoming.php">upcoming</a></td><td width="20%"><a href="?fillers">fillers</a></td></table>
<?php
if (!$_SERVER['QUERY_STRING']) { ?>

	<h1>Cards</h1>
	<?php
			echo "<p class=\"center\">";
			$select = mysql_query("SELECT set1, COUNT(deckname) FROM `$table_cards` WHERE NOT (set1='Other') GROUP BY set1");
			while($row= mysql_fetch_array($select)) {
				echo "<a href=\"viewset.php?set=$row[set1]\"><img src=\"/images/covers/sets/$row[set1].png\" alt=\"$row[set1]\" title=\"$row[set1]\" /></a>";
				if($row[filename]=="member") {
					$select2 = mysql_query("SELECT * FROM `$table_members` WHERE `membercard`='Yes'");
					$memnum = mysql_num_rows($select2);
					echo "$memnum/0";
				}
			
				echo " ";
			}
			echo "</p>";
} elseif ($_SERVER['QUERY_STRING'] == "alpha") { ?>
	<h1><a href="/cards.php">Cards</a> &gt; Alphabetically</h1>

	
	<table width="100%" class="wildthing">
	<tr><th width="21%">Series</th><th width="14%">Type</th><th width="40%">Deck</th><th width="25%">Filename</th></tr>
	<?php
	$select = mysql_query("SELECT * FROM `$table_cards` ORDER BY `set1`, `category`, `season`, `deckname`, `filename`");
	while($row=mysql_fetch_assoc($select)) {
	$catnum = $row[category];
		echo "<tr><td><a href=\"viewset.php?set=$row[set1]\">$row[set1]</a></td><td>$category[$catnum]</td><td>$row[deckname]</td><td><a href=\"viewcards.php?deck=$row[filename]\">$row[filename]</a>";
		}
		echo "</td></tr>\n";
	echo "</table>\n";
} elseif ($_SERVER['QUERY_STRING'] == "abcsets") { ?>
<?php ?>
	<h1><a href="/cards.php">Cards</a> &gt; Sets list (table)</h1>
	<table width="100%" align="center" class="wildthing">
	<tr><th width="95%">Set name</th><th width="5%" class="alignright">#</th></tr>
<?php
		$select = mysql_query("SELECT set1, COUNT(deckname) FROM `$table_cards` GROUP BY set1");
	while($row=mysql_fetch_assoc($select)) {
		echo "<tr><td><a href=\"viewset.php?set=$row[set1]\">$row[set1]</a></td><td class=\"alignright\">";
			$select_setcount = mysql_query("SELECT * FROM `$table_cards` WHERE set1='$row[set1]'"); $num_cards3 = mysql_num_rows($select_setcount); echo $num_cards3;
		echo "</td></tr>\n";
	}
	echo "</table>\n";
} elseif ($_SERVER['QUERY_STRING'] == "fillers") { ?>
<h1><a href="/cards.php">Cards</a> &gt; Fillers</h1>
<p class="center"><img src="/cards/blank.png" alt="blank" title="blank" /> <img src="/cards/filler.png" alt="filler" title="filler" /> <img src="/cards/pending.png" alt="pending" title="pending" /></p>
<?php }
include("$footer"); ?>