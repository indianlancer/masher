<?php
class Error_model extends CI_Model
{
    function get_content($deflang=1)
    {
        $lang_id=$this->coresession->userdata('cchl_id');
        if(strlen($lang_id)<1)
        {
            $lang_id=$deflang;
        }
        $this->db->select('*');
        $this->db->from('home');
        $this->db->where('fk_language_id',$lang_id);
        $query = $this->db->get();
        return $query->row();
    }
        
}

