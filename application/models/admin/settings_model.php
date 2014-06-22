<?php

class Settings_model extends CI_Model {
	
	function get_config_list($paging='nopaging',$startpoint=false,$limit=false,$orderby='param',$ordertype='asc',$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('*');
                $this->db->from('std_config');
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
        
        function set_setting_config($up_data)
        {
             $this->db->insert('std_config', $up_data);
             return $this->db->insert_id();
        }
        
        function update_setting_config($id,$up_data)
        {
            $this->db->where('id', $id);
            $this->db->update('std_config', $up_data);
        }
        
        function get_config_byid($id)
        {
                $this->db->select('*');
                $this->db->from('std_config');
                $this->db->where('id',$id);    
                $query = $this->db->get();
                $this->db->last_query();
                return $query->row();
                
        }
        
        function changepass($up_data)
        {
                $admin_session=$this->coresession->userdata('ADMIN_SESSION');
                $user_id=$admin_session->id;
                $this->db->where('id', $user_id);
                $this->db->update('aff_admin_user', $up_data);
        }
        
        function getallcurrenysymbol()
        {
                $this->db->select('*');
                $this->db->from('currency_symbols');
                $this->db->where('is_enabled','1');
                $query = $this->db->get();
                $currency=$query->result();
                return $currency;
        }
        
        function getcurrenysymbol($paging='nopaging',$startpoint=false,$limit=false,$orderby='id',$ordertype='asc',$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('*');
                $this->db->from('currency_symbols');
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
        function getallcurrenycode()
        {
                $this->db->select('distinct(currency) as currency_code');
                $this->db->from('currency_national');
                $this->db->order_by('currency');
                $query = $this->db->get();
                $currency=$query->result();
                return $currency;
        }
        
        function getallcurrenyformat()
        {
                $this->db->select('*');
                $this->db->from('currency_formats');
                $this->db->order_by('format_name');
                $query = $this->db->get();
                $currency=$query->result();
                return $currency;
        }
        
        
        function getcurrenyformats($paging='nopaging',$startpoint=false,$limit=false,$orderby='id',$ordertype='asc',$deflang=1)
        {
                $lang_id=$this->coresession->userdata('admin_cchl_id');
                if(strlen($lang_id)<1)
                {
                    $lang_id=$deflang;
                }
                $this->db->select('*');
                $this->db->from('currency_formats');
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
        
        function updateformats($up_data,$id)
        {
            if($id=="new")
            {
                $this->db->insert('currency_formats', $up_data);
                $last_id= encode_id($this->db->insert_id());
                
            }
            else
            {
                $this->db->where('id', $id);
                $this->db->update('currency_formats', $up_data);
                $last_id=0;
            }
            $this->db->last_query();
            return $last_id;
        }
        
        function updatecurrencies($up_data,$id)
        {
            if($id=="new")
            {
                $this->db->insert('currency_symbols', $up_data);
                $last_id= encode_id($this->db->insert_id());
                
            }
            else
            {
                $this->db->where('id', $id);
                $this->db->update('currency_symbols', $up_data);
                $last_id=0;
            }
            $this->db->last_query();
            return $last_id;
        }
        function setcurrenysymbol($id)
        {
            $up_data=array('is_set'=>'0');
            $this->db->where('is_set', 1);
            $this->db->update('currency_symbols', $up_data);
            
            $up_data=array('is_set'=>'1');
            $this->db->where('id', $id);
            $this->db->update('currency_symbols', $up_data);
        }
        function editsitelogo($up_data,$id)
        {
            $this->db->where('param', $id);
            $this->db->update('std_config', $up_data);
        }
        
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
        function get_vat_tax($paging='nopaging',$startpoint=false,$limit=false,$orderby='Country',$ordertype='asc',$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->select('*');
            $this->db->from('countries');
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
        
        function get_country_by_id($id)
	{
            $this->db->select("*");
            $this->db->from('countries');
            $this->db->where('CountryId',$id);
            $query = $this->db->get();
            return $query->row();
	}
        
        function edit_vattax($up_data,$id,$deflang=1)
        {
            $lang_id=$this->coresession->userdata('admin_cchl_id');
            if(strlen($lang_id)<1)
            {
                $lang_id=$deflang;
            }
            $this->db->where('CountryId', $id);
            $this->db->update('countries', $up_data);
        }
        
        function get_lang_byid($id)
        {
            $this->db->select('*');
            $this->db->from('language');
            $this->db->where('id',$id);    
            $query = $this->db->get();
            $this->db->last_query();
            return $query->row();
        }
	
}

