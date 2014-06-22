<div class="container main_container">
    <section class="middle">
        <div class="main_cont_pt">
            <div class="content">
                <div class="headline"><h2> Email Verification</h2></div>
                
                <?php print_success_error(false,$error_mess); ?> 
<?php
                if($success_mess!="")
                {
?>
                <div class="row-fluid">
                    <div class="alert alert-success">
                        <h4 class="v-font-cl" style="color:#000;">Congratulations!</h4>
                        <br/><br/>
                        You have successfully verified an email address with <?php echo SITE_NAME;?>. 
                        <br/>
                        Your account has now been activated.
                        <br/>
                        <br/>
                        <div class="v-font-cl" style="color:#000;"><a href="<?php echo HTTP_PATH;?>user/">Click here</a> to go to client panel</div>
                    </div>
                    
                </div>
        <?php
                }
        ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
</div>
                            