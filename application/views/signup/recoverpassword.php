<div class="purchase login_signup_c">
    <section class="container">
        <div class="">
            <div style="height: 10px;"></div>
            <div class="row-fluid">
            
            <div class="LoginForm">

                <form class="form-signin login-c-form col-md-5" method="post" name="pass_recover_form" id="pass_recover_form" action="" >
                    <?php 
                    if(isset ($success_mess) && strlen($success_mess)>0)
                    {
?>
                    <div class="alert alert-success">
                        <?php echo $success_mess;?>
                    </div>
<?php
                    }
                    else
                    if(isset ($error_mess) && strlen($error_mess)>0)
                    {
?>
                    <div class="alert alert-danger">
                        <?php echo $error_mess;?>
                    </div>
<?php
                    }
                    ?>
                    
                    <div class="row-fluid headline">
                        <h2 class="color-white">Forgot Your Password</h2>
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <label for="email" class="control-label"><?php echo tr("USERNAME");?>/<?php echo tr("EMAIL");?></label>
                            <div class="controls">
                                <input type="text" value="" placeholder="Enter username or Email ID" id="txtEmail" name="txtEmail" class="form-control" />
                            </div>
                        </div>
                        <button class="btn btn-large btn-success" type="submit">Submit</button>
                    </fieldset> 
                    <div class="norm-ht-diff"></div>
                    <div>If you have already created your account <a  href="<?php echo HTTP_PATH;?>signin_up">Login</a></div>
                    
                    <div> Become a member <a href="<?php echo HTTP_PATH;?>signin_up">Sign up</a></div>
                </form>
                
            </div>
            <div class="clearfix"></div>
        </div>
        </div>
    </section>
</div>
