<script>
var HTTP_PATH = "<?php echo HTTP_PATH;?>";
var this_user = "<?php echo $user_session->id;?>";
</script>
<?php
    echo $this->html->css(array("chat","smileys",'jquery-ui/themes/base/jquery.ui.all'),array(),array("fullPath"=>true));
?>

<div id="main_container" class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="col-md-12">
                <div class="navbar2-side">
                    <ul class="nav navbar2-nav side-nav2">
                    <li class="side-user ">
                        <div class="user-prof-co">
                            <img alt="" src="<?php echo ICONS_PATH;?>common/profile-pic.png" class="img-circle col-xs-10" />
                            <div class="edit-i-d">
                                <i title="Edit" class="icon icon-edit"></i> 
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <p class="welcome">
                            <i class="icon icon-key"></i> Logged in as
                        </p>
                        <p class="name tooltip-sidebar-logout">
                            <?php echo ucfirst($user_session->username);?>
                            <a title="Signout" data-placement="top" data-toggle="tooltip" href="<?php echo HTTP_PATH.'login/logout';?>" class="logout_open" style="color: inherit" data-popup-ordinal="1" id="open_25993300" data-original-title="Logout"><i class="icon icon-signout"></i></a>
                        </p>
                        <div class="clearfix"></div>
                    </li>
                    </ul>
                    <div class="status-btn-g">
                        <div class="btn-group">
                            <div class="dropdown">
                                    <a class="btn set-status" href="#">
                                        Status <i class="icon-gear"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu"> 
                                        <!-- dropdown menu links -->
                                        <li><a data-status="1" class="changeStatus <?php if($user_session->status == 1) echo 'active';?>"><i class="available icon-user-status icon-circle"></i> Available</a></li>

                                        <li><a data-status="2" class="changeStatus <?php if($user_session->status == 2) echo 'active';?>"><i class="away icon-user-status icon-circle"></i> Away</a></li>

                                        <li><a data-status="3" class="changeStatus <?php if($user_session->status == 3) echo 'active';?>"><i class="busy icon-user-status icon-circle"></i> Busy</a></li>

                                        <li><a data-status="4" class="changeStatus <?php if($user_session->status == 4) echo 'active';?>"><i class="offline icon-user-status icon-circle"></i> Invisible</a></li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chat_boxes"></div>
        </div>
        <div class="col-sm-6">
            <div style="height: 20px;clear: both;"></div>
            <div class="col-md-12">
                <div class="search-c-d">
                    <input type="text" value="" placeholder="Search friends..." name="srch_frnd_email" id="srch_frnd_email" class="form-control" autocomplete="off" />
                    <i class="icon icon-search"></i>
                </div>
            </div>
            <div style="height: 20px;clear: both;"></div>
            <div class="col-md-12">
                <div class="user-frnd-list-cont">
                    <div class="user-frnd-list-head">
                        <i class="icon icon-list"></i> 
                        <span>Friends list</span>
                    </div>
                    <ul class="user_frnd_list">

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div style="height: 20px;clear: both;"></div>
            <div class="user-frnd-list-cont">
                <div class="user-frnd-list-head">
                    <i class="icon icon-list"></i> 
                    <span>Friend request list</span>
                </div>
                <ul class="user_req_list">
                </ul>
            </div>
            
        </div>
    </div>
<!-- YOUR BODY HERE -->
</div>

<div id="chat_bx_tmpl" style="display:none;">
    <div class="chatbox" id="chatbox_${chatboxtitle}">
        <div class="chatboxhead">
            <div class="chatboxtitle">${chatboxtitle}</div>
            <div class="chatboxoptions">
                <a href="#" class="togBoxGrowth" data-id="${chatboxtitle}">-</a>
                <a href="#" class="closeChatbox" data-id="${chatboxtitle}">X</a>
            </div>
            <br clear="all"/></div>
        <div class="chatboxcontent"></div>
        <div class="open-smile-cont">
            <a href="#" ><img class="open-smile" data-name="${chatboxtitle}" alt="smileys" src="<?php echo IMG_PATH;?>icons/smileys/smile.png" /></a>
        </div>
        <div class="smileys-list-all-cont">
            <div class="smileys-list-all" id="chat_smiley_${chatboxtitle}" data-id="${chatboxid}">
            </div>
        </div>
        <div class="chatboxinput">
            <textarea class="chatboxtextarea" data-id="${chatboxid}" data-name="${chatboxtitle}"></textarea>
        </div>
    </div>
</div>

<?php
echo $this->html->script('jquery.tmpl',array("fullBase"=>true));
echo $this->html->script('jquery.playSound',array("fullBase"=>true));
echo $this->html->script(array('chat','jquery-ui.min','bootstrap-dropdown'),array("fullBase"=>true));
?>