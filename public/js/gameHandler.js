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
        setTimeout(function() {
            data = $.parseJSON(data);

            if (data.finished === "1") {
                $("#gameDiv").html(data.pageData);
                alicejs.fade({
                    elems: $("#gameDiv"), 
                    fade: "in",
                    iteration: 1,
                    duration: {
                        "value": "300ms",
                        "randomness": "0%",
                        "offset": "0ms",
                    }
                });
            } else {
                $("#gameDiv").html(data.pageData);
                pageID++;

                alicejs.toss({
                    elems: $(".gameElement"), 
                    move: "up", 
                    iteration: 1,
                    duration: {
                        "value": "1500ms",
                        "randomness": "20%",
                        "offset": "50ms",
                    }
                });

                $("#questions").submit(function(e) {
                    e.preventDefault();

                    if (validateForm($("#questions")[0].elements)) {
                        alicejs.fade({
                            elems: $(".gameElement"), 
                            fade: "out",
                            iteration: 1,
                            duration: {
                                "value": "300ms",
                                "randomness": "0%",
                                "offset": "0ms",
                            }
                        });

                        getNextGamePage();
                    }
                });
            }
        }, 1000);
    });
}