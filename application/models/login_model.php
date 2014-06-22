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
                $this->db->select('*');
                $this->db->from('user');
                $this->db->where('email_id',$username);
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
        }
        
        function register_user($userdata)
        {
            $this->db->insert('user',$userdata);
            $user_id = $this->db->insert_id();
            
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id',$user_id);
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }
        
        
        function enable_account($user_id)
        {
            $up_data=array(
                    'is_enabled'=>1
            );
            $this->db->where("id",$user_id);
            $this->db->update("user",$up_data);
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
        
        function get_user_data($username)
        {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('email_id',$username);
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
        function check_useraccount_data($username)
        {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('is_enabled',1);
            $where = "(`email_id`='".$username."' or `username` = '".$username."')";
            
            $this->db->where($where);
            $query = $this->db->get();
            
            
            if($query->num_rows() > 0)
            {
                
                return $query->row();
            }
            else
            {
                return false;
            }
        }
        function check_username_data($username)
        {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('username',$username);
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
        
        function update_password($user_id,$password)
        {
            $password = md5(MD5_PREFIX_PASS.$password);
            $data = array('login_pass'=>$password);
            $this->db->where("id",$user_id);
            $this->db->update('user', $data);
            return $this->db->affected_rows();
        }
        
        
        function setverifysession($up_data,$resend=false)
        {
            $this->db->select('*');
            $this->db->from('session');
            $this->db->where('userid',$up_data['userid']);
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                //if($resend)
                //    $up_data['resend']=1;
                $this->db->where("userid",$up_data['userid']);
                $this->db->update("session",$up_data);
            }
            else
            {
                $this->db->insert("session",$up_data);
            }
        }
        
        function verify_session($user_id)
        {
            $this->db->select('*');
            $this->db->from('session');
            $this->db->where('userid',$user_id);
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                $result=$query->row();
                return $result;
            }
            else
            {
                return false;
            }
        }
        
        function link_session_destroy($user_id,$session_id)
        {
            $up_data=array(
                        'session_id'=>0
            );
            $this->db->where("userid",$user_id);
            $this->db->where("session_id",$session_id);
            
            $this->db->update("session",$up_data);
        }

        function update_user_session($user_id)
        {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id',$user_id);
            $query = $this->db->get();
            $result = $query->row();
            $this->coresession->set_userdata('USER_SESSION',$result);
        }
        
        function setStatus($status = 1)
        {
            $data = $this->coresession->userdata('USER_SESSION');
            $up_data=array(
                    'status' => $status
            );
            $this->db->where("id",$data->id);
            $this->db->update("user",$up_data);
            $this->update_user_session($data->id);
        }
}

