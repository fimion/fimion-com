<?php
/*********************************************************
 * License Information.
 * This is the BSD License
 * Details: http://opensource.org/licenses/bsd-license.php
 *********************************************************
Copyright (c) 2003, 2004 
All rights reserved.

Redistribution and use in source and binary forms, 
with or without modification, are permitted provided 
that the following conditions are met:

    * Redistributions of source code must retain the 
above copyright notice, this list of conditions and 
the following disclaimer.
    * Redistributions in binary form must reproduce 
the above copyright notice, this list of conditions 
and the following disclaimer in the documentation 
and/or other materials provided with the distribution.
    * Neither the name of the j-san.net nor the 
names of its contributors may be used to endorse or 
promote products derived from this software without 
specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS 
AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED 
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A 
PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL 
THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR 
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED 
TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) 
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE 
OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS 
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*************************************************************/


/********************************************
 * mlman.php
 * jason brackins
 * jason@j-san.net
 * Current Version: 0.3 2004-01-17
 * Version: 0.2 2003-09-08
 * Started (version 0.1): 2003-08-26
 *
 * mlman is intended to be a simple to reuse
 * bbcode mark up parser. bbcode is used by 
 * phpbb (www.phpbb.com). It is a simple syntax
 * that makes it easy for people that do not
 * know html to post formatted code on the web.
 * It is basically html with square brackets instead
 * of angle brackets. [] instead of <>. Also, maybe 
 * more importantly, linebreaks are respected.
 *
 * while there are default patterns and replacements,
 * mlman is extensible. users can pass their own
 * patterns and replacements arrays that over ride 
 * some or all of the defaults. 
 * user defined patterns and replacemnts can be used
 * by simply adding new patterns and matching 
 * replacements to the $userPatterns and $userReplaments
 * arrays respecitvely.
 */

//Set up the default patterns and replacements
//we are using globals so we only have to build these
//arrays one time per include

$defaultPatterns = Array();
$defaultReplacements = Array();

//Bold, Italic and Underline
//As they stand they could be done with a string replace
//but we're going to do everything we can with this array
$defaultPatterns['boldOpen'] = '/\[b\]/';
$defaultReplacements['boldOpen'] = '<span style="font-weight:bold;">';
$defaultPatterns['boldClose'] = '/\[\/b\]/';
$defaultReplacements['boldClose'] = '</span>';

$defaultPatterns['italicOpen'] = '/\[i\]/';
$defaultReplacements['italicOpen'] = '<span style="font-style:italic;">';
$defaultPatterns['italicClose'] = '/\[\/i\]/';
$defaultReplacements['italicClose'] = '</span>';

$defaultPatterns['underlineOpen'] = '/\[u\]/';
$defaultReplacements['underlineOpen'] = '<span style="text-decoration:underline;">';
$defaultPatterns['underlineClose'] = '/\[\/u\]/';
$defaultReplacements['underlineClose'] = '</span>';

//code/preformated
$defaultPatterns['codeOpen'] = '/\[code\]/';
$defaultReplacements['codeOpen'] = '<pre>';
$defaultPatterns['codeClose'] = '/\[\/code\]/';
$defaultReplacements['codeClose'] = '</pre>';

//big
$defaultPatterns['bigOpen'] = '/\[big\]/';
$defaultReplacements['bigOpen'] = '<span style="font-size:1.8em;font-weight:bold;">';
$defaultPatterns['bigClose'] = '/\[\/big\]/';
$defaultReplacements['bigClose'] = '</span>';


//[url]foo.com[/url]
$defaultPatterns['url1'] = '/\[url\](?!http:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/url\]/si';
$defaultReplacements['url1'] = '<a href="http://\\1">\\1</a>';

//[url]http://foo.com[/url]
$defaultPatterns['url2'] = '/\[url\]([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/url\]/si';
$defaultReplacements['url2'] = '<a href="\\1\\2">\\1\\2</a>';

//[url=foo.com]description[/url]
$defaultPatterns['url3'] = '/\[url=(?![0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+?)\[\/url\]/si';
$defaultReplacements['url3'] = '<a href="http://\\1">\\2</a>';

//[url=http://foo.com]description[/url]
$defaultPatterns['url4'] = '/\[url=([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+?)\[\/url\]/si';
$defaultReplacements['url4'] = '<a href="\\1\\2">\\3</a>';


//[email]jason@foo.com[/email]
$defaultPatterns['email1'] = '/\[email\]([\w\-\.\@]+)\[\/email\]/si';
$defaultReplacements['email1'] = '<a href="mailto:\\1">\\1</a>';

//[email=jason@foo.com]name[/email]
$defaultPatterns['email2'] = '/\[email=([\w\-\.\@]+)\](.+)\[\/email\]/si';
$defaultReplacements['email2'] = '<a href="mailto:\\1">\\2</a>';


//[img]local/foo.png[/img]
$defaultPatterns['img1'] = '/\[img\](?!http:\/\/)((?:[\w\-]+\.)*[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/img\]/si';
$defaultReplacements['img1'] = '<img src="\\1" alt="\\1"/>';

//[img]http://www.foo.com/foo.png[/img]
$defaultPatterns['img2'] = '/\[img\]([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\[\/img\]/si';
$defaultReplacements['img2'] = '<img src="\\1\\2" alt="\\1\\2" />';

//[img=local/foo.png]description[/img]
$defaultPatterns['img3'] = '/\[img=(?![0-9a-z]+:\/\/)((?:[\w\-]+\.)*[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+?)\[\/img\]/si';
$defaultReplacements['img3'] = '<img src="\\1" alt="\\2" />';

//[img=http://www.foo.com/dotdotdot/foo.png]description[/img]
$defaultPatterns['img4'] = '/\[img=([0-9a-z]+:\/\/)((?:[\w\-]+\.)+[\w]+(?:[\w\-\/\.\?=\+\&]*))\](.+)\[\/img\]/si';
$defaultReplacements['img4'] = '<img src="\\1\\2" alt="\\3" />';

//lists
//yet to be done

//tabular data
//yet to be done

//Do paragraphs as br tags
$defaultPatterns['linebreaks'] = '/^(.*)$/mi';
$defaultReplacements['linebreaks'] = '\\1<br />';




/***** 
 * mlmanDisplay($string, $userReplacements, $userPatterns)
 *
 * $string is the string to parse
 *
 * $userReplacements and $userPatterns are arrays
 * that replace the default patterns and replacements
 *****/
function mlmanDisplay($string, $userReplacements='', $userPatterns='') {
  global $defaultPatterns, $defaultReplacements;

  $patterns = array();
  $replacements = array();

  //build $patterns[] and $replacements[]
  //give precedence to $userPatterns and $usrReplacements

  $replacements = $defaultReplacements;
  if (is_array($userReplacements)) {
    foreach ($userReplacements as $key => $value) {
      $replacements[$key] = $value;
    }
  }

  $patterns = $defaultPatterns;  
  if (is_array($userPatterns)) {
    foreach ($userPatterns as $key => $value) {
	$patterns[$key] = $value;
    }
  }

  /*Debug - uncomment this section to see the final arrays
  print "<pre>";
  print_r($patterns);
  print_r($replacements);
  print "</pre>";
  */

  return stripslashes(preg_replace ($patterns, $replacements, $string));
}




/* mlmanDisplayHelp()
 * Display basic usage
 *
 * Customize look and feel by describing
 * div.mlmanDisplayHelp { } in your css style sheet
 */
function mlmanDisplayHelp() {
  print '<div class="mlmanDisplayHelp">';

  print '<h1>MLman tags</h1>';
  print '<p>[b]<strong>bold</strong>[/b] 
[i]<em>italic</em>[/i] 
[u]<span style="text-decoration:underline">underline</span>[/u]</p>';

  print '<p>[url]<a href="http://www.foo.com">www.foo.com</a>[/url] or <br />
[url=www.foo.com]<a href="http://www.foo.com">Foo inc.</a>[/url]</p>';

  print '</div>';
}

?>