<script>
    $j(function(){
        
        $j("#resend_email_verification").submit(function(){
            parent.$j("#loader").show();
            parent.$j("#resend_iframe").hide();
        });
        
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>main/iframe_no_background.css"/>
    <div class="row-fluid span12">
            <form action="" method="post" id="resend_email_verification" name="resend_email_verification">
                <div class="btn-toolbar">
                    <input type="hidden" name="update" id="update" value="<?php echo encode_id("time");?>" />
                    <input type="submit" class="btn btn-large btn-primary" name="resend" id="resend" value="Resend verification Email" />
                </div>
            </form>
        </div>
<?php
        
        if($mail_sent == 1)
        {
?>
        <script>
           $j(function(){
                    parent.bootbox.alert("Activation mail sent successfully, please check your mailbox");
                    parent.$j("#loader").hide();
                    parent.$j("#resend_iframe").show();
            });
        </script>    
<?php
        }
?>
                            