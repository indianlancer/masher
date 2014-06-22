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
                <?php echo insert_button(ADMIN_HTTP_PATH."emailtemplate/add");?>
            </div>
        </div>
        <div class="box" id="box-0">
            <h4 class="box-header round-top"><?php echo tr("EMAIL_TEMPLATES"); ?></h4>         
            <div class="box-container-toggle">
                <div class="box-content">
                    <div class="control-group">
                        <label for="txtLabel" class="control-label"><?php echo tr("LABEL");?></label>
                        <div class="controls">
                            <?php echo $template_data->email_label;?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="txtSubject" class="control-label">Subject</label>
                        <div class="controls">
                            <?php echo $template_data->mail_subject;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--/span-->     
        