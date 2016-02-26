<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Info | Wild Thing",$buffer);
echo $buffer;?>
<table width="100%" class="secret">
<tr><td align="center" width="20%"><a href="?">main</a></td>
<td align="center" width="20%"><a href="?abbreviations">abbreviations</a></td>
<td align="center" width="20%"><a href="?basics">basics</a></td>
<td align="center" width="20%"><a href="?donations">donations</a></td>
<td align="center" width="20%"><a href="?etcg">easyTCG info</a></td></tr>
</table><br />
<?php
if (!$_SERVER['QUERY_STRING']) { ?>
<h1>Information</h1>
<p>Can't find the information you're looking for here? <a href="/forms_general.php">Contact</a> us and we will answer your question ASAP.</p>
<SCRIPT TYPE="text/javascript">
						emailE=('wildthingtcg@' + 'gmail.com')
						document.write('<p>Not a member? Email: <a href="mailto:' + emailE + '">' + emailE +'</a></p>')</script>

<h2>Cards</h2>
All cards at <strong><?php echo $tcgname; ?></strong> are <strong>worth 1</strong>. Each deck contains <strong>20</strong> cards. Cards may be earned though <a href="/interactive.php">games and donation rewards</a>.
<p class="center"><?php
for($i=1; $i<=5; $i++) {
	$randtype = 'regular';
	echo "<img src=\"$tcgcardurl";
	include ("mytcg/random.php");
	echo ".$ext\" />\n";
}
?></p>

<h3>Member cards</h3>
<p>Member cards are <strong>worth 1</strong> and fully tradeable. You have unlimited copies to trade with other members, but each member card may count toward your collection only once. Member cards are required at <?php echo $tcgname; ?>. The <a href="viewcards.php?deck=member">member deck</a> is masterable every 20 different cards. Member cards&mdash;and the member deck&mdash;are different from <a href="?memdecks">individual member decks</a> an entirely optional feature.</p>
<p class="center"><?php
for($i=1; $i<=5; $i++) {
	$randtype = 'member';
	echo "<img src=\"$tcgcardurl";
	echo "mc-";
	include ("mytcg/random.php");
	echo ".$ext\" />\n";
}
?></p>

<h3>Levels & Level Ups</h3>
Levels depend on <strong>total card count</strong>. Rewards for leveling up are <?php
if($num_lvlchoice!=0) {
	echo "<strong>$num_lvlchoice</strong> regular card(s) of choice";
}
if($num_lvlreg!=0) {
	echo ", <strong>$num_lvlreg</strong> random regular cards";
}
if($num_lvlspc!=0) {
	echo ", and <strong>$num_lvlspc</strong> random special cards";
}
?>. Every 300 cards you collect, you level up.
<table width="100%" class="secret">
<tr><th width="25%" class="center">level</th><th class="center" width="25%">card count</th><th width="25%" class="center">level</th><th  width="25%" class="center">card count</th></tr>
<tr><td align="center">1. Human</td><td align="center">001-300</td><td align="center">6. Undead</td><td align="center">1501-1700</td></tr>
<tr><td align="center">2. Mutant</td><td align="center">301-600</td><td align="center">7. Werewolf</td><td align="center">1801-2100</td></tr>
<tr><td align="center">3. Banshee</td><td align="center">601-900</td><td align="center">8. Hybrid</td><td align="center">2101-2400</td></tr>
<tr><td align="center">4. Witch</td><td align="center">901-1200</td><td align="center">9. Hellhound</td><td align="center">2401-2700</td></tr>
<tr><td align="center">5. Ghost</td><td align="center">1201-1500</td><td align="center">10. Original</td><td align="center">2701-3000</td></tr>
<tr><td align="center" colspan="2" width="50%">Level up</td><td align="center" colspan="2">every 300 cards</td></tr>
</table>

<h3>Mastering</h3>
Once you have collecting all of the cards in a deck, you have <strong>mastered</strong> the deck. This means you cannot trade away any of these cards (except for doubles, of course) but you will receive some rewards for doing so. For every <strong>regular card deck</strong> you master, you receive <?php
if($num_maschoice!=0) {
	echo "<strong>$num_maschoice</strong> regular card(s) of choice";
}
if($num_masreg!=0) {
	echo ", <strong>$num_masreg</strong> random regular cards";
}
if($num_masspc!=0) {
	echo ", and <strong>$num_masspc</strong> random special cards";
}
?>.
<h2>Extras</h2>
<p><strong><?php echo $tcgname; ?></strong> has extra activities to add enjoyment to the game. These activities are optional to participate in, as some don't have rewards (though they <em>may</em> later), but they are available nevertheless.</p>

<h2>Owner playing</h2>
<p>I'm playing! I'll play only non-password gate games and take from updates as provided for everyone else. I'll never take cards for donations or errors, but I will take staff pay for deck-making.</p>

<?php } elseif ($_SERVER['QUERY_STRING'] == "basics") { ?>
<h1>What is a TCG?</h1>
Online <strong>T</strong>rading <strong>C</strong>ard <strong>G</strong>ames are similar to the trading cards you knew as a child. Rather than playing in person and collecting cards from packs at the store, you collect everything online. The goal is to collect all of the cards you like, also know as mastering a deck. Online TCGs are free to play, a lot of fun, and very addictive! Interested in joining? Check out the rest of this section before moving on to the join form!

<h2>Trade Post</h2>
Before you join, you need a place to store your stuff, also know as a trade post. To make life easier for you and for your fellow TCG members, you should separate your cards--at least into groups of keeping and trading. You are also required to keep a detailed card log, showing how you got every card. The final thing you need on your site is a way to contact you, either a form or an email link, so you can trade.

<h2 id="cheating">Cheating</h2>
Cheating takes away the fun in playing, but&hellip;quite frankly, I don't care if you cheat. This is a miniature/mostly automatic TCG, because I have neither the time nor the energy to watch for everyone who's cheating, so I really couldn't care less. Obviously, by cheating, you're not playing fair with your peers. It's unethical. In the past, I've confronted people and have been lied to, and I just really don't care anymore. Specific games make cheating less doable/easy, and most games are logged. Basically, I won't come after you with a broom to sweep you away if you're cheating. The inevitable risk of getting caught is usually what fuels the fun of cheating, so I'm taking that risk away. Poof! It's gone. Is cheating still fun?
<p>Only you and whomever you tell, if anyone, will know you're cheating. I don't care. Just don't tell me, because eh. (Don't care.)</p>
<p>For the record, a general idea of what counts as cheating: refreshing rewards, taking more from the updates than permitted, having multiple accounts for self&hellip;and others, most likely, that I just can't think of right now.</p>

<h2 id="updates">Updates</h2>
Since this is a <strong>miniature trading card game</strong>, there are no set times on when updates may occur. My goal is to release <strong>20 decks per month</strong>, but if I do not meet it, please understand and have patience until I can.

<p>New members may take freebies <strong>from the latest update</strong> upon their joining. If the date update of the update is the date they joined, then so be it.</p>

<p>Members are required to comment updates with what they take.</p>

<p>Updates from November-December will likely be done in only one of the months, as it's when I'm busiest.</p>

<p>All games are automatically updated unless otherwise stated, thus they will rarrely be mentioned in updates.</p>
<?php } elseif ($_SERVER['QUERY_STRING'] == "events") { ?>
<h1>Events</h1>
<p>Throughout the year, there will be at <em>least</em> four TCG events. At <strong><?php echo $tcgname; ?></strong>, we use <strong>event milestones</strong> to track said events. Event milestones may be earned via activity and participation. Event milestones may not be traded with other members, as it is impossible to collect duplicates. Though they're currently only available for fun, they may be exchangeable in the future. :)</p>

<p>For specific details (e.g. dates), view the <a href="/site.php?timeline">timeline</a>.</p>

<?php } elseif ($_SERVER['QUERY_STRING'] == "donations") { ?>
<h1>Donation guidelines</h1>
Earn oodles of cards by donating to the site so it can grow! Claim <a href="/forms_claim.php">here</a>.

<h2>Deck images</h2>
Deck images must be HQ <strong>screenshots</strong>. You can view the list of sites I use on the <a href="/site.php?credits">credits</a> page.
<ul><li>25-35 images per deck. No more, no less. The more I have to work with, the longer I take. :(</li>
<li><strong>Character decks</strong> and <strong>relationship decks</strong> should have mostly the featured character(s) only who is visible in each picture.</li>
<li>All deck images should be arranged in the order they happened. (e.g. I number mine 01, 02, 03, etc. to 25 or 30, and so on.)</li>
<li><u>limit:</u> You can donate 5 decks per month.</li>
<li><u>reward per deck:</u> 4 random cards, +1 choice from deck when released</li></ul>

<h2>Level badges</h2>
<ul><li>
</li></ul>

<h2>Link buttons</h2>
<ul><li>100x35 and 88x31 are the sizes</li>
<li>Save them as <strong>button-yourname##</strong> or <strong>button-yourname##</strong>.</li>
<li><u>limit:</u> 15 buttons total</li>
<li><u>reward per button:</u> 2 random cards</li></ul>

<h2>Puzzle images</h2>
<ul><li>Must be HQ screenshots or promotional pictures.</li>
<li>Don't edit/add text to puzzle images.</li>
<li>Must claim before donating.</li>
<li><u>limit:</u> 20 puzzle images total</li>
<li><u>reward per image:</u> 1 random card</li></ul>

<h2>Tradecards</h2>
<ul><li>
</li></ul>

<?php } elseif ($_SERVER['QUERY_STRING'] == "etcg") { ?>
<h1>easyTCG info</h1>
<p>All decks have <strong>20</strong> cards, <strong>some</strong> are puzzles (only title logos, seasonal promo posters, etc.).
<p><strong>TCG Name:</strong> Wild Thing<br />
<strong>TCG URL:</strong> <code>http://wt.slothly.org</code><br />
<strong>Image Format:</strong> png<br />
<strong>Default Upload URL:</strong> <code>http://wt.slothly.org/cards/</code></p>

<?php } elseif ($_SERVER['QUERY_STRING'] == "abbreviations") { ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$.getJSON("http://spreadsheets.google.com/feeds/list/1yx48pAzk0x0kgo0qTzWboZ7doDr7BHbLoKSNBoFCCOk/od6/public/values?alt=json-in-script&callback=?")
.done( function(data) {
    var ssData = data.feed;
    $.each( ssData.entry, function() {
        // show a checkmark for completed decks
        var complete;
        // create and populate rows
        $('#abbreviations').append(
            '<tr>'
            + '<td>' + this.gsx$abbreviation.$t + '</td>'
            + '<td>' + this.gsx$series.$t + '</td>'
            + '</tr>'
        );
    });
});
</script>
<h1>Abbreviations</h1>
<p>Every series has its own abbreviation to 1) help save decks from having such long filenames and 2) differentiate between each series. Additionally, cards display the series name in the top-left hand corner for quicker reference. Abbreviations for series listed below that also do not have decks may change in time.</p>

<p>Technical difficulties? <a href="https://docs.google.com/spreadsheets/d/1yx48pAzk0x0kgo0qTzWboZ7doDr7BHbLoKSNBoFCCOk/edit?usp=sharing">View the Google Spreadsheets document.</a></p>
<table id="abbreviations" class="wildthing" width="100%">
    <tr>
        <th width="10%" align="left">Abbrev.</th>
        <th width="90%" align="left">Series</th>
    </tr>
</table>

<?php } elseif ($_SERVER['QUERY_STRING'] == "memdecks") { ?>
<h1>Member decks</h1>
<p>Member decks, not to be confused with <a href="viewcards.php?deck=member">the member deck</a>, are an extra activity at <?php echo $tcgname; ?>. Members may unlock cards in their member decks by completing the corresponding task.</p>

<h2>Tasks</h2>
<table class="wildthing" width="100%" align="center">
<tr><th width="5%" class="alignright">#</th><th width="95%">Task</th></tr>
<tr><td class="alignright">01</td><td>Level 1 (Human)</td></tr>
<tr><td class="alignright">02</td><td>Level 2 (Mutant)</td></tr>
<tr><td class="alignright">03</td><td>Level 3 (Banshee)</td></tr>
<tr><td class="alignright">04</td><td>Level 4 (Witch)</td></tr>
<tr><td class="alignright">05</td><td>Level 5 (Ghost)</td></tr>
<tr><td class="alignright">06</td><td>Level 6 (Undead)</td></tr>
<tr><td class="alignright">07</td><td>Level 7 (Werewolf)</td></tr>
<tr><td class="alignright">08</td><td>Level 8 (Hybrid)</td></tr>
<tr><td class="alignright">09</td><td>Level 9 (Hellhound)</td></tr>
<tr><td class="alignright">10</td><td>Level 10 (Original)</td></tr>
<tr><td class="alignright">11</td><td>Participate in a <a href="interactive.php?director">Director's Chair</a> activity.</td></tr>
<tr><td class="alignright">12</td><td>50 trades (count total; not worth)</td></tr>
<tr><td class="alignright">13</td><td>Master 10 character decks</td></tr>
<tr><td class="alignright">14</td><td>Master 10 episode decks</td></tr>
<tr><td class="alignright">15</td><td>Master 10 relationship decks</td></tr>
<tr><td class="alignright">16</td><td>Master 10 decks from one series</td></tr>
<tr><td class="alignright">17</td><td>Master the member deck</td></tr>
<tr><td class="alignright">18</td><td>Collect 20 milestones</td></tr>
<tr><td class="alignright">19</td><td>Refer 10 members</td></tr>
<tr><td class="alignright">20</td><td>Be a Prejoin member, be a staff member, or make 50 donations total</td></tr>
</table>
<?php } elseif ($_SERVER['QUERY_STRING'] == "locations") { ?>
<h1>Locations</h1>
<p>To help with various stories in the interactive activities, <strong><?php echo $tcgname ?></strong> has various locations. All members are assigned to Wintervale at registration. Each location has its own story, which has been developed purely for entertainment purposes. Members may participate in location events no matter their residence.</p>

<p>If you complete your assigned location's tasks, you will be permitted to move. If you complete all locations, you will have the ability to change your location as often as you'd like.</p>
<h2>Wintervale</h2>
<strong>Wintervale</strong> is a town home to many supernatural creatures. Local law enforcement is trying their hardest to deter the supernatural from remaining in the town, but to no avail. Local scientists are working hard to create and perform various experiments to help the police categorize citizens into species types. Each month, a new experiment is launched. Those who do not participate are recorded appropriately&mdash;and monitored.
<h3>Task</h3>
<ol><li>Complete 10 experiments.</li></ol>
<h2>Asylwood</h2>
You managed to make it out of Wintervale, but you took the wrong road and wound up in <strong>Asylwood</strong>, a town made up of doctors&mdash;some are human, some are not&mdash;who are determined to make you "better" (whatever that means). If you're not supernatural yet, you're bound to be after they're done with you.
<h3>Task</h3>
<ol><li>Coming soon.</li></ol>
<?php }
include("$footer"); ?>