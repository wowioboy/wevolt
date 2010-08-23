<?
include 'includes/init.php';
 include 'includes/header_template_new.php';?>
<script language="javascript">
var sizeset = 0;

function show_reader() {
if (sizeset = 0) {
window.parent.document.getElementById('reader_div').style.display='block';
window.parent.document.getElementById("readerframe").style.height = '1063px';
}
}
function resize_frame() {
//alert('resize Frame ');
sizeset = 1;
//alert((document.body.scrollHeight+75)+'px');
window.parent.document.getElementById("readerframe").style.height = (document.body.scrollHeight+75)+'px';

}

function open_link(value) {
	if (value != '') {
		if (value == 'synopsis') {
		alert('got here');
			jQuery.facebox('Big Trouble .');
		} else if (value == 'credits') {
			open_content_window('credits','Big_Trouble_In_Little_China');
		} else {
			parent.window.location = value;
		}	
	}

}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
 <select name="sectionSelect" style="height:18px; margin:0px; padding:0px;width:250px;" onChange="open_link(this.options[this.selectedIndex].value);">
               		<option value="">Big Trouble In Little China</option>
              		<option value="http://www.wevolt.com/Big_Trouble_In_Little_China/">Home</option>

                                        <option value="synopsis">Synopsis</option>
                                        
        	   </select>

</body>
</html>
