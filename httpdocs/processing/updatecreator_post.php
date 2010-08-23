<?php
include '../includes/dbconfig.php';
$ComicID = $_GET['comicid'];
$Email = $_GET['email'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "SELECT encryptid FROM users WHERE email='$Email'";
$result = mysql_query($query);
$creator = mysql_fetch_array($result);
$ID = $creator['encryptid'];
$query = "SELECT url FROM $comicstable WHERE comiccrypt='$ComicID' AND creatorid='$ID'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$Url = $user['url'];

  $creatorarray = array();
  $c_elem = null;
  
  function startElement3( $parser, $name, $attrs ) 
  {
  global $creatorarray, $c_elem;
  if ( $name == 'CREATOR' )$creatorarray []= array();
  $c_elem = $name;
  }
  
  function endElement3( $parser, $name ) 
  {
  global $c_elem;
  $c_elem = null;
  }
  
  function textData3( $parser, $text )
  {
  global $creatorarray, $c_elem;
  if ( $c_elem == 'INFLUENCES' ||
  $c_elem == 'BIO' ||
  $c_elem == 'ABOUT' ||
  $c_elem == 'LOCATION' ||
  $c_elem == 'CREATORNAME' ||
  $c_elem == 'WEBSITE' ||
  $c_elem == 'LINK1' ||
  $c_elem == 'LINK2' ||
  $c_elem == 'LINK3' ||
  $c_elem == 'LINK4' ||
  $c_elem == 'HOBBIES'||
  $c_elem == 'CREDITS'||
  $c_elem == 'MUSIC'||
  $c_elem == 'BOOKS'||
  $c_elem == 'ALLOWCOMMENTS'||
  $c_elem == 'AVATAR')
  {$creatorarray[ count($creatorarray ) - 1 ][ $c_elem ] = $text;
  }
  }
  
  $parser = xml_parser_create();
  
  xml_set_element_handler( $parser, "startElement3", "endElement3" );
  xml_set_character_data_handler( $parser, "textData3" );
  
  $f = fopen( $Url.'/xml/creatorXML.xml', 'r' );
  
  while( $data = fread( $f, 4096 ) )
  {
//print $data;
 // $data = htmlspecialchars($data);
 //echo "<br><br>";
   // print html_entity_decode(htmlentities($data));
	//print html_entity_decode($data);
  xml_parse( $parser, $data );
  }
  
  xml_parser_free( $parser );
  
  foreach($creatorarray as $creatoritem )
  {
  if ($creatoritem['INFLUENCES'] != ""){
  $Influences = $creatoritem['INFLUENCES'];
  //print "MY creatorarray INFLUENCES = " . $Influences;
  $query = "UPDATE $usertable SET influences='$Influences' WHERE encryptid='$ID'";
  $result = mysql_query($query);
 // print "<br/>".$query;
  }
  
  if ($creatoritem['CREATORNAME'] != ""){
  $Realname = $creatoritem['CREATORNAME'];
  }
  
  if ($creatoritem['CREDITS'] != ""){
  $Credits = $creatoritem['CREDITS'];
  
  }
  
  if ($creatoritem['MUSIC'] != ""){
  $Music = $creatoritem['MUSIC'];
  }
  
  if ($creatoritem['BOOKS'] != ""){
  $Books = $creatoritem['BOOKS'];
  }
  
   if ($creatoritem['ABOUT'] != ""){
  $Bio = htmlspecialchars($creatoritem['ABOUT']);
  }
  
   if ($creatoritem['BIO'] != ""){
  $Bio = htmlspecialchars($creatoritem['BIO']);
  }
  
  if ($creatoritem['WEBSITE'] != ""){
  $Website = $creatoritem['WEBSITE'];
  }
  
  if ($creatoritem['LINK1'] != ""){
  $Link1 = $creatoritem['LINK1'];
  }
  
  if ($creatoritem['LINK2'] != ""){
  $Link2 = $creatoritem['LINK2'];
  }
  
  if ($creatoritem['LINK3'] != ""){
  $Link3 = $creatoritem['LINK3'];
  }
  
  if ($creatoritem['LINK4'] != ""){
  $Link4 = $creatoritem['LINK4'];
  }
  
   if ($creatoritem['LOCATION'] != ""){
  $Location = htmlspecialchars($creatoritem['LOCATION']);
  }
  if ($creatoritem['HOBBIES'] != ""){
  $Hobbies = $creatoritem['HOBBIES'];
  }
  if ($creatoritem['AVATAR'] != ""){
  $Avatar = $creatoritem['AVATAR'];
  }
  
    if ($creatoritem['ALLOWCOMMENTS'] != ""){
  $AllowComments = $creatoritem['ALLOWCOMMENTS'];
  }
 }

$query = "UPDATE $usertable SET location='$Location' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;


$query = "UPDATE $usertable SET about='$Bio' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET hobbies='$Hobbies' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br/>".$query;

$query = "UPDATE $usertable SET music='$Music' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br/>".$query;

$query = "UPDATE $usertable SET books='$Books' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br/>".$query;

$query = "UPDATE $usertable SET influences='$Influences' WHERE encryptid='$ID'";
$result = mysql_query($query);

//print "<br/>".$query;

$query = "UPDATE $usertable SET website='$Website' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET credits='$Credits' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET link1='$Link1' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET link2='$Link2' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET link3='$Link3' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

$query = "UPDATE $usertable SET link4='$Link4' WHERE encryptid='$ID'";
$result = mysql_query($query);

$query = "UPDATE $usertable SET allowcomments='$AllowComments' WHERE encryptid='$ID'";
$result = mysql_query($query);
//print "<br />".$query;

?>
