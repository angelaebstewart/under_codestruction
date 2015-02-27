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

        <form id='questions' action="game/viewGame?id=1&page=2" method="POST" onsubmit="return validateForm()">
            <br>Scenario: You need to go to the store to get any items for your party that you don't already have.<br>
            <br>Given: Your list of items to buy includes chips, dip, soda, a fruit tray, cups, and plates.<br>
            You first need to check your kitchen for each item.<br>
            
            <br>while(more items on list) {
            <br>&nbsp;&nbsp;&nbsp;&nbsp;if (<select id="Q1" onchange="check(this.value, this.id)">
                <option value="Make another selection."></option>
                <option value="You only want a list of items you don't have.">item is not in kitchen</option>
                <option value="right">item is in kitchen</option>
            </select>                
                )
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;remove item from list
                <br>}
            
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