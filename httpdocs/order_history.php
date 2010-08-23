<? 
include_once("includes/init.php");
$Pagetracking = 'client'; 
$PageTitle = 'Client'; 
$AppSet = 0; 
if (!isset($_SESSION['usertype'])) {
header("location:login.php");
}
$UserID = $_SESSION['id'];
$ClientDB = new DB();
$OrderDB = new DB();
$OrderItemDB = new DB();
$query = "SELECT DISTINCT o.* from user_orders uo
			JOIN tbl_order AS o ON uo.orderid = o.od_id
			JOIN tbl_order_item AS oi ON oi.od_id = o.od_id
		where oi.complete=3 AND	userid='$UserID'";
$OrderString ='<table cellspacing="0" cellpadding="0" border="0">';

$ClientDB->query($query);
while ($OrderArray = $ClientDB->fetchNextObject()) { 
	$OrderID = $OrderArray->od_id;
	//$query = "SELECT * from tbl_order where od_id='$OrderID' and (od_status ='Completed' OR  od_status ='Shipped')";
	//$OrderArray = $OrderDB->queryUniqueObject($query);
	$query = "SELECT * from tbl_order_item where od_id='$OrderID'";
	$OrderDB->query($query);
	$UpdateDay = substr($OrderArray->od_last_update, 5, 2); 
	$UpdateMonth = substr($OrderArray->od_last_update, 8, 2); 
	$UpdateYear = substr($OrderArray->od_last_update, 0, 4);
	$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
	$OrderString .= "<tr><td class='openorder' colspan='2' align='left'><b>Purchase Date : </b>".$Updated."</td><td class='openorder'></td></tr>";
	while ($orderItem = $OrderDB->fetchNextObject()) { 
		$ProductID = $orderItem->pd_id;
		$Quanity = $orderItem->od_qty;
		$query = "SELECT * from pf_store_items where id='$ProductID'";
		$OrderItemArray = $OrderItemDB->queryUniqueObject($query);
		$query = "SELECT * from pf_store_images where IsMain=1 and ItemID='$ProductID'";
		$OrderItemImagesArray = $OrderItemDB->queryUniqueObject($query);
      
		$OrderString .= "<tr><td class='openorder' align='left'><img src='".$OrderItemImagesArray->ThumbSm."' align='left' border='1'></td><td  class='openorder' width='500' valign='top' align='left'>ORDER ITEMS<br/><b>".$OrderItemArray->ShortTitle."</b><div class='smspacer'></div><b>Quanity : </b>".$Quanity."</td><td align='center' class='openorder'></td></tr>";
}
}
$OrderString .= "</table>";
$ClientDB->close();
$OrderDB->close();
$OrderItemDB->close();

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

    <td width="574" id='contenttop'>&nbsp;</td>

    <td width="18" id='contenttopright'>&nbsp;</td>
  </tr>

  <tr>

    <td height="235" id="contentleftside"></td>

    <td width="158" valign="top">
<div align="left">
 <? include 'includes/client_menu.php';?>
</div></td>

    <td colspan="2" valign="top" class='adminContent' style="padding-left:10px;padding-right:10px; text-align:left;">
    <div class="bluesectionheader">ORDER HISTORY</div><div class='spacer'></div>
      <? echo $OrderString;?>        </td>
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

	</td>
 	</tr>
  	<tr>
    <td id="footer">&nbsp;</td>
  	</tr>
</table>
<?php include 'includes/footer.php'; ?>	