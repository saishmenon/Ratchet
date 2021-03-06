<?php
	$dbName = $_POST["dbName"];
	$name = $_POST["name"];
	$description = $_POST["description"];
	
	//connect to mongoDB
	$connection = new MongoClient( "mongodb://admin:admin@ds053684-a0.mongolab.com:53684,ds053684-a1.mongolab.com:53684/rit-vector-security?replicaSet=rs-ds053684" ); //connect to a remote host at a given port
	$databaseName = "rit-vector-security";
	$db = $connection->$databaseName;
	$collection = $db->createCollection(
					$dbName,
					array()
				);
	//count how many documents there are currently in the DB
	//http://php.net/manual/en/mongocollection.count.php
	$numDocuments = $collection->count();
	//echo($numDocuments)

	//increment the document count by one to get new unique ID for new document
	$numDocuments++;
	
	$doc = array(
	"_id" => (string)$numDocuments,
	"dbID" => (string)$numDocuments,
	"name" => $name,
	"vote" => 0,
	"userVote"=>"down",
	"description" => $description,
	"children" => array (),
	"comment" => "",
	"voteID"=> array()
	);

	$collection->insert($doc);

?>