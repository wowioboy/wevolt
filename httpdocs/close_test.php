<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>clsoe test</title>
<script type="text/javascript" src="http://users.wevolt.com/scripts/global_functions.js"></script>
<script type="text/javascript" src="http://users.wevolt.com/shadowbox/shadowbox.js"></script>
<link rel="stylesheet" type="text/css" href="http://users.wevolt.com/shadowbox/shadowbox.css">
<script type="text/javascript">
function edit_window(windowid,type,action,section){


    // open a welcome message as soon as the window loads
	//alert('http://www.wevolt.com/connectors/update_window_myvolt.php?window='+windowid+'&stype='+type+'&section='+section+'&action='+action);
  Shadowbox.open({
       content: 'http://users.wevolt.com/connectors/update_window_myvolt.php?window='+windowid+'&stype='+type+'&section='+section+'&action='+action,
      player:     "iframe",
       title:      "",
     height:     660,
     width:      385
    });

 
};
</script>
</head>

<body>
<a href="#" onclick="edit_window('Module5-4e732ced34631a','ref','add','myvolt');hide_layer('4e732ced34631a_menu', event);">add item</a>

<script type="text/javascript">
Shadowbox.init({
    // let's skip the automatic setup because we don't have any
    // properly configured link elements on the page
    skipSetup: false,
	modal: true,
	overlayColor: "#000",
	overlayOpacity: 0.3,

    // include the html player because we want to display some html content
    players: ["iframe","img","html","swf"]
});

</script> 
</body>
</html>
