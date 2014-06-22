<!-- Bread Crumb Navigation -->
        <div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">
<?php
            if(isset($bread_crumb) && !empty($bread_crumb))
                breadcrumb($bread_crumb);
                set_print_success_error();  
?>
   <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                    <?php   insert_button(ADMIN_HTTP_PATH."language/add");
                            inline_button(false,true,"language"); ?>
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
                                <tr class="nodrop nodrag" id="tr_<?php echo base64_encode(0); ?>">
                                    <th style="" width="1"><input type="checkbox" id="checkallitem" /></th>
                                    <th class="left"><?php echo tr("LANGUAGE"); ?></th>
                                    <th class="left"><?php echo tr("IMAGE"); ?></th>
                                    <th class="left"><?php echo tr("FOR_DOMAINS"); ?></th>
                                    <th class="left"><?php echo tr("DISPALY_TEXT"); ?></th>
                                    <th class="right"><?php echo tr("ACTION"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
        <?php
            if (!empty($langs_data)) {
                foreach($langs_data as $data) {
                    $encodedid=encode_id($data->id);
        ?>
                                <tr id="tr_<?php echo $encodedid; ?>">
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <?php echo $data->lang; ?>
                                    </td>
                                    <td class="left">
                                        <img src="<?php echo ICONS_PATH.'flags/'.$data->lang.".gif";?>" width="18" />
                                    </td>
                                    <td class="left">
                                        <?php echo $data->for_domain_ext;?>
                                    </td>
                                    <td class="left">
                                        <?php echo tr($data->lang); ?>
                                    </td>
                                    <td class="right btn-toolbar">
<?php
                                            edit_button(ADMIN_HTTP_PATH."language/edit/".$encodedid."/".$startpoint);
                                            active_deactive_btn($data->is_enabled,$encodedid,"language","ENABLE","DISABLE");
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
        </div>
    
    