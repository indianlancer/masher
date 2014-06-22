<?php 

class Acl_manage_model extends CI_Model {

    function get_all_acos()
    {
        $this->db->select("*");
        $this->db->from("acos");
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_all_aros()
    {
        $this->db->select("*");
        $this->db->from("aros");
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_aco_by_id($id)
    {
        $this->db->select("*");
        $this->db->from("acos");
        $this->db->where("id",$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function is_already_exists($aro,$aco)
    {
        $this->db->select("*");
        $this->db->from("aros_acos");
        $this->db->where("aro_id",$aro);
        $this->db->where("aco_id",$aco);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function set_aro_aco($aro,$aco,$val)
    {
        $is_exists = $this->is_already_exists($aro,$aco);
        $aco_data = $this->get_aco_by_id($aco);
        
        if($is_exists)
        {
            if($aco_data->parent_id == 1) // parent_id = 1 means this is controller base
            {
                $update = array(
                            '_create' => $val,
                            '_read' => $val,
                            '_update' => $val,
                            '_delete' => $val
                );
                $this->db->where("aro_id",$aro);
                $this->db->where("aco_id",$aco);
                $this->db->update("aros_acos",$update);
                $acos_data = $this->get_all_acos_by_parent($aco_data->id);
                foreach($acos_data as $acos)
                {
                    $this->set_aro_aco($aro,$acos->id,$val);
                }
                
            }
            else
            {
                $update = array(
                            '_create' => $val,
                            '_read' => $val,
                            '_update' => $val,
                            '_delete' => $val
                );
                $this->db->where("aro_id",$aro);
                $this->db->where("aco_id",$aco);
                $this->db->update("aros_acos",$update);
            }
        }
        else
        {
            if($aco_data->parent_id == 1) // parent_id = 1 means this is controller base
            {
                $update = array(
                            'aro_id' => $aro,
                            'aco_id' => $aco,
                            '_create' => $val,
                            '_read' => $val,
                            '_update' => $val,
                            '_delete' => $val
                );
                $this->db->insert("aros_acos",$update);
                $acos_data = $this->get_all_acos_by_parent($aco_data->id);
                foreach($acos_data as $acos)
                {
                    $this->set_aro_aco($aro,$acos->id,$val);
                }
                
            }
            else
            {
                $update = array(
                            'aro_id' => $aro,
                            'aco_id' => $aco,
                            '_create' => $val,
                            '_read' => $val,
                            '_update' => $val,
                            '_delete' => $val
                );
                $this->db->insert("aros_acos",$update);
            }
        }
    }
    
    function get_all_acos_by_parent($parent_id)
    {
        $this->db->select("*");
        $this->db->from("acos");
        $this->db->where("parent_id",$parent_id);
        $query = $this->db->get();
        return $query->result();
    }
        
        
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */