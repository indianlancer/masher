<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acl_manage extends RT_Controller {

	public function __construct()
	{
             $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
	     parent::__construct();
             $this->load->library('Aclauth');
             $this->load->model('admin/acl_manage_model');
	}
        
	public function index() // default function called for the home controller
	{
            logoutredirect();
            $commonObj=new Common_model(); // common model object created 
            $aclDbObj=new Acl_manage_model(); // common model object created 
            
            
            $data['langsel']=$commonObj->get_langs();
            $data['setting_data']=$this->coresession->userdata('SETTINGS_DATA');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Acl Manage'=> ADMIN_HTTP_PATH.'acl_manage'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'ACL_MANAGE';
            $data['acos_list'] = $aclDbObj->get_all_acos();
            $data['aros_list'] = $aclDbObj->get_all_aros();
            
            $this->render($data);
  	}
        
        
        function recreate_all_acos_aros()
        {
            ajaxlogoutmess();
            $this->aclauth->acosAuthCreate();
            $data=array(
                    'success' => 0,
                    'error' => 0,
                    'success_mess' => '',
                    'error_mess' => ''
                    );
            echo json_encode($data);
        }
        
        function tog_perm()
        {
            ajaxlogoutmess();
            $aclDbObj=new Acl_manage_model(); // common model object created
            $aro = nohtmldata($this->input->post("aro"));
            $aco = nohtmldata($this->input->post("aco"));
            $val_set = nohtmldata($this->input->post("val_set"));
            if($aro == 1)
                return false;
            if($val_set == 1)
                $val_set = 0;
            else
                $val_set = 1;
            $aco_data = $aclDbObj->set_aro_aco($aro,$aco,$val_set);
            $data=array(
                    'success' => 0,
                    'error' => 0,
                    'success_mess' => '',
                    'error_mess' => '',
                    'datap' => 1
                    );
            echo json_encode($data);
        }
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */