/*
var context = document.getElementById('canvas').getContext("2d");

var chippyIMG = new Image();
chippyIMG.src = imgFolder + "chippy.png";
chippyIMG.onload = function () {
    context.drawImage(chippyIMG, 580, 330);
};

var bubbleIMG = new Image();
bubbleIMG.src = imgFolder + "speechBubble.png";
bubbleIMG.onload = function () {
    context.drawImage(bubbleIMG, 400, 180);
};
*/

var chippyHTML = "<div id='chippyImg'><img src='" + imgFolder + "chippy.png'></div>";
chippyHTML += "<div id='speechBubbleImg'><img src='" + imgFolder + "speechBubble.png'></div>";
chippyHTML += "<div id='speechBubble'>Welcome!</div>";

$("#chippyHolder").html(chippyHTML);