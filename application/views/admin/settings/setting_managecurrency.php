   <script>
        $(document).ready(function(){
            
            var sel_arr= new Array();
            sel_arr[0]=['currcode_sel',"selCurrencyCode",'<option value="">--<?php echo tr("SELECT");?>--</option><option value="<?php echo "EUR";?>"><?php echo "EUR";?></option><?php foreach($currency_codes as $codes) { ?><option value="<?php echo $codes->currency_code;?>"><?php echo $codes->currency_code;?></option><?php } ?>','hdnCurrencyCode',''];
            
            sel_arr[1]=['currformat_sel',"selCurrencyFormat",'<option value="">--<?php echo tr("SELECT");?>--</option><?php foreach($currency_formats as $formats) { ?><option value="<?php echo $formats->id;?>"><?php echo $formats->format_name;?></option><?php } ?>','hdnCurrencyFormat',''];
            
            sel_arr[2]=['space_sel','selSpace','<option value="1"><?php echo tr("YES");?></option><option value="0"><?php echo tr("NO");?></option>','hdnSpace','1'];
            sel_arr[3]=["",'selPlace','<option value="1"><?php echo tr("BEFORE_VALUE");?></option><option value="2"><?php echo tr("AFTER_VALUE");?></option>','hdnPlace','1'];
            
            $('#t_header_menus').sort_inedit({
                    inputs_arr: new Array("txtCurrency"),
                    select_tag_arr: sel_arr,
                    save_url: ADMIN_HTTP_PATH+"settings/updatecurrencies/",
                    block_mess: "Please wait..",
                    reply_mess_id:"rep_mess",
                    block_id: "t_header_menus",
                    save_button: '<?php inline_save_button("new");?>',
                    act_deact_button: '<?php active_deactive_btn(0,"new","currency_symbols","ENABLE","DISABLE","displaynonehard");?>',
                    req_error: REQ_ERROR
            });
                        
                   
            $("#manage_macros").click(function(e){
                   e.preventDefault();
            });
            
            $(".place_sel").live('blur',function(e){
                    e.preventDefault();
                    var thisid=this.id;
                    var thisval=this.value;
                    thisid=thisid.split("_")[1];
                    document.getElementById("hdnPlace_"+thisid).value=thisval;
            });
            
            $(".space_sel").live('blur',function(e){
                    e.preventDefault();
                    var thisid=this.id;
                    var thisval=this.value;
                    thisid=thisid.split("_")[1];
                    document.getElementById("hdnSpace_"+thisid).value=thisval;
            });
            
            $(".currcode_sel").live('blur',function(e){
                    e.preventDefault();
                    var thisid=this.id;
                    var thisval=this.value;
                    thisid=thisid.split("_")[1];
                    document.getElementById("hdnCurrencyCode_"+thisid).value=thisval;
            });
            
            $(".currformat_sel").live('blur',function(e){
                    e.preventDefault();
                    var thisid=this.id;
                    var thisval=this.value;
                    thisid=thisid.split("_")[1];
                    document.getElementById("hdnCurrencyFormat_"+thisid).value=thisval;
            });
        });

    </script>
    <style>
        #t_header_menus input[type=text]
        {
            width:100%;
            border:none;
        }
        .currcode_sel{
            width: 100px;
        }
        .space_sel
        {
            width: 60px;
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
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/managecurrency/"><?php echo tr("MANAGE_CURRENCY"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
        
    <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                    <?php toolbar_def_buttons("MANAGE_FORMATS",ADMIN_HTTP_PATH."settings/managecurrformats/");toolbar_def_buttons("MANAGE_DEFAULT",ADMIN_HTTP_PATH."settings/currency/");inline_button(true,true,"currency_symbols"); ?>
                </div>
            </div>
            <?php set_print_success_error(); ?> 
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("MANAGE_FORMATS"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <table class="table table-bordered" id="t_header_menus" tab_d="t_header_menus" path="settings/managecurrency/">
                            <thead>
                                <tr class="nodrop nodrag" id="tr_<?php echo base64_encode(0); ?>">
                                    <th style="" width="1"><input type="checkbox" id="checkallitem"></th>
                                    <th class="left"><?php echo tr("CURRENCY"); ?></th>
                                    <th class="left"><?php echo tr("CURRENCY_CODE"); ?></th>
                                    <th class="left"><?php echo tr("CURRENCY_FORMAT"); ?></th>
                                    <th class="left"><?php echo tr("SPACE_ALLOWED"); ?></th>
                                    <th class="left"><?php echo tr("PLACE_VALUE"); ?></th>
                                    <th class="right"><?php echo tr("ACTION"); ?></th>

                                </tr>
                            </thead>
                            <tbody class="dragging_t">
        <?php
            if (!empty($all_currency)) {
                foreach($all_currency as $data) {
                    $encodedid=encode_id($data->id);
        ?>
                                <tr id="tr_<?php echo $encodedid; ?>">
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <input type="text" value="<?php echo $data->currency_symbol; ?>" id="txtCurrency_<?php echo $encodedid;?>" name="txtCurrency_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <select class="currcode_sel" id="selCurrencyCode_<?php echo $encodedid;?>" name="selCurrencyCode_<?php echo $encodedid;?>" >                                 
                                            <option value="">--<?php echo tr("SELECT");?>--</option>
                                            <option <?php if($data->currency_code == "EUR") echo "selected='selected'";?> value="<?php echo "EUR";?>"><?php echo "EUR";?></option>
        <?php
                                            foreach($currency_codes as $codes)
                                            {
        ?>
                                            <option <?php if($data->currency_code == $codes->currency_code) echo "selected='selected'";?> value="<?php echo $codes->currency_code;?>"><?php echo $codes->currency_code;?></option>
        <?php
                                            }
        ?>
                                        </select>
                                        <input type="hidden" value="<?php echo $data->currency_code; ?>" id="hdnCurrencyCode_<?php echo $encodedid;?>" name="hdnCurrencyCode_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <select class="currformat_sel" id="selCurrencyFormat_<?php echo $encodedid;?>" name="selCurrencyFormat_<?php echo $encodedid;?>" >                                 
                                            <option value="">--<?php echo tr("SELECT");?>--</option>
        <?php
                                            foreach($currency_formats as $formats)
                                            {
        ?>
                                            <option <?php if($data->currency_format == $formats->id) echo "selected='selected'";?> value="<?php echo $formats->id;?>"><?php echo $formats->format_name;?></option>
        <?php
                                            }
        ?>
                                        </select>
                                        <input type="hidden" value="<?php echo $data->currency_format; ?>" id="hdnCurrencyFormat_<?php echo $encodedid;?>" name="hdnCurrencyFormat_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <select class="space_sel" id="selSpace_<?php echo $encodedid;?>" name="selSpace_<?php echo $encodedid;?>" >
                                            <option <?php if($data->space == 1) echo "selected='selected'";?> value="1"><?php echo tr("YES");?></option>
                                            <option <?php if($data->space == 0) echo "selected='selected'";?> value="0"><?php echo tr("NO");?></option>
                                        </select>
                                        <input type="hidden" value="<?php echo $data->space; ?>" id="hdnSpace_<?php echo $encodedid;?>" name="hdnSpace_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="left">
                                        <select class="place_sel" id="selPlace_<?php echo $encodedid;?>" name="selPlace_<?php echo $encodedid;?>" >
                                            <option <?php if($data->place == 1) echo "selected='selected'";?> value="1"><?php echo tr("BEFORE_VALUE");?></option>
                                            <option <?php if($data->place == 2) echo "selected='selected'";?> value="2"><?php echo tr("AFTER_VALUE");?></option>
                                        </select>
                                        <input type="hidden" value="<?php echo $data->place; ?>" id="hdnPlace_<?php echo $encodedid;?>" name="hdnPlace_<?php echo $encodedid;?>" />
                                    </td>
                                    <td class="right">
                                        <div class="btn-toolbar">
                                            <?php inline_save_button($encodedid);?>
                                            <?php active_deactive_btn($data->is_enabled,$encodedid,"currency_symbols");?>
                                        </div>

                                    </td>
                                </tr>
                <?php
            }
        } else {
            ?>
                                <tr>
                                    <td class="left" colspan="3" align="center"><?php echo tr("NO_RECORDS"); ?></td>
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