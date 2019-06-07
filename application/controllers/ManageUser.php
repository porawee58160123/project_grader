<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include 'Main.php';
require_once('Login.php');
class ManageUser extends Main {

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
    
    /*
    |--------------------------------------------------------------------------
    | V_show_user
    |--------------------------------------------------------------------------
    */

    function show_user(){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | แสดงผู้ใช้';
        $data['user_session'] = $session;
        $data['active'] = 'User';
        $data['content'] = 'V_ShowUser';
        $data['user_data'] = $this->get_user();
        $this->load_view($data);

    }
    
    function get_user(){
        $this->load->model('M_User','user');
        return $this->user->get_user_data();
    }
    
    function search_user(){
        $user_id = $this->input->post('edit_user_id');
        $this->load->model('M_User','user');
        $this->user->user_id = $user_id;
        $result_user = $this->user->verify_user()->result();
        echo json_encode($result_user);
    }

    function update_user(){
        $user_id = $this->input->post('user_id');
        $user_name = $this->input->post('edit_user_name');
        $user_grp = $this->input->post('edit_user_grp');
        $user_pass = $this->input->post('edit_user_pass');
        $user_cfpass = $this->input->post('edit_user_cfpass');

        $this->load->model('M_User','user');
        $this->user->name = $user_name;
        $this->user->grp = $user_grp; 
        $this->user->user_id = $user_id;

            if($user_pass == $user_cfpass && $user_pass != "" && $user_cfpass != ""){
                $this->user->passwd = Login::encode_password($user_pass);
            }else{
                $data_result = $this->user->verify_user()->result_array();
                $this->user->passwd =  $data_result[0]['passwd'];
            }
        $this->user->update();

    }

    function delete_user(){
        $user_id = $this->input->post('user_id');
        $this->load->model('M_User','user');
        $this->user->user_id = $user_id;
        $this->user->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | V_upload_user
    |--------------------------------------------------------------------------
    */
    
    function upload_user (){
        $session = $this->session->userdata();
        $data['title'] = 'Grader | อัปโหลด';
        $data['user_session'] = $session;
        $data['active'] = 'User';
        $data['content'] = 'V_UploadUser';
        $this->load_view($data);
    }

    function insert_csv_file(){

        if(isset($_FILES)){
            $this->load->model('M_User','user');

            $handle = fopen($_FILES['file']['tmp_name'],'r');
            while($data_csv = fgetcsv($handle)){

                // cut spacial charater 
                $user_id = trim($data_csv[0], chr(239).chr(187).chr(191));

                $this->user->user_id = $user_id;
                $this->user->name = $data_csv[1];

                // encode passwd
                $this->user->passwd = Login::encode_password($data_csv[2]);
                $this->user->grp = $data_csv[3];
                $this->user->type = $data_csv[4];
                $this->user->scid = $data_csv[5];

                // ip check null
                if($data_csv[6] == "NULL"){
                    $this->user->ipaddr = null;
                }else{
                    $this->user->ipaddr = $data_csv[6];
                }
                $this->user->insert();  
            } // close while

        }else{
            return false;   
        }
    }

}

?>