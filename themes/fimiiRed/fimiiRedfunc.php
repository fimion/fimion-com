<?php

///////////////////////////////////////////////
//
// Top of the Page
//
///////////////////////////////////////////////
function topOfPage()
{
	global $fimii_module;
	
	
		
	print "<html>".
			"\n\t<head>".
			"\n\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">".
			"\n\t\t<title>Fimion.com 2.0 - ".$fimii_module['pageName']."</title>".
			"\n\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"http://www.fimion.com/themes/fimiiRed/stylesheet.css\" />".
			"\n\t\t<script type=\"text/javascript\" src=\"http://www.fimion.com/lib/fimii_php.js\"></script>".
			"\n\t</head>".
			"\n\t<body>".
			"\n\t\t<div id=\"inner\">";
	fimiiBanner();
	fimiiNavbar();
	print "<div id=\"content\"><div class=\"title\">".$fimii_module['pageName']."</div>".
	"<div class=\"blogbody\">";
}
//////////////////////////////////////////
//
// Copyright Info
//
//////////////////////////////////////////
function copyrightInfo()
{
	echo "\n\t\t\t\t\t<div id=\"copyright\">".
		"\n\t\t\t\t\t\t<span class=\"copyrighttop\">Fimion.com Version 2.0</span><br />".
		"\n\t\t\t\t\t\t<span class=\"copyrighttext\">Site Design by Alex Riviere.<br />".
		"\n\t\t\t\t\t\tSite &copy;2004, Alex Riviere</span>".
		"\n\t\t\t\t\t</div>";
}
//////////////////////////////////////////
//
// Bottom of page
//
//////////////////////////////////////////
function bottomOfPage()
{
	echo "</div></div>";
	//echo "\n\t\t<br style=\"clear: both;\" /></div>";
	copyrightInfo();
	echo "\n\t</body>\n</html>";
}

//////////////////////////////////////////
//
// Banner
//
//////////////////////////////////////////
function fimiiBanner()
{
	echo "\n\t\t\t<div id=\"banner\">\n\t\t\t\t";
	displayImage(fimii_image_fimiiRed_pageBanner,"Fimion.com");
	echo "\n\t\t\t</div>";
}

//////////////////////////////////////////
//
// Navbar
//
//////////////////////////////////////////
function addNav($lkhref,$lkdisp,$lklocal=true)
{
	$lktop="<span class=\"side\">";
	$lktnd="</a></span>";
	if($lklocal)
	{
		$lktop.="<a class=\"side\" href=\"";
		$lktcl="\">";
		echo $lktop."?view=".$lkhref.$lktcl.$lkdisp.$lktnd;
	}
	else
	{
		$lktop.="<a class=\"sideext\" href=\"";
		$lktcl="\" rel=\"external\">";
		echo $lktop.$lkhref.$lktcl.$lkdisp.$lktnd;
	}
}
function fimiiNavbar()
{
	global $db,$fimii_module;
	echo "\n\t\t\t<div id=\"Navbar\">";
		/*"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Sections</div>";
	

	*/
	/* Performing SQL query */
	$query = "SELECT * FROM fimii_modules";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	/* Printing results in HTML */
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
	   $row=$db->sql_fetchrow($result);
	   if (fimii_pageView==$row[varName])
	   {
	       echo "\n\t\t\t\t\t<span class=\"side\">".$row['linkName']."</span>";
	   }
	   else
	   {
		  echo "\n\t\t\t\t\t";
	      addNav($row['varName'],$row['linkName']);
	   }
	   if($x-1>0) echo " | ";
	
	}
	
	$db->sql_freeresult($result);
	echo "<br />";
	/*echo "\n\t\t\t\t</span>";
		/*"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">External Links</div>";*/
	

	/* Performing SQL query */
	$query = "SELECT * FROM fimii_linkbar";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	/* Printing results in HTML */
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		
		echo "\n\t\t\t\t\t";
		addNav($row['link'],$row['name'],false);
		if($x-1>0) echo " | ";
	   
	}
	/* Free resultset */
	$db->sql_freeresult($result);
	
	echo "\n\t\t\t\t</span>";
		/*"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Random Zen</div>".
		"\n\t\t\t\t\t<div class=\"randside\">";
	randphrase();
	echo "\n\t\t\t\t\t</div>\n\t\t\t\t</div>";
	
	echo "\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Random Definition</div>".
		"\n\t\t\t\t\t<div class=\"randside\">".randword()."\n\t\t\t\t\t</div>\n\t\t\t\t</div>";
		
		
		*/
	echo "\n\t\t\t</div>";
}


//////////////////////////////////////////
//
// Display an Image
//
//////////////////////////////////////////
function displayImage($imgsrc,$imgalt,$imgwidth=false,$imgheight=false)
{
	echo "<img src=\"".fimii_imageDir.$imgsrc."\" alt=\"".$imgalt."\"";
	if($imgwidth)
	{
		echo " width=\"".$imgwidth."\"";
	}
	if($imgheight)
	{
		echo " height=\"".$imgheight."\"";
	}
	echo " />";
}

/*//////////////////////////////////////////
//
// Get a Module setting
//
//////////////////////////////////////////
function modSetting($setName)
{
	global $fimii_module;
	return constant("fimii_".$fimii_module['varName']."_".$setName);
}
*/
//////////////////////////////////////////
//
// output function
//
//////////////////////////////////////////
function output($output)
{
	echo fimii_bbcode($output);
}


///////////////////////////////////////////////
//
// starts a subContent div with title $title
//
///////////////////////////////////////////////
function openSubContent($title)
{
	echo "<div class=\"subContent\">\n".
		"<div class=\"subContentTitle\">";
	output($title);
	echo "</div>\n".
		"<div class=\"subContentText\">\n";
}

///////////////////////////////////////////////
//
// ends a subContent div
//
///////////////////////////////////////////////
function closeSubContent($text="")
{
	echo "</div>\n";
	output($text);
	echo "</div>\n";
}

///////////////////////////////////////////////
//
// Navigation for entries at the bottom of entry page
//
///////////////////////////////////////////////
function entryNav($text)
{
	echo "<div class=\"entryNav\">";
	output($text);
	echo "</div>\n";
}

?>

