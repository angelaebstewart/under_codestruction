<div id="contentArea">
    <div class="contentDivision">
        <div class="class-list-edit">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Lessons</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Lesson Name</th>
                                <th>Lesson Description</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lessonList = $this->lessonList;

                            foreach ($lessonList as $lessonID => $lesson) {
                                ?>
                                <tr>
                                    <td><?php
                                        if (isset($lesson["id"])) {
                                            echo "<a href='" . Config::get('URL', 'gen') . "lesson/viewLesson/?id=" . $lesson["id"] . "'>" . $lesson["name"] . "</a>";
                                        } else {
                                            echo $lesson["name"];
                                        }
                                        ?></td>
                                    <td><?php echo $lesson["ModuleDescription"]; ?></td>
                                </tr>

                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>




    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>