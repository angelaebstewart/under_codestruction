  <div id="contentArea">
    <div class="contentDivision"> 




<form class="form-signin" action="<?php echo Config::get('URL','gen'); ?>login/login" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" id="inputEmail" class="form-control" name="user_name" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="user_password" placeholder="Password" required>
        <div class="checkbox" style="display:none;">
          <label>
            <input type="checkbox" value="remember-me" name="set_remember_me_cookie"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <label>
                    <a href="<?php echo Config::get('URL','gen'); ?>account/requestPasswordReset">I forgot my password</a>
</label>
        
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
      </form>
    

    </div>
  </div>