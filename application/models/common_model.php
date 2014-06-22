<?php

class Common_model extends CI_Model {
	
        public function __construct()
	{
	     parent::__construct();
             $curr_ad= $this->uri->segment("1");
             if($curr_ad=="admin")
             {
                 $this->load->model("admin/login_model");
             }
             else
             {
                $this->load->model("login_model");
             }
	}
       
	function get_langs()   // function to get the languages list as option ofr users
	{ 
		$this->db->select('*');
                $query = $this->db->get('language');
		return $query->result();
	}
        
        function get_lang_code_byid($id)   // function to get the languages list as option ofr users
	{ 
		$this->db->select('*');
                $this->db->from('language');
                $this->db->where('id',$id);
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
        
        
        function endisable($up_data,$tab_d,$id) // function to enable disable the data
	{
            
            $this->db->where('id',$id);
            $this->db->update($tab_d,$up_data);
	}
        
        function deleterows($tab_d,$check) // function to delete the data
	{
            if ($this->db->field_exists('is_deleted', $tab_d))
            {
                foreach($check as $checkval)
                {
                    $up_data = array("is_deleted"=>1);
                    $checkval=  decode_id($checkval);
                    $this->db->where('id', $checkval);
                    $this->db->update($tab_d,$up_data);
                }
            }
            else
            {
                foreach($check as $checkval)
                {
                    $checkval=  decode_id($checkval);
                    $this->db->where('id', $checkval);
                    $this->db->delete($tab_d);
                }
            }
	}
        
        
        function get_email_template($email_label,$deflang=1)
        {
                $lang_id=$this->coresession->userdata('cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('mail_subject,body');
                $this->db->from('emailtemplate');
                $this->db->where('fk_language_id',$lang_id);
                $this->db->where('email_label',$email_label);
                $this->db->where('is_enabled','1');
                $query = $this->db->get();
                $this->db->last_query();
                return $query->row();
        }
        
        function get_curr_file($id,$col_name,$tab_name,$where_cont='id')
        {
            $query = $this->db->select($col_name);
            $query = $this->db->from($tab_name);
            $query = $this->db->where($where_cont,$id);
            $query = $this->db->get();
            $this->db->last_query();
	    return $query->row();
            
        }
        
        function getuser_by_id($id)
        {
            $this->db->select('*');
            $this->db->from("users");
            $this->db->where("id",$id);
            $query = $this->db->get();
            return $query->row();
        }
        
        
}