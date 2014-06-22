<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailtemplate extends RT_Controller {

	public function __construct()
	{
	     parent::__construct();
             $this->form_validation->set_message('required', '%s');
             logoutredirect();
	}
        
	public function index($startpoint = 0,$orderby = 'email_label',$sort_order=false,$per_page = PER_PAGE) 
// default function called for the emailtemplates controller
	{
            $data['error']="";
            $data['sucessmessage']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $etemplateObj=new Emailtemplate_model();
            $data['spans_arr']= array(
                                'left' => 2,
                                'center' => 10,
                                );
            $total_rows=$etemplateObj->get_templates('nopaging');
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'emailtemplate/index/'); 
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['email_templates']=$etemplateObj->get_templates('paging',$startpoint,$limit,$orderby,$sort_order);
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'EMAIL_TEMPLATES'=> ADMIN_HTTP_PATH.'emailtemplate'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['user_session']=$this->coresession->userdata('USER_SESSION');
            $this->render($data);
	}
        
        
        
        function viewtemplate($id=false)
        {
            logoutredirect();
            if(empty($id))
                die;
            $orig_id=$id;
            $id=  decode_id($id);
            $data['sel_lang_def']="";
            $data['sel_lang_def_id']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available
            $etemplateObj=new Emailtemplate_model();
            $data['template_data']=$etemplateObj->get_template_byid($id); // function to value by the id
            if(empty($data['template_data']))
                die;
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['setting_data']=$this->coresession->userdata('SETTINGS_DATA');
            $this->load->view('admin/emailtemplate_view',$data);
        }
        
        
        
        public function add() // metasection function 
	{
            logoutredirect();
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $etemplateObj=new Emailtemplate_model();
            $data['spans_arr']= array(
                                'left' => 2,
                                'center' => 10,
                                );
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_rules('txtLabel', 'LABEL_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtSubject', 'SUBJECT_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtBody', 'BODY_ERROR', 'trim|required');
            
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtLabel'))
                {
                    $data['error']= form_error('txtLabel');
                }
                else
                if(form_error('txtSubject'))
                {
                    $data['error']= form_error('txtSubject');
                }
                else
                if(form_error('txtBody'))
                {
                    $data['error']= form_error('txtBody');
                }
            }
            else
            {
                    $label=$this->input->post('txtLabel');    
                    $subject=$this->input->post('txtSubject');
                    $body=$this->input->post('txtBody');
                    
                    $up_data = array(
                                'email_label' => strtoupper(spacetounderscore(nohtmldata($label))),
                                'mail_subject' => nohtmldata($subject),
                                'body' => ($body)
                                );
                    
                    $orig_id =  encode_id($etemplateObj->add_template($up_data));
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'INSERT_SUCCESS');
                    rt_redirect('/admin/emailtemplate/edit/'.$orig_id,'/admin/emailtemplate/add/','/admin/emailtemplate/');
            }
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'EMAIL_TEMPLATES'=> ADMIN_HTTP_PATH.'emailtemplate',
                                    'ADD_TEMPLATE'=> ADMIN_HTTP_PATH.'emailtemplate/add'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $this->render($data);
	}
        
        
        public function edit($id=false) // metasection function 
	{
            logoutredirect();
            $data['error']="";
             if(empty($id))
                redirect('/admin/emailtemplate/');
            $orig_id=$id;
            $id=  decode_id($id);
             $data['spans_arr']= array(
                                'left' => 2,
                                'center' => 10,
                                );
            $commonObj=new Common_model(); // common model object created 
            $etemplateObj=new Emailtemplate_model();
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            
            $this->form_validation->set_rules('txtSubject', 'SUBJECT_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtBody', 'BODY_ERROR', 'trim|required');
            
            if ($this->form_validation->run() == FALSE)
            {
                
                if(form_error('txtSubject'))
                {
                    $data['error']= form_error('txtSubject');
                }
                else
                if(form_error('txtBody'))
                {
                    $data['error']= form_error('txtBody');
                }
            }
            else
            {
                    
                    $subject=$this->input->post('txtSubject');
                    $body=$this->input->post('txtBody');
                    
                    $up_data = array(
                                'mail_subject' => nohtmldata($subject),
                                'body' => ($body)
                                );
                    
                    $etemplateObj->update_template($up_data,$id);
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'UPDATE_SUCCESS');
                    rt_redirect('/admin/emailtemplate/edit/'.$orig_id,'/admin/emailtemplate/add/','/admin/emailtemplate/');
            }
            
            $data['template_data']=$etemplateObj->get_template_byid($id); // function to value by the id
            if(empty($data['template_data']))
                 redirect('/admin/emailtemplate/');
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'EMAIL_TEMPLATES'=> ADMIN_HTTP_PATH.'emailtemplate',
                                    'DELETE_TEMPLATE'=> ADMIN_HTTP_PATH.'emailtemplate/edit'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $this->render($data);
	}
        
        
        function importtempeng()
        {
            $data=array();
            $etemplateObj=new Emailtemplate_model();
            $ret_val=$etemplateObj->import_template();
            $data['success']="0";
            $data['success_mess']=tr("IMPORT_DATA_SUCCESS");
            $data['error']="0";
            $data['error_mess']=tr("IMPORT_DATA_ERROR");
            if($ret_val)
            {
                $data['success']="1";
            }
            else
            {
                $data['error']="1";
            }
            $data['datap']="1";
            echo json_encode($data);
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */