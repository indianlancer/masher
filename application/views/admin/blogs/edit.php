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
                toolbar_buttons(array("save","save_new","save_close","cancel"),ADMIN_HTTP_PATH.'pages');
?>
                </div>
            </div>
            <div class="box" id="box-0">
            <h4 class="box-header round-top">Blogs</h4>         
            <div class="box-container-toggle">
                <div class="box-content">
                    <form  enctype="multipart/form-data" action="" method="post" class="form-horizontal" id="sub_form" >
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>" />    
                        <input type="hidden" name="update" value="<?php echo md5(rand()); ?>" />
                        <input type="hidden" name="tooltask" id="tooltask" value="save" />
                            <div class="control-group">
                            <label for="txtMTitle" class="control-label">Title</label>
                            <div class="controls">
                                <textarea id="txtMTitle" <?php rt_validation("required","required").rt_validation("maxlength","200");?> class="span10" name="txtMTitle" rows="5" cols="90" ><?php echo $page_data->title;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="txtMDesc" class="control-label">Short Description</label>
                            <div class="controls">
                                <textarea id="txtMDesc" class="span10" name="txtMDesc" rows="5" cols="90" <?php rt_validation("required","required").rt_validation("maxlength","300");?>
                                ><?php echo $page_data->short_desc;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="fileImage" class="control-label">Image</label>
                            <div class="controls">
                                <input type="file" id="fileImage" class="span10" name="fileImage" />
                            </div>
                            <?php
                            if(file_exists(UPLOAD_ROOT_PATH .'posts_upload/'.$page_data->id."/".$page_data->image))
                            {
                            ?>
                            <br/>
                            <img src="<?php echo UPLOAD_PATH .'posts_upload/'.$page_data->id."/200_100_".$page_data->image;?>" width="200" />    
                            <?php
                            }
                            ?>

                        </div>
                        <div class="control-group">
                            <label for="txtTags" class="control-label">Tags</label>
                            <div class="controls">
                                <textarea id="txtTags" <?php rt_validation("required","required").rt_validation("maxlength","200");?> class="span10" placeholder="Tags must be enter seprated" name="txtTags" rows="5" cols="90" ><?php echo $page_data->tags;?></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="txtPageContent" class="control-label">Content</label>
                            <div class="controls">
                                <textarea id="txtPageContent" name="txtPageContent" ><?php echo $page_data->content;?></textarea>
                                <script type="text/javascript">
                                        //<![CDATA[
                                        CKEDITOR.replace( 'txtPageContent',{

                                        });
                                        //]]>
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
        