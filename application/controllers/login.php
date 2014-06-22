<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends RT_Controller {
    
        public function __construct()
	{
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
	     parent::__construct();
             $this->load->library('coresession');
             $this->load->model('emailtemplate');
             
             $this->load->model("login_model");
             $this->form_validation->set_message('required', '%s');
       }
        
        public function ajax_login() // default function called for the home controller
	{
            $this->load->model('home_model'); // model for the controller
            $loginObj=new Login_model();
            $json_data = $this->config->item('json_data');
            $json_data['datap']="1";
            $json_data['redirect_link'] = "";
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                $is_logged_in = $loginObj->is_loggedin();
                if($is_logged_in)
                {
                    $json_data['success_mess'] = "Already logged in";
                    $json_data['success'] = "2";
                }
                else
                {
                    $this->form_validation->set_rules('txtUsernameLogin', 'Email address / Username required', 'trim|required');
                    $this->form_validation->set_rules('txtPasswordLogin', 'Password required', 'required|callback_userlogin_check');
                    if ($this->form_validation->run() == FALSE)
                    {
                        $json_data['error'] = 1;
                        $json_data['success'] = 0;
                        if(form_error('txtUsernameLogin'))
                        {
                            $json_data['error_mess']= tr(form_error('txtUsernameLogin'));
                        }
                        else
                        if(form_error('txtPasswordLogin'))
                        {
                            $json_data['error_mess']= tr(form_error('txtPasswordLogin'));
                        }
                    }
                    else
                    {
                        $json_data['success'] = 1;
                        $json_data['error'] = 0;
                        $refrer_link = $this->coresession->userdata('refrer_link');
                        $usersession = $this->coresession->userdata('USER_SESSION');
                        if($usersession->status == 0)
                            $loginObj->setStatus(1);
                        if(!empty($refrer_link) && (strpos($refrer_link,"logout") === false))
                        {
                            $json_data['success'] = "3";
                            $this->coresession->unset_userdata('refrer_link');
                            $json_data['redirect_link'] = $refrer_link;
                        }
                        $json_data['success_mess']="Login success..";
                        $json_data['error_mess']="";
                    }
                }
            }
            else
            {
                $json_data['error_mess'] = "Please select valid url login";
                $json_data['error'] = "1";
            }
            echo json_encode($json_data);
	}
        
	function userlogin_check()
	{
            $this->load->helper('cookie');
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $username = $this->input->post('txtUsernameLogin');    
            $password = $this->input->post('txtPasswordLogin');
            $loginObj=new Login_model();
            $data = $loginObj->check_login($username,$password);
            if(empty($data))
            {
                $this->form_validation->set_message('userlogin_check', 'Login authentication failed');
                return FALSE;
            }
            else
            {
                $remember = $this->input->post("optRememberMe");
                if($remember==1)
                {
                        $cookie = array(
                                    'name' => REMEMBER_ME_KEY,
                                    'value' => encode_id($username),
                                    'expire' => time()+ (60*60*24*7) // 7 days cookie set
                                    );
                        $this->input->set_cookie($cookie);
                }
                else
                {
                    delete_cookie(REMEMBER_ME_KEY);
                }
                $this->coresession->set_userdata('USER_SESSION',$data);
                return TRUE;
            }
	}
        
        
    public function logout()
    {
        $this->coresession->unset_userdata('USER_SESSION');
        $this->coresession->set_flashdata('LOGOUT', 'Logged out successfully');
        redirect('signin_up');
        exit();
    }
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */