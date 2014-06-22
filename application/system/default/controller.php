<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _CONTROLLER_ extends RT_Controller {

	public function __construct()
	{
	     parent::__construct();
	}
        
	public function index() // default function called for the home controller
	{
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['home_content'] = $this->home_model->get_content();
            $data['posts']=$this->blog_model->getAllBy(null,array("id",'ASC'));
            $data['header_menu_link']=$commonObj->get_header_menu_links();
            $data['footer_menu_link']=$commonObj->get_footer_menu_links();
            $data['title_for_layout']=$data['home_content']->meta_title;
            $data['meta_keywords']=strip_tags($data['home_content']->meta_keywords);
            $data['meta_description']=strip_tags($data['home_content']->meta_description);
            $data['footer_title_text']=$data['home_content']->txtFooter;
            $data['footer_bottom_line']=$data['home_content']->txtBottomline;
            $data['footer_bottom_linecont']=$data['home_content']->txtBottomlinecont;
            $this->render($data);
  	}
	
        public function add() // default function called for the home controller
	{
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['home_content']=$this->home_model->get_content();
            $data['header_menu_link']=$commonObj->get_header_menu_links();
            $data['footer_menu_link']=$commonObj->get_footer_menu_links();
            $data['title_for_layout']=$data['home_content']->meta_title;
            $data['meta_keywords']=strip_tags($data['home_content']->meta_keywords);
            $data['meta_description']=strip_tags($data['home_content']->meta_description);
            $data['footer_title_text']=$data['home_content']->txtFooter;
            $data['footer_bottom_line']=$data['home_content']->txtBottomline;
            $data['footer_bottom_linecont']=$data['home_content']->txtBottomlinecont;
            
            if($this->request->is("post"))
            {
                $this->blog_model->create();
                /*$o->title = $this->input->post('title');
                $o->description = $this->input->post('description');
                $o->date = date("Y-m-d H:i:s");*/
                $this->exemple->save($o);
                //Creating the row in the database
            }
            $this->render($data,'add');
  	}
        
        public function view($id=false) // default function called for the home controller
	{
            if($id<1)
                redirect("/");
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['post']=$this->blog_model->getBy("id",$id);
            $data['home_content']=$this->home_model->get_content();
            $data['header_menu_link']=$commonObj->get_header_menu_links();
            $data['footer_menu_link']=$commonObj->get_footer_menu_links();
            $data['title_for_layout']=$data['home_content']->meta_title;
            $data['meta_keywords']=strip_tags($data['home_content']->meta_keywords);
            $data['meta_description']=strip_tags($data['home_content']->meta_description);
            $data['footer_title_text']=$data['home_content']->txtFooter;
            $data['footer_bottom_line']=$data['home_content']->txtBottomline;
            $data['footer_bottom_linecont']=$data['home_content']->txtBottomlinecont;
            $this->render($data);
  	}
        
        
        public function edit($id=false) // default function called for the home controller
	{
            if($id<1)
                redirect("/");
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['post']=$this->blog_model->getBy("id",$id);
            $data['home_content']=$this->home_model->get_content();
            $data['header_menu_link']=$commonObj->get_header_menu_links();
            $data['footer_menu_link']=$commonObj->get_footer_menu_links();
            $data['title_for_layout']=$data['home_content']->meta_title;
            $data['meta_keywords']=strip_tags($data['home_content']->meta_keywords);
            $data['meta_description']=strip_tags($data['home_content']->meta_description);
            $data['footer_title_text']=$data['home_content']->txtFooter;
            $data['footer_bottom_line']=$data['home_content']->txtBottomline;
            $data['footer_bottom_linecont']=$data['home_content']->txtBottomlinecont;
            if($this->request->is("post"))
            {
                //$this->blog_model->update()
            }
            
            
            
            $this->render($data);
  	}
        
        
        public function delete($id=false) // default function called for the home controller
	{
            if($this->request->is("ajax"))
            {
                if($id<1)
                    die("exception found");
                $element = $this->blog_model->read($id);
                $this->blog_model->delete($element->id);
                $this->render($data);
            }
            else
            {
                throw new Exception('ERROR: Cannot delete with this method request');
            }
  	}
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */