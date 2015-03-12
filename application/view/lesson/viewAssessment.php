  <div id="contentArea">
    <div class="contentDivision"> 

    <h4>Assessment for Lesson <?php echo Request::get('id'); ?></h4>

    <form method="post" action="<?php echo Config::get('URL','gen'); ?>assessment/submitAssessment/?id=<?php echo Request::get('id'); ?>" name="assessment_form">
        <label for="question1">2 + 2 = </label>
        <select id="question1" name="question1" required autocomplete="off">
            <option value="answer1">2</option>
            <option value="answer2">3</option>
            <option value="answer3">4</option>
        </select>
        <br>
        <input type="submit"  name="submit_assessment" value="Submit assessment" />
    </form>

    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div>
  </div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>