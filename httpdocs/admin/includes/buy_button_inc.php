<div class='spacer'></div><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" style='border:0;' src="<? if ($BuyButton == '') { echo 'https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif'; } else { echo $BuyButton;}?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="<? echo $Encrypted;?>">
</form>
<? if ($ShowAddCart == 1) { ?>

<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="image" style='border:0;' src="<? if ($AddCart == '') { echo 'https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif'; } else { echo $AddCart;}?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="padding:0px; margin:0px;">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="add" value="1">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="<? echo $MerchantEmail; ?>">
<input type="hidden" name="item_name" value="<? echo $Title;?>">
<input type="hidden" name="item_number" value="<? echo $ItemNumber;?>">
<input type="hidden" name="amount" value="<? echo $Price;?>">
<input type="hidden" name="no_shipping" value="<? echo $ShippingOption;?>">
<input type="hidden" name="weight" value="<? echo $ItemWeight;?>">
<input type="hidden" name="weight_unit" value="lbs">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="bn" value="PP-ShopCartBF">
</form>
<? }?>
<? if ($ShowViewCart == 1) { ?>

<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="<? echo $MerchantEmail; ?>">
<input type="image" style='border:0;' src="<? if ($ViewCart == '') { echo 'https://www.paypal.com/en_US/i/btn/view_cart.gif'; } else { echo $ViewCart;}?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<input type="hidden" name="display" value="1">
</form>
<? } ?>