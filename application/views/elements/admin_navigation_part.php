<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?php echo HTTP_PATH;?>"><img src="<?php echo IMG_PATH ?>icons/common/<?php echo SITE_LOGO;?>" height="40" title="<?php echo SITE_NAME;?>" /></a>
      <div class="lang_container"></div>
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i> admin
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo ADMIN_HTTP_PATH;?>settings"><?php echo tr("SETTINGS");?></a></li>
          <li class="divider"></li>
          <li><a href="<?php echo ADMIN_HTTP_PATH;?>logout"><img alt="<?php echo tr("LOGOUT");?>" title="<?php echo tr("LOGOUT");?>" src="<?php echo ICONS_PATH;?>admin/icons/logout.png"><?php echo tr("LOGOUT");?></a></li>
        </ul>
      </div>
      <div class="nav-collapse">
        <ul class="nav">
          <li>
              <a href="<?php echo ADMIN_HTTP_PATH.'mailbox';?>" >
<?php 
                    echo tr("MESSAGES");
                    $unread_messages = "1";
                    if($unread_messages)
                    {
?> 
                  <span class="label label-info"><?php echo $unread_messages;?></span>
<?php
                    }
?>
              </a>
          </li>
          <li><a href="#"><?php echo tr("HELP");?></a></li>  
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>