<div class="headline"><h2>Login</h2></div>
    <div class="form-group">
        <input autocomplete="off" type="text" value="<?php if(set_value('txtUsernameLogin')) echo set_value('txtUsernameLogin'); else if(!empty($cookie_remember)) echo $cookie_remember; ?>" placeholder="Email address / Username" id="txtUsernameLogin" name="txtUsernameLogin" class="form-control" />

    </div>
    <div class="form-group">

        <div class="controls">
            <input autocomplete="off" type="password" placeholder="Password" id="txtPasswordLogin" name="txtPasswordLogin" class="form-control" />
        </div>
    </div>
    <label class="checkbox">
        <input <?php if(!empty($cookie_remember)) echo "checked='checked'"; ?> type="checkbox" name="optRememberMe" id="optRememberMe" value="1" /> Remember me
    </label>
        <button class="btn btn-large btn-success" id="ajax_login_btn" type="submit">Login</button>
        &nbsp;&nbsp;<a href="<?php echo HTTP_PATH.'recoverpassword'; ?>">Forgot your password ?</a>
        <p></p>                    