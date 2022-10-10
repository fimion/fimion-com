<?php

include('mysql4.php');

// These have been changed for reasons.
define("fimii_MySQLhost", "hostname");
define("fimii_MySQLuname", "username");
define("fimii_MySQLupass", "password");
define("fimii_MySQLdbname", "dbserver");
define("fimii_defaultPage", "main.php");
if(!isset($_GET['view']))
	define("fimii_pageView","main");
else
	define("fimii_pageView",$_GET['view']);

$regglob=new sql_db(fimii_MySQLhost,fimii_MySQLuname,fimii_MySQLupass,fimii_MySQLdbname);

//register globals from SQL database
$globs=$regglob->sql_query("SELECT * FROM fimii_globvars");
for($glob_x=0;$glob_x<$regglob->sql_numrows($globs);$glob_x++)
{
	$glob_row=$regglob->sql_fetchrow($globs);
	define("fimii_".$glob_row['name'],$glob_row['setting']);
}
$regglob->sql_freeresult($globs);

//Get module info for global variable
$fimii_module=array();
$globs=$regglob->sql_query("SELECT * FROM fimii_modules WHERE varName = '".fimii_pageView."'");
$glob_row=$regglob->sql_fetchrow($globs);
if($glob_row['varName']==fimii_pageView)
{
	$fimii_module['varName']=$glob_row['varName'];
	$fimii_module['pageName']=$glob_row['linkName'];
	$fimii_module['fileName']=$glob_row['fileName'];
}
else
{
	$fimii_module['varName']="main";
	$fimii_module['pageName']="Main";
	$fimii_module['fileName']=fimii_defaultPage;
}
$regglob->sql_freeresult($globs);


//register module variables from SQL database
$globs=$regglob->sql_query("SELECT * FROM fimii_modules_settings WHERE modName = '".$fimii_module['varName']."'");
for($glob_x=0;$glob_x<$regglob->sql_numrows($globs);$glob_x++)
{
	$glob_row=$regglob->sql_fetchrow($globs);
	define("fimii_".$glob_row['modName']."_".$glob_row['setting'],$glob_row['value']);
}
$regglob->sql_freeresult($globs);
$regglob->sql_close();


include('browserdetect.php');
include('random.php');
include('mlman.php');
include('./themes/theme.php');
//include('fimii_mlman.php');
include('mainfunctions.php');

//Global Database
$db=new sql_db(fimii_MySQLhost,fimii_MySQLuname,fimii_MySQLupass,fimii_MySQLdbname) or die("Could not connect to db");
?>