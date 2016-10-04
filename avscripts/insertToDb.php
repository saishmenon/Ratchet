<?php
//connect to mongoDB
$connection = new MongoClient( "mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security" ); //connect to a remote host at a given port
$databaseName = "rit-vector-security";
$db = $connection->$databaseName;
$collection = $db->test;
//count how many documents there are currently in the DB
//http://php.net/manual/en/mongocollection.count.php
$numDocuments = $collection->count();
//echo($numDocuments)

//increment the document count by one to get new unique ID for new document
$numDocuments++;

//create associatitive array to be inserted into the db  
//http://docs.mongodb.org/manual/reference/method/db.collection.insert/
//http://www.php.net/manual/en/mongo.tutorial.insert.php

//concatanate current ID onto name
$newName = $_POST["attackName"] . " " . $numDocuments;

$doc = array(
	"_id" => (string)$numDocuments,
	"id" => (string)$numDocuments,
	"name" => $newName,
	"data" => $_POST["description"],
	"adjacencies" => array ()
	);
	
$collection->insert($doc);

//edit the parent document to have an adjancey to the newly created document
//http://stackoverflow.com/questions/5370925/mongodb-in-php-how-do-i-insert-items-into-an-array-in-a-collection

$collection->update(
	array("id" => $_POST["parentID"]),
	array('$push' => array("adjacencies" => (string)$numDocuments))
	);
//return user to where they were
header('Location:http://ratchet.csec.rit.edu/node/2');
?>
