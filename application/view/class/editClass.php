<div id="contentArea">
    <div class="contentDivision"> 
        <div class="class-list-edit">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Class Edit</h3>
                </div>
                <div class="panel-body">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student's Name</th>
                                <th><button type="button" class="btn btn-xs btn-danger" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add</button></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Student 1</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Student 2</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Student 3</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Student 4</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Student 5</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Student 6</td>
                                <td><button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(this)">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="add-student-class">
                <div class="panel panel-default">
                    <div class="panel-heading">Add students to class</div>
                    <div class="panel-body">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody id="studentList">
                                    <tr>
                                        <td><input id="fnInput" required pattern=".{1,}" name="first_name" type="text" placeholder="First Name" class="form-control" ></td>
                                        <td><input id="lnInput" required pattern=".{1,}" name="last_name" type="text" placeholder="Last Name" class="form-control" ></td>
                                        <td><input id="emInput" required pattern=".{1,}" name="e_mail" type="text" placeholder="E-mail" class="form-control" ></td>
                                        <td><button id="addStudentBtn" class="btn btn-small btn-primary btn-block" type="submit" onclick="addStudent()">+</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo Config::get('URL', 'gen'); ?>js/student.js"></script>
    <script src="<?php echo Config::get('URL', 'gen'); ?>js/newClass.js"></script>