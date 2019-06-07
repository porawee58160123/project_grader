<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Problems extends CI_Model {	

	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */
   
	public $prob_id;
	public $prob_name;
	public $avail = 'Y';
	public $prob_order = null;
	public $description = null;
	public $attempt = 0;
	public $success = 0;
	
	public $last_insert_id;

	function __construct() {
		parent::__construct();				
	}
	
	 /*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
	*/
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO prob_info (prob_id, name, avail, prob_order, description, attempt, success)
				VALUES (?, ?, ?, ?, ?, ?, ?)";
		
		$this->db->query($sql, array($this->prob_id, $this->prob_name, $this->avail, $this->prob_order, $this->description, $this->attempt, $this->success));
		
	}
	function update() {
		$sql = "UPDATE prob_info
				SET	name = ?				
				WHERE prob_id = ? ";
		$this->db->query($sql, array($this->prob_name, $this->prob_id));
			
	}
	
	function delete() {
		$sql = "DELETE FROM prob_info
				WHERE prob_id = ? ";
				
		$this->db->query($sql, array($this->prob_id));
	}	

	/*
    |--------------------------------------------------------------------------
    | more function
    |--------------------------------------------------------------------------
    */

	function get_avail_lessons(){
		
		$sql = "SELECT * FROM prob_info WHERE avail = 'Y' order by prob_id ASC";
		$query = $this->db->query($sql, array($this->lessons_id));
				
		return $query;
	}


	function get_prob_by_id(){
		$sql = "SELECT * FROM prob_info WHERE prob_info.prob_id = ?";
		$query = $this->db->query($sql, array($this->prob_id));
				
		return $query;
	}

	function get_prob_pdf()	{
		$sql = "SELECT * FROM `prob_info` 
				LEFT JOIN prob_pdf on prob_pdf.pdf_prob_id = prob_info.prob_id
				LEFT JOIN lesson_prob on prob_info.prob_id = lesson_prob.prob_id 
				WHERE prob_info.prob_id = ?";
		$query = $this->db->query($sql, array($this->prob_id));
		return $query;
	}
	
}	
?>