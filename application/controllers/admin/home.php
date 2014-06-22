<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends RT_Controller {

	public function __construct()
	{
            $this->load_model=false;
            parent::__construct();
            
	}
        
	public function index() // default function called for the home controller
	{
            logoutredirect();
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 5,
                                'right' => 4
                                );
            $data['dashboard'] = array(
                                'title' => "DASHBOARD",
                                'li' =>array(
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'acl_manage',
                                            'text' => 'ACL_MANAGE',
                                            'dash_img' => 'acl'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'language',
                                            'text' => 'LANGUAGES',
                                            'dash_img' => 'languages'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'emailtemplate',
                                            'text' => 'EMAIL_TEMPLATES',
                                            'dash_img' => 'email_templates'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'blogs',
                                            'text' => 'BLOGZ',
                                            'dash_img' => 'blog'
                                            )
                                        )
                                );
            $data['load_file'] = "admin_dashboard"; // element load
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $this->render($data);
  	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */