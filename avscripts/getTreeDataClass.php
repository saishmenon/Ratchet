<?php

class FunctionClass
	{
		
		public static function genCursorArray($name)		//function generate the array for the document
		{
			//connect to mongoDB
			$connection = new MongoClient("mongodb://admin:admin@ds053684-a0.mongolab.com:53684,ds053684-a1.mongolab.com:53684/rit-vector-security?replicaSet=rs-ds053684");

			$svg = $name;

			$databaseName = "rit-vector-security";
			$db = $connection->$databaseName;
			$collection = $db->$svg;

			$cursor = $collection->find();
			$cursor->sort(array("dbID"=>1));
			
			$return=array();
			$i=0;
			while($cursor->hasNext())
			{
				$return[$i] = $cursor->getNext();
				$i++;
			}

			//fix the sorting, php mongo sort function not working?
			$ids = array(); 
			foreach ($return as $findIds) 
			{    
				$ids[] = $findIds['dbID'];
			}
			array_multisort($ids, SORT_ASC, $return);
			
			return $return;
		
		}
	}

?>