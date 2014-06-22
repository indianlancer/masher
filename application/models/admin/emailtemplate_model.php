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
        
        function get_template_byid($id,$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('*');
                $this->db->from('emailtemplate');
                $this->db->where('fk_language_id',$lang_id);
                $this->db->where('id',$id);
                $query = $this->db->get();
	        if($query->num_rows()==0)
                    return false;
                $this->db->last_query();
                return $query->row();
                
        }
        
        
        function add_template($up_data,$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $up_data['fk_language_id'] = $lang_id;
                $this->db->insert('emailtemplate', $up_data);
                return $this->db->insert_id();
	}
        
        
        function update_template($up_data,$id,$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->where("id",$id);
                $this->db->update('emailtemplate', $up_data);
	}
        
        function import_template($deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                if($lang_id==1)
                    return false;
                // delete all the old templates for the selected language
                $this->db->where('fk_language_id', $lang_id);
                $this->db->delete('emailtemplate'); 
                
                // import all the templates from the english language
                
                $this->db->select('email_label,mail_subject,body');
                $this->db->from('emailtemplate');
                $this->db->where('fk_language_id', 1);
                $query = $this->db->get();

                if($query->num_rows()) 
                {
                    $new_template = $query->result_array();

                    foreach ($new_template as $author) 
                    {
                        $this->db->insert("emailtemplate", $author);
                    }           
                }
                
                $up_data= array(
                                'fk_language_id'=>$lang_id,
                                'is_enabled'=>1,
                                
                            );
                
                $this->db->where("fk_language_id",0);
                $this->db->update('emailtemplate', $up_data);
                return true;
        }
        
	
}

