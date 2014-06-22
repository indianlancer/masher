<?php

class EmailTemplate_model extends CI_Model {
	
	function get_templates($paging='nopaging',$startpoint=false,$limit=false,$orderby='email_label',$ordertype='asc',$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('*');
                $this->db->from('emailtemplate');
                $this->db->where('fk_language_id',$lang_id);
		
                if($paging=='paging')
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
}

