<?php 
include 'includes/global_settings_inc.php';
include 'includes/init.php';


include_once("includes/smssend.php");

$sms = new SMSSend();

//$ID = 'bac9162b16c';
$ItemID = $_GET['content'];
if ($ItemID == '')
	$ItemID = $_POST['content'];
$hdnSubmit = $_POST['hdnSubmit'];
$ItemDB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$query = "SELECT * from mobile_content as m
		  join comics as c on m.ComicID=c.comiccrypt
where EncryptID='$ItemID'";
$ItemArray = $ItemDB->queryUniqueObject($query);
$ItemTitle = $ItemArray->Title;
$ItemImage = '/comics/'.$ItemArray->HostedUrl.'/'.$ItemArray->Image;

$ItemDB->close();

if ($hdnSubmit == '1')
{
  $areacode = $_POST['areacode'];
  $prephone = $_POST['prephone'];
  $postphone = $_POST['postphone'];
  $carrier = $_POST['carrier'];
  
  
  if ((!isset($areacode)) || ($areacode == ''))
		$error[] = 'areacode';
  if ((!isset($prephone)) || ($prephone == ''))
		$error[] = 'prephone';
  if ((!isset($postphone)) || ($postphone == ''))
		$error[] = 'postphone';

  if((!is_array($error)) || (!in_array('areacode', $error)))
  {
	if ((!is_numeric($areacode)) || (strlen($areacode) < 3))
		$error[] = 'areacode';
  }	
  
  if((!is_array($error)) || (!in_array('prephone', $error)))
  {
	if ((!is_numeric($prephone)) || (strlen($prephone) < 3))
		$error[] = 'prephone';
  }	
  
  if((!is_array($error)) || (!in_array('postphone', $error)))
  {
	if ((!is_numeric($postphone)) || (strlen($postphone) < 4))
		$error[] = 'postphone';
  }	
  
  if (!is_array($error))
  {
	  if (isset($areacode))
	  {
		$result = $sms->Send($carrier, $areacode . $prephone . $postphone, 'Your Wallpaper Request', 'Click here to download:  http://m.panelflow.com/get.php?clid=' . $ItemID . '-' . $carrier);
		
		if ($result != 'SUCCESS')
		{
			$error[] = 'carrier';
		}
		else
		{
			header("Location: /sendcomplete.php");
		}
	  }
  }
}


$PageTitle = 'wevolt | send to mobile' . $ItemTitle;
$TrackPage = 1;
?>

<?php include 'includes/header_template_new.php'; ?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">

    
 
<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
<? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
		<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;">
			<? include 'includes/site_menu_popup_inc.php';?>
		</td> 
	<? } else {?>
<td width="<? echo $SideMenuWidth;?>" valign="top">
	<? include 'includes/site_menu_inc.php';?>
</td> 
<? }?>

<td  valign="top" align="center"><? if ($_SESSION['noads'] != 1) {?><iframe src="http://www.wevolt.com/includes/top_banner_inc.php" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no"></iframe> <? }?>

    <? ?>
<table width="750" border="0" cellpadding="0" cellspacing="0" height="">
                  <tbody>
                    <tr>
                      <td id="modtopleft"></td>
                      <td id="modtop" width="738" align="left">WEVOLT MOBILE</td>
                          
                      <td id="modtopright" align="right" valign="top"></td>
                    </tr>
                    <tr>
                      <td colspan="3" valign="top" style="padding-left:3px; padding-right:3px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td id="modleftside"></td>
                              <td class="boxcontent">
 <table width="100%" cellspacing="0" cellpadding="0">
           <tr>
            <td width="309" valign="top" style="padding-left:10px;"><div align="left"><span class='warning'><? echo $ItemTitle;?></span></div>
<img src="<? echo $ItemImage;?>" width='300' height='300' style="border:2px solid #FF9900;" vspace='2'/>              </td>
            <td width="402" valign="top"> <form action="/send_to_mobile.php" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td colspan="2" class='sectionheader' style="padding:5px;"><div class="pageheader">SEND TO YOUR PHONE</div>Note: Not all devices are supported, also you will not be able to download content to your iphone/ipod...yet. </td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<? if (is_array($error)) { ?>
			<tr>
				<td colspan="2"><div style="border:  thin #000000 solid; background-color: #CCCCCC">
				   <font weight="bold" size="3px" color="red">!</font><font weight="bold" size="3px">Please Check Information</font>
				   <br/>Some required fields were incorrect or not completed. Invalid fields are marked with a (<strong>!</strong>) below.
				  </div>				</td>
			</tr>
		  <? } ?>
					<tr>
				<td width="16%">&nbsp;</td>
			    <td width="84%"><strong>Enter Your Phone Number: <br />
			    </strong>Format (555-555-5555)</td>
		    </tr>
			<tr>
				<td>&nbsp;</td>
			    <td><input type="text" name="areacode" size="3" maxlength="3"  onKeyPress="return number(event)"  value="<? echo $areacode; ?>" />&nbsp;-
							<input type="text" name="prephone" size="3" maxlength="3"  onKeyPress="return number(event)" value="<? echo $prephone; ?>" />&nbsp;-
							<input type="text" name="postphone" size="4" maxlength="4"  onKeyPress="return number(event)" value="<? echo $postphone; ?>" /><? if (is_array($error) && (in_array('areacode', $error) || in_array('prephone', $error) || in_array('postphone', $error))) { echo '&nbsp;&nbsp;<font weight="bold" size="5px" color="red">!</font>'; } ?></td>
		    </tr>
               <tr>
				<td>&nbsp;</td>
		      <td>&nbsp;</td>
		    </tr>
			<tr>
				<td><br />
      				  <br /></td>
			    <td><strong>Select Your Carrier </strong><br /></td>
		    </tr>
			<tr id="trCarriers">
				<td>&nbsp;</td>
			    <td>Carrier:  <select name="carrier">
					<?
					$Carriers = $sms->GetCarriers();
					for ($i=0; $i<sizeof($Carriers); $i++)
					{
					  list($name, $server, $port, $length) = split('[|]', $Carriers[$i]);
					  echo "<option value='$i'";
					  if ($carrier == $i)
						echo " selected";
					  echo ">$name</option>";
					}
					?>
					</select><? if (is_array($error) && (in_array('carrier', $error))) { echo '&nbsp;&nbsp;<font weight="bold" size="5px" color="red">!</font>'; } ?>	</td>
		    </tr>
            <tr>
				<td>&nbsp;</td>
		      <td>&nbsp;</td>
		    </tr>
			<tr>
				<td><input type="hidden" name="hdnSubmit" value="1"  /><br /><input type="hidden" name="content" value="<? echo $_GET['content'];?>"  />
                </td>
			    <td><? if ($_SESSION['userid'] == '') {?> You must first log in to send content<? } else {?><input type="image" name="btnSend" value="Send"  src="/images/send.gif" style="border:none;"/><? }?></td>
		    </tr>
		</table>
	  </form></td>
	        </tr>
		</table> 
           </td>
                              <td id="modrightside"></td>
                            </tr>
                            <tr>
                      <td id="modbottomleft"></td>
                      <td id="modbottom"></td>
                      <td id="modbottomright"></td>
                    </tr>
                          </tbody>
                      </table>


    
 	</td>
	
</tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>



