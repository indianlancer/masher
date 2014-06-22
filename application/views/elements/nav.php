<div class="collapse navbar-collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav navbar-right">
        <?php
        if(!isset($user_session) || empty($user_session))
        {
?>
        <li>
            <a href="<?php echo HTTP_PATH;?>signin_up">
                <i class="icon icon-lock"></i> <div>Login</div>
            </a>
            
        </li>
        <li>
            <a href="<?php echo HTTP_PATH;?>signin_up">
                <i class="icon icon-signin"></i> <div>Signup</div>
            </a>
        </li>
<?php
        }
        else
        {
?>
        <li>
            <a href="<?php echo HTTP_PATH;?>login/logout">
                <i class="icon icon-signout"></i> <div>Signout</div>
            </a>
        </li>
<?php
        }
?>
    </ul>
    <div class="search-open">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search">
            <span class="input-group-btn">
                <button class="btn-u" type="button">Go</button>
            </span>
        </div><!-- /input-group -->
    </div>                
    </div>