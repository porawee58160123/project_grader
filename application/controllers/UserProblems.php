<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'Main.php';
class UserProblems extends Main {

    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */

    function __construct() {
        parent::__construct();
        if($this->session->userdata('type') != 'C'){
            redirect(base_url().'index.php/Login/index');
        }
    }

    public function index(){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | นิสิต';
        $data['user_session'] = $session;
        $data['active'] = '';
        $data['user_lesson'] = $this->user_lesson();
        $data['content'] = 'V_UserLesson';
        $this->load_view($data);
    }

  public function user_lesson(){
      $this->load->model('M_Lessons','lessons');
      return $this->lessons->get_lessons();
	}

  public function get_sub_status($id='', $probid=''){

    $this->load->model('M_Submit','M_sub');
    $res = $this->M_sub->get_status_by_usid_pbid();

    if(($res->num_rows())==1) {
      $status = mysql_result($res,0,'res_id');
      settype($status,'integer');
      return $status;
    } else {
      return 0;
    }
  }

  public function set_sub_status($id='', $probid='', $status=''){

    $this->load->model('M_Submit','M_sub');
    
    $res = $this->M_sub->get_status_by_usid_pbid();
    if(($res->num_rows())==1) {
      
		  $this->M_sub->id = $id;
		  $this->M_sub->probid = $probid;

      $q = $this->M_sub->update_status();
    } else {
      $this->M_sub->id = $id;
      $this->M_sub->probid = $probid;
      $this->M_sub->status = $status;
      
      $q = $this->M_sub->insert_status();
    }
    $res = $q;
    if($res!=TRUE)
      echo "ERROR SQL <br>";
    return $res;
  }

  public function put_in_queue($id='', $probid='', $sub_num=''){

    $this->load->model('M_Submit','M_sub');
    
    $res = $this->M_sub->get_queue_by_usid_pbid();

    if(($res->num_rows())==1) {

      $this->M_sub->sub_num = $sub_num;
		  $this->M_sub->id = $id;
		  $this->M_sub->probid = $probid;

      $res = $this->M_sub->update_queue();

    } else {
      $this->M_sub->id = $id;
      $this->M_sub->probid = $probid;
      $this->M_sub->sub_num = $sub_num;
      
      $res = $this->M_sub->insert_queue();
    }
    return $res;
  }

  public function get_sub_count($id='',$probid=''){
    
    $this->load->model('M_Submit','M_sub');
    $this->M_sub->probid = $probid;
    $this->M_sub->id = $id;

    $query = $this->M_sub->get_all_sub_by_usid_pbid();
    return $query->num_rows();
  }

  public function build_date(){
    return date("Y-m-d H:i:s");
  }

  public function save_submission($id='', $probid='', $filename=''){
  
    $this->load->model('M_Submit','M_sub'); 
    $content = file_get_contents($filename);
    $msg = NULL;
    
    $this->M_sub->lock_tb_submission();
    // save_submission: savefile, set status, add submission to queue
    
    $status = $this->get_sub_status($id, $probid);
    if($status!=2) {
    // savefile
      $subcount = $this->get_sub_count($id, $probid);
      $set_sub_num  = 1+$subcount;
      $timestamp = $this->build_date();

      $this->M_sub->id = $id;
      $this->M_sub->probid = $probid;
      $this->M_sub->sub_num = $set_sub_num;
      $this->M_sub->code = $content;
      $this->M_sub->ipaddress = '';
      $res = $this->M_sub->insert_submission();

      if($res!=TRUE){
        $msg = "ERROR: Database problem (insertion error)";
      
      }else {

        if($this->set_sub_status($id, $probid, 1)!=TRUE){

          $msg = "ERROR: Database problem (grd_status)";

        }else{

          if($this->put_in_queue($id, $probid, $subcount+1)!=TRUE){
            $msg = "ERROR: Database problem (grd_queue)";
          }

        }

      }
    } else {
      $msg = "ERROR: Grading old submission, please wait.";
    }
    $this->M_sub->unlock_tb();

    return $msg;
  }

  // Non edited
  public function my_unlink($wild_card='') {
   
    foreach (glob($wild_card) as $filename) {
      unlink($filename);
    }
  }

  public function process_submission(){

    $id = $_SESSION['user_id'];
    $fsize = $_FILES['code']['size'];

    if(($fsize>0) && ($fsize<=100000)) {
      
      $res = $this->save_submission($id, $_POST['prob_id'], $_FILES['code']['tmp_name']);

      if($res != NULL) {
        $_SESSION['msg']=$res;
      }
    } else {
      $_SESSION['msg']='ERROR: File too large';
    }

     // Non edited
     // **** user namei - l /full/path/to/save/directory to check
     // ****    whether it is 0755 all the way through (the last
     // ****    directory has to be 777

     $myOld = umask(0);
     
     $myDir = $this->config->item('floder_send_code');
      if(!file_exists($myDir."/".$id."/")){
        mkdir($myDir."/".$id."/", 0777, true);
      }
     
      if(!file_exists($myDir."/".$id."/".$_POST['prob_id']."/")){
        mkdir($myDir."/".$id."/".$_POST['prob_id']."/", 0777, true);
      }

     umask($myOld);

     $this->my_unlink($myDir."*.h"); 
     $this->my_unlink($myDir."*.c"); 
     $this->my_unlink($myDir."*.cpp"); 
     $this->my_unlink($myDir."*.java"); 
     $this->my_unlink($myDir."*.class"); 
     $this->my_unlink($myDir."*.out"); 

     if(!empty($_FILES['file'])){

        foreach($_FILES['file']['error'] as $key => $error) {
          if($error == 0) {
            $myFSize = $_FILES['file']['size'][$key];

              if(($myFSize > 0) && ($myFSize <= 100000)) {
                  $tmp_name = $_FILES['file']['tmp_name'][$key];
                  $name = basename($_FILES['file']['name'][$key]); 
                  if(move_uploaded_file($tmp_name,"$myDir"."$name")) {
                      // echo "<br>done";
                  } else {
                      // echo "<br>can't be done";
                  }
              }// if

          } // error
        }

      }else{
       echo "refesh";
      }// isset
     
     redirect('Main/index','refresh');
  }



    /*
    |--------------------------------------------------------------------------
    | Author : Porawee Limpongprasert
    | Modified :-
    |--------------------------------------------------------------------------
    */

    public function show_problems_actives($user_id,$lesson_id){
        $session = $this->session->userdata();
        $data['title'] = 'Grader |  การบ้าน';
        $data['user_session'] = $session;
        $data['active'] = '';
        
        $this->load->model('M_UserProblems','lessons_prob');
		    $this->lessons_prob->lessons_id = $lesson_id;
        $this->lessons_prob->user_id = $user_id;
        $prob_data = $this->lessons_prob->get_user_prob();
        $user_submit_data = $this->lessons_prob->get_user_submit();

        if ($prob_data->num_rows() > 0) {

          foreach ($prob_data->result() as $row) {

            $this->lessons_prob->prob_id = $row->les_prob_id;
            $sub_num  = $this->lessons_prob->get_sub_num()->result();

            $arrCheckSame[] = $row->prob_id;
            $arrPatent[$row->prob_id]['lesson_id'] = $row->lesson_id;
            $arrPatent[$row->prob_id]['prob_id'] = $row->les_prob_id;
            $arrPatent[$row->prob_id]['prob_name'] = $row->prob_name;
            $arrPatent[$row->prob_id]['limit'] = $row->limit;
            $arrPatent[$row->prob_id]['sub_num'] = $sub_num[0]->sub_num;
            $arrPatent[$row->prob_id]['due_date'] = $row->due_date;
                    $arrPatent[$row->prob_id]['pdf_data'] = base64_encode($row->pdf_data);
                    $arrPatent[$row->prob_id]['grading_msg'] = "";
                    $arrPatent[$row->prob_id]['compiler_msg'] = "";
                    $arrPatent[$row->prob_id]['score'] = "";
          }
            $data['user_prob'] = $arrPatent;
            $data['check'] = 1;
        }else{
            $data['user_prob'] = array();
        }

        if ($user_submit_data->num_rows() > 0) {
          foreach ($user_submit_data->result() as $row) {
              if(empty($arrCheckSame)){
                $arrCheckSame[] = false; 
              }
              $this->lessons_prob->prob_id = $row->les_prob_id;
              $sub_num  = $this->lessons_prob->get_sub_num()->result();
              if (in_array($row->prob_id, $arrCheckSame)) {
                  $arrPatent[$row->prob_id]['lesson_id'] = $row->lesson_id;
                  $arrPatent[$row->prob_id]['prob_id'] = $row->les_prob_id;
                  $arrPatent[$row->prob_id]['prob_name'] = $row->prob_name;
                  $arrPatent[$row->prob_id]['limit'] = $row->limit;
                  $arrPatent[$row->prob_id]['sub_num'] = $sub_num[0]->sub_num;
                  $arrPatent[$row->prob_id]['due_date'] = $row->due_date;
                  $arrPatent[$row->prob_id]['pdf_data'] = base64_encode($row->pdf_data);
                  $arrPatent[$row->prob_id]['grading_msg'] = $row->grading_msg;
                  $arrPatent[$row->prob_id]['compiler_msg'] = str_replace('"', '', $row->compiler_msg);
                  $arrPatent[$row->prob_id]['score'] = $row->score;
              }
          }
          if(empty($arrPatent)){
            $arrPatent[] = 0; 
          }
          $data['user_prob'] = $arrPatent;
          $data['check'] = 1;
        }
        $data['user_lessons_id'] = $lesson_id;
        $data['content'] = 'V_UserProblems';
        $this->load_view($data);
    }

    public function show_problem_pdf(){
        if(isset($_POST["prob_id"])) {
            $this->load->model('M_Problems','prob');
            $this->prob->prob_id = $_POST["prob_id"];
            $row = $this->prob->get_prob_pdf()->result_array();
            // create object tag 
            if(!empty(base64_encode($row[0]['pdf_data']))){
                $output =' <object type="application/pdf" data="data:application/pdf;base64,'.base64_encode($row[0]['pdf_data']).'" style="height:410px;width:100%" ></object>';

            }else {
                $output = '<h2 style="text-align: center;">ไม่มีไฟล์ PDF ในระบบ !</h2>';
            }
            echo $output;
		    }
    }

    public function insert_time_open_pdf(){

        $this->load->model('M_UserProblems','prob');
        $user_id = $this->session->userdata('user_id');
        $prob_id = $this->input->post('prob_id');

        $chk_open_pdf = $this->prob->check_first_open_pdf($user_id,$prob_id);
        if($chk_open_pdf->num_rows() == 0){
            $this->prob->user_id = $user_id;
            $this->prob->prob_id = $prob_id;
            $this->prob->insert_open_pdf();
        }else{

        }
       
    }

    public function get_msg_data(){
        $this->load->model('M_UserProblems','prob');
        $user_id = $this->session->userdata('user_id');
        $prob_id = $this->input->post('prob_id');

        $msg_data = $this->prob->get_msg($user_id,$prob_id);

        echo json_encode($msg_data->row());
    }

    public function get_prob_name(){
      $prob_id = $this->input->post('prob_id');
      $this->load->model('M_Problems','prob');
      $this->prob->prob_id = $prob_id;
      $result = $this->prob->get_prob_pdf()->result_array();
      // change fomat data
      $data_result = array(
          "lesson_id" => $result[0]['lesson_id'],
          "prob_id" => $result[0]['prob_id'],
          "pdf_id" => $result[0]['pdf_id'],
          "prob_name" => $result[0]['name'],
          "pdf_name" => $result[0]['pdf_name'],
          
      );
      echo json_encode($data_result);
    }

}
?>