<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Randomizers | Wild Thing",$buffer);
echo $buffer; ?>
<h1>Randomiser</h1>
<table width="100%" class="secret">
<tr><th class="center" width="100%" colspan="4">Randomisers</th></tr>
<tr><td class="center" width="25%"><a href="?random">regular</a></td>
<td class="center" width="25%"><a href="/random.php#donations">donations</a></td>
<td class="center" width="25%"><a href="?games">games</a></td>
<td class="center" width="25%"><a href="/random_update.php?count=10&date=lastupdatedate">new decks</a></td></tr>
<tr><td class="center"><a href="?doubles">doubles</a></td>
<td class="center"><a href="/random.php#referral">referral</a></td></tr>
<tr><th class="center" width="100%" colspan="4">Generators</th></tr>
<tr><td class="center" width="25%"><a href="/gen_forum.php">forum</a></td>
<td class="center" width="25%"><a href="/gen_update.php">update</a></td>
<td class="center" width="25%"><a href="/random_quitter.php">quitter</a></td></tr>
</table>
<?php
if (!$_SERVER['QUERY_STRING']) { ?>
<h2><a id="referral"></a>Referral</h2>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<2; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>Referral:</strong> $rewards";
?>

<h2><a id="donations"></a>Donation: Deck images</h2>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<4; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards1 .= $card.", ";
}
$rewards1 = substr_replace($rewards1,"",-2);
echo "<br /><strong>Donations (deck images):</strong> $rewards1";
?>

<h2>Donation: Buttons</h2>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<3; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards2 .= $card.", ";
}
$rewards2 = substr_replace($rewards2,"",-2);
echo "<br /><strong>Donations (buttons):</strong> $rewards2";
?>

<h2>Donation: Level badges</h2>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<4; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards3 .= $card.", ";
}
$rewards3 = substr_replace($rewards3,"",-2);
echo "<br /><strong>Donations (level badges):</strong> $rewards3";
?>
<?php } elseif ($_SERVER['QUERY_STRING'] == "random") { ?>
<h1>Regular Cards</h1>
<center>
<?php
for($i=1; $i<=20; $i++) {
	$randtype = 'regular';
	echo "<img src=\"$tcgcardurl";
	include ("mytcg/random.php");
	echo ".$ext\" />\n";
}
?>
</center>
<?php } elseif ($_SERVER['QUERY_STRING'] == "filenames") { ?>
<h1>Filenames</h1>
<textarea onclick="this.focus();this.select()" style="width: 75%;"><?php
for($i=1; $i<=10; $i++) {
	$randtype = 'regular';
	include ("mytcg/random.php");
	echo ", ";
}
?></textarea>
<?php } elseif ($_SERVER['QUERY_STRING'] == "doubles") { ?>
<h1>Doubles</h1>
<p>Exchange your doubles here. Refreshing to get something you want counts as cheating, but only you, and whomever else you tell, will know you're cheating. <a href="/info.php?basics#cheating">More info.</a></p>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<rand(2,5); $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>Doubles:</strong> $rewards";

} include("$footer"); ?>