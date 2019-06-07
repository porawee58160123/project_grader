<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    /*
    |--------------------------------------------------------------------------
    | Author : Sukan Sittibamrungsuk
    | Modified :-
    |--------------------------------------------------------------------------
    */

    public $uploads_dir ;
    
    function __construct() {
        parent::__construct();	
    }
    
    public function load_view($data){
       
        $this->load->view('Template/header.php',$data);
        $this->load->view($data['content'],$data);
        $this->load->view('Template/footer.php');

    } 
    public function logout(){
        session_destroy();   
        redirect(base_url().'index.php/Login/index','refresh');
    }
}
?>