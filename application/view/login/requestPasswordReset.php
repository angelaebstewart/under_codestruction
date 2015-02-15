<div id="contentArea">
    <div class="contentDivision"> 
    

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <!-- request password reset form box -->
    <form method="post" class="form-request" action="<?php echo Config::get('URL','gen'); ?>login/requestPasswordReset_action">
        <h3 class="form-request-heading">Request a password reset</h3>
        <label>
            Enter your username or email and you'll get a mail with instructions:
            <input type="text" class="form-control" name="user_name_or_email" required />
        </label>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Send me a password-reset mail" />
    </form>
</div>
</div>
