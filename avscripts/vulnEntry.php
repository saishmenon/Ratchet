<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$connection = new MongoClient( "mongodb://matt:\$RITattacktrees\$@ds045137.mongolab.com:45137/rit-vector-security" ); //connect to a remote host at a given port
$databaseName = "rit-vector-security";
$db = $connection->$databaseName;

$collection = $db->cvuln;

$doc = array (
                "vulnTitle" => $_POST["vTitle"],
                "cve" => $_POST["cve"],
                "av" => $_POST["affectedVersions"]
);

$collection->insert( $doc );

?>
