function confirmDelete(param) {
var result = window.confirm("Are you sure you want to delete this student?");
    if (result == true) {
        var row = param.parentElement.parentElement;
        row.parentElement.removeChild(row);
    }
}