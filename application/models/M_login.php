<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Login extends CI_Model {	

	/*
    |--------------------------------------------------------------------------
    | Date : 
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */	
	
	// PK is pf_id

	function __construct() {
		parent::__construct();				
	}
	/*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
    */
	function verify_user(){
		$sql = "select * from user_info where user_id=?";
		$query = $this->db->query($sql, array($this->user_id));
		return $query;
	  }

	
}	
?>