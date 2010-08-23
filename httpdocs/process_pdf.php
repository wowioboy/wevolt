<? 
include 'includes/init.php';
include '../includes/image_resizer.php';
include '../classes/class_dirtool.php';
include '../includes/signup_data_inc.php';
$ID = $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
		header("location:login.php?ref=/create/pdf/");
}
$UserID = $_SESSION['userid'];
$UserDB = new DB($db_database,$db_host, $db_user, $db_pass);
if (isset($_POST['saveinfo'])) {
	$FirstName = mysql_real_escape_string($_POST['txtFirstName']);
	$LastName = mysql_real_escape_string($_POST['txtLastName']);
	$PayPalEmail = mysql_real_escape_string($_POST['txtEmail']);
	$StreetAddress = mysql_real_escape_string($_POST['txtStreet1']);
	$StreetAddress2 = mysql_real_escape_string($_POST['txtStreet2']);
	$City = mysql_real_escape_string($_POST['city']);
	$State = mysql_real_escape_string($_POST['state']);
	$Zip = mysql_real_escape_string($_POST['zip']);
	$HomePhone = mysql_real_escape_string($_POST['phone']);
$query ="INSERT into users_data (UserID, FirstName, LastName, PayPalEmail, StreetAddress, StreetAddress2, City, State, Zip, HomePhone, Agreed) value ('$UserID','$FirstName','$LastName','$PayPalEmail','$StreetAddress','$StreetAddress2', '$City','$State','$Zip','$HomePhone',1)";
$UserDB->query($query);

}

if ((!isset($_POST['creditscomplete'])) && ($_POST['txtInfoClicked'] == 0))  {
	$UserInfoComplete = 0;
} else {
$query ="SELECT * from users_data where UserID='$UserID'";
$UserInfoArray = $UserDB->queryUniqueObject($query);
$PayPalEmail = $UserInfoArray->PayPalEmail;
	if ($PayPalEmail == '') {
		$UserInfoComplete = 0;
	} else {
		$UserInfoComplete = 1;
	}
}
$UserDB->close();
if (((isset($_POST['creditscomplete'])) || ($_POST['txtInfoClicked'] == 1)) && ($UserInfoComplete == 1)) {

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

if ($_POST['txtSize'] == 'comic') {
	if ($_POST['txtLayout'] == 'p') {
		$PageSize = array(11.11,16.86);
	} else {
		$PageSize = array(16.86,11.11);
	}
} else if ($_POST['txtSize'] == 'digest') {
	if ($_POST['txtLayout'] == 'p') {
		$PageSize = array(5.5,8.25);
	} else {
		$PageSize = array(8.25,5.5);
	}
}

// set document information
$pdf->setPageOrientation($_POST['txtLayout']);
$pdf->setPageFormat($PageSize);
$pdf->SetAuthor($_POST['txtAuthor']);
$pdf->SetTitle($_POST['txtTitle']);
$pdf->SetSubject($_POST['txtSubject']);
$pdf->SetKeywords($_POST['txtKeywords']);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setPrintHeader(false);

//set auto page breaks
$pdf->SetAutoPageBreak(FALSE);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
$pdf->setLanguageArray($l);  
//set some language-dependent strings
//$Directory = $_POST['tempdir'];
$PageList = explode('||',$_POST['txtPages']);
$Directory = $_POST['tempdir'];
$Count = 1;
foreach ($PageList as $Image) {
// add a page
$pdf->AddPage();
if ($Count == 1) {
	$CoverImage = $Image;
}
// set JPEG qualiy
$pdf->setJPEGQuality(100);
// Image example
list($width,$height)=getimagesize($Image);
//$pdf->Image('../images/image_demo.jpg', 50, 50, 100, 150, '', 'http://www.tcpdf.org', '', true, 150);
$pdf->Image($Image, 0, .33, 0, 0, '', '', 'LTR', true, 72,'C',false);
$Count++;
}

$Filename = '../imported/temp/'.$Directory.'/'.$Directory.'.pdf';
$PdfFileName = $Directory.'.pdf';
$TotalPages = $pdf->getNumPages();
$pdf->Output($Filename, 'F'); 
$User = trim($_SESSION['username']);

/// INSERT INTO DATABASE aND STORE FILE IN PRODUCT
if(!is_dir("../users/".$User."/pdfs")) mkdir("../users/".$User."/pdfs", 0777);
if(!is_dir("../users/".$User."/pdfs/thumbs")) mkdir("../users/".$User."/pdfs/thumbs", 0777);
	copy($Filename, "../users/".$User."/pdfs/".$PdfFileName);
	chmod("../users/".$User."/pdfs/".$PdfFileName,0777);
	$PDFFILE = "../users/".$User."/pdfs/".$PdfFileName;
$FilenameArray = explode('.',$PdfFileName);
$ThumbFileName = $FilenameArray[0];

$image = new imageResizer($CoverImage);

$Thumbsm = '../users/'.$User.'/pdfs/thumbs/'.$ThumbFileName.'_sm.jpg';
$image->resize(100, 100,100, 100);
$image->save($Thumbsm, JPG);
chmod($Thumbsm,0777);

$Thumbmd = '../users/'.$User.'/pdfs/thumbs/'.$ThumbFileName.'_md.jpg';
$image->resize(200, 300,200, 300);
$image->save($Thumbmd, JPG);
chmod($Thumbmd,0777);

$Thumblg = '../users/'.$User.'/pdfs/thumbs/'.$ThumbFileName.'_lg.jpg';
$image->resize(300, 450,300, 450);
$image->save($Thumblg, JPG);
chmod($Thumblg,0777);
	
$Title = mysql_real_escape_string($_POST['txtTitle']);
$Subject = mysql_real_escape_string($_POST['txtSubject']);
$Keywords = mysql_real_escape_string($_POST['txtKeywords']);
$Published = $_POST['txtPost'];
$Price = $_POST['txtPrice'];
$Author = mysql_real_escape_string($_POST['txtAuthor']);
$PDFsize = $_POST['txtSize'];
$PDFlayout = $_POST['txtLayout'];
$PDFDB = new DB($db_database,$db_host, $db_user, $db_pass);
if ($_POST['txtEdit'] != 1) {

$query ="INSERT into products (ComicID, UserID,Title,Description, Keywords, ThumbSm, ThumbMd, ThumbLg,IsDigital,ProductType,ProductFile,Price,Published) values('".$_GET['comicid']."','".$_SESSION['userid']."','$Title','$Subject','$Keywords','$Thumbsm','$Thumbmd','$Thumblg',1,'pdf','$PDFFILE','$Price','$Published')";
$PDFDB->query($query);

$query ="SELECT ID from products where ProductFile='$PDFFILE'";
$ProductID = $PDFDB->queryUniqueValue($query);

$Encryptid = substr(md5($PageID), 0, 8).dechex($PageID);

$query = "UPDATE products SET EncryptID='$Encryptid' WHERE ID='$ProductID'";
$PDFDB->query($query);

$query ="INSERT into products_attributes_pdf (Title, Author,Subject,Tags, ProductID,  Size, Layout, Pages) values('$Title','$Author','$Subject','$Keywords','$Encryptid','$PDFsize','$PDFlayout','$Count')";
$PDFDB->query($query);
} else {
$EncryptID = $_POST['txtProductID'];
$query ="UPDATE products set Title='$Title', Description='$Subject', Keywords='$Keywords', ThumbSm='$Thumbsm', ThumbMd='$Thumbmd', ThumbLg='$Thumblg',ProductFile='$PDFFILE',Price='$Price',Published='$Published' where EncryptID='$EncryptID'";
$PDFDB->query($query);

$query ="UPDATE products_attributes_pdf set Title='$Title', Author='$Author',Subject='$Subject',Tags='$Keywords', Size='$PDFsize', Layout='$PDFlayout',Pages='$Count' where ProductID ='$EncryptID'";
$PDFDB->query($query);

}
$Today = date('d-m-Y');
$query ="UPDATE products_incomplete set Finished=1, FinishedDate='$Today', ProductID='$Encryptid' where TempDirectory='$Directory'";
$PDFDB->query($query);
$PDFDB->close();
$dir = new dirtool("./imported/temp/".$Directory);
$dir->delete();
if ($_POST['txtPost'] == 1) {

$PdfString = '<div style="padding-left:40px;padding-right:30px;">
<div class="pageheader">Download your PDF below</div>
<div class="spacer"></div> 
This product will also be shown in the product listing <a href="products.php?s=pdf">HERE</a>. You can edit this PDF selecting the PRODUCTS tab in your profile. <div class="spacer"></div>If you have the Products listing turned on in your Panel Flow Comic Admistration, then this product will also appear in the products module on your comic. <div class="spacer"></div><div align="center"><a href="'.$PDFFILE.'" target="_blank"><img src="images/pdf_big.jpg" border="0"/></a></div></div>';

} else {
$PdfString = '<div style="padding-left:40px;padding-right:30px;">
<div class="pageheader">Download your PDF below. </div>
<div class="spacer"></div> You can edit this PDF selecting the PRODUCTS tab in your profile.
<div class="spacer"></div>
If you have the Products listing turned on in your Panel Flow Comic Admistration, then this product will also appear in the products module on your comic. <div class="spacer"></div><div align="center"><a href="/'.$PDFFILE.'" target="_blank"><img src="/images/pdf_big.jpg" border="0"/></a></div></div>';

}
} else if (((isset($_POST['creditscomplete'])) || ($_POST['txtInfoClicked'] == 1)) && ($UserInfoComplete == 0)) {
$StepTitle = ' Step 2 - Enter Seller Information';

} else {
$StepTitle = ' Step 1 - Enter E-BOOK Credits';
$PdfDB = new DB($db_database,$db_host, $db_user, $db_pass);

if ($_POST['txtEdit'] != 1) {
$query = "SELECT * from comics where comiccrypt ='".$_GET['comicid']."'";
$ComicArray = $PdfDB->queryUniqueObject($query);
$ComicTitle = stripslashes($ComicArray->title);
$CreatorID = $ComicArray->CreatorID;
$ComicTags = stripslashes($ComicArray->tags);
$Synopsis = stripslashes($ComicArray->synopsis);
$Genre = $ComicArray->genre;
$Artist = $ComicArray->artist;
$Writer = $ComicArray->writer;
$Creator = $ComicArray->creator;
} else {
$query = "SELECT * from products where EncryptID ='".$_POST['txtProductID']."'";
$ProductArray = $PdfDB->queryUniqueObject($query);
$Published = stripslashes($ProductArray->Published);
$Price = stripslashes($ProductArray->Price);

$query = "SELECT * from products_attributes_pdf where EncryptID ='".$_POST['txtProductID']."'";
$PDFattArray = $PdfDB->queryUniqueObject($query);
$Genre = stripslashes($PDFattArray->Subject);
$Creator = stripslashes($PDFattArray->Author);
$Size = $PDFattArray->Size;
$Layout = $PDFattArray->Layout;
$ComicTags = stripslashes($PDFattArray->Tags);
$Genre = stripslashes($PDFattArray->Subject);

}
 $PdfDB->close();
} 
$PageTitle = 'PROCESS PDF';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<? echo $SiteDescription;?>"></meta>
<meta name="keywords" content="<? echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?> |<? echo $StepTitle;?> </title>
<script type="text/javascript">
function isValidEmail(strEmail){

  validRegExp = /^[^@]+@[^@]+.[a-z]{2,}$/i;
  strEmail = document.forms[0].txtEmail.value;

   // search email text for regular exp matches
    if (strEmail.search(validRegExp) == -1) 
   {
   
      return false;
    } 
    return true; 
}
function isZip(s) 
{
     reZip = new RegExp(/(^\d{5}$)|(^\d{5}-\d{4}$)/);

     if (!reZip.test(s)) {
         return false;
     }

return true;
}

function show_pricing() {
	document.getElementById("pricingdiv").style.display = '';
}

function hide_pricing() {
	document.getElementById("pricingdiv").style.display = 'none';
}

function hide_price_input() {
	document.getElementById("priceinputdiv").style.display = 'none';

}

function show_price_input() {
	document.getElementById("priceinputdiv").style.display = '';

}

function finish_pdf() {
	document.CreditForm.submit();
}

function check_form() {
var FormValid = 1;
	if ( document.InfoForm.txtFirstName.value == "" ) {
		document.getElementById("fnamespan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
		
	} else {
		document.getElementById("fnamespan").innerHTML ='';
	}
	if ( document.InfoForm.txtLastName.value == "" ) {
		document.getElementById("lnamespan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	} else {
		document.getElementById("lnamespan").innerHTML ='';
	}
	if ( document.InfoForm.txtEmail.value == "" ) {
		document.getElementById("emailspan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	} else if (!isValidEmail(document.InfoForm.txtEmail.value)) {
		
		document.getElementById("emailspan").innerHTML ='<font color="red">**** Not A Valid Email</font>';
		FormValid = 0;
	} else {
		document.getElementById("emailspan").innerHTML ='';
	}
	if ( document.InfoForm.txtStreet1.value == "" ) {
		document.getElementById("streetspan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	} else {
		document.getElementById("streetspan").innerHTML ='';
	}
	if ( document.InfoForm.city.value == "" ) {
		document.getElementById("cityspan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	} else {
		document.getElementById("cityspan").innerHTML ='';
	}
	if ( document.InfoForm.zip.value == "" ) {
		document.getElementById("zipspan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	} else if (!isZip(document.InfoForm.zip.value)) {
		document.getElementById("zipspan").innerHTML ='<font color="red">**** Not A Valid Zip</font>';
		FormValid = 0;
	}else {
		document.getElementById("zipspan").innerHTML ='';
	}
	if ( document.InfoForm.phone.value == "" ) {
		document.getElementById("phonespan").innerHTML ='<font color="red">****</font>';
		FormValid = 0;
	}else {
		document.getElementById("phonespan").innerHTML ='';
	}
	if ( document.InfoForm.agreed.checked == false ) {
		document.getElementById("agreespan").innerHTML ='<br/><font color="red">****You Must Agree to Terms</font>';
		FormValid = 0;
	}else {
		document.getElementById("agreespan").innerHTML ='';
	}
	if (FormValid == 1) {
	document.InfoForm.submit();
	
	}
	

}
</script>

</head> 

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<?
if (((isset($_POST['creditscomplete']))  || ($_POST['txtInfoClicked'] == 1)) && ($UserInfoComplete == 1)) {
echo $PdfString;
}else  if (((isset($_POST['creditscomplete'])) || ($_POST['txtInfoClicked'] == 1)) && ($UserInfoComplete == 0)) {?>
<div style="padding-left:40px; padding-right:25px;"> 
<form method="post" action="process_pdf.php?comicid=<? echo $_GET['comicid'];?>" name="InfoForm" id="InfoForm">
<div class="pageheader"> Enter all your Seller Information below. All fields are required</div>
<div class="spacer"></div>
When you are finished click here -> <input type="button" value="SAVE INFO" onClick="check_form();" style="background-color:#FF9900;"/>

<div class="spacer"></div>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="203"><b>FIRST NAME: </b></td>
<td width="445"><input type="text" style="width:300px;" name="txtFirstName" id="txtFirstName"/><span id="fnamespan"></span></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>LAST NAME</strong> </td>
<td><input type="text" style="width:300px;" name="txtLastName" id="txtLastName"/><span id="lnamespan"></span></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>PAYPAL EMAIL :</strong> </td>
<td><input type="text" style="width:300px;" name="txtEmail" id="txtEmail"/><span id="emailspan"></span></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>STREET ADDRESS: </strong></td>
<td><input type="text" style="width:300px;" name="txtStreet1" id="txtStreet1"/><span id="streetspan"></span></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>(APT/SUITE/UNIT): </strong></td>
<td><input type="text" style="width:300px;" name="txtStreet2" /></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
  <tr>
	 <td class="form_text"><b>CITY</b></td>

     <td><input name="city" type="text" id="city" size="30"><span id="cityspan"></span></td>
    </tr>
    <tr><td colspan="2" height="10"></td></tr>
    <tr>
	 <td class="form_text"><b>STATE</b></td>
     
      <td><SELECT ID='state' NAME='state' STYLE='WIDTH:200px;'>
          <? if ($state != '') { echo str_replace($state . '"', $branchState . '" selected', $StateString); } else { echo $StateString;} ?> ; ?>
        </SELECT></td>
    </tr>
    <tr><td colspan="2" height="10"></td></tr>
    <tr>
	 <td class="form_text"><b>ZIP CODE</b></td>
   
      <td style="padding-top:3px;"><input name="zip" type="text" class="form_field" id="zip" value="<? echo $zip; ?>" size="5" maxlength="5" ><span id="zipspan"></span></td>
    </tr>
    <tr><td colspan="2" height="10"></td></tr>
     <tr>
	 <td class="form_text"><b>PHONE NUMBER</b></td>
   
      <td style="padding-top:3px;"><input name="phone" type="text"  id="phone" size="20" maxlength="10" ><span id="phonespan"></span></td>
    </tr>
      <tr>
	 <td class="form_text"><b>SELLER AGREEMENT</b></td>
   
      <td style="padding-top:3px;"><input name="agreed" type="checkbox" id="agreed" <? if ($Agreed == 1) echo 'checked';?>>
      Check here if you agree to the Seller Terms Below:<span id="agreespan"></span></td>
    </tr>
     <tr>
	 <td class="form_text"></td>
   
      <td style="padding-top:3px;">I agree to allow PanelFlow.com sell and distribute my PDF through this website. I understand I will recieve payments through my PayPal account when purchases are made. Panel Flow will keep 10% of the selling price for processing fees after a PDF has been successfully purchased.  </td>
    </tr>
    
   <input type="hidden" name="tempdir" value="<? echo $_POST['tempdir'];?>" >
   <input type="hidden" name="txtPages" value="<? echo $_POST['txtPages'];?>" id='txtPages'>
   <input type="hidden" name="txtEdit" value="<? echo $_POST['txtEdit'];?>" />
<input type="hidden" name="txtProductID" value="<? echo $_POST['txtProductID'];?>" />
<input type="hidden" name="txtSize" value="<? echo $_POST['txtSize'];?>" />
<input type="hidden" name="txtLayout" value="<? echo $_POST['txtLayout'];?>" />
<input type="hidden" name="txtAuthor" value="<? echo $_POST['txtAuthor'];?>" />
<input type="hidden" name="txtTitle" value="<? echo $_POST['txtTitle'];?>" />
<input type="hidden" name="txtSubject" value="<? echo $_POST['txtSubject'];?>" />
<input type="hidden" name="txtKeywords" value="<? echo $_POST['txtKeywords'];?>" />
<input type="hidden" name="saveinfo" value="1" />
<input type="hidden" value="<? echo $_POST['txtInfoClicked'];?>" name="txtInfoClicked" id="txtInfoClicked"/>
 <input type="hidden" value="1" name="creditscomplete" />

 </table>
 </form>

</div>

<? } else { ?>
<div style="padding-left:40px; padding-right:25px;"> 
<form method="post" action="process_pdf.php?comicid=<? echo $_GET['comicid'];?>" name="CreditForm" id="CreditForm">
<div class="pageheader"> Enter your PDF's Credits/Information</div>
<div class="spacer"></div>
When you are finished click here -> <input type="button" value="CREATE PDF" onClick="finish_pdf();" style="background-color:#FF9900;"/>

<div class="spacer"></div>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="88"><b>CREATOR: </b></td>
<td width="488"><input type="text" style="width:300px;" name="txtAuthor" value="<? echo stripslashes($Creator);?>"/></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>TITLE:</strong> </td>
<td><input type="text" style="width:300px;" name="txtTitle" value="<? echo $ComicTitle;?>"/></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>SUBJECT:</strong> </td>
<td><textarea name="txtSubject" style="width:300px;"><? echo $Genre;?></textarea></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>KEYWORDS: </strong></td>
<td><textarea name="txtKeywords" style="width:300px;"><? echo $ComicTags;?></textarea></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
 <tr>
<td><strong>PDF LAYOUT:</strong> </td>
<td><select name="txtLayout">
<option value='p' <? if ($Layout =='p') echo 'selected';?>>Portrait</option>
<option value="l" <? if ($Layout =='l') echo 'selected';?>>Landscape</option></select></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
 <tr>
<td><strong>PDF SIZE:</strong> </td>
<td>
<select name="txtSize">
<option value='comic' <? if ($Layout =='comic') echo 'selected';?>>Standard Comic</option>
<option value="digest" <? if ($Layout =='digest') echo 'selected';?>>Digest Size</option>
</select></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
<tr>
<td colspan="2" height="10">Do you want to post this PDF to the Panel Flow Products list? : <input type="radio"  name="txtPost" value="1" <? if (($Published == 1) || ($Published == '')) echo 'checked';?> onClick="show_pricing();"/>Yes &nbsp;<input type="radio"  name="txtPost" value="0" onClick="hide_pricing();" <? if ($Published == 0) echo 'checked';?> />No &nbsp;
<div id='pricingdiv' <? if ($Published == 0) {?>style="display:none;"<? }?>>
   <div class="spacer"></div>
  Would you like to offer this PDF for sale? : <input type="radio"  name="txtPricing" value="1" <? if ($Price != '') echo 'checked'; ?>onClick="show_price_input()"/>Yes &nbsp;<input type="radio"  name="txtPricing" value="0" <? if ($Price == '') echo 'checked'; ?>  onClick="hide_price_input()"/>No (Free)&nbsp;
  
  <div id="priceinputdiv" <? if ($Published == 0) {?>style="display:none;"<? }?>>
  Enter The Amount you would like to charge to download this E-Book: <input type="text"  style="width:100px;" name="txtPrice"  value="<? echo $Price;?>"/>
  <br /><br />

 <b> ***In order to sell products on PanelFlow.com, you will need to have filled out the Seller data and have an active Paypal account. If you have not filled out the Seller data, you will be prompted to do so on the next page. </b> </div>
   
   </div></td></tr> 
   <input type="hidden" name="tempdir" value="<? echo $_POST['tempdir'];?>" >
   <input type="hidden" name="txtPages" value="<? echo $_POST['txtPages'];?>" id='txtPages'>
   <input type="hidden" name="txtEdit" value="<? echo $_POST['txtEdit'];?>" />
<input type="hidden" name="txtProductID" value="<? echo $_POST['txtProductID'];?>" />
 <input type="hidden" value="1" name="creditscomplete" />
 <input type="hidden" value="1" name="txtInfoClicked" id="txtInfoClicked"/>
 </table>
 </form>

</div>
<? }?>




  </div>
  <?php include 'includes/footer_v2.php';?>

</body>
</html>