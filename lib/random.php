<?php

/*Fimion's Randomainiolizier*/

function randphrase()
{
$noun1 = array("The frog ","A tree ","A mountain ","A monk ","The woman ","A child ","A snake ","A midget ","A king ","a monkey ","A man ","A reed ","A person ","The lion ","The one ","A friend ","A mob ");
$verb1 = array("inside ","coveting ","holding ","walking on ","carrying ","wandering in ","immersed in ","praying to ","floating on ","speaking to ","seeking ","when eating ","who knows ","who needs ","asking for ","arguing over ","lusting for ","wishing for ","washing ");
$noun2 = array("the wind ","a dream ","a cloud ","the sea ","a rock ","a dollar ","a fork ","a cup of tea ","a basket of wheat ","a puddle of mud ","a mirror ","a bottle of ginseng ","wisdom ","a fly ","a cow ","the forest ","the desert ","a hot bath ");
$yesorno = array("never ","always ","seldom ","usually ","happily ","normally ","frequently ");
$verb2 = array("steals ","catches ","pushes ","kills ","destroys ","pursues ","embraces ","plays with ","walks on ","angers ","comments on ","negotiates with ","converses with ","trips ","recieves ","confuses it with ","betrays ","bends ","uses ","abuses ", "makes peace with ");
$noun3 = array("a dog.","a dragon.","a brother.","a horse.","a mother.","a priest.","an owl.","a flower.","a monkey.","a llama.","God.","humanity.","a spoon.","a superior being.","a warrior.","a sword","an ally.");
srand((float) microtime() * 10000000);
print $noun1[array_rand($noun1)].$verb1[array_rand($verb1)].$noun2[array_rand($noun2)].$yesorno[array_rand($yesorno)].$verb2[array_rand($verb2)].$noun3[array_rand($noun3)];
}

function randword()
{
	global $db;
	/* Performing SQL query */
	$query = "SELECT * FROM fimii_words";
	$result = $db->sql_query($query) or die("Query failed : " . $db->sql_error());
	
	$db->sql_rowseek(rand(1,$db->sql_numrows($result)),$result);
	$row=$db->sql_fetchrow($result);
	/* Printing results in HTML */
	$rword=$row['word'];
	$rpos=$row['pos'];
	$rdef=$row['definition'];
	
	
	/* Free resultset */
	$db->sql_freeresult($result);
	
	return $rword." - ".$rpos.": ".$rdef;
}


?>
