<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Update randomizer | Wild Thing",$buffer);
echo $buffer;
$count = $_GET['count'];
$date = $_GET['date']; ?>
<h1>Update randomiser</h1>
<p>This randomiser fetches <strong>1 card</strong> per each latest deck. If the update allows you to grab more than one card per deck, feel free to switch a card out, but make sure you follow the limits outlined in the update.</p>
<blockquote>This randomiser only works with the latest update. For older updates, you'll need to manually select cards.</blockquote>
<?php
			$resultnd=mysql_query("SELECT * FROM `$table_cards` WHERE worth='1' ORDER BY `id` DESC LIMIT $count") or die("<p>Unable to select from database.</p><p>May need to try defining <code>count</code> and <code>date</code> in URL.</p>");
			$min=1;
			$max=mysql_num_rows($resultnd);

			for($i=0; $i<$count; $i++) {
				mysql_data_seek($resultnd,rand($digits_spc,1)-1);
				$row=mysql_fetch_assoc($resultnd);
				$digits = rand(01,$row['count']);

				if ($digits < 10) { 
					$_digits = "0$digits"; 
				} 

				else { 
					$_digits = $digits;
				}

				$card = "$row[filename]$_digits";
				echo "<img class=\"set\" src=\"$tcgcardurl$filename$card.png\" border=\"0\" /> ";
				$rewards .= $card.", ";
			}

			$rewards = substr_replace($rewards,"",-2);
			echo "<br /><strong>New decks ($date):</strong>: $rewards";
include("$footer"); ?>