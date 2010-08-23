<?php include 'includes/init.php';?>
<?php

if (isset($_POST['add']))
{
	

     // Check if any of the fields are missing
     if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirmpass']))
     {
          // Reshow the form with an error
          $reg_error = 'One or more fields missing';
     }

     // Check if the passwords match
     if (($reg_error == '') && ($_POST['password'] != $_POST['confirmpass']))
     {
          // Reshow the form with an error
          $reg_error = 'Your passwords do not match';
     }

      if ($_POST['admin'] != "1")
        $Usertype = 0;
      else
        $Usertype = 1;
        
     if ($reg_error == '')
     {
       // Everything is ok, register
       if (!user_register ($_POST['name'], $_POST['username'], $_POST['password'], $Usertype ))
       {
            // Reshow the form with an error
            $reg_error = 'A matching username already exists.';
	}
       else
       {
            header( "Location: admin.php?a=users") ;
       }
    }
}

?>

<?php include 'includes/header.php'; ?><style type="text/css">
<!--
body {
	background-color: #303d4b;
}
-->
</style>
<div class="spacer"></div>	
<div class="contentwrapper" align="center">
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="header" bgcolor="#000000" valign="middle" align="center">PANEL FLOW CONTENT MANAGEMENT SYSTEM</td>
  </tr>
  <tr>
    <td id="content" bgcolor="#FFFFFF" style="padding:10px;">
	<div class="contentwrapper">CREATE A NEW USER / CLIENT

	  <div align="center" style="background-color:#000000;">
	    <? 
	echo $msg;
		include 'includes/register_form.inc.php';
	?><div class="spacer"></div>
      </div>
	</div>
</td>
  </tr>
  <tr>
    <td id="footer">&nbsp;</td>
  </tr>
</table>

</div>			
<?php include 'includes/footer.php'; ?>	