var fadeTimeoutHandler;

function check(inValue, idIn) {
    if (inValue !== 'right') {
        setChippyText(inValue);
        document.getElementById(idIn).selectedIndex = 0;
    } else {
        setChippyText("Correct!");
    }
}

function validateForm(elem) {
    for(var i = 0; i < elem.length; i++) {
        if (elem[i].value==='Please make a selection.') {
               setChippyText("Answer all blanks before moving on.");
               return false;
        }
    }
    setChippyText("Good job! Let's move on.");
    
    return true;
}

function setChippyText(input) {
    $("#speechBubble").fadeTo(0, 1);
    
    $("#speechBubble").html(input);
    
    clearTimeout(fadeTimeoutHandler);
    fadeTimeoutHandler = setTimeout(function() {
        $("#speechBubble").fadeTo(1000, 0);
    }, 4000);
}

var numBackgroundImages = 0;
function addBackgroundImages() {
    // <image src="<?php echo Config::get('URL','gen'); ?>/images/game/1/1/bg_1.png">
    
    var imagesHTML = "";
    
    if (gameID == 1) {
        if (pageID == 1) numBackgroundImages = 6; // I'm sure there's a better way to do this...
        else if (pageID == 2) numBackgroundImages = 5;
        else if (pageID == 3) numBackgroundImages = 6;
        else if (pageID == 4) numBackgroundImages = 7;
        else numBackgroundImages = 0;
    }
    
    for (var x=1; x<=numBackgroundImages; x++) {
        imagesHTML += "<image id='backgroundImage" + x + "' src='" + imgFolder + "game/" + gameID + "/" + pageID + "/bg_" + x + ".png'>";
    }
    
    $("#backgroundImages").html(imagesHTML);
    
    var x;
    for (x=1; x<=numBackgroundImages; x++) {
        alicejs.slide({
            elems: $("#backgroundImage" + x), 
            move: (x % 2 == 0) ? "up" : "left",
            iteration: 1,
            duration: {
                "value": (300 + 250 * x) + "ms",
                "randomness": "0%",
                "offset": "0ms",
            }
        });
    }
    
    return 300 + 250 * x + 200;
}

function fadeOutBackgroundImages() {
    var x;
    for (x=1; x<=numBackgroundImages; x++) {
        alicejs.slide({
            elems: $("#backgroundImage" + x), 
            move: {direction: (x % 2 == 0) ? "down" : "right", start: 0, end: 1500},
            iteration: 1,
            duration: {
                "value": (300 + 250 * x) + "ms",
                "randomness": "0%",
                "offset": "0ms",
            }
        });
    }
    
    return 300 + 250 * x + 200;
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
                
                var fadeDelay = addBackgroundImages();

                $("#questions").fadeTo(0, 0);
                setTimeout(function() {
                    alicejs.fade({
                        elems: $("#questions"), 
                        fade: "in",
                        iteration: 1,
                        duration: {
                            "value": "300ms",
                            "randomness": "0%",
                            "offset": "0ms",
                        }
                    });
                }, fadeDelay);
                

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
                        
                        var fadeDelay = fadeOutBackgroundImages();
                        setTimeout(getNextGamePage, fadeDelay);
                    }
                });
            }
        }, 1000);
    });
}