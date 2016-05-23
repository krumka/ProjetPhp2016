var canvas;
var context;
var ctx;

function loadCanvas() {
    canvas = document.getElementById("drawingCanvas");
    context = canvas.getContext("2d");
    loadRest();
}
function loadRest(){
    console.log("load");
  $('#colorSelector').ColorPicker({
    color: '#0000ff',
    onShow: function (colpkr) {
      $(colpkr).fadeIn(500);
      return false;
    },
    onHide: function (colpkr) {
      $(colpkr).fadeOut(500);
      return false;
    },
    onChange: function (hsb, hex, rgb) {
      console.log("yo");
      $('#colorSelector div').css('backgroundColor', '#' + hex);
    }
  });
  var canvas = document.getElementById('drawingCanvas');
  var context = canvas.getContext('2d');
  var imageObj = new Image();
  var imageLoader = document.getElementById('imageLoader');
  imageLoader.addEventListener('change', handleImage, false);
  var canvas = document.getElementById('drawingCanvas');
  ctx = canvas.getContext('2d');
    canvas.onmousedown = startDrawing;
    canvas.onmouseup = stopDrawing;
    canvas.onmouseout = stopDrawing;
    canvas.onmousemove = draw;
};
var isDrawing = false;
function startDrawing(e) {
  // Start drawing.
  isDrawing = true;

  // Create a new path (with the current stroke color and stroke thickness).
  context.beginPath();

  // Put the pen down where the mouse is positioned.
  context.moveTo(e.pageX - canvas.offsetLeft, e.pageY - canvas.offsetTop);
}

function stopDrawing() {
  isDrawing = false;
}

function draw(e) {
  if (isDrawing == true) {
    // Find the new position of the mouse.
    var x = e.pageX - canvas.offsetLeft;
    var y = e.pageY - canvas.offsetTop;

    // Draw a line to the new position.
    context.lineTo(x, y);
    context.stroke();
  }
}

// Keep track of the previous clicked <img> element for color.
var previousColorElement;

function changeColor(color, imgElement) {
  // Change the current drawing color.
  context.strokeStyle = color;

  // Give the newly clicked <img> element a new style.
  imgElement.className = "Selected";

  // Return the previously clicked <img> element to its normal state.
  if (previousColorElement != null) previousColorElement.className = "";
  previousColorElement = imgElement;
}

// Keep track of the previous clicked <img> element for thickness.
var previousThicknessElement;

function changeThickness(thickness, imgElement) {
  // Change the current drawing thickness.
  context.lineWidth = thickness;

  // Give the newly clicked <img> element a new style.
  imgElement.className = "Selected";

  // Return the previously clicked <img> element to its normal state.
  if (previousThicknessElement != null) previousThicknessElement.className = "";
  previousThicknessElement = imgElement;
    $("#thicknessShower").css("width", thickness);
    $("#thicknessShower").css("height", thickness);
    $("#thicknessShower").css("border-radius", thickness);
    console.log("changed thickness");
}


function clearCanvas() {
  context.clearRect(0, 0, canvas.width, canvas.height);
}

function saveCanvas() {
  // Find the <img> element.
  var imageCopy = document.getElementById("savedImageCopy");

  // Show the canvas data in the image.
  imageCopy.src = canvas.toDataURL();

  // Unhide the <div> that holds the <img>, so the picture is now visible.
  var imageContainer = document.getElementById("savedCopyContainer");
  imageContainer.style.display = "block";
}
function handleImage(e){
    var reader = new FileReader();
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            var w = img.width;
            var h = img.height;
            var ch = canvas.height;
            var cw = canvas.width;
            if(w>cw){
                h = h/w*cw;
                w = cw;
            }
            if(h>ch){
                w = w/h*ch;
                h = ch;
            }
            var pw = (cw-w)/2;
            var ph = (ch-h)/2;
            ctx.drawImage(img,pw,ph, w, h);
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
}
