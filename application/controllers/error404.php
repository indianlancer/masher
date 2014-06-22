<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error404 extends RT_Controller {
    
        public function __construct()
	{
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
            parent::__construct();
            $this->load->library('coresession');
            $this->load->model('home_model'); // model for the controller
	}
        
        public function index() // default function called for the home controller
	{
            //$this->layout = "default";
            $this->page = "error";
            $commonObj=new Common_model(); // common model object created 
            //$data = $this->set_default_data_on_view();
            
            
            //$data['title_for_layout']=$data['home_content']->meta_title;
            $data = array();
            $this->render($data);
  	}
        
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */