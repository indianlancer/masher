<script>
    function process_after_delete()
    {
        window.location.reload();
        bootbox.alert("Delete success!",function(){
            window.location.reload();
        });
            
            
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

<?php 
                insert_button(ADMIN_HTTP_PATH."blogs/add");
                inline_button(false,true,"blog");
?>
                </div>
            </div>
       <div class="box" id="box-0">
              <h4 class="box-header round-top">Blogs</h4>         
                <div class="box-container-toggle">
                    <div class="box-content form-horizontal">
                        <form action="" method="post" name="frmSearch" id="frmSearch">
                            <div class="control-group">
                                <label for="selCategory" class="control-label">Search Keyword</label>
                                <div class="controls">
                                    <input type="text" value="<?php echo $search_key;?>" id="txtSearchKey" name="txtSearchKey" placeholder="Search blogs" />
                                    <input type="hidden" value="<?php echo md5(time());?>" id="hdnSerachFnd" name="hdnSerachFnd" />
                                <input type="submit" name="btnSearch" class="btn btn-inverse" id="btnSearch" value="Search" />
                                <input type="button" name="btnResetSearch" class="btn btn-inverse" id="btnResetSearch" value="Reset" />
                                </div>
                            </div>

                        </form>
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr id="tr_<?php echo base64_encode(0); ?>">
                                    <th width="1"><input type="checkbox" id="checkallitem"></th>
                                    <th width="15%" class="left">Title</th>
                                    <th width="15%" class="left">Short description</th>
                                    <th width="20%" class="left">Image</th>
                                    <th width="10%" class="left">Content</th>
                                    <th width="10%" class="left">Date</th>
                                    <th class="right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
        <?php
            if (!empty($blogs)) {
                foreach($blogs as $data) {
                    $encodedid=encode_id($data->id);
        ?>
                                <tr id="tr_<?php echo $encodedid; ?>">
                                    <td style="">
                                        <input name="selected[]" class="actionsid" value="<?php echo $encodedid; ?>" type="checkbox">
                                    </td>
                                    <td class="left">
                                        <?php echo $data->title; ?>
                                    </td>
                                    <td class="left">
                                        <?php echo $data->short_desc; ?>
                                    </td>
                                    <td class="left">
                                        <?php echo $data->image; ?>
                                    </td>
                                    <td class="left">
                                        <?php echo convert_timestamp_date($data->created);?>
                                    </td>
                                    <td class="left">
                                        <a class="link open_pop_old" set_iframe="true" set_width="900" set_height="500" href="<?php echo HTTP_PATH.'blog/view/'.$data->id;?>">View blog post</a>
                                    </td>
                                    <td class="right btn-toolbar">
<?php
                                            edit_button(ADMIN_HTTP_PATH."blogs/edit/".$encodedid."/".$startpoint);
                                            active_deactive_btn($data->is_enabled,$encodedid,"blog","Enable","Disable");
?>
                                    </td>
                                </tr>
                <?php
            }
        } else {
            ?>
                                <tr class="no_records">
                                    <td colspan="7">No records</td>
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
   

        