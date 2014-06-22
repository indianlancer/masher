<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request 
{
    
    public $data = array();
    
    public function __construct() 
    {
        $this->CI =& get_instance();
        
    }
    
    function is($type='get')
    {
        switch($type)
        {
            case 'get':
                        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
                        {
                            return true;
                        }
                        break;
            case 'post':
                        if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
                        {
                            return true;
                        }
                        break;
            case 'ajax':
                        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                        {
                            return true;
                        }
                        break;
           default :
                        return false;
                        break;
                        
        }
    }
}