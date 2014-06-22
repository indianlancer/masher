<?php

class Login_model extends CI_Model {
	
	function check_login($username,$password)
        {
            $password=md5(MD5_PREFIX_PASS.$password);
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('username',$username);
            $this->db->where('login_pass',$password);
            $this->db->where('is_enabled',1);
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                $this->db->last_query();
                return $query->row();
            }
            else
            {
                return false;
            }
            
        }
        
        function is_loggedin()
        {
            $data=$this->coresession->userdata('USER_SESSION');
            if(empty($data))
            {
                return FALSE;
            }
            else
            {
                return TRUE; 
            }
        }
}

