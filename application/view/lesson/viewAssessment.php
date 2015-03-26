        <style>
            #canvas
            {
                margin-left: 10px;
                margin-top: 10px;
                background: #3D3F49;
                border: thin solid #aaaaaa;
            }
            #gameDiv
            {
                position: absolute;
                left: 25px;
                top: 10px;
                color: #eeeeee;
            }
        </style>
        <script>
            function checkAnswers() {
                var elem = document.getElementById('questions').elements;
                for(var i = 0; i < elem.length; i++) {
                    if (elem[i].value==="right") {
                            //do nothing
                            //alert("Failure.");
                           //this is where we would store failur attempt in DB
                    }
                    
                    else
                        alert("Failure.");
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
                checkAnswers();
            }
        </script>
<div id="contentArea">
    <div class="contentDivision"> 

    <h4>Assessment for Lesson <?php echo Request::get('id'); ?></h4>

        <div id="gameDiv">

        <form id='questions' action="index.php" method="POST" onsubmit="return validateForm(this.id)">
            <br>Answer each of the blanks so that the path from start to finish is completed.<br>
            
            <br>x = 0 <br>y = 0<br>
            <select id="Q1">
                <option value="Please make a selection."></option>
                <option value="wrong1">x = x - 5</option>
                <option value="right">x = x + 5</option>
                <option value="wrong2">x = 5 * x</option>
                <option value="wrong3">x = x / 5</option>
                <option value="wrong4">x = x + 1</option>    
            </select>   
            
            <br>if (x < 5)<br>FAIL
            <br>else {<br>
            &nbsp;&nbsp;&nbsp;&nbsp; <select id="Q2 ">
                <option value="Please make a selection."></option>
                <option value="wrong1">y = y - 4</option>
                <option value="wrong2">y = y + 5</option>
                <option value="wrong3">y = 5 * y</option>
                <option value="right">y = y - 10</option>
                <option value="wrong4">y = y / 5</option>    
            </select> 
            <br>&nbsp;&nbsp;&nbsp;&nbsp;if (y &le; -5) {
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;while (x &ge; 1) {
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="Q3">
                <option value="Please make a selection."></option>
                <option value="right">x = x - 1</option>
                <option value="wrong1">x = x + 1</option>
                <option value="wrong2">x = 2x</option>
                <option value="wrong3">x = x / 1</option>
                <option value="wrong4">x = x + 5</option>
            </select>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if( <select id="Q4">
                <option value="Please make a selection."></option>
                <option value="wrong1">y &LT; -10</option> 
                <option value="right">y &LT; 0</option>
                <option value="wrong2">y &ge; -9</option> 
                <option value="wrong3">y &ge; 0</option>
                <option value="wrong4">y &le; -11</option> 
            </select> ) {
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;while ( <select id="Q5">
                <option value="Please make a selection."></option>
                <option value="wrong1">y = y</option>
                <option value="wrong1">y &LT; -50</option>
                <option value="wrong1">y &LT; -15</option>
                <option value="wrong1">y &LT; -10</option>
                <option value="right">y &LT; 15</option>
            </select> )
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;y = y + 1
            <br> &nbsp;&nbsp;&nbsp;&nbsp;}
            <br> &nbsp;&nbsp;&nbsp;&nbsp;else
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FAIL
            <br>}
            <br>else
            <br>&nbsp;&nbsp;&nbsp;&nbsp;FAIL<br>
           
            <button name="submit" type="submit" value="check_assessment">Check Assessment</button>
        </form>
        
    </div>
        
    <canvas id="canvas" width="750" height="500" style="border:1px solid #000000;">
            HTML Canvas isn't supported by your browser.
    </canvas>

    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div>
  </div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>