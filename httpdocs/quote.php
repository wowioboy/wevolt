<?php include 'includes/init.php';
$PageTitle = ' | Print on Demand Quote';


if ($_GET['a'] == 'calc') {
		$CoverType = $_POST['txtCover'];
		$Interiors = $_POST['txtInteriors'];
		$Pages = $_POST['txtPages'];
		$Quanity = $_POST['txtNumber'];
		
		//print 'COVER = ' . $CoverType.'<br/>';
		//print 'Interiors = ' . $Interiors.'<br/>';
		//print 'Pages = ' . $Pages.'<br/>';
		//print 'Quanity = ' . $Quanity.'<br/>';
		//STAPLED
		$Binding = '.31';
		
		//PERFECT
		//$Binding = 1.44;
		
		if ($Pages > 12)
			$ColorRate = .38;
		else 
			$ColorRate = .42;
		//print 'ColorRate = ' . $ColorRate.'<br/>';
		if ($Interiors == 2) {
			
			if ($Pages == 12)
				$PageRate = '.26';
			else if ($Pages == 16)
				$PageRate = '.21';
			else if ($Pages == 16)
				$PageRate = '.21';
			else if ($Pages == 20)
				$PageRate = '.19';
			else if ($Pages >= 24)
				$PageRate = '.16';
		
		} else if ($Interiors == 1) { 
			
			if ($Pages <= 16)
				$PageRate = '.42';
			else
				$PageRate = '.38';		
		
		}
		//print 'PageRate = ' . $PageRate.'<br/>';
		$Calcpages = $Pages / 4;
		//print 'Calcpages = ' . $Calcpages.'<br/>';
		if (($Quanity >= 500) && ($Quanity < 700))
			$QDiscount = .05;
		else if ($Quanity > 700)
			$QDiscount = .075;
		else	
			$QDiscount = '';
			
		$InteriorTotal = $PageRate * $Calcpages;
	//	print 'InteriorTotal = ' . $InteriorTotal.'<br/>';
		$CoverAndInterior = $InteriorTotal + $ColorRate;
		//print 'CoverAndInterior = ' . $CoverAndInterior.'<br/>';
		$EachBound = $CoverAndInterior + $Binding;
		//	print 'EachBound = ' . $EachBound.'<br/>';
		if ($QDiscount != '') {
			$SubTotal = ($Quanity * $EachBound);
			$DiscountTotal = $SubTotal * $QDiscount;
			$ProductionTotal = $SubTotal - $DiscountTotal;
		} else {
			$SubTotal = ($Quanity * $EachBound);
			$ProductionTotal = $SubTotal;
		}
	//	print 'SubTotal = ' . $SubTotal.'<br/>';
			//print 'DiscountTotal = ' . $DiscountTotal.'<br/>';
		//print 'ProductionTotal = ' . $ProductionTotal.'<br/>';
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
<div><img src="/images/content_header_bg.png" /></div>
<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 
	<div class='contentwrapper'>
		<div align="center" style=" padding-left:13px;">
        <form name="printform" id="printform" method="post" action="quote.php?a=calc">
<table cellpadding=5 width=96% align=center>
<tr>
  <td>
  <center>
    <p><span class=huge>Standard-Sized Comics</span><br>
        <span class=title3>Trimmed Size 6.625w X 10.25h*<br />
        </span><br>
        <i>Basic</i> <br>
      Covers printed on 8t Glossy Card Stock<br />
      (10pt available)<br>
      Interiors printed on 60# Offset-white<br>
      <br>
      <br>
      <i>Premium</i><br>
      Covers printed on 10t Glossy Card Stock<br>
      Interiors printed on 70# glossy paper<br>
            <span class=tiny>*Please NOTE:  The dimensions quoted above are the final trimmed size <br>
        and NOT the size at which your files should be sent. </br> 
        For more info please see our <a href=index.php?page=Specs class='tiny' target=_blank>Technical Specifications.</a></span><br>
    </p>
    </center>
  <table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td width=50% valign=middle><b>Title:</b> </td>
    <td width=50% valign=middle><input name="txtComic" type="text" value="<? if (isset($_POST['txtComic'])) echo $_POST['txtComic']; else echo 'Comic Title';?>" size="75" onFocus='clearText(this)'><br><br>
  </td>
  </tr>
    <tr>
    <td width=50% valign=middle>  <b>Cover:</b> </td>

    <td width=50% valign=middle><select name="txtCover"><option value=1 <? if (($_POST['txtCover'] == 1) || ($_POST['txtCover'] == '')) echo 'selected';?>>Full Color- Inside and Out</option><option value=2 <? if ($_POST['txtCover'] == 2)  echo 'selected';?>>Color Outsides / Black &amp; White Insides</option>
	</select><br><br>
    </td>
  </tr>

  <tr>
    <td width=50% valign=middle><b>Interiors:</b> </td>
    <td width=50% valign=middle><select name="txtInteriors" value=1 ><option value=1 <? if (($_POST['txtInterior'] == 1) || ($_POST['txtInterior'] == '')) echo 'selected';?>> Full Color</option><option value=2 <? if (($_POST['txtInterior'] == 2) || ($_POST['txtInterior'] == '')) echo 'selected';?>>Black &amp; White</option>
    </select><br><br>
    </td>
  </tr>

  <tr>
    <td width=50% valign=middle>  <b>Interior Page Count:</b> </td>
    <td width=50% valign=middle><select name="txtPages" onChange='calculate()'><option value="" <? if ($_POST['txtPages'] == '') echo 'selected';?>>--select--</option>
    <option value=8 <? if ($_POST['txtPages'] == 8) echo 'selected';?>>8 pages</option>
    <option value=12 <? if ($_POST['txtPages'] == 12) echo 'selected';?>>12 pages</option>
    <option value=16 <? if ($_POST['txtPages'] == 16) echo 'selected';?>>16 pages</option>
    <option value=20 <? if ($_POST['txtPages'] == 20) echo 'selected';?>>20 pages</option>
    <option value=24 <? if ($_POST['txtPages'] == 24) echo 'selected';?>>24 pages</option>
    <option value=28 <? if ($_POST['txtPages'] == 28) echo 'selected';?>>28 pages</option>
    <option value=32 <? if ($_POST['txtPages'] == 32) echo 'selected';?>>32 pages</option>
    <option value=36 <? if ($_POST['txtPages'] == 36) echo 'selected';?>>36 pages</option>
    <option value=40 <? if ($_POST['txtPages'] == 40) echo 'selected';?>>40 pages</option>
    <option value=44 <? if ($_POST['txtPages'] == 44) echo 'selected';?>>44 pages</option>
    <option value=48 <? if ($_POST['txtPages'] == 48) echo 'selected';?>>48 pages</option>
    <option value=52 <? if ($_POST['txtPages'] == 52) echo 'selected';?>>52 pages</option>

  </select><br><br>
</td>
  </tr>
  <tr>
    <td width=50% valign=middle>  <b>Quantity:</b> </td>
    <td width=50% valign=middle><input name="txtNumber" type="text" size="3" onChange='calculate()' value="<? if ($_POST['txtNumber'] == '') echo '1'; else echo $_POST['txtNumber'];  ?>"><br><br>
  </td>
  </tr>

   <tr><td colspan=2 align=center>  <span class=redtext><i>You can lower your printing costs by adding a full page ad for PanelFlow.com to your comic.<br> 
	<i><a href="print_promo.php" target="blank">Click here to see a low rez version of the Panel Flow Print Ad.</a></span>

  <br><br></td></tr>
  <tr>
    <td width=50% valign=middle><b>Panel Flow Ad:</b></td>
    <td width=50% valign=middle>
    <select name="txtAD" onChange='calculate()'>
    <option value=0 <? if (($_POST['txtAD'] == '') || ($_POST['txtAD'] == '0')) echo 'selected';?>>YES- Back Cover</option>
    <option value=1 <? if ($_POST['txtAD'] == '1') echo 'selected';?>>YES- Inside Back Cover</option>
    <option value=2 <? if ($_POST['txtAD'] == '2') echo 'selected';?>>YES- An Interior Page</option>
    <option value=3 <? if ($_POST['txtAD'] == '3') echo 'selected';?>>NO Ad</option>
  </select><br><br>
    </td>

  </tr>
  <tr>
    <td colspan=2><b>Digital Proof:</b><br><br>
<i>At the time of invoicing we will send you a hyperlink to a Digital PROOF of your book. This Digital Proof is a low resolution version of the printable files adjusted to show the trimmed size. You can use the Digital Proof to check pagination as well as the trims.</i><br><br>
	</td>
  </tr><input name=proof_requested type=hidden value=0>
  </table>
 
  <b>Sub Total</b> <input type=text name=formatted_subtotal size=10 readonly onFocus='this.blur()' value="<? echo $SubTotal;?>"><br>
 <!-- <input type=hidden name=discount value=0><input type=hidden name=formatted_subtotal_discount value=0><br><br>
  <b>Pre-Press Fee</b> <input type=text name=formatted_setup_fee size=20 value='None $0.00' readonly onFocus='this.blur()'><br><br>
  <input type=hidden name=coupon_code value='' size=15><br><br>-->
  <b>Total</b> <input type=text name=formatted_total size=10 readonly onFocus='this.blur()' value="<? echo $ProductionTotal;?>">

  &nbsp;&nbsp;<input type="submit" name="submit" value='Calculate Quote'>
  <br><br>
  <input type=hidden name=this_order value=0>
  <input type=hidden name=reorder value=0>
  <input type=hidden name=catalog value=0>
  <input type=hidden name=file_location value=>
  <input type=hidden name=new value=1>
  <input type=hidden name=first_time value=0>
  <input type=hidden name=setup_fee value=0>

  <input type=hidden name=total><span class=option>You must be <a href='/login/'><u>logged in</u></a> to place an order.</span>

  </center>
  </td>
</tr>
</table>


</form>
		</div>
	</div>
</div>
<div>
<img src="/images/content_footer_bg.png" />

</div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

