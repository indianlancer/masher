    <script>
        $(document).ready(function(){
            $("#selCurrency").change(function(){
                    var thisval=this.value;
                    var url=ADMIN_HTTP_PATH+"settings/setcurrency/";
                    var dataString="data="+thisval;
                    var returndata=ajaxJsonData(url,dataString,"body",'Please wait..','rep_mess');
                    var returndata_p=returndata.split("_");
                    
                    returndata=returndata_p[0];
                    
                    if(returndata==1)
                    {
                        
                    }
            });
                

        });
        

    </script>
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
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/currency/"><?php echo tr("CHANGE_CURRENCY"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
        <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">
                <?php toolbar_def_buttons("MANAGE",ADMIN_HTTP_PATH."settings/managecurrformats/"); toolbar_buttons(array("cancel")); ?>
                </div>
            </div>
                <?php set_print_success_error(); ?> 
             <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("MANAGE_CURRENCY"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <form action="" method="post" autocomplete="off" class="signupform" id="sub_form">

                            <table class="form">
                                <tr>
                                    <td width="10%"> 
                                        <?php echo tr("SELECT_CURRENCY");?>
                                    </td>
                                    <td width="50%"> 
                                        <select style="width: 50px;" class="select" id="selCurrency" name="selCurrency" >

                                            <?php 
                                            foreach($all_currency as $curr)
                                            {
                                                if($currency->id==$curr->id)
                                                {
                                                    $sel="selected='selected'";
                                                }
                                                else
                                                {
                                                    $sel="";
                                                }
            ?>
                                            <option <?php echo $sel;?> value="<?php echo encode_id($curr->id);?>"><?php echo $curr->currency_symbol;?></option>
            <?php
                                            }
            ?>
                                        </select>
                                    </td>
                                    <td width="40%">
                                        <label class="status"></label>
                                    </td>
                                </tr>

                            </table>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div><!--/span-->