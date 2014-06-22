<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends RT_Controller {

	public function __construct()
	{
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
            $this->load->library('coresession');
            parent::__construct();
        }
        
        public function about() 
	{
            $commonObj=new Common_model(); // common model object created 
            //$data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = "About | Indianlancer | Get WOW-Perfect web application";
            $data['page_meta_keywords'] = "Codeigniter experts, YII experts, top website developement company, indian web company, website company, top most compnay, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android, Imperative Solutions";
            $data['page_meta_desc'] = "top website developement company, indian web company, website company, top most company, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android ,Imperative Solutions, Best outsource Joomla, Codeigniter experts ";

            $this->render($data);
  	}
        
        public function history() 
	{
            $commonObj=new Common_model(); // common model object created 
            //$data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = "";
            $data['page_meta_keywords'] = "";
            $data['page_meta_desc'] = "";

            $this->render($data);
  	}
        
        public function contact() 
	{
            $commonObj=new Common_model(); // common model object created 
            //$data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = "Contact | send us your requirements | Indianlancer | Get WOW-Perfect web application";
            $data['page_meta_keywords'] = "Codeigniter experts, YII experts, top website developement company, indian web company, website company, top most compnay, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android, Imperative Solutions";
            $data['page_meta_desc'] = "top website developement company, indian web company, website company, top most company, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android ,Imperative Solutions, Best outsource Joomla, Codeigniter experts ";

            $this->render($data);
  	}
        
        public function whyourclientsloveus() 
	{
            $commonObj=new Common_model(); // common model object created 
            //$data = $this->set_default_data_on_view();
            
            $data['title_for_layout'] = "Why our clients love us | Indianlancer | Get WOW-Perfect web application";
            $data['page_meta_keywords'] = "Codeigniter experts, YII experts, top website developement company, indian web company, website company, top most compnay, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android, Imperative Solutions";
            $data['page_meta_desc'] = "top website developement company, indian web company, website company, top most company, indian website company, web company india, php outsource, Codeignitor, Joomla website, cms, mvc , ecommerce, wordpress, music, indian, Website Design India, SEO,E-Commerce india, Mobile, iPhone, android ,Imperative Solutions, Best outsource Joomla, Codeigniter experts ";

            $this->render($data);
  	}
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */