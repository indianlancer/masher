<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends RT_Controller {

	public function __construct()
	{
            $this->load_model=false;
	     parent::__construct();
             $this->load->model('admin/settings_model');
       }
        
	public function index() // default function called for the home controller
	{
            logoutredirect();
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $settingObj=new Settings_model();  
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 5,
                                'right' => 4,
                                );
            $data['dashboard'] = array(
                                'title' => "DASHBOARD",
                                'li' =>   array(
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'settings/config_setting',
                                            'text' => 'CONFIGURATION',
                                            'dash_img' => 'config-setting'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'settings/change_pass',
                                            'text' => 'CHANGE_PASS',
                                            'dash_img' => 'change_pass'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'settings/managecurrency',
                                            'text' => 'MANAGE_CURRENCY',
                                            'dash_img' => 'currency_sign'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'settings/site_logo',
                                            'text' => 'SITE_LOGO',
                                            'dash_img' => 'logo'
                                            )
                                        )
                                );
            $data['load_file'] = "admin_dashboard";
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $this->render($data);
	}
        
        public function config_setting($startpoint=0,$orderby=false,$sort_order=false,$per_page = PER_PAGE)
        {
            logoutredirect();
            $data['error']="";
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $settingObj=new Settings_model();
            $total_rows=$settingObj->get_config_list('nopaging');
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'settings/config_setting/'); 
            
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['config_list']=$settingObj->get_config_list('paging',$startpoint,$limit,$orderby,$sort_order);
            $data['user_session']=$this->coresession->userdata('USER_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $this->render($data);
        }
        
        public function up_config_setting($id,$startpoint=0)
        {
            logoutredirect();
            if(!$id)
            {
                 redirect('/admin/settings/config_setting/'.$startpoint);
            }
            $data['error']="";
            $real_id=  $id;
            $id=  decode_id($id);
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $commonObj=new Common_model(); // common model object created 
            $settingObj=new Settings_model();
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_message('required', '%s');
            $this->form_validation->set_rules('txtParam', 'CONFIG_PARAM_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtValue', 'CONFIG_VALUE_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtDesc', 'CONFIG_DESC_ERROR', 'trim');
            if($this->input->post('update'))
            {
                if ($this->form_validation->run() == FALSE)
                {
                    $data['error'] = validation_errors('<div class="error">', '</div>');
                }
                else
                {
                    $txtParam=nohtmldata(spacetounderscore(strtoupper($this->input->post('txtParam'))));
                    $txtValue=nohtmldata($this->input->post('txtValue'));
                    $txtDesc=nohtmldata($this->input->post('txtDesc'));
                    $hdnconfigid=  ($id);
                    
                    $up_data = array(
                                'param' => $txtParam,
                                'value' => $txtValue,
                                'description' => $txtDesc
                                );

                    $settingObj->update_setting_config($id,$up_data);
                    
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'UPDATE_SUCCESS');
                    $hdnstartpoint=$this->input->post('hdnstartpoint');
                    rt_redirect('/admin/settings/up_config_setting/'.$real_id,'/admin/settings/ct_config_setting/','/admin/settings/config_setting/'.$hdnstartpoint);
                }
            }
            $data['configdata']=$settingObj->get_config_byid($id);
            $data['startpoint']=$startpoint;
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $this->render($data);
        }
        
        public function ct_config_setting($startpoint=0)
        {
            logoutredirect();
            $data['error']="";
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $commonObj=new Common_model(); // common model object created 
            $settingObj=new Settings_model();
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_message('required', '%s');
            $this->form_validation->set_rules('txtParam', 'CONFIG_PARAM_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtValue', 'CONFIG_VALUE_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtDesc', 'CONFIG_DESC_ERROR', 'trim');
            if($this->input->post('update'))
            {
                if ($this->form_validation->run() == FALSE)
                {
                    $data['error'] = validation_errors('<div class="error">', '</div>');
                }
                else
                {
                    $txtParam=nohtmldata(spacetounderscore(strtoupper($this->input->post('txtParam'))));
                    $txtValue=nohtmldata($this->input->post('txtValue'));
                    $txtDesc=nohtmldata($this->input->post('txtDesc'));
                    $up_data = array(
                                'param' => $txtParam,
                                'value' => $txtValue,
                                'description' => $txtDesc
                                );

                    
                    $insert_id=$settingObj->set_setting_config($up_data);
                    $last_id=encode_id($insert_id);
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'INSERT_SUCCESS');
                    $hdnstartpoint=$this->input->post('hdnstartpoint');
                    rt_redirect('/admin/settings/up_config_setting/'.$last_id,'/admin/settings/ct_config_setting/','/admin/settings/config_setting/'.$hdnstartpoint);
                }
            }
            $data['startpoint']=$startpoint;
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $this->render($data);
        }
        
        public function change_pass()
        {
            logoutredirect();
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_message('required', '%s');
            $this->form_validation->set_message('matches', tr("PASSWORD_CONFIRM_ERROR"));
            $this->form_validation->set_rules('txtPassword', 'REQ_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtConfPassword', 'REQ_ERROR', 'trim|required|matches[txtPassword]');
            $settingObj=new Settings_model();
            if($this->input->post('update'))
            {
                if ($this->form_validation->run() == FALSE)
                {
                    if(form_error('txtPassword'))
                    {
                        $data['error']= form_error('txtPassword');
                    }
                    else
                    if(form_error('txtConfPassword'))
                    {
                        $data['error']= form_error('txtConfPassword');
                    }
                }
                else
                {
                    $txtPassword=$this->input->post('txtPassword');
                    
                    $up_data = array(
                                'admin_passd_user' => md5(MD5_PREFIX_PASS.$txtPassword)
                                );
                    
                    $settingObj->changepass($up_data);
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'PASS_UPDATE_SUCCESS');
                    redirect('/admin/settings/change_pass/');
                }
            }
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $this->render($data);
        }
        
        public function currency()
        {
            logoutredirect();
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $settingObj=new Settings_model();
            $data['currency']=$commonObj->getcurrenysymbol();
            $data['all_currency']=$settingObj->getallcurrenysymbol();
            $data['setting_data']=$this->coresession->userdata('SETTINGS_DATA');
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['title_for_layout'] = "Admin panel";
            
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $this->render($data);
        }
        
        public function managecurrency($startpoint=0,$orderby='id',$sort_order=false,$per_page = PER_PAGE)
        {
            logoutredirect();
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $settingObj=new Settings_model();
            $data['currency']=$commonObj->getcurrenysymbol();
            $data['currency_codes']=$settingObj->getallcurrenycode();
            $data['currency_formats']=$settingObj->getallcurrenyformat();
            $total_rows=$settingObj->getcurrenysymbol('nopaging');
            
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'settings/managecurrency/'); 
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['all_currency']=$settingObj->getcurrenysymbol('paging',$startpoint,$limit,$orderby,$sort_order);
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $this->render($data);
        }
        
        public function updatecurrencies()
        {
            ajaxlogoutmess();
            $postdata=json_decode($this->input->post('data'));
            if($postdata[0]!="new")
            $postdata[0]=  decode_id($postdata[0]);
            if(strlen($postdata[1])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=1;
                $data['success']="0";
            }
            else
            if(strlen($postdata[2])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=2;
                $data['success']="0";
            }
            else
            if(strlen($postdata[3])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=3;
                $data['success']="0";
            }
            else
            {
                $data['error_mess']="";
                $data['error_tab']=0;
                $up_data=array(
                        'currency_symbol'=>nohtmldata(urldecode($postdata[1])),
                        'currency_code'=>$postdata[2],
                        'currency_format'=>$postdata[3],
                        'space'=>($postdata[4]),
                        'place'=>($postdata[5])
                );
                $settingObj=new Settings_model();
                $data['last_id']=$settingObj->updatecurrencies($up_data,$postdata[0]);
                
                $data['success']="1";
                $data['success_mess']=tr("UPDATE_SUCCESS");
            }
            
            
            echo json_encode($data);
        }
        
        
        
        public function managecurrformats($startpoint=0,$orderby='id',$sort_order=false,$per_page = PER_PAGE)
        {
            logoutredirect();
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $settingObj=new Settings_model();
            $total_rows=$settingObj->getcurrenyformats('nopaging');
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'settings/managecurrformats/'); 
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['currency_formats']=$settingObj->getcurrenyformats('paging',$startpoint,$limit,$orderby,$sort_order);
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $this->render($data);
        }
        
        public function updateformats()
        {
            ajaxlogoutmess();
            $postdata=json_decode($this->input->post('data'));
            
            if($postdata[0]!="new")
            $postdata[0]=  decode_id($postdata[0]);
            if(strlen($postdata[1])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=1;
                $data['success']="0";
            }
            else
            if(strlen($postdata[2])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=2;
                $data['success']="0";
            }
            else
            if(strlen($postdata[3])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=3;
                $data['success']="0";
            }
            else
            if(strlen($postdata[4])<1)
            {
                $data['error_mess']=tr("REQ_ERROR");
                $data['error']="1";
                $data['error_tab']=4;
                $data['success']="0";
            }
            else
            {
                $data['error_mess']="";
                $data['error_tab']=0;
                $up_data=array(
                        'format_name'=>nohtmldata(urldecode($postdata[1])),
                        'decimal_symbol'=>$postdata[2],
                        'thousand_seprator'=>$postdata[3],
                        'thousand_seprated_from'=>($postdata[4])
                );
                $settingObj=new Settings_model();
                $data['last_id']=$settingObj->updateformats($up_data,$postdata[0]);
                
                $data['success']="1";
                $data['success_mess']=tr("UPDATE_SUCCESS");
            }
            
            
            echo json_encode($data);
        }
        
        public function setcurrency()
        {
            ajaxlogoutmess();
            $postdata=  decode_id($this->input->post('data'));
            
            $id=$postdata;
            $settingObj=new Settings_model();
            $settingObj->setcurrenysymbol($id);
            $data['error_mess']="";
            $data['error_tab']=0;
            

            $data['success']="1";
            $data['success_mess']=tr("UPDATE_SUCCESS");
            echo json_encode($data);
        }
        
        public function site_logo() 
	{
            logoutredirect();
            $data['error']="";
            $data['sucessmessage']="";
            $commonObj=new Common_model(); // common model object created 
            
            
            $data['langsel']=$commonObj->get_langs();
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 5,
                                'right' => 4,
                                );
            
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $this->render($data);
	}
        
        public function update_site_logo() // edit services data function called 
	{
            ajaxlogoutmess();
            $data['error']="";
            $data['up_file']="";
            $commonObj=new Common_model(); // common model object created 
            $settingObj=new Settings_model();
       
            $this->load->library('photoslibrary');
            $curr_upload_path=IMG_ROOT_PATH .'img';
            if (!is_dir($curr_upload_path))
            {
                    umask(0);
                    mkdir($curr_upload_path, 0777);
                    chmod($curr_upload_path, 0777); //incase mkdir fails
            }
            $curr_upload_path=$curr_upload_path.'/';
            $this->load->helper("Image");
            $fileImage="";
            if(!empty($_FILES['fileImage']) && strlen($_FILES['fileImage']['name'])>=1)
            {

                // Create a User's directory  (if not already created)
                    $filename = $_FILES['fileImage']['name'];
                    $filetempname = $_FILES['fileImage']['tmp_name'];
                    $filesize = floatval((filesize($filetempname)/1024)/1024); // bytes to MB  

                    list($width, $height, $type, $attr) = getimagesize($filetempname);
                    $req_size=explode(",",SITE_LOGO_IMG_SIZE);
                    $req_size=explode("x",$req_size[0]);
                    if($width<$req_size[0] || $height<$req_size[1])
                    {
                        $data['error']="Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
                    }
                    else
                    {
                        $data['error']="";
                        $fileImage=imageresize($filename,$filetempname,SITE_LOGO_IMG_SIZE,$curr_upload_path,'hdnImage',false,false);
                    }
            }
            
            if(strlen($data['error'])==0)
            {
                $up_data = array(
                            'value' => $fileImage
                            );
                $data['error']=0;
                $data['success_mess']=tr("FILE_UPLOAD_SUCCESS");
                
                $data['up_file']=$fileImage;
                $settingObj->editsitelogo($up_data,"SITE_LOGO");
            }
            echo json_encode($data);
        }
}

