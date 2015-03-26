
<div id="contentArea">
    <div class="contentDivision"> 
        <!-- request password reset form box -->
        <form method="post" class="form-request" action="<?php echo Config::get('URL', 'gen'); ?>account/requestEmailReset_action">
            <h2 class="form-request-heading">Email Reset</h2>
            <input type="text" class="form-control" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|
biz|info|mobi|name|aero|asia|jobs|museum)\b" placeholder="Current Email" name="user_name_or_email" required />
            <input type="text" class="form-control" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|
biz|info|mobi|name|aero|asia|jobs|museum)\b" placeholder="New Email" name="new_user_name_or_email" required />
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Send" />
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