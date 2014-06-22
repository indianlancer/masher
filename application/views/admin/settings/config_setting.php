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
                    <?php insert_button(ADMIN_HTTP_PATH."settings/ct_config_setting/").inline_button(false,true,"aff_std_config");?>
                </div>
            </div>
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("CONFIG_SETTINGS"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="" width="1"><input type="checkbox" id="checkallitem"></th>
                                    <th class="left"><?php echo tr("PARAM"); ?></th>
                                    <th class="left"><?php echo tr("VALUE"); ?></th>
                                    <th class="right"><?php echo tr("ACTION"); ?></th>

                                </tr>
                            </thead>
                            <tbody>
<?php
            if (!empty($config_list)) {
                foreach($config_list as $data) {
                    $encoded_id=encode_id($data->id);
?>
                                <tr>
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encoded_id; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <?php echo $data->param; ?></td>
                                    <td class="left">
                                        <?php echo $data->value; ?>
                                    </td>
                                    <td class="right">
                                        <?php edit_button(ADMIN_HTTP_PATH."settings/up_config_setting/".$encoded_id.'/'.$startpoint);?>
                                    </td>
                                </tr>
                <?php
            }
        } else {
            ?>
                                <tr>
                                    <td class="left" colspan="6" align="center"><?php echo tr("NO_RECORDS"); ?></td>
                                </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    
                        <?php paging_container($curr_data,$total_rows);?> 
                  </div>
            </div>
        </div><!--/span-->
        </div>
        