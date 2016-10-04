<?php
	$dbName = $_POST["treeName"];
	$newDescription = $_POST["description"];
	$id = $_POST["id"];

	//connect to mongoDB
	$connection = new MongoClient( "mongodb://admin:admin@ds053684-a0.mongolab.com:53684,ds053684-a1.mongolab.com:53684/rit-vector-security?replicaSet=rs-ds053684" ); //connect to a remote host at a given port
	$databaseName = "rit-vector-security";
	$db = $connection->$databaseName;
	$collection = $db->$dbName;
	
	//update the description section

	$collection->update(
	array("dbID" => $id),
	array('$set' => array("description" => $newDescription))
	);

	echo "working $id $newDescription $dbName";
	

?>