<?php include("mytcg/settings.php");
ob_start();
include("$header");
$id = $_GET['id'];
$buffer=ob_get_contents();
ob_end_clean();
$buffer=str_replace("%TITLE%","$id's Profile | Wild Thing",$buffer);
echo $buffer;
$query="SELECT * FROM `$table_members` WHERE name='$id'";
$result=mysql_query($query);

while ($row=mysql_fetch_assoc($result)) {
	?>
	<h1><a href="/members.php">Members</a> &gt; <?php echo $row[name]; ?></h1>
	<table width="100%" class="wildthing" align="center">
	<tr><th class="center">Basics</th><th colspan="3">Information</th></tr>
	<tr><td rowspan="3" class="center" width="123"><?php
	if($row[membercard]=="Yes") {
		echo "<img src=\"/cards/mc-$row[name].png\" />";
	}
	else {
		echo "<img src=\"/cards/blank.png\" />";
	}
	?><br />
	<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") { ?><?php } else { ?><a href="<?php echo $row[url]; ?>" target="_blank">visit tradepost</a><?php } ?>
	</td><td><b>Name:</b> <?php echo $row[name]; ?></td><td>
	<b>Status:</b> <?php echo $row[status]; ?></td><td rowspan="3" class="center" width="180"><img src="/cards/<?php echo $row[collecting]; ?>-master.png" title="<?php echo $row[collecting]; ?>" alt="<?php echo $row[collecting]; ?>" /><br /><a href="viewcards.php?deck=<?php echo $row[collecting]; ?>"><?php echo $row[collecting]; ?></a></td></tr>
	<tr><td><strong>Species:</strong> <?php echo $level[$row[level]]; ?></td>
	<td><strong>Birthday:</strong> <img src="/images/profiles/<?php echo $row[birthday]; ?>" title="<?php echo $row[birthday]; ?>" alt="<?php echo $row[birthday]; ?>" /><br />
	</td></tr>
	<tr><td colspan="2"><strong>Last online:</strong> n/a</td></tr>
	</table>
	
	<h2>Mastered</h2>
	<?php echo $row[wishlist]; ?>
	
<?php session_start();
if (isset($_SESSION['USR_LOGIN'])=="") {
	if($row[tradeform]=="no") {
			echo ""; }
		else {
	?><h2>Trade</h2><p>You must be <a href="login.php">logged in</a> to view <?php echo $row[name]; ?>'s trade form.</p><?php } else { ?>
	<h2>Trade</h2>
	<form method="post" action="email.php?id=<?php echo "$id"; ?>">
	<input type="hidden" name="id" value="<?php echo "$row[id]"; ?>" />
	<table width="100%" class="wildthing" align="center">
	<tr><td>Name:</td><td><input type="text" name="name" value="" /></td></tr>
	<tr><td>Email:</td><td><input type="text" name="email" value="" /></td></tr>
	<tr><td>Trade Post:</td><td><input type="text" name="url" value="http://" /></td></tr>
	<tr><td>You Give:</td><td><input type="text" name="giving" value="" /></td></tr>
	<tr><td>You Want:</td><td><input type="text" name="for" value="" /></td></tr>
	<tr><td>Member Cards:</td><td><input type="radio" name="member" value="yes" /> Yes <input type="radio" name="member" value="no"> No</td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="submit" value=" Trade! " /></td></tr>
	</table>
	</form>
<?php }
	}
}
include("$footer"); ?>