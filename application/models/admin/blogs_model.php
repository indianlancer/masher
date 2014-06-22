<?php

class Blogs_model extends RT_Model {
	
	function get_blogs($search_key,$paging='nopaging',$startpoint=false,$limit=false,$orderby='created',$ordertype='desc')
        {
                $this->db->select('*');
                $this->db->from('blog');
                if(strlen($search_key)>0)
                {
                    $this->db->like('LOWER(title)',$search_key);
                    $this->db->or_like('LOWER(short_desc)',$search_key);
                    $this->db->or_like('LOWER(content)',$search_key);
                }
                if($paging == 'paging')
                    $this->db->limit($limit,$startpoint);
                if($orderby)
                    $this->db->order_by($orderby,$ordertype);    
                $query = $this->db->get();
                if($paging == 'nopaging')
                    return $query->num_rows();
                else
                {
                   $this->db->last_query();
                    return $query->result();
                }
            
        }
        
        function get_post_byid($id)
        {
                $this->db->select('*');
                $this->db->from('blog');
                $this->db->where('id',$id);
                $query = $this->db->get();
	        if($query->num_rows()==0)
                    return false;
                $this->db->last_query();
                return $query->row();
                
        }
        
        
        function add_post($up_data)
        {
                $this->db->insert('blog', $up_data);
                return $this->db->insert_id();
	}
        
        
       function update_post($up_data,$id)
       {
            $post_data = $this->get_post_byid($id);
            if(strlen($up_data['image'])> 0 )
            {
                $curr_upload_path = UPLOAD_ROOT_PATH.'posts_upload/'.$id.'/';
                @unlink($curr_upload_path.$post_data->image);
                $sizes = explode("," ,POSTS_IMAGES);
                foreach($sizes as $size)
                {
                    $size = explode("x", $size);
                    @unlink($curr_upload_path.$size[0]."_".$size[1]."_".$post_data->image);
                }
            }

            $this->db->where("id",$id);
            $this->db->update('blog', $up_data);
	   }

        function check_slug($slug,$update=0)
        {
            $this->db->select('id');
            $this->db->from('dynamic_pages');
            $this->db->where('slug',$slug);
            if($update)
                $this->db->where('id !=',$update);
            $query = $this->db->get();
            $this->db->last_query();
            return $query->num_rows();
        }
	
}

