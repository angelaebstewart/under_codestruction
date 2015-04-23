<script src="<?php echo Config::get('URL', 'gen'); ?>js/student.js"></script>
<script src="<?php echo Config::get('URL', 'gen'); ?>js/newClass.js"></script><div id="contentArea">
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
                            <?php
                            foreach ($this as $key => $value) {
                                $firstName = $value->fname;
                                $lastName = $value->lname;
                                $userID = $value->uid;
                                ?>
                                <tr>
                                    <td><?php echo $firstName." ".$lastName; ?></td>
                                    <td><button type="button" class="btn btn-xs btn-danger" 
                                                class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalPin">Delete</button></th>
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


    <div class="modal fade" id="myModalPin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        
            <div class="enter-pin">
                <div class="panel panel-default">
                    <div class="panel-heading">Enter Pin</div>
                    <div class="panel-body">
                        <div class="row">
                            <table class="table">
                                <tbody id="pin">
                                    <tr>
                                        <td><input id="pinInput" required pattern="^[0-9]{4}$" name="user_pin" type="password" placeholder="Pin" class="form-control" ></td>
                                        <td><button id="enterPinBtn" class="btn btn-small btn-primary btn-block" type="submit" onclick="checkPin(this,<?php echo $userID ?>)">Delete</button></td>
                                        <!--onclick="confirmDeleteStudent(this,<?/php echo $userID ?>)"maxlength ="4"-->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                        <td><input id="fnInput" required pattern="[\u00C0-\u00FFA-Za-z]+" name="first_name" type="text" placeholder="First Name" class="form-control" ></td>
                                        <td><input id="lnInput" required pattern="[\u00C0-\u00FFA-Za-z]+" name="last_name" type="text" placeholder="Last Name" class="form-control" ></td>
                                        <td><input id="emInput" required pattern=".+@.+\..+" name="e_mail" type="text" placeholder="E-mail" class="form-control" ></td>
                                        <td><button id="addStudentBtn" class="btn btn-small btn-primary btn-block" type="submit" onclick="addStudent(<?php echo $_GET['classID'] ?>)">+</button></td>
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


<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>
<script>
function addStudent(classID_in) {

    var fnInputBox = document.getElementById('fnInput');
    var firstNameValue = fnInputBox.value;
    fnInputBox.value = '';

    var lnInputBox = document.getElementById('lnInput');
    var lastNameValue = lnInputBox.value;
    lnInputBox.value = '';

    var emInputBox = document.getElementById('emInput');
    var emValue = emInputBox.value;
    emInputBox.value = '';
    
    /*var passwordInputBox = document.getElementById('passInput');
    var passwordValue = passwordInputBox.value;
    passwordInputBox.value = '';*/


    var tablerow = document.createElement("tr");
    var stndCellFN = document.createElement("td");
    var stndCellLN = document.createElement("td");
    var stndCellEM = document.createElement("td");
    var fnInput = document.createElement("h4");
    var lnInput = document.createElement("h4");
    var emInput = document.createElement("h4");
    var fnTextNode = document.createTextNode(firstNameValue);
    var lnTextNode = document.createTextNode(lastNameValue);
    var emTextNode = document.createTextNode(emValue);
    fnInput.setAttribute("placeholder", "First Name");
    fnInput.appendChild(fnTextNode);
    lnInput.setAttribute("placeholder", "Last Name");
    lnInput.appendChild(lnTextNode);
    emInput.setAttribute("placeholder", "E-mail");
    emInput.appendChild(emTextNode);
    stndCellFN.appendChild(fnInput);
    stndCellLN.appendChild(lnInput);
    stndCellEM.appendChild(emInput);
    tablerow.appendChild(stndCellFN);
    tablerow.appendChild(stndCellLN);
    tablerow.appendChild(stndCellEM);
    
    var data = {
        fname : firstNameValue,
        lname : lastNameValue,
        email : emValue,
        //password : passwordValue,
        classID : classID_in
        };
        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>class/editClassAddStudent_action",
        data: data,
        success: function () {
            document.getElementById("studentList").appendChild(tablerow);
        },
        error: function () {alert("error");}
        });
}



function confirmDeleteStudent(param,studentID_in) {
var result = window.confirm("Are you sure you want to delete this student?");
    if (result == true) {
        deleteStudent(studentID_in);
        var row = param.parentElement.parentElement;
        row.parentElement.removeChild(row);
    }
      
}


// returns True on success, false if error occurs
function checkPin(param,studentID_in) {
        var pinInputBox = document.getElementById('pinInput');
        var pin_in = pinInputBox.value;
        var data = {
        pin : pin_in,
        studentID : studentID_in
        };
        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>class/checkPin_action",
        data: data,
        success: function () {
            //confirmDeleteStudent(param,studentID_in);
            //alert("The method was called");
        },
        error: function () {
            alert("Not so much.");}
        });
        $('#myModalPin').modal('hide');
}

// returns True on success, false if error occurs
function deleteStudent(studentID_in) {
    var data = {
        studentID : studentID_in
        };
        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>class/removeStudent_action",
        data: data,
        success: function () {
            alert("The student was successfully removed from the class.");
        },
        error: function () {
            alert("There was an error deleting this student.");}
        });
}

</script>
