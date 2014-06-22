<?php 
    if(isset($spans_arr['right']) && $spans_arr['right']>0)
    {
?>
<div class="span<?php echo $spans_arr['right'];?>">
      <div class="member-box round-all"> 
        <a><img src="<?php echo ICONS_PATH;?>common/member_ph.png" class="member-box-avatar" /></a>
        <span>
            <strong><?php echo tr("MEMBER");?></strong><br/>
            <a>admin</a><br/>
            <span class="member-box-links"><a href="<?php echo ADMIN_HTTP_PATH;?>settings"><?php echo tr("SETTINGS");?></a> | <a href="<?php echo ADMIN_HTTP_PATH;?>logout"><?php echo tr("LOGOUT");?></a></span>
        </span>
      </div>          
      <div class="sidebar-nav">
      	<div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list"> 
          <li class="nav-header"><?php echo tr("MAIN");?></li>        
          <li class="active"><a href="<?php echo ADMIN_HTTP_PATH;?>"><i class="icon-home"></i> <?php echo tr("DASHBOARD");?></a></li>
          
          <li><a href="<?php echo ADMIN_HTTP_PATH;?>settings/change_pass"><i class="icon-th-large"></i> <?php echo tr("CHANGE_PASS");?></a></li>
          
          <li><a href="<?php echo ADMIN_HTTP_PATH;?>logout"><i class="icon-off"></i> <?php echo tr("LOGOUT");?></a></li>
        </ul>
        </div>
      </div><!--/.well -->
</div> 
<!--/span-->
<?php
    }
?>