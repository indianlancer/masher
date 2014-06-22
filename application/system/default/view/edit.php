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
                <?php echo toolbar_buttons(array("save","save_new","save_close","cancel"));?>
            </div>
        </div>
        <?php print_success_error($sucessmessage,$error);set_print_success_error(); ?> 
            <div class="box" id="box-0">
            <h4 class="box-header round-top"><?php echo tr("EMAIL_TEMPLATES"); ?></h4>         
            <div class="box-container-toggle">
                <div class="box-content">
                    <form action="" method="post" class="form-horizontal" id="sub_form" >
                        <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>" />    
                        <input type="hidden" name="update" value="<?php echo md5(rand()); ?>" />
                        <input type="hidden" name="tooltask" id="tooltask" value="save" />
                            <div class="control-group">
                                <label for="txtLabel" class="control-label"><?php echo tr("LABEL");?></label>
                                <div class="controls">
                                    <input type="text" readonly="true" required="" class="span6" id="txtLabel" name="txtLabel" size="80" value="<?php echo $template_data->email_label;?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="txtSubject" class="control-label">Subject</label>
                                <div class="controls">
                                    <textarea id="txtSubject" required="" class="span6" name="txtSubject" rows="5" cols="90" ><?php echo $template_data->mail_subject;?></textarea>
                                </div>
                            </div>
                            <label>Meta Description</label>
                            <textarea id="txtBody" name="txtBody" ><?php echo $template_data->body;?></textarea>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div><!--/span-->     
        