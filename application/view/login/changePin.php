

<div id="contentArea">
    <div class="contentDivision"> 
        <!-- request password reset form box -->
        <form method="post" class="form-request" action="<?php echo Config::get('URL', 'gen');?>account/changePin_action">
            <h2 class="form-request-heading">Change Pin</h2>
            <input type="password" class="form-control" pattern="^[0-9]{4}$" placeholder="Enter Pin (4 digits)" id="pin1" name="pin1" required autocomplete="off" onkeyup="check(this)"/>
            <input type="password" class="form-control" pattern="^[0-9]{4}$" placeholder="Re-type Pin" id="pin2" name="pin2" required autocomplete="off" onkeyup="check(this)"/>
            <span id="pinMsg" class="label label-danger" margin="5" style="visibility: hidden;"> </span>
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="setPinBtn"  value="Set Pin" />
        </form>
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>
</div>

<script>
    function check(pinBox) {
        var pinBox1 = document.getElementById("pin1");
        var pinBox2 = document.getElementById("pin2");
        var msgBox = document.getElementById("pinMsg");
        if(msgBox.style.visibility != "visible"){
        msgBox.style.visibility="visible";
        }
        var pin1Text = pinBox1.value;
        var pin2Text = pinBox2.value;
        if(pin1Text == pin2Text){
            msgBox.setAttribute("class", "label label-success");
            msgBox.innerHTML = "Pins Match";
        } else{
            msgBox.setAttribute("class", "label label-danger");
            msgBox.innerHTML = "Pins Do Not Match";
        }
        
        
    }
</script>