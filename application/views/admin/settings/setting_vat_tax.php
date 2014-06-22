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
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/managevattax/"><?php echo tr("MANAGE_VAT_TAX"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
<!-- Table -->
    <div class="row-fluid">
    <div class="span12">
        <div class="box box-content" id="tool_box_btn">
            <div id="toolbar" class="btn-toolbar">
                <?php inline_button(true,false,"currency_symbols");?>
            </div>
        </div>
        <?php set_print_success_error(); ?> 
            <div class="box" id="box-0">
            <h4 class="box-header round-top"><?php echo tr("MANAGE_FORMATS"); ?></h4>         
            <div class="box-container-toggle">
                <div class="box-content">
                <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                <table class="table table-bordered" id="t_header_features" tab_d="t_header_features" path="webhosting/sortfeatures/">
                    <thead>
                        <tr class="nodrop nodrag" id="tr_<?php echo base64_encode(0); ?>">
                            <th style="" width="1"><input type="checkbox" id="checkallitem"></th>
                            <th class="left"><?php echo tr("COUNTRY"); ?></th>
                            <th class="left"><?php echo tr("ISO2"); ?></th>
                            <th class="left"><?php echo tr("MAP_REFERENCE"); ?></th>
                            <th class="left"><?php echo tr("VAT_COMPULSARY"); ?></th>
                            <th class="left"><?php echo tr("VAT_WORKING_ID_REQUIRED"); ?></th>
                            <th class="left"><?php echo tr("VAT_PERCENT"); ?></th>
                            <th class="right"><?php echo tr("ACTION"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    if (!empty($vats_data)) {
        foreach($vats_data as $data) {
            $encodedid=encode_id($data->CountryId);
?>
                        <tr id="tr_<?php echo $encodedid; ?>">
                            <td style="">
                                <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                            </td>
                            <td class="left">
                                    <?php echo $data->Country;?>
                            </td>
                            
                            <td class="left">
                                <?php echo $data->ISO2;?>
                            </td>
                            <td class="left">
                                    <?php echo $data->MapReference; ?>
                            </td>
                            <td class="left">
                                    <?php if($data->VAT_compulsary==0) echo tr("NO"); else echo tr("YES"); ?>
                            </td>
                            <td class="left">
                                <?php if($data->VAT_working_id==0) echo tr("NO"); else echo tr("YES"); ?>
                            </td>
                            <td class="left">
                                    <?php echo $data->VAT_percent; ?> %
                            </td>
                            <td class="right">
                                <div class="quick_actions">
                                    <span class="edit_ac_link" reflink="<?php echo ADMIN_HTTP_PATH;?>settings/editvattax/<?php echo $encodedid; ?>/<?php echo $startpoint; ?>" id="<?php echo $encodedid; ?>">
                                        <img alt="edit" title="<?php echo tr("EDIT");?>" src="<?php echo ADMIN_ICONS_PATH;?>edit.png" />
                                    </span>
                                    
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
                <?php paging_container($curr_data,$total_rows);?>
        </div>
            </div>
            
        </div>
    </div>
</div><!--/span-->