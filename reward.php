<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$game = $_GET['game'];
$buffer=str_replace("%TITLE%","$game rewards | Wild Thing",$buffer);
echo $buffer; ?>
<h1><?php echo $game; ?> rewards</h1>
<blockquote>Well done! Take the following rewards for successfully completing <strong><?php echo $game; ?></strong>!</blockquote>
<p><?php
$result2=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result2);
for($i=0; $i<rand(2,4); $i++) {
mysql_data_seek($result2,rand($min,$max)-1);
$row2=mysql_fetch_assoc($result2);
$digits2 = rand(01,$row2['count']);
if ($digits2 < 10) { $_digits2 = "0$digits2"; } else { $_digits2 = $digits2;}
$card = "$row2[filename]$_digits2";
echo "<img src=\"$tcgcardurl$card.png\" border=\"0\" /> ";
$rewards .= $card.", ";
}
$rewards = substr_replace($rewards,"",-2);
echo "<br /><strong>$game:</strong> $rewards</p><p><a href=\"/interactive.php\">&larr; back to the games?</a></p>";
include("$footer"); ?>