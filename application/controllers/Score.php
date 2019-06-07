<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'Main.php';

class Score extends Main {

   /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */

    function __construct() {
        parent::__construct();
        if($this->session->userdata('type')  != 'A'){
            redirect(base_url().'index.php/Login/index');
        }
    }

    function score_total(){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | คะแนนทั้งหมด';
        $data['user_session'] = $session;
        $data['active'] = 'Score';
        $data['content'] = 'V_ScoreTotal';
        $data['score_total'] = $this->show_score_total();
        $this->load_view($data);
    }

    function score_problems(){

        $session = $this->session->userdata();
        $data['title'] = 'Grader | คะแนนรายโจทย์ปัญหา';
        $data['user_session'] = $session;
        $data['active'] = 'Score';
        $data['content'] = 'V_ScoreProblems';
        $data['problems_data'] = $this->show_problems();
        $this->load_view($data);

    }


    function get_score_data(){
        $this->load->model('M_Score','score_problem');
        $prob_id =  $this->input->post('prob_id');
        $this->score_problem->prob_id= $prob_id;
        $result = $this->score_problem->get_score_problem();
        $data = array();
        foreach($result->result() as $row){
            if($row->open_time != '' && $row->sub_time!= ''){
                $dteStart = new DateTime($row->open_time); 
                $dteEnd   = new DateTime($row->sub_time); 
                $dteDiff  = $dteStart->diff($dteEnd); 
                $display_date = $dteDiff->format("%d วัน %h ชั่วโมง %I นาที");
            }else{
                $display_date = "- วัน - ชั่วโมง - นาที";
            }
            array_push($data,array(
                'prob_id' => $row->prob_id,
                'prob_name' => $row->prob_name,
                'user_id' => $row->user_id,
                'name' => $row->name,
                'grp' => $row->grp,
                'open_time' => $row->open_time,
                'sub_time' => $row->sub_time,
                'time_diff' => $display_date,
                'sub_num' => $row->sub_num,
                'score' => $row->score,
            ));
        }
        echo json_encode($data);
    }


     /*
    |--------------------------------------------------------------------------
    | Date :8/2/2019
    | Author : Sukan Sittibamrungsuk
    | Modified :Porawee Limpongprasert
    | About :
    |--------------------------------------------------------------------------
    */

    function score_person($id){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | คะแนนรายบุคคล';
        $data['user_session'] = $session;
        $data['active'] = 'Score';
        $data['content'] = 'V_ScorePerson';

        /* ----------------------- score area ----------------------- */

        $this->load->model('M_Score','score_person');
        $this->score_person->user_id = $id;
        $person_prob = $this->score_person->get_person_prob();
        $score_person_prob = $this->score_person->get_score_person();

        if ($person_prob->num_rows() > 0) {
            foreach ($person_prob->result() as $row) {
                    $arrCheckSame[] = $row->prob_id;
                    $arrPatent[$row->prob_id]['lesson_id'] = $row->lesson_id;
                    $arrPatent[$row->prob_id]['lesson_name'] = $row->lesson_name;
                    $arrPatent[$row->prob_id]['prob_id'] = $row->prob_id;
                    $arrPatent[$row->prob_id]['prob_name'] = $row->prob_name;
                    $arrPatent[$row->prob_id]['time_spent'] = "";
                    $arrPatent[$row->prob_id]['sub_num'] = "";
                    $arrPatent[$row->prob_id]['score'] = "";
            }
            $data['score_person'] = $arrPatent;
            $data['check'] = 1;
        }
        if ($score_person_prob->num_rows() > 0) {
            foreach ($score_person_prob->result() as $row) {
                if($row->sub_open_time != '' && $row->sub_time!= ''){
                    $dteStart = new DateTime($row->sub_open_time); 
                    $dteEnd   = new DateTime($row->sub_time); 
                    $dteDiff  = $dteStart->diff($dteEnd); 
                    $display_date = $dteDiff->format("%d วัน %h ชั่วโมง %I นาที");
                }else{
                    $display_date = "- วัน - ชั่วโมง - นาที";
                }

                if (in_array($row->prob_id, $arrCheckSame)) {
                    $arrPatent[$row->prob_id]['lesson_id'] = $row->lesson_id;
                    $arrPatent[$row->prob_id]['prob_id'] = $row->les_prob_id;
                    $arrPatent[$row->prob_id]['prob_name'] = $row->prob_name;
                    $arrPatent[$row->prob_id]['time_spent'] =  $display_date;
                    $arrPatent[$row->prob_id]['sub_num'] = $row->sub_num;
                    $arrPatent[$row->prob_id]['score'] = $row->score;
                }
            }
            $data['score_person'] = $arrPatent;
            $data['check'] = 1;
        }
        /* ----------------------- score area ----------------------- */

        $data['person_info'] = $this->show_person_info($id);
        $data['person_lessons'] = $this->show_person_lessons($id);
        $data['person_prob'] = $this->show_person_prob($id);
        $this->load_view($data);

    }

     /*
    |--------------------------------------------------------------------------
    | Date :8/2/2019
    | Author : Porawee Limpongprasert
    | Modified :-
    | About :
    |--------------------------------------------------------------------------
    */

    function show_score_total(){
        $this->load->model('M_Score','score_total');
        return $this->score_total->get_score_total();
    }

    function show_person_info($id){
        $this->load->model('M_Score','person_info');
        $this->person_info->user_id = $id;
        $person_info = $this->person_info->get_person_info();
        return $person_info->result()[0];
    }

    function show_person_lessons($id){
        $this->load->model('M_Score','person_lessons');
        $this->person_lessons->user_id = $id;
        return $this->person_lessons->get_person_lessons();
    }

    function show_person_prob($id){
        $this->load->model('M_Score','person_prob');
        $this->person_prob->user_id = $id;
        return $this->person_prob->get_person_prob();
    }

    function show_problems(){
        $this->load->model('M_Score','problems_data');
        return $this->problems_data->get_problems();
    }

}
?>
