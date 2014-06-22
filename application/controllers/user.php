<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('coresession');
        $this->load->model('login_model');
    }
        

    function updateStatus() {
        $loginObj = new Login_model();
        $status = $this->input->post('status');
        $loginObj->setStatus($status);
        $this->load->model("chat_model");
        $chatObj = new chat_model();
        $friends_list = $chatObj->findFriends();
        $chatObj->update_comet_files($friends_list,"Status: ".$status);
        $data['error'] = 0;
        $data['success'] = 1;
        $data['error_mess'] = "";
        $data['datap'] = "1";
        echo json_encode($data);
    }
}