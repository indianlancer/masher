<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">
    <div>
        <ul class="breadcrumb">
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH;?>"><?php echo tr("HOME"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings"><?php echo tr("SETTINGS"); ?></a> <span class="divider">/</span>
          </li>
          <li>
            <a href="<?php echo ADMIN_HTTP_PATH; ?>settings/site_logo/"><?php echo tr("SITE_LOGO"); ?></a> <span class="divider">/</span>
          </li>
        </ul>
      </div>
    <!-- Table -->
      <div class="row-fluid">
        <div class="span12">
    <?php
          print_success_error($sucessmessage,$error);
?>  
         <div class="box" id="box-0">
              <h4 class="box-header round-top"><?php echo tr("CONFIG_SETTINGS"); ?></h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                    <input type="hidden" name="hdnPgRefRan" value="<?php echo rand(); ?>">
                       <form action="" method="post" enctype="multipart/form-data" class="signupform" id="upload_form">
                        <input type="hidden" name="update" value="<?php echo md5(rand()); ?>" />
                        <table class="form">
                            <tr>
                                <td><span class="required">*</span> Image</td>
                                <td>
                                    <input type="file" class="upload_image" id="fileImage" name="fileImage" >
                                    <input type="hidden"  id="hdnImage" name="hdnImage" value="<?php echo SITE_LOGO;?>" />
                                    <br/>
                                    <span class="required">Image Size : <?php echo SITE_LOGO_IMG_SIZE;?></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div style="margin-left:100px;" id="uploaded_image">
        <?php
                                        if(file_exists(IMG_ROOT_PATH.SITE_LOGO))
                                        {
        ?>
                                        <img width="200" src="<?php echo IMG_PATH.SITE_LOGO;?>" />
        <?php
                                        }
        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div><!--/span-->
        </div>
      </div>
</div>