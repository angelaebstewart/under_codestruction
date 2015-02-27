  <div id="contentArea">
    <div class="contentDivision gameContent"> 

    <h4><br>Game for Lesson <?php echo Request::get('id'); ?></h4>

        <script>
            function check(inValue, idIn) {
                if (inValue !== 'right') {
                    alert(inValue);
                    document.getElementById(idIn).selectedIndex = 0;
                }
            }
            
            function validateForm() {
                var elem = document.getElementById('questions').elements;
                for(var i = 0; i < elem.length; i++) {
                    if (elem[i].value==='Please make a selection.') {
                           alert("Answer all blanks before moving on.");
                           return false;
                    }
                }
            }
        </script>    
        <div id="gameDiv">

       <form id='questions' action="game/viewGame?id=1&page=3" method="POST" onsubmit="return validateForm()">
            <br>Given: You know what items you need to buy from the store. The next step is 
            getting to the store.<br> The store is an unknown distance away, and you must 
                drive there and back.<br>
                <br>if (<select id="Q2" onchange="check(this.value, this.id)">
                <option value="Please make a selection."></option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">* (multiply)</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">2</option>
                <option value="right">amount of gas</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
                </select>&gt;distance to store
                <select id="Q4" onchange="check(this.value, this.id)">
                <option value="Please make a selection."></option>
                <option value="right">* (multiply)</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">2</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">amount of gas</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
            </select>
                <select id="Q5" onchange="check(this.value, this.id)">
                <option value="Please make a selection."></option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">* (multiply)</option>
                <option value="right">2</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">amount of gas</option>
                <option value="Place these choices so that you have enough gas to go to and from the store.">distance to store</option>
            </select>) {<br>
                &nbsp;&nbsp;&nbsp;&nbsp;drive to store<br>
                }<br>
                
                <br> else {
                <br>&nbsp;&nbsp;&nbsp;&nbsp;drive to gas station<br>
                &nbsp;&nbsp;&nbsp;&nbsp;<select id="Q6" onchange="check(this.value, this.id)">
                <option value="Please make a selection."></option>
                <option value="You're here because you didn't have enough gas.">buy a candy bar</option>
                <option value="You're here because you didn't have enough gas.">drive back home</option>
                <option value="You're here because you didn't have enough gas.">drive to store</option>
                <option value="right">pump gas</option>
            </select><br>
                &nbsp;&nbsp;&nbsp;&nbsp;<select id="Q7" onchange="check(this.value, this.id)">
                <option value="Please make a selection."></option>
                <option value="Remember the intended destination.">buy a candy bar</option>
                <option value="Remember the intended destination.">drive back home</option>
                <option value="right">drive to store</option>
                <option value="Remember the intended destination.">pump gas</option>
            </select><br><br>
                }<br>
            
            <button name="submit" type="submit" value="next_task">Next Task</button>
            
 
        </form>
        
    </div>
        
    <canvas id="canvas" width="750" height="500" style="border:1px solid #000000;">
            HTML Canvas isn't supported by your browser.
    </canvas>
    
    <script>
        var context = document.getElementById('canvas').getContext("2d");
	
        var img = new Image();
        img.onload = function () {
            context.drawImage(img, 300, 200);
        };
        img.src = "chippy3_0.png";
    </script>

    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div>
  </div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>