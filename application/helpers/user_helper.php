<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
    * function  mail_left_menu
    *
    * This function is for displaying the mail list left menus.
    * 
    * @param	string	     type of mail which is currently set as active
    * @param	Digit	     Count number for unreaded messages
    
*/


if(!function_exists('get_user_pic'))
{
        function get_user_pic($user_id=false,$link=false,$size='50_50')
        {
            $CI = & get_instance();
            $set_pic=false;
            $set_alt="member";
            
            if($user_id)
            {
                $this->load->model('user/users_model');
                $userObj=new Users_model();
                $user_session->get_user_by_id($user_id);
                
            }
            else
            {
                $user_session = $CI->coresession->userdata('USER_SESSION');
            }
            $pic = $user_session->profile_pic;
                
            $user_pic= DEVUSERDATA_PATH.$user_session->id.'/profile_pic/'.$size.'_'.$pic;
            $set_alt=$user_session->first_name;
            if(file_exists($user_pic))
            {
                $set_pic=$user_pic;
            }
            else
            {
                $set_pic= IMG_PATH.'member_ph_'.$size.'.png';
            }
            $anc = '<a href="'.USERS_HTTP_PATH.'profile/'.$user_session->id.'">';
            $img= '<img src="'.$set_pic.'" class="member-box-avatar" alt="'.$set_alt.'" />';
            
            if($link)
            {
                echo $anc.$img."</a>";
            }
             else {
                 echo $img;
            }
            
       }
}

if(!function_exists('get_user_name'))
{
        function get_user_name($user_id=false,$link=false,$full=false)
        {
            $CI = & get_instance();
            
            if($user_id)
            {
                $this->load->model('user/users_model');
                $userObj=new Users_model();
                $user_session->get_user_by_id($user_id);
                
            }
            else
            {
                $user_session = $CI->coresession->userdata('USER_SESSION');
            }
                
            
            $anc = '<a href="'.USERS_HTTP_PATH.'profile/'.$user_session->id.'">';
            $name= $user_session->first_name;
            if($full)
                $name .= ' '.$user_session->last_name;
            if($link)
            {
                echo $anc.$name."</a>";
            }
             else {
                 echo $name;
            }
            
       }
}

/* End of file bootstrap_helper.php */
/* Location: /helpers/bootstrap_helper.php */
