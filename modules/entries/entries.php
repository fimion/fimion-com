<?php
if(!isset($_GET['comment'])) define("fimii_comment","0");
else define("fimii_comment",$_GET['comment']);



function entries_Main()
{
	if(is_null($_GET['lim'])) $templim=0;
	else $templim=$_GET['lim'];
	global $db;
	/* Performing SQL query */
	$query = "SELECT * FROM fimii_entries ORDER BY 'date' DESC LIMIT ".$templim." , 5";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	/* Printing results in HTML */
	
	
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		openSubContent("\"".$row['title']."\"\n".date("F j, Y  g:i a",strtotime($row['date'])));
		output($row['entry']."\n\n");
		closeSubContent("Number of comments: ".$row['commentcount']." | <a href=\"?view=entries&comment=".$row['IDnum']."\">View/Add Comments</a>");
	}
	
	$entryNav="";
	if($_GET['lim']>0)
	{
		$nlim=$_GET['lim']-5;
		$entryNav.="<a href=\"?view=entries&lim=".$nlim."\">Prev</a>";
	}
	else
	{
		$entryNav.="Prev";
	}
	$entryNav.=" | ";
	if($row['IDnum']>1)
	{
		$nlim=$_GET['lim']+5;
		$entryNav.="<a href=\"?view=entries&lim=".$nlim."\">Next</a>";
	}
	else
	{
		$entryNav.="Next";
	}
	
	entryNav($entryNav);
	
	/* Free resultset */
	$db->sql_freeresult($result);
}
function entries_DisplayEntry()
{
	global $db;
	/* Performing SQL query */
	$query = "SELECT IDnum, title, date, entry, commentcount FROM fimii_entries  WHERE IDnum=".fimii_comment;
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	/* Printing results in HTML */
	
	
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		openSubContent("\"".$row['title']."\"\n".date("F j, Y  g:i a",strtotime($row['date'])));
		output($row['entry']."\n\n");
		closeSubContent("Number of comments: ".$row['commentcount']);

	}
	
	$db->sql_freeresult($result);
	output("\n\n");
	/* Performing SQL query */
	$query = "SELECT * FROM fimii_entries_comments WHERE messagenum=".fimii_comment." ORDER BY IDnum ASC";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	/* Printing results in HTML */
	
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		openSubContent("\"".$row['title']."\"\nFrom: ".$row['commentor']);
		output($row['comment']);
		closeSubContent();
	}
	
	$db->sql_freeresult($result);
	
	entryNav("\n\n<a href=\"?view=entries&comment=".fimii_comment."&addcomment=1\">Add Comment</a> | <a href=\"?view=entries\">Go Back</a>\n\n");

}

function entries_addComment()
{
	openSubContent("Add Comment");
	/*output("<form action=\"index.php?view=entries&comment=".fimii_comment."&addcomment=2\" method=\"post\">\n".
		"<input type=\"hidden\" name=\"messagenum\" value=\"".fimii_comment."\">\n".
		"Title:   <input type=\"text\" name=\"title\">\n".
		"Name: <input type=\"text\" name=\"commentor\" value=\"Anonymous\">\n".
		"Comment:\n".
		"<textarea name=\"message\" rows=\"5\" cols=\"40\"></textarea>\n".
		"<input type=\"submit\" name=\"submit\" value=\"Submit\"></form>");*/
        output("Sorry, Comments have been disabled at this time due to spam. Please go to [url=http://fabulousgeek.com]FabulousGeek.com[/url] to see Newer material.");
	closeSubContent();
}


function entries_updateComments()
{
	global $db;
	if($_POST['commentor']=="") $fimii_commentor="Anonymous";
	else $fimii_commentor=$_POST['commentor'];
	$fimii_comment=$_POST['message'];
	$fimii_title=$_POST['title'];
	$fimii_comment=strip_tags($fimii_comment);
	$fimii_commentor=strip_tags($fimii_commentor);
	$fimii_title=strip_tags($fimii_title);
	
	//$fimii_comment=fimii_bbcode($fimii_comment);
	
	//$query = "INSERT INTO fimii_entries_comments (messagenum, title, comment, commentor) VALUES (('".$_POST['messagenum']."'), ('".$fimii_title."'), ('".$fimii_comment."'),('".$fimii_commentor."'))";
	//$db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	//$query = "UPDATE fimii_entries SET commentcount=commentcount+1 WHERE IDnum=".$_POST['messagenum'];
	//$db->sql_query($query) or die("Query failed : " . $db->sql_error());
}


topOfPage();


switch($_GET['addcomment'])
{
	case "1": entries_addComment(); break;
	
	case "2": entries_updateComments(); break;
	
	default:  break;
}
switch(fimii_comment)
{
	case "0": 
	{
		entries_Main();
	}break;
	
	default: entries_DisplayEntry(); break;
}
bottomOfPage();
?>



