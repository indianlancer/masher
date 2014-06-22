<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">
<?php
      if(isset($bread_crumb) && !empty($bread_crumb))
                breadcrumb($bread_crumb);
?>
   <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                    <?php   toolbar_import_data_button("IMPORT_TEMPLATES",ADMIN_HTTP_PATH."emailtemplate/importtempeng");
                            insert_button(ADMIN_HTTP_PATH."emailtemplate/add");
                            inline_button(false,true,"emailtemplate"); ?>
                </div>
            </div>
            <?php print_success_error($sucessmessage,$error);set_print_success_error(); ?> 
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("EMAIL_TEMPLATES"); ?></h4>         
                <div class="box-container-toggle">
                    <div class="box-content">       
    
        
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <table class="table table-bordered" path="emailtemplates/">
                            <thead>
                                <tr id="tr_<?php echo base64_encode(0); ?>">
                                    <th width="1"><input type="checkbox" id="checkallitem"></th>
                                    <th width="20%" class="left"><?php echo tr("EMAIL_LABEL"); ?></th>
                                    <th width="45%" class="left"><?php echo tr("EMAIL_SUBJECT"); ?></th>
                                    <th width="10%" class="left"><?php echo tr("BODY"); ?></th>
                                    <th width="30%" class="right"><?php echo tr("ACTION"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
        <?php
            if (!empty($email_templates)) {
                foreach($email_templates as $data) {
                    $encodedid=encode_id($data->id);
        ?>
                                <tr id="tr_<?php echo $encodedid; ?>">
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <?php echo $data->email_label; ?>
                                    </td>
                                    <td class="left">
                                        <?php echo $data->mail_subject; ?>
                                    </td>
                                    <td class="left">
                                        <a href="<?php echo ADMIN_HTTP_PATH.'emailtemplates/viewtemplate/'.$encodedid;?>"><?php echo tr("VIEW_TEMPLATE");?></a>
                                    </td>
                                    <td class="right btn-toolbar">
<?php
                                            edit_button(ADMIN_HTTP_PATH."emailtemplate/edit/".$encodedid."/".$startpoint);
                                            active_deactive_btn($data->is_enabled,$encodedid,"emailtemplate","ENABLE","DISABLE");
?>
                                    </td>
                                </tr>
                <?php
            }
        } else {
            ?>
                                <tr>
                                    <td colspan="6" align="center"><?php echo tr("NO_RECORDS"); ?></td>
                                </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                    </table>
                    <?php paging_container($curr_data,$total_rows);?>
                </div>
            </div>
        </div>
    </div>
</div><!--/span-->       
        