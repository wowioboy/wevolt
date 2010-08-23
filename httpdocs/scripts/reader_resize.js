function onResize()
{
	var _size = {width:0,height:0};
	
	if(typeof(window.innerWidth) == 'number') 
	{
		_size = {width:window.innerWidth,height:window.innerHeight};
	}
	else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight))
	{
		_size = {width:document.documentElement.clientWidth,height:document.documentElement.clientHeight};
	} 
	else if(document.body && (document.body.clientWidth || document.body.clientHeight))
	{
		_size = {width:document.body.clientWidth,height:document.body.clientHeight};
	}
	
	
	if(_size.width < 300)
	{
		document.getElementById('reader').width = '300';
		document.getElementById('reader').style.width = '300px';
	}
	else
	{
		document.getElementById('reader').width = '100%';
		document.getElementById('reader').style.width = '100%';
	}

	if(_size.height < 300  ) 
	{
		document.getElementById('reader').height = 300;
		document.getElementById('reader').style.height = '300px';
	}
	else
	{
		document.getElementById('reader').height = '100%';
		document.getElementById('reader').style.height = '100%';
	}
}

onResize();

window.onresize = function()
{
	onResize();
}