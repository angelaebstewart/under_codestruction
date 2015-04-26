<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="contentArea">
    <div class="contentDivision"> 
        <h1>Account Options</h1>
        
      <!--  <form method="post" class="form-request">
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="changePwdBtn"  value="Delete Account" onclick="confirmDeleteAccount()"/>
        </form> -->


    <div class="create-class">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="#">
                        <button type="button" class="btn btn-lg btn-primary btn-block" onclick="window.location.href = '<?php echo Config::get('URL', 'gen'); ?>account/changePassword'">Change Password</button>
                        <button type="button" class="btn btn-lg btn-primary btn-block" onclick="window.location.href = '<?php echo Config::get('URL', 'gen'); ?>account/editUserEmail'">Change Email</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>
    
    
</div>


