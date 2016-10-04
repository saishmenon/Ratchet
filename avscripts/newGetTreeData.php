<?php 

include("getTreeDataClass.php");

//display error reporting
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//set up the first document name
$svg ="svgTest";
if(isset($_GET["treeName"])){
	$svg = $_GET["treeName"];
}

//object for the class
$cursor_obj = new FunctionClass();
$return = $cursor_obj->genCursorArray($svg);

//final array to be presented to user webpage
$formatedArray = array();

$return;

foreach($return as $key=>$value)
{
	if($key == 0){
		$formatedArray[0]["name"] = $value["name"];
		$formatedArray[0]["dbID"] = $value["dbID"];
		$formatedArray[0]["vote"] = $value["vote"];
		$formatedArray[0]["userVote"] = $value["userVote"];
		$formatedArray[0]["description"] = $value["description"];
		$formatedArray[0]["comment"] = $value["comment"];
		$formatedArray[0]["voteID"] = $value["voteID"];
		
	}
	//handles the collection with just 1 node (root)
	if(count($return)<=1)
	{
		$formatedArray[0]["children"] = array();
	}
   // else{
		foreach($value["children"] as $value2){
			if(strpos($value2,"trN")!== FALSE)
			{
				$documentName = explode("_",$value2);
				$genArray = $cursor_obj->genCursorArray($documentName[1]);
				$formatedArray[0]["children"][]=rec(1,$genArray);
			}
			else{
				$formatedArray[0]["children"][]=rec($value2,null);
			}
			
		}
	//}
	break;
}


function rec($ind,$array){
	global $return;
	global $cursor_obj;
	global $j;
	global $formatedArray;
	
	/*$indexTemp = explode("_",$index);
	if(count($indexTemp)>1)
	{
		$ind = $indexTemp[1];
	}
	else{
		$ind = $index;
	}
	*/
	
	$returnFinalArray;
	
	if($array == null){
		$innerReturn = $return;
	}
	else{
		$innerReturn = $array;
	}
	
	foreach($innerReturn[$ind-1] as $k=>$v){
		if(strcmp($k, "children")!=0)
		{
			$returnFinalArray[0][$k] = $v; 
		}
		else{
			
			if(count($v)>0)
			{
	
				foreach($v as $value2){
					if(strpos($value2,"trN")!=FALSE)
					{
						$documentName = explode("_",$value2);
						$genArray = $cursor_obj->genCursorArray($documentName[1]);
						$returnFinalArray[0]["children"][]=rec(1,$genArray);
					}
					else{
						$returnFinalArray[0]["children"][]=rec($value2,null);
					}
				}
			}
			else{

					//$length = count($v);
					$returnFinalArray[0][$k] = array();
			}
			
		}

		$keys = array_keys($innerReturn[$ind-1]);
		$last = end($keys);

		if(strcmp($last, $k)===0){
			return $returnFinalArray[0];
		}
		
	}
}


//print_r($return);
$return_json = json_encode($formatedArray[0]);

echo $return_json;


?>
