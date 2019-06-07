<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Lessons extends CI_Model {		

	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */
	
    // PK is pf_id
    
    public $lessons_id;
	public $prob_id;
	public $name;
	public $date;
	public $active;
	public $rank = 0; // set default rank 
	public $limit;
	public $avail;
	public $prob_order;
	public $description;
	public $attempt;
	public $success;
	public $group;
	public $due_date;	
	
	function __construct() {
		parent::__construct();				
    }
    /*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
	*/
	
	
	function insert() {
		$sql = "INSERT INTO lessons
				VALUES (?, ?, ?, ?, ?)";
		
		$this->db->query($sql, array($this->lessons_id, $this->name, $this->date, $this->active, $this->rank));
		$this->last_insert_id = $this->db->insert_id();		
		
	}
	
	 function update() {
			$sql = "UPDATE lessons
			SET	name = ?, active = ?, rank = ?				
			WHERE id = ? ";
		$this->db->query($sql, array($this->name, $this->active, $this->rank, $this->lessons_id));
	 	$this->last_insert_id = $this->db->insert_id();		
	 }
	
	function delete() {
		$sql = "DELETE FROM lessons
				WHERE id = ? ";
		$this->db->query($sql, array($this->lessons_id));
    }	
    /*
    |--------------------------------------------------------------------------
    | more function 
    |--------------------------------------------------------------------------
    */
    
    function get_lessons(){

        $sql = "SELECT * FROM lessons 
		LEFT JOIN submit_deadline ON lessons.id = submit_deadline.lessons_id ORDER BY submit_deadline.due_date ASC";
        $query = $this->db->query($sql);

        return $query;
	}
	
	function get_lessons_sub_date(){
		
		$sql = "SELECT * FROM lessons 
		LEFT JOIN submit_deadline ON lessons.id = submit_deadline.lessons_id
		WHERE id = ?";
		$query = $this->db->query($sql, array($this->lessons_id));
				
		return $query;
	}
	function get_by_lessons_id(){
		$sql = "SELECT * FROM lessons 
				WHERE id = ?";
		
		$query = $this->db->query($sql, array($this->lessons_id));
		return $query ;
		
	}

	function verify_name_less(){
		$sql = "SELECT * FROM lessons 
				WHERE `name` = ?";
		
		$query = $this->db->query($sql, array($this->name));
		return $query ;
	}
	
}	
?>