<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends RT_Controller {

	public function __construct()
	{
	     parent::__construct();
             $this->form_validation->set_message('required', '%s');
             
	}
        
	public function index() // default function called for the home controller
	{
            $is_logged_in=$this->login_model->is_loggedin();
             if($is_logged_in)
             {
                 redirect("/admin");
             }
            $this->layout = "admin_login";
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $data['title_for_layout']="Admin Login";
            $commonObj = new Common_model(); // common model object created 
            $data['langsel'] = $commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_rules('txtUserName', 'Username error', 'trim|required');
            $this->form_validation->set_rules('txtPassword', 'Password error', 'required|callback_userlogin_check');
            $data['error']='';
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtUserName'))
                {
                    $data['error']= form_error('txtUserName');
                }
                else
                if(form_error('txtPassword'))
                {
                    $data['error']= form_error('txtPassword');
                }
                
                    
            }
            else
            {
                    $data['error']= "";
            }
            $data['setting_data']=$this->coresession->userdata('SETTINGS_DATA');
            $data['logout_message']=$this->coresession->flashdata('LOGOUT');
            $this->render($data);
            
	}
	
        function userlogin_check()
	{
            $is_logged_in=$this->login_model->is_loggedin();
             if($is_logged_in)
             {
                 redirect("/admin");
             }
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $username=$this->input->post('txtUserName');    
            $password=$this->input->post('txtPassword');
            $loginObj=new Login_model();
            $data=$loginObj->check_login($username,$password);
            if(empty($data))
            {
                $this->form_validation->set_message('userlogin_check', 'LOGIN_ERROR');
                return FALSE;
            }
            else
            {
                $this->coresession->set_userdata('USER_SESSION',$data);
                redirect('/admin');
                return TRUE;
            }
	}
        
        
        public function logout()
	{
             $this->coresession->unset_userdata('USER_SESSION');
             $this->coresession->set_flashdata('LOGOUT', 'Logout Successfull');
             logoutredirect();
        }
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */