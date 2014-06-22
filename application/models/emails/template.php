<?php
Class Template extends CI_Model
{
	public $mailSubject;
	public $mailBody;
												 
	function getAnEmailtemplate($search)
	{	
	        $this->db->select("*");
                $this->db->from("emailtemplate");
                $this->db->where("email_label",$search);
                $this->db->where("is_enabled","1");
		$query=$this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row;
		}
                else 
                {
			return false;
		}
	}
}