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
                        <button type="button" class="btn btn-lg btn-primary btn-block" onclick="window.location.href = '<?php echo Config::get('URL', 'gen'); ?>account/editTeacherEmail'">Change Email</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>
    
    <form method="post" class="form-request">
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="changePwdBtn"  value="Delete Account" onclick="confirmDeleteAccount()"/>
    </form>
    
</div>

<script>
function confirmDeleteAccount() {
    var result = window.confirm("Are you sure you want to delete your account? \n\
All classes you teach and students in those classes will also be deleted.");
    if (result == true) {
        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>account/options_deleteAccountAction",
        success: function () {
            alert("Your account was successfully deleted.");
        },
        error: function () {
            alert("There was an error deleting this account.");}
        });
    }
}
</script>
