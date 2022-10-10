<?php
/*
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
			"\n\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"stylesheet.css\" />".
			"\n\t\t<script type=\"text/javascript\" src=\"./lib/fimii_php.js\"></script>".
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
	echo "\n\t\t<div id=\"copyright\">".
		"\n\t\t\t<div class=\"copyrighttop\">Fimion.com Version 2.0</div>".
		"\n\t\t\tSite Design by Alex Riviere.<br />".
		"\n\t\t\tSite &copy;2004, Alex Riviere".
		"\n\t\t</div>";
}
//////////////////////////////////////////
//
// Bottom of page
//
//////////////////////////////////////////
function bottomOfPage()
{
	echo "</div></div>";
	echo "\n\t\t<br style=\"clear: both;\" /></div>";
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
	displayImage(fimii_image_pageBanner,"Fimion.com");
	echo "\n\t\t\t</div>";
}

//////////////////////////////////////////
//
// Navbar
//
//////////////////////////////////////////
function addNav($lkhref,$lkdisp,$lklocal=true)
{
	$lktop="<div class=\"side\">";
	$lktnd="</a></div>";
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
	echo "\n\t\t\t<div id=\"Navbar\">".
		"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Sections</div>";
	

	
	//Performing SQL query
	$query = "SELECT * FROM fimii_modules";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	//Printing results in HTML
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
	   $row=$db->sql_fetchrow($result);
	   if (fimii_pageView==$row[varName])
	   {
	       echo "\n\t\t\t\t\t<div class=\"side\">".$row['linkName']."</div>";
	   }
	   else
	   {
		  echo "\n\t\t\t\t\t";
	      addNav($row['varName'],$row['linkName']);
	   }
	
	}
	
	$db->sql_freeresult($result);
	echo "\n\t\t\t\t</div>".
		"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">External Links</div>";
	

	//Performing SQL query
	$query = "SELECT * FROM fimii_linkbar";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	//Printing results in HTML
	for ($x=$db->sql_numrows($result);  $x >0; $x--)
	{
		$row=$db->sql_fetchrow($result);
		echo "\n\t\t\t\t\t";
		addNav($row['link'],$row['name'],false);
	   
	}
	//Free resultset
	$db->sql_freeresult($result);
	
	echo "\n\t\t\t\t</div>".
		"\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Random Zen</div>".
		"\n\t\t\t\t\t<div class=\"randside\">";
	randphrase();
	echo "\n\t\t\t\t\t</div>\n\t\t\t\t</div>";
	
	echo "\n\t\t\t\t<div class=\"linkborder\">".
		"\n\t\t\t\t\t<div class=\"sidetitle\">Random Definition</div>".
		"\n\t\t\t\t\t<div class=\"randside\">".randword()."\n\t\t\t\t\t</div>\n\t\t\t\t</div>";
		
		
		
	echo "\n\t\t\t</div>";
}

//////////////////////////////////////////
//
// Start a Table
//
//////////////////////////////////////////
function openTable($tabletype="other")
{
	switch($tabletype)
	{
		case "Main":
		{
			print "<table border=\"0px\" cellpadding=\"0px\" cellspacing=\"0px\" width=\"100%\"><tr><td colspan=\"2\">";
		}break;
		case "Copyright":
		{
			print "<table id=\"copyright\" border=\"0px\" cellpadding=\"0px\" cellspacing=\"0px\" width=\"100%\"><tr><td>";
		}break;
		default:
		{
			print "<table><tr><td>";
		}break;
	}
}
//////////////////////////////////////////
//
// End of Table
//
//////////////////////////////////////////
function closeTable()
{
	print "</td></tr></table>";
}

//////////////////////////////////////////
//
// Finish one row, Start another
//
//////////////////////////////////////////
function nextTableRow($tabletype="other")
{
	switch($tabletype)
	{
		case "Main":
		{
			print "</td></tr><tr><td width=\"221px\">";
		}break;
		default:
		{
			print "</td></tr><tr><td>";
		}break;
	}
}
//////////////////////////////////////////
//
// Next Cell
//
//////////////////////////////////////////
function nextTableCell($tabletype="other")
{
	switch($tabletype)
	{
		case "Main":
		{
			print "</td><td width=\"*%\">";
		}break;
		default:
		{
			print "</td><td>";
		}break;
	}
	
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
	echo ">";
}
*/
//////////////////////////////////////////
//
// Get a Module setting
//
//////////////////////////////////////////
function modSetting($setName)
{
	global $fimii_module;
	return constant("fimii_".$fimii_module['varName']."_".$setName);
}

?>