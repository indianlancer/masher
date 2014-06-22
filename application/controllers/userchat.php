<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userchat extends RT_Controller {

    public function __construct()
    {
        $this->load_model = FALSE;   // this is needed to be placed above the parent::__contructor call
        parent::__construct();
        $this->load->library('coresession');
        $this->load->model('home_model');
        $this->load->model('chat_model');
        if (!isset($_SESSION['chatHistory'])) 
        {
            $this->coresession->set_userdata('chatHistory',array());
        }

        if (!isset($_SESSION['openChatBoxes'])) 
        {
            $this->coresession->set_userdata('openChatBoxes',array());
        }
    }
        

    function chatHeartbeat() 
    {
        $chatObj = new chat_model();
        $this->layout = 'ajax';
            $user_session = $this->coresession->userdata('USER_SESSION');
        
            $hdata = $chatObj->heartbeat();
            $items = '';

            $chatBoxes = array();
            
            if(!empty($hdata))
            foreach ($hdata as $chat ) {

                    if (!isset($_SESSION['openChatBoxes'][$chat['from']]) && isset($_SESSION['chatHistory'][$chat['from']])) {
                            $items = $_SESSION['chatHistory'][$chat['from']];
                    }

                    $chat['message'] = $this->sanitize($chat['message']);

                    $items .= '{
                            "s": "0",
                            "f": "'.$chatObj->getUserName($chat['from']).'",
                            "fid": "'.($chat['from']).'",
                            "m": "'.$chat['message'].'"
                            },';

                    if (!isset($_SESSION['chatHistory'][$chat['from']])) {
                            $_SESSION['chatHistory'][$chat['from']] = '';
                    }

                    $_SESSION['chatHistory'][$chat['from']] .= 
                                                               '{
                                    "s": "0",
                                    "f": "'.$chatObj->getUserName($chat['from']).'",
                                    "fid": "'.($chat['from']).'",
                                    "m": "'.$chat['message'].'"
                       },';
            

                    unset($_SESSION['tsChatBoxes'][$chat['from']]);
                    $_SESSION['openChatBoxes'][$chat['from']] = $chat['sent'];
            }

            if (!empty($_SESSION['openChatBoxes'])) {
            foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
                    if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                            $now = time()-strtotime($time);
                            $time = date('g:iA M dS', strtotime($time));

                            $message = "Sent at ".$time;
                            if ($now > 180) {
                                    $items .= '
                                    {
                                    "s": "2",
                                    "f": "'.$chatObj->getUserName($chatbox).'",
                                    "fid": "'.($chatbox).'",
                                    "m": "'.$message.'"
                                    },';
    

                                if (!isset($_SESSION['chatHistory'][$chatbox])) {
                                        $_SESSION['chatHistory'][$chatbox] = '';
                                }

                                $_SESSION['chatHistory'][$chatbox] .= '
                                                {
                                "s": "2",
                                "f": "'.$chatObj->getUserName($chatbox).'",
                                "fid": "'.($chatbox).'",
                                "m": "'.$message.'"
                                },';

                                $_SESSION['tsChatBoxes'][$chatbox] = 1;
                            }
                    }
            }
    }
        $user_session = $this->coresession->userdata('USER_SESSION');
        $friendSt = $chatObj->findFriends();
        $friends_list['friends_list'] = $chatObj->findFriends();
        $friends_list = $this->renderPartial($friends_list,'ajax_friend_list');
            $insertdata = array("recd"=>1);
            $this->db->where("recd",0);
            $this->db->where("to",$user_session->id);
            $this->db->update("chat",$insertdata);
            if ($items != '') {
                    $items = substr($items, 0, -1);
            }
            header('Content-type: application/json');
    ?>
    {
                    "friend_st" : <?php echo json_encode($friends_list);?>,
                    "items": [
                            <?php echo $items;?>
                            ]
    }

    <?php
                            exit(0);
    }

    function chatBoxSession($chatbox) {
        $chatObj = new chat_model();
            $items = '';

            if (isset($_SESSION['chatHistory'][$chatbox])) {
                    $items = $_SESSION['chatHistory'][$chatbox];
            }

            return $items;
    }

    function initiateUserChat() {
        $chatObj = new chat_model();
            $items = '';
            if (!empty($_SESSION['openChatBoxes'])) {
                    foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
                            $items .= $this->chatBoxSession($chatbox);
                    }
            }


            if ($items != '') {
                    $items = substr($items, 0, -1);
            }

    header('Content-type: application/json');
    
    $user_session = $this->coresession->userdata('USER_SESSION');
    ?>
    {
                    "username": "<?php echo $user_session->username;?>",
                    "items": [
                            <?php echo $items;?>
            ]
    }

    <?php


            exit(0);
    }

    function sendChat() {
        $chatObj = new chat_model();
        $user_session = $this->coresession->userdata('USER_SESSION');
            $from = $user_session->id;
            $to = $_POST['to'];
            $message = $_POST['message'];

            $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());

            $messagesan = $this->sanitize($message);

            if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
                    $_SESSION['chatHistory'][$_POST['to']] = '';
            }

            $_SESSION['chatHistory'][$_POST['to']] .= '
                                               {
                            "s": "1",
                            "f": "'.$chatObj->getUserName($to).'",
                            "fid": "'.($to).'",
                            "m": "'.$messagesan.'"
               },';

            unset($_SESSION['tsChatBoxes'][$_POST['to']]);
            $insertdata = array("from"=>$from,"to"=>$to,"message"=> $message,"sent"=>date("Y-m-d H:i:s",time()));
            $this->db->insert("chat",$insertdata);
            
            echo "1";
            exit(0);
    }

    function closeChat() {
$chatObj = new chat_model();
            unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);

            echo "1";
            exit(0);
    }

    function sanitize($text) {
            $text = htmlspecialchars($text, ENT_QUOTES);
            $text = str_replace("\n\r","\n",$text);
            $text = str_replace("\r\n","\n",$text);
            $text = str_replace("\n","<br>",$text);
            return $text;
    }
}