<?php
	$dbName = $_POST["collection"];
	$vote = $_POST["vote"];
	$id = $_POST["dbID"];
	$username  = $_POST["username"];
	

	//connect to mongoDB
	$connection = new MongoClient( "mongodb://admin:admin@ds053684-a0.mongolab.com:53684,ds053684-a1.mongolab.com:53684/rit-vector-security?replicaSet=rs-ds053684" ); //connect to a remote host at a given port
	$databaseName = "rit-vector-security";
	$db = $connection->$databaseName;
	$collection = $db->$dbName;
	
	$find = array('dbID' => $id);
	$cursor = $collection->find($find);
	
	//update the vote section
	$collection->update(
		array("dbID" => $id),
		array('$push' => array("voteID" => $username))
		);
	if($vote==="plus")
	{
		$collection->update(
		array("dbID" => $id),
		array('$inc' => array("vote" => 1))
		);
	}
	else{
		$collection->update(
		array("dbID" => $id),
		array('$inc' => array("vote" => -1))
		);
	}
	

	echo "working";
	

?>