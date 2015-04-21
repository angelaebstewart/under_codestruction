<div id="contentArea">
    
    
    
<div class="contentDivision assessmentContent"> 
    
    <p>Fill in the blanks so that the program executes from "Begin" to "End" 
        without getting stuck or going off into the red paths!</p>
    
    <div id="backgroundImages">
        <img src="<?php echo Config::get('URL','gen'); ?>images/assessment/assessment_background.png">
    </div>

    <div id="assessmentDiv">

        <form id='questions' action="<?php echo Config::get('URL','gen'); ?>assessment/submitAssessment/?id=<?php echo Request::get('id'); ?>" method="POST">
            
            <select name="Q1" id="Q1">
                <option value="Please make a selection."></option>
                <option value="wrong1">x = x - 5</option>
                <option value="right">x = x + 5</option>
                <option value="wrong2">x = 5 * x</option>
                <option value="wrong3">x = x / 5</option>
                <option value="wrong4">x = x + 1</option>    
            </select>   
            
            <select name="Q2" id="Q2">
                <option value="Please make a selection."></option>
                <option value="wrong1">y = y - 4</option>
                <option value="wrong2">y = y + 5</option>
                <option value="wrong3">y = 5 * y</option>
                <option value="right">y = y - 10</option>
                <option value="wrong4">y = y / 5</option>    
            </select>
            
            <select name="Q3" id="Q3">
                <option value="Please make a selection."></option>
                <option value="right">x = x - 1</option>
                <option value="wrong1">x = x + 1</option>
                <option value="wrong2">x = 2x</option>
                <option value="wrong3">x = x / 1</option>
                <option value="wrong4">x = x + 5</option>
            </select>
            
            <select name="Q4" id="Q4">
                <option value="Please make a selection."></option>
                <option value="wrong1">y &LT; -10</option> 
                <option value="right">y &LT; 0</option>
                <option value="wrong2">y &ge; -9</option> 
                <option value="wrong3">y &ge; 0</option>
                <option value="wrong4">y &le; -11</option> 
            </select>
            
            <button name="submit" id="submit" type="submit" value="submit_assessment">Submit Assessment</button>
           
        </form>
        
    </div>
    
    <div id="arrowOuter">
        <div id="arrow">
            <img src="<?php echo Config::get('URL','gen'); ?>images/assessment/arrow.png">
        </div>
    </div>

    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div>
</div>

<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/assessmentHandler.js"></script>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>