<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package        CodeIgniter
 * @author        Dariusz Debowczyk
 * @copyright    Copyright (c) 2006, D.Debowczyk
 * @license        http://www.codeignitor.com/user_guide/license.html 
 * @link        http://www.codeigniter.com
 * @since        Version 1.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Session class using native PHP session features and hardened against session fixation.
 * 
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Sessions
 * @author        Dariusz Debowczyk
 * @link        http://www.codeigniter.com/user_guide/libraries/sessions.html
 */
class Coresession {
    
    /* How we can identify flash sessions */
    const flash = 'FLASH_';
    var $flashdata_key	= 'flash';
    
    /* Do not delete this time round */
    private static $_arrFlashDND = array();
    
    /**
     * Construct
     *
     * Calls the session start function
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function __construct() {
        /* Set the timeout time */
        $objCI = &get_instance();
        $objCI->load->config('session', false, true);

        /* Set the timeout time */
        $timeout = $objCI->config->item('session_lifetime');
        if(is_numeric($timeout)) { ini_set('session.gc_maxlifetime', $timeout); }

        $this->start();
        // Delete 'old' flashdata (from last request)
        $this->_flashdata_sweep();

        // Mark all new flashdata as old (data will be deleted before next request)
        $this->_flashdata_mark();
    }
    
    /**
     * Destruct
     *
     * Deletes any flash sessions that have not
     * been set up this time.  It's a duplication
     * of what's done during the getSession() function,
     * but this clears up sessions that have not
     * actually been called
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function  __destruct() {
        $arrSession = $this->all_userdata();
        if(count($arrSession) > 0) {
            foreach($arrSession as $key => $value) {
                /*if(!in_array($key_match_flash, $this->flashdata_key)) 
                {
                    $this->unset_userdata($key);
                }*/
            }
        }
    }

    /**
     *	Start()
     *
     *	Checks no session is start then it simply calls
     *	the session_start() function.  You can force a new
     *	session_start by putting true - not sure if you'd
     *	ever need that functionality, but it's there anyway
     *
     *	@author Simon Emms <simon@simonemms.com>
     */
    public function start($override = false) {
        if(!session_id() || $override) {
            @session_start();
        }
    }
    
    /**
     *	Is Session
     *
     *	Checks there is a session set and that it's not empty
     *
     *	@author Simon Emms <simon@simonemms.com>
     */
    public function exists($name) {
        if(isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     *	Set Session()
     *
     *	Sets a session based on the variables passed
     *	setSession(str $sessionName, mixed $sessionValue, bool $encryption);
     *
     *	@author Simon Emms <simon@simonemms.com>
     */
    public function set_userdata($name, $value = null, $flash = false) {
        if(is_array($name)) {
            if(count($name) > 0) {
                foreach($name as $n => $v) {
                    $this->set_userdata($n, $v, $flash);
                }
            }
        } else {
            $_SESSION[$name] = $value;
        }
    }

    /**
     * Get Session()
     *
     * Returns value of specified session.  Will only decrypt on specified sessions
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function userdata($name = null, $flash_only = false) {
        if($flash_only === false) {
            if(is_null($name)) {
                $_arrDetails = $this->all_userdata();
            } else {
                $_arrDetails = false;
                if(isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
                    /* Check for session name */
                    $_arrDetails = $_SESSION[$name];
                }
            }
        }
        /* If nothing found, repeat search for flash data */
        if(empty($_arrDetails) && $flash_only === true) {
            $_arrDetails = $this->userdata(self::flash.$name, true);
        }
        return $_arrDetails;
    }

    /**
     * All Userdata
     *
     * Returns all sessions
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function all_userdata() {
        $sessionId = $this->id();
        if(!empty($sessionId)) {
            return $_SESSION;
        } else {
            return array();
        }
    }
    
    /**
     * Destroy
     *
     * Destroys named session
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function unset_userdata($name = null) {
        if(is_null($name)) {
            /* Remove all */
        } elseif(is_array($name)) {
            if(count($name) > 0) {
                foreach($name as $n => $v) {
                    $this->unset_userdata($n);
                }
            }
        } else {
            unset($_SESSION[$name]);
        }
    }
    
    public function set_flashdata($item, $value) 
    {
        if(is_array($item)) 
        {
            if(count($item) > 0) 
            {
                foreach($item as $n => $v) {
                    $flashdata_key = $this->flashdata_key.':new:'.$n;
                    $this->set_userdata($flashdata_key, $v, $flash);
                }
            }
        }
        else
        {
            $flashdata_key = $this->flashdata_key.':new:'.$item;
            $this->set_userdata($flashdata_key, $value, true);
        }
        
    }
    
    public function flashdata($item) 
    {
        $flashdata_key = $this->flashdata_key.':old:'.$item;
        return $this->userdata($flashdata_key, false, false); 
    }

    // ------------------------------------------------------------------------

    /**
    * Identifies flashdata as 'old' for removal
    * when _flashdata_sweep() runs.
    *
    * @access	private
    * @return	void
    */
    function _flashdata_mark()
    {
            $userdata = $this->all_userdata();
            foreach ($userdata as $name => $value)
            {
                    $parts = explode(':new:', $name);
                    if (is_array($parts) && count($parts) === 2)
                    {
                            $new_name = $this->flashdata_key.':old:'.$parts[1];
                            $this->set_userdata($new_name, $value);
                            $this->unset_userdata($name);
                    }
            }
    }
    
    /**
     * Redo Session
     *
     * Re-sets the session.  Will work for any session, but
     * the idea is to use it for Flash sessions
     *
     * @param string $name
     */
    public function keep_flashdata($name) {
        
        // 'old' flashdata gets removed.  Here we mark all
        // flashdata as 'new' to preserve it from _flashdata_sweep()
        // Note the function will return FALSE if the $key
        // provided cannot be found
        $old_flashdata_key = $this->flashdata_key.':old:'.$key;
        $value = $this->userdata($old_flashdata_key);

        $new_flashdata_key = $this->flashdata_key.':new:'.$key;
        $this->set_userdata($new_flashdata_key, $value);
    }
    
    // ------------------------------------------------------------------------

    /**
    * Removes all flashdata marked as 'old'
    *
    * @access	private
    * @return	void
    */
    
    function _flashdata_sweep()
    {
            $userdata = $this->all_userdata();
            foreach ($userdata as $key => $value)
            {
                    if (strpos($key, ':old:'))
                    {
                            $this->unset_userdata($key);
                    }
            }

    }
    
    /**
     * ID
     *
     * Returns the session ID
     *
     * @return string
     * @author Simon Emms <simon@simonemms.com>
     */
    public function id() { return session_id(); }
    
}