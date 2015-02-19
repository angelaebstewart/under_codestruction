  <div id="contentArea">
    <div class="contentDivision"> 
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>


    <!-- register form -->
    <form method="post" class="form-register" action="<?php echo Config::get('URL', 'gen'); ?>account/register_action">            
        <h3 class="form-register-heading">Register a new account</h3>
        <!-- the user name input field uses a HTML5 pattern check -->
        <input type="text" class="form-control" name="user_firstName" placeholder="first name" required />
        <input type="text" class="form-control" name="user_lastName" placeholder="last name" required />
        <input type="text" class="form-control" name="user_email" placeholder="email address (a real address)" required />
        <input type="password" class="form-control" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)" required autocomplete="off" />
        <input type="password" class="form-control" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password" autocomplete="off" />

        <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
        <div class="">
        <img id="captcha" src="<?php echo Config::get('URL', 'gen'); ?>login/showCaptcha" />
        <span class="label label-info"><a href="#" onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL', 'gen'); ?>login/showCaptcha?' + Math.random();
                       return false">Reload</a></span>
        </div>
        <input type="text" class="form-control" name="captcha" placeholder="Please enter above characters" required />
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Register" />
    </form>
</div>
  </div>
