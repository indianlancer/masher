
    <div class="span4">&nbsp;</div>
    <div class="span4">
      <div class="page-header">
        <h1>Admin Login</h1>
        <?php print_success_error($logout_message,$error);set_print_success_error(); ?> 
      </div>
      <div class="box" style="margin-bottom:300px;">
        <h4 class="box-header round-top">Admin Login</h4>
        <div class="box-container-toggle">
          <div class="box-content">
              <form method="post" class="well form-search" action="">
                    <input type="hidden" name="hidPgRefRan" value="<?php echo rand();?>" />
                    <input type="text" class="input-small" name="txtUserName" placeholder="<?php echo tr("USERNAME"); ?>">
                    <input type="password" class="input-small" name="txtPassword" placeholder="<?php echo tr("PASSWORD"); ?>">
                    <button type="submit" class="btn"><?php echo tr("GO"); ?></button>
                    <label class="inline uniform" for="remember" style="vertical-align: bottom;">
                    <input class="uniform_on" type="checkbox" id="remember" value="option1">
                    Remember me? </label>
                </form>
              </div>
            </div>
          </div>
        <!--/span--> 
        <div class="span4">&nbsp;</div>
    </div>
