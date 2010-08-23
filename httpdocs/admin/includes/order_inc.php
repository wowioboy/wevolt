<script type="text/javascript">
function cancel() {
window.location ='/admin.php?a=orders';

}
</script>
<? 
include_once('./class/storeitemattribute.php');

$OrderID = $_GET['orderid'];
if (!isset($OrderID)) 
	$OrderID = $_POST['orderid'];
$ItemID = $_GET['id'];
if (!isset($ItemID))
	$ItemID = $_POST['id'];
	 
$db = new DB();

$query = "SELECT o.*, oi.ID, od_status, oi.Complete, oi.od_numids, p.ID AS ProductID, p.ProductCode, p.Price, p.ShortTitle, pi.ThumbSm, oi.ct_coupon from tbl_order AS o JOIN tbl_order_item AS oi ON oi.od_id = o.od_id JOIN pf_store_items AS p ON oi.pd_id = p.ID JOIN pf_store_images AS pi ON p.id = pi.ItemID where oi.ID=$ItemID and o.od_id=$OrderID";
$db->query($query);
$line = $db->fetchNextObject();	
$orderitemid = $line->ID;
?>

<form name="form1" method='post' action='admin.php?a=order'>
<input type="hidden" name="page" id="page" value="" />
<input type="hidden" name="id" id="id" value="<? echo $ItemID; ?>" />
<table width='100%' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td id='contenttop'>&nbsp;</td>

    <td id='contenttopright'>&nbsp;</td>

  </tr>

  <tr>

    <td id="contentleftside"></td>

    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>
      ORDERS<div style="height:7px;"></div><input type="button" value="BACK" id='submitstyle' onclick="cancel();"></div>
   </td>

<td class='adminContent' valign="top"><table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td width="100px"><img src="<? echo $line->ThumbSm; ?>" /></td>
				<td><? echo $line->ShortTitle; ?></td>
			</tr>
		</table>
		<hr /><br />
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="5"><b>STATUS/COMMENTS</b></td>
			</tr>
			<tr>
				<td class='tableheader'>STATUS</td>
				<td class='tableheader'>SHIPPING METHOD</td>
				<td class='tableheader'>TRACKING CODE</td>
				<td class='tableheader'>COMMENT</td>
				<td class='tableheader'>DATE</td>
			</tr>
			<? $db2 = new DB();
				$db2->query("select * from tbl_order_item_shipping where orderitemid=$orderitemid");
				while ($line2 = $db2->fetchNextObject()) { ?>
					<tr>
						<td><? switch($line2->complete)
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
							} ?></td>
						<td><? echo $line2->shippingmethod; ?></td>
						<td><? echo $line2->trackingcode; ?></td>
						<td><? echo $line2->comment; ?></td>
						<td><? echo $line2->creationdate; ?></td>
					</tr>
			<?	}
			   $db2->close();
			?>
		</table>
		<hr /><br /><br />
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td class='tableheader' width="200px" style="border-right:#0099FF 1px solid;">OrderID</td>
				<td class="listcell"><? echo $line->od_id ?>-<? echo $line->ID ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="border-right:#0099FF 1px solid;">Product Code</td>
				<td class="listcell"><? echo $line->ProductCode ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="border-right:#0099FF 1px solid;">Posted Date</td>
				<td class="listcell"><? echo $line->od_last_update ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="border-right:#0099FF 1px solid;">Status</td>
				<td class="listcell"><? switch(	$line->Complete)
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
					} ?></td>
			</tr>
			<tr>
				<td class='tableheader'style="border-right:#0099FF 1px solid;">Coupon</td>
				<td class="listcell"><? echo $line->ct_coupon ?></td>
			</tr>
	  <tr>
				<td class='tableheader' style="border-right:#0099FF 1px solid;">Total order Paid:</td>
				<td class="listcell"> <? echo $line->od_total_cost ?></td>
			</tr>
			<tr>
				<td class='tableheader' style="border-right:#0099FF 1px solid;">Shipping Cost:</td>
				<td class="listcell"><? echo $line->od_shipping_cost ?></td>
			</tr>
		</table>
<div class="spacer"></div>
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td style="font-size: 14px; font-weight: bold">SHIPPING INFORMATION</td>
		  </tr>
			<tr>
				<td>
					<table width='100%' cellpadding='0' cellspacing='0' border='0'>
						<tr>
							<td width="19%" class='tableheader' style="border-right:#0099FF 1px solid;">FIRST NAME:</td>
						  <td width="81%" class="listcell"><? echo $line->od_shipping_first_name ?></td>
					  </tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">LAST NAME:</td>
							<td class="listcell"><? echo $line->od_shipping_last_name ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">ADDRESS:</td>
							<td class="listcell"><? echo $line->od_shipping_address1 ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;"></td>
							<td class="listcell"><? echo $line->od_shipping_address2 ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">CITY:</td>
							<td class="listcell"><? echo $line->od_shipping_city ?></td>
						</tr>
						<tr>
							<td class='tableheader'style="border-right:#0099FF 1px solid;">STATE:</td>
							<td class="listcell"><? echo $line->od_shipping_state ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">ZIP CODE:</td>
							<td class="listcell"><? echo $line->od_shipping_postal_code ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">PHONE:</td>
							<td class="listcell"><? echo $line->od_shipping_phone ?></td>
						</tr>
						<tr>
							<td class='tableheader' style="border-right:#0099FF 1px solid;">EMAIL:</td>
							<td class="listcell"><? echo $line->od_shipping_email ?></td>
						</tr>
					</table>
				</td>
				
			</tr>
		</table>

		<br />
        <div id="inputform">
		<form action="#" method="POST">
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="2" style="font-size: 14px; font-weight: bold">SET STATUS OR SHIPPING AND TRACKING INFORMATION</td>
			</tr>
			<tr>
				<td class='tableheader'>Status:</td>
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
				<td class='tableheader'>Shipping Method:</td>
				<td><input type="text" name="txtShippingMethod" /></td>
			</tr>
			<tr>
				<td class='tableheader'>Tracking Code:</td>
				<td><input type="text" name="txtTrackingCode" /></td>
			</tr>
			<tr>
				<td class='tableheader'>Comment:</td>
				<td><textarea name="txtTrackingComment" cols="60" rows="10"></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="btnSubmit" value="SAVE" /></td>
			</tr>
		</table>
		</form>
        </div>
		<br />
		<br />
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="2" style="font-size: 14px; font-weight: bold">ITEMS IN CURRENT ORDER</td>
			</tr><tr>
				<td class='tableheader'>ID</td>
				<td class='tableheader'>STATUS</td>
				<td class='tableheader'>ITEM</td>
				<td class='tableheader'>QTY</td>
			</tr>
			<? $db->query("select oi.id, oi.complete, si.shorttitle, oi.od_qty from tbl_order_item AS oi JOIN pf_store_items AS si ON si.id= oi.pd_id where oi.od_id=$orderid and oi.id!=$orderitemid");
				while ($line = $db->fetchNextObject()) { ?>
					<tr>
						<td><a href="/admin.php?a=order&orderid=<? echo $orderid;?>&id=<? echo $line->id; ?>"><? echo $orderid . '-'. $line->id; ?></a></td>
						<td><? switch($line->complete)
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
							} ?></td>
						<td><? echo $line->shorttitle; ?></td>
						<td><? echo $line->od_qty; ?></td>
					</tr>
			<?	}
			   $db->close();
			?>
		</table>
		<br />
		<br />
		<table width='100%' cellpadding='0' cellspacing='0' border='0'>
			<tr>
				<td colspan="2" style="font-size: 14px; font-weight: bold">OTHER ORDER FOR MEMBER</td>
			</tr><tr>
				<td class='tableheader'>ID</td>
				<td class='tableheader'>STATUS</td>
				<td class='tableheader'>ITEM</td>
				<td class='tableheader'>QTY</td>				
			</tr>
			<? $db->query("select userid from user_orders where orderid=$orderid");
			$line = $db->fetchNextObject();	
			$useridtemp = $line->userid;
			if ($useridtemp == '')
				$useridtemp = 0;
			$db->query("select ua.orderid, oi.id, oi.complete, si.shorttitle, oi.od_qty 
						from tbl_order_item AS oi 
						JOIN pf_store_items AS si ON si.id= oi.pd_id 
						JOIN user_orders AS ua ON oi.od_id=ua.orderid 
						where oi.od_id!=$orderid and ua.userid=$useridtemp
						order by ua.orderid DESC");
				while ($line = $db->fetchNextObject()) { ?>
					<tr>
						<td><a href="/admin.php?a=order&orderid=<? echo $line->orderid;?>&id=<? echo $line->id; ?>"><? echo $line->orderid . '-'. $line->id; ?></a></td>
						<td><? switch($line->complete)
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
							} ?></td>
						<td><? echo $line->shorttitle; ?></td>
						<td><? echo $line->od_qty; ?></td>
					</tr>
			<?	}
			   $db->close();
			?>
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

</form>

