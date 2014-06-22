<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends RT_Controller {
    
	public function __construct()
	{
            //$this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
            parent::__construct();
            $this->load->library('coresession');
        }
        
        public function index() // default function called for the home controller
	{
            $commonObj=new Common_model(); // common model object created 
            $data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['page_meta_keywords'] = $data['home_content']->meta_keywords;
            $data['page_meta_desc'] = $data['home_content']->meta_description;
            $this->render($data,'home');
  	}
        
        public function chat()
	{
            $this->load->model('login_model');
            $loginObj=new Login_model();
            $is_logged_in = $loginObj->is_loggedin();
            if(!$is_logged_in)
            {
                redirect("/signin_up");
            }
            
            $this->load->model('chat_model');
            
            $data['user_session'] = $this->coresession->userdata('USER_SESSION');
            $data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = $data['home_content']->meta_title;
            $data['page_meta_keywords'] = $data['home_content']->meta_keywords;
            $data['page_meta_desc'] = $data['home_content']->meta_description;
            $this->render($data,'chat');
	}
                
        
        function userlogin_check()
	{
            $username = $this->input->post('txtUsernameLogin');    
            $chatObj = new chat_model();
            $data = $chatObj->checkExist($username);
            if(!empty($data))
            {
                $this->coresession->set_userdata('user_session',$data);
                return true;
            }
            else {
                return false;
            }
        }
	
        function getUserContact()
        {
                $jsondata = array(
                                'error' => 0,
                                'success' => 0,
                                'error_mess' => "",
                                'success_mess' => "",
                            );
                $this->load->model("chat_model");
                $chatObj = new chat_model();
                $query = $this->input->post('q');
                $limit = $this->input->post('page_limit');
                $ret_arr = $chatObj->getUserContact($query,$limit);
                
                $jsondata['contacts'] = $ret_arr;

                die(json_encode($jsondata));
            
        }
        function acceptReq()
        {
                $jsondata = array(
                                'error' => 0,
                                'success' => 1,
                                'error_mess' => "",
                                'success_mess' => "",
                            );
                $this->load->model("chat_model");
                $chatObj = new chat_model();
                $user_id = $this->input->post('user_id');
                
                $chatObj->acceptReq($user_id);
                
                die(json_encode($jsondata));
            
        }
        function getUser($user = "")
        {
            
            $this->load->model('login_model');
            $this->load->model('chat_model');
            $loginObj=new Login_model();
            $chatObj = new chat_model();
            $is_logged_in = $loginObj->is_loggedin();
            if(!$is_logged_in)
            {
                redirect("/signin_up");
            }
            
            $chatObj = new chat_model();
            $data['user'] = $chatObj->getUserDetailByUsername($user);
            if(empty($data['user']))
                redirect("/home/chat");
            $data['is_friend'] = $chatObj->isFriend($data['user']->id);
            $data['user_session'] = $this->coresession->userdata('USER_SESSION');
            $data['main_page'] = "user_page";
            $this->load->view('main_center',$data);
        }
        
        function sendRequest()
        {
            $this->load->model('login_model');
            $this->load->model('chat_model');
            $loginObj=new Login_model();
            $chatObj = new chat_model();
            $is_logged_in = $loginObj->is_loggedin();
            if(!$is_logged_in)
            {
                redirect("/signin_up");
            }
            $userid = decode_id($this->input->post("myid"));
            $chatObj = new chat_model();
            $data['user'] = $chatObj->getUserDetail($userid);
            if(empty($data['user']))
                redirect("/home/chat");
            $data['is_friend'] = $chatObj->isFriend($userid);
            if(!empty($data['is_friend']) && $data['is_friend']->status != 1)
            {
                die("already sent request");
            }
            if(!empty($data['is_friend']) && $data['is_friend']->status == 1)
            {
                die("already you are friend");
            }
            $chatObj->sendRequest($userid);
            redirect("/home/chat/?request=sent");
        }
        
        function friendChatList()
        {
            $jsondata = array(
                                'error' => 0,
                                'success' => 1,
                                'error_mess' => "",
                                'success_mess' => "",
                            );
            $this->layout = 'ajax';
            $this->load->model("chat_model");
            $chatObj = new chat_model();
            $data['friends_list'] = $chatObj->findFriends();
            $jsondata['friends_list'] = $this->renderPartial($data,'ajax_friend_list');
            die(json_encode($jsondata));
        }
        
        function friendChatRequestList()
        {
            $jsondata = array(
                                'error' => 0,
                                'success' => 1,
                                'error_mess' => "",
                                'success_mess' => "",
                            );
            $this->layout = 'ajax';
            $this->load->model("chat_model");
            $chatObj = new chat_model();
            $data['friend_request_list'] = $chatObj->findFriendRequest();
            $jsondata['friend_request_list'] = $this->renderPartial($data,'ajax_friend_request_list');
            die(json_encode($jsondata));
        }
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */