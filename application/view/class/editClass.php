<div class="container">
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
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Student 1</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Student 2</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Student 3</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Student 4</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Student 5</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                        <tr>
                            <td>Student 6</td>
                            <td><button type="button" class="btn btn-small btn-danger" onclick="alertMsg(this)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
function alertMsg(param){
var result = window.confirm("Are you sure you want to delete this student");
if(result == true){
var row = param.parentElement.parentElement;
row.parentElement.removeChild(row);
}
}
</script>