<?php

        if(!empty($friends_list))
        foreach($friends_list as $list)
        {
            $status = "offline";
            if($list->status == 1)
                $status = "available";
            if($list->status == 2)
                $status = "away";
            if($list->status == 3)
                $status = "busy";
       ?>
        <li>    
            <div class="cht_wt chat_user_list" data-name="<?php echo $list->username;?>" data-id="<?php echo $list->id;?>"><span><?php echo ucwords($list->username);?></span> <i class="<?php echo $status;?> icon-user-status icon-circle"></i></div>
        </li>
<?php        

        }
?>