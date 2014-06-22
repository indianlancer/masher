<?php

class Users_model extends CI_Model {
	
	function get_users_list($search_key,$paging='nopaging',$startpoint=false,$limit=false,$orderby='first_name',$ordertype='desc')
        {
            $this->db->select('*');
            $this->db->from('user');
            if(strlen($search_key)>0)
            {
                $this->db->like('LOWER(login_user)',$search_key);
                $this->db->or_like('LOWER(email_id)',$search_key);
                $this->db->or_like('LOWER(first_name)',$search_key);
                $this->db->or_like('LOWER(last_name)',$search_key);
                $this->db->or_like('LOWER(concat(first_name," ", last_name))',$search_key);
            }
            if($paging!='nopaging')
            $this->db->limit($limit,$startpoint);
            if($orderby)
            $this->db->order_by($orderby,'desc');    
            $query = $this->db->get();
            if($paging=='nopaging')
            return $query->num_rows();
            else
            {
                $this->db->last_query();
                return $query->result();
            }
        }
        function get_user_byid($id)
        {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id',$id);
            $query = $this->db->get();
            $this->db->last_query();
            return $query->row();
        }

        function insert_userdata($up_data)
        {
            $this->db->insert('user', $up_data);
            return $this->db->insert_id();
        }
        
        function update_userdata($id,$up_data)
        {
            $this->db->where("id",$id);
            $this->db->update('user', $up_data);
        }
        
	
}

