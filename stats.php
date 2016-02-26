<p class="stats">
<strong>Owner:</strong> Effy<SCRIPT TYPE="text/javascript">
						emailE=('wildthingtcg@' + 'gmail.com')
						document.write(' (<a href="mailto:' + emailE + '">email</a>)')</script><br />
<strong>Status:</strong> In progress; last modified <?php echo date ("d-M-Y", getlastmod()); ?><br />
<?php $select_mem = mysql_query("SELECT * FROM `$table_members` WHERE NOT (`status`='Pending')"); $num_members = mysql_num_rows($select_mem); ?>
<strong>Members:</strong> <a href="/members.php"><?php echo $num_members; ?></a><?php $select_pmem = mysql_query("SELECT * FROM `$table_members` WHERE `status`='Pending'"); $num_pmembers = mysql_num_rows($select_pmem); if($count==0) {} else { echo "(+$num_pmembers)";}?><br />
<?php $select_aff = mysql_query("SELECT * FROM `$table_affiliates`"); $num_aff = mysql_num_rows($select_aff); ?>
<strong>Affiliates:</strong> <a href="/affiliates.php"><?php echo $num_aff; ?></a><br />
<?php $select_count = mysql_query("SELECT * FROM `$table_cards` WHERE worth='1'"); $num_cards = mysql_num_rows($select_count); ?>
<strong>Decks:</strong> <a href="/cards.php"><?php echo $num_cards; ?></a> (+<a href="/upcoming.php"><?php
$select_upcoming = mysql_query("SELECT * FROM `$table_upcoming` WHERE ip='c'");
$num_cards2 = mysql_num_rows($select_upcoming);
echo $num_cards2; ?></a>)<br />
<strong>Cards:</strong> <?php $select100 = mysql_query("SELECT worth, SUM(count) FROM `$table_cards` WHERE worth='1' GROUP BY worth"); while($row100=mysql_fetch_assoc($select100)) {echo $row100['SUM(count)'];} ?></p>