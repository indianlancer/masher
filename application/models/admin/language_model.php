<?php

class Language_model extends CI_Model {
	
       function get_langs($paging='nopaging',$startpoint=false,$limit=false,$orderby='id',$ordertype='asc',$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->select('*');
            $this->db->from('language');
            if($paging!='nopaging')
            $this->db->limit($limit,$startpoint);
            if($orderby)
            $this->db->order_by($orderby,$ordertype);    
            $query = $this->db->get();
            if($paging=='nopaging')
            return $query->num_rows();
            else
            {
                $this->db->last_query();
                return $query->result();
            }
        }
        
        function add_language($up_data,$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->insert('language', $up_data);
            return $this->db->insert_id();
        }
        
        function edit_language($up_data,$id,$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->where('id', $id);
            $this->db->update('language', $up_data);
        }
        
        function get_lang_byid($id,$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->select('*');
            $this->db->from('language');
            $this->db->where('id', $id);
            $query = $this->db->get();
            return $query->row();
        }
}

