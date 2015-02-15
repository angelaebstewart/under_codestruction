  <div id="contentArea">
    <div class="contentDivision"> 

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="create-class">
        <div class="panel panel-default">
            <div class="panel-heading">Create a class</div>
            <div class="panel-body">
                <form action="#">
                    <input id="classTitle" pattern=".{5,}" required name="classTitle" type="text" placeholder="Class Title" class="form-control" >                
                    <input id="classPwd" pattern=".{5,10}" required name="password" type="password" placeholder="Class Password" class="form-control" >
                    <button id="createClassBtn" class="btn btn-lg btn-primary btn-block" type="submit">Create Class</button>
                </form>
            </div>
        </div>
    </div>
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
     <script src="<?php echo Config::get('URL','gen'); ?>js/newClass.js"></script>
