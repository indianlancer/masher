<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * 
 * @author   Rishi Raj Tripathi
 */

// ------------------------------------------------------------------------

class Upload {

    var $filename = '';
    
    public $result = '';
    
    var $error = '';
    
    var $CI;
    
    var $newname;
    
    public $finalname;
    
    
    public $done_files = array();
    public $ret_files = array();
    
    public $config = array(
                        'file' => false,
                        'upload_path' => false,
                        'validate' =>true,
                        'required' => true,
                        'create_thumb' => false,
                        'thumb_sizes' => '100x100',
                        'thumb_mark' => false,
                        'allow_ratio_diff' => false,
                        'newthumb_path' => false,
                        'maintain_ratio' => false,
                        'maintain_height' => false
                    );
    
    /**
     * Constructor - Sets Preferences
     *
     * The constructor can be passed an array of config values
     */    
    function Upload()
    {    
        $this->CI = & get_instance();
        $this->CI->load->helper("Image");
    }

    // --------------------------------------------------------------------

    /**
     * Initialize preferences
     *
     * @access    public
     * @param    array
     * @return    void
     */    
    
    
    function process()
    {
        if(!isset($this->config['allow_ratio_diff']))
        {
            $this->config['allow_ratio_diff'] = false;
        }
        if (!is_dir($this->config['upload_path']))
        {
                umask(0);
                mkdir($this->config['upload_path'], 0777,true);
                chmod($this->config['upload_path'], 0777); //incase mkdir fails
        }
        $this->config['upload_path'] .= '/';
        
        if($this->config['required'] == false && strlen(trim($this->config['file']['name'])) == 0)
        {
            return true;
        }
        if($this->config['validate'])
        {
            if(!$this->validate())
                return false;
        }
        
        $this->create_name();
        $this->finalname = $this->config['upload_path']. $this->newname;
        // Move uploaded file into User's directory & rename
        
        if (move_file($this->config['file']['tmp_name'], $this->finalname))
        {
            if(!$this->config['create_thumb'])
            {
                $this->result = $this->newname;
                return true;
            }
            // Populate arrays
            if($this->config['newthumb_path'])
                $this->config['newthumb_path'] = $this->config['upload_path'].$this->config['newthumb_path'].$this->newname;
            $pro_size = explode(",",$this->config['thumb_sizes']);
            
            foreach($pro_size as $sizes)
            {
                $newsize = explode("x",$sizes);
                $is_create_false=$this->create_thumb($newsize[0],$newsize[1]); 
                if(!$is_create_false)
                {
                    $this->roll_back();
                    return false;
                }
                $this->ret_files[] = $newsize[0]."_".$newsize[1]."_".$this->newname;
            }
            $this->result = $this->newname;
            return true;
        }
        else
        {
            $this->error =  "upload error cannot move file while uploading";
            return false;
        }
    }
    
    
    function validate()
    {
        $req_size = explode(",",$this->config['thumb_sizes']);
        $req_size = explode("x",$req_size[0]);
        if(!empty($this->config['file']) && strlen($this->config['file']['name'])>=1)
        {
            // Create a User's directory  (if not already created)
            $filename = $this->config['file']['name'];
            $filetempname = $this->config['file']['tmp_name'];
            $filesize = floatval((filesize($filetempname)/1024)/1024); // bytes to MB  
            list($width, $height, $type, $attr) = @getimagesize($filetempname);
            
            if($this->config['allow_ratio_diff'])
            {
                if($width < $req_size[0] && $height < $req_size[1])
                {
                    $this->error =  "Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
                    return false;
                }
                $check_width = round($width / $req_size[0]);
                $check_height = round($height / $req_size[1]);
                $rt_w = 400 * $this->config['allow_ratio_diff'];
                $rt_h = 300 * $this->config['allow_ratio_diff'];
                
                if($check_width >= $check_height)
                {
                    if($check_width - $check_height > $this->config['allow_ratio_diff'])
                    {
                        $this->error =  "Ratio of image should not be greater than ".$rt_w."x".$rt_h." pixels";
                        return false;
                    }
                }
                else 
                {
                    if($check_height - $check_width > $this->config['allow_ratio_diff'])
                    {
                        $this->error =  "Ratio of image should not be greater than ".$rt_w."x".$rt_h." pixels";
                        return false;
                    }
                }
            }
            else
            if($width < $req_size[0] || $height < $req_size[1])
            {
                $this->error =  "Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
                return false;
            }
            return true;
        }
        else
        {
            $this->error =  "Image required minimum ".$req_size[0]."x".$req_size[1]." pixels";
            return false;
        }
    }
    
    
    function create_name()
    {
        // clean the file
        $nameparts = explode('.', $this->config['file']['name']);
        $file_ext = $nameparts[count($nameparts) - 1];
        $newname = str_replace('.' . $file_ext, '', $this->config['file']['name']);
        $timestamp=time();
        $this->newname = rand(0,999999).$timestamp . '.' . $file_ext;
    }
    
    
    // This function creates the thumbnail 
    function create_thumb($width,$height)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->finalname;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = $this->config['maintain_ratio'];
        
        if($this->config['newthumb_path'] == true)
            $config['new_image'] = $this->config['newthumb_path'];
        
        if($this->config['thumb_mark'])
            $config['thumb_marker'] = $width."_".$height."_";
        else
            $config['thumb_marker'] = "";    
        
        $config['width'] = $width;
        
        //if($this->config['maintain_height'])
        {
            $config['height'] = $height;
        }
        
        $this->CI->load->library('image_lib', $config);
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        if(!$this->CI->image_lib->resize())
        {
            $this->error = $this->CI->image_lib->display_errors();
            return false;
        }
        
        $this->done_files[] = $this->finalname;
        return true;
        // function create_thumb() ends here
    }
    
    function roll_back()
    {
        foreach($this->done_files as $files)
            @unlink($files);
        
        @rmdir($this->config['upload_path']);
    }
    
}


// END Upload Class
