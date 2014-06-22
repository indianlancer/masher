<div class="container main_container">
    <section class="middle">
        <div class="main_cont_pt">
            <div class="content">
                <div class="page-header">
                    <div class="headline"><h2>Verify Your email Id</h2></div>
                </div>
                <p class="alert alert-success">
                    Signup successful! <b>Email address verification needed.</b>
                    <br>
                    Before you can login, please check your email to activate your user account. If you don't receive an email within few minutes, please check your
                    spam filters. If you cannot access your spam filter, Resend the verification email.
                </p>
                <div class="row-fluid">
                    <iframe src="<?php echo HTTP_PATH;?>signup/resendverifyemail" class="span8" id="resend_iframe" frameborder="0" style="overflow: hidden;"></iframe>
                    <div class="span2"><img class="displaynone" id="loader" src="<?php echo ICONS_PATH;?>common/wait.gif" border="0" style="width: 100px;" /></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
</div>
