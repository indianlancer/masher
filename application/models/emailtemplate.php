<?php
Class Emailtemplate extends CI_Model
{
	public $mailSubject;
	public $mailBody;
												 
	function getAnEmailtemplate($search)
	{
            $template_path = ROOT_PATH.'/'.APPPATH.'email_templates/';
            $search = strtolower($search);
            ob_start();
            include_once ($template_path.strtolower($search).".php");
            return ob_get_clean();
        }
}