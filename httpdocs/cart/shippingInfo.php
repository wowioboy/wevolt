<?php
include_once 'config.php';

$ShippingFirstName = $_POST['hidShippingFirstName'];
$ShippingLastName = $_POST['hidShippingLastName'];
$ShippingStreet = $_POST['hidShippingAddress1'];
$ShippingStreet2 = $_POST['hidShippingAddress2'];
$ShippingCity = $_POST['hidShippingCity'];
$ShippingState = $_POST['hidShippingState'];
$ShippingZip = $_POST['hidShippingPostalCode'];
$ShippingPhone = $_POST['hidShippingPhone'];
$ShippingEmail = $_POST['hidShippingEmail'];
$ShippingCost = $_POST['hidShippingCost'];
if (isset($_SESSION['id']))
{
	if (!isset($ShippingStreet))
	{
		$ClientDB = new DB();
		$query = "SELECT * from users where ID='" . $_SESSION['id'] . "'";
		$ClientArray = $ClientDB->queryUniqueObject($query);
		$ShippingFirstName = $ClientArray->ShippingFirstName;
		$ShippingLastName = $ClientArray->ShippingLastName;
		$ShippingStreet = $ClientArray->ShippingStreet1;
		$ShippingStreet2 = $ClientArray->ShippingStreet2;
		$ShippingCity = $ClientArray->ShippingCity;
		$ShippingState = $ClientArray->ShippingState;
		$ShippingZip= $ClientArray->ShippingZip;
		$ShippingPhone= $ClientArray->ShippingPhone;
		$ShippingEmail= $ClientArray->Email;
		$ClientDB->close();
	}
}
/*
if (!defined('WEB_ROOT')
    || !isset($_GET['step']) || (int)$_GET['step'] != 1) {
	exit;
}
*/
if (isset($_POST['hidMessage'])) 
	$errorMessage = $_POST['hidMessage'];
else
	$errorMessage = '&nbsp;';
?>
<script language="javascript" type="text/javascript" src="/js/validation.js"></script>
<script language="JavaScript" type="text/javascript" src="/cart/checkout.js"></script>
<script language="JavaScript" type="text/javascript">
	function hideCC() { 
		 document.getElementById('CCNumber').style.visibility = 'hidden';
		document.getElementById('CCExp').style.visibility = 'hidden';
	}
	
	function showCC() { 
		document.getElementById('CCNumber').style.visibility = 'visible';
		document.getElementById('CCExp').style.visibility = 'visible'; 
	} 
</script>
<div class="pageheader">Please Enter All your Shipping Information</div>
<div id="errorMessage"><font color="red"><b><?php echo $errorMessage; ?></b></font></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout" onSubmit="return checkShippingAndPaymentInfo();">

    <table width="57%" border="0" align="center" cellpadding="2" cellspacing="0" class="entryTable">
<tr class="entryTableHeader"> 
            <td colspan="2" class='cartheader'><b>Shipping Information</b></td>
        </tr>
		  <tr> 
            <td width="186" class="carttext">First Name</td>
            <td width="302" class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50" value="<? echo $ShippingFirstName; ?>" ></td>
      </tr>
        <tr> 
            <td width="186" class="carttext">Last Name</td>
          <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="30" maxlength="50" value="<? echo $ShippingLastName; ?>" ></td>
        </tr>
        <tr> 
            <td width="186" class="carttext">Address1</td>
          <td class="content"><input name="txtShippingAddress1" type="text" class="box" id="txtShippingAddress1" size="50" maxlength="100"  value="<? echo $ShippingStreet; ?>" ></td>
        </tr>
        <tr> 
            <td width="186" class="carttext">Address2</td>
          <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"  value="<? echo $ShippingStreet2; ?>"></td>
        </tr>
        <tr> 
            <td width="186" class="carttext">City</td>
          <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="30" maxlength="32"   value="<? echo $ShippingCity; ?>"></td>
        </tr>
		<tr> 
            <td width="186" class="carttext">Province / State</td>
          <td class="content">
			<select name="txtShippingState" id="txtShippingState">
				      <option value="AL" <? if ($ShippingState =='AL') echo 'selected'; ?>>Alabama</option>
					  <option value="AK" <? if ($ShippingState =='AK') echo 'selected'; ?>>Alaska</option>
					  <option value="AS" <? if ($ShippingState =='AS') echo 'selected'; ?>>American Samoa</option>
					  <option value="AZ" <? if ($ShippingState =='AZ') echo 'selected'; ?>>Arizona</option>
					  <option value="AR" <? if ($ShippingState =='AR') echo 'selected'; ?>>Arkansas</option>
					  <option value="AF" <? if ($ShippingState =='AF') echo 'selected'; ?>>Armed Forces Africa</option>
					  <option value="AA" <? if ($ShippingState =='AA') echo 'selected'; ?>>Armed Forces Americas</option>
					  <option value="AC" <? if ($ShippingState =='AC') echo 'selected'; ?>>Armed Forces Canada</option>
					  <option value="AE" <? if ($ShippingState =='AC') echo 'selected'; ?>>Armed Forces Europe</option>
					  <option value="AM" <? if ($ShippingState =='AM') echo 'selected'; ?>>Armed Forces Middle East</option>
					  <option value="AP" <? if ($ShippingState =='AP') echo 'selected'; ?>>Armed Forces Pacific</option>
					  <option value="CA" <? if ($ShippingState =='CA') echo 'selected'; ?>>California</option>
					  
					  <option value="AB" <? if ($ShippingState =='AB') echo 'selected'; ?>>Canada - Alberta</option>    
					  <option value="BC" <? if ($ShippingState =='BC') echo 'selected'; ?>>Canada - British Columbia</option>    
					  <option value="MB" <? if ($ShippingState =='MB') echo 'selected'; ?>>Canada - Manitoba</option>    
					  <option value="NB" <? if ($ShippingState =='NB') echo 'selected'; ?>>Canada - New Brunswick</option>    
					  <option value="NL" <? if ($ShippingState =='NL') echo 'selected'; ?>>Canada - Newfoundland and Labrador</option>    
					  <option value="NT" <? if ($ShippingState =='NT') echo 'selected'; ?>>Canada - Northwest Territories</option>    
					  <option value="NS" <? if ($ShippingState =='NS') echo 'selected'; ?>>Canada - Nova Scotia</option>    
					  <option value="NU" <? if ($ShippingState =='NU') echo 'selected'; ?>>Canada - Nunavut</option>    
					  <option value="ON" <? if ($ShippingState =='ON') echo 'selected'; ?>>Canada - Ontario</option>    
					  <option value="PE" <? if ($ShippingState =='PE') echo 'selected'; ?>>Canada - Prince Edward Island</option>    
					  <option value="QC" <? if ($ShippingState =='QC') echo 'selected'; ?>>Canada - Quebec</option>    
					  <option value="SK" <? if ($ShippingState =='SK') echo 'selected'; ?>>Canada - Saskatchewan</option>    
      				  <option value="YT" <? if ($ShippingState =='YT') echo 'selected'; ?>>Canada - Yukon Territory</option>    

					  <option value="CO" <? if ($ShippingState =='CO') echo 'selected'; ?>>Colorado</option>
					  <option value="CT" <? if ($ShippingState =='CT') echo 'selected'; ?>>Connecticut</option>
					  <option value="DE" <? if ($ShippingState =='DE') echo 'selected'; ?>>Delaware</option>
					  <option value="DC" <? if ($ShippingState =='DC') echo 'selected'; ?>>District of Columbia</option>
					  <option value="FM" <? if ($ShippingState =='FM') echo 'selected'; ?>>Federated States Of Micronesia</option>
					  <option value="FL" <? if ($ShippingState =='FL') echo 'selected'; ?>>Florida</option>
					  <option value="GA" <? if ($ShippingState =='GA') echo 'selected'; ?>>Georgia</option>
					  <option value="GU" <? if ($ShippingState =='GU') echo 'selected'; ?>>Guam</option>
					  <option value="HI" <? if ($ShippingState =='HI') echo 'selected'; ?>>Hawaii</option>
					  <option value="ID" <? if ($ShippingState =='ID') echo 'selected'; ?>>Idaho</option>
					  <option value="IL" <? if ($ShippingState =='IL') echo 'selected'; ?>>Illinois</option>
					  <option value="IN" <? if ($ShippingState =='IN') echo 'selected'; ?>>Indiana</option>
					  <option value="IA" <? if ($ShippingState =='IA') echo 'selected'; ?>>Iowa</option>
					  <option value="KS" <? if ($ShippingState =='KS') echo 'selected'; ?>>Kansas</option>
					  <option value="KY" <? if ($ShippingState =='KY') echo 'selected'; ?>>Kentucky</option>
					  <option value="LA" <? if ($ShippingState =='LA') echo 'selected'; ?>>Louisiana</option>
					  <option value="ME" <? if ($ShippingState =='ME') echo 'selected'; ?>>Maine</option>
					  <option value="MH" <? if ($ShippingState =='MH') echo 'selected'; ?>>Marshall Islands</option>
					  <option value="MD" <? if ($ShippingState =='MD') echo 'selected'; ?>>Maryland</option>
					  <option value="MA" <? if ($ShippingState =='MA') echo 'selected'; ?>>Massachusetts</option>
					  <option value="MI" <? if ($ShippingState =='MI') echo 'selected'; ?>>Michigan</option>
					  <option value="MN" <? if ($ShippingState =='MN') echo 'selected'; ?>>Minnesota</option>
					  <option value="MS" <? if ($ShippingState =='MS') echo 'selected'; ?>>Mississippi</option>
					  <option value="MO" <? if ($ShippingState =='MO') echo 'selected'; ?>>Missouri</option>
					  <option value="MT" <? if ($ShippingState =='MT') echo 'selected'; ?>>Montana</option>
					  <option value="NE" <? if ($ShippingState =='NE') echo 'selected'; ?>>Nebraska</option>
					  <option value="NV" <? if ($ShippingState =='NV') echo 'selected'; ?>>Nevada</option>
					  <option value="NH" <? if ($ShippingState =='NH') echo 'selected'; ?>>New Hampshire</option>
					  <option value="NJ" <? if ($ShippingState =='NJ') echo 'selected'; ?>>New Jersey</option>
					  <option value="NM" <? if ($ShippingState =='NM') echo 'selected'; ?>>New Mexico</option>
					  <option value="NY" <? if ($ShippingState =='NY') echo 'selected'; ?>>New York</option>
					  <option value="NC" <? if ($ShippingState =='NC') echo 'selected'; ?>>North Carolina</option>
					  <option value="ND" <? if ($ShippingState =='ND') echo 'selected'; ?>>North Dakota</option>
					  <option value="MP" <? if ($ShippingState =='MP') echo 'selected'; ?>>Northern Mariana Islands</option>
					  <option value="OH" <? if ($ShippingState =='OH') echo 'selected'; ?>>Ohio</option>
					  <option value="OK" <? if ($ShippingState =='OK') echo 'selected'; ?>>Oklahoma</option>
					  <option value="OR" <? if ($ShippingState =='OR') echo 'selected'; ?>>Oregon</option>
					  <option value="PW" <? if ($ShippingState =='PW') echo 'selected'; ?>>Palau</option>
					  <option value="PA" <? if ($ShippingState =='PA') echo 'selected'; ?>>Pennsylvania</option>
					  <option value="PR" <? if ($ShippingState =='PR') echo 'selected'; ?>>Puerto Rico</option>
					  <option value="RI" <? if ($ShippingState =='RI') echo 'selected'; ?>>Rhode Island</option>
					  <option value="SC" <? if ($ShippingState =='SC') echo 'selected'; ?>>South Carolina</option>
					  <option value="SD" <? if ($ShippingState =='SD') echo 'selected'; ?>>South Dakota</option>
					  <option value="TN" <? if ($ShippingState =='TN') echo 'selected'; ?>>Tennessee</option>
					  <option value="TX" <? if ($ShippingState =='TX') echo 'selected'; ?>>Texas</option>
					  <option value="UT" <? if ($ShippingState =='UT') echo 'selected'; ?>>Utah</option>
					  <option value="VT" <? if ($ShippingState =='VT') echo 'selected'; ?>>Vermont</option>
					  <option value="VI" <? if ($ShippingState =='VI') echo 'selected'; ?>>Virgin Islands</option>
					  <option value="VA" <? if ($ShippingState =='VA') echo 'selected'; ?>>Virginia</option>
					  <option value="WA" <? if ($ShippingState =='WA') echo 'selected'; ?>>Washington</option>
					  <option value="WV" <? if ($ShippingState =='WV') echo 'selected'; ?>>West Virginia</option>
					  <option value="WI" <? if ($ShippingState =='WI') echo 'selected'; ?>>Wisconsin</option>
					  <option value="WY" <? if ($ShippingState =='WY') echo 'selected'; ?>>Wyoming</option>
				</select>
        </tr>
        <tr> 
            <td width="186" class="carttext">Postal / Zip Code</td>
          <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" value="<? echo $ShippingZip; ?>"></td>
        </tr>
		<tr> 
            <td width="186" class="carttext">Phone Number<br />
          (XXX-XXX-XXXX)</td>
          <td class="content"><input name="txtShippingPhone" type="text" class="box" id="txtShippingPhone" size="30" maxlength="32" value="<? echo $ShippingPhone; ?>"></td>
        </tr>
		<tr> 
            <td width="186" class="carttext">Email Address</td>
          <td class="content"><input name="txtShippingEmail" type="text" class="box" id="txtShippingEmail" size="30" maxlength="32" value="<? echo $ShippingEmail; ?>"></td>
        </tr> <tr>
		<td colspan='2'><p align="center">
		<input class="box" name="btnStep1" type="submit" id="btnStep1" value="Proceed &gt;&gt;" style="padding:0px;margin:0px;">
</td></tr>
    </table>
</form>