<?php
   include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
  class SMSSend
  { 
  	var $SMSID = 0;
	
    function GetCarriers()
    {
      $Carrier[] = "Alltel|snpp.alltel.net|444|160";  
      $Carrier[] = "AT&T Free2Go|@mmode.com||160"; 
      $Carrier[] = "AT&T PCS|@mobile.att.net||160"; 
      $Carrier[] = "AT&T Wireless|@txt.att.net||456";
      $Carrier[] = "Bell South|@sms.bellsouth.com||160";
      $Carrier[] = "Bell South (Blackberry)|@bellsouthtips.com||160";
      $Carrier[] = "Boost|@myboostmobile.com||160";
      $Carrier[] = "Cingular|snpp.cingular.com|444|456";
      $Carrier[] = "Comcast|@comcastpcs.textmsg.com||160";
      $Carrier[] = "GTE|@gte.pagegate.net||160";
      $Carrier[] = "Nextel|pecos.nextel.com|444|160"; 
      $Carrier[] = "Qwest|@qwestmp.com||160";
      $Carrier[] = "SBC|snpp.sbc.com|444|160";
      $Carrier[] = "Skytel|snpp.skytel.com|7777|240";
      $Carrier[] = "Sprint|snpp.messaging.sprint.com|444|160";
      $Carrier[] = "T-Mobile|@tmomail.net||160"; 
      $Carrier[] = "Verizon PCS|@vtext.com||160";
      $Carrier[] = "Virgin Mobile|@vmobl.com||160";
    
      return $Carrier;
    }
    
    function Send($carrierindex, $phonenumber, $subject, $message)
    {
	  $Carriers = $this->GetCarriers();
      list($name, $server, $port, $length) = split('[|]', $Carriers[$carrierindex]);
      if ($server[0] == '@')
        return $this->SendSMTP($carrierindex, $phonenumber, $subject, $message);
      else
        return $this->SendSNPP($carrierindex, $phonenumber, $subject, $message);
    }
    
    function SendSMTP($carrierindex, $phonenumber, $subject, $message)
    {
      $result = 'SUCCESS';
      $Carriers = $this->GetCarriers();
      
      list($name, $server, $port, $length) = split('[|]', $Carriers[$carrierindex]);
      
      $to = $phonenumber . $server;
	  
	  
	  if (!mail($to, $subject, $message, "From: noreply@panelflow.com")) 
      {
        $result = 'FAILURE - SMTP';
      }
	  
	  $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	  $query = "INSERT INTO smssendlog (smsid, type, function, phonenumber, server, port, subject, message, result, creationdate) 		VALUES (" ;
	  $query .= $this->SMSID . ", 0, 'send', ";
	  $query .= "'" . mysql_real_escape_string($phonenumber) . "', ";
	  $query .= "'" . mysql_real_escape_string($server) . "', ";
	  $query .= "'" . mysql_real_escape_string($port) . "', ";	  	  
	  $query .= "'" . mysql_real_escape_string($subject) . "', ";
	  $query .= "'" . mysql_real_escape_string($message) . "', ";
	  $query .= "'" . mysql_real_escape_string($result) . "', ";
	  $query .= "NOW())";
	  $db->execute($query);
	  $db->close();
    
	  return $result;
    }
    
    function SendSNPP($carrierindex, $phonenumber, $subject, $message)
    {
      $result = 'SUCCESS';
      $Carriers = $this->GetCarriers();
	  
	  list($name, $server, $port, $length) = split('[|]', $Carriers[$carrierindex]);
      try
	  {
	  	  $telnetPointer = fsockopen($server, $port);
		  list($code, $desc, $type, $resultmsg) = split('[ ]', fgets($telnetPointer));
		  if ($code > 250)
			$result = 'FAILURE - Failed carrier connect';
	  }
	  catch (Exception $e)
	  {
	   		$result = 'FAILURE - Failed carrier connect';
	  }
	  
	  try
	  {
		  if ($result == 'SUCCESS')
		  { 
			fwrite($telnetPointer, "PAGE $phonenumber\r\n");
			list($code, $desc, $type, $resultmsg) = split('[ ]', fgets($telnetPointer));
			if ($code > 250)
			  $result = 'FAILURE - Carrier did not accept number';
		  }
		  
		  /*if ($result == 'SUCCESS')
		  {
			fwrite($telnetPointer, "SUBJ $subject\r\n");
			fgets($telnetPointer);
		  }*/
		  
		  if ($result == 'SUCCESS')
		  {
			  fwrite($telnetPointer, "MESS $message\r\n");
			  list($code, $desc, $type, $resultmsg) = split('[ ]', fgets($telnetPointer));
			  if ($code > 250)
				$result = 'FAILURE - Carrier did not accept message';
		  }
		  
		  if ($result == 'SUCCESS')
		  {
			  fwrite($telnetPointer, "SEND\r\n");
			  list($code, $desc, $type, $resultmsg) = split('[ ]', fgets($telnetPointer));
			  if ($code > 250)
				$result = 'FAILURE - Carrier did not accept send';
		  }
		  
		  if ($result == 'SUCCESS')
		  {
			  fwrite($telnetPointer, "QUIT\r\n");
			  fgets($telnetPointer);
		  }
		  
		   $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
		  $query = "INSERT INTO smssendlog (smsid, type, function, phonenumber, server, port, subject, message, result, resulttype, resultcode, resultdesc, resultmsg, creationdate) 		VALUES (" ;
		  $query .= $this->SMSID . ", 0, 'send', ";
		  $query .= "'" . mysql_real_escape_string($phonenumber) . "', ";
		  $query .= "'" . mysql_real_escape_string($server) . "', ";
		  $query .= "'" . mysql_real_escape_string($port) . "', ";	  	  
		  $query .= "'" . mysql_real_escape_string($subject) . "', ";
		  $query .= "'" . mysql_real_escape_string($message) . "', ";
		  $query .= "'" . mysql_real_escape_string($result) . "', ";
		  $query .= "'" . mysql_real_escape_string($type) . "', ";
		  $query .= "'" . mysql_real_escape_string($code) . "', ";
		  $query .= "'" . mysql_real_escape_string($desc) . "', ";		  		  		  
		  $query .= "'" . mysql_real_escape_string($resultmsg) . "', ";		  		  		  		  
		  $query .= "NOW())";
		  $db->execute($query);
		  $db->close();
		  fclose($telnetPointer);
	  }
	  catch (Exception $e)
	  {
	   		$result = 'FAILURE - Exception';
	  }   
	  return $result;  
    }
  }
?>