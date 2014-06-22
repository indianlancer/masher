<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends RT_Controller {

	public function __construct()
	{
	     parent::__construct();
             logoutredirect();
	}
        
	public function index() // default function called for the home controller
	{
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs();
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 5,
                                'right' => 4
                                );
            $data['dashboard'] = array(
                                'title' => "DASHBOARD",
                                'li' =>   array(
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'language/add',
                                            'text' => 'ADD_LANGUAGE',
                                            'dash_img' => 'add_language'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'language/managelangs',
                                            'text' => 'MANAGE_LANGUAGE',
                                            'dash_img' => 'languages'
                                            ),
                                            array(
                                            'href' => ADMIN_HTTP_PATH.'language/manage_files',
                                            'text' => 'MANAGE_LANGUAGE_FILES',
                                            'dash_img' => 'file_manager'
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
        
        function managelangs($startpoint=0,$orderby='id',$sort_order=false,$per_page = PER_PAGE)
        {
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $data['error']="";
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 7,
                                'right' => 2,
                                );
            $langObj=new Language_model();
            $total_rows=$langObj->get_langs('nopaging');
            $limit=$per_page;
            $to_page=($startpoint+$per_page);
            if($to_page>$total_rows)
                $to_page=$total_rows;
            $curr_data=($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'language/managelangs/'); 
            $data['curr_data']=$curr_data;
            $data['total_rows']=$total_rows;
            $data['startpoint']=$startpoint;
            $data['langs_data']=$langObj->get_langs('paging',$startpoint,$limit,$orderby,$sort_order); // function to get all the header menus available
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
        
        
        public function add() // default function called for the home controller
	{
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $langObj=new Language_model(); // default controller model object created 
             $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 7,
                                'right' => 2,
                                );
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_rules('txtLanguage', 'LANGUAGE_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtForDomains', 'DOMAIN_ERROR', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtLanguage'))
                {
                    $data['error']= form_error('txtLanguage');
                }
                else
                if(form_error('txtForDomains'))
                {
                    $data['error']= form_error('txtForDomains');
                }
            }
            else
            {
                    $this->load->library('photoslibrary');
                    $curr_upload_path=ICONS_ROOT_PATH .'flags';
                   
                    if (!is_dir($curr_upload_path))
                    {
                            umask(0);
                            mkdir($curr_upload_path, 0777);
                            chmod($curr_upload_path, 0777); //incase mkdir fails
                    }
                    $curr_upload_path=$curr_upload_path.'/';
                    $fileImage="";
                    if(!empty($_FILES['fileImage']) && strlen($_FILES['fileImage']['name'])>=1)
                    {
                            // Create a User's directory  (if not already created)
                            $filename = $_FILES['fileImage']['name'];
                            $filetempname = $_FILES['fileImage']['tmp_name'];
                            $filesize = floatval((filesize($filetempname)/1024)/1024); // bytes to MB  

                            list($width, $height, $type, $attr) = getimagesize($filetempname);
                            $req_size=explode(",",FLAG_IMG_SIZE);
                            $req_size=explode("x",$req_size[0]);
                            if($width<$req_size[0] || $height<$req_size[1])
                            {
                                $data['error']="Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
                            }
                            else
                            {
                                $data['error']="";
                                // Image resize function (filename,filetempname,imagesizeconstant,uploadpath,hiddenimage)
                                $this->load->helper("Image");
                                $fileImage=imageresize($filename,$filetempname,FLAG_IMG_SIZE,$curr_upload_path,false,false,false,'',array('gif'));
                                if($fileImage)
                                {
                                    $language=nohtmldata($this->input->post('txtLanguage'));    
                                    $domains=$this->input->post('txtForDomains');
                                    $nameparts = explode('.', $fileImage);
                                    $file_ext = $nameparts[count($nameparts) - 1];
                                    $relfile=$nameparts[0];
                                    
                                    if(file_exists($curr_upload_path.$language.".".$file_ext))
                                    {
                                        $data['error']=tr("ALREADY_EXIST_ERROR");
                                    
                                    }
                                    else
                                    {
                                        @rename($curr_upload_path.$fileImage, $curr_upload_path.$language.".".$file_ext);

                                        $domains=explode("\n",trim($domains,'\n'));
                                        $domains=nohtmldata(implode("|",$domains));
                                        $up_data = array(
                                                    'lang' => ($language),
                                                    'for_domain_ext' => ($domains)
                                                    );
                                        $orig_id = encode_id($langObj->add_language($up_data));
                                        $this->coresession->set_flashdata('UPDATE_SUCCESS', 'INSERT_SUCCESS');
                                        redirect('/admin/language/managelangs/');
                                        rt_redirect('/admin/language/edit/'.$orig_id,'/admin/language/add/','admin/language/managelangs/');
                                    }
                                }
                                else
                                {
                                    $data['error']=tr("NOT_VALID_IMAGE");
                                }
                            }
                    }
                    else
                    {
                        $data['error']=tr("IMAGE_REQ_ERROR");
                    }
            }
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'LANGUAGES';
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $this->render($data);
	}
        
        
        
        public function edit($id) // default function called for the home controller
	{
             if(!$id)
            {
                 redirect('/admin/language/managelangs');
            }
            
            $orig_id=  $id;
            $id=  decode_id($id);
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 7,
                                'right' => 2,
                                );
            $langObj=new Language_model(); // common model object created 
            $data['langs_data']=$langObj->get_lang_byid($id); 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_rules('txtLanguage', 'LANGUAGE_ERROR', 'trim|required');
            $this->form_validation->set_rules('txtForDomains', 'DOMAIN_ERROR', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtLanguage'))
                {
                    $data['error']= form_error('txtLanguage');
                }
                else
                if(form_error('txtForDomains'))
                {
                    $data['error']= form_error('txtForDomains');
                }
            }
            else
            {
                    $this->load->library('photoslibrary');
                    $curr_upload_path=ICONS_ROOT_PATH .'flags';
                   
                    if (!is_dir($curr_upload_path))
                    {
                            umask(0);
                            mkdir($curr_upload_path, 0777);
                            chmod($curr_upload_path, 0777); //incase mkdir fails
                    }
                    $curr_upload_path=$curr_upload_path.'/';
                    $fileImage="";
                    if(!empty($_FILES['fileImage']) && strlen($_FILES['fileImage']['name'])>=1)
                    {
                            // Create a User's directory  (if not already created)
                            $filename = $_FILES['fileImage']['name'];
                            $filetempname = $_FILES['fileImage']['tmp_name'];
                            $filesize = floatval((filesize($filetempname)/1024)/1024); // bytes to MB  

                            list($width, $height, $type, $attr) = getimagesize($filetempname);
                            $req_size=explode(",",FLAG_IMG_SIZE);
                            $req_size=explode("x",$req_size[0]);
                            if($width<$req_size[0] || $height<$req_size[1])
                            {
                                $data['error']="Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
                            }
                            else
                            {
                                $data['error']="";
                                // Image resize function (filename,filetempname,imagesizeconstant,uploadpath,hiddenimage)
                                $this->load->helper("Image");
                                $fileImage=imageresize($filename,$filetempname,FLAG_IMG_SIZE,$curr_upload_path,"hdnImage",false,false,'',array('gif'));
                                if($fileImage)
                                {
                                    $language=$data['langs_data']->lang;    
                                    $domains=$this->input->post('txtForDomains');
                                    $nameparts = explode('.', $fileImage);
                                    $file_ext = $nameparts[count($nameparts) - 1];
                                    $relfile=$nameparts[0];
                                    if(file_exists($curr_upload_path.$language.".".$file_ext))
                                    {
                                        @unlink($curr_upload_path.$language.".".$file_ext);
                                    }
                                    rename($curr_upload_path.$fileImage, $curr_upload_path.$language.".".$file_ext);
                                }
                                else
                                {
                                    $data['error']=tr("NOT_VALID_IMAGE");
                                }
                            }
                    }
                    if(strlen($data['error'])==0)
                    {
                        
                        $domains=$this->input->post('txtForDomains');
                        $domains = trim($domains);
                        $domains=explode("\n",trim($domains,'\n'));
                        $domains=nohtmldata(implode("|",$domains));
                        $up_data = array(
                                    'for_domain_ext' => ($domains)
                                    );
                        $langObj->edit_language($up_data,$id);
                        $this->coresession->set_flashdata('UPDATE_SUCCESS', 'UPDATE_SUCCESS');
                        rt_redirect('/admin/language/edit/'.$orig_id,'/admin/language/add/','admin/language/managelangs/');
                    }
                    
            }
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH,
                                    'Language'=> ADMIN_HTTP_PATH.'language',
                                    'Edit language'=> '',
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'LANGUAGES';
            $this->render($data);
	}
        
        public function manage_files() // default function called for the home controller
	{
            $this->layout ="admin";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $data['user_session']=$this->coresession->userdata('USER_SESSION');
            $data['spans_arr']= array(
                                'left' => 2,
                                'center' => 10,
                                );
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home'
                                    ) ;
            $data['left_menus'] = default_admin_left_menu();
            $data['left_active'] = 'DASHBOARD';
            $this->render($data);
	}
        
        
        function load_lang_files()
        {
            $commonObj=new Common_model(); // common model object created 
            $folder=$this->input->post("folder");
            $data['dir_arr']=array();
            $data['files_arr']['file']=array();
            $data['files_arr']['enc_file']=array();
            $data['back']="0";
            if(strlen($folder)==0)
            {
                
            }
            else
            {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=1;
                }
                $lang_code = $commonObj->get_lang_code_byid($lang_id);
                $lang_code = $lang_code->lang;
                $lang_folder = ASSETS_ROOT_PATH.'language/'.$lang_code;
                if($folder!="0")
                {
                    $lang_folder .= "/".$folder;
                }
                if(is_dir($lang_folder))
                {
                        $dirs = scandir($lang_folder);
                        foreach($dirs as $dir)
                        {
                            if ($dir === '.' || $dir === '..' ){continue;}
                            if(is_dir($lang_folder.'/'.$dir))
                            {
                                array_push($data['dir_arr'],$dir);
                            }
                            else
                            {
                                if($dir=='index.html' || $dir=='index.xml' || $dir=='index.php'){continue;}
                                $file_rel=explode("_",$dir);
                                array_pop($file_rel);
                                $file_rel=implode("_",$file_rel);
                                array_push($data['files_arr']['file'],$dir);
                                if($folder!="0")
                                {
                                    $data['back']=1;
                                    array_push($data['files_arr']['enc_file'],encode_id($folder.'/'.$file_rel));
                                }
                                else
                                {
                                    array_push($data['files_arr']['enc_file'],encode_id($file_rel));
                                }
                            }
                        }
                }
            }
            $data['error_mess']="";
            $data['error']="0";
            $data['success']="1";
            $data['datap']="1";
            echo json_encode($data);
        }
        
        
        public function manage_macros($fileopen="",$othercall=false) // manage macros function
	{
            //ajaxlogoutmess();
            $this->layout = "iframe";
            $fileopen=  decode_id($fileopen);
            $data['sel_lang_def']="";
            $data['error']="";
            $data['sucessmessage']="";
            $data['sel_lang_def_id']="";
            $commonObj=new Common_model(); // common model object created 
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $data['user_session']=$this->coresession->userdata('USER_SESSION');
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=1;
            }
            $lang_code=$commonObj->get_lang_code_byid($lang_id);
            $lang_code= $lang_code->lang;
            $lang_file = ASSETS_ROOT_PATH.'language/'.$lang_code."/".$fileopen."_lang.xml";
            $lang_file_php = ADMIN_LANG_ROOT_PATH.$lang_code."/".$fileopen."_lang.php";
            if(file_exists($lang_file_php))
            {
                if($this->input->post('save'))
                {
                    $total_include=$this->input->post("total_num_include");
                    //$total_comments=$this->input->post("total_num_comments");
                    $total_langs=$this->input->post("total_num_langs");
                    $file_content_save="<?php   if (!defined(\"BASEPATH\")) exit(\"No direct script access allowed\"); \n";
                    for($k=0;$k<$total_include;$k++)
                    {
                        $file_content_save .= "include \"".filter_lang_file_include($this->input->post("include_files_".$k))."\"; \n\n\n";
                    }
                    
                    for($k=0;$k<$total_langs;$k++)
                    {
                        $lang_insert_key=filter_lang_file_content($this->input->post("langs_key_".$k));
                        if(!empty($lang_insert_key) && strlen($lang_insert_key)>0)
                        {
                            $file_content_save .= "\$lang[\"".$lang_insert_key."\"]=";
                            $file_content_save .= "\"".filter_lang_file_value($this->input->post("langs_value_".$k))."\"; \n";
                        }
                    }
                    
                    $file_content_save .= "\n \n \n ?>";
                    $this->savethisfile($lang_file_php,$file_content_save);
                    //$xml_data = create_copy_xml($lang_file_php,$fileopen."_lang");
                    //$this->savethisfile($lang_file,$xml_data);
                    $data['sucessmessage']=tr("FILE_UPDATE_SUCCESS");
                }
                $fileopen=end(explode("/",$fileopen));
                $xml_data = create_copy_xml($lang_file_php,$fileopen."_lang");
                $this->savethisfile($lang_file,$xml_data);
                $data['handle'] = get_xml_nodes($lang_file);
            }
            else
            {
                $data['error']=tr("FILE_ERROR");
            }
            if($othercall)
            $data['othercall']=$othercall;
            $this->render($data);
	}
        
        public function savethisfile($lang_file,$data)
        {
            writethisfile($lang_file,$data);
        }
}

