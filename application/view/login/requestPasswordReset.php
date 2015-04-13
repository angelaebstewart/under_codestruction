<div id="contentArea">
    <div class="contentDivision"> 
        <!-- request password reset form box -->
        <form method="post" class="form-request" action="<?php echo Config::get('URL', 'gen'); ?>account/requestPasswordReset_action">
            <h2 class="form-request-heading">Password Reset</h2>
            <input type="text" class="form-control" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|
biz|info|mobi|name|aero|asia|jobs|museum)\b" placeholder="Email" name="email" required />
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Send" />
        </form>
                    <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>

</div>


