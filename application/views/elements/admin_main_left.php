<?php 
    if(isset($spans_arr['left']) && $spans_arr['left']>0)
    {
?>
<div class="span<?php echo $spans_arr['left'];?>">
      <div class="member-box round-all"> 
        <a><img src="<?php echo ICONS_PATH;?>common/member_ph.png" class="member-box-avatar" /></a>
        <span>
            <strong><?php echo tr("MEMBER");?></strong><br/>
            admin<br/>
            <span class="member-box-links"><a href="<?php echo ADMIN_HTTP_PATH;?>settings"><?php echo tr("SETTINGS");?></a> | <a href="<?php echo ADMIN_HTTP_PATH;?>logout"><?php echo tr("LOGOUT");?></a></span>
        </span>
      </div>          
      <div class="sidebar-nav">
      	<div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
<?php 
            foreach($left_menus as $menu)
            {
                if($menu[1])
                {
?>
            <li class="<?php if(isset($left_active) && ($left_active == $menu[0])) echo 'active';?>"><a href="<?php echo $menu[1];?>"><i class="icon-<?php echo $menu[2];?>"></i> <?php echo tr($menu[0]);?></a></li>
<?php
                }
                else
                {
?>
            <li class="nav-header"><?php echo tr($menu[0]);?></li>        
<?php                    
                }
            }
?>
        </ul>
        </div>
      </div><!--/.well -->
</div>
<!--/span-->
<?php
    }
?>