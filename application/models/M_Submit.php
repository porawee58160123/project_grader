<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Submit extends CI_Model {

    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
		*/
		public $id;
		public $grp;
		public $grp1;
		public $lessons_id;
		public $due_date;
		public $probid;
		public $code;
		public $sub_num;
		public $ipaddress;
		public $time;
		public $user_id;
		public $last_insert_id;	
		public $status;
    
    function __construct() {
			parent::__construct();				
    }
    
    /*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
    */
	
	function insert_status() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO grd_status (user_id, prob_id, res_id) VALUES (?,?,?)";		
		$query = $this->db->query($sql, array($this->id,$this->probid, $this->status));
		$this->last_insert_id = $this->db->insert_id();
				
		
		return $query;
	}

	function insert_queue() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO grd_queue (user_id, prob_id, sub_num) VALUES (?,?,?)";		
		$query = $this->db->query($sql, array($this->id,$this->probid, $this->sub_num));
		$this->last_insert_id = $this->db->insert_id();
		

		return $query;
	}
	
	function insert_submission() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO submission values (?,?,?,?,now(), ?,now())";		
		$query = $this->db->query($sql, array($this->ipaddress,$this->id,$this->probid, $this->sub_num, $this->code));
		$this->last_insert_id = $this->db->insert_id();

		return $query;
		
	}

	function update_status() {
		// if there is no auto_increment field, please remove it
		$sql = "UPDATE grd_status SET res_id= ? WHERE user_id= ? AND prob_id= ?";
		$query = $this->db->query($sql, array($this->status, $this->id, $this->probid));
		$this->last_insert_id = $this->db->insert_id();	

		return $query;
	}

	function update_queue() {
		// if there is no auto_increment field, please remove it
		$sql = "UPDATE grd_queue SET sub_num=? WHERE user_id=? AND prob_id=?";
		$query = $this->db->query($sql, array($this->sub_num, $this->id, $this->probid));
		$this->last_insert_id = $this->db->insert_id();	
			
		return $query;		
	}

	/*
    |--------------------------------------------------------------------------
    | more function
    |--------------------------------------------------------------------------
	*/
	function get_status_by_usid_pbid(){
		
		$sql = "SELECT * FROM grd_status WHERE user_id= ? AND prob_id= ?";
		$query = $this->db->query($sql, array($this->id, $this->probid));
		return $query;
	}

	function lock_tb_submission(){
		
		$sql = "LOCK TABLE submission WRITE, grd_queue WRITE, grd_status WRITE";
		$query = $this->db->query($sql);
				
		return $query;
	}

	function get_queue_by_usid_pbid(){
		
		$sql = "SELECT q_id FROM grd_queue WHERE user_id=? AND prob_id=?";
		$query = $this->db->query($sql, array($this->id, $this->probid));
				
		return $query;
	}

	function get_all_sub_by_usid_pbid(){
		
		$sql = "SELECT * from submission where user_id=? and prob_id=?";
		$query = $this->db->query($sql, array($this->id, $this->probid));
	
		return $query;
	
	}


	function unlock_tb(){
		
		$sql = "UNLOCK TABLES";
		$query = $this->db->query($sql);
				
		return $query;
	}

}
?>