/*
$("#Q1").change(function() {
    do_q1ToIf1();
});

$("#Q2").change(function() {
    do_q2ToIf2();
});

$("#Q3").change(function() {
    do_q3();
});

$("#Q4").change(function() {
    do_q4();
});*/

var isInitialSubmit = true;

function begin() {
    $("select").prop("disabled", true);
    $("#submit").prop("disabled", true);
    
    $("#arrow").toggleClass("flipped", 1).animate({opacity: 1, top:"15px", left:"138px"}, 0, 
        function() {$("#arrow").animate({top:"15px", left:"95px"}, 1000, 
            function() {setTimeout(do_q1ToIf1, 500);}
        )}
    );
}

function do_q1ToIf1() {
    $("#arrow").toggleClass("flipped", 0).animate({top:"53px", left:"100px"}, 0, 
        function() {$("#arrow").animate({top:"53px", left:"363px"}, 2000, 
            function() {
                var answer = $("#Q1")[0].value;
                if (answer === 'right') {
                    setTimeout(do_else1ToQ2, 500);
                } else {
                    setTimeout(do_if1ToFail, 500);
                }
            }
        )}
    );
}

function do_if1ToFail() {
    $("#arrow").animate({top:"82px", left:"490px"}, 0, 
        function() {$("#arrow").animate({top:"82px", left:"595px"}, 1000, 
            function() {
                alert("Question 1 is incorrect. You need to make sure that 'x' is not less than 5.");
                failAssessment();
            }
        )}
    );
}

function do_else1ToQ2() {
    //[110, 360, 1, 1] -> [110, 100, 1, 1]
    $("#arrow").toggleClass("flipped", 1).animate({top:"110px", left:"360px"}, 0, 
        function() {$("#arrow").animate({top:"110px", left:"100px"}, 2000, 
            function() {setTimeout(do_q2ToIf2, 500);}
        )}
    );
}

function do_q2ToIf2() {
    var answer = $("#Q2")[0].value;
    
    if (answer === 'right') {
        setTimeout(do_if2ToWhile, 500);
    } else {
        setTimeout(do_if2ToFail, 500);
    }
}

function do_if2ToFail() {
    $("#arrow").animate({top:"206px", left:"50px"}, 0, 
        function() {$("#arrow").animate({top:"206px", left:"-65px"}, 1000, 
            function() {
                alert("Question 2 is incorrect. You need to make sure that 'y' is less than or equal to -5.");
                failAssessment();
            }
        )}
    );
}

function do_if2ToWhile() {
    $("#arrow").toggleClass("flipped", 0).animate({top:"145px", left:"111px"}, 0, 
        function() {$("#arrow").animate({top:"145px", left:"364px"}, 2000, 
            function() {setTimeout(do_q3, 500);}
        )}
    );
}

function do_q3() {
    var answer = $("#Q3")[0].value;
    
    if (answer === 'right') {
        setTimeout(do_whileToQ4, 500);
    } else {
        do_stuckInWhile(0);
    }
}

function do_stuckInWhile(iterations) {
    if (iterations >= 4) {
        alert("Question 3 is incorrect. 'x' is always going to be greater than or equal to 1, so your program is stuck here forever!");
        failAssessment();
    } else {
        $("#arrow").animate({top:"175px", left:"380px"}, 0);
        setTimeout(function() {
            $("#arrow").animate({top:"145px", left:"364px"}, 0);
            setTimeout(function() {
                do_stuckInWhile(iterations + 1);
            }, 500);
        }, 500);
    }
}

function do_whileToQ4() {
    $("#arrow").toggleClass("flipped", 1).animate({top:"201px", left:"520px"}, 0, 
        function() {$("#arrow").animate({top:"201px", left:"395px"}, 1500, 
            function() {setTimeout(do_q4, 500);}
        )}
    );
}

function do_q4() {
    var answer = $("#Q4")[0].value;
    
    if (answer === 'right') {
        setTimeout(do_q4ToEnd, 500);
    } else {
        setTimeout(do_q4ToFail, 500);
    }
}

function do_q4ToFail() {
    $("#arrow").animate({top:"302px", left:"185px"}, 0, 
        function() {$("#arrow").animate({top:"302px", left:"-65px"}, 2000, 
            function() {
                alert("Question 4 is incorrect. You need to select something that is true about 'y'.");
                failAssessment();
            }
        )}
    );
}

function do_q4ToEnd() {
    $("#arrow").toggleClass("flipped", 0).animate({top:"248px", left:"400px"}, 0, 
        function() {$("#arrow").animate({top:"248px", left:"595px"}, 2000, 
            function() {
                alert("Good job, you passed the assessment!");
                passAssessment();
            }
        )}
    );
}

function failAssessment() {
    $("select").prop("disabled", false);
    $("#submit").prop("disabled", false);
    $("#submit").click();
}

function passAssessment() {
    $("select").prop("disabled", false);
    $("#submit").prop("disabled", false);
    $("#submit").click();
}

$("#questions").submit(function(e) {
    if (isInitialSubmit) {
        e.preventDefault();
        if (validateForm($("#questions")[0].elements)) {
            isInitialSubmit = false;
            begin();
        }
    }
});

function validateForm() {
    var elem = document.getElementById('questions').elements;
    for(var i = 0; i < elem.length; i++) {
        if (elem[i].value==='Please make a selection.') {
            alert("Answer all blanks before submitting.");
            return false;
        }
    }
    return true;
}