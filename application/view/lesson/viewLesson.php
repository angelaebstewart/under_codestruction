  <div id="contentArea">
    <div class="contentDivision"> 



    <div class="item-list">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><h4><?php echo $this->lessonData->ModuleName; ?></h4></div>

            <!-- List group -->
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="<?php echo $this->lessonData->VideoLink; ?>" rel="prettyPhoto">
                        Video
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?php echo Config::get('URL', 'gen') . $this->lessonData->GameLink; ?>">
                        Game
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="<?php echo Config::get('URL', 'gen') . $this->lessonData->AssessmentLink; ?>">
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