<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_UserProblems extends CI_Model {		

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
    public $grp;
    public $user_id;
    public $time;
    public $code;
    

	
	function __construct() {
		parent::__construct();				
    }

    function insert_open_pdf()
    {
        $sql = "INSERT INTO `submission` ( `user_id`, `prob_id` ) 
                VALUES (?, ?)";
        $query = $this->db->query($sql,array($this->user_id,$this->prob_id));
    }

    function check_first_open_pdf($user_id,$prob_id){
        $sql ="SELECT * FROM submission WHERE submission.user_id = '$user_id' AND submission.prob_id = '$prob_id' AND submission.sub_num = 0";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_msg($user_id,$prob_id){
        $sql = "SELECT * FROM grd_status WHERE user_id = '$user_id' AND prob_id = '$prob_id'";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function get_user_prob(){
        $sql = "SELECT submit_deadline.grp as sub_grp, user_info.grp as user_grp, user_info.user_id AS user_info_id , 
        user_info.name AS user_name , 
        user_info.grp AS user_group ,
        submit_deadline.grp AS deadline_grp , 
        submit_deadline.lessons_id AS deadline_les_id , 
        submit_deadline.due_date, 
        lesson_prob.lesson_id ,
        lesson_prob.prob_id AS les_prob_id ,
        lesson_prob.limit,
        prob_info.prob_id ,
        prob_info.name AS prob_name,
        prob_pdf.pdf_data 
        from user_info,submit_deadline
        LEFT JOIN lesson_prob ON submit_deadline.lessons_id = lesson_prob.lesson_id
        LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
        LEFT JOIN prob_pdf ON prob_info.prob_id = prob_pdf.pdf_prob_id  
        WHERE user_info.user_id = ? AND submit_deadline.lessons_id = ? AND lesson_prob.active = 1";

        $query = $this->db->query($sql,array($this->user_id,$this->lessons_id));
        return $query;
    }

    function get_user_submit(){
        $sql = "SELECT submit_deadline.lessons_id AS dead_les_id ,
                lesson_prob.lesson_id ,
                lesson_prob.active AS les_active ,
                lesson_prob.prob_id AS les_prob_id,
                lesson_prob.limit,
                prob_info.prob_id ,
                prob_info.name AS prob_name,
                prob_pdf.pdf_data ,
                grd_status.prob_id AS grd_prob_id ,
                grd_status.score ,
                grd_status.user_id AS grd_user_id ,
                grd_status.grading_msg,
                grd_status.compiler_msg,
                user_info.user_id , 
                user_info.grp AS user_grp  ,
                user_info.name AS user_name , 
                submit_deadline.grp AS dead_grp ,
                submit_deadline.due_date
                FROM submit_deadline
                LEFT JOIN lesson_prob ON submit_deadline.lessons_id = lesson_prob.lesson_id
                LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
                LEFT JOIN prob_pdf ON prob_info.prob_id = prob_pdf.pdf_prob_id
                LEFT JOIN grd_status ON lesson_prob.prob_id = grd_status.prob_id
                LEFT JOIN user_info ON grd_status.user_id = user_info.user_id
                WHERE user_info.user_id = ? AND lesson_prob.lesson_id = ?
                ";
            $query = $this->db->query($sql,array($this->user_id,$this->lessons_id));
            return $query;
    }

    function get_sub_num(){
        $sql = "SELECT MAX(sub_num) as sub_num FROM `submission` WHERE user_id = ? and prob_id = ?";
        $query = $this->db->query($sql, array($this->user_id, $this->prob_id));
        return $query;
    }
}
?>
