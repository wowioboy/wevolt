<? 
if ($ItemID == "") {
	$ItemID = $_GET['id'];
}
$db = new DB();
$query = "SELECT * from pf_store_items where id='$ItemID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = stripslashes($line->Title);
	$Description = stripslashes($line->Description);
	$Encrypted = $line->Encrypted;
	$ThumbSm = $line->ThumbSm;
	$ThumbLg = $line->ThumbLg;
	$Thumb50 = $line->Thumb50;
	$Thumb100 = $line->Thumb100;
	$Thumb200 = $line->Thumb200;
	$Thumb400 = $line->Thumb400;
	$Thumb600 = $line->Thumb600;
	$ItemImage = $line->GalleryImage;
	$ThumbCustom = $line->ThumbCustom;
	$Category = $line->Category;
	$Price = $line->Price;
	$ItemNumber = $line->ItemNumber;
	$IsActive = $line->IsActive;
	$IsFeatured = $line->IsFeatured;
	$ItemWeight = $line->ItemWeight;
	$ItemShipping = $line->ItemShipping;
	$ShippingOption =  $line->ShippingOption;
	$InModule = $line->InModule;
}
$catString = "";
	$db = new DB();
	$query = "select * from pf_store_categories order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' class='inputstyle'>";
	while ($line = $db->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		if ($Category == $line->Category) {
			$catString .= "selected";
			$CatID = $line->ID;
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";
	
	$query = "select CategoryThumb from pf_store_categories where id='$CatID'";
	$CategoryThumb = $db->queryUniqueValue($query);
	if ($CategoryThumb == $ItemID) {
		$IsCategoryThumb = 1;
	} else {
		$IsCategoryThumb = 0;
	}
?>
<form method='post' action='admin.php?a=store'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      EDIT STORE ITEM</div>
<input type='submit' name='btnsubmit' value='SAVE ITEM' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE ITEM' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CHANGE IMAGE' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="246" valign="top"  class="contentbox"><div class="spacer"></div>ITEM TITLE:<br />
<input type='text' name='txtTitle' value="<? echo $Title; ?>" /><div class="spacer"></div>

	ITEM CATEGORY<br /> 
	<? echo $catString; ?><div class='spacer'></div><div class="spacer"></div>
ITEM PRICE:<br />

<input type='text' name='txtPrice' value="<? echo $Price; ?>" /><div class="spacer"></div>
ITEM NUMBER:<br />

<input type='text' name='txtNumber' value="<? echo $ItemNumber; ?>" /><div class='spacer'></div>
	WILL THIS ITEM BE SHIPPED? <br />
<input type="radio" name="txtShippingOption" value='2' <? if ($ShippingOption == 2)  { echo 'checked';} ?>/>YES <input type="radio" name="txtShippingOption" value='0' <? if (($ShippingOption == 1) || ($ShippingOption == '')){ echo 'checked';} ?>/>NO<div class='spacer'></div>
ITEM WEIGHT (in lbs):<br />

<input type='text' name='txtWeight' value="<? echo $ItemWeight; ?>" /><br />
SHIPPING RATE:<br />

<input type='text' name='txtShipping' value="<? echo $ItemShipping; ?>" /><div class='spacer'></div><div class='spacer'></div>
PAYPAL BUTTON CODE:<br />Paste the Encrypted code from Paypal into the box<br />
<textarea name='encryptedButton' style="width:100%; height:200px;"><? echo $Encrypted;?></textarea>
</td>	<td width="322" valign="top" class="contentbox"><div class="spacer"></div>
ITEM DESCRIPTION:<br />
<textarea name='txtDescription' class='inputstyle' /><? echo $Description; ?></textarea><div class="spacer"></div>
<div class="spacer"></div>

	<div class='spacer'></div>
	MAKE THIS ITEM THE CATEGORY THUMB?<br />
<input type="radio" name="txtCategoryThumb" value='1' <? if ($IsCategoryThumb == 1) { echo 'checked';} ?>/>YES <input type="radio" name="txtCategoryThumb" value='0' <? if ($IsCategoryThumb == 0) { echo 'checked';} ?>/>NO<div class='spacer'></div>
	MAKE THIS ITEM ACTIVE?<br />
<input type="radio" name="txtActive" value='1' <? if (($IsActive == 1) || ($IsActive == '')) { echo 'checked';} ?>/>YES <input type="radio" name="txtActive" value='0' <? if ($IsActive == 0) { echo 'checked';} ?>/>NO<div class='spacer'></div>
	FEATURE ITEM ON FRONT PAGE?<br />
<input type="radio" name="txtFeatured" value='1' <? if ($IsFeatured == 1)  { echo 'checked';} ?>/>YES <input type="radio" name="txtFeatured" value='0' <? if (($IsFeatured == 0) || ($IsFeatured == '')){ echo 'checked';} ?>/>NO<div class='spacer'></div>
	SHOW THIS ITEM IN THE STORE MODULE?<br />
<input type="radio" name="txtInModule" value='1' <? if ($InModule == 1) { echo 'checked';} ?>/>YES <input type="radio" name="txtInModule" value='0' <? if ($InModule == 0) { echo 'checked';} ?>/>NO
</td>
   </tr>
    <tr>
    <td colspan="3"  valign="top" class="contentbox"><strong>SYSTEM THUMBS </strong>
      <div class="spacer"></div>
<? if (($ThumbSm != "") && ($ThumbSm != "none")) { ?>
SMALL THUMB:: <br /> 
<img src='<? echo $ThumbSm; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>
<? if (($ThumbLg != "") && ($ThumbLg != "none")) { ?>
LARGE THUMB: <br /> 
<img src='<? echo $ThumbLg; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($ItemImage != "") && ($ItemImage != "none")) { ?>
ITEM IMAGE: <br /> 
<img src='<? echo $ItemImage; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>
<strong>USER THUMBS</strong><br />

<? if (($Thumb50 != "") && ($Thumb50 != "none")) { ?>
50 WIDE: <br /> 
<img src='<? echo $Thumb50; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb100 != "") && ($Thumb100 != "none")) { ?> 
100 WIDE: <br />
<img src='<? echo $Thumb100; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb200 != "") && ($Thumb200 != "none")) { ?> 
200 WIDE: <br />
<img src='<? echo $Thumb200; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb400 != "") && ($Thumb400 != "none")) { ?> 
400 WIDE: <br />
<img src='<? echo $Thumb400; ?>' border='1'/>
<div class="spacer"></div>
<? } ?>

<? if (($Thumb600 != "") && ($Thumb600 != "none")) { ?> 
600 WIDE: <br />
<img src='<? echo $Thumb600; ?>' border='1'/>
<div class="spacer"></div>
<? } ?>

<? if (($ThumbCustom != "") && ($ThumbCustom != "none")) { ?> 
CUSTOM THUMB<br />
<img src='<? echo $ThumbCustom; ?>' border='1'/>
<div class="spacer"></div>
<? } ?></td>

   </tr>
   </table></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type='hidden' name='txtItem' value='<? echo $ItemID; ?>' />
<input type='hidden' name='sub' value='item' />
</form>