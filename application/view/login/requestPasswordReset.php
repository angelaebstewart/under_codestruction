<div id="contentArea">
    <div class="contentDivision"> 


        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!-- request password reset form box -->
        <form method="post" class="form-request" action="<?php echo Config::get('URL', 'gen'); ?>account/requestPasswordReset_action">
            <h2 class="form-request-heading">Password Recovery</h2>
            <input type="text" class="form-control" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|edu)\b" placeholder="Email" name="user_name_or_email" required />
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Send" />
        </form>
    </div>
</div>
