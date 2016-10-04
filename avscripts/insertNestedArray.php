<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$connection = new MongoClient( "mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security" ); //connect to a remote host at a given port
$databaseName = "rit-vector-security";
$db = $connection->$databaseName;

$collection = $db->attackTrees;

$query = array( '_id' => $_POST["newDocTitle"]);
//$update = array( '$addToSet' => array('action.'.'._id' => array('breakOpen') ));
$update = array('$addToSet' => array('action' => array('_id' =>'BreakIn','other' => '4','3' => 'three')));

$collection->update($query, $update);

header('Location:http://insomnia.no-ip.org/?q=node/1');
?>
