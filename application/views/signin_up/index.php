<script>
    var $j = jQuery.noConflict();
	var error_mess_disp = "<?php echo strlen($error_mess);?>";
        var HTTP_PATH = "<?php echo HTTP_PATH;?>";
	$j(function(){
            $j("#txtUsernameLogin").focus();
            if($j.trim($j("#txtUsernameLogin").val().length) > 0)
                $j("#txtPasswordLogin").focus();

	});
</script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jqBootstrapValidation.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>custom/login.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>custom/register.js"></script>
<div class="purchase login_signup_c">
    <section class="container">
        <div class="">
            <div class="row-fluid headline">
                <h2 class="color-white">Lets have a chat as a friend</h2>
            </div>
            
            <div style="height: 10px;"></div>
            <div class="row-fluid">
            
            <div class="LoginForm">
            	<?php 
                        print_success_error($success_mess,$error_mess);
                ?>
                <div class="row-fluid">
                    
                    <form class="col-md-3 login-c-form" method="post" name="login_form" id="login_form" action="" style="position: relative;">
                    	<div id="shake_effect">
                        <?php
                        set_print_success_error(); 
                        echo $this->content->element('login_form');
                        ?>
                        </div>
                    </form>
                    <div class="col-md-2"></div>
                    <form class="col-md-4 login-c-form" method="post" name="signup_form" id="signup_form" action="signup" novalidate style="position:relative;">
                        <?php 
                        echo $this->content->element('register_form');
                        ?>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
