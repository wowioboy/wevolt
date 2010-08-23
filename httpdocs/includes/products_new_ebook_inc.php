<? $_SESSION['uploadtype'] = 'selfpdf';?>
<iframe id='loaderframe' name='loaderframe' height='400px' width="680" frameborder="no" scrolling="auto" src="/pdf_file_upload.php"></iframe>

<div id='bookinfo'>
<div align="center"> 
<div class="pageheader"> Enter your PDF's Credits/Information</div>
<div class="spacer"></div>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="88"><b>CREATOR: </b></td>
<td width="488"><input type="text" style="width:300px;" name="txtAuthor" value="<? if (!isset($_POST['txtAuthor'])) { echo stripslashes($Creator); } else { echo $_POST['txtAuthor'];}?>"/></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>TITLE:</strong> </td>
<td><input type="text" style="width:300px;" name="txtTitle" value="<? if (!isset($_POST['txtTitle'])) { echo stripslashes($ComicTitle); } else { echo $_POST['txtTitle'];}?>"/></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>SUBJECT:</strong> </td>
<td><textarea name="txtSubject" style="width:300px;"><? if (!isset($_POST['txtSubject'])) { echo stripslashes($Genre); } else { echo $_POST['txtSubject'];}?></textarea></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>KEYWORDS: </strong></td>
<td><textarea name="txtKeywords" style="width:300px;"><? if (!isset($_POST['txtKeywords'])) { echo stripslashes($ComicTags); } else { echo $_POST['txtKeywords'];}?></textarea></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
<tr>
<td colspan="2" height="10">Do you want to post this PDF to the Panel Flow Products list? : <input type="radio"  name="txtPost" value="1" <? if (($_POST['txtPost'] == 1) || ($_POST['txtPost'] == '')) echo 'checked';?> onClick="show_pricing();"/>Yes &nbsp;<input type="radio"  name="txtPost" value="0" onClick="hide_pricing();" <? if ($_POST['txtPost'] == 0) echo 'checked';?> />No &nbsp;
<div id='pricingdiv' <? if ($_POST['txtPost'] == 0) {?>style="display:none;"<? }?>>
   <div class="spacer"></div>
  Would you like to offer this PDF for sale? : <input type="radio"  name="txtPricing" value="1" <? if ($_POST['txtPrice'] != '') echo 'checked'; ?> onClick="show_price_input()"/>Yes &nbsp;<input type="radio"  name="txtPricing" value="0"  <? if ($_POST['txtPrice'] == '') echo 'checked'; ?>  onClick="hide_price_input()"/>No (Free)&nbsp;
  
  <div id="priceinputdiv"  <? if (($_POST['txtPricing'] == 0) || (!isset($_POST['txtPricing']))) {?>style="display:none;"<? }?>>
  Enter The Amount you would like to charge to download this E-Book: <input type="text"  style="width:100px;" name="txtPrice"  value="<? echo $_POST['txtPrice'];?>" id="txtPrice"/>
  <br /><br />

 <b> ***In order to sell products on PanelFlow.com, you will need to have filled out the Seller data and have an active Paypal account. If you have not filled out the Seller data, you will be prompted to do so on the next page. </b> </div>
   
   </div></td></tr> 

 </table>

</div>