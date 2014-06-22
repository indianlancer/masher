<script>
        $(document).ready(function(){
            
            $('#t_header_menus').sort_inedit({
                    inputs_arr: new Array("txtFormat","txtDecimal","txtThousSept","txtSeptBy"),
                    save_url: ADMIN_HTTP_PATH+"settings/updateformats/",
                    block_mess: "Please wait..",
                    reply_mess_id:"rep_mess",
                    block_id: "t_header_menus",
                    save_button: '<?php inline_save_button("new");?>',
                    req_error: REQ_ERROR
            });
            
        });

    </script>
    <style>
        #t_header_menus input[type=text]
        {
            width:100%;
            border:none;
            padding:5px 0px;
        }
    </style>
    <!-- Bread Crumb Navigation -->
    <div class="span10">
      <div>
        <ul class="breadcrumb">
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH;?>"><?php echo tr("HOME"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings"><?php echo tr("SETTINGS"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/managecurrformats/"><?php echo tr("MANAGE_FORMATS"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
        <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                <?php toolbar_def_buttons("MANAGE_CURRENCY",ADMIN_HTTP_PATH."settings/managecurrency/");toolbar_def_buttons("MANAGE_DEFAULT",ADMIN_HTTP_PATH."settings/currency/");inline_button(true,true,"currency_formats"); ?>
                </div>
            </div>
            <?php set_print_success_error(); ?> 
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("MANAGE_CURRENCY"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <table class="table table-bordered" id="t_header_menus" tab_d="t_header_menus" path="settings/managecurrformats/">
                            <thead>
                                <tr class="nodrop nodrag" id="tr_<?php echo base64_encode(0); ?>">
                                    <th style="" width="1"><input type="checkbox" id="checkallitem"></th>
                                    <th class="left"><?php echo tr("FORMAT_NAME"); ?></th>
                                    <th class="left"><?php echo tr("DECIMAL_SYMBOL"); ?></th>
                                    <th class="left"><?php echo tr("THOUSAND_SEPERATOR"); ?></th>
                                    <th class="left"><?php echo tr("THOUSAND_SEPERATED_BY"); ?></th>
                                    <th class="right"><?php echo tr("ACTION"); ?></th>

                                </tr>
                            </thead>
                            <tbody class="dragging_t">
        <?php
            if (!empty($currency_formats)) {
                foreach($currency_formats as $data) {
                    $encodedid=encode_id($data->id);
        ?>
                                <tr id="tr_<?php echo $encodedid; ?>">
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <input type="text" value="<?php echo $data->format_name; ?>" id="txtFormat_<?php echo $encodedid;?>" name="txtFormat_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <input type="text" maxlength="1" value="<?php echo $data->decimal_symbol; ?>" id="txtDecimal_<?php echo $encodedid;?>" name="txtDecimal_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <input type="text" maxlength="1" value="<?php echo $data->thousand_seprator; ?>" id="txtThousSept_<?php echo $encodedid;?>" name="txtThousSept_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <input type="text" maxlength="1" value="<?php echo $data->thousand_seprated_from; ?>" id="txtSeptBy_<?php echo $encodedid;?>" name="txtSeptBy_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="right">
                                        <div class="btn-toolbar">
                                            <?php inline_save_button($encodedid);?>
                                        </div>

                                    </td>
                                </tr>
                <?php
            }
        } else {
            ?>
                                <tr>
                                    <td class="left" colspan="8" align="center"><?php echo tr("NO_RECORDS"); ?></td>
                                </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination">
                <div class="links">
                    <?php echo $this->pagination->create_links();?>
                </div>
                <div class="results">
                    Showing <?php echo $curr_data;?> of <?php echo $total_rows;?>
                </div>
            </div>
        </div>
    </div>
</div><!--/span-->
                
        