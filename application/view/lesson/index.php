
    <div class="container">
<div class="item-list">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h4>Lessons</h4></div>

  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item"><a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=1">Lesson One</a></li>
    <li class="list-group-item">Lesson Two</li>
    <li class="list-group-item">Lesson Three</li>
    <li class="list-group-item">Lesson Four</li>
    <li class="list-group-item">Lesson Five</li>
    <li class="list-group-item">Lesson Six</li>
  </ul>
</div>
</div>
    </div> <!-- /container -->
    
            <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>