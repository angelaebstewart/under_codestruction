<div id="contentArea">
    <div class="contentDivision"> 
        <div class="class-list-edit">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Classes</h3>
                </div>
                <div class="panel-body">

                    <table class="table table-hover" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th><button type="button" class="btn btn-xs btn-danger"  data-toggle="modal" data-target="#myModal">New Class</button></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($this as $key => $value) {
                                $className = $value->ClassName;
                                $classID = $value->ClassID;
                                ?>
                                <tr>
                                    <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=<?php echo $classID ?>"><?php echo $className ?></a></td>
                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href = '<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
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
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="panel panel-default">
                <div class="panel-heading">Create a class
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <form action="#">
                        <input id="classTitle" pattern="[A-Za-z\d\s]+" required name="classTitle" type="text" placeholder="Class Title" class="form-control" >
                        <button id="createClassBtn" class="btn btn-lg btn-primary btn-block" type="submit">Create Class</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
var $classNameInput = $('#classTitle');
var $returnBox = $(".the-return");
    
    $("#createClassBtn").on('click', function(){
        var data = {
        classTitle: $classNameInput.val()
        };
        

        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>class/createClass_action",
        data: data,
        success: function (result) {
            $returnBox.html(result);

        },
        error: function () {alert("error");}
        });

    });

});
</script>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>