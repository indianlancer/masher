<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Html 
{
    
    
    public function __construct() 
    {
       
        
    }
    
    /**
     *	meta()
     *
     *	Checks no session is start then it simply calls
     *	the session_start() function.  You can force a new
     *	session_start by putting true - not sure if you'd
     *	ever need that functionality, but it's there anyway
     *
     *	@author Simon Emms <simon@simonemms.com>
     */
    public function meta($content=null,$paths=array()) 
    {
        if(!(empty($content)))
        foreach($content as $data)
        {
            if(isset($paths['fullPath']) && $paths['fullPath']==true)
                $add_path=HTTP_PATH;
            else
                $add_path="";
            switch($data)
            {
                case 'icon':
                            return '<link rel="shortcut ref icon" href="'.$add_path.'assets/img/ico/favicon.ico"/>'."\n";
            }
        }
    }
    
    public function css($css=false,$alts=false,$paths=false) 
    {
        $css_files="";
        if(is_array($css))
        {
            if(!(empty($css)))
            foreach($css as $data)
            {
                $css_files .= $this->css($data,$alts,$paths);
            }
        }
        else 
        {
            if($paths['fullPath']==true)
                $add_path=HTTP_PATH;
            else
                $add_path="";
             return '<link rel="stylesheet" type="text/css" href="'.$add_path.'assets/css/'.$css.'.css"/>'."\n";
        }
        return $css_files;
    }
    
    public function script($script=false,$paths=false) 
    {
        $js_files="";
        if(is_array($script))
        {
            if(!(empty($script)))
            foreach($script as $data)
            {
                $js_files .= $this->script($data,$paths);
            }
        }
        else
        {
            if($paths['fullBase']==true)
                $add_path=HTTP_PATH;
            else
                $add_path="";
            
            if(preg_match("|".WEBSITE_URL_PATTERN."|i", $script) === 0)
            {
                return  '<script type="text/javascript" src="'.$add_path.'assets/js/'.$script.'.js"></script>'."\n";
            }
            else
            {
                return '<script type="text/javascript" src="'.$script.'"></script>'."\n";
            }
        }
        return $js_files;
    }
    
    public function image($image = false,$paths = false, $attrs = false) 
    {
        $img_files="";
        if(is_array($image))
        {
            if(!(empty($image)))
            foreach($image as $data)
            {
                $img_files .= $this->image($data,$paths, $attrs);
            }
        }
        else
        {
            $img_tag = "";
            if($paths['fullBase'] == true)
                $add_path = HTTP_PATH;
            else
                $add_path = "";
            if(preg_match("|".WEBSITE_URL_PATTERN."|i", $image) === 0)
            {
                $img_tag .= '<img src="'.$add_path.'assets/img/'.$image.'" ';
            }
            else
            {
                $img_tag .= '<img src="'.$image.'" ';
            }

            return $img_tag .= ' '.$this->_set_attrs($attrs).'/>'."\n"; 

            
        }
        return $image_files;
    }
    
    public function file($image = false,$paths = false,$attrs = false) 
    {
        $img_files="";
        if(is_array($image))
        {
            if(!(empty($image)))
            foreach($image as $data)
            {
                $img_files .= $this->image($data,$alts = false,$paths=false);
            }
        }
        else
        {
            if($paths['fullBase']==true)
                $add_path = UPLOAD_PATH;
            else
                $add_path="";
            if(preg_match("|".WEBSITE_URL_PATTERN."|i", $image) === 0)
            {
                if(!file_exists(UPLOAD_ROOT_PATH.$image))
                    return false;
                return  '<img src="'.$add_path.$image.'" />'."\n";
            }
            else
            {
                return '<img src="'.$image.'" />'."\n";
            }
        }
        return $image_files;
    }
    
    
    public function link($text = false,$link = false,$paths = false,$attr = false) 
    {
        $link_s = "";
        if($paths['fullBase']==true)
            $add_path=HTTP_PATH;
        else
            $add_path="";

        if(isset($paths['class']))
            $class = "class = '".$paths['class']."'";
        else
            $class = "";

        
            
        if(preg_match("|".WEBSITE_URL_PATTERN."|i", $link) === 0)
        {
            $add_path .= $link; 
            
        }
        else
        {
            $add_path = $link; 
            
        }
        $link_s =  '<a '.$this->_set_attrs($attr).' href="'.$add_path.'" '.$class.' >'.$text.'</a>'."\n";
        return $link_s;
    }


    private function _set_attrs($attrs)
    {
        $attrs_str = "";
        if(is_array($attrs))
        {
            if(!empty($attrs))
            foreach ($attrs as $key => $data) {
                $attrs_str .= " ".$key." = '".$data."' ";
            }
        }
        else
        {
            $attrs_str = $attrs;
        }
        return $attrs_str;
    }
    
    
}