

<div id="contentArea">
    <div class="contentDivision"> 
        <!-- request password reset form box -->
        <form method="post" class="form-request" action="<?php echo Config::get('URL', 'gen');?>account/editPassword_action">
            <h2 class="form-request-heading">Change Password</h2>
            <input type="password" class="form-control" pattern=".{6,}" placeholder="New Password" id="password1" name="password1" required autocomplete="off" onkeyup="check(this)"/>
            <input type="password" class="form-control" pattern=".{6,}" placeholder="Re-type New Password" id="password2" name="password2" required autocomplete="off" onkeyup="check(this)"/>
            <span id="passwordMsg" class="label label-danger" margin="5" style="visibility: hidden;"> </span>
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="changePwdBtn"  value="Change Password" />
        </form>
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>
</div>

<script>
    function check(passwordBox) {
        var passwordBox1 = document.getElementById("password1");
        var passwordBox2 = document.getElementById("password2");
        var msgBox = document.getElementById("passwordMsg");
        if(msgBox.style.visibility != "visibile"){
        msgBox.style.visibility="visible";
        }
        var password1Text = passwordBox1.value;
        var password2Text = passwordBox2.value;
        if(password1Text == password2Text){
            msgBox.setAttribute("class", "label label-success");
            msgBox.innerHTML = "Passwords Match";
        } else{
            msgBox.setAttribute("class", "label label-danger");
            msgBox.innerHTML = "Passwords Do Not Match";
        }
        
        
    }
</script>