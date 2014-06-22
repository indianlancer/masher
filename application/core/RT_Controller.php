<?php
/**
* This class extend default Controller class and we will use it
* as parent for all controllers in our project
*
* @author Rishi 
*/

if ( ! class_exists('CI_Model'))
{            
    require_once(BASEPATH.'core/Model'.EXT);
}
require_once APPPATH . 'models/RT_Model.php';

class RT_Controller extends CI_Controller
{
   protected $_controller;
   public    $language;
   public $folder;
   public $lang_id;
   public $layout="default";
   public $load_view;
   public $load_content;
   public $page;
   private $method;
   public $route;
   private $dir;
   private $action;
   public $load_model = TRUE;
   public $load_session = TRUE;
   public $check_acl = true;
   
   
    protected function before_filter()
    {
        $routePath = APPPATH . 'config/routes.php';
        require($routePath);
        $this->route = $route;
        $this->check_rec_dir();
        if($this->check_acl === false)
            return true;
        if(!$this->load_session)
            return true;
        $this->load->library('Aclauth');
        $ret_check = $this->aclauth->acosAuthcheck($this->route);
        if($ret_check == false)
            //redirect(uri_string());
        die("Hacking attempt");
    }
    protected function after_filter(){
        
    }


    // Utilize _remap to call the filters at respective times
    public function _remap($method, $params = array())
    {
        $this->before_filter();
        if (method_exists($this, $method))
        {
            empty($params) ? $this->{$method}() : call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $mess="You have done some change in error404 files path please fix this first";
            handle_error($mess);
        }
        $this->after_filter();
    }

   public function __construct($deflang=1){
                parent::__construct();
                if($this->load_session)
                {
                    $this->load->library('coresession');
                }
                else
                    return true;
                $this->_set_model_obj();
                $this->lang_id=$this->coresession->userdata('cchl_id');
                if(strlen($this->lang_id)<1)
                {
                    $this->lang_id=$deflang;
                }
                $this->form_validation->set_error_delimiters('', '');
                $this->_define_layouts();
                $this->_create_constants();
		if($this->config->item('translator') == 'on'){
			$this->load->library('coresession');
                        if ($this->input->post('hl')) {
                                if($this->uri->segment(1)!="admin")
                                {
                                    $this->coresession->set_userdata('lang', $this->input->post('hl'));
                                    $this->coresession->set_userdata('cchl', $this->input->post('cchl'));
                                    $this->coresession->set_userdata('cchl_id', $this->input->post('cchl_id'));
                                }
                                else
                                {
                                    $this->coresession->set_userdata('admin_lang', $this->input->post('hl'));
                                    $this->coresession->set_userdata('admin_cchl', $this->input->post('cchl'));
                                    $this->coresession->set_userdata('admin_cchl_id', $this->input->post('cchl_id'));
                                }
			}
			if(!$this->uri->segment(1)) {
				$this->_controller = $this->route['default_controller'];
			} else {
                                if(($this->uri->segment(1)!="admin") && ($this->uri->segment(1)!="clientarea"))
                                {
                                    $this->_controller = $this->uri->segment(1);
                                    $this->folder='';
                                }
                                else if($this->uri->segment(1)!="admin")
                                {
                                    $this->folder='clientarea/';
                                    if(!$this->uri->segment(2))
                                    {
                                        
                                        $this->_controller = $this->route['default_controller'];
                                    }
                                    else
                                    {
                                        $this->_controller = $this->uri->segment(2);
                                    }
                                }
                                else
                                {
                                    $this->folder='admin/';
                                    if(!$this->uri->segment(2))
                                    {
                                       $this->_controller = $this->route['default_controller'];
                                    }
                                    else
                                    {
                                        $this->_controller = $this->uri->segment(2);
                                    }
                                }
			}
			$this->load->library('Multilang');
			$this->language = new Multilang();
                        
                        if($this->uri->segment(1)!="admin")
                        {
                            $lang = $this->coresession->userdata('lang');
                            if(!$lang || $lang == "") {
                                $lang=$this->_get_lang_for();
                            	//$lang = $this->config->item('default_language');
				$this->coresession->set_userdata('lang', $lang);
                                $this->coresession->set_userdata('cchl', $lang);
                                $this->coresession->set_userdata('cchl_id', $this->lang_id);
                            }
			}
                        else
                        {
                            $lang = $this->coresession->userdata('admin_lang');
                            if(!$lang || $lang == "") {
                                $lang=$this->_get_lang_for();
                                //$lang = $this->config->item('default_language');
				$this->coresession->set_userdata('admin_lang', $lang);
                                $this->coresession->set_userdata('admin_cchl', $lang);
                                $this->coresession->set_userdata('admin_cchl_id', $this->lang_id);
                            }
                            
                        }
			$this->language->load($this->_controller, $lang,$this->folder);   
		}
  	  
   }
   
   
    public function render($data= array(),$view_call = NULL)
    {
        $base_method = $this->router->fetch_method();
        
        $class_path = $this->dir;
        $action_path = $this->action;
        $method="";
        if($this->page!="error")
        {
            if(strlen($class_path) == 0)
            {
                $class = $this->route['default_controller'];
                if(strlen($view_call)==0)
                    $method = $base_method;
                else
                $method = $view_call;
            }
            elseif(strlen($class_path) > 0 && strlen($action_path) > 0)
            {
                $class = $class_path;
                if(strlen($view_call)==0)
                    $method = $base_method;
                else
                $method = $view_call;
            }
            else 
            {
                $class = $class_path;
                if(is_dir(APPPATH."controllers/".$class))
                {
                    $class = $class."/".$this->route['default_controller'];
                }
                if($view_call==null)
                {
                    if(strlen($action_path)==0)
                        $method = $base_method;
                    else
                        $method = $action_path;
                }
                else {
                    $method = $view_call;
                }
            }
        }
        else
        {
           $class ="error404";
           $method ="index";
        }
        if(trim($this->layout)!='iframe' && $this->layout!='ajax' && $this->layout!='json')
        {
            $this->check_views_dir($class);
            $this->__check_file($class,$method);
        }
       
           if(!file_exists(APPPATH."views/layouts/".$this->layout.".php"))
           {

               $mess=$this->layout.".php file does not exist in layouts folder in views";
               error404_disp($mess);
           }
           $this->load_view = $class."/".$method;
           $this->load_content = $data;
           $this->load->view("layouts/".$this->layout, $data);
       
    }
    
    public function renderPartial($data= array(),$view_call = NULL)
    {
        $base_method = $this->router->fetch_method();
        
        $class_path = $this->dir;
        $action_path = $this->action;
        $method="";
        if($this->page!="error")
        {
            if(strlen($class_path) == 0)
            {
                $class = $this->route['default_controller'];
                if(strlen($view_call)==0)
                    $method = $base_method;
                else
                $method = $view_call;
            }
            elseif(strlen($class_path) > 0 && strlen($action_path) > 0)
            {
                $class = $class_path;
                if(strlen($view_call)==0)
                    $method = $base_method;
                else
                $method = $view_call;
            }
            else 
            {
                $class = $class_path;
                if(is_dir(APPPATH."controllers/".$class))
                {
                    $class = $class."/".$this->route['default_controller'];
                }
                if($view_call==null)
                {
                    if(strlen($action_path)==0)
                        $method = $base_method;
                    else
                        $method = $action_path;
                }
                else {
                    $method = $view_call;
                }
            }
        }
        else
        {
           $class ="error404";
           $method ="index";
        }
        if(trim($this->layout)!='iframe' && $this->layout!='ajax' && $this->layout!='json')
        {
            $this->check_views_dir($class);
            $this->__check_file($class,$method);
        }
       
           if(!file_exists(APPPATH."views/layouts/".$this->layout.".php"))
           {

               $mess=$this->layout.".php file does not exist in layouts folder in views";
               error404_disp($mess);
           }
           $this->load_view = $class."/".$method;
           $this->load_content = $data;
           ob_start();
           $this->load->view("layouts/".$this->layout, $data);
           return ob_get_clean();
       
    }
   
    private function __check_file($folder,$view)
    {
      $def_view= 'views/'.$folder."/".$view;
       if(!file_exists(APPPATH.$def_view.".php"))
       {
            $mess=$view.".php file does not exist in ".$folder." folder in views";
            error404_disp($mess);
       }
    }
    
    function check_rec_dir($seg=1,$dir=false)
    {
        $nseg = $class = $this->uri->segment($seg);
        if($dir==false && strlen($class)>0)
        {
            if(is_dir(APPPATH."controllers/".$class))
            {
                $dd= $this->check_rec_dir(++$seg,$class);
                return $dd;
            }
            else
            if(file_exists(APPPATH."controllers/".$class.".php"))
            {
                $this->dir = $class;
                return $class."|";
            }
            else 
            {
                $class = $this->router->fetch_class();
                if(file_exists(APPPATH."controllers/".$class.".php"))
                {
                    $this->dir = $class;
                    return $class."|";
                }
            }
        }
        else
        if($dir==true && strlen($class) == 0)
        {
            $this->dir = $dir;
            $this->action = $class;
            return $dir."|".$class;
        }
        else
        if($dir==true && strlen($class) > 0)
        {
            $class = $dir."/".$class;
            if(is_dir(APPPATH."controllers/".$class))
            {
                $dd= $this->check_rec_dir(++$seg,$class);
                return $dd;
            }
            elseif(file_exists(APPPATH."controllers/".$class.".php"))
            {
                $this->dir = $class;
                return $class."|";
            }
        }
        $this->dir = $dir;
        $this->action = $nseg;
        return $dir."|".$nseg;
    }
    function check_views_dir($dir)
    {
        $dir = explode("/", $dir);
        $check_folder="views";
        $found_folder="views";
        foreach($dir as $folders)
        {
            $check_folder .= "/". $folders;
            if(is_dir(APPPATH."/".$check_folder))
            {
                $found_folder .= "/". $folders;
                continue;
            }
            else
            {
                $mess=$folders." folder does not exist in ".$found_folder;
                error404_disp($mess);
            }
        }
    }
    
    
    public function fetch($content='content')
    {
        $this->load->view($this->load_view, $this->load_content);
    }
    
    public function element($content=false,$data=false)
    {
        if(is_array($content))
        {
            if(!(empty($content)))
            foreach($content as $elem)
            {
                $this->element($elem,$data);
            }
        }
        else 
        {
             $this->load->view("elements/".$content, $data);
        }
        
    }
    
    
   protected function _get_lang_for()
   {
        $ext=base_url();
        $ext=end(explode(".",$ext));
        $ext=(explode("/",$ext));
        $ext=$ext[0];
        $result="";
        if($ext!="")
        {
            $this->db->select('*');
            $this->db->from('language');
            $this->db->where('is_enabled',1);
            $query = $this->db->get();
            if($query->num_rows()>0)
            {
                $ret=$query->result();
                foreach($ret as $data)
                {
                    $datan=explode("|",$data->for_domain_ext);
                    if(in_array($ext,$datan))
                    {
                        $result=$data->lang;
                        $this->lang_id=$data->id;
                    }
                }
            }
        }
        if(empty($result))
        {
            return "en";
        }
        else
        {
            return $result;
        }
   }
   
   protected function _create_constants()
   {
        $this->db->select( 'param, value' );
        $this->db->from( 'std_config');
        $this->db->where( 'is_constant', 1);
        $result=$this->db->get();
        $app_conf = $result->result_array();
        foreach( $app_conf as $row )
        {
            if(!defined("{$row['param']}"))
            define( "{$row['param']}", $row['value'] );
        }

   }
   
   protected function _define_layouts()
   {
        $class = $this->uri->segment(1);
        $admin_name = $this->config->item('admin_path_name');
        $member_name = $this->config->item('member_path_name');
        if(strlen($admin_name)!=0)
        if($class == $admin_name)
        {
            $layout = $this->config->item('admin_layout');
            if(strlen($layout)!=0)
            $this->layout  = $this->config->item('admin_layout');
        }
        if(strlen($member_name)!=0)
        if($class == $member_name)
        {
            $layout = $this->config->item('member_layout');
            if(strlen($layout)!=0)
            $this->layout  = $layout;
        }

   }
   
   private function _set_model_obj()
   {
       if($this->load_model==TRUE)
       {
            $class= $this->router->fetch_class();
            $main_action = uri_string();
            $main_action = explode("/", $main_action);

            $class_key = array_search($class,$main_action);
            $folder_path = array_slice($main_action, 0,$class_key); 
            $folder_path = implode("/", $folder_path);
            if(strlen($folder_path)>0)
            {
                $class = $folder_path."/".$class;
            }
           
           
           $this->load->model($class."_model");
       }
   }

   /** 
    * Fle is used to set default menu, seo data, session data, etc... for view
    * 
    * @return array 
    * @author rishi
    */ 
    
    protected function set_default_data_on_view()  
    {  
        $home_content = $this->home_model->get_content();
        return $ret_arr =  array(
                        'error_mess' => "",
                        'success_mess' => "",
                        'sel_lang_def' => "",      
                        'sel_lang_def_id' => "",
                        'home_content' => $home_content,
                        'langsel' => $this->common_model->get_langs(),
                        'setting_data' => $this->coresession->userdata('SETTINGS_DATA'),
                        'user_session' => $this->coresession->userdata('USER_SESSION'),
                       // 'header_menu_link' => $this->common_model->get_header_menu_links(),
                       // 'footer_menu_link' => $this->common_model->get_footer_menu_links(),
                        'meta_title' => $home_content->meta_title,
                        'meta_keywords' => strip_tags($home_content->meta_keywords),
                        'meta_description' => strip_tags($home_content->meta_description),
                    );
    }  
}
?>
