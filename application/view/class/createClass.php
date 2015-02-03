<div class="component">
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="create-class">
        <div class="panel panel-default">
            <div class="panel-heading">Create a class</div>
            <div class="panel-body">
                <form action="#">
                <input id="textinput" pattern=".{5,}" name="classTitle" type="text" placeholder="Class Title" class="form-control" >                
                <input id="textinput" pattern=".{5,10}" name="password" type="password" placeholder="Class Password" class="form-control" >
                <button class="btn btn-lg btn-primary btn-block" type="submit">Create Class</button>
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
                                    <td><input id="textinput" pattern=".{0,}" name="first_name" type="text" placeholder="First Name" class="form-control" ></td>
                                    <td><input id="textinput" pattern=".{1,}" name="last_name" type="text" placeholder="Last Name" class="form-control" ></td>
                                    <td><input id="textinput" pattern=".{1,}" name="e_mail" type="text" placeholder="E-mail" class="form-control" ></td>
                                    <td><button class="btn btn-lg btn-primary btn-block" type="submit" onclick="addStudent()">+</button></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        
        <script>            
            function addStudent(){
                
                var tableBody = document.getElementById("studentList");
                var tableRow = tableBody.firstElementChild;
                var tableRowElementCount = tableRow.childElementCount;
                var stndCellFN = tableRow.children[0];
                var fnInputBox = stndCellFN.firstElementChild;
                var firstNameValue = fnInputBox.value;
                fnInputBox.value='';
                var stndCellLN = tableRow.children[1];
                var lnInputBox = stndCellLN.firstElementChild;
                var lastNameValue = lnInputBox.value;
                lnInputBox.value = '';
                var stndCellEM = tableRow.children[2];
                var emInputBox = stndCellEM.firstElementChild;
                var emValue = emInputBox.value;
                emInputBox.value = '';
                
                
            var tablerow = document.createElement("tr");
            var stndCellFN = document.createElement("td"); 
            var stndCellLN = document.createElement("td");
            var stndCellEM = document.createElement("td");
            var fnInput= document.createElement("h4");
            var lnInput= document.createElement("h4");
            var emInput= document.createElement("h4");
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
             document.getElementById("studentList").appendChild(tablerow);
                
            }
        </script>