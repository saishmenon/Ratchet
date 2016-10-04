<?php
	function votingapi_set_votes(&$votes, $criteria = NULL) {
		  $touched = array();
		  if (!empty($votes['entity_id'])) {
			$votes = array($votes);
		  }

		  // Handle clearing out old votes if they exist.
		  if (!isset($criteria)) {
			// If the calling function didn't explicitly set criteria for vote deletion,
			// build up the delete queries here.
			foreach ($votes as $vote) {
			  $tmp = votingapi_current_user_identifier();
			  $tmp += $vote;
			  if (isset($tmp['value'])) {
				unset($tmp['value']);
			  }
			  votingapi_delete_votes(votingapi_select_votes($tmp));
			}
		  }
		  elseif (is_array($criteria)) {
			// The calling function passed in an explicit set of delete filters.
			if (!empty($criteria['entity_id'])) {
			  $criteria = array($criteria);
			}
			foreach ($criteria as $c) {
			  votingapi_delete_votes(votingapi_select_votes($c));
			}
		  }

		  foreach ($votes as $key => $vote) {
			_votingapi_prep_vote($vote);
			$votes[$key] = $vote; // Is this needed? Check to see how PHP4 handles refs.
		  }

		  // Cast the actual votes, inserting them into the table.
		  votingapi_add_votes($votes);

		  foreach ($votes as $vote) {
			$touched[$vote['entity_type']][$vote['entity_id']] = TRUE;
		  }

		  if (variable_get('votingapi_calculation_schedule', 'immediate') != 'cron') {
			foreach ($touched as $type => $ids) {
			  foreach ($ids as $id => $bool) {
				$touched[$type][$id] = votingapi_recalculate_results($type, $id);
			  }
			}
		  }
		  return $touched;
		}
	if(isset($_POST["value"]))
	{
		$source = $_POST["source"];
		$id= $_POST["id"];
		$value = $_POST["value"];
		$votes = array("entity_id"=>$id,"value"=>$value,"vote_source"=>$source);
		votingapi_set_votes(&$votes);
		//echo json_encode($votes);
	}	
	else if(isset($_POST["down"])){
		echo "down";
	}
?>