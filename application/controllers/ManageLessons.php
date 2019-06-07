<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'Main.php';
class ManageLessons extends Main {
    
    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
	*/

    function __construct() {
        parent::__construct();	
        if($this->session->userdata('type') != 'A'){
            redirect(base_url().'index.php/Login/index');	
		}
		
	}

    function index(){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | บทเรียน';
        $data['user_session'] = $session;
        $data['active'] = 'Lessons';
        $data['content'] = 'V_Lessons';
        $data['lessons'] = $this->show_lessons_data();

        $this->load_view($data);
    }

    function show_lessons_data(){
        $this->load->model('M_Lessons','lessons');
        return $this->lessons->get_lessons();
	}
	
	public function search_lessons(){
		if(isset($_POST["lessons_id"])){
			$this->load->model('M_Lessons','lessons');
			$this->lessons->lessons_id = $_POST["lessons_id"];
			$row = $this->lessons->get_lessons_sub_date()->result();
			echo json_encode($row); 
		}
	}

    public function create_lessons(){

		$name = $this->input->post('name');
		$date = $this->input->post('due_date');
		$grp = $this->input->post('grp');

		$this->load->model('M_Lessons','lessons');
		$this->load->model('M_SubmitDate','submit_date');


		if(!empty($name)){
			$this->lessons->name = $name;
			// check name lesson Repeat name
			$vertify_lesson = $this->lessons->verify_name_less();
			if($vertify_lesson->num_rows() > 0){
				echo 1 ; die;
			}
		}

		//fomat new date [due_date]
		$fomat_date = date("Y-m-d",strtotime($date)); 

		$this->lessons->name = $name;
		$this->lessons->active = 1;
		$this->lessons->date = date("Y-m-d"); // create lessons date 
		$this->lessons->insert();

		$this->submit_date->grp = $grp;
		$this->submit_date->due_date = $fomat_date; // due_date
		$this->submit_date->lessons_id = $this->lessons->last_insert_id;
		$this->submit_date->insert();
		redirect('index.php/ManageLessons/index','refresh');
	}

    public function update_lessons() {

		$name = $this->input->post('edit_lessons_name');
		$due_date = $this->input->post('edit_due_date');
		$grp1 = $this->input->post('edit_grp');
		$grp = $this->input->post('edit_grp');
		$lessons_id = $this->input->post('edit_id');

		// change fomat date
		$fomat_due_date = date("Y-m-d",strtotime($due_date)); 
		
		$this->load->model('M_Lessons','lessons');
		$this->lessons->lessons_id = $lessons_id;
	

        $query_lessons_id = $this->lessons->get_by_lessons_id();
		foreach($query_lessons_id->result() as $val){
			$active = $val->active;
		}

		$this->lessons->name = $name;
		$this->lessons->active = $active;
		$this->lessons->rank = 0;
		$this->lessons->update();

		$this->load->model('M_SubmitDate','submit_date');
		$this->submit_date->grp1 = $grp1;
		$this->submit_date->due_date = $fomat_due_date;
		$this->submit_date->lessons_id = $lessons_id;
		$this->submit_date->grp = $grp;
		$this->submit_date->update();


    }
    
    public function delete() {

		$del_lessons_id = $this->input->post('del_lessons_id');
		$this->load->model('M_Problems','prob');
		$this->load->model('M_LessonsProblems','less_prob');
		$this->load->model('M_Lessons','lessons');
		$this->load->model('M_SubmitDate','submit_date');

		// del lesson id
		$this->lessons->lessons_id = $del_lessons_id;
		$this->lessons->delete();

		// del lesson_id table submit_deadline 
		$this->submit_date->lessons_id = $del_lessons_id;
		$this->submit_date->delete();
	}

	function del_all_less_file($dir) {
        if (is_dir($dir)) {
                // search file and unlink file
            foreach(scandir($dir) as $file) {
                if ('.' === $file || '..' === $file){ continue; }
                
                if (is_dir($dir."/".$file)) {
                    
                    $this->del_all_less_file(($dir."/".$file));
                }else {
                    unlink($dir."/".$file);
                }
            }
            rmdir($dir); 
        }else{
            return false; 
        }
    }

	public function update_status_lessons(){

		$lessons_id = $this->input->post('lessons_id');
		$lessons_active = $this->input->post('lessons_active');
		if($lessons_active == 1){
			$lessons_active = 0;
		}else{
			$lessons_active = 1;
		}
		$this->load->model('M_Lessons','lessons');
		$this->lessons->lessons_id = $lessons_id;
		$lessons_data = $this->lessons->get_by_lessons_id();
		
		foreach ($lessons_data->result() as $key => $row) {
			$lessons_name = $row->name ;
		}
		$this->lessons->name = $lessons_name;
		$this->lessons->rank = 0;
		$this->lessons->active = $lessons_active;
		$this->lessons->update();

	}
}
?>
