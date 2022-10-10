<?php

include('./lib/config.php');


if($fimii_module['varName']==fimii_pageView)
{
	include('./modules/'.$fimii_module['varName'].'/'.$fimii_module['fileName']);
}

$db->sql_close();


?>