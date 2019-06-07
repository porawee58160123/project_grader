<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_LessonsProblems extends CI_Model {		

	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */
	
    public $lessons_id;
	public $prob_id;
	public $active;
	public $rank = 0; // set default rank 
	public $limit;
	
	function __construct() {
		parent::__construct();				
    }
    /*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
	*/
	
	
	function insert() {
		$sql = "INSERT INTO lesson_prob 
				VALUES (?, ?, ?, ?, ?)";
		
		$this->db->query($sql, array($this->lessons_id, $this->prob_id, $this->active, $this->rank, $this->limit));
	}
	
	 function update() {
        $sql = "UPDATE lesson_prob
			SET	 active = ?, lesson_prob.limit = ?				
			WHERE lesson_id = ? and prob_id = ? ";
		$this->db->query($sql, array($this->active, $this->limit, $this->lessons_id, $this->prob_id));
	 	$this->last_insert_id = $this->db->insert_id();		
	 }
	
	function delete() {
		$sql = "DELETE FROM lesson_prob
				WHERE lesson_id = ? and prob_id = ?";
		$this->db->query($sql, array($this->lessons_id, $this->prob_id));
    }	

    
    /*
    |--------------------------------------------------------------------------
    | more function 
    |--------------------------------------------------------------------------
    */
    
    function get_lessons_prob(){

        $sql = "SELECT lesson_prob.lesson_id,lesson_prob.prob_id,prob_info.name,lesson_prob.active,lesson_prob.limit FROM lesson_prob 
                LEFT JOIN lessons ON lesson_prob.lesson_id = lessons.id
                LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
                LEFT JOIN submit_deadline ON lesson_prob.lesson_id = submit_deadline.lessons_id
                WHERE lesson_prob.lesson_id = ? AND submit_deadline.grp = ?";
        $query = $this->db->query($sql,array($this->lessons_id,$this->grp));

        return $query;
    }

    function get_by_less_prob_id(){
        $sql ="SELECT * FROM lesson_prob
               WHERE lesson_id = ? AND prob_id = ?";
		$query = $this->db->query($sql, array($this->lessons_id, $this->prob_id));
        return $query;
    }

    function get_less_prob_by_id(){
        $sql = "SELECT * fROM lesson_prob
                WHERE lesson_id = ?";
        $query = $this->db->query($sql, array( $this->lessons_id));
        return $query;
    }

	
}	
?>