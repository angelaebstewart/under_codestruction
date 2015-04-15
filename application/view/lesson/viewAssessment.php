<div id="contentArea">
<div class="contentDivision gameContent"> 

    <h4>Assessment for Lesson <?php echo Request::get('id'); ?></h4>

    <div id="gameDiv">

        <form id='questions' action="<?php echo Config::get('URL','gen'); ?>assessment/submitAssessment/?id=<?php echo Request::get('id'); ?>" method="POST">
            <br>Answer each of the blanks so that the path from start to finish is completed.<br>
            
            <br>x = 0 <br>y = 0<br>
            <select name="Q1" id="Q1">
                <option value="Please make a selection."></option>
                <option value="wrong1">x = x - 5</option>
                <option value="right">x = x + 5</option>
                <option value="wrong2">x = 5 * x</option>
                <option value="wrong3">x = x / 5</option>
                <option value="wrong4">x = x + 1</option>    
            </select>   
            
            <br>if (x < 5)<br>&nbsp;&nbsp;&nbsp;&nbsp;FAIL
            <br>else<br>
            &nbsp;&nbsp;&nbsp;&nbsp; <select name="Q2" id="Q2">
                <option value="Please make a selection."></option>
                <option value="wrong1">y = y - 4</option>
                <option value="wrong2">y = y + 5</option>
                <option value="wrong3">y = 5 * y</option>
                <option value="right">y = y - 10</option>
                <option value="wrong4">y = y / 5</option>    
            </select> 
            <br>&nbsp;&nbsp;&nbsp;&nbsp;if (y &le; -5)
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;while (x &ge; 1)
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="Q3" id="Q3">
                <option value="Please make a selection."></option>
                <option value="right">x = x - 1</option>
                <option value="wrong1">x = x + 1</option>
                <option value="wrong2">x = 2x</option>
                <option value="wrong3">x = x / 1</option>
                <option value="wrong4">x = x + 5</option>
            </select>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if( <select name="Q4" id="Q4">
                <option value="Please make a selection."></option>
                <option value="wrong1">y &LT; -10</option> 
                <option value="right">y &LT; 0</option>
                <option value="wrong2">y &ge; -9</option> 
                <option value="wrong3">y &ge; 0</option>
                <option value="wrong4">y &le; -11</option> 
            </select> )

            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WIN
            <br> &nbsp;&nbsp;&nbsp;&nbsp;
            <br> &nbsp;&nbsp;&nbsp;&nbsp;else
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FAIL
            <br>
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
<script>
function runCheck() {
    var elem = document.getElementById('questions').elements;
    for(var i = 0; i < elem.length; i++) {
        if (elem[i].id==='Q1') {
            //move right along blue arror
            if(elem[i].value === 'right') {
                alert("Question 1 is correct");
                //move left along blue line
            }
            
            else {
                alert("Question 1 is incorrect");
                //move right along red line
                return; //added to prevent the rest of the checks
            }
        }

        else if (elem[i].id==='Q2') {
            if(elem[i].value === 'right') {
                alert("Question 2 is correct");
                //move right along blue line
            }
            
            else {
                alert("Question 2 is incorrect");
                //move left along red line
                return;
            }
        }
        
        else if (elem[i].id==='Q3') {
            if(elem[i].value === 'right') {
                alert("Question 3 is correct");
                //move around the while in a square 5 times then move slight left along blue line
            }
            
            else {
                alert("Question 3 is incorrect");
                //move around the while in a square 10 times then the alert will display, assessment will terminate
                alert("Looks like you created an infinite loop!");
                return;
            }
        }
        
        else if (elem[i].id==='Q4') {
            if(elem[i].value === 'right') {
                alert("Question 4 is correct");
                //move right along the blue line outside the div
            }
            
            else {
                alert("Question 4 is incorrect");
                //move left on the red line outside the div
                return;
            }
        }        
    }
}    
</script>

<script>
    function validateForm() {
        var elem = document.getElementById('questions').elements;
        for(var i = 0; i < elem.length; i++) {
            if (elem[i].value==='Please make a selection.') {
                   alert("Answer all blanks before moving on.");
                   return false;
            }
        }
        return true;
    }
    
    $( "#questions" ).submit(function( event ) {
        if ( !validateForm() ) {
            event.preventDefault();
            return;
        }
        
        else {
            runCheck();
        }
    });
</script>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>