<?php
        
        if(!empty($friend_request_list))
        foreach ($friend_request_list as $list)
        {
?>
        <li>    
            <div><?php echo $list->first_name." ".$list->last_name;?> <a class="accept_req btn btn-mini btn-success pull-right" data-id="<?php echo $list->id;?>">Accept</a></div>
        </li>
<?php        

        }
        ?>