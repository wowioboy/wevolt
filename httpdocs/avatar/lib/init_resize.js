function scaleIt(v, originalWidth) {
  var scalePhoto = $('theImage');
  v = originalWidth * (v/100);
  scalePhoto.style.width = Math.floor(v) + 'px';
}

function saveChange() {
  var theWidth = $('theImage').style.width;
  theWidth = theWidth.substring(0,(theWidth.length-2));
  $('resizeWidth').value = theWidth;
}

function initSlider() {
  new Control.Slider('resizeHandle','resizeTrack', { 
    axis:'horizontal', 
    range:$R(20,200), 
    sliderValue:100,
    onSlide: function(v) { scaleIt(v, $('cropWidth').value); },
    onChange: function(v) { saveChange(); }      
  });
}

Event.observe(window, 'load', function() { initSlider() });