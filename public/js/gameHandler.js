function check(inValue, idIn) {
    if (inValue !== 'right') {
        alert(inValue);
        document.getElementById(idIn).selectedIndex = 0;
    }
}

function validateForm(elem) {
    for(var i = 0; i < elem.length; i++) {
        if (elem[i].value==='Please make a selection.') {
               alert("Answer all blanks before moving on.");
               return false;
        }
    }
    return true;
}

function getNextGamePage() {
    var data = {
        gameID : gameID,
        nextPage : pageID+1
    };
    $.ajax({
        type: "POST",
        url: loadGamePageURL,
        data: data,
        error: function () {alert("error");}
    })
    .done(function( data ) {
        data = $.parseJSON(data);

        if (data.finished === "1") {
            $("#gameDiv").html(data.pageData);
        } else {
            $("#gameDiv").html(data.pageData);
            pageID++;

            $("#questions").submit(function(e) {
                e.preventDefault();

                if (validateForm($("#questions")[0].elements)) {
                    getNextGamePage();
                    $("#gameDiv").html("Loading...");
                }
            });
        }
    });
}