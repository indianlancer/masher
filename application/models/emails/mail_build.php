<?php 
class Mail_build extends CI_Model{

	public $sender_email;
	public $sender_name;
        public $to_email;
        public $attached_file="";
        public $emailsubject;
        public $emailbody;


        function sendmail($data,$template=false)
	{  
		
                $this->sender_email = NOREPLY_EMAIL;
                $this->to_email = ADMIN_EMAIL;
                $this->sender_name = SITE_NAME;
		$emailsubject = 'NOT_PREPARED';
		$emailbody = 'NOT_PREPARED';
		$template->body=str_replace('[HTTP_PATH]',HTTP_PATH,$template->body);
                $template->body=str_replace('[LOGO]',IMG_PATH.'img/logo.gif',$template->body);
                
		switch (strtolower($data['type'])) 
		{
			case 'contact_us_mail':
                            	if($template){
                                        $this->sender_email=$data['up_data']['email_id'];
                                        $this->sender_name=$data['sender_name'];
					$template->mail_subject = str_replace('[SUBJECT_SELECT]',$data['up_data']['subject'],$template->mail_subject); 
					$this->emailsubject = str_replace('[USERNAME]',ucfirst($data['sender_name']),$template->mail_subject); 
					$template->body= str_replace('[DOMAIN_NAME]',$data['up_data']['domain_name'],$template->body);
					$template->body= str_replace('[USERNAME]',$data['up_data']['full_name'],$template->body);
					$template->body= str_replace('[CONTACT_DATE]',convert_timestamp_date($data['up_data']['contact_date']),$template->body);
					$template->body= str_replace('[EMAIL_ID]',$data['up_data']['email_id'],$template->body);
					$template->body= str_replace('[ICQ_NUMBER]',$data['up_data']['icq_number'],$template->body);
					$template->body= str_replace('[MSN_MESSENGER]',$data['up_data']['msn_messenger'],$template->body);
					$template->body= str_replace('[SUBJECT_SELECT]',$data['up_data']['subject'],$template->body);
					$template->body= str_replace('[COMMENT]',$data['up_data']['comment'],$template->body);
                                        $this->emailbody = $this->set_macros($template->body,$data);
				}
			break;
			case 'contact_us_thankyou':
                            	if($template){
                                        $this->to_email=$data['up_data']['email_id'];
                                        $this->emailsubject = str_replace('[USERNAME]',ucfirst($data['sender_name']),$template->mail_subject); 
					$template->body= str_replace('[DOMAIN_NAME]',$data['up_data']['domain_name'],$template->body);
					$template->body= str_replace('[USERNAME]',$data['up_data']['full_name'],$template->body);
					$template->body= str_replace('[CONTACT_DATE]',convert_timestamp_date($data['up_data']['contact_date']),$template->body);
					$template->body= str_replace('[EMAIL_ID]',$data['up_data']['email_id'],$template->body);
					$template->body= str_replace('[ICQ_NUMBER]',$data['up_data']['icq_number'],$template->body);
					$template->body= str_replace('[MSN_MESSENGER]',$data['up_data']['msn_messenger'],$template->body);
					$template->body= str_replace('[SUBJECT_SELECT]',$data['up_data']['subject'],$template->body);
					$template->body= str_replace('[COMMENT]',$data['up_data']['comment'],$template->body);
                                        $this->emailbody = $this->set_macros($template->body,$data);
				}
			break;
                        
                        case 'new_user_registration':
				if($template){
                                        
                                        $this->sender_name = $data['first_name']." ".$data['last_name'];
					$this->emailsubject = $this->set_macros($template->mail_subject,$data); 
                                        $template->body= str_replace('[EMAIL_ID]',$data['email'],$template->body);
                                        $template->body= str_replace('[REGISTER_DATE]',convert_timestamp_date(time()),$template->body);
                                        $template->body= str_replace('[MAIN_LINK]',ADMIN_HTTP_PATH.'clientusers/listuser/',$template->body);
                                        $this->emailbody = $this->set_macros($template->body,$data);
				}
			break;
                        
                        case 'email_verification':
				if($template){
                                        $this->to_email = $data['email'];
                                        $this->sender_name = $this->sender_name;
					$this->emailsubject = $this->set_macros($template->mail_subject,$data); 
                                        $template->body= str_replace('[ACTIVATION_LINK]',$data['activation_link'],$template->body);
                                        $template->body= str_replace('[MAIN_LINK]',HTTP_PATH.'clientusers/',$template->body);
                                        $this->emailbody = $this->set_macros($template->body,$data);
				}
			break;
                        case 'password_recovery':
                                if($template){
                                        
                                        $this->to_email=$data['email'];
                                        $this->emailsubject = $this->set_macros($template->mail_subject,$data); 
                                        $template->body =  str_replace('[FORGOT_PASS_LINK]',$data['activation_link'],$template->body);
                                        $template->body= str_replace('[MAIN_LINK]',HTTP_PATH.'clientusers/',$template->body);
                                        $this->emailbody =  $this->set_macros($template->body,$data);
                                }
                        break;
                        case 'invoive_upload_admin':
				if($template){
                                        $this->attached_file=$data['template_data']->invoice_file;
                                        $this->to_email=$data['template_data']->email_id;
                                        $this->emailsubject = $this->set_macros($template->mail_subject,$data); 
                                        $template->body= str_replace('[FIRSTNAME]',$data['template_data']->uname,$template->body);
                                        $template->body= str_replace('[LASTNAME]','',$template->body);
                                        $template->body= str_replace('[TRANS_ID]',$data['template_data']->transc_id,$template->body);
                                        $template->body= str_replace('[DUE_DATE]',convert_timestamp_date($data['template_data']->due_date),$template->body);
                                        $template->body= str_replace('[DESCRIPTION]',$data['template_data']->description,$template->body);
                                        $template->body= str_replace('[AMOUNT]',print_money_with_symbol(($data['template_data']->amount),$data['template_data']->currency_code),$template->body);
                                        $template->body= str_replace('[MAIN_LINK]',CLIENT_HTTP_PATH.'myaccount/invoice/',$template->body);
                                        $this->emailbody = $this->set_macros($template->body,$data);
                                       // print_r($this->emailbody);
                                        //die;
				}
			break;
                        
		}
		
		if($template){
			$this->emailbody=str_replace('[USEREMAIL]',$data['email'],$this->emailbody);
			if(isset($data['user_id'])) {
				$this->emailbody=str_replace('[UNSUBSCRIBE]',HTTP_PATH.'unsubscribe/index/uid/'.md5($data['user_id']),$this->emailbody);
			}
		}
                
		if( $this->emailsubject == 'NOT_PREPARED'){ // Do not send email if email is not prepared
			return;
		}
                
                
                $config['protocol'] = 'sendmail';
                
                /*if(MAIL_PROTOCOL=='smtp')
                {
                    //  ========== newly added things to Codeigniter mail class ===============
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'mail.cisinlabs.com';
                    $config['smtp_user'] = 'rishi.r@cisinlabs.com';
                    $config['smtp_pass'] = 'cis951';
                    $config['_smtp_auth'] = TRUE;
                    //  ========== newly added things to Codeigniter mail class ===============
                }*/
                $config['mailpath'] = '/usr/sbin/sendmail';
                
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = "html";
                
                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->from($this->sender_email, $this->sender_name);
                $this->email->to($this->to_email);
                $this->email->subject($this->emailsubject);
                $this->email->message($this->emailbody);
                if(!empty($this->attached_file))
                $this->email->attach($this->attached_file);
                
                $sss=$this->email->send();
		
 }
 
 
 function set_macros($rep_data,$tempdata)
 {
     if(isset($tempdata['first_name']))
     $rep_data= str_replace('[FIRSTNAME]',$tempdata['first_name'],$rep_data);
     if(isset($tempdata['last_name']))
     $rep_data= str_replace('[LASTNAME]',$tempdata['last_name'],$rep_data);
     $rep_data= str_replace('[SITENAME]',SITE_NAME,$rep_data);
     $rep_data= str_replace('[CLIENT_LOGIN_URL]',HTTP_PATH,$rep_data);
     $rep_data= str_replace('[SUPPORT_LIVE_HELP_URL]',HTTP_PATH,$rep_data);
     $rep_data= str_replace('[CONTACT_EMAIL]',CONTACT_EMAIL,$rep_data);
     return $rep_data;
 }

}

?>