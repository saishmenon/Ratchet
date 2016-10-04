<?php 

//connect to mongoDB
$connection = new MongoClient("mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security");

$databaseName = "rit-vector-security";
$db = $connection->$databaseName;
$collection = $db->test;

//http://stackoverflow.com/questions/9623593/pass-javascript-variable-to-php-code
$myval = $_POST['variable'];
// do something

//http://php.net/manual/en/mongocollection.find.php

$docQuery = array('id' => $myval);
$cursor = $collection->find($docQuery); 

foreach($cursor as $result)
  {
	//echo $result['data'];
	$return_json = json_encode($result);

	echo $return_json;
    //echo sprintf("ID: %s, Data: %s%s", $result['id'], $result['data'], PHP_EOL);
  }
  

?>
