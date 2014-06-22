<!-- Bread Crumb Navigation -->
<div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>" id="center_page_sh">
    <?php
        if(isset($bread_crumb) && !empty($bread_crumb))
            breadcrumb($bread_crumb);
    ?>
             <div class="box" id="box-0">
              <h4 class="box-header round-top">Page Content View</h4>         
              <div class="box-container-toggle">
                <div class="box-content">
                    <div class="template_view"><?php echo htmldata($page_data->content);?></div>
                </div>
            </div>
        </div><!--/span-->
</div>


    
