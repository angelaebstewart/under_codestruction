<div id="contentArea">
    <div class="contentDivision">


        <div class="item-list">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"><h4>Lessons</h4></div>

                <!-- List group -->
                <ul class="list-group">

                    <?php
                    $lessonList = $this->lessonList;

                    foreach ($lessonList as $lessonID => $lesson) {
                        ?><li class="list-group-item"><?php
                        if (isset($lesson["id"])) {
                            echo "<a href='" . Config::get('URL', 'gen') . "lesson/viewLesson/?id=" . $lesson["id"] . "'>" . $lesson["name"] . "</a>";
                        } else {
                            echo $lesson["name"];
                        }
                        ?></li><?php
                        }
                        ?>

                </ul>
            </div>
        </div>
    </div> 
</div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>