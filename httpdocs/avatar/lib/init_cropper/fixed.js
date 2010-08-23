// Credit: Paul
// http://mondaybynoon.com/2007/01/22/crop-resize-with-javascript-php-and-imagemagick/#comment-56103

function onEndCrop( coords, dimensions ) {
  $('cropX').value = coords.x1;
  $('cropY').value = coords.y1;
  $('cropWidth').value = dimensions.width;
  $('cropHeight').value = dimensions.height;
}

Event.observe(window, 'load', function() { 
	new Cropper.Img(
		'cropImage',
		{
			ratioDim: {x: 1,y: 1},
			minWidth: 200, 
			minHeight: 200, 
			maxWidth: 200, 
			maxHeight: 200, 
			displayOnInit: true, 
			onEndCrop: onEndCrop
		}
	);
});