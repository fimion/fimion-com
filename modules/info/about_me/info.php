<?php

function fimii_dblist($cat, $title){

	global $db;
	/* Performing SQL query */
	$query = "SELECT item FROM fimii_about_lists WHERE catagory='".$cat."'";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	
	print "<b><u>".$title."</u></b><br><ul type=disc>";
	/* Printing results in HTML */
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		print "<li>".$row['item']."</li>";
	}
	print "</ul><br>";
	
	/* Free resultset */
	$db->sql_freeresult($result);

}

?>