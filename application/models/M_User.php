<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_User extends CI_Model {
	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */
    
	public $user_id;
	public $name;
	public $passwd;
	public $grp;
	public $type;
	public $scid;
	public $ipaddr;
	
	function __construct() {
		parent::__construct();				
    }
    
    /*
    |--------------------------------------------------------------------------
    | base function
    |--------------------------------------------------------------------------
    */
    function insert(){
      $sql = "INSERT INTO `user_info` (`user_id`, `name`, `passwd`, `grp`, `type`, `scid`, `ipaddr`)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
      $this->db->query($sql,array($this->user_id, $this->name, $this->passwd, $this->grp, $this->type, $this->scid, $this->ipaddr));
    }
    function update(){
      $sql = "UPDATE user_info
              SET	`name` = ?, `grp` = ?, passwd = ?				
              WHERE user_id = ? ";
      $this->db->query($sql, array($this->name, $this->grp, $this->passwd, $this->user_id));
    }
	
    function update_password() {
        $sql = "UPDATE user_info
                SET	passwd = ?				
                WHERE user_id = ? ";
        $this->db->query($sql, array($this->passwd, $this->user_id));	
    }
    function delete(){
      $sql = "DELETE FROM user_info
				      WHERE `user_id` = ? ";
      $this->db->query($sql, array($this->user_id));
    }
    
    /*
    |--------------------------------------------------------------------------
    | more function
    |--------------------------------------------------------------------------
    */
    function verify_user(){
      $sql = "select * from user_info where user_id=?";
      $query = $this->db->query($sql, array($this->user_id));
      return $query;
    }
    function get_user_data(){
      $sql = "SELECT * FROM `user_info`";
      $query = $this->db->query($sql);
      return $query;
    }
	
}