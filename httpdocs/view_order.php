<? 
include 'includes/init.php';?>
<script type="text/javascript">
function cancel() {
window.location ='/store/orders/';

}
</script>
<? 

$OrderID = $_GET['orderid'];
if (!isset($OrderID)) 
	$OrderID = $_POST['orderid'];
$ItemID = $_GET['id'];
if (!isset($ItemID))
	$ItemID = $_POST['id'];

if ($_POST['btnSubmit'] == 'SAVE'){


	$db = new DB();
	
	if ($_POST['txtSelect'] != '0')
	{
		$query = 'update tbl_order_item set Complete = ' . $_POST['txtSelect'] . ' where id = \'' . $_POST['id'].'\'';
		$db->query($query);
	}
		
	$query = 'insert tbl_order_item_shipping(orderitemid, complete, shippingmethod, trackingcode, comment, creationdate) values (\'';
	$query .= $_POST['id'] . '\',' . $_POST['txtSelect'] . ",'" . $_POST['txtShippingMethod']  . "','" . $_POST['txtTrackingCode']  . "','"; 	$query .=  mysql_escape_string($_POST['txtTrackingComment']) . "', Now())";
	$db->query($query);
	$db->close(); 
	
	
	include_once 'shippingemail.php';
	header("location:/store/orders/");
}
	 
$db = new DB();

$query = "SELECT o.*,pi.*, oi.ID as OrderItemID, od_status, oi.Complete, oi.od_numids, p.EncryptID AS ProductID, p.ProductCode, p.Price, p.ShippingOption, p.ShortTitle, pi.ThumbSm, oi.ct_coupon from tbl_order AS o JOIN tbl_order_item AS oi ON oi.od_id = o.od_id JOIN pf_store_items AS p ON oi.pd_id = p.EncryptID JOIN pf_store_images AS pi ON p.EncryptID = pi.ItemID where p.EncryptID='$ItemID' and o.od_id='$OrderID'";

$line = $db->queryUniqueObject($query);

$orderitemid = $line->OrderItemID;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?><?php echo $PageTitle; ?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
    <form name="form1" method='post' action='/store/order/?id=<? echo $ItemID; ?>'>
<input type="hidden" name="page" id="page" value="" />
<input type="hidden" name="id" id="id" value="<? echo $orderitemid; ?>" />


<table width='95%' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td id='contenttop'>&nbsp;</td>

    <td id='contenttopright'>&nbsp;</td>

  </tr>

  <tr>

    <td id="contentleftside"></td>

    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      ORDERS<div style="height:7px;"></div><input type="button" value="BACK" id='submitstyle' onClick="cancel();"></div>
   </td>

<td class='adminContent' valign="top" ><table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td width="100"  valign="top"><img src="/<? echo $line->ThumbMd; ?>" /></td>
				<td  valign="top" style="padding-left:10px; padding-right:10px;"><b><? echo $line->ShortTitle; ?></b>
                <table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td class='tableheader' width="123" style="font-size:12px; font-weight:bold;">OrderID</td>
				<td width="196" class="listcell" style="font-size:12px; "><? echo $line->od_id ?>-<? echo $line->OrderItemID; ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Product Code</td>
				<td class="listcell" style="font-size:12px;"><? echo $line->ProductCode ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Posted Date</td>
				<td class="listcell" style="font-size:12px; "><? echo $line->od_date; ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Status</td>
				<td class="listcell" style="font-size:12px; "><? switch($line->Complete)
					{
						case 0:
							echo 'Uncomplete';
							break;
						case 1:
							echo 'Complete';
							break;
						case 2:
							echo 'Processing';
							break;
						case 3:
							echo 'Shipped';
							break;
						case 4:
							echo 'Voided';
							break;
						case 5:
							echo 'Downloaded';
							break;
						case 6:
							echo 'Link Sent';
							break;
					} ?></td>
			</tr>
			
	  <tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Total order Paid:</td>
				<td class="listcell" style="font-size:12px; "> <? echo $line->od_total_cost ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Shipping Cost:</td>
				<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_cost ?></td>
			</tr>
		</table></td>
			</tr>
		</table>
		<div class="spacer"></div>
		<table width='95%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="5"><b>STATUS/COMMENTS</b></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:10px;font-weight:bold;">STATUS</td>
				<td class='tableheader' style="font-size:10px;font-weight:bold;">SHIPPING METHOD</td>
				<td class='tableheader' style="font-size:10px;font-weight:bold;">TRACKING CODE</td>
				<td class='tableheader' style="font-size:10px;font-weight:bold;">COMMENT</td>
				<td class='tableheader' style="font-size:10px;font-weight:bold;">DATE</td>
			</tr>
			<? 
			$db2 = new DB();
			if (($line->Complete == 1) && ($line->ShippingOption == 1)) 
				$db2->execute("update tbl_order_item set Complete = 6 where id = '$orderitemid'");
			
				$db2->execute("update tbl_order set IsRead=1 where od_id='$OrderID'");
				
				$db2->query("select * from tbl_order_item_shipping where orderitemid=$orderitemid");
				
			
				
				while ($line2 = $db2->fetchNextObject()) { ?>
					<tr>
						<td style="font-size:12px;"><? switch($line2->complete)
							{
								case 0:
									echo 'Uncomplete';
									break;
								case 1:
									echo 'Complete';
									break;
								case 2:
									echo 'Processing';
									break;
								case 3:
									echo 'Shipped';
									break;
								case 4:
									echo 'Voided';
									break;
								case 5:
									echo 'Downloaded';
									break;
								case 6:
									echo 'Link Sent';
									break;
							} ?></td>
						<td style="font-size:12px;"><? echo $line2->shippingmethod; ?></td>
						<td style="font-size:12px;"><? echo $line2->trackingcode; ?></td>
						<td style="font-size:12px;"><? echo $line2->comment; ?></td>
						<td style="font-size:12px;"><? echo $line2->creationdate; ?></td>
					</tr>
			<?	}
			   $db2->close();
			?>
		</table><? if ($line->ShippingOption == 0) {?>
		
<div class="spacer"></div>
		<table width='95%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td style="font-size: 14px; font-weight: bold">SHIPPING INFORMATION</td>
		  </tr>
			<tr>
				<td>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr>
							<td width="32%" class='tableheader' style="font-size:12px;">FIRST NAME:</td>
						  <td width="68%" class="listcell" style="font-size:12px;"><? echo $line->od_shipping_first_name ?></td>
					  </tr>
						<tr>
							<td class='tableheader' style="font-size:12px;">LAST NAME:</td>
							<td class="listcell" style="font-size:12px;" ><? echo $line->od_shipping_last_name ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="font-size:12px;">ADDRESS:</td>
							<td class="listcell"style="font-size:12px;"><? echo $line->od_shipping_address1 ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="font-size:12px;"></td>
							<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_address2 ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="font-size:12px;">CITY:</td>
							<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_city ?></td>
						</tr>
						<tr>
							<td class='tableheader'style="font-size:12px;">STATE:</td>
							<td class="listcell"style="font-size:12px;"><? echo $line->od_shipping_state ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="font-size:12px;">ZIP CODE:</td>
							<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_postal_code ?></td>
						</tr>
						<tr>
							<td class='tableheader'style="font-size:12px;">PHONE:</td>
							<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_phone ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="font-size:12px;">EMAIL:</td>
							<td class="listcell" style="font-size:12px;"><? echo $line->od_shipping_email ?></td>
						</tr>
					</table>
				</td>
				
			</tr>
		</table>
<? }?>
		<br />
        <div id="inputform">
		<form action="#" method="POST">
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="2" style="font-size: 14px; font-weight: bold">SET STATUS OR SHIPPING AND TRACKING INFORMATION</td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Status:</td>
				<td><select name="txtSelect">
						<option value="0">-- SET --</option>
						<option value="1">New Order</option>
						<option value="2">Processing</option>
						<option value="3">Shipped</option>
						<option value="4">Voided</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Shipping Method:</td>
				<td><input type="text" name="txtShippingMethod" /></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Tracking Code:</td>
				<td><input type="text" name="txtTrackingCode" /></td>
			</tr>
			<tr>
				<td class='tableheader' style="font-size:12px; font-weight:bold;">Comment:</td>
				<td><textarea name="txtTrackingComment" cols="60" rows="10"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="btnSubmit" value="SAVE" />
                </td>
			</tr>
		</table>
		</form>
        </div>
		</td>

    <td id='contentrightside'>&nbsp;</td>

  </tr>

  <tr>

    <td id='contentbottomleft'>&nbsp;</td>

    <td id='sidebottom'>&nbsp;</td>

    <td id='contentbottom'>&nbsp;</td>

    <td id='contentbottomright'>&nbsp;</td>

  </tr>

</table>

</form>
  </div>
 </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

