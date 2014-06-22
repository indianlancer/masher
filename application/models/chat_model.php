<?php

class Chat_model extends CI_Model {
	
    function findFriendRequest()
    {
        $user_session = $this->coresession->userdata('USER_SESSION');
        $sql = "select userid, frienduserid from ".$this->db->dbprefix('user_friend')." where (frienduserid=?) and status =?";

        $query = $this->db->query($sql, array($user_session->id,0));
        
        
        $listArr = array();
        if($query->num_rows()){
            $db_result = $query->result();

            foreach ($db_result as $list)
            {
                array_push($listArr , $this->getUserDetail($list->userid));
            }
            return $listArr;
        }
        
    }
    function findFriends()
    {
        $user_session = $this->coresession->userdata('USER_SESSION');
        $sql = "select distinct userid, frienduserid from ".$this->db->dbprefix('user_friend')." where (userid=? OR frienduserid=?) and status =?";

        $query = $this->db->query($sql, array($user_session->id,$user_session->id,1));
        
        
        $list = array();
		if($query->num_rows()){
                    $db_result = $query->result();
                    $count = count($db_result);
                    $j=0;
                    for( $i=0; $i < $count; $i++ ){
                        if($db_result[$i]->userid != $user_session->id)
                        {	
                            $result = $this->getUserDetail($db_result[$i]->userid);
                            if($result){
                                    $list[$j] =  $result;
                                    $j++;
                            }
                        }
                        else
                        {	
                            $result = $this->getUserDetail($db_result[$i]->frienduserid);
                            if($result){
                                    $list[$j] =  $result;
                                    $j++;
                            }
                        }
                    }
		}
                
		return $list;
    }
    
    function getUserDetail($userId){
            $this->db->select('id ,username, first_name, last_name,status');
            $this->db->from('user');
            $this->db->where('id',$userId);

            $query = $this->db->get(); 
            if($query->num_rows()){
                    $db_result = $query->row();  
                    return $db_result;
            } else { 
                    return false;
            }
    }
    function getUserDetailByUsername($userId){
            $this->db->select('id ,username');
            $this->db->from('user');
            $this->db->where('username',$userId);

            $query = $this->db->get(); 
            if($query->num_rows()){
                    $db_result = $query->row();  
                    return $db_result;
            } else { 
                    return false;
            }
    }
    function getUserName($userId){
            $this->db->select('username');
            $this->db->from('user');
            $this->db->where('id',$userId);

            $query = $this->db->get(); 
            if($query->num_rows()){
                    $db_result = $query->row()->username;  
                    return $db_result;
            } else { 
                    return false;
            }
    }
    function checkExist($user_name){
            $this->db->select('id ,username');
            $this->db->from('user');
            $this->db->where('username',$user_name);

            $query = $this->db->get(); 
            
            return $query->row_array();  
            
    }
	
    function heartbeat()
    {
        $user_session = $this->coresession->userdata('USER_SESSION');
        $sql = "select * from ".$this->db->dbprefix('chat')." where (`to` =? AND `recd` = 0) order by id ASC";

        $query = $this->db->query($sql, array($user_session->id));
        return $query->result_array();
    }
    
    function getUserContact($query, $limit){
            $this->db->select('id,username, (concat(first_name," ", last_name)) as uname',false);
            $this->db->from('user');
            
            if(strlen($query)>0)
            {
                $this->db->like('LOWER(username)',$query);
                $this->db->or_like('LOWER(email_id)',$query);
                $this->db->or_like('LOWER(first_name)',$query);
                $this->db->or_like('LOWER(last_name)',$query);
                $this->db->or_like('LOWER(concat(first_name," ", last_name))',$query);
            }
            $this->db->limit($limit,0);
            $this->db->order_by("first_name",'desc');    
            $query = $this->db->get(); 
            
            if($query->num_rows()){
                    $db_result = $query->result();  
                    return $db_result;
            } else { 
                    return false;
            }
    }
    
    function isFriend($userid)
    {
        $userdata = $this->coresession->userdata('USER_SESSION');
        $sql = "select distinct userid, frienduserid,status from ".$this->db->dbprefix('user_friend')." where (userid=? AND frienduserid=?) or ((userid=? AND frienduserid=?)) ";

        $query = $this->db->query($sql, array($userid,$userdata->id,$userdata->id,$userid));
        
        $this->db->last_query();
        if($query->num_rows()){
                $db_result = $query->row();  
                return $db_result;
        } 
        else 
        { 
                return false;
        }
    }
    function sendRequest($userid)
    {
        $userdata = $this->coresession->userdata('USER_SESSION');
        $ss = array(
                'userid' => $userdata->id,
                'frienduserid' => $userid,
                'status' => 0
                );
        $this->db->insert("user_friend",$ss);
    }
    
    function acceptReq($user_id)
    {
        $userdata = $this->coresession->userdata('USER_SESSION');
        $ss = array(
                'status' => 1
                );
        
        $this->db->where("userid",$user_id);
        $this->db->where("frienduserid",$userdata->id);
        $this->db->update("user_friend",$ss);
    }
    
    function update_comet_files($friends_list=array(),$message = '')
    {
        if(!empty($friends_list))
        foreach($friends_list as $list)
        {
            $filename  = ROOT_PATH.'application/user_files/data_'.$list->id.'.txt';
            file_put_contents($filename,$message);
        }
    }
}

