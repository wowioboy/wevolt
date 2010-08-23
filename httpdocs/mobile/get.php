<?php 
include_once("mobileheader.php"); 
//include_once("includes/user.php"); 
include_once("includes/wapprofile.php");
include_once("includes/imagehelper.php");

if ($ID == "")
	$ID = $_GET['id'];
if ($Carrier == "")	
	$Carrier = $_GET['cid'];
$SID = $_GET["clid"];
if ($SID != '')
{
	$arrID = split('-', $SID);
	if (sizeof($arrID) == 2)
	{
		$ID = $arrID[0];
		$Carrier = $arrID[1];		
	}
}

$valid = false;

if (($ID != '') && ($Carrier != '')){
	$valid = true;
	
		
	$Profile = $_SERVER["HTTP_X_WAP_PROFILE"];
	if ($Profile == '')
	  $Profile = $_SERVER["HTTP_PROFILE"];
	  
	$WAPProfile = new WAPProfile($_SERVER["HTTP_USER_AGENT"], $Profile);
	$WAPProfile->Load();
	$contenttype = 1;
	 
	  
	//if ($UserID != '') 
	//{
	//  $User = new User();
	 // if ($Carrier == '')
	//	  $Carrier = $User->GetMobileCarrier($UserID);  
	//}
	
	$ReturnPage = $_GET['rtrnpg'];
	if ($ReturnPage == '')
	  $ReturnPage = $_POST['rtrnpg'];
	$ReturnName = $_GET['rtrnnm'];
	if ($ReturnName == '')
	  $ReturnName = $_POST['rtrnnm'];
	
	$ReturnParam = "id=$ID&amp;rtrnpg=" . urlencode($ReturnPage) . "&amp;rtrnnm=" . urlencode($ReturnName);
	
	$URL = '';
	if ($UserID == '') {
	  $URL = "/login.php?pg=" . urlencode("get.php?id=$ID&rtrnpg=" . urlencode($ReturnPage) . "&rtrnnm=$ReturnName");
	} else {
		switch ($contenttype) {
		  case '1':
		  case '2':
			$URL = "/download.php?id=$ID&amp;cid=$Carrier";
			break;
		  case '3':
		  case '4':
		  case '5':
		  default: 
			//if (($WAPProfile->AcceptsMP3) || ($WAPProfile->AcceptsMPEG))
			  $URL = "/download.php?id=$ID&amp;cid=$Carrier";
			//else
			//  $URL = "";
			break;
		}
	} 
}
?>
<?php include_once("pagetop.php"); ?>
<? if ((!$IsWML) && ($valid)){ ?>
    <p>Title:&nbsp;<? echo $title; ?><br/>
      Creator:&nbsp;<? echo $artist; ?><br/>
   </p>
	 <a href="<? echo $URL; ?>"><img src="/images/getitnow.gif" alt="Get It Now" /></a>
<? } else if ($IsWML) { ?>
	<p>Your phone is unsupported.  We apologize for any inconvience this may cause.</p>
<? } else { ?>
	<p>The wallpaper requested cannot be determined.  Please verify the url enter is correct and please try again.</p>
<? } ?>   
<p class="copyright">Copyright&copy; 2008<br />Panel Flow</p>
     </body>
  </html>
