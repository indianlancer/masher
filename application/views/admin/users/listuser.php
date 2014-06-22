<script>
    function process_after_delete()
    {
        bootbox.alert("Delete success!",function(){});
            setTimeout(function(){
                window.location.reload();
            },1000);
    }
</script>
<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>" id="center_page_sh">
    <?php
        if(isset($bread_crumb) && !empty($bread_crumb))
            breadcrumb($bread_crumb);
    ?>
<?php
          print_success_error($sucessmessage,$error);
          set_print_success_error();
?>  
            <div class="box box-content" id="tool_box_btn">
                <div id="toolbar" class="btn-toolbar">

                    <?php insert_button(ADMIN_HTTP_PATH."users/adduser/").inline_button(false,true,"users");?>
                </div>
            </div>
             <div class="box" id="box-0">
              <h4 class="box-header round-top">Users list</h4>         
              <div class="box-container-toggle">
                  <div class="box-content form-horizontal">
                      <form action="" method="post" name="frmSearch" id="frmSearch">
                        <div class="control-group">
                            <label for="selCategory" class="control-label">Search Keyword</label>
                            <div class="controls">
                                <input type="text" value="<?php echo $search_key;?>" id="txtSearchKey" name="txtSearchKey" placeholder="Search User" />
                                <input type="hidden" value="<?php echo md5(time());?>" id="hdnSerachFnd" name="hdnSerachFnd" />
                                <input type="submit" name="btnSearch" class="btn btn-inverse" id="btnSearch" value="Search" />
                                <input type="button" name="btnResetSearch" class="btn btn-inverse" id="btnResetSearch" value="Reset" />
                            </div>
                        </div>

                    </form>
                    <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="nodrop nodrag" id="tr_<?php echo base64_encode(0); ?>">
                                <th width="1%"><input type="checkbox" id="checkallitem"></th>
                                <th width="20%" class="left">Email ID</th>
                                <th width="20%" class="left">Name</th>
                                <th width="12%" class="left">Created date</th>
                                <th width="12%" class="left">Modified date</th>
                                <th width="25%" class="right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if (!empty($users_list)) {
        foreach($users_list as $data) {
            $encodedid=encode_id($data->id);
?>
                            <tr id="tr_<?php echo $encodedid; ?>">
                                <td style="">
                                    <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                </td>
                                <td class="left">
                                    <div class="uListEmWrp"><?php echo $data->email_id;?></div></td>
                                <td class="left">
                                    <?php echo $data->first_name." ".$data->last_name;?></td>
                                <td class="left">
                                    <?php echo convert_timestamp_date($data->created_date); ?>
                                </td>
                                <td class="left">
                                    <?php echo convert_timestamp_date($data->modified_date); ?>
                                </td>
                                <td class="right">
                                    <div class="btn-toolbar">
                                        <?php 
                                                edit_button(ADMIN_HTTP_PATH."users/edituser/".$encodedid.'/'.$startpoint);
                                                active_deactive_btn($data->is_enabled,$encodedid,"users");
                                        ?>
                                    </div>
                                </td>
                            </tr>
        <?php
    }
} else {
    ?>
                            <tr>
                                <td colspan="6" align="center">No Records</td>
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
   