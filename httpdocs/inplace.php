<html>
  <head>
  <title>Demo</title>

  <script type="text/javascript"
   src="lib/prototype.js"></script>

  <script type="text/javascript"
   src="lib/scriptaculous.js"></script>


<?php
  require('srciptaculous.php');
  //starting objekt
  $inPlace= new handl_scriptac;
  //array for the used inPlaceEditors
  // array(Your_HTML_ID, Your_PHP_handling_File, array(your_scriptsets) )
  // ->next....
  $in_placers=array(
  array('test1', 'include.php',array('formId'=>'norm', 'okText' => 'Update')),
  array('test2', 'include.php',array('rows'=>'5','formId'=>'norm', 'okText' => 'Updateme')) 
  );
  //Add all 
  foreach($in_placers as $ky => $va)
  {
    $error=$inPlace->add_inPlaceEditor($va[0], $va[1], $va[2]);
    //if error!=true can be output echo error;
  }
  //Execute
  $code=$inPlace->place_inPlaceEditor();
  
  echo $code;
?>
  </head>
  <body style="text-align:center">
  <h2>DEMO of srciptaculius.php</h2>
  <h4>by Christian Zinke 02/2009 - <a href="http://christianzinke.wordpress.com/">http://christianzinke.wordpress.com/</a> 
  </h4><br>
  DEMO - Place_InEdit<br>: 
  <div id="form" action="#">
  <div id="test1">My Form (ID=test1) edit live</div>
  <div id="test2">My Form (ID=test2)  edit live with 4 rows</div>  
  </div>
  <span>If you wanne you can here set the set JS Variable to
  - test1.dispose(); AND test1.enterEditMode('click');
  (The HTML ID is the js.object)</span>
  <h4>based on: Scriptaculous: Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)</h4>
  </form>
  </body>
</html>