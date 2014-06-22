<?php
class Multilang
{
   public  $language    	 	= array();
   public $header = "";
   public $footer = "";
   private $langTo    	 	= "";
   private $langFile    	 	= "";
   private $_pathtoLanguage 	= '';    
   private $_postfix    	 	= "_lang";
 
 
   public function __construct($header='header',$footer='footer') {
  	 $this->langTo    		= $this->_getCI()->config->item('default_language');
  	 $this->_pathtoLanguage = APPPATH . 'language/';
         $this->header=$header;
         $this->footer=$footer;
   }
 
   /**
    * Get CodeIgniter Object
    */
   private function & _getCI() {
  	 return get_instance();
   }
 
   /**
    * Function get translated text
    * @param String $idiom
    */
   public function get($idiom = false) {
	    if($this->_getCI()->config->item('translator') == 'on')
            {
		if(!empty($this->language) && isset($this->language[strtoupper($idiom)])) {
                    return $this->language[strtoupper($idiom)];
                } 
                else 
                {
                    return $idiom;
                }
            }
            else
            {
                return $idiom;
            }
   }
 
   
   public function load($langfile = '', $idiom = 'en',$folder='') {
	   if($this->_getCI()->config->item('translator') == 'on'){
			 $langfile = $langfile.$this->_postfix;
                         $headerfile = $this->header.$this->_postfix;
                         $footerfile = $this->footer.$this->_postfix;
			 if($idiom == "") {
				 $idiom = $this->lang_to;
			 }
			 $lang = array();
			 $this->langTo = $idiom;
			 $this->langFile = $langfile;
			 // Determine where the language file is and load it
                         
			 if (file_exists($this->_pathtoLanguage.$idiom.'/'.$folder.$langfile.'.php')) {
                                include_once($this->_pathtoLanguage.$idiom.'/'.$folder.$headerfile.'.php');
                                include_once($this->_pathtoLanguage.$idiom.'/'.$folder.$footerfile.'.php');
                                include_once($this->_pathtoLanguage.$idiom.'/'.$folder.$langfile.'.php');
			 }
                         else
                         {
                             include_once($this->_pathtoLanguage.$idiom.'/'.'error404'.$this->_postfix.'.php');
                         }
			 $this->language = array_merge($this->language, $lang); 
	    }
   }
 
   /**
    * Set path to language
    * @param $path
    */
   public function setLanguagesFolder($path) {
  	 $this->_pathtoLanguage = $path;
  	 return $this;
   }
 
   /**
    * Set postfix
    * @param unknown_type $postfix
    */
   public function setPostfix($postfix = '_lang') {
  	 $this->_postfix = $postfix;
  	 return $this;
   }
   
  
   
}
?>
