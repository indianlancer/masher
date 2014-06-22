<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('translate'))
{
	function translate($lang_key)
	{
                $CI =& get_instance();
		return $CI->lang->line($lang_key);
	}
}       

if ( ! function_exists('tr'))
{
        function tr($lang_key)
	{
               $CI =& get_instance();
		if($CI->config->item('translator') == 'on'){
                        return $CI->language->get($lang_key);
		} else {
                	return $lang_key;
		}
	}
}
        
      
if ( ! function_exists('defpagination'))
{        
        function defpagination($total_rows,$per_page,$num_links=10,$uri_segment=4,$base_link=HTTP_PATH)
        {
            $CI =& get_instance();
            $CI->load->library('pagination');
            $config['base_url'] = $base_link;
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $per_page;
            $config['num_links'] = $num_links;
            $config['first_link'] = tr('FIRST');
            $config['last_link'] = tr('LAST');
            $config['cur_tag_open'] = '<li  class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '<li>';
            $config['uri_segment']=$uri_segment;
            $CI->pagination->initialize($config);
        }
}


if ( ! function_exists('encode_id'))
{        
        function encode_id($id)   // function for encoding the data ids
        {
            $CI =& get_instance();
            $CI->load->library('encrypt');
            $data= $CI->encrypt->encode($id, ENCRYPT_KEY);
            $data=str_replace('/','@',$data);
            return $data;
        }
}

if ( ! function_exists('decode_id'))
{        
        function decode_id($id) // function for decoding the data ids
        {
            $CI =& get_instance();
            $CI->load->library('encrypt');
            $data=str_replace('@','/',$id);
            $data=str_replace(' ','+',$data);
            return $CI->encrypt->decode($data, ENCRYPT_KEY);
        }
}
if ( ! function_exists('rt_encode'))
{        
        function rt_encode($id)   // function for encoding the data ids
        {
            $data=encode_id($id);
            $data=substr($data,0,strlen($data)-2);
            return $data;
        }
}

if ( ! function_exists('rt_decode'))
{        
        function rt_decode($id) // function for decoding the data ids
        {
            $data= $id."==";
            $data = decode_id($data);
            return $data;
        }
}

if ( ! function_exists('move_file'))
{
        function move_file($from, $to)
        {
            if (!@move_uploaded_file($from, $to))
            {
                return false;
            }
            return true;
        }
}

if ( ! function_exists('get_lang_code_byid'))
{
        function get_lang_code_byid($id)
	{
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created 
            $retdata=$commonObj->get_lang_code_byid($id);
            return $retdata;
	}
}

if ( ! function_exists('writethisfile'))
{
        function writethisfile($file,$data)
        {
            $fp = fopen($file, "w") or die('error permission denied');
            $data=($data);
            fwrite($fp, $data);
            fclose($fp);
        }
}
if ( ! function_exists('create_copy_xml'))
{
        function create_copy_xml($from_file,$file_name)
        {
            $lang=file_get_contents($from_file);
            $xml_data = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml_data .= "<".$file_name."> \n";
            $xml_data .= "<include_file> \n";
            $rx_head = '(include "(.+)";)Ui';
            preg_match_all($rx_head, $lang, $out);
            foreach($out[1] as $inc_files)
            {
                $xml_data .= "<file>".$inc_files."</file> \n";
            }
            $xml_data .= "</include_file> \n";
            
            $rx_head2 = '(\$lang\["([^"]+)"\]="([^"]+)";)Ui';
            preg_match_all($rx_head2, $lang, $out1);
            unset($out1[0]);
            $out1=array_values($out1);
            
            for($j=0;$j<sizeof($out1[0]);$j++)
            {
                $xml_data .= "<langs> \n";
                $xml_data .= "<key>".$out1[0][$j]."</key>\n";
                $xml_data .= "<value><![CDATA[".$out1[1][$j]."]]></value>\n";
                $xml_data .= "</langs> \n";
            }
            $xml_data .= "</".$file_name."> \n";
            return $xml_data;
        }
}

if ( ! function_exists('ajaxlogoutmess'))
{
        function ajaxlogoutmess()
        {
            $CI =& get_instance();
            $is_logged_in=$CI->login_model->is_loggedin();
            if(!$is_logged_in)
            {
                $data['error']="logged_out";
                echo json_encode($data);
                die;
            }
        }
}

if ( ! function_exists('logoutredirect'))
{
        function logoutredirect()
        {
            $CI =& get_instance();
            $is_logged_in=$CI->login_model->is_loggedin();
            if(!$is_logged_in)
            {
                // Redirect to home page
		$refrer_link= current_url();
		$CI->coresession->set_userdata('adm_refrer_link', $refrer_link);
                redirect("/admin/login/");
            }
        }
}



if ( ! function_exists('array_to_object'))
{
        function array_to_object($array) 
        {
            $obj = new stdClass;
            foreach($array as $k => $v) 
            {
                if(is_array($v)) 
                {
                    $obj->{$k} = array_to_object($v); //RECURSION
                } else 
                {
                    $obj->{$k} = $v;
                }
            }
            return $obj;
        }
}

if(!function_exists('generate_username'))
{
        function generate_username($firstname,$lastname)
        {
            $firstname=substr(nohtmldata(strtolower(str_replace(" ","",trim($firstname)))),0,10);
            $lastname=substr(nohtmldata(strtolower(str_replace(" ","",trim($lastname)))),0,10);
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created
            
            $username=$firstname.".".$lastname;
            $username=$username.".".mt_rand(11111, 99999999);
            $check = $commonObj->check_client_username_exist($username);
            if($check==false)
            {
                generate_username($firstname,$lastname);
            }
            else
            {
                return $username;
            }
        }
}


if(!function_exists('generate_userslot'))
{
        function generate_userslot()
        {
            $commonObj=new Common_model(); // common model object created
            
            $userslot=mt_rand(11111111, 9999999999);
            $check = $commonObj->check_client_userslot_exist($userslot);
            if($check==false)
            {
                generate_userslot();
            }
            else
            {
                return $userslot;
            }
        }
}
if(!function_exists('generate_password'))
{
    function generate_password($l=10, $c=3, $n=2, $s=3)   // functions parameters $length=9, $capitals=0, $numbers=0, $specials_chars=0   
    {
         $out="";
         // get count of all required minimum special chars
         $count = $c + $n + $s;

         // all inputs clean, proceed to build password

         // change these strings if you want to include or exclude possible password characters
         $chars = "abcdefghijklmnopqrstuvwxyz";
         $caps = strtoupper($chars);
         $nums = "0123456789";
         $syms = "!@#$%^&*()-+?";

         // build the base password of all lower-case letters
         for($i = 0; $i < $l; $i++) {
              $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
         }

         // create arrays if special character(s) required
         if($count) {
              // split base password to array; create special chars array
              $tmp1 = str_split($out);
              $tmp2 = array();

              // add required special character(s) to second array
              for($i = 0; $i < $c; $i++) {
                   array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
              }
              for($i = 0; $i < $n; $i++) {
                   array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
              }
              for($i = 0; $i < $s; $i++) {
                   array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
              }

              // hack off a chunk of the base password array that's as big as the special chars array
              $tmp1 = array_slice($tmp1, 0, $l - $count);
              // merge special character(s) array with base password array
              $tmp1 = array_merge($tmp1, $tmp2);
              // mix the characters up
              shuffle($tmp1);
              // convert to string for output
              $out = implode('', $tmp1);
         }

         return $out;
    }
}

if(!function_exists('convert_timestamp_date'))
{
        function convert_timestamp_date($timestamp)
        {
            date_default_timezone_set('Asia/Calcutta');
            if(strlen($timestamp)>0)
            {
                $date=date("F j, Y, g:i a", $timestamp);
                return $date;
            }
        }
}
if(!function_exists('convert_timestamp_url_date'))
{
        function convert_timestamp_url_date($timestamp)
        {
            date_default_timezone_set('Asia/Calcutta');
            if(strlen($timestamp)>0)
            {
                $date=date("Y/m/d", $timestamp);
                return $date;
            }
        }
}
if(!function_exists('open_permission'))
{
        function open_permission($path,$perm)
        {
            if(!@chmod($path,$perm))
            return false;
        }
}
if(!function_exists('close_permission'))
{
        function close_permission($path)
        {
            if(!@chmod($path,0755))
            return false;
        }
}


if(!function_exists('rt_redirect'))
{
        function rt_redirect($save_path,$save_new,$save_close)
        {
            $CI =& get_instance();
            $tooltask=$CI->input->post('tooltask');
            if($tooltask=="save")
            redirect($save_path);
            if($tooltask=="savenew")
            redirect($save_new);
            if($tooltask=="saveclose")
            redirect($save_close);
        }
}




/* End of file common_function_helper.php */
/* Location: /helpers/common_function_helper.php */
