<?php 
class Mchmail extends CI_Model{

	public $sender_email;
	public $sender_name;
        public $to_email;
        public $attached_file="";
        public $emailsubject ;
        public $emailbody;


        function sendmail($data,$template=false)
	{  
            $this->sender_email = "chat@alpha.cisinlabs.com:81";
            $this->to_email = "chat@alpha.cisinlabs.com:81";
            $this->sender_name = "alphasever";
            $emailsubject = 'NOT_PREPARED';
            $emailbody = 'NOT_PREPARED';
            $template->body = str_replace('[HTTP_PATH]',HTTP_PATH,$template->body);
            
            switch (strtolower($data['type'])) 
            {
                case 'password_recovery':
                        $this->to_email = $data['email'];
                        if($template){
                                $template->body = str_replace('{{username}}',ucfirst($data['username']),$template->body); 
                                
                                $template->body= str_replace('{{activation_link}}',$data['activation_link'],$template->body);
                                $this->emailbody = $template->body;
                                $this->emailsubject = $template->subject;
                        }
                break;
            }


            try{

                if(1==1)
                {
                    //  ========== newly added things to Codeigniter mail class ===============
                    $config['protocol'] = 'smtp';
                    $config['smtp_port'] = 587;
                    $config['smtp_host'] = 'smtp.cisinlabs.com';
                    $config['smtp_user'] = 'rishi.r@cisinlabs.com';
                    $config['smtp_pass'] = 'sdbyj4368';
                    $config['_smtp_auth'] = TRUE;
                    //  ========== newly added things to Codeigniter mail class ===============
                }
                else
                {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                }


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
            catch (Exception $e)
            {
                return $e;
            }
        }
        
        function sendmail2()
	{  
            $rand = rand(4, 10);
            //$this->sender_email = "arun".$rand."@tvesa.in";
            //$this->to_email = "arun@tvesa.in";
            $this->sender_email = "vipin.shm".$rand."@gmail.com";
            $this->to_email = "vipin.s@cisinlabs.com";

            $this->sender_name = "Vipin Sharma";
            $emailsubject = 'Google..........';
            $emailbody = 'Google..........';

            $this->emailsubject = $emailsubject; 
            $this->emailbody = $emailbody;

            try{

                if(1==1)
                {
                    //  ========== newly added things to Codeigniter mail class ===============
                    $config['protocol'] = 'smtp';
                    $config['smtp_port'] = 587;
                    $config['smtp_host'] = 'smtp.cisinlabs.com';
                    $config['smtp_user'] = 'rishi.r@cisinlabs.com';
                    $config['smtp_pass'] = 'sdbyj4368';
                    $config['_smtp_auth'] = TRUE;
                    //  ========== newly added things to Codeigniter mail class ===============
                }
                else
                {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                }


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
            catch (Exception $e)
            {
                return $e;
            }
        }
 
 

}

?>