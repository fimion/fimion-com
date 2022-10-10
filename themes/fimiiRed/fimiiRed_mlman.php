<?php

/////////////////////////////////////////////////////////////
//
// Custom mlman arrays
//
/////////////////////////////////////////////////////////////
$fimii_mlmanPatterns= Array();
$fimii_mlmanReplace= Array();


//[url]foo.com[/url]
$fimii_mlmanPatterns['url1'] = '/\[url\](?!http:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/url\]/si';
$fimii_mlmanReplace['url1'] = '<a href="http://\\1" class="external" rel="external">\\1</a>';

//[url]http://foo.com[/url]
$fimii_mlmanPatterns['url2'] = '/\[url\]([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/url\]/si';
$fimii_mlmanReplace['url2'] = '<a href="\\1\\2" class="external" rel="external">\\1\\2</a>';

//[url=foo.com]description[/url]
$fimii_mlmanPatterns['url3'] = '/\[url=(?![0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+?)\[\/url\]/si';
$fimii_mlmanReplace['url3'] = '<a href="http://\\1" class="external" rel="external">\\2</a>';

//[url=http://foo.com]description[/url]
$fimii_mlmanPatterns['url4'] = '/\[url=([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+?)\[\/url\]/si';
$fimii_mlmanReplace['url4'] = '<a href="\\1\\2" class="external" rel="external">\\3</a>';


//Acronym CSS
$fimii_mlmanPatterns['acronymcss']='/CSS/';
$fimii_mlmanReplace['acronymcss']='<acronym title="Cascading Style Sheet">CSS</acronym>';

//Acronym ATML
$fimii_mlmanPatterns['acronymatml']='/ATML/';
$fimii_mlmanReplace['acronymatml']='<acronym title="Atlanta Theatre Mailing List">ATML</acronym>';


function fimii_bbcode($string)
{
	global $fimii_mlmanPatterns, $fimii_mlmanReplace;
	return mlmanDisplay($string, $fimii_mlmanReplace, $fimii_mlmanPatterns);
}


?>