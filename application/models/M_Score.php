<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Score extends CI_Model {
	/*
    |--------------------------------------------------------------------------
    | Date :8/02/2019
    | Author : Porawee Limpongprasert
    | Modified :-
    |--------------------------------------------------------------------------
    */

    public $user_id;
    public $prob_id;

    function get_score_total(){
        $sql = "SELECT user_info.user_id , user_info.name , user_info.grp , SUM(score) AS total_score FROM user_info
        LEFT JOIN grd_status ON user_info.user_id = grd_status.user_id
        GROUP BY grd_status.user_id
        ORDER BY total_score  DESC";
		$query = $this->db->query($sql);
		return $query;
    }

    function get_person_info(){
        $sql = "SELECT user_info.user_id as user_id,user_info.name as student_name,user_info.grp as student_group FROM user_info 
        WHERE user_info.user_id = ? ";
        $query = $this->db->query($sql,array($this->user_id));
        return $query;
    }

    function get_person_lessons(){
        $sql = "SELECT submit_deadline.lessons_id AS dead_les_id,
                lesson_prob.lesson_id AS les_id,
                lessons.id AS lesson_id,
                lessons.active AS les_active,
                lesson_prob.prob_id AS les_prob_id,
                lessons.name AS lesson_name,
                prob_info.prob_id,
                prob_info.name AS prob_name,
                submit_deadline.grp AS dead_grp,
                user_info.grp AS student_grp,
                user_info.user_id AS student_id
        FROM user_info,submit_deadline
        LEFT JOIN lesson_prob ON submit_deadline.lessons_id = lesson_prob.lesson_id
        LEFT JOIN lessons ON lesson_prob.lesson_id = lessons.id
        LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
        WHERE (submit_deadline.grp = user_info.grp OR submit_deadline.grp = '*') AND user_info.user_id = ? 
        GROUP BY lesson_id ";
        $query = $this->db->query($sql,array($this->user_id));
        return $query;
    }

    function get_person_prob(){
        $sql = "SELECT submit_deadline.lessons_id AS dead_les_id,
                lesson_prob.lesson_id AS les_id,
                lessons.id AS lesson_id,
                lessons.active AS les_active,
                lessons.name AS lesson_name,
                lesson_prob.prob_id AS les_prob_id,
                prob_info.prob_id,
                prob_info.name AS prob_name,
                submit_deadline.grp AS dead_grp,
                user_info.grp AS student_grp,
                user_info.user_id AS student_id
        FROM user_info,submit_deadline
        LEFT JOIN lesson_prob ON submit_deadline.lessons_id = lesson_prob.lesson_id
        LEFT JOIN lessons ON lesson_prob.lesson_id = lessons.id
        LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
        WHERE (submit_deadline.grp = user_info.grp OR submit_deadline.grp = '*') AND user_info.user_id = ?
        ";
        $query = $this->db->query($sql,array($this->user_id));
        return $query;
    }

    function get_score_person(){
        $sql = "SELECT submit_deadline.lessons_id AS dead_les_id ,
                lesson_prob.lesson_id AS les_id,
                lessons.id AS lesson_id,
                lessons.active AS les_active ,
                lessons.name AS lesson_name,
                lesson_prob.prob_id AS les_prob_id,
                prob_info.prob_id ,
                prob_info.name AS prob_name,
                user_info.grp AS user_grp  ,
                submit_deadline.grp AS dead_grp,
                grd_status.prob_id AS grd_prob_id ,
                grd_status.user_id AS grd_user_id ,
                user_info.user_id ,
                grd_status.score ,
                MAX(submission.sub_num) AS sub_num,
                MAX(submission.time) AS sub_time,
                (SELECT sub.open_time FROM submission sub WHERE sub.sub_num = 0 AND sub.user_id = ? AND sub.prob_id = prob_info.prob_id) AS sub_open_time
        FROM submit_deadline
        LEFT JOIN lesson_prob ON submit_deadline.lessons_id = lesson_prob.lesson_id
        LEFT JOIN lessons ON lesson_prob.lesson_id = lessons.id
        LEFT JOIN prob_info ON lesson_prob.prob_id = prob_info.prob_id
        LEFT JOIN grd_status ON lesson_prob.prob_id = grd_status.prob_id
        LEFT JOIN user_info ON grd_status.user_id = user_info.user_id
        LEFT JOIN submission ON user_info.user_id = submission.user_id
        WHERE user_info.user_id = ? AND lesson_prob.prob_id = submission.prob_id
        GROUP BY submission.prob_id
        " ;
        $query = $this->db->query($sql,array($this->user_id,$this->user_id));
        return $query;
    }

    function get_problems(){
        $sql = "SELECT prob_id,prob_info.name AS prob_name FROM prob_info";
		$query = $this->db->query($sql);
		return $query;
    }

    function get_score_problem(){
        $sql = "SELECT user_info.user_id ,submission.user_id ,grd_status.user_id ,submission.prob_id,grd_status.prob_id,prob_info.name AS prob_name ,user_info.name,user_info.grp,MAX(submission.sub_num) AS sub_num, grd_status.score,
        (SELECT sub.open_time FROM submission sub WHERE sub.sub_num = 0 AND sub.user_id = user_info.user_id AND sub.prob_id = ?) AS open_time,
        MAX(submission.time) AS sub_time
                FROM submission
                LEFT JOIN user_info ON submission.user_id = user_info.user_id
                LEFT JOIN grd_status ON submission.user_id = grd_status.user_id
                LEFT JOIN prob_info ON submission.prob_id = prob_info.prob_id
                WHERE submission.prob_id = ? AND submission.prob_id = grd_status.prob_id
                GROUP BY submission.user_id";
        $query = $this->db->query($sql,array($this->prob_id,$this->prob_id));
        return $query;
    }

}

?>