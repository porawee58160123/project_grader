<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include "Main.php";
require_once "Login.php";
class ResetPassword extends Main {
    
    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */


    function __construct() {
        parent::__construct();	
    }

    public function index(){
            $session = $this->session->userdata();
            $data['title'] = 'Grader | เปลี่ยนรหัสผ่าน';
            $data['user_session'] = $session;
            $data['active'] = '';
            $data['content'] = 'V_ResetPassword';

            $this->load_view($data);
    }

    function reset_passwd(){
        $user_id = $this->input->post('user_id');
        $user_pass = $this->input->post('new_passwd');
        $user_cfpass = $this->input->post('cf_passwd');

        if(strlen($user_pass) < 8){
            // check len
            echo 3; die;
        }


        $this->load->model('M_User','user');
        $this->user->user_id = $user_id;
        $data_user = $this->user->verify_user();

        if($data_user->num_rows() > 0){

            if($user_pass == $user_cfpass && $user_pass !== "" && $user_cfpass !== ""){
                $this->user->passwd = Login::encode_password($user_pass);
                $this->user->update_password();
            }else{
                // return error
                echo 2; die;
            }
            echo 1;

        }else{
            echo 0 ;
        }

            

    }


}
?>