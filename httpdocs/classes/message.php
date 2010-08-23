<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class message {
	
		var $Title;
		var $JobID;
		var $Description;	
		var $EncryptID;	
		var $CatID;
		var $Tags;
		var $Deadline;
		var $DeadnlineNotes;
		var $Rate;
		var $CreatedDate;
		var $Collaboration;
		var $Type;
		var $TutorialArray;
		var $TutorialWidth;


		public function sendMessage($FromUser, $ToUser, $Type,$ContentID='') {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			
			$query ="SELECT * from users where encryptid='$FromUser'";
			$FromArray=$db->queryUniqueObject($query);
			$output = $query.'<br/>';
			$query ="SELECT * from users where encryptid='$ToUser'";
			$ToArray=$db->queryUniqueObject($query);
			$output = $query.'<br/>';
			switch ($Type) {
				case 'application':
				$query = "select p.*,c.title as PosTitle, j.title as JobTitle, j.user_id as JobOwner 
						from pf_jobs_positions as p
						join pf_jobs_cats as c on p.job_type=c.id
						join pf_jobs as j on p.job_id=j.id
						where p.encrypt_id='$PositionID'";
				$PositionArray = $db->queryUniqueObject($query);
				$output .= $query.'<br/>';
				$Subject = "You have an application on your job posting";
				$Message = $FromArray->realname .' has applied for your job posting on WEvolt. To view the applicant visit this link: http://www.wevolt.com/jobs.php?a=applications&j='.$ContentID.'\r\n';
				$WeMessage = $FromArray->realname .' has applied for your job posting on WEvolt. To view the applicant visit this link: <a href="javascript:void(0)" onclick="window.location.href=\'http://www.wevolt.com/jobs.php?a=applications&j='.$ContentID.'\';">http://www.wevolt.com/jobs.php?a=applications&j='.$ContentID.'</a>\r\n';
				break;
			}
				  //SEND WEmail
				  $query = "INSERT into messages (userid, sendername, senderid, subject, message, date) values ('$FriendID','".$FromArray->username."','".$FromUser."','$Subject','".mysql_real_escape_string($WeMessage)."','$CreateDate')";
				  $db->execute($query);
				  $output .= $query.'<br/>';
				 
				  //SEND EMAIL
				  $header = "From: noreply@wevolt.com  <noreply@wevolt.com >\n";
				  $header .= "Reply-To: noreply@wevolt.com <noreply@wevolt.com>\n";
	              $header .= "X-Mailer: PHP/" . phpversion() . "\n";
	              $header .= "X-Priority: 1";
				  $to = $ToArray->email;
				  $subject = $Subject .' on WEvolt';
   				  mail($to, $subject, $Message, $header);
			$db->close();
				return $output;
			
		}
		
		  


	}




?>