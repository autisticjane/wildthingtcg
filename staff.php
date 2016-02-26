<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Staff | Wild Thing",$buffer);
echo $buffer;
?>
<table width="100%" class="secret">
<tr><td align="center" width="25%"><a href="?">main</a></td>
<td align="center" width="25%"><a href="affiliates.php">affiliates</a></td>
<td align="center" width="25%"><a href="?credits">credits</a></td>
<td align="center" width="25%"><a href="?timeline">timeline</a></td></tr>
</table><br />
<?php
if (!$_SERVER['QUERY_STRING']) { ?>
<h1>Link to us</h1>
<h2>88x31</h2>
<h2>100x35</h2>
<?php } elseif ($_SERVER['QUERY_STRING'] == "pay") { ?>
<h1>Staff pay</h1>
<p>Let me know if you feel these should be adjusted!</p>

<h2>Game Staff</h2>
<p class="center"><?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<5; $i++) {
mysql_data_seek($result,rand($min,$max)-1);
$row=mysql_fetch_assoc($result);
$digits = rand(01,$row['count']);
if ($digits < 10) { $_digits = "0$digits"; } else { $_digits = $digits;}
$card = "$row[filename]$_digits";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>Game Staff:</strong> $rewards";
?></p>

<h2>Forum helper</h2>
<p class="center"><?php
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
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>Game Staff:</strong> $rewards";
?></p>

<?php } elseif ($_SERVER['QUERY_STRING'] == "timeline") { ?>
<table width="100%" align="center">
<tr><th width="15%">Image</th><th width="25%">Event</th><th width="20%">Date</th><th width="40%">Summary</th></tr>
<tr><th colspan="4" class="thdate">2015</th></tr>
<tr><td valign="middle"></td><td valign="top">Prejoin</td><td valign="top">31 Oct.</td><td valign="top">25 decks, 100 upcoming<br /># members:<br /># donations:<br /># affiliates:</td></tr>
</table>
<?php } elseif ($_SERVER['QUERY_STRING'] == "donations") { ?>

<?php }
include("$footer"); ?>