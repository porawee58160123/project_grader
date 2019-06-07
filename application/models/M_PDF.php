<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_PDF extends CI_Model {	

	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */	
    public $pdf_id;
    public $pdf_prob_id;
    public $pdf_name;
	public $pdf_data;
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
		$sql = "INSERT INTO prob_pdf 
				VALUES ('', ?, ?, ?, CURRENT_TIMESTAMP)";
		
		$this->db->query($sql, array( $this->pdf_prob_id, $this->pdf_name, $this->pdf_data));
		
	}
	
	 function update() {
			$sql = "UPDATE `prob_pdf` 
					SET `pdf_name`= ?,`pdf_data`= ?,`create_pdf_date`= CURRENT_TIMESTAMP  
					WHERE pdf_prob_id = ?";
		$this->db->query($sql, array( $this->pdf_name, $this->pdf_data, $this->pdf_prob_id));
	 	$this->last_insert_id = $this->db->insert_id();		
	 }
	
	function delete() {
		$sql = "DELETE FROM prob_pdf
				WHERE pdf_id = ? ";
		$this->db->query($sql, array($this->pdf_id));
	}	
	function delete_by_prob_id() {
		$sql = "DELETE FROM prob_pdf
				WHERE pdf_prob_id = ? ";
		$this->db->query($sql, array($this->pdf_prob_id));
    }	
	
    /*
    |--------------------------------------------------------------------------
    | more function
    |--------------------------------------------------------------------------
	*/
	
	function get_pdf_by_id(){
		$sql = "SELECT * FROM prob_pdf WHERE prob_pdf.pdf_prob_id = ?";
		$query = $this->db->query($sql, array($this->pdf_prob_id));
				
		return $query;
	}
}	
?>