<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MCH_Controller {

	public function __construct()
	{
	    parent::__construct();
            logoutredirect();
        }
        
	public function index() // default function called for the home controller
	{
            $data['error']="";
            $data['csrf_auth'] = $this->get_tokens();
            $commonObj = new Common_model(); // common model object created 
            $settingObj = new Users_model();  
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['dashboard'] = array(
                                'title' => "Users Management",
                                'li' =>array(
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'users/listuser',
                                            'text' => 'Users list',
                                            'dash_img' => 'user_list'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'users/adduser',
                                            'text' => 'Add Users',
                                            'dash_img' => 'user_add'
                                            )
                                        )
                                );
            $data['content'] = "dashboard"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel | user management";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Users management' => ADMIN_HTTP_PATH.'users'
                                    ) ;
            $data['left_active'] = '5';
            $this->load->view("admin/main_center",$data);
	}
        
        public function listuser($startpoint=0,$orderby='created_date',$sort_order=false,$per_page = PER_PAGE)
        {
            if($startpoint < 0)
                die;
            $data['csrf_auth'] = $this->get_tokens();
            $search_key= "";
            $search_key = trim($this->input->post("txtSearchKey"));
            $sess_search_key = $this->coresession->userdata("USER_SEARCH_KEY");
            if(!isset ($_POST['hdnSerachFnd']))
            {
                $search_key = $sess_search_key;
            }
            $this->coresession->set_userdata("USER_SEARCH_KEY",$search_key);
            $data['error']="";
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $userObj=new Users_model();
            $total_rows=$userObj->get_users_list($search_key,'nopaging');
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'users/listuser/'); 
            
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['search_key']=$search_key;
            
            $data['users_list']=$userObj->get_users_list($search_key,'paging',$startpoint,$limit,$orderby,$sort_order);
            if($startpoint >= PER_PAGE && empty($data['users_list']))
            {
                $rd_stp = $startpoint - PER_PAGE;
                redirect ("admin/users/listuser/".$rd_stp);
                exit();
            }
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "users_list"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel | user management";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Users management' => ADMIN_HTTP_PATH.'users',
                                    'Users list' => ADMIN_HTTP_PATH.'users/listuser'
                                    ) ;
            $data['left_active'] = '5';
            $this->load->view("admin/main_center",$data);
        }
        
        public function add($startpoint=0)
        {
            $data['csrf_auth'] = $this->get_tokens();
            $data['error']="";
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $commonObj=new Common_model(); // common model object created 
            $userObj=new Users_model();
            $emailTemplate = new emailtemplate();
            $mailObj=new Mchmail();
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->load->library('form_validation');
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('txtFirstname', 'First name', 'trim|required|max_length[20]|alpha');
            $this->form_validation->set_rules('txtLastname', 'Last name', 'trim|required|max_length[20]|alpha');
            $this->form_validation->set_rules('txtEmailId', 'Email ID', 'trim|required|max_length[50]|valid_email|callback_emailvalid_check');
            $this->form_validation->set_rules('txtPassword', 'PASSWORD', 'trim|required|min_length[8]|max_length[30]|matches[txtConfPassword]|callback_userpass_check');
            $this->form_validation->set_rules('txtConfPassword', 'CONF_PASSWORD', 'trim|required|min_length[8]|max_length[30]');
            
            
            $data['error']="";
            //if($this->input->post('update'))
            {
                if ($this->form_validation->run() == FALSE)
                {
                    $data['error']= validation_errors();
                }
                else
                {
                    $txtFirstname=nohtmldata(ucfirst($this->input->post('txtFirstname')));
                    $txtLastname=nohtmldata(strtolower($this->input->post('txtLastname')));                    
                    $txtEmailId=nohtmldata($this->input->post('txtEmailId'));
                    $txtPassword=nohtmldata($this->input->post('txtPassword'));                    
                    $username = generate_username($txtFirstname,$txtLastname);
                    $up_data = array(
                                'first_name' => $txtFirstname,
                                'last_name' => $txtLastname,
                                'email_id' => $txtEmailId,
                                'login_user' => $username,
                                'login_pass' => md5(MD5_PREFIX_PASS.$txtPassword),
                                'created_date' => time(),
                                'is_enabled' => 1
                                );

                    $insert_id=$userObj->insert_userdata($up_data);
                    $this_id=encode_id($insert_id);
                    
                    
                    
                    $maildata=array(
                                    'type'=>'user_register_by_admin',
                                    'email'=>$txtEmailId,
                                    'sender_name' => "",
                                    'first_name' => $txtFirstname,
                                    'last_name' => $txtLastname,
                                    'username' => $username,
                                    'password' => $txtPassword

                                );
                    
                    $template = $emailTemplate->getAnEmailtemplate('USER_REGISTRER_BY_ADMIN');
                    $mailObj->sendmail($maildata,$template);
                    
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'User created successfully');
                    $hdnstartpoint=$this->input->post('hdnstartpoint');
                    rt_redirect('/admin/users/edituser/'.$this_id,'/admin/users/adduser/','/admin/users/listuser/');
                }
            }
            
            //$data['configdata']=$userObj->get_user_byid($id);
            $data['startpoint']=$startpoint;
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "users_add"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel | user management";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Users management' => ADMIN_HTTP_PATH.'users',
                                    'Users list' => ADMIN_HTTP_PATH.'users/listuser',
                                    'Add User' => ADMIN_HTTP_PATH.'users/listuser/adduser'
                                    ) ;
            $data['left_active'] = '5';
            $this->load->view("admin/main_center",$data);
        }
        
        
        public function edit($id,$startpoint=0)
        {
            $data['csrf_auth'] = $this->get_tokens();
            if(!$id)
            {
                 redirect('/admin/users/listusers/'.$startpoint);
            }
            $data['orig_id']=$id;
            $id = decode_id($id);
            $commonObj=new Common_model(); // common model object created 
            $userObj=new Users_model();
            $emailTemplate = new emailtemplate();
            $mailObj=new Mchmail();
            $this->load->library('form_validation');
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('txtFirstname', 'First name', 'trim|required|max_length[70]|alpha');
            $this->form_validation->set_rules('txtLastname', 'Last name', 'trim|required|max_length[70]|alpha');
            $this->form_validation->set_rules('txtEmailId', 'Email ID', 'trim|required|max_length[200]|valid_email|callback_emailvalid_check');
            $this->form_validation->set_rules('txtPassword', 'Password', 'trim|max_length[30]|matches[txtConfPassword]|callback_userpass_up_check');
            $this->form_validation->set_rules('txtConfPassword', 'Confirm passowrd', 'trim|max_length[30]');
            $data['error']="";
            if($this->input->post('update'))
            {
                if ($this->form_validation->run() == FALSE)
                {
                    $data['error']= validation_errors();
                }
                else
                {
                    $txtFirstname=nohtmldata(ucfirst($this->input->post('txtFirstname')));
                    $txtLastname=nohtmldata(strtolower($this->input->post('txtLastname')));                    
                    $txtEmailId=nohtmldata($this->input->post('txtEmailId'));
                    $txtUsername=nohtmldata($this->input->post('txtUsername'));                    
                    $txtPassword=nohtmldata($this->input->post('txtPassword'));                    
                    $up_data = array(
                                'first_name' => $txtFirstname,
                                'last_name' => $txtLastname,
                                'email_id' => $txtEmailId,
                                'modified_date' => time()
                                );
                    if(strlen($txtPassword)>0)
                    {
                        $up_data['login_pass'] = md5(MD5_PREFIX_PASS.$txtPassword);
                    }
                    $userObj->update_userdata($id,$up_data);
                    
                    
                    $maildata=array(
                                    'type'=>'user_updated_by_admin',
                                    'email'=>$txtEmailId,
                                    'sender_name' => "",
                                    'first_name' => $txtFirstname,
                                    'last_name' => $txtLastname
                                    

                                );
                    if(strlen($txtPassword)>0)
                    $maildata['password'] = $txtPassword;
                    
                    $template = $emailTemplate->getAnEmailtemplate('USER_UPDATED_BY_ADMIN');
                    $mailObj->sendmail($maildata,$template);
                    
                    
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'User data successfully updated');
                    rt_redirect('/admin/users/edituser/'.$data['orig_id'],'/admin/users/adduser/','/admin/users/listuser/');
                }
            }
            $data['userup_data']=$userObj->get_user_byid($id);
            $data['startpoint']=$startpoint;
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "users_edit"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel | user management";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Users management' => ADMIN_HTTP_PATH.'users',
                                    'Users list' => ADMIN_HTTP_PATH.'users/listuser',
                                    'Edit User' => ''
                                    ) ;
            $data['left_active'] = '5';
            $this->load->view('admin/main_center',$data);
        }
        
        private function username_check()
	{
            $username=$this->input->post("txtUsername");
            $update=  decode_id($this->input->post("update"));
            
		if(preg_match("/^[0-9a-zA-Z_]{5,}$/", $username) === 0)
		{
			$this->form_validation->set_message('username_check', '%s must be bigger that 5 chars and contain only digits, letters and underscore');
			return FALSE;
		}
		else
		{
                        $commonObj=new Common_model(); // common model object created 
                        $ret=$commonObj->checkvalidusername($username,$update); // function to delete rows form the table
                        if($ret)
                        {
                            return true;
                        }
                        else
                        {
                            $this->form_validation->set_message('username_check', "USERNAME_ALREADY_USED_ERROR");
                            return false;
                        }
		}
	}
        
        private function userpass_check()
	{
		if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $this->input->post("txtPassword")) === 0)
		{
			$this->form_validation->set_message('userpass_check', '%s must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit');
			return FALSE;
		}
		else
		{
                    return TRUE;
		}
	}
        
        private function emailvalid_check() // default function called for the home controller
	{
            ajaxlogoutmess();
            $commonObj=new Common_model(); // common model object created 
            
            $emailid= $this->input->post('txtEmailId');
            $update=decode_id($this->input->post("update"));
            $ret=$commonObj->checkvalidemail($emailid,$update); // function to delete rows form the table
            if($ret)
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('emailvalid_check', "Email ID is already registered");
                return false;
            }
	}
        
        private function userpass_up_check()
	{
            if(strlen($this->input->post("txtPassword"))>0)
            {
		if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $this->input->post("txtPassword")) === 0)
		{
			$this->form_validation->set_message('userpass_up_check', '%s must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit');
			return FALSE;
		}
		else
		{
                    return TRUE;
		}
            }
            else
            {
                return TRUE;
            }
	}
        
        
        
}

