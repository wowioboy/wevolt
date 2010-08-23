<? 
include_once("includes/init.php");
$Pagetracking = 'client'; 
$PageTitle = 'Client'; 
$AppSet = 0; 
if (!isset($_SESSION['usertype'])) {
header("location:login.php");
}
$UserID = $_SESSION['id'];
if ($_POST['btnSubmit'] == 'SAVE')
{
	$ShippingFirstName = $_POST['txtFirstName'];
	$ShippingLastName = $_POST['txtLastname'];
	$ShippingStreet = $_POST['txtAddress'];
	$ShippingStreet2 = $_POST['txtAddress2'];
	$ShippingCity = $_POST['txtCity'];
	$ShippingState = $_POST['txtState'];
	$ShippingZip = $_POST['txtZip'];
	$ShippingPhone = $_POST['txtPhone'];		
	if ($ShippingStreet == '')
		$Message .= ' - Street Address<br />';
	if ($ShippingCity == '')
		$Message .= ' - City<br />';
	if ($ShippingState == '') 
		$Message .= ' - State<br />';
	if ($ShippingZip == '')
		$Message .= ' - Zip<br />';
	
	if ($Message == '')
	{
		$query = "UPDATE users ";
		$query .= "SET ShippingStreet1='"  . mysql_real_escape_string($_POST['txtAddress']) . "', ";
		$query .= "ShippingStreet2='"  . mysql_real_escape_string($_POST['txtAddress2']) . "', ";
		$query .= "ShippingCity='"  . mysql_real_escape_string($_POST['txtCity']) . "', ";
		$query .= "ShippingState='"  . mysql_real_escape_string($_POST['txtState']) . "', ";
		$query .= "ShippingZip='"  . mysql_real_escape_string($_POST['txtZip']) . "', ";
		$query .= "ShippingFirstName='"  . mysql_real_escape_string($_POST['txtFirstName']) . "', ";
		$query .= "ShippingLastName='"  . mysql_real_escape_string($_POST['txtLastName']) . "', ";
		$query .= "ShippingPhone='"  . mysql_real_escape_string($_POST['txtPhone']) . "' ";
		$query .= "WHERE ID=$UserID";
		$ClientDB = new DB();
		$ClientDB->execute($query); 
		$ClientDB->close();
		header("location:/client.php?m=Shipping+information+saved++successfully."); 
	}	
	else
		$Message =  'The following are invalid:<br />' . $Message;
}
else
{
	$ClientDB = new DB();
	$query = "SELECT * from users where ID='$UserID'";
	$ClientArray = $ClientDB->queryUniqueObject($query);
	$ShippingFirstName = $ClientArray->ShippingFirstName;
	$ShippingLastName = $ClientArray->ShippingLastName;
	$ShippingStreet1 = $ClientArray->ShippingStreet1;
	$ShippingStreet2 = $ClientArray->ShippingStreet2;
	$ShippingCity = $ClientArray->ShippingCity;
	$ShippingState = $ClientArray->ShippingState;
	$ShippingZip= $ClientArray->ShippingZip;
	$ShippingPhone= $ClientArray->ShippingPhone;
	$ClientDB->close();

}
?>
<?php include 'includes/header.php'; ?>

<script type="text/javascript" src="js/validation.js"></script>
<!-- <script type="text/javascript" src="js/simpleCart.js"></script> 
<script type="text/javascript">
	simpleCart = new cart("nationalemergenyid");
</script>-->
<table width="<? echo $SiteWidth;?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td bgcolor="#FFFFFF">
<div class="contentwrapper" style="background-image:url(images/content_bg.jpg);padding-top:5px; padding-left:5px; padding-right:5px;">
<table width='761' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="11" id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td width="574" id='contenttop'><? if ($Message != '') { ?>
<font color="red"><b><? echo $Message; ?></b></font>
	<? } ?></td>

    <td width="18" id='contenttopright'>&nbsp;</td>
  </tr>

  <tr>

    <td height="235" id="contentleftside"></td>

    <td width="158" valign="top" >
<div align="left">
 <? include 'includes/client_menu.php';?>
</div></td>

    <td colspan="2" valign="top" class='adminContent' style="padding-left:10px;padding-right:10px; text-align:left;">
    <div class="bluesectionheader">SHIPPING CHILDREN</div><div class='spacer'></div>
    <form method="post" action="shipping_info.php" name='accountform'>
      <table cellpadding="0" cellspacing="0" border="0" width="80%">
	
    <tr>
    <td class="inputtext">First Name</td>
    <td class="inputcell"><input type="text" name='txtFirstName' value="<? echo $ShippingFirstName;?>" class="inputstyle" /> </td>
    </tr>
     <tr>
    <td class="inputtext">Last Name</td>
    <td class="inputcell"><input type="text" name='txtLastName' value="<? echo $ShippingLastName;?>" class="inputstyle" /> </td>
    </tr>
     <tr>
    <td class="inputtext">Street Address1</td>
    <td class="inputcell"><input type="text" name='txtAddress' value="<? echo $ShippingStreet1;?>" class="inputstyle" /> </td>
    </tr>
     <tr>
    <td class="inputtext">Street Address2</td>
    <td class="inputcell"><input type="text" name='txtAddress2' value="<? echo $ShippingStreet2;?>" class="inputstyle" /> </td>
    </tr>
     <tr>
    <td class="inputtext">City</td>
    <td class="inputcell"><input type="text" name='txtCity' value="<? echo $ShippingCity;?>" class="inputstyle" /> </td>
    </tr>
    <tr>
    <td class="inputtext">State</td>
    <td class="inputcell"><input type="text" name='txtState' value="<? echo $ShippingState;?>" class="inputstyle" style="width:25px;" size="2" maxlength="2" /> &nbsp;&nbsp;<span class='inputtextExtra'>Zip</span><input type="text" name='txtZip' value="<? echo $ShippingZip;?>" class="inputstyle" style="width:50px;" /></td>
    </tr>
	 <tr>
    <td class="inputtext">Phone</td>
    <td class="inputcell"><input type="text" name='txtPhone' value="<? echo $ShippingPhone;?>" class="inputstyle" /> </td>
    </tr>
      <tr>
    <td class="inputtext"></td>
    <td class="inputcell">    <input type="submit" value="SAVE" name='btnSubmit'/>&nbsp;<input type="button" value="CANCEL" name='btnCancel' onclick="location.href='/client.php';"/></td>
    </tr>
    </table>

    </form></td>
    </tr>

  <tr>

    <td id='contentbottomleft'>&nbsp;</td>

    <td id='sidebottom'>&nbsp;</td>

    <td id='contentbottom'>&nbsp;</td>

    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
</div>

	</td>
 	</tr>
  	<tr>
    <td id="footer">&nbsp;</td>
  	</tr>
</table>
<?php include 'includes/footer.php'; ?>	