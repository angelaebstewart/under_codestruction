  <div id="contentArea">
    <div class="contentDivision"> 



    <div class="item-list">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><h4>Lesson <?php echo Request::get('id'); ?> Name</h4></div>

            <!-- List group -->
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="https://www.youtube.com/watch?v=xgeWnEP7Kq4&feature=em-upload_owner" rel="prettyPhoto">
                        Video
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?php echo Config::get('URL', 'gen'); ?>game/viewGame/?id=<?php echo Request::get('id'); ?>">
                        Game
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?php echo Config::get('URL', 'gen'); ?>assessment/viewAssessment/?id=<?php echo Request::get('id'); ?>">
                        Assessment
                    </a>
                </li>
            </ul>
        </div>

        <a href="<?php echo Config::get('URL', 'gen'); ?>lesson/index"><- Back to home page</a>
    </div>
</div> 
  </div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $("a[rel^='prettyPhoto']").prettyPhoto();
    });
</script>