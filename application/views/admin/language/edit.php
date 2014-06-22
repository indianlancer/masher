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
                        <form action="" method="post" enctype="multipart/form-data" class="signupform" id="sub_form">
                            <input type="hidden" name="update" value="<?php echo md5(rand()); ?>">
                            <input type="hidden" name="tooltask" id="tooltask" value="save" />
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> Language</td>
                                    <td>
                                        <input readonly="true" type="text" id="txtLanguage" name="txtLanguage" value="<?php echo $langs_data->lang;?>"/>
                                        <label class="status"></label>
                                     </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> For Domains</td>
                                    <td>
                                        <?php 
                                        $domain_arr=explode("|",$langs_data->for_domain_ext);
                                        ?>
                                        <textarea id="txtForDomains" rows="10" cols="30" name="txtForDomains" ><?php foreach($domain_arr as $arr) echo $arr."\n";?></textarea>
                                        <label class="status"></label>
                                   </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> Image</td>
                                    <td>
                                        <input type="file" id="fileImage" name="fileImage" />
                                        <input type="hidden" id="hdnImage" name="hdnImage" />
                                        <img src="<?php echo ICONS_PATH.'flags/'.$langs_data->lang.".gif";?>" width="18" />
                                        <br/>
                                        <span class="required">Image Size : 18x12 and .gif only</span>
                                   </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>