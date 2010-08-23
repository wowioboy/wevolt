<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
<!-- Identify your business so that you can collect the payments. --> 
<input type="hidden" name="business" value="alice@mystore.com"> 
<!-- Specify a Subscribe button. --> 
<input type="hidden" name="cmd" value="_xclick-subscriptions"> 
<!-- Identify the subscription. --> 
<input type="hidden" name="item_name" value="Alice's Weekly Digest"> 
<input type="hidden" name="item_number" value="DIG Weekly"> 
<!-- Set the terms of the 1st trial period. --> 
<input type="hidden" name="currency_code" value="USD"> 
<input type="hidden" name="a1" value="0"> 
<input type="hidden" name="p1" value="7"> 
<input type="hidden" name="t1" value="D"> 
<!-- Set the terms of the 2nd trial period. --> 
<input type="hidden" name="a2" value="5.00"> 
<input type="hidden" name="p2" value="3"> 
<input type="hidden" name="t2" value="W"> 
<!-- Set the terms of the regular subscription. --> 
<input type="hidden" name="a3" value="49.99"> 
<input type="hidden" name="p3" value="1"> 
<input type="hidden" name="t3" value="Y"> 
<input type="hidden" name="src" value="1"> 
<!-- Display the payment button. --> 
<input type="image" name="submit" border="0" 
src="https://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif" 
alt="PayPal - The safer, easier way to pay online"> 
<img alt="" border="0" width="1" height="1" 
src="https://www.paypal.com/en_US/i/scr/pixel.gif" > 
</form> 
