
<div class="container">
    <div class="class-list-edit">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Classes</h3>
            </div>
            <div class="panel-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/createClass'">New Class</button></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>class/viewClass/?classID=1&teacherID=1">Class One</a></td>
                            <td><button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo Config::get('URL', 'gen'); ?>class/edit'">Edit</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>