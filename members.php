<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Members | Wild Thing",$buffer);
echo $buffer;
?>

<h1>Members</h1>
<p>Listed below you will find all current member here at <?php echo $tcgname; ?>. Clicking on a member's name will take you to their profile, where you can send them a trade request.</p>

<?php
$select2 = mysql_query("SELECT * FROM `$table_members` WHERE `status`='Pending' ORDER BY `name`");
$count2 = mysql_num_rows($select2);

if($count2==0) {
	echo "";
}
else {
	echo "<h2>Pending</h2><table width=\"100%\" class=\"wildthing\">\n";
	echo "<tr><th width=\"25%\"><b>Name</b></th><th width=\"25%\"><b>HTTP://</b></th><th width=\"25%\"><b>Birthday</b></th><th width=\"25%\"><b>Collecting</b></th></tr>\n";
	while($row2=mysql_fetch_assoc($select2)) {
		echo "<tr><td  class=\"center\"><a href=\"profile.php?id=$row2[name]\">$row2[name]</a></td><td  class=\"center\"><a href=\"$row2[url]\" target=\"_blank\">http://</a></td><td  class=\"center\">$row2[birthday]</td><td  class=\"center\">$row2[collecting]</td></tr>\n";
	}
	echo "</table>\n";
	echo "<br /><br />\n\n";
}


for($i=1; $i<=$num_levels; $i++) {
	$levelnum = $i;
	$select = mysql_query("SELECT * FROM `$table_members` WHERE `level`='$levelnum' AND `status`='Active' ORDER BY `name`");

	$count = mysql_num_rows($select);
	
	if($count==0) {
		echo "";
	}
	else {
		echo "<h1>$level[$i]</h1>\n";
		echo "<table width=\"100%\" class=\"wildthing\">\n";
		echo "<tr><th width=\"25%\" class=\"center\">Alias</th><th width=\"25%\" class=\"center\">Trades @</th><th width=\"25%\" class=\"center\">Ages up during</th><th width=\"25%\" class=\"center\">Collecting</th></tr>\n";
		while($row=mysql_fetch_assoc($select)) {
			echo "<tr><td class=\"center\"><a href=\"profile.php?id=$row[name]\">$row[name]</a></td><td class=\"center\" class=\"center\"><a href=\"$row[url]\" target=\"_blank\">view tradepost</a></td><td class=\"center\"><img src=\"/images/profiles/$row[birthday].png\" title=\"$row[birthday]\" alt=\"$row[birthday]\" /></td><td  class=\"center\"><a href=\"viewcards.php?deck=$row[collecting]\">$row[collecting]</a></td></tr>\n";
		}
		echo "</table>\n";
		echo "<br /><br />\n\n";
	}
}

$select3 = mysql_query("SELECT * FROM `$table_members` WHERE `status`='Hiatus' ORDER BY `name`");
$count3 = mysql_num_rows($select3);

if($count3==0) {
	echo "";
}
else {
	echo "<h2>Hiatus</h2><table width=\"100%\" class=\"wildthing\">\n";
	echo "<tr><th width=\"25%\"><b>Name</b></th><th width=\"25%\"><b>HTTP://</b></th><th width=\"25%\"><b>Birthday</b></th><th width=\"25%\"><b>Collecting</b></th></tr>\n";
	while($row3=mysql_fetch_assoc($select3)) {
			echo "<tr><td  class=\"center\"><a href=\"profile.php?id=$row3[name]\">$row3[name]</a></td><td  class=\"center\"><a href=\"$row3[url]\" target=\"_blank\">http://</a></td><td  class=\"center\">$row3[birthday]</td><td  class=\"center\">$row3[collecting]</td></tr>\n";
	}
	echo "</table>\n";
	echo "<br /><br />\n\n";
}
$select4 = mysql_query("SELECT * FROM `$table_members` WHERE `status`='Inactive' ORDER BY `name`");
$count4 = mysql_num_rows($select4);

if($count4==0) {
	echo "";
}
else {
	echo "<h2>Inactive</h2><p>These members have been inactive for <strong>six months</strong> and first need to reactivate their account before they may continue playing the game.</p><table width=\"100%\">\n";
	echo "<tr><td width=\"100%\">";
	while($row4=mysql_fetch_assoc($select4)) {
			echo "<a href=\"profile.php?id=$row4[name]\">$row4[name]</a>, ";
	}
	echo "</td></tr></table>";
}
include('$footer'); ?>