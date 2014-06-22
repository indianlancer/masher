<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin_up extends RT_Controller {
    
        public function __construct()
	{
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
	     parent::__construct();
             $this->load->library('coresession');
             
             $this->load->model('emails/template');
             $this->load->model("mail_build");
             $this->form_validation->set_message('required', '%s');
        }
        
        
        
        public function index() // default function called for the home controller
	{
            $this->load->model('login_model'); // model for the controller
            $loginObj=new Login_model();
            
            $is_logged_in = $loginObj->is_loggedin();
            if($is_logged_in)
            {
                redirect("/home/chat");
                exit();
            }
            $data['success_mess']="";
            $data['error_mess']="";

            $this->form_validation->set_rules('txtUsername', 'Email address / Username required', 'trim|required');
            $this->form_validation->set_rules('txtPassword', 'Password required', 'required|callback_userlogin_check');
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtUsername'))
                {
                    $data['error_mess']= tr(form_error('txtUsername'));
                }
                else
                if(form_error('txtPassword'))
                {
                    $data['error_mess']= tr(form_error('txtPassword'));
                }
            }
            else
            {
                $refrer_link=$this->coresession->userdata('refrer_link');

                if(!empty($refrer_link) && (strpos($refrer_link,"logout") === false))
                {
                    $this->coresession->unset_userdata('refrer_link');
                    redirect($refrer_link);
                }
                else
                    redirect("/user");
                $data['success_mess']="Login success..";
                $data['error_mess']="";
            }

            $data['success_mess'] = $this->coresession->flashdata("PASS_CHANGE_SUCCESS_FLASH");
            $logout_mess = $this->coresession->flashdata("LOGOUT");
            $login_first = $this->coresession->flashdata("LOGIN_FIRST");
            if(strlen($logout_mess)>0)
                $data['success_mess'] = $logout_mess;
            if(strlen($login_first)>0)
                $data['success_mess'] = $login_first;
            
            
            $data['cookie_remember'] = decode_id($this->input->cookie(REMEMBER_ME_KEY));
            $this->load->model('home_model');
            $homeObj=new Home_model();
            
            $data['home_content'] = $homeObj->get_content();
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['page_meta_keywords'] = strip_tags($data['home_content']->meta_keywords);
            $data['page_meta_description'] = strip_tags($data['home_content']->meta_description);
            $this->render($data);
                
	}
        
        
    
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */