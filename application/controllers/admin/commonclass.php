<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commonclass extends RT_Controller {

	public function __construct()
	{
            $this->load_model=false;
            parent::__construct();
	}
        
	public function endisable() // default function called for the home controller
	{
            ajaxlogoutmess();
            $commonObj=new Common_model(); // common model object created 
            $tab_d=decode_id($this->input->post('tab_d'));
            $id= decode_id($this->input->post('id'));
            $set_en=$this->input->post('set_en');
            $up_data['is_enabled']=$set_en;
            $data['langsel']=$commonObj->endisable($up_data,$tab_d,$id); // function to enable disable data form the list
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data=array();
            $data['success']="1";
            $data['success_mess']=($set_en==1) ? tr("ENABLE_SUCCESS") : tr("DISABLE_SUCCESS");
            $data['error']="0";
            echo json_encode($data);
	}
	public function set_row_data() // default function called for the home controller
	{
            ajaxlogoutmess();
            $commonObj=new Common_model(); // common model object created 
            $tab_d=decode_id($this->input->post('tab_d'));
            $col_d=decode_id($this->input->post('col_d'));
            $id= decode_id($this->input->post('id'));
            $set_en=$this->input->post('set_en');
            $up_data[$col_d]=$set_en;
            $data['langsel']=$commonObj->endisable($up_data,$tab_d,$id); // function to enable disable data form the list
            $data=array();
            $data['success']="1";
            $data['success_mess']=tr("UPDATE_SUCCESS");
            $data['error']="0";
            echo json_encode($data);
	}
        
        public function deleterows() // default function called for the home controller
	{
            ajaxlogoutmess();
            $commonObj=new Common_model(); // common model object created 
            $tab_d=decode_id($this->input->post('tab_d'));
            $checkval= explode(",",$this->input->post('checkval'));
            
            $commonObj->deleterows($tab_d,$checkval); // function to delete rows form the table
            $data['admin_session']=$this->coresession->userdata('ADMIN_SESSION');
            $data=array();
            $data['success']="1";
            $data['success_mess']=tr("DELETE_SUCCESS");
            $data['error']="0";
            echo json_encode($data);
	}
        
        
        function listusers($limit=10)
        {
		$keyWord=urldecode($_GET['q']);
		$commonObj=new Common_model(); // common model object created 
                $data=$commonObj->search_user_auto($keyWord,$limit);
                foreach($data as $searchdata)
                {
                    $id=encode_id($searchdata->id);
                    $name=$searchdata->first_name." ".$searchdata->last_name;
                    $fk_language_id=$searchdata->fk_language_id;
                    $email_id=$searchdata->email_id;
                    $vattax_valid=$searchdata->vattax_valid;

                    //echo "<strong>$name</strong>|$imgurl|$id|$is_frnd \n";
                    echo "$name|$id|$fk_language_id|$email_id|$vattax_valid \n";
                }
		
		
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */