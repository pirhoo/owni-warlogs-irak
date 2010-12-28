<?php

Class WLratings {
	
	var $status = "200 OK";
	var $error = false;
	var $session = "";
	var $message = "";
	var $reportKey = "";
	var $warlog;
	var $WL_ratings_criteria;
	var $ratings = array();
	var $sessions = 0;
	var $my_ratings = array();
	var $my_evaluation = "";
	var $db;
	
	function __construct ($reportKey) {
		global $WL_ratings_criteria;
                
		$this->session = session_id();
		
		if (empty($this->session)) {
			$this->message = "could not find/create session";
			$this->error = true;
			return false;
		}
		
		$this->WL_ratings_criteria = $WL_ratings_criteria;
		$this->reportKey = htmlentities($reportKey, ENT_QUOTES, "UTF-8");
		
		global $mysql;
		$this->db = new Mydb ($mysql["host"], $mysql["database"], $mysql["user"], $mysql["password"]);
		
		$this->db->query("SELECT * FROM  `war_diary` as d LEFT JOIN `war_evaluations` as i ON i.`ReportKey` = d.`ReportKey` WHERE d.`ReportKey` = '".$this->reportKey."'");
		if ($this->warlog = $this->db->fo()) {
			$this->my_evaluation = $_SESSION["my_evaluation_".$this->reportKey];
			$this->get_ratings();
			return $this->warlog;
		}
		else {
			$this->message = $db->getErr_query();
			$this->error = true;
			return false;
		}
	}
	
	function get_ratings () {
		$this->db->query("SELECT * FROM `war_ratings` WHERE `ReportKey` = '".$this->reportKey."'");
		
		for ($i=0; $i<count($this->WL_ratings_criteria); $i++) {
			if ($i==0) $this->ratings [$i] = null;
			else $this->ratings [$i] = 0;
		}
		
		$sessions = array();
		while ($rating = $this->db->fo()) {
			if (!in_array($rating->session_id,$sessions))
				$sessions[] = $rating->session_id;
				
			if ($rating->session_id == $this->session)
				$this->my_ratings[$rating->criteria_id] += $rating->rating;
				
			$this->ratings[$rating->criteria_id] += $rating->rating;
		}
		$this->sessions = count($sessions);
		
		return $this->ratings;
	}
	
	function set_evaluation ($evaluation) {
            
		/*  UPDATE/INSERT conditional  */
		if (!$this->warlog->positive AND !$this->warlog->negative) {
			// insert
			if (!$this->db->query("INSERT INTO `war_evaluations` (`ReportKey`, `positive`, `negative`)
				VALUES ('".$this->reportKey."', ".($evaluation=="positive" ? 1 : 0).", ".($evaluation=="negative" ? 1 : 0).")")) {
				$this->message = $db->getErr_query();
				$this->error = true;
			}
		}
		else {
			// update
			if (!$this->db->query("UPDATE `war_evaluations` SET
				  `positive` = `positive`+".($evaluation == "positive" ? 1 : 0)."
				, `negative` = `negative`+".($evaluation == "negative" ? 1 : 0)."
				WHERE `ReportKey` = '".$this->reportKey."' LIMIT 1")) {
				$this->message = $db->getErr_query();
				$this->error = true;
			}
		}
                
		$_SESSION["my_evaluation_".$this->reportKey] = $this->my_evaluation = $evaluation;
		
		return !$this->error;
	}
	
	function score () {
		return $this->db->query("UPDATE `war_evaluations` SET `score` = `score`+1 WHERE `ReportKey` = '".$this->reportKey."' LIMIT 1");
	}
	
	function set_ratings ($ratings) {
            
		for ($i=1; $i<count($this->WL_ratings_criteria); $i++) {
			
			$rating = ($ratings[$i-1] == "true") ? 1 : 0;
                        
			if ($rating) $this->score();
                        
			if (!$this->db->query("INSERT INTO `war_ratings` (`id` , `ReportKey` ,`session_id` ,`timestamp` ,`criteria_id` ,`rating`)
                                               VALUES (NULL , '".$this->reportKey."', '{$this->session}', CURRENT_TIMESTAMP , '$i', '$rating');")) {
				$this->message = $db->getErr_query();
				$this->error = true;
				break;
			}
                        
			$_SESSION["my_ratings_".$i] = $this->my_ratings[$i] = $rating;
			$_SESSION["my_ratings"] = true;
		}
		return !$this->error;
	}
}
?>