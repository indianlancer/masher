<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Connect extends RT_Controller {
        // this class is to just manage long polling
	public function __construct()
	{
            $this->load_session = FALSE;
            $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
	     parent::__construct();
	}
	public function index()
	{
            $from_user = isset($_POST['from_user']) ? $_POST['from_user'] : '';
            $filename  = ROOT_PATH.'application/user_files/data_'.$from_user.'.txt';

            // infinite loop until the data file is not modified
            $lastmodif    = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;
            $currentmodif = filemtime($filename);
            if(!file_exists($filename))
            {
                $fp = fopen($filename, 'w');
                fclose($fp);
            }

            while ($currentmodif <= $lastmodif) // check if the data file has been modified
            {
                usleep(10000); // sleep 10ms to unload the CPU
                clearstatcache();
                $currentmodif = filemtime($filename);
            }

            // return a json array
            $response = array();
            $response['msg']       = file_get_contents($filename);
            $response['timestamp'] = $currentmodif;
            echo json_encode($response);
            flush();
        }
        
        
        function send()
        {
            $from_user = isset($_POST['from_user']) ? $_POST['from_user'] : '';
            // store new message in the file
            $msg = isset($_POST['msg']) ? $_POST['msg'] : '';
            if ($msg != '')
            {
                $to_user = isset($_POST['to_user']) ? $_POST['to_user'] : '';
                $filename  = ROOT_PATH.'application/user_files/data_'.$to_user.'.txt';
                file_put_contents($filename,$msg);
                $filename  = ROOT_PATH.'application/user_files/data_'.$from_user.'.txt';
                file_put_contents($filename,$msg);
                $response = array();
                $response['timestamp'] = 0;
                echo json_encode($response);
                die();
            }
        }
    
    }
  ?>