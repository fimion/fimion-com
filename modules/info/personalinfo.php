<?php
include("about_me/info.php");
include("about_me/age.php");
topOfPage();

output("[img]http://www.fimion.com".fimii_imageDir.modSetting("image_self1")."[/img]");

output("\n\nName: ".modSetting("displayName")."\n\n".
	findfullage(modSetting("birthYear"),modSetting("birthMonth"),modSetting("birthDay"),modSetting("birthHour"),modSetting("birthMinute"))."\n\n");
fimii_dblist("hobby","Hobbies");
fimii_dblist("game","Favorite Games");
fimii_dblist("book","Favorite Books/Plays");

bottomOfPage();
?>