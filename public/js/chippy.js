var context = document.getElementById('canvas').getContext("2d");
var img = new Image();
img.src = "http://ec.l.thumbs.canstockphoto.com/canstock6369486.jpg";

img.onload = function () {
    context.drawImage(img, 616, 340);
    console.log(img);
};