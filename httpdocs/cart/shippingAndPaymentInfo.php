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

<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr> 
        <td class='inputheader'><b>Step 1 Of 3 </b>: Enter Shipping And Payment Information </td>
    </tr>
</table>
<p id="errorMessage"><font color="red"><b><?php echo $errorMessage; ?></b></font></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout" onSubmit="return checkShippingAndPaymentInfo();">
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
            <td colspan="2" class='inputheader'><b>Shipping Information</b></td>
        </tr>
		<tr> 
            <td colspan="2" class="content"><i>Credit Card information is required for new orders.  If you are using a code for renewal or prepaid packages, Credit Card information is collected for the S/H only.  You will be able to preview charges before submitting.</i></td>
        </tr>
	   <tr> 
            <td width="150" class="label">First Name</td>
            <td class="content"><input name="txtShippingFirstName" type="text" class="box" id="txtShippingFirstName" size="30" maxlength="50" value="<? echo $ShippingFirstName; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">Last Name</td>
            <td class="content"><input name="txtShippingLastName" type="text" class="box" id="txtShippingLastName" size="30" maxlength="50" value="<? echo $ShippingLastName; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address1</td>
            <td class="content"><input name="txtShippingAddress1" type="text" class="box" id="txtShippingAddress1" size="50" maxlength="100"  value="<? echo $ShippingStreet; ?>" ></td>
        </tr>
        <tr> 
            <td width="150" class="label">Address2</td>
            <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"  value="<? echo $ShippingStreet2; ?>"></td>
        </tr>
        <tr> 
            <td width="150" class="label">City</td>
            <td class="content"><input name="txtShippingCity" type="text" class="box" id="txtShippingCity" size="30" maxlength="32"   value="<? echo $ShippingCity; ?>"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Province / State</td>
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
            <td width="150" class="label">Postal / Zip Code</td>
            <td class="content"><input name="txtShippingPostalCode" type="text" class="box" id="txtShippingPostalCode" size="10" maxlength="10" value="<? echo $ShippingZip; ?>"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Phone Number<br />(XXX-XXX-XXXX)</td>
            <td class="content"><input name="txtShippingPhone" type="text" class="box" id="txtShippingPhone" size="30" maxlength="32" value="<? echo $ShippingPhone; ?>"></td>
        </tr>
		<tr> 
            <td width="150" class="label">Email Address</td>
            <td class="content"><input name="txtShippingEmail" type="text" class="box" id="txtShippingEmail" size="30" maxlength="32" value="<? echo $ShippingEmail; ?>"></td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
            <td width="156" class='inputheader'>Payment Information</td>
            <td colspan="2"  class="content"><input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"   <? if ($_POST['hidSame'] == 'checkbox') {  ?> checked="checked" <? } ?>> 
                &nbsp;Same as shipping information</td>
        </tr>
        <tr> 
            <td width="156" class="label">First Name</td>
            <td colspan="2" class="content"><input name="txtPaymentFirstName" type="text" class="box" id="txtPaymentFirstName" size="30" maxlength="50" value="<? echo $_POST['hidPaymentFirstName']; ?>"></td>
        </tr>
        <tr> 
            <td width="156" class="label">Last Name</td>
            <td colspan="2" class="content"><input name="txtPaymentLastName" type="text" class="box" id="txtPaymentLastName" size="30" maxlength="50" value="<? echo $_POST['hidPaymentLastName']; ?>"></td>
        </tr>
        <tr> 
            <td width="156" class="label">Address1</td>
            <td colspan="2" class="content"><input name="txtPaymentAddress1" type="text" class="box" id="txtPaymentAddress1" size="50" maxlength="100" value="<? echo $_POST['hidPaymentAddress1']; ?>"></td>
        </tr>
        <tr> 
            <td width="156" class="label">Address2</td>
            <td colspan="2" class="content"><input name="txtPaymentAddress2" type="text" class="box" id="txtPaymentAddress2" size="50" maxlength="100" value="<? echo $_POST['hidPaymentAddress2']; ?>"></td>
        </tr>
        <tr> 
            <td width="156" class="label">City</td>
            <td colspan="2" class="content"><input name="txtPaymentCity" type="text" class="box" id="txtPaymentCity" size="30" maxlength="32" value="<? echo $_POST['hidPaymentCity']; ?>"></td>
        </tr>
		<tr> 
            <td width="156" class="label">Province / State</td>
            <td colspan="2" class="content">
						<select name="txtPaymentState" id="txtPaymentState">
				      <option value="AL" <? if ($_POST['hidPaymentState'] =='AL') echo 'selected'; ?>>Alabama</option>
					  <option value="AK" <? if ($_POST['hidPaymentState'] =='AK') echo 'selected'; ?>>Alaska</option>
					  <option value="AS" <? if ($_POST['hidPaymentState'] =='AS') echo 'selected'; ?>>American Samoa</option>
					  <option value="AZ" <? if ($_POST['hidPaymentState'] =='AZ') echo 'selected'; ?>>Arizona</option>
					  <option value="AR" <? if ($_POST['hidPaymentState'] =='AR') echo 'selected'; ?>>Arkansas</option>
					  <option value="AF" <? if ($_POST['hidPaymentState'] =='AF') echo 'selected'; ?>>Armed Forces Africa</option>
					  <option value="AA" <? if ($_POST['hidPaymentState'] =='AA') echo 'selected'; ?>>Armed Forces Americas</option>
					  <option value="AC" <? if ($_POST['hidPaymentState'] =='AC') echo 'selected'; ?>>Armed Forces Canada</option>
					  <option value="AE" <? if ($_POST['hidPaymentState'] =='AC') echo 'selected'; ?>>Armed Forces Europe</option>
					  <option value="AM" <? if ($_POST['hidPaymentState'] =='AM') echo 'selected'; ?>>Armed Forces Middle East</option>
					  <option value="AP" <? if ($_POST['hidPaymentState'] =='AP') echo 'selected'; ?>>Armed Forces Pacific</option>
					  <option value="CA" <? if ($_POST['hidPaymentState'] =='CA') echo 'selected'; ?>>California</option>
					  <option value="AB" <? if ($_POST['hidPaymentState'] =='AB') echo 'selected'; ?>>Canada - Alberta</option>    
					  <option value="BC" <? if ($_POST['hidPaymentState'] =='BC') echo 'selected'; ?>>Canada - British Columbia</option>    
					  <option value="MB" <? if ($_POST['hidPaymentState'] =='MB') echo 'selected'; ?>>Canada - Manitoba</option>    
					  <option value="NB" <? if ($_POST['hidPaymentState'] =='NB') echo 'selected'; ?>>Canada - New Brunswick</option>    
					  <option value="NL" <? if ($_POST['hidPaymentState'] =='NL') echo 'selected'; ?>>Canada - Newfoundland and Labrador</option>    
					  <option value="NT" <? if ($_POST['hidPaymentState'] =='NT') echo 'selected'; ?>>Canada - Northwest Territories</option>    
					  <option value="NS" <? if ($_POST['hidPaymentState'] =='NS') echo 'selected'; ?>>Canada - Nova Scotia</option>    
					  <option value="NU" <? if ($_POST['hidPaymentState'] =='NU') echo 'selected'; ?>>Canada - Nunavut</option>    
					  <option value="ON" <? if ($_POST['hidPaymentState'] =='ON') echo 'selected'; ?>>Canada - Ontario</option>    
					  <option value="PE" <? if ($_POST['hidPaymentState'] =='PE') echo 'selected'; ?>>Canada - Prince Edward Island</option>    
					  <option value="QC" <? if ($_POST['hidPaymentState'] =='QC') echo 'selected'; ?>>Canada - Quebec</option>    
					  <option value="SK" <? if ($_POST['hidPaymentState'] =='SK') echo 'selected'; ?>>Canada - Saskatchewan</option>    
      				  <option value="YT" <? if ($_POST['hidPaymentState'] =='YT') echo 'selected'; ?>>Canada - Yukon Territory</option>    

					  <option value="CO" <? if ($_POST['hidPaymentState'] =='CO') echo 'selected'; ?>>Colorado</option>
					  <option value="CT" <? if ($_POST['hidPaymentState'] =='CT') echo 'selected'; ?>>Connecticut</option>
					  <option value="DE" <? if ($_POST['hidPaymentState'] =='DE') echo 'selected'; ?>>Delaware</option>
					  <option value="DC" <? if ($_POST['hidPaymentState'] =='DC') echo 'selected'; ?>>District of Columbia</option>
					  <option value="FM" <? if ($_POST['hidPaymentState'] =='FM') echo 'selected'; ?>>Federated States Of Micronesia</option>
					  <option value="FL" <? if ($_POST['hidPaymentState'] =='FL') echo 'selected'; ?>>Florida</option>
					  <option value="GA" <? if ($_POST['hidPaymentState'] =='GA') echo 'selected'; ?>>Georgia</option>
					  <option value="GU" <? if ($_POST['hidPaymentState'] =='GU') echo 'selected'; ?>>Guam</option>
					  <option value="HI" <? if ($_POST['hidPaymentState'] =='HI') echo 'selected'; ?>>Hawaii</option>
					  <option value="ID" <? if ($_POST['hidPaymentState'] =='ID') echo 'selected'; ?>>Idaho</option>
					  <option value="IL" <? if ($_POST['hidPaymentState'] =='IL') echo 'selected'; ?>>Illinois</option>
					  <option value="IN" <? if ($_POST['hidPaymentState'] =='IN') echo 'selected'; ?>>Indiana</option>
					  <option value="IA" <? if ($_POST['hidPaymentState'] =='IA') echo 'selected'; ?>>Iowa</option>
					  <option value="KS" <? if ($_POST['hidPaymentState'] =='KS') echo 'selected'; ?>>Kansas</option>
					  <option value="KY" <? if ($_POST['hidPaymentState'] =='KY') echo 'selected'; ?>>Kentucky</option>
					  <option value="LA" <? if ($_POST['hidPaymentState'] =='LA') echo 'selected'; ?>>Louisiana</option>
					  <option value="ME" <? if ($_POST['hidPaymentState'] =='ME') echo 'selected'; ?>>Maine</option>
					  <option value="MH" <? if ($_POST['hidPaymentState'] =='MH') echo 'selected'; ?>>Marshall Islands</option>
					  <option value="MD" <? if ($_POST['hidPaymentState'] =='MD') echo 'selected'; ?>>Maryland</option>
					  <option value="MA" <? if ($_POST['hidPaymentState'] =='MA') echo 'selected'; ?>>Massachusetts</option>
					  <option value="MI" <? if ($_POST['hidPaymentState'] =='MI') echo 'selected'; ?>>Michigan</option>
					  <option value="MN" <? if ($_POST['hidPaymentState'] =='MN') echo 'selected'; ?>>Minnesota</option>
					  <option value="MS" <? if ($_POST['hidPaymentState'] =='MS') echo 'selected'; ?>>Mississippi</option>
					  <option value="MO" <? if ($_POST['hidPaymentState'] =='MO') echo 'selected'; ?>>Missouri</option>
					  <option value="MT" <? if ($_POST['hidPaymentState'] =='MT') echo 'selected'; ?>>Montana</option>
					  <option value="NE" <? if ($_POST['hidPaymentState'] =='NE') echo 'selected'; ?>>Nebraska</option>
					  <option value="NV" <? if ($_POST['hidPaymentState'] =='NV') echo 'selected'; ?>>Nevada</option>
					  <option value="NH" <? if ($_POST['hidPaymentState'] =='NH') echo 'selected'; ?>>New Hampshire</option>
					  <option value="NJ" <? if ($_POST['hidPaymentState'] =='NJ') echo 'selected'; ?>>New Jersey</option>
					  <option value="NM" <? if ($_POST['hidPaymentState'] =='NM') echo 'selected'; ?>>New Mexico</option>
					  <option value="NY" <? if ($_POST['hidPaymentState'] =='NY') echo 'selected'; ?>>New York</option>
					  <option value="NC" <? if ($_POST['hidPaymentState'] =='NC') echo 'selected'; ?>>North Carolina</option>
					  <option value="ND" <? if ($_POST['hidPaymentState'] =='ND') echo 'selected'; ?>>North Dakota</option>
					  <option value="MP" <? if ($_POST['hidPaymentState'] =='MP') echo 'selected'; ?>>Northern Mariana Islands</option>
					  <option value="OH" <? if ($_POST['hidPaymentState'] =='OH') echo 'selected'; ?>>Ohio</option>
					  <option value="OK" <? if ($_POST['hidPaymentState'] =='OK') echo 'selected'; ?>>Oklahoma</option>
					  <option value="OR" <? if ($_POST['hidPaymentState'] =='OR') echo 'selected'; ?>>Oregon</option>
					  <option value="PW" <? if ($_POST['hidPaymentState'] =='PW') echo 'selected'; ?>>Palau</option>
					  <option value="PA" <? if ($_POST['hidPaymentState'] =='PA') echo 'selected'; ?>>Pennsylvania</option>
					  <option value="PR" <? if ($_POST['hidPaymentState'] =='PR') echo 'selected'; ?>>Puerto Rico</option>
					  <option value="RI" <? if ($_POST['hidPaymentState'] =='RI') echo 'selected'; ?>>Rhode Island</option>
					  <option value="SC" <? if ($_POST['hidPaymentState'] =='SC') echo 'selected'; ?>>South Carolina</option>
					  <option value="SD" <? if ($_POST['hidPaymentState'] =='SD') echo 'selected'; ?>>South Dakota</option>
					  <option value="TN" <? if ($_POST['hidPaymentState'] =='TN') echo 'selected'; ?>>Tennessee</option>
					  <option value="TX" <? if ($_POST['hidPaymentState'] =='TX') echo 'selected'; ?>>Texas</option>
					  <option value="UT" <? if ($_POST['hidPaymentState'] =='UT') echo 'selected'; ?>>Utah</option>
					  <option value="VT" <? if ($_POST['hidPaymentState'] =='VT') echo 'selected'; ?>>Vermont</option>
					  <option value="VI" <? if ($_POST['hidPaymentState'] =='VI') echo 'selected'; ?>>Virgin Islands</option>
					  <option value="VA" <? if ($_POST['hidPaymentState'] =='VA') echo 'selected'; ?>>Virginia</option>
					  <option value="WA" <? if ($_POST['hidPaymentState'] =='WA') echo 'selected'; ?>>Washington</option>
					  <option value="WV" <? if ($_POST['hidPaymentState'] =='WV') echo 'selected'; ?>>West Virginia</option>
					  <option value="WI" <? if ($_POST['hidPaymentState'] =='WI') echo 'selected'; ?>>Wisconsin</option>
					  <option value="WY" <? if ($_POST['hidPaymentState'] =='WY') echo 'selected'; ?>>Wyoming</option>
				</select>
</td>
        </tr>
        <tr> 
            <td width="156" class="label">Postal / Zip Code</td>
            <td colspan="2" class="content"><input name="txtPaymentPostalCode" type="text" class="box" id="txtPaymentPostalCode" size="10" maxlength="10" value="<? echo $_POST['hidPaymentPostalCode']; ?>"></td>
        </tr>
		<tr> 
            <td width="156" class="label">Phone Number<br />(XXX-XXX-XXXX)</td>
            <td colspan="2" class="content"><input name="txtPaymentPhone" type="text" class="box" id="txtPaymentPhone" size="30" maxlength="32"  value="<? echo $_POST['hidPaymentPhone']; ?>">		</td>
        </tr>
		<tr>
			<td colspan="3">
				<table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
				  <tr>
					<td width="160" class='inputheader'>Payment Method </td>
					<td width="367" class="content">
					<!-- <input name="optPayment" type="radio" id="optPaypal" value="paypal" <? if ($_POST['hidPaymentMethod'] == 'paypal') {  ?> checked="checked" <? } ?>  onclick="javascript: hideCC();"/>
					&nbsp;Paypal&nbsp;-->
					<input name="optPayment" type="radio" value="cod" id="optCod"  <? if (($_POST['hidPaymentMethod'] == 'optCod') || ($_POST['hidPaymentMethod'] == '')) { ?> checked="checked" <? } ?> onclick="javascript: showCC();"/>
					&nbsp;Credit Card&nbsp;</td>
				  </tr>
				</table>			</td>
		</tr>
		<tr id="CCNumber"> 
            <td width="156" class="label">Credit Card Number</td>
            <td colspan="2" class="content"><input name="txtCCNumber" type="text" class="box" id="txtCCNumber" size="30" maxlength="32"  value="<? echo $_POST['hidCCNumber']; ?>" onkeypress="return numbersonly(event)">		</td>
        </tr>
		<tr  id="CCExp"> 
            <td width="156" class="label">Credit Expiration Date</td>
            <td width="120" valign="top" class="content" align="right"><select name="txtCCMonth">
									<option value="01" <? if ($_POST['hidCCMonth'] == '01') echo 'selected'; ?>>01</option>													
									<option value="02" <? if ($_POST['hidCCMonth'] == '02') echo 'selected'; ?>>02</option>
									<option value="03" <? if ($_POST['hidCCMonth'] == '03') echo 'selected'; ?>>03</option>									
									<option value="04" <? if ($_POST['hidCCMonth'] == '04') echo 'selected'; ?>>04</option>
									<option value="05" <? if ($_POST['hidCCMonth'] == '05') echo 'selected'; ?>>05</option>													
									<option value="06" <? if ($_POST['hidCCMonth'] == '06') echo 'selected'; ?>>06</option>
									<option value="07" <? if ($_POST['hidCCMonth'] == '07') echo 'selected'; ?>>07</option>									
									<option value="08" <? if ($_POST['hidCCMonth'] == '08') echo 'selected'; ?>>08</option>
									<option value="09" <? if ($_POST['hidCCMonth'] == '09') echo 'selected'; ?>>09</option>													
									<option value="10" <? if ($_POST['hidCCMonth'] == '10') echo 'selected'; ?>>10</option>
									<option value="11" <? if ($_POST['hidCCMonth'] == '11') echo 'selected'; ?>>11</option>									
									<option value="12" <? if ($_POST['hidCCMonth'] == '12') echo 'selected'; ?>>12</option>
								</select></td>
<td width="252" valign="top" class="content" align="left"><select name="txtCCYear">
									<option value="08" <? if ($_POST['hidCCYear'] == '08') echo 'selected'; ?>>2008</option>													
									<option value="09" <? if ($_POST['hidCCYear'] == '09') echo 'selected'; ?>>2009</option>
									<option value="10" <? if ($_POST['hidCCYear'] == '10') echo 'selected'; ?>>2010</option>									
									<option value="11" <? if ($_POST['hidCCYear'] == '11') echo 'selected'; ?>>2011</option>
									<option value="12" <? if ($_POST['hidCCYear'] == '12') echo 'selected'; ?>>2012</option>													
									<option value="13" <? if ($_POST['hidCCYear'] == '13') echo 'selected'; ?>>2013</option>													
									<option value="14" <? if ($_POST['hidCCYear'] == '14') echo 'selected'; ?>>2014</option>													
									<option value="15" <? if ($_POST['hidCCYear'] == '15') echo 'selected'; ?>>2015</option>													
									<option value="16" <? if ($_POST['hidCCYear'] == '16') echo 'selected'; ?>>2016</option>													
									<option value="17" <? if ($_POST['hidCCYear'] == '17') echo 'selected'; ?>>2017</option>													
									<option value="18" <? if ($_POST['hidCCYear'] == '18') echo 'selected'; ?>>2018</option>													
									<option value="19" <? if ($_POST['hidCCYear'] == '19') echo 'selected'; ?>>2019</option>													
									<option value="20" <? if ($_POST['hidCCYear'] == '20') echo 'selected'; ?>>2020</option>													
								</select>	</td>
		</tr>
        <tr>
		<td><img src="/images/rapidssl_ssl_certificate.gif" alt="Secure by RapidSSL" /><div style="width: 20px"></div> </td>
		<td colspan='2'>    <p align="center">
		<input class="box" name="btnStep1" type="submit" id="btnStep1" value="Proceed &gt;&gt;" style="padding:0px;margin:0px;">
    </p></td></tr>
    </table>

</form>