<? 
include 'includes/init.php';

$Status = $_POST['txtStatus'];
if (!isset($Status))
	$Status = 'completed';
$Page = $_POST['page']; 
if (!isset($Page))
	$Page = 1;
$Coupon = $_POST['txtCoupon'];
$UserID = $_SESSION['userid'];
$Action = $_GET['a'];
$menuString = "";
	
$db = new DB();
$query = "SELECT oi.* , o.* ,pii.*,o.od_total_paid As Price, pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'";
  if ($_GET['a'] != 'archive') {
	$where .= " and " ;
	if ($_POST['txtOrderNum'] != '')
		  $where .= "o.od_id=" . $_POST['txtOrderNum'];
	else
	{
		if($Status == 'shipped')
		  $where .= "  oi.Complete = 3";
		else if($Status == 'processing')
		  $where .= "oi.Complete = 2";
		else if($Status == 'uncomplete')
		  $where .= " oi.Complete = 0";
		else if($Status == 'voided')
		  $where .= " oi.Complete = 4";
		else
		  $where .= " oi.Complete = 1 or o.IsRead=0";
		  
}  
			$FromArray = explode('/',$_POST['fromdate']);
			$ToArray = explode('/',$_POST['todate']);
		if ($_POST['txtName'] != '')
		  $where .= " and (o.od_shipping_last_name='" . mysql_real_escape_string($_POST['txtName']) . "' or o.od_payment_last_name='" . mysql_real_escape_string($_POST['txtName']) . "')";
		if ($_POST['fromdate'] != '')
		  $where .= " and o.od_last_update>='" . $FromArray[2] . '-' . $FromArray[0]  . '-' . $FromArray[1] . " 00:00:00'";
			if ($_POST['dtToYear'] != '')
		  $where .= " and o.od_last_update<='" . $ToArray[2] . '-' . $ToArray[0]  . '-' . $ToArray[1] . " 23:59:59'";
		     
	}

$order .= " order by o.od_date DESC";

if ($_POST['btnSubmit'] == 'EXPORT')
{
	$attribquery = "SELECT DISTINCT sia.AttributeID, a.Name from tbl_order AS o JOIN tbl_order_item AS oi ON oi.od_id = o.od_id JOIN pf_store_items AS p ON oi.pd_id = p.ID JOIN store_item_attributes AS sia ON sia.StoreItemID = p.ID JOIN attribute AS a ON sia.AttributeID = a.ID ";
	$db->query($attribquery . $where . ' order by sia.OrderNumber');
	while ($line = $db->fetchNextObject()) { 
		$arrAttribIDs[] = $line->AttributeID;
		$arrAttribNames[] = $line->Name;		
	} 
	
	header("Content-type: application/csv");
	header("Content-disposition: csv; filename=" . date("m-d-Y") . ".csv");
	$attribcnt = 0;
	print"ORDER_ID,ORDER_TIME,ORDER_STATUS,PAID_AMOUNT,PRODUCT_TOTAL,SHIPPING_AMOUNT,COUPON,PRODUCT_CODE,PRODUCT_NAME,PRICE,QUANTITY,ADDITONAL_IDS";
	foreach ($arrAttribNames as $value) {
		//print ",$value";
		switch($value)
		{
			case 'DOB':
				print ',ATTR_DATE_OF_BIRTH';
				break;
			case 'Medical Condition(s)':
				print ',ATTR_MEDICAL_CONDITIONS';
				break;
			case 'Parent/Guardian/Emergency Name':
				print ',ATTR_EMERGENCY_CONTACT';
				break;
			case 'Emergency Work Phone':
				print ',ATTR_WORK_PHONE';
				break;
			case 'Emergency Cell Phone':
				print ',ATTR_CELL_PHONE';
				break;
			case 'Emergency Phone':
				print ',ATTR_HOME_PHONE';
				break;
			case 'Last Name':
				print ',ATTR_LAST_NAME,ATTR_NAME';
				break;
			default:							
				print ',ATTR_' . strtoupper(str_replace(' ', '_', $value)) ;
				break;
		}
						
		$attribcnt++;
	}
	print "\r\n";
	$db->query($query . $where);
	$db2 = new DB();
	$db3 = new DB();
	
	while ($line = $db->fetchNextObject()) { 
		print '" ' . $line->od_id . "-" . $line->ID . '",';
		print $line->od_last_update . ",";	
		switch(	$line->Complete)
		{
			case 0:
				print 'Uncomplete,';
				break;
			case 1:
				print 'Complete,';
				break;
			case 2:
				print 'Processing,';
				break;
			case 3:
				print 'Shipped,';
				break;
			case 4:
				print 'Voided,';
				break;
		}
		print $line->Price . ",";		
		print $line->od_total_cost . ",";		
		print $line->od_shipping_cost . ",";
		print $line->ct_coupon . ",";
		print $line->ProductCode . ",";
		print $line->ShortTitle . ",";						
		print $line->Price . ",";	
		print $line->od_qty . ",";	
		print $line->od_numids;	
		
		$itemattribvalues = '';
		$db3->query('select * from pf_store_order_item_fields where orderid=' . $line->od_id . ' and itemid=' . $line->ID . ' LIMIT 1');
		while ($line2 = $db3->fetchNextObject()) { 
			$itemattribvalues = $line2->FieldData;
		}
		$db3->close();
		$firstname='';
		if ($itemattribvalues != '')
		{
			$arrValues = split('[|]', $itemattribvalues);
			foreach ($arrAttribIDs as $value) {
				$found = false; 
				foreach ($arrValues as $attribvalue) {
					$arrField = split('[=]', $attribvalue);
			
					if ($arrField[0] == "fld$value")
					{
						if ($arrField[0] == 'fld10')
							$firstname = $arrField[1];
						$aval = split('[=]', $attribvalue);
						if ($arrField[0] == 'fld21')
							print ', "' . $aval[1] . '"';
						else
							print ',' . $aval[1];
						
						if ($arrField[0] == 'fld33')
							print ',' . $firstname . ' ' . $aval[1] ;
														
						$attribcnt--;
						$found = true;
					}
				}	
				if (!$found)
				{
					print ",";
					$attribcnt--;
				}
			}
		}		
		/*
		foreach ($arrAttribIDs as $value) {
			$db2->query("SELECT * FROM store_item_attributes WHERE StoreItemID = " . $line->ProductID . " AND AttributeID = " . $value);
			$line2 = $db2->fetchNextObject();
			print "," . $line2->value;
			$attribcnt--;
		}
		*/
		for ($i = 0; $i < $attribcnt; $i++)
			print ",";
		print "\r\n";	
		
	}
	exit;  

}

//echo $query . $where . $order;
$db->query($query . $where . $order);	
//print $query . $where . $order;
$NumberOfResults = $db->numRows();

$Limit = 25;

$limit .= " LIMIT " . ($page)*$Page . ",$Limit";
$db->query($query . $where . $order . $limit);
//print $query;
$NumberOfPages=ceil($NumberOfResults/$Limit); 

for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
	if($i == $Page) 
		$Nav .= "<B>$i</B>"; 
	else
		$Nav .= '<A HREF="#" onclick="' . "javascript: document.getElementById('page').value=$i; document.form1.submit();" . '">' . $i . "</A>"; 
	 
} 

$menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='10%' class='tableheader'>ID</td><td class='tableheader'>ORDER DATE</td><td class='tableheader'>STATUS</td><td class='tableheader'>SHIPPING TO</td><td class='tableheader'>TOTAL PAID</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";

while ($line = $db->fetchNextObject()) { 

$menuString .= "<tr><td width='3%' align='left' class='listcell'><a href='/store/order/?orderid=".$line->od_id ."&id=".$line->EncryptID."'>".$line->od_id. '-' . $line->ID."<img src='/".$line->ThumbSm."' border='0' height='50' width='50'></a></td><td class='listcell' style='padding-left:5px;'>".$line->od_date."</td><td class='listcell'>";

switch(	$line->Complete)
{
	case 0:
		$menuString .= 'Uncomplete';
		break;
	case 1:
		$menuString .= 'Complete';
		break;
	case 2:
		$menuString .= 'Processing';
		break;
	case 3:
		$menuString .= 'Shipped';
		break;
	case 4:
		$menuString .= 'Voided';
		break; 
}

$menuString .="</td><td class='listcell'>";
if ($line->ShippingOption == 1)
	$menuString .="Digital Delivery";
else 
$menuString .=$line->od_shipping_last_name. ', ' . $line->od_shipping_first_name;
$menuString .="</td><td class='listcell'>".$line->Price."</td></tr>";

	}
$menuString .= "</table>";

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
     <form name="form1" method='post' action='/store/orders/'>
<input type="hidden" name="page" id="page" value="" />
<input type="hidden" name="user" id="page" value="<? echo $UserID;?>" />
  <table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>

  <td  valign="top">
  

<table width='100%' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="12" id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td width="574" id='contenttop'>&nbsp;</td>

    <td width="13" id='contenttopright'>&nbsp;</td>

  </tr>

  <tr>

    <td id="contentleftside"></td>

    <td width="140" class='adminSidebar' align="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      ORDERS</div>
   <div>
   <fieldset>
          <legend style="font-size: 12px;">search</legend>
              ORDER:&nbsp;&nbsp;
              <input type="text" name="txtOrderNum" id="txtOrderNum" value="<? echo $_POST['txtOrderNum']; ?>" style="width:97%;" /><br />
NAME:&nbsp;&nbsp;<br />
<input type="text" name="txtName" id="txtName" value="<? echo $_POST['txtName']; ?>" style="width:97%;" />
              <div style="height: 5px;"></div>
             <font style="font-size: 12px;">Status:</font>
          <select name="txtStatus">
				<option value="" <? if ($Status == '') echo 'selected'; ?>>NEW</option>				
				<option value="shipped" <? if ($Status == 'shipped') echo 'selected'; ?>>SHIPPED</option>	
				<option value="processing" <? if ($Status == 'processing') echo 'selected'; ?>>PROCESSING</option>	
				<option value="voided" <? if ($Status == 'voided') echo 'selected'; ?>>VOIDED</option>	
				<option value="uncomplete" <? if ($Status == 'uncomplete') echo 'selected'; ?>>UNCOMPLETED</option>	
		  </select>

             
               <div style="height: 5px;"></div> 
               <input name="fromdate" id="fromdate" size="10" value="from date" onfocus="doClear(this)" type="text">&nbsp;<img src="images/cal.gif" onclick="displayDatePicker('fromdate',false,'mdy','/');" class="calpick">&nbsp;<br />
<input name="todate" id="todate" size="10" value="to date" onfocus="doClear(this)" type="text">&nbsp;<img src="images/cal.gif" onclick="displayDatePicker('todate',false,'mdy','/');" class="calpick">
 <div style="height: 5px;"></div>    <input type="submit" value="SEARCH" id='submitstyle'>
          </fieldset>
   
   
   
   
   
 </div></td>

    <td class='adminContent' valign="top"><div style="color: #FFFFFF">TOTAL:&nbsp;[<? echo ($Page=='')?'1':$Page; ?>&nbsp;-&nbsp;<? echo (($Page)*$Limit < $NumberOfResults)?($Page)*$Limit:$NumberOfResults; ?>&nbsp;of&nbsp;<? echo $NumberOfResults; ?>]  <? echo "&nbsp;&nbsp;&nbsp;PAGES[" . $Nav . "]"; ?></div><br /><? echo $menuString; ?></td>

    <td id='contentrightside'>&nbsp;</td>

  </tr>

  <tr>

    <td id='contentbottomleft'>&nbsp;</td>

    <td id='sidebottom'>&nbsp;</td>

    <td id='contentbottom'>&nbsp;</td>

    <td id='contentbottomright'>&nbsp;</td>

  </tr>

</table>



</td>
  </tr>
</table>
</form>
  </div>
  </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

