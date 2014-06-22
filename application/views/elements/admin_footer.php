        <footer>
            <a href="<?php echo HTTP_PATH;?>"><?php echo ucfirst(SITE_NAME);?></a> 
            &#169; 2010 All Rights Reserved.
        </footer>

        <div id="loginalertbox" class="modal hide fade in" style="display: none;">
            <div class="modal-body">
                <p><strong><?php echo tr("LOGIN_ALERT");?></strong></p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo ADMIN_HTTP_PATH;?>" class="btn btn-primary" ><?php echo tr("OK");?></a>
                <a href="<?php echo ADMIN_HTTP_PATH;?>" class="btn" ><?php echo tr("CANCEL");?></a>
            </div>
        </div>

        <div id="confirmbox" class="modal hide fade in" style="display: none;">
            <div class="modal-body">
                <p><strong id="alert_confirm_mess"><?php echo tr("DELETE_CONFIRM");?></strong></p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" close-modal="true" ><?php echo tr("OK");?></a>
                <a href="#" class="btn" data-dismiss="modal" ><?php echo tr("CANCEL");?></a>
            </div>
        </div>
<div class="loading_div">Loading..</div>
<?php include 'admin_js_includes.php';?>
    