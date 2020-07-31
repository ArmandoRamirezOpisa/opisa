<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ini extends CI_Controller {
    
     public function __construct()
        {
            parent::__construct();
            $this->load->model("user_Information");
        }
    
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */ 
    public function ValidateLogin() {
        $data = array(
            'user_name' => $this->input->get_post('user', true),
            'user_email_id' => $this->input->get_post('pass', true),
            'KeyPermission' => $this->input->get_post('key', true)
        );
        if ($data["KeyPermission"] == FALSE || $data["user_name"] == FALSE || $data["user_email_id"] == FALSE) {
           echo '{error:"Verifica tu informacion"}';
        } else {  
          //  $this->loginModel->ValidateUserModel($data);     
            $json = json_encode($data);  
            echo $json;
        }
    }
}
