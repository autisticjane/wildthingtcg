<?php include("mytcg/settings.php");
ob_start();
include("$header");
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","Site | Wild Thing",$buffer);
echo $buffer; ?>
<table width="100%" class="wildthing">
<tr><td align="center" width="25%"><a href="?">main</a></td>
<td align="center" width="25%"><a href="affiliates.php">affiliates</a></td>
<td align="center" width="25%"><a href="?credits">credits</a></td>
<td align="center" width="25%"><a href="?timeline">timeline</a></td></tr>
</table>
<?php
if (!$_SERVER['QUERY_STRING']) { ?>
<h1>Link to us</h1>
<h2>88x31</h2>
<h2>100x35</h2>
<?php } elseif ($_SERVER['QUERY_STRING'] == "credits") { ?>
<h1>Credits</h1>
<h2>General</h2>
<table width="100%" align="center" class="wildthing">
<tr><th width="50%" align="left">Resource</th><th width="50%" align="left">Source</th></tr>
<tr><td>Images (screencaps)</td><td>Donations<br />
<a href="http://www.homeofthenutty.com/" target="_blank">Home of the Nutty</a><br />
<a href="http://screencapped.net/" target="_blank">Screencapped.net</a></td></tr>
</table>
<p><small>Series' intertitles are used to represent their corresponding series' sets only; their use is minimal and follows fair use standards. Screenshots are used for these as well as often as possible.</small></p>

<h2>Code</h2>
<table width="100%" align="center" class="wildthing">
<tr><th width="50%" align="left">Resource</th><th width="50%" align="left">Source</th></tr>
<tr><td>Flight (Hijacked!), Melting Pot, Card Claim</td><td>Nina @ <a href="http://absolute-chaos.net" target="_blank">Absolute Chaos</a></td></tr>
<tr><td>Masteries list displayed as badges</td><td>Carla &amp; <a href="http://carbonbeauty.net" target="_blank">Jams</a></td></tr>
<tr><td>MyTCG</td><td>Amanda &amp; <a href="http://my.tcg-publicity.com" target="_blank">Helpful Hand</a></td></tr>
<tr><td>Permanent logs</td><td>KatieW @ <a href="http://www.exposureforums.org/viewthread.php?tid=13461" target="_blank">Exposure</a></td></tr>
<tr><td>SiteSkin</td><td><a href="http://scripts.indisguise.org/" target="_blank">Indisguise Scripts</a></td></tr>
</table>

<h2>Self</h2>
<table width="100%" align="center" class="wildthing">
<tr><th colspan="4">General</th></tr>
<tr><td width="25%">Templates</td><td width="25%">Flight (adopted out)</td><td width="25%">Pixels</td><td width="25%">Level names</td></tr>
<tr><td>Layouts</td><td>x</td><td>Member panel</td><td>Director's Chair</td></tr>
<tr><th colspan="4">Scripts &amp; software</th></tr>
<tr><td>6forums</td><td>User notepad</td><td>Member deck display</td><td>Hidden trade form</td></tr>
<tr><td>Wish</td><td>User preferences</td><td>Automatic Sudoku</td><td>Scavenger hunt</td></tr>
</table>
<p>I have a new code page @ <a href="http://6birds.net/code/" target="_blank">6birds</a>.</p>
<?php } elseif ($_SERVER['QUERY_STRING'] == "timeline") { ?>
<table width="100%" align="center" class="wildthing">
<tr><th width="15%">Image</th><th width="25%">Event</th><th width="20%">Date</th><th width="40%">Summary</th></tr>
<tr><th colspan="4" class="thdate center">2015</th></tr>
<tr><td valign="middle"></td><td valign="top">Prejoin</td><td valign="top">31 Oct.</td><td valign="top">50 decks, 100 upcoming<br /># members:<br /># donations:<br /># affiliates:</td></tr>

</table>

<?php }
include("$footer"); ?>