<?
include_once("includes/init.php");
include_once('./class/storeitemattribute.php');
include_once('./class/attribute.php');

$ID = $_GET['id'];
if (!isset($ID))
	$ID = $_POST['id'];

$Name = $_POST['txtName'];
$Type = $_POST['txtType'];
$Default = $_POST['txtDefault'];
$IsRequired = $_POST['txtIsRequired'];
if (!isset($IsRequired))
	$IsRequired = 0;

$StoreItemAttribute = new StoreItemAttribute();

$Message = '';
if ($_POST['btnsubmit'] == 'CREATE ATTRIBUTE')
{
	$Attribute = new Attribute();
	if ($Attribute->Create($Name, $Type, $Default, $IsRequired) == 'success')
	{
		die( "<script>window.returnValue = '$Attribute->ID|$Name'; window.close();</script>");    
		//die( "<script>window.opener.location.reload();window.close();</script>");  
	}
	else
		$Message = 'Attribute already exists.  Please rename this attribute';
}
else if ($_POST['btnsubmit'] == 'EDIT ATTRIBUTE')
{
	$Attribute = new Attribute($ID);
	$Attribute->Name = $Name;
	$Attribute->Type = $Type;
	$Attribute->Default = $Default;
	$Attribute->IsRequired = $IsRequired;
	if ($Attribute->Save() == 'success')
	{
		die( "<script>window.returnValue = '$Attribute->ID|$Name'; window.close();</script>");  
		//die( "<script>window.opener.location.reload();window.close();</script>");  
	}
	else
		$Message = 'Attribute already exists.  Please rename this attribute';
}
else if ($ID != '0')
{
	$Attribute = new Attribute($ID);
	$Name = $Attribute->Name;
	$Type = $Attribute->Type;
	$Default = $Attribute->Default;
	$IsRequired = $Attribute->IsRequired;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="css/pf_admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function validate()
	{
	  if (document.getElementById('txtName').value == '') {
	  	alert("You must enter a name for the attribute.");
		return false; 
		}
	 	return true;
	 }
//-->
</script>
</head>
<body>

<div class="wrapper" align="center">
<div class='adminContent'>
<form action="#" method="post" onsubmit="validate();">
	<input type="hidden" name="id" value="<? echo $ID; ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		 <tr>
			<td colspan="2" valign="top"><div class="lgspacer"></div></td>
		 </tr>
		  <tr>
			<td colspan="2" align="center"><strong>ATTRIBUTE INFORMATION</strong></td>
		 </tr>
		  <tr>
			<td colspan="2" align="center">&nbsp;</td>
		 </tr>
		  <tr>
			<td colspan="2" align="center"><font color="red"><? echo $Message ?></font></td>
		 </tr>
		 <tr>
			<td colspan="2" align="center">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="171" valign="top" class="inputtext"> ATTRIBUTE NAME </td>
			<td width="425" valign="top"><input type="text" size="30" maxlength="50" name="txtName" id="txtName" value="<?php echo $Name; ?>"/>
			 <div class="lgspacer"></div></td>
		 </tr>
		
		  <tr>
			 <td valign="top"><div class="medspacer"></div></td>
			 <td valign="top">&nbsp;</td>
			</tr>
		   <tr>
			<td valign="top" class="inputtext"> LIST TYPE </td>
			<td valign="top"> <select name="txtType">
								<option value="0" <? if ($Type == '0') echo 'selected'; ?>>Text</text>
								<option value="1" <? if ($Type == '1') echo 'selected'; ?>>Numeric</text>
								<option value="2" <? if ($Type == '2') echo 'selected'; ?>>Date</text>
								<option value="3" <? if ($Type == '3') echo 'selected'; ?>>Email</text>
								<option value="4" <? if ($Type == '4') echo 'selected'; ?>>Phone</text>	
								<option value="5" <? if ($Type == '5') echo 'selected'; ?>>State</text>	
								<option value="6" <? if ($Type == '6') echo 'selected'; ?>>TextArea</text>	
								<option value="7" <? if ($Type == '7') echo 'selected'; ?>>Height</text>		
								<option value="8" <? if ($Type == '8') echo 'selected'; ?>>Photo</text>	
								<option value="9" <? if ($Type == '9') echo 'selected'; ?>>Sex</text>																																																																																		
							  </select>  
			  <div class="lgspacer"></div></td>
			</tr>
		  <tr>
			 <td valign="top"><div class="medspacer"></div></td>
			 <td valign="top">&nbsp;</td>
			</tr>
		   <tr>
			<td valign="top" class="inputtext"> DEFAULT VALUE</td>
			<td valign="top"> <input type="text" size="30" maxlength="50" name="txtDefault" value="<?php echo $Default; ?>"/>
			  <div class="lgspacer"></div></td>
			</tr>
		  <tr>
			 <td valign="top"><div class="medspacer"></div></td>
			 <td valign="top">&nbsp;</td>
			</tr>
		   <tr>
			<td valign="top" class="inputtext"> IS REQUIRED </td>
			<td valign="top"> <input type="checkbox" name="txtIsRequired" value="1" <? if ($IsRequired == '1') echo 'checked'; ?> />
			  <div class="lgspacer"></div></td>
			</tr>
				<tr>
			<td valign="top" class="inputtext">&nbsp;</td>
			<td colspan="2" valign="top">&nbsp;</td>
			</tr> 
		  <tr>
			<td colspan="2">
			<input type="submit" name="btnsubmit" value="<? if ($ID == '0') echo 'CREATE'; else echo 'EDIT'; ?> ATTRIBUTE" />
			</td>
		  </tr>
	</table>
</form>
</div>
</div>
</body>
</html>
