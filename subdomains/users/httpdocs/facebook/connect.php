<? include '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/includes/global_settings_inc.php';
global $api_key,$secret;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> <body> <div id="comments_post"> <h3>Leave a comment:</h3> <form method="POST"> <div id="user"> Name: <input name="name" size="27"><br /> <fb:login-button onlogin="update_user_box();"></fb:login-button> </div> <textarea name="comment" rows="5" cols="30"></textarea> <br /> <input type="submit" value="Submit Comment"> </form> </div> <script type="text/javascript"> function update_user_box() { var user_box = document.getElementById("user"); // add in some XFBML. note that we set useyou=false so it doesn't display "you" user_box.innerHTML = "<span>" + "<fb:profile-pic uid=loggedinuser facebook-logo=true></fb:profile-pic>" + "Welcome, <fb:name uid=loggedinuser useyou=false></fb:name>. You are signed in with your Facebook account." + "</span>"; // because this is XFBML, we need to tell Facebook to re-process the document FB.XFBML.Host.parseDomTree(); } </script> <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> <script type="text/javascript"> FB.init("<? echo $api_key;?>","/channel/xd_receiver.htm"); </script> </body> </html>