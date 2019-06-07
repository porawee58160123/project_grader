<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_SubmitDate extends CI_Model {

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

		$sql = "INSERT INTO submit_deadline 
				VALUES (?, ?, ?)";
		
		$this->db->query($sql, array($this->grp,$this->lessons_id, $this->due_date));
		$this->last_insert_id = $this->db->insert_id();
		
	}
	
	function update() {
		$sql = "UPDATE submit_deadline
				SET	due_date = ? ,
					grp = ?				
				WHERE lessons_id = ? ";
		$this->db->query($sql, array($this->due_date, $this->grp1, $this->lessons_id));
		$this->last_insert_id = $this->db->insert_id();	
		
	}

    function delete() {
		$sql = "DELETE FROM submit_deadline
				WHERE lessons_id = ? ";
				
		$this->db->query($sql, array($this->lessons_id));
	}	
    
    /*
    |--------------------------------------------------------------------------
    | more function
    |--------------------------------------------------------------------------
	*/
	
	
}