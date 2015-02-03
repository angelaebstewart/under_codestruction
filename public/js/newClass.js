function addStudent() {

    var fnInputBox = document.getElementById('fnInput');
    var firstNameValue = fnInputBox.value;
    fnInputBox.value = '';

    var lnInputBox = document.getElementById('lnInput');
    var lastNameValue = lnInputBox.value;
    lnInputBox.value = '';

    var emInputBox = document.getElementById('emInput');
    var emValue = emInputBox.value;
    emInputBox.value = '';


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
    document.getElementById("studentList").appendChild(tablerow);

}