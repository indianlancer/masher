<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">
      <div>
        <ul class="breadcrumb">
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH;?>"><?php echo tr("HOME"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings"><?php echo tr("SETTINGS"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/config_setting/"><?php echo tr("CONFIG_SETTINGS"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/ct_config_setting/"><?php echo tr("CREATE"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
    <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
<?php
          print_success_error($sucessmessage,$error);
?>  
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                    <?php echo toolbar_buttons(array("save","save_new","save_close","cancel"));?>
                </div>
            </div>
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("CONFIG_SETTINGS"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                    <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                    <form action="" method="post" id="sub_form" class="form-horizontal" novalidate>
                        <input type="hidden" name="hdnstartpoint" value="<?php echo $startpoint ?>">
                        <input type="hidden" name="tooltask" id="tooltask" value="save">
                        <input type="hidden" name="update" value="<?php echo md5(rand()); ?>">

                        <div class="control-group">
                            <label class="control-label" for="txtParam">* <?php echo tr('PARAM');?>:</label>
                            <div class="controls">
                                <input type="text" value="<?php echo set_value("txtParam");?>" id="txtParam" name="txtParam" required="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="txtValue">* <?php echo tr('VALUE');?>:</label>
                            <div class="controls">
                                <input type="text" value="<?php echo set_value("txtValue");?>" id="txtValue" name="txtValue" required="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="txtDesc"><?php echo tr('DESCRIPTION');?>:</label>
                            </td>
                            <div class="controls">
                                <textarea cols="40" rows="10" class="input-xlarge" id="txtDesc" name="txtDesc"><?php echo set_value("txtDesc");?></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--/span-->
        </div>