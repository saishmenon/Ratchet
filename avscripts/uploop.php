<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$connection = new MongoClient( "mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security" ); //connect to a remote host at a given port
$databaseName = "rit-vector-security";
$db = $connection->$databaseName;

$collection = $db->attackTrees;

//update the selected document. $addToSet - only update if does not exist.

$doc = array( '_id' => $_POST["newDocTitle"],
	'title' => 'haxin',
	'friends' => array('bernie', 'alvin'),
	'followers' => 18,
	'action' => array(array( '_id'=> 'Pick Lock','Pick Lock' => "tim"),array( '_id' => 'GetCombo','GetCombo' => 'yes'))
);

$collection->insert($doc);

header('Location:http://insomnia.no-ip.org/?q=node/1');
?>
