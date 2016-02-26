<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Doubles | Wild Thing",$buffer);
echo $buffer; ?>
<h1>Doubles</h1>
<p>Exchange your doubles here. Refreshing to get something you want counts as cheating, but only you, and whomever else you tell, will know you're cheating. <a href="/info.php#cheating">More info.</a></p>
<?php
$result=mysql_query("SELECT * FROM `$table_cards` WHERE `worth`='1'") or die("Unable to select from database.");
$min=1;
$max=mysql_num_rows($result);
for($i=0; $i<2,5; $i++) {
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
include("$footer"); ?>