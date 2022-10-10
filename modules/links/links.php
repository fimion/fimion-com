<?php
function addLink($lnkhref,$lnkdisp)
{
	return "[url=".$lnkhref."]".$lnkdisp."[/url]";
}
topOfPage();

/* Performing SQL query */
$query = "SELECT * FROM fimii_links";
$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());

/* Printing results in HTML */
for ($x=$db->sql_numrows($result);  $x >0; $x--)
{
   $row=$db->sql_fetchrow($result);
   openSubContent(addLink($row['link'],$row['name']));
   output($row['description']);
   closeSubContent();
}
/* Free resultset */
$db->sql_freeresult($result);


bottomOfPage();
?>