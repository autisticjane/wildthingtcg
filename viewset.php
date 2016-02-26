<?php 
include("mytcg/settings.php"); 
ob_start();
include("$header");
$set = $_GET['set'];
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","$set | Wild Thing",$buffer);
echo $buffer;
?> 

<div class="right"><img src="/images/covers/sets/<?php echo $set ?>.png" alt="<?php echo $set ?>" /></div><h1><a href="/cards.php">Cards</a> &gt; <?php echo $set ?></h1>
<p>If you don't see a deck you'd like to collect, and it's not on the <a href="/upcoming.php">upcoming</a> list, <a href="info.php?donations">donate</a> it! Make sure to also check the <a href="/cards.php?alpha">alphabetical</a> list.</p>
<p class="clear"></p>
<blockquote>There are <strong><?php $select_setcount = mysql_query("SELECT * FROM `$table_cards` WHERE set1='$set'"); $num_cards3 = mysql_num_rows($select_setcount); echo $num_cards3; ?></strong> released in this set. <strong><?php $select_setcount1 = mysql_query("SELECT * FROM `$table_upcoming` WHERE description='$set'"); $num_cards4 = mysql_num_rows($select_setcount1); echo $num_cards4; ?></strong> additional decks for this set are pending release.</blockquote>
<?php 
for($i=1; $i<=$num_categories; $i++) { 
$catnum = $i; 
$select = mysql_query("SELECT * FROM `cards` WHERE `category`='$catnum' AND `set1`='$set' ORDER BY `category`, `season`, `deckname`, `filename`");
$count = mysql_num_rows($select); 

		if($count==0) {} else {
				if($set=="Other"){}
		else {echo "<h2>$category[$i]</h2>\n";}
	echo "<table width=\"100%\" class=\"wildthing\">\n"; 
	echo "<tr><th width=\"45%\">Deck</th><th width=\"50%\">Filename</th><th width=\"5%\">#/$</th></tr>\n"; 
	
	while($row2=mysql_fetch_assoc($select)) { 
	
		echo "<tr>\n"; 
		echo "<td><a href=\"viewcards.php?deck=$row2[filename]\">$row2[deckname]</a></td>\n"; 
		echo "<td>$row2[filename]</td>\n"; 
		if($row[filename]=="member") { $select2 = mysql_query("SELECT * FROM `$table_members` WHERE `membercard`='Yes'"); $memnum = mysql_num_rows($select2); echo "<td>$memnum/0</td>\n"; } else { echo "<td>$row2[count]/$row2[worth]</td>\n"; } 
		echo "</tr>\n"; 
		} 
	
	echo "</table>\n\n"; 
	}
}
include("$footer"); ?>