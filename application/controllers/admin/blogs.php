<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogs extends RT_Controller {

    public $update_id;
	public function __construct()
	{
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
	    parent::__construct();
            $this->load->model('admin/blogs_model');
            $this->form_validation->set_message('required', '%s');
        }
        
	public function index($startpoint = 0,$orderby='created',$sort_order='desc',$per_page = PER_PAGE) 
	{
            logoutredirect();
            if($startpoint < 0)
                die;
            $data['error']="";
            $data['sucessmessage']="";
            
            $search_key= "";
            $search_key = trim($this->input->post("txtSearchKey"));
            $sess_search_key = $this->coresession->userdata("BLOGS_SEARCH_KEY");
            if(!isset ($_POST['hdnSerachFnd']))
            {
                $search_key = $sess_search_key;
            }
            $this->coresession->set_userdata("BLOGS_SEARCH_KEY",$search_key);
            $commonObj = new Common_model(); // common model object created 
            $blogsObj = new BLOGS_model();
            $total_rows = $blogsObj->get_blogs($search_key,'nopaging');
            $limit = $per_page;
            $to_page = ($startpoint+$per_page);
            if($to_page > $total_rows)
                $to_page = $total_rows;
            $curr_data = ($startpoint+1)."-".$to_page;
            //pagination library loaded from common function helper 
            defpagination($total_rows,$per_page,10,4,ADMIN_HTTP_PATH.'blogs/index/'); 
            $data['curr_data'] = $curr_data;
            $data['total_rows'] = $total_rows;
            $data['startpoint'] = $startpoint;
            $data['search_key'] = $search_key;
            $data['blogs'] = $blogsObj->get_blogs($search_key,'paging',$startpoint,$limit,$orderby,$sort_order);
            if($startpoint >= PER_PAGE && empty($data['pages']))
            {
                $rd_stp = $startpoint - PER_PAGE;
                redirect ("admin/blogs/index/".$rd_stp);
                exit();
            }
            $data['sucessmessage'] = $this->coresession->flashdata('UPDATE_SUCCESS');
            $data['admin_session'] = $this->coresession->userdata('USER_SESSION');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "pages_list"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Blogs' => ADMIN_HTTP_PATH.'blogs'
                                    ) ;
            $data['left_active'] = '8';
            $this->render($data);

	}
        
        
        
        function view($id=false)
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
            $blogsObj=new Blogs_model();
            $data['page_data']=$blogsObj->get_page_byid($id); // function to value by the id
            if(empty($data['page_data']))
                die;
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $data['setting_data']=$this->coresession->userdata('SETTINGS_DATA');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "pages_view"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    'Blogs' => ADMIN_HTTP_PATH.'blogs'
                                    ) ;
            $data['left_active'] = '8';
            $this->load->view('admin/main_center',$data);
        }
        
        
        
        public function add() // metasection function 
	{
            logoutredirect();
            $data['error']="";
            $commonObj=new Common_model(); // common model object created 
            $blogsObj=new Blogs_model();
            $this->form_validation->set_rules('txtMTitle', 'Meta Title Required', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtMDesc', 'Meta Description Required', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('txtTags', 'Tags Required', 'trim|required|max_length[200]');
            
            $this->form_validation->set_rules('txtPageContent', 'Page Contact Required', 'trim|required|max_length[5000]');

            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtMTitle'))
                {
                    $data['error']= form_error('txtMTitle');
                }
                else
                if(form_error('txtMDesc'))
                {
                    $data['error']= form_error('txtMDesc');
                }
                else
                if(form_error('txtTags'))
                {
                    $data['error']= form_error('txtTags');
                }
                else
                if(form_error('txtPageContent'))
                {
                    $data['error']= form_error('txtPageContent');
                }
            }
            else
            {
                $dir_name = session_id();
                $path = UPLOAD_ROOT_PATH .'posts_upload/';
                $this->upload->config = array(
                                            'file' => $_FILES['fileImage'],
                                            'upload_path' => $path.$dir_name,
                                            'validate' => true,
                                            'required' => true,
                                            'create_thumb' => true,
                                            'thumb_sizes' => POSTS_IMAGES,
                                            'thumb_mark' => true,
                                            'newthumb_path' => false,
                                            'maintain_ratio' => true,
                                            'maintain_height' => false
                                        );
                
                // upload the image using the upload library
                $result=$this->upload->process();
                if (!$result)
                {
                    // display error
                    $data['error'] = $this->upload->error;
                    $this->coresession->set_flashdata("ERROR_UPLOAD",$data['error']);
                }
                else 
                {
                    $image = $this->upload->result;
                    $title=$this->input->post('txtMTitle');
                    $desc=$this->input->post('txtMDesc');
                    $tags = $this->input->post('txtTags');
                    $content=$this->input->post('txtPageContent');
                    
                    $up_data = array(
                                'title' => nohtmldata($title),
                                'short_desc' => nohtmldata($desc),
                                'image' => $image,
                                'content' => ($content),
                                'tags' => $tags,
                                'created' => time()
                                );
                    $orig_id =  $blogsObj->add_post($up_data);
                    rename($path.$dir_name, $path.$orig_id);
                    $orig_id =  encode_id($orig_id);
                    
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'Post added successfully');
                    rt_redirect('/admin/blogs/edit/'.$orig_id,'/admin/blogs/add/','/admin/blogs/');
                }
            }
            
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    ' Blogs' => ADMIN_HTTP_PATH.'blogs',
                                    'Post Blog' => ADMIN_HTTP_PATH.'blogs/add'
                                    ) ;
            $data['left_active'] = '8';
            
            $this->render($data);
       }
        
        
        public function edit($id=false) // metasection function 
	{
            logoutredirect();
            $data['error']="";
             if(empty($id))
                redirect('/admin/pages/');
            $orig_id=$id;
            $this->update_id = $id =  decode_id($id);
            $commonObj=new Common_model(); // common model object created 
            $blogsObj=new Blogs_model();
            $data['langsel']=$commonObj->get_langs(); // function to get all the languages available 
            $this->form_validation->set_rules('txtMTitle', 'Blog Title Required', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtMDesc', 'Blog Description Required', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('txtTags', 'Tags Required', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtPageContent', 'Blog Contact Required', 'trim|required|max_length[5000]');
            if ($this->form_validation->run() == FALSE)
            {
                if(form_error('txtMTitle'))
                {
                    $data['error']= form_error('txtMTitle');
                }
                else
                if(form_error('txtMDesc'))
                {
                    $data['error']= form_error('txtMDesc');
                }
                else
                if(form_error('txtTags'))
                {
                    $data['error']= form_error('txtTags');
                }
                else
                if(form_error('txtPageContent'))
                {
                    $data['error']= form_error('txtPageContent');
                }
            }
            else
            {
                
                $path = UPLOAD_ROOT_PATH .'posts_upload/';
                $this->upload->config = array(
                                            'file' => $_FILES['fileImage'],
                                            'upload_path' => $path.$this->update_id,
                                            'validate' => true,
                                            'required' => false,
                                            'create_thumb' => true,
                                            'thumb_sizes' => POSTS_IMAGES,
                                            'thumb_mark' => true,
                                            'newthumb_path' => false,
                                            'maintain_ratio' => true,
                                            'maintain_height' => false
                                        );

                // upload the image using the upload library
                $result = $this->upload->process();
                if (!$result)
                {
                    // display error
                   echo  $data['error'] = $this->upload->error;
                    $this->coresession->set_flashdata("ERROR_UPLOAD",$data['error']);
                }
                else 
                {
                    $image = $this->upload->result;
                    $title = $this->input->post('txtMTitle');
                    $desc = $this->input->post('txtMDesc');
                    $tags = $this->input->post('txtTags');
                    $content = $this->input->post('txtPageContent');
                    $up_data = array(
                                'title' => nohtmldata($title),
                                'short_desc' => nohtmldata($desc),
                                'content' => ($content),
                                'tags' => $tags,
                                'modified' => time()
                                );
                    if(strlen($image) > 0)
                        $up_data['image'] = $image;

                    $blogsObj->update_post($up_data,$id);
                    $this->coresession->set_flashdata('UPDATE_SUCCESS', 'Post updated successfully');
                    rt_redirect('/admin/blogs/edit/'.$orig_id,'/admin/blogs/add/','/admin/blogs/');
                }
            }
            
            $data['page_data']=$blogsObj->get_post_byid($id); // function to value by the id
            if(empty($data['page_data']))
                 redirect('/admin/pages/');
            $data['admin_session']=$this->coresession->userdata('USER_SESSION');
            $data['sucessmessage']=$this->coresession->flashdata('UPDATE_SUCCESS');
            $data['spans_arr']= array(
                                'left' => 3,
                                'center' => 9
                                );
            $data['content'] = "pages_edit"; // element load
            $data['left_menus'] = default_admin_left_menu();
            $data['title_for_layout'] = "Admin panel";
            $data['bread_crumb'] = array(
                                    'Dashboard'=> ADMIN_HTTP_PATH.'home',
                                    ' Blogs' => ADMIN_HTTP_PATH.'blogs',
                                    'Update Post' => ADMIN_HTTP_PATH.'blogs/edit'
                                    ) ;
            $data['left_active'] = '8';
            $this->render($data);
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */