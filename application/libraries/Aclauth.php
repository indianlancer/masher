<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aclauth 
{
    
    var $back_arr = array();
    public $route;
    private $_user;
    public function __construct() 
    {
        $this->CI =& get_instance();
        $this->_user = $this->CI->coresession->userdata("USER_SESSION");
    }
    
    function acosAuthCreate()
    {
        $dir_path = APPPATH."controllers";
        $arr_bind= array('base'=>array(),'files'=>array(),'contr'=>array());
        $ret_data = $this->read_dir_php($dir_path,$arr_bind);
        $this->__create_acos_aros_back_arr();
        
        $this->CI->db->truncate('acos');
        $in_data = array(
                        'alias'=>'controllers',
                        'lft' => 1
                    );

        $this->CI->db->insert("acos",$in_data);
        $this_id="";
        $this_inner_id="";

        for($i=0;$i<sizeof($ret_data['base']);$i++)
        {
            $this->CI->db->select('max(rght) as mx_rght,max(lft) as mx_lft');
            $this->CI->db->from('acos');
            if(strlen($this_id)>0)
                $this->CI->db->where('id',$this_id);
            else
                $this->CI->db->where('parent_id IS NULL',NULL);
            $query = $this->CI->db->get();
            $mx_lft = $query->row()->mx_lft;
            $mx_rght = $query->row()->mx_rght;
            $mx_set="";
            if($mx_rght== null || strlen($mx_rght) == 0)
            {
                $mx_set = ++$mx_lft;
            }
            else
            {
                $mx_set = ++$mx_rght;
            }
            
            if(strlen($ret_data['base'][$i])>0)
            {
                $contro_set_nm = $ret_data['base'][$i]."/".$ret_data['contr'][$i];
            }
            else
            {
                $contro_set_nm = $ret_data['contr'][$i];
            }
            $in_al_data = array(
                    'parent_id'=>1,
                    'alias'=>$contro_set_nm,
                    'lft' => $mx_set
                );
            $this->CI->db->insert("acos",$in_al_data);
            $this_inner_id = $this_id = $this->CI->db->insert_id();
            $max_sz = sizeof($ret_data['files'][$i]);
            foreach($ret_data['files'][$i] as $key=>$files_names)
            {
                $this->CI->db->select('max(rght) as mx_rght,max(lft) as mx_lft');
                $this->CI->db->from('acos');

                $this->CI->db->where('id',$this_id);
                $query = $this->CI->db->get();
                $mx_lft = $query->row()->mx_lft;
                $mx_rght = $query->row()->mx_rght;
                $mx_set="";
                if($mx_rght==null || strlen($mx_rght)==0)
                    $mx_set = ++$mx_lft;
                else
                    $mx_set = ++$mx_rght;
                
                $in_al_data = array(
                        'parent_id'=>$this_inner_id,
                        'alias'=> $files_names,
                        'lft' => $mx_set,
                        'rght' => ($mx_set+1)
                    );
                $this->CI->db->insert("acos",$in_al_data);
                $this_id = $this->CI->db->insert_id();


                if(($max_sz-1) == $key)
                {
                    $set_data = array(
                                'rght' =>$mx_set+2
                                );
                    $this->CI->db->where('id', $this_inner_id);
                    $this->CI->db->update('acos', $set_data);
                    $this_id = $this_inner_id;
                }
            }
            $set_data = array(
                        'rght' =>$mx_set+2
                        );
            $this->CI->db->where('parent_id IS NULL',NULL);
            $this->CI->db->update('acos', $set_data);
        }
        $all_aros = $this->__get_aros();
        $this->CI->db->truncate('aros_acos');
        $this->__acos_aros_back_data();
    }
    
    function test()
    {
        $this->__create_acos_aros_back_arr();
        $this->__acos_aros_back_data();
    }
    
    function read_dir_php($dir_path,$arr_bind,$base=false)
    {
        $projectsListIgnore=array('.' ,'..');
        $dir = opendir ($dir_path);
        while (false !== ($file = readdir($dir))) {
            if (strpos($file, '.php',1)) {
                $retFnArr = $this->read_files_php($dir_path."/".$file,$file);
                if(strlen($base)>0)
                {
                    $arr_bind['base'][]=$base;
                    $arr_bind['files'][]=$retFnArr;
                }
                else
                {
                    $arr_bind['base'][]=null;
                    $arr_bind['files'][]=$retFnArr;
                }
                $contro_file = explode(".", $file);
                $arr_bind['contr'][] = $contro_file[0];

            }
            elseif(is_dir($dir_path."/".$file) && !in_array($file,$projectsListIgnore))
            {
                $arr_bind = $this->read_dir_php($dir_path."/".$file,$arr_bind,$file);
            }
        }
        closedir($dir);
        return $arr_bind;
    }

    function read_files_php($dir_file,$file)
    {
        $functionFinder = '/[\s\n]+(\S+)[\s\n]* function[\s\n]+(\S+)[\s\n]*\(/';
        # Init an Array to hold the Function Names
        $functionArray = array();
        $retFnArr = array();
        # Load the Content of the PHP File
        $file = explode(".", $file);
        $file = $file[0];
        $fileContents = file_get_contents($dir_file);

        # Apply the Regular Expression to the PHP File Contents
        preg_match_all( $functionFinder , $fileContents , $functionArray );
        # If we have a Result, Tidy It Up

        if( count( $functionArray )>1 )
        {
          # Grab Element 1, as it has the Matches
            unset($functionArray[0]);
          //$functionArray = $functionArray[1];
        }

        $functionArray= array_values($functionArray);
        for($i=0;$i<sizeof($functionArray[1]);$i++)
        {
            if(($functionArray[0][$i]=="public" || $functionArray[0][$i]=="}") && ($functionArray[1][$i]!= "__construct" && $functionArray[1][$i]!= ucfirst($file)))
            {
                array_push($retFnArr,$functionArray[1][$i]);
            }
        }
        return $retFnArr;

    }
    
    
    
    private function __acos_aros_back_data()
    {
        $all_aros = $this->__get_aros();
        $all_acos = $this->__get_acos();
        
        foreach($this->back_arr as $aros)
        {
            $key=false;
            foreach($all_acos as $find_acos)
            {
                $parent = ($find_acos->parent_id == NULL) ? NULL : $this->__get_aco_parent($find_acos->parent_id);
                if($find_acos->alias == $aros['aco'] &&  $parent == $aros['aco_parent'])
                {
                   $key =  $find_acos->id;
                }
            }
            
            if($key)
            {
                $in_data = array(
                    'aro_id' => $aros['aro_aco']->aro_id,
                    'aco_id' => $key,
                    '_create' => $aros['aro_aco']->_create,
                    '_read' => $aros['aro_aco']->_read,
                    '_update' => $aros['aro_aco']->_update,
                    '_delete' => $aros['aro_aco']->_delete
                );
                
                //print_r($in_data);
                $this->CI->db->insert("aros_acos",$in_data);
            }
        }
        
    }
    
    private function __create_acos_aros_back_arr()
    {   
        $this->CI->db->select("*");
        $this->CI->db->from("aros_acos");
        $query = $this->CI->db->get();
        $acos_aros = $query->result();
        foreach($acos_aros as $key=>$aco_aro)
        {
            $this->CI->db->select("*");
            $this->CI->db->from("acos");
            $this->CI->db->where("id",$aco_aro->aco_id);
            $query = $this->CI->db->get();
            $aco = $query->row();
            $this->back_arr[$key]['aro_aco'] = $aco_aro;
            $this->back_arr[$key]['aco'] = $aco->alias;
            $this->back_arr[$key]['aco_parent'] = ($aco->parent_id == NULL) ? NULL : $this->__get_aco_parent($aco->parent_id);
        }
    }
    
    
    private function __get_aco_parent($parent_id)
    {
        $this->CI->db->select("alias");
        $this->CI->db->from("acos");
        $this->CI->db->where("id",$parent_id);
        $query = $this->CI->db->get();
        return $query->row()->alias;
    }
    private function __get_aco_all_child_where($id,$alias)
    {
        $this->CI->db->select("*");
        $this->CI->db->from("acos");
        $this->CI->db->where("parent_id",$id);
        $this->CI->db->where("alias",$alias);
        $query = $this->CI->db->get();
        //echo $this->CI->db->last_query();
        return $query->row();
    }
    private function __get_aros()
    {
        $this->CI->db->select("*");
        $this->CI->db->from("aros");
        $query = $this->CI->db->get();
        return $query->result();
    }
    
    private function __get_acos()
    {
        $this->CI->db->select("*");
        $this->CI->db->from("acos");
        $query = $this->CI->db->get();
        return $query->result();
    }
    
    function get_aro_aco_icon($aro_id,$aco_id)
    {
        if($aro_id==1)
            return "icon-ok|1";
        $this->CI->db->select("*");
        $this->CI->db->from("aros_acos");
        $this->CI->db->where("aro_id",$aro_id);
        $this->CI->db->where("aco_id",$aco_id);
        $query = $this->CI->db->get();
        $acos_aros = $query->row();
        if($query->num_rows==0)
        {
            return "icon-remove|0";
        }
        elseif($acos_aros->_create==1)
        {
            return "icon-ok|1";
        }
        else
        {
            return "icon-remove|0";
        }
    }
    
    
    function acosAuthcheck($route)
    {
        if(!empty($this->_user) && $this->_user->u_aro_id == 1)
            return true;
        $this->route = $route;
        //echo "<pre>";
        $action = $this->CI->router->fetch_method();
        $class= $this->CI->router->fetch_class();
        $main_action = uri_string();
        $main_action = explode("/", $main_action);
        
        $index2 = true;
        if(!isset($main_action[1]))
        {
            $main_action[1]  = "index";
            $index2 = false;
        }
        if(strlen($action)==0)
            $second_find = $main_action[1];
        else
            $second_find = $action;    
        
        $action_key = array_search($action,$main_action);
        $class_key = array_search($class,$main_action);
        $def_path = array_slice($main_action, 0,$action_key); 
        $class_path = array_slice($main_action, 0,$class_key); 
        $def_path = implode("/", $def_path);
        $class_path = implode("/", $class_path);
        if($class !="error404")
        {
            if(strlen($main_action[0]) == 0)
            {
                //echo "1";
                $first_find = $this->route['default_controller'];
            }
            elseif(strlen($main_action[0]) > 0 && $class_key === false && $index2 == false)
            {
                //echo "2";
                if(isset($this->route[uri_string()]))
                {
                    
                    $first_find2 = explode("/",$this->route[uri_string()]);
                    $first_find = $first_find2[0];
                    $second_find = $first_find2[1];
                }
                else
                    $first_find = $def_path.'/'.$this->route['default_controller'];
            }
            elseif(strlen($main_action[0]) > 0 && $class_key === false)
            {
                //echo "3";
                $first_find = $def_path.'/'.$class;
            }
            elseif(strlen($main_action[0]) > 0 && $class_key)
            {
                //echo "4";
                $first_find = $class_path.'/'.$class;
                //$second_find = "index";
            }
            else 
            {
                //echo "5";
                $first_find = $main_action[0];
                $second_find = $action; // changes on 20 may due to error on commonclass from $second_find = $action;
            }
        }
        else 
        {
            $first_find = "error404";
            $second_find = "index";
        }
        $this->CI->db->select("*");
        $this->CI->db->from("acos");
        $this->CI->db->where("alias",trim($first_find,'/'));
        $query = $this->CI->db->get();
        //echo $this->CI->db->last_query();die;
        $aco = $query->row();
        //print_r($aco);die;
        if($query->num_rows==0)
            return false;
        else
        {
            $childs = $this->__get_aco_all_child_where($aco->id,trim($second_find,"/"));
            if(sizeof($childs) == 0)
            {
                return false;
            }
            else
            {
                //print_r($childs);
                if(!empty($this->_user))
                {
                    $aro_id_ch = $this->_user->u_aro_id;
                }
                else 
                {
                    $aro_id_ch = 3;   //this  id is for checking anonymous users allowed or not
                }

                $query = $this->check_aro_aco($aco->id,$aro_id_ch);
                $acl =$query->row();
                if($query->num_rows==0 || $acl->_read==0)
                {
                    $query2 = $this->check_aro_aco($childs->id,$aro_id_ch);
                    $acl2 = $query2->row();
                    if($query2->num_rows==0 || $acl2->_read==0)
                        return false;
                    else
                        return true;
                }
                else
                {
                    $query2 = $this->check_aro_aco($childs->id,$aro_id_ch);
                    $acl2 = $query2->row();
                    if($query2->num_rows==0 || $acl2->_read==0)
                        return false;
                    else
                        return true;
                }

            }
            
            die;
            return true;
        }
        
    }
    
    function check_aro_aco($aco,$aro)
    {
        $this->CI->db->select("*");
        $this->CI->db->from("aros_acos");
        $this->CI->db->where("aco_id",$aco);
        $this->CI->db->where("aro_id",$aro);
        $query = $this->CI->db->get();
        //echo $this->CI->db->last_query();die;
        return $query;
    }
}