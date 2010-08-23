<html>
<head>
<title>boom</title>
<link rel="stylesheet" href="css/jquery.contextMenu.css" />
<script src="js/jquery-1.4.2.min.js"></script>
<script src="js/jquery.contextMenu.js"></script>
<script>
$(document).ready(function(){
	$('#boombox').contextMenu({
		menu: 'myMenu',
		leftClick: true
	});	
});
</script>
</head>
<body>
<ul id="myMenu">
    <li class="edit">
        <a href="#edit">Edit</a>
    </li>
    <li class="cut separator">
        <a href="#archives">Archives</a>
    </li>
    <li class="copy">
        <a href="#copy">Copy</a>
    </li>
    <li class="paste">
        <a href="#paste">Paste</a>
    </li>
    <li class="delete">
        <a href="#delete">Delete</a>
    </li>
    <li class="quit separator">
        <a href="#quit">Quit</a>
    </li>
</ul>
<div id="boombox" style="background-color:#000;height:50px;width:50px;"></div>
</body>
</html>