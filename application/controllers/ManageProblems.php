<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
include 'Main.php';
class ManageProblems extends Main
{
    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('type') != 'A') {
            redirect(base_url() . 'index.php/Login/index');
        }
    }

    public function index($id,$grp) {

        $session = $this->session->userdata();
        $data['title'] = 'Grader | โจทย์ปัญหา';
        $data['user_session'] = $session;
        $data['active'] = 'Lessons';
        $data['content'] = 'V_Problems';

            if($grp == "0") { 
                $grp = "*";	
            }

        $this->load->model('M_LessonsProblems','lessons_prob');
		$this->lessons_prob->lessons_id = $id;
        $this->lessons_prob->grp = $grp;
        $data['problems'] = $this->lessons_prob->get_lessons_prob();
		$data['lessons_id'] = $id;
        $this->load_view($data);
    }

    public function insert_file(){
        
        $dir = $this->config->item('floder_prob');
        $prob_id = $this->input->post('prob_id');

        $file_type = $_FILES["file"]['type'];
        $file_size = $_FILES["file"]['size'];
            if($file_type == 'application/pdf' && $file_size < 1000000){
                // save file pdf to database 
                $file_pdf_data = file_get_contents($_FILES["file"]["tmp_name"]);
                
                $this->load->model('M_PDF','pdf');         
                $this->pdf->pdf_prob_id = $prob_id;
                $query_pdf = $this->pdf->get_pdf_by_id();
                // check pdf_prob_id
                    if($query_pdf->num_rows() > 0) {
                        echo 1;
                    } else {
                        $this->pdf->pdf_name = $_FILES["file"]["name"];
                        $this->pdf->pdf_data = $file_pdf_data;
                        $this->pdf->insert();
                    }

            } else if($file_type == "application/x-zip-compressed" || $file_type == "application/octet-stream" || $file_type == 'text/plain' ) {

                if (!file_exists("$dir/$prob_id")) {
                    // 755 / 644
                    mkdir("$dir/$prob_id", 0777, true);
                }
                $name = $_FILES["file"]["name"];
                $tmp_name = $_FILES["file"]["tmp_name"];
                move_uploaded_file($tmp_name, "$dir/$prob_id/$name");

                $file_name_type = explode('.',$name);
                
                if($file_name_type[1] == "zip"){
                    
                    $zip = new ZipArchive;
                    $res = $zip->open("$dir/$prob_id/$name");
                    if ($res === TRUE) {
                        $zip->extractTo("$dir/$prob_id/");
                        $zip->close();
                        unlink("$dir/$prob_id/$name");
                        echo 'complete !';
                    } else {
                        echo 'error !'. $res;
                    }

                }else if($file_name_type[1] == "rar"){
                    echo $file_name_type[1]; die;

                }

            }else{
                echo 2; die;
            }
    }


    public function create_problems() {
        
        $dir = $this->config->item('floder_prob');
        $lessons_id = $this->input->post('lessons_id');
        $prob_id = $this->input->post('prob_id');
        $prob_name = $this->input->post('prob_name');
        $prob_limits = $this->input->post('prob_limits');
        
        $this->load->model('M_Problems', 'problems');
        $this->problems->prob_id = $prob_id;

            // create floder
            if (!file_exists("$dir/$prob_id")) {
                // 755 / 644
                mkdir("$dir/$prob_id", 0777, true);
            }
        // check empty data 
        $prob_data = $this->problems->get_prob_by_id();
            if($prob_data->num_rows() > 0){
                echo 1;
            } else {        
                $this->problems->prob_name = $prob_name; 
                $this->problems->insert();
        
                $this->load->model('M_LessonsProblems', 'lessons_prob');
                $this->lessons_prob->lessons_id = $lessons_id;
                $this->lessons_prob->prob_id = $prob_id;
                $this->lessons_prob->active = 1;
                $this->lessons_prob->rank = 0;
                $this->lessons_prob->limit = $prob_limits;
                $this->lessons_prob->insert();
            }
       
        redirect('Lessons/index', 'refresh');
    }
    public function show_problem_pdf() {
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

    public function delete_prob() {
  
        $prob_id = $this->input->post('prob_id');
        $dir = $this->config->item('floder_prob');

            $dir = "$dir/$prob_id";

            if (file_exists($dir)) {
                $this->del_all_prob_file($dir);
            }// close file_exists
        $this->load->model('M_Problems', 'prob');
        $this->prob->prob_id = $prob_id;
        $this->prob->delete(); 
        
        $this->load->model('M_PDF','pdf');
        $this->pdf->pdf_prob_id = $prob_id;
        $this->pdf->delete_by_prob_id();
    }

    function del_all_prob_file($dir) {
        if (is_dir($dir)) {
                // search file and unlink file
            foreach(scandir($dir) as $file) {
                if ('.' === $file || '..' === $file){ continue; }
                
                if (is_dir($dir."/".$file)) {
                    
                    $this->del_all_prob_file(($dir."/".$file));
                }else {
                    unlink($dir."/".$file);
                }
            }
            rmdir($dir); 
        }else{
            return false; 
        }
    }

    public function update_prob_status(){

        $prob_id = $this->input->post('prob_id');
        $lessons_id = $this->input->post('lessons_id');
        $active = $this->input->post('prob_active'); 
        // change status
            if($active == 1){
                $active = 0;
            }else{
                $active = 1;
            }

        $this->load->model('M_LessonsProblems', 'lesson_prob');
        $this->lesson_prob->active = $active;
        $this->lesson_prob->lessons_id = $lessons_id;
        $this->lesson_prob->prob_id = $prob_id;

        $less_prob_data = $this->lesson_prob->get_by_less_prob_id();
		
            foreach ($less_prob_data->result() as $key => $row) {
                $limits = $row->limit ;
            }
        $this->lesson_prob->limit = $limits;
        $this->lesson_prob->update();
    }

    public function search_edit_problem_id(){
        $prob_id = $this->input->post('prob_id');

        $this->load->model('M_Problems','prob');
        $this->prob->prob_id = $prob_id;
        $prob_data = $this->prob->get_prob_pdf()->result_array();
            // check data empty ?
            if(empty($prob_data)){
                echo $prob_data_result = 0; die;
            }else{
                $prob_data_result = array(
                    "prob_id" => $prob_data[0]['prob_id'],
                    "pdf_id" => $prob_data[0]['pdf_id'],
                    "prob_name" => $prob_data[0]['name'],
                    "pdf_name" => $prob_data[0]['pdf_name'],
                    "limit" => $prob_data[0]['limit'],
                    "create_pdf_date"=> $prob_data[0]['create_pdf_date'],
                    "pdf_data" => base64_encode($prob_data[0]['pdf_data'])
                );
            }
        echo json_encode($prob_data_result) ;
    }

    public function update_prob(){
        $prob_id = $this->input->post('edit_prob_id');
        $lessons_id = $this->input->post('edit_lessons_id');
        $prob_name = $this->input->post('edit_prob_name');
        $prob_limit = $this->input->post('edit_prob_limit');

        $this->load->model('M_Problems','prob');
        $this->load->model('M_LessonsProblems','less_prob');

        $this->prob->prob_id = $prob_id;
        $this->prob->prob_name = $prob_name;
        $this->prob->update();


        $this->less_prob->lessons_id = $lessons_id;
        $this->less_prob->prob_id = $prob_id;
        // get current active 
        $less_prob_data = $this->less_prob->get_by_less_prob_id()->result_array();

        $this->less_prob->active = $less_prob_data[0]['active'];
        $this->less_prob->limit = $prob_limit;
        $this->less_prob->update();
    }

    public function edit_file_upload(){
        $prob_id = $this->input->post('edit_prob_id');
        $file_type = $_FILES["file"]['type'];
        $file_size = $_FILES["file"]['size']; 

            if($file_type == 'application/pdf' && $file_size < 1000000){
                // get file pdf  
                $file_pdf_data = file_get_contents($_FILES["file"]["tmp_name"]);
                
                $this->load->model('M_PDF','pdf');         
                $this->pdf->pdf_prob_id = $prob_id;
                // check current pdf_prob_id
                $query_pdf = $this->pdf->get_pdf_by_id();
                
                if($query_pdf->num_rows() > 0) {
                        $this->pdf->pdf_name = $_FILES["file"]["name"];
                        $this->pdf->pdf_data = $file_pdf_data;
                        $this->pdf->update();
                    } else {

                        $this->pdf->pdf_name = $_FILES["file"]["name"];
                        $this->pdf->pdf_prob_id = $prob_id;
                        $this->pdf->pdf_data = $file_pdf_data;
                        $this->pdf->insert();
                    }

            } else {
                echo 1 ; die;
            }
        
    }

}
?>

