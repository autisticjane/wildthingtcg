<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	header("Location:login.php");
}
include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Interactive | Wild Thing",$buffer);
echo $buffer; ?>
<h1>Interactive</h1>
<table width="100%" class="wildthing">
<tr><td colspan="4" align="center" class="middle">Use <em>lowercase</em> letters for all answers and exclude punctuation.</td></tr>
<tr><td width="25%" style="height: 50px" align="center" class="middle"><a href="?weekly">Weekly</a></td>
<td width="25%" style="height: 50px" align="center" class="middle"><a href="?monthly">Monthly</a></td>
<td width="25%" style="height: 50px" align="center" class="middle"><a href="?forums">Forums</a></td>
<td width="25%" style="height: 50px" align="center" class="middle"><a href="?extras">Extras</a></td></tr>
<tr><td align="center" class="middle">weekly</td><td align="center" class="middle">monthly</td><td align="center" class="middle">varies</td><td align="center" class="middle">events &amp;  ongoing</td></tr>
<tr><td colspan="4" align="center" class="middle">If you lose anything, check your <a href="log.php">log</a>!</td></tr>
</table><br /><br /><?php
if (!$_SERVER['QUERY_STRING']) { ?>

<?php } elseif ($_SERVER['QUERY_STRING'] == "weekly") { ?>
<h2>Weekly</h2>
<table width="100%" class="wildthing">
<tr><td width="33%" style="height: 50px" class="middle"><a href="game.php?blackjack">Blackjack</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game_claim.php">Card Claim</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?card">Card Puzzle</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?guess">Guess the Number</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?hangman">Hangman</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game_melt.php">Melting Pot</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?peeptin">Peeptin</a> <strong>or</strong> <a href="game.php?memory">Memory</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game_pick.php">Pick a Monster</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?slots">Slots</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?tictactoe">Tic-Tac-Toe</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?war">War</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?wheel">Wheel of Surprises</a></td></tr>
</table>

<?php } elseif ($_SERVER['QUERY_STRING'] == "monthly") { ?>
<h2>Monthly</h2>
<table width="100%" class="wildthing">
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="game.php?list">Kill List</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="forms_vote.php">Natural Selection</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game_trivia.php">Rapid Fire</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="info.php?donations">Sacrifices</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="forms_wish.php">Spell Casting</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="game_puzzle.php">Stitches</a></td></tr>
</table>

<?php } elseif ($_SERVER['QUERY_STRING'] == "forums") { ?>
<h2>Forums</h2>
<table width="100%" class="secrets1">
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_eyes.php">Eye See You</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_fish.php">Go Fish</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_guess.php">Guess the Episode</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_puzzle.php">Puzzle</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_quotes.php">Quotes</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="groupc_trivia.php">Trivia</a></td></tr>
</table>

<?php } elseif ($_SERVER['QUERY_STRING'] == "extras") { ?>
<h2>Extras</h2>
<table width="100%" class="secrets1">
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="extras_claim.php">Card claim</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="donations.php">Donations</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="doubles.php">Doubles</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="extras_eyelashes.php">Eyelashes</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="membercards.php">Member Cards</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="extras_mini.php">Mini Masteries</a></td></tr>
<tr><td width="33%" style="height: 50px" align="center" class="middle"><a href="shop.php">Shop</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="tradecards.php">Trade Cards</a></td><td width="33%" style="height: 50px" align="center" class="middle"><a href="voteupcoming.php">Vote upcoming</a></td></tr>
<tr><td colspan="3" align="center" class="middle"><a href="http://carbonbeauty.net/forum" target="_blank">even moar fun on the forums!</a></td></tr>
</table>

<?php } elseif ($_SERVER['QUERY_STRING'] == "quilts") { ?>
<h2>Quilts</h2>
<p>Pixeled and non-pixeled patches are given away through various activities. Should you decide to collect and keep track of them, you may collect a prize of <strong>3</strong> random cards for every 50 patches collected.</p>
<h3>Earning patches</h3>
<p>You may earn patches via a variety of methods:</p>
<ul><li>General &amp; site events</li>
<li>Playing <strong><?php echo $tcgname; ?></strong></li>
<li>Clicking on hidden links</li>
<li>Celebrating your birth month</li></ul>

<h3>All patches</h3>
<p>Below is a list of all the patches ever handed out. <strong>Do not</strong> take these.</p>
<?php }
include("$footer"); ?>