<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends RT_Controller {
    
        public function __construct()
	{
            $this->load_model = FALSE;
	     parent::__construct();
             $this->load->model('emails/template');
             $this->load->model("mail_build");
             $this->load->model("login_model");
             $this->form_validation->set_message('required', '%s');
        }
        
        function regsubmit()
        {
            //$commonObj=new Common_model(); // common model object created 
            $loginObj=new Login_model();
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', '%s required');
            $this->form_validation->set_message('max_length', '%s max length error %s');
            $this->form_validation->set_message('alpha', 'Alphbets only allowed %s');
            $this->form_validation->set_message('min_length', '%s '."Min length required".' %s');
            $this->form_validation->set_message('valid_email', "Not a valid email");
            $this->form_validation->set_message('numeric', '%s '."Number only allowed");
            $this->form_validation->set_message('matches', '%s '."Confirm password does not matched");
            
            $data['error']='';
            $data['success']="0";
            $data['success_mess']="";
            $data['error_mess']="";
            $data['error_tab']="";
            $data['error_tab_num']="0";
            $data['datap']="1";
            $this->form_validation->set_rules('txtFirstName', ' ', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('txtLastName', ' ', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('txtEmail', ' ', 'trim|required|max_length[50]|valid_email|callback_emailexist_check');
            //$this->form_validation->set_rules('txtUsername', ' ', 'trim|required|min_length[4]|max_length[15]|userexist_check');
            $this->form_validation->set_rules('txtPassword', ' ', 'required|max_length[30]|callback_userpass_check');
            $this->form_validation->set_rules('txtConfPassword', ' ', 'required|matches[txtPassword]');
            //$this->form_validation->set_rules('chk_terms_cond', ' ', 'trim|required');
            
            
            $data['error']="";
            
            if ($this->form_validation->run() == FALSE)
            {
                $data['error']="1";
                if(form_error('txtFirstName'))
                {
                    $data['error_tab']="txtFirstName";
                    $data['error_tab_num']="0";
                    $data['error_mess']= form_error('txtFirstName');
                }
                else
                if(form_error('txtLastName'))
                {
                    $data['error_tab']="txtLastName";
                    $data['error_tab_num']="1";
                    $data['error_mess']= form_error('txtLastName');
                }
                else
                if(form_error('txtEmail'))
                {
                    $data['error_tab']="txtEmail";
                    $data['error_tab_num']="2";
                    $data['error_mess']= form_error('txtEmail');
                }
                /*else
                if(form_error('txtUsername'))
                {
                    $data['error_tab']="txtUsername"; 
                    $data['error_tab_num']="3";
                    $data['error_mess']= form_error('txtUsername');
                }*/
                else
                if(form_error('txtPassword'))
                {
                    $data['error_tab']="txtPassword"; 
                    $data['error_tab_num']="4";
                    $data['error_mess']= form_error('txtPassword');
                }
                else
                if(form_error('txtConfPassword'))
                {
                    $data['error_tab']="txtConfPassword"; 
                    $data['error_tab_num']="5";
                    $data['error_mess']= form_error('txtConfPassword');
                }
                else
                if(form_error('txtSecurity'))
                {
                    $data['error_tab']="txtSecurity"; 
                    $data['error_tab_num']="6";
                    $data['error_mess']= form_error('txtSecurity');
                }
                /*else
                if(form_error('chk_terms_cond'))
                {
                    $data['error_tab']="chk_terms_cond"; 
                    $data['error_tab_num']="7";
                    $data['error_mess']= form_error('chk_terms_cond');
                }*/
            }
            else
            {
                    $txtFirstname=(ucfirst($this->input->post('txtFirstName')));
                    $txtLastname=(strtolower($this->input->post('txtLastName'))); 
                    $txtEmailId=($this->input->post('txtEmail'));
                    //$txtUsername=(strtolower($this->input->post('txtUsername')));
                    $txtPassword=($this->input->post('txtPassword'));
                    
                    $deflang=1;
                    $lang_id=$this->coresession->userdata('cchl_id');
                    if(strlen($lang_id)<1)
                    {
                        $lang_id=$deflang;
                    }
                    $reg_data = array(
                                //'username' =>$txtUsername,
                                'login_pass' =>md5(MD5_PREFIX_PASS.$txtPassword),
                                'first_name' => $txtFirstname,
                                'last_name' => $txtLastname,
                                'email_id' => $txtEmailId,
                                'is_enabled' => 0
                                );


                    $userData = $loginObj->register_user($reg_data);
                    $this->sendConfirmMail($userData);
                    $data['success']="1";
                    $data['error_tab']="";
                    $data['success_mess']="Registration successfull";
                    $data['error_mess']="";
                    $data['error']="0";
                    $data['datap']=1;
            }
            echo json_encode($data);
        }
        
        function sendConfirmMail($userData)
        {
            $session_id = md5(time());
            $loginObj=new Login_model();
            $up_data= array(
                        'username' => $userData->email_id,
                        'time' => time(),
                        'session_id' => $session_id,
                        'userid' => $userData->id,
                        'usertype' => '',
                        'data' => serialize($userData)
                        );

            $loginObj->setverifysession($up_data);
            
            $templateObj = new template();
            $mailObj = new Mail_build();


            $new_user_maildata=array(
                            'type'=>'new_user_registration',
                            'email' => $userData->email_id,
                            'sender_name' => "",
                            'first_name' => $userData->first_name,
                            'last_name' => $userData->last_name,
                            'password' => '********'
                        );
            
            $enco_user = encode_id($userData->email_id);
            
            $activation_link = '<a href="'.HTTP_PATH.'emailverify/'.$enco_user.'/'.$userData->id.'/'.$session_id.'">'.HTTP_PATH.'emailverify/'.$enco_user.'/'.$userData->id.'/'.$session_id.'</a>';

            $email_verify_maildata=array(
                            'type'=>'email_verification',
                            'email'=>$userData->email_id,
                            'sender_name' => "",
                            'activation_link' => $activation_link,
                            'first_name' => $userData->first_name,
                            'last_name' => $userData->last_name
                        );

            $new_user_template = $templateObj->getAnEmailtemplate('NEW_USER_REGISTERED');
            $email_verify_template = $templateObj->getAnEmailtemplate('EMAIL_VERIFICATION');
            $mailObj->sendmail($new_user_maildata,$new_user_template);
            $mailObj->sendmail($email_verify_maildata,$email_verify_template);
            $this->coresession->set_userdata("VERIFY_EMAIL_USER",$up_data);
        }
        
        function verifyemail()
        {
            $up_data=$this->coresession->userdata("VERIFY_EMAIL_USER");
            
            $commonObj=new Common_model(); // common model object created 
            $this->load->model('home_model'); // model for the controller
            $loginObj=new Login_model();
            $homeObj=new Home_model();
            if(empty($up_data))
            {
                    redirect("");
                    exit();
            }
            
            $data['success_mess']="";
            $data['error_mess']="";

            $data['home_content'] = $homeObj->get_content();
            
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['meta_keywords'] = strip_tags($data['home_content']->meta_keywords);
            $data['meta_description'] = strip_tags($data['home_content']->meta_description);
            
            $this->render($data);
            
        }
        
        function resendverifyemail()
        {
            $this->layout = 'siteiframe';
            $up_data = $this->coresession->userdata("VERIFY_EMAIL_USER");
            $commonObj = new Common_model(); // common model object created 
            $this->load->model('home_model'); // model for the controller
            $emailTemplate = new template();
            $mailObj = new Mail_build();
            $loginObj = new Login_model();
            $homeObj = new Home_model();
            if(empty($up_data))
            {
                    die("");
            }
            $resend_opt = $loginObj->verify_session($up_data['userid']);
                
            $data['remove_resend']=0;
            $data['mail_sent']=0;
            $resend = $this->input->post("update");
            $resend = decode_id($resend);
            if($resend_opt->resend != 0)
                $data['remove_resend'] = 0;
            if($resend == "time" && $resend_opt->resend == 0)
            {
                $up_data['session_id']=md5(time());
                $loginObj->setverifysession($up_data,"resend");
                $this->coresession->set_userdata("VERIFY_EMAIL_USER",$up_data);
                $enco_user = encode_id($up_data['username']);
                
                $reg_data =  unserialize($up_data['data']);
                
                $activation_link= '<a href="'.HTTP_PATH.'emailverify/'.$enco_user.'/'.$up_data['userid'].'/'.$up_data['session_id'].'">'.HTTP_PATH.'emailverify/'.$enco_user.'/'.$up_data['userid'].'/'.$up_data['session_id'].'</a>';
                $email_verify_maildata=array(
                                'type'=>'email_verification',
                                'email' => $reg_data->email_id,
                                'sender_name' => "",
                                'activation_link' => $activation_link,
                                'first_name' => '',
                                'last_name' => '',
                                'username' => '',
                                'password' => ''

                            );
                    $email_verify_template = $emailTemplate->getAnEmailtemplate('EMAIL_VERIFICATION');
                    $mailObj->sendmail($email_verify_maildata,$email_verify_template);
                $data['remove_resend'] = 0; // if want to stop resending email enable to 1;
                $data['mail_sent'] = 1; 
            }
            
            $data['home_content'] = $homeObj->get_content();
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['page_meta_keywords'] = strip_tags($data['home_content']->meta_keywords);
            $data['page_meta_description'] = strip_tags($data['home_content']->meta_description);
            
            $data['success_mess']="";
            $data['error_mess']="";
            $this->render($data);
        }
        
        function emailverify($enco_user,$user_id,$session_id)
        {
            
            $user_email =  decode_id($enco_user);
            $commonObj = new Common_model(); // common model object created 
            $this->load->model('home_model');
            $loginObj = new Login_model();
            $homeObj = new Home_model();
            if(strlen($enco_user)<1 || strlen($user_id)<1 || strlen($session_id)<1)
            {
                    redirect("/login");
                    exit();
            }
            $session_data = $loginObj->verify_session($user_id);
            $data['success_mess']="";
            $data['error_mess']="";
            
            $time_expire=time()-EMAIL_VERIFY_EXPIRE;
            if($session_data->time > $time_expire)
            {
                if($user_email == $session_data->username && $user_id == $session_data->userid && $session_id == $session_data->session_id)
                {
                    $loginObj->enable_account($user_id);
                    $data['success_mess']="Thank you! Your email verified successfully";
                    $this->coresession->unset_userdata("VERIFY_EMAIL_USER");
                    $loginObj->link_session_destroy($user_id,$session_id);
                    
                    $logged_in_data = $loginObj->check_username_data($session_data->username);
                    $this->coresession->set_userdata('USER_SESSION',$logged_in_data);
                }
                else
                {
                    $data['error_mess']="This link is expired";
                }
            }
            else
            {
                $data['error_mess']="This link is expired";
            }
            
            
            $data['user_session'] = $this->coresession->userdata('USER_SESSION');
            $data['home_content']=$homeObj->get_content();
            $data['meta_keywords']="";
            $data['title_for_layout']=" login";
            $data['meta_description']="";
            $data['title_for_layout']=$data['home_content']->meta_title;
            $data['meta_keywords']=strip_tags($data['home_content']->meta_keywords);
            $data['meta_description']=strip_tags($data['home_content']->meta_description);
            
            $this->render($data);
            
        }
        
        function recoverpassword()
        {
            $this->load->model('home_model'); // model for the controller
            $loginObj=new Login_model();
            $homeObj=new Home_model();
            $emailTemplate = new template();
            $mailObj = new Mail_build();
            $is_logged_in = $loginObj->is_loggedin();
            if($is_logged_in)
            {
                redirect("/home/chat");
                exit();
            }
            $data['success_mess']="";
            $data['error_mess']="";
            $data['error_mess']=$this->coresession->flashdata("PASS_RECOVER_EXPIRE_FLASH");
            $this->form_validation->set_rules('txtEmail', 'Please enter Username/Email ID', 'trim|required|callback_useraccount_exist_check');
            
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtEmail'))
                {
                    $data['error_mess']= form_error('txtEmail');
                }
            }
            else
            {
                $username=$this->input->post("txtEmail");
                $user_data = $loginObj->check_useraccount_data($username);
                $session_id=md5(time());
                $up_data= array(
                            'username' => $user_data->username,
                            'time' => time(),
                            'session_id' => $session_id,
                            'userid' => $user_data->id,
                            'usertype' => '',
                            'data' => serialize($user_data)
                            );

                $loginObj->setverifysession($up_data);
                
                $enco_user = encode_id($user_data->username);
                $activation_link= HTTP_PATH.'passwordrecover/'.$enco_user.'/'.$up_data['userid'].'/'.$up_data['session_id'];
                $pass_recover_maildata=array(
                                'type'=>'password_recovery',
                                'username'=>$user_data->username,
                                'email'=>$user_data->email_id,
                                'activation_link' => $activation_link,
                            );
                $template = (object)array();
                $template->subject = "Password change link";
                $template->body = $emailTemplate->getAnEmailtemplate('PASSWORD_RECOVERY');
                $mailObj->sendmail($pass_recover_maildata,$template);
                $this->coresession->set_flashdata("PASS_RECOVER_FLASH","Please check your Mail Inbox, we sent you a password recovery mail with password reset link. If you do not find any mail in your Inbox then you need to check your spam/junk box");
                redirect("/recoverpassword");
                exit();
                
            }
            
            $data['success_mess']=$this->coresession->flashdata("PASS_RECOVER_FLASH");
            $data['home_content'] = $homeObj->get_content();
            
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['page_meta_keywords'] = strip_tags($data['home_content']->meta_keywords);
            $data['page_meta_description'] = strip_tags($data['home_content']->meta_description);
            
            $this->render($data);
        }
        
        function passwordrecover($enco_user=false,$user_id=false,$session_id=false)
        {
            $user_name=  decode_id($enco_user);
            
            $this->load->model('home_model'); // model for the controller
            
            $loginObj=new Login_model();
            $homeObj=new Home_model();
            if(strlen($enco_user)<1 || strlen($user_id)<1 || strlen($session_id)<1)
            {
                $this->coresession->set_flashdata("PASS_RECOVER_EXPIRE_FLASH","This is not valid it may be expired");
                redirect("/recoverpassword");
                exit();
            }
            $data['success_mess']="";
            $data['error_mess']="";
            $data['can_change_pass']="0";
            
            $session_data=$loginObj->verify_session($user_id);
            if(!empty($session_data))
            {
                $time_expire=time()-EMAIL_VERIFY_EXPIRE;
                if($session_data->time > $time_expire)
                {
                    if($user_name==$session_data->username && $user_id==$session_data->userid && $session_id==$session_data->session_id)
                    {
                        $data['can_change_pass']="1";
                        $rel_stamp=md5("stamp".$enco_user);
                        $hdnStamp=$this->input->post("hdnStamp");
                        if($hdnStamp)
                        {
                            if($rel_stamp==$hdnStamp)
                            {
                                $this->form_validation->set_rules('txtPassword', ' ', 'required|max_length[30]|callback_userpass_check');
                                $this->form_validation->set_rules('txtConfPassword', ' ', 'required|matches[txtPassword]');
                                if ($this->form_validation->run() == FALSE)
                                {
                                    if(form_error('txtPassword'))
                                    {
                                        $data['error_mess']= form_error('txtPassword');
                                    }
                                    else
                                    if(form_error('txtConfPassword'))
                                    {
                                        $data['error_mess']= form_error('txtConfPassword');
                                    }
                                }
                                else
                                {
                                    $password=$this->input->post("txtPassword");
                                    $loginObj->update_password($user_id,$password);
                                    $loginObj->link_session_destroy($user_id,$session_id);
                                    $this->coresession->set_flashdata("PASS_CHANGE_SUCCESS_FLASH","Password changed successfully");
                                    redirect("/signin_up");
                                    exit();
                                }
                            }
                            else
                            {
                                $data['error_mess']="This authentication token is not valid";
                            }
                        }
                    }
                    else
                    {
                        $this->coresession->set_flashdata("PASS_RECOVER_EXPIRE_FLASH","This is not valid it may be expired");
                        redirect("/recoverpassword");
                        exit();
                    }
                }
                else
                {
                    $this->coresession->set_flashdata("PASS_RECOVER_EXPIRE_FLASH","This is not valid it may be expired");
                    redirect("/recoverpassword");
                    exit();
                }
            }
            else
            {
                $this->coresession->set_flashdata("PASS_RECOVER_EXPIRE_FLASH","This is not valid it may be expired");
                redirect("/recoverpassword");
                exit();
            }
            
            $data['hdn_stamp']=md5("stamp".$enco_user);
            
            $data['main_page']="passwordrecover_center";
            $this->load->view('main_center',$data);
        }
        
        
        function checkregisemail()
        {
            $value = (trim($this->input->get("value")));
            $loginObj = new Login_model();
            $data=array(
            "value" => $value,
            "valid" => false,
            "message" => ""
            );
            
            $edata=$loginObj->get_user_data($value);
            if(empty($edata))
            {
                $data['valid']= true;
                $data['message']= ("ok");
            }
            else
            {
                $data['valid']= false;
                $data['message']= tr("Email already exist");
            }
            
            echo json_encode($data);
        }
        function checkregisusername()
        {
            $value=($this->input->get("value"));
            $loginObj=new Login_model();
            $data=array(
            "value" => $value,
            "valid" => false,
            "message" => ""
            );
            
            $edata=$loginObj->check_username_data($value);
            if(empty($edata))
            {
                $data['valid']= true;
                $data['message']= tr("OK");
            }
            else
            {
                $data['valid']= false;
                $data['message']= tr("username already exist");
            }
            
            echo json_encode($data);
        }
        
        
        public function userpass_check()
	{
            
            	if(preg_match("/".PASSWORD_PATTERN."/", $this->input->post("txtPassword")) === 0)
		{
			$this->form_validation->set_message('userpass_check', '%s '.tr("password pattern error"));
			return FALSE;
		}
		else
		{
                    return TRUE;
		}
       }
        public function dob_check()
	{
            
            	if(preg_match("/".DATE_PATTERN."/", $this->input->post("txtDob")) === 0)
		{
			$this->form_validation->set_message('dob_check', '%s '.("DOB_PATTERN_ERROR"));
			return FALSE;
		}
		else
		{
                    return TRUE;
		}
       }
       
        public function weburl_check()
	{
            
            	if(preg_match("|".WEBSITE_URL_PATTERN."|i", $this->input->post("txtWeburl")) === 0)
		{
			$this->form_validation->set_message('weburl_check', '%s '.tr("WEBSITE_URL_PATTERN_ERROR"));
			return FALSE;
		}
		else
		{
                    return TRUE;
		}
       }
        public function security_check()
	{
            $captcha=$this->coresession->userdata("REGIS_CAPTCHA");
            $captcha_word=strtolower($captcha['word']);
            $security_code=strtolower($this->input->post("txtSecurity"));
            if($captcha_word!=$security_code)
            {
                $this->form_validation->set_message('security_check', '%s '.("Security code does not match with the given image"));
                return FALSE;
            }
            else
            {
                return TRUE;
            }
       }

        function emailexist_check()
        {
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            
            $username=$this->input->post('txtEmail');    
            $loginObj=new Login_model();
            $data=$loginObj->get_user_data($username);
            if(!empty($data))
            {
                $this->form_validation->set_message('emailexist_check', 'This email id is already registered');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        function useraccount_exist_check()
        {
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $username=$this->input->post('txtEmail');    
            $loginObj=new Login_model();
            $data=$loginObj->check_useraccount_data($username);
            if(empty($data))
            {
                $this->form_validation->set_message('useraccount_exist_check', 'This account does not exist');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        function userexist_check()
        {
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $username=$this->input->post('txtUsername');    
            $loginObj=new Login_model();
            $data=$loginObj->check_username_data($username);
            if(!empty($data))
            {
                $this->form_validation->set_message('userexist_check', 'Username already exists');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */