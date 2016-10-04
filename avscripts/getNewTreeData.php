<?php 

//connect to mongoDB
$connection = new MongoClient("mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security");

$databaseName = "rit-vector-security";
$db = $connection->$databaseName;
$collection = $db->svgTest;

$cursor = $collection->find();

$return=array();
$i=0;
$find = $_GET["treeName"];
while($cursor->hasNext())
{
	$return[$i] = $cursor->getNext();
	// might not need the line below sinde _id is written to db
	$return[$i++][$find] = $cursor->key();
}


//http://shiflett.org/blog/2011/jun/sorting-multi-dimensional-arrays-in-php
$ids = array(); 
foreach ($return as $findIds) 
{    
	$ids[] = $findIds['id'];
}
array_multisort($ids, SORT_ASC, $return);


//print_r($return);
$return_json = json_encode($return);

echo $return_json;


?>
