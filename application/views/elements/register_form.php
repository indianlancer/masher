<div class="headline"><h2>Sign up</h2></div>
    <div class="row-fluid tab_data_cont">
        <div class="form-group">
            <div class="forms">
                <input <?php rt_validation("required","required").rt_validation("maxlength","20").rt_validation("regex","[a-zA-Z]+","Alphabets only allowed");?> type="text" value="" placeholder="First Name" id="txtFirstName" name="txtFirstName" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="forms">
                <input <?php rt_validation("required","required").rt_validation("maxlength","20").rt_validation("regex","[a-zA-Z]+","Alphabets only allowed");?> type="text" placeholder="Last Name" id="txtLastName" name="txtLastName" name="" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <div class="forms">
                <input type="email" <?php rt_validation("required","required").rt_validation("email","email").rt_validation("maxlength","50").rt_validation("ajax",HTTP_PATH."signup/checkregisemail");?> placeholder="Email Address" id="txtEmail" name="txtEmail" class="form-control" />
            </div>
        </div>
<!--        <div class="form-group">
            <div class="forms">
                <input type="text" <?php rt_validation("required","required").rt_validation("regex",USERNAME_PATTERN,'must be atleast 4 characters and contain only alpha numeric characters').rt_validation("maxlength","15").rt_validation("ajax",HTTP_PATH."signup/checkregisusername");?> placeholder="Username" id="txtUsername" name="txtUsername" class="form-control" />
            </div>
        </div>-->
        <div class="form-group">
                <div class="forms">
                    <input <?php rt_validation("required","required").rt_validation("regex",PASSWORD_PATTERN,"Password should be of 8 chars in length atleast, should contain 1 uppercase, 1 lowercase letter & 1 digit").rt_validation("maxlength","30");?> type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Password" />
                </div>
            </div>
            <div class="form-group">
                <div class="forms">
                    <input <?php rt_validation("required","required").rt_validation("maxlength","30").rt_validation("match","txtPassword","Confirm password does not match");?> type="password" id="txtConfPassword" name="txtConfPassword" class="form-control" placeholder="Confirm Password" />
                </div>
            </div>
        <div class="form-group">
            <div class="forms">
                
                    By clicking sign up you agree <a target="_blank" href="<?php echo HTTP_PATH;?>termsandcondition/">Terms & Conditions</a>
                
            </div>
        </div>
    </div>


     <div class="btn-toolbar form-actions" id="signup_btn_container">
        <button class="btn btn-large btn-success" id="next_btn" type="submit">Sign up</button>
    </div>

<!-- Modal -->
<div class="modal fade" id="verifyemailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="myModalLabel">One more step get started</h4>
      </div>
      <div class="modal-body">
          <p class="alert alert-success">
                Signup successful! <b>Email address verification needed.</b>
          </p>
          <p class="alert alert-success">
                Before you can login, please check your email to activate your user account. If you don't receive an email within a few minutes, please check your spam filters.</p>
          <p class="alert alert-success">If you cannot access your spam filter, Resend the verification email.
            </p>
            <div class="body_o_cont row-fluid"></div>
            <div class="span2"><img class="displaynone" id="loader" src="<?php echo ICONS_PATH;?>common/wait.gif" border="0" style="width: 100px;" /></div>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>