<div class="container">

    <h4>Game for Lesson <?php echo Request::get('id'); ?></h4>

    <p>(Game will go here)</p>

    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div> <!-- /container -->

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>