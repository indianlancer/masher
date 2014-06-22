<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>" id="center_page_sh">
<?php
        if(isset($bread_crumb) && !empty($bread_crumb))
            breadcrumb($bread_crumb);
?>
        <!-- Table -->
<?php
          print_success_error($sucessmessage,$error);
?>  
        <div class="box box-content" id="tool_box_btn">
            <div id="toolbar" class="btn-toolbar">
                <?php echo toolbar_buttons(array("save","save_new","save_close","cancel"),ADMIN_HTTP_PATH.'users/listuser/'.$startpoint);?>
            </div>
        </div>
         <div class="box" id="box-0">
              <h4 class="box-header round-top">Edit user</h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                    <form action="" method="post" id="sub_form" class="form-horizontal" novalidate>
                        <input type="hidden" name="update" value="<?php echo $orig_id; ?>">
                        <input type="hidden" name="tooltask" id="tooltask" value="save">
                        <input type="hidden" name="hdnstartpoint" value="<?php echo $startpoint; ?>">
                            <div class="control-group">
                                <label class="control-label" for="txtFirstname">* First name:</label>
                                <div class="controls">
                                    <input <?php rt_validation("required","required").rt_validation("maxlength","20").rt_validation("regex","[a-zA-Z]+","Alphabets only allowed");?> type="text" id="txtFirstname" name="txtFirstname" value="<?php if(!set_value('txtFirstname')) echo $userup_data->first_name; else echo set_value("txtFirstname");?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="txtLastname">* Last name:</label>
                                <div class="controls">
                                    <input <?php rt_validation("required","required").rt_validation("maxlength","20").rt_validation("regex","[a-zA-Z]+","Alphabets only allowed");?> type="text" id="txtLastname" name="txtLastname" value="<?php if(!set_value('txtLastname')) echo $userup_data->last_name; else echo set_value("txtLastname");?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="txtEmailId">* Email ID:</label>
                                <div class="controls">
                                    <input <?php rt_validation("required","required").rt_validation("email").rt_validation("maxlength","50");?> type="email" id="txtEmailId" name="txtEmailId" value="<?php if(!set_value('txtEmailId')) echo $userup_data->email_id; else  echo set_value("txtEmailId");?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="txtPassword">* Password:</label>
                                <div class="controls">
                                    <input <?php rt_validation("regex",PASSWORD_PATTERN,"Password should be of 8 chars in length atleast, should contain 1 uppercase, 1 lowercase letter & 1 digit").rt_validation("maxlength","30");?> type="password" id="txtPassword" name="txtPassword">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="txtConfPassword">* Confirm password:</label>
                                <div class="controls">
                                    <input <?php rt_validation("maxlength","30").rt_validation("match","txtPassword","Confirm password does not match");?> type="password" id="txtConfPassword" name="txtConfPassword" value="">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div><!--/span-->
</div>