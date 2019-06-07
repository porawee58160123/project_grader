<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
	*/
		
	public function __construct() {
        parent::__construct();	
        if($this->session->userdata('type') == 'A'){
            redirect(base_url().'index.php/ManageLessons/index');
		} else if($this->session->userdata('type') == 'C'){
            redirect(base_url().'index.php/UserProblems/index');
		}
	}

	public function encode_password($password){
		// *password ซึ่งเป็น string โดยเป็น password ที่ต้องการเข้ารหัส แต่ได้ไม่เกิน 72 ตัวอักษร
		// *algo เป็น int แต่สามารถใช้ Constants แทนได้ 2 ตัวคือ PASSWORD_BCRYPT  และ PASSWORD_DEFAULT โดย
		// – PASSWORD_BCRYPT  เป็นการระบุให้ใช้ Algorithm แบบ CRYPT_BLOWFISH
		// – PASSWORD_DEFAULT เป็นค่าตั้งต้นโดย PHP จะเป็นคนเลือก Algotithm ที่ใหม่ที่สุดหรือแข็งแรงที่สุดให้เมื่อมี Release ใหม่ๆเข้ามา
		// *options เป็น array ซึ่งสามารถใช้ key: salt และ cost ได้
		// - cost เป็นตัวที่บอกว่ารหัสที่ออกมานั้นผ่านการ Encrypt ซ้ำ ๆ ทั้งสิ้น n รอบ 
	
			$options = [
				'cost' => 12,
			];
			return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	public function check_password(){
		
		$user_id = $this->input->post('userid');
		$passwd = $this->input->post('password');
		
		$this->load->model('M_User','user');
		$this->user->user_id = $user_id;
		$result = $this->user->verify_user();

		if($result->num_rows() > 0){
			// get hash 
			$hash =  $result->result_array();
			if (password_verify($passwd , $hash[0]['passwd'])) {
				
				$row = $result->result_array();
				$session_data = array(
					'user_id' => $row[0]['user_id'],
					'name' => $row[0]['name'],
					'grp' => $row[0]['grp'],
					'type' => $row[0]['type'],
					'scid' => $row[0]['scid'],
				);
				
				$this->session->set_userdata($session_data);
				
				if($this->session->userdata('type') == 'C'){
					redirect(base_url().'index.php/UserProblems/index');
				}
				redirect(base_url().'index.php/ManageLessons/index');
			} 
			// passwd incorrect !
			$this->session->set_flashdata('error','กรุณาตรวจสอบ Username และ Password ของท่านอีกครั้ง !');
			redirect(base_url().'index.php/Login/index');
		} else {
			// no user
			$this->session->set_flashdata('error','ไม่พบข้อมูลผู้ใช้งาน !');
			redirect(base_url().'index.php/Login/index');
		}

	}
		
	public function index(){
		$this->load->view('V_Login');
	}
}
?>