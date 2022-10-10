<?php

function findfullage($byear,$bmonth,$bday,$bhour,$bmin)
{ 
$yeardiff = date("Y") - $byear;
$monthdiff = date("m") - $bmonth;
$daydiff = date("j") - $bday;
$hourdiff=date("G")-$bhour;
$mindiff=date("i")-$bmin;
$lastmonth = date("t",mktime(0, 0, 0, date("m")-1, date("d"),  date("Y")));
/*
 * if month or day is negative we have yet to reach it so
 * we need to subtract a year seeing we haven't
 * reached our birthday yet, else yeardiff is correct
 */

if(($monthdiff < 0)||($monthdiff==0 && (($daydiff<0)||($daydiff==0&&(($hourdiff<0)||($hourdiff==0&&$mindiff<0)))) )){
   $year = $yeardiff - 1;
}
else {
   $year = $yeardiff;
}

$monthminus=0;
if (($daydiff<0)||($daydiff==0&& (($hourdiff<0)||($hourdiff==0&&$mindiff<0)) ))
   $monthminus=1;

if($monthdiff<0||($monthdiff==0&&$monthminus==1)){
   $month = $monthdiff + 12-$monthminus;
}
else{
   $month = $monthdiff-$monthminus;
}


$dayminus=0;
if (($hourdiff<0)||($hourdiff==0&&$mindiff<0)) $dayminus=1;

if (($daydiff<0)||($daydiff==0&& $dayminus==1)){
   $day=$daydiff+$lastmonth-$dayminus;
}
else{
   $day=$daydiff-$dayminus;
}

$hourminus=0;
if($mindiff<0) $hourminus=1;

if (($hourdiff<0)||($hourdiff==0&&$hourminus==1)){
   $hour=$hourdiff+24-$hourminus;
}
else{
   $hour=$hourdiff-$hourminus;
}

if($mindiff<0){
   $min=$mindiff+60;
}
else{
   $min=$mindiff;
}



$sec=date("s");

$months=" months, ";
if ($month==1) $months=" month, ";
$days=" days, ";
if ($day==1) $days=" day";
$hours=" hours, ";
if ($hour==1) $hours=" hour, ";
$mins=" minutes, and ";
if ($min==1) $mins=" minute, and ";
$secs=" seconds.<br>";
if ($sec==1) $secs=" second.<br>";

return "Age: ".$year." years, ".$month.$months.$day.$days.$hour.$hours.$min.$mins.$sec.$secs;
//$month." ".$day." ".$hour." ".$min." ".$sec."<br>"; 
}

 ?>

