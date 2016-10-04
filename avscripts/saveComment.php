<?php
	$dbName = $_POST["treeName"];
	$comment = $_POST["comment"];
	$id = $_POST["id"];
	$finalComment = "";
	
	//connect to mongoDB
	$connection = new MongoClient( "mongodb://admin:admin@ds053684-a0.mongolab.com:53684,ds053684-a1.mongolab.com:53684/rit-vector-security?replicaSet=rs-ds053684" ); //connect to a remote host at a given port
	$databaseName = "rit-vector-security";
	$db = $connection->$databaseName;
	$collection = $db->$dbName;
	
	$find = array('dbID' => $id);
	$cursor = $collection->find($find);
	
	foreach ($cursor as $doc) {
        $finalComment .= $doc["comment"];
		break;
	}
	
	if($finalComment == "")
	{
		$finalComment .= $comment;
	}
	else{
		$finalComment .= "|".$comment;
	}
	//update the comment section

	$collection->update(
	array("dbID" => $id),
	array('$set' => array("comment" => $finalComment))
	);

	echo $finalComment;
	

?>