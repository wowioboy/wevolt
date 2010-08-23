<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class register {
		
					public function generate_salt () {
						 // Declare $salt
						 $salt = '';
	
						 // And create it with random chars
						 for ($i = 0; $i < 3; $i++) {
							  $salt .= chr(rand(35, 126));
						 }
						 return $salt;
					}
	
					public function createAccount($Username, $Email, $Password='', $Gender, $Overage, $Birthday, $RealName,$Ref='',$verified=0,$IsPublisher=0) {
								
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$query = "SELECT count(*) FROM users where email='".$Email."'";
								$EmailExists = $db->queryUniqueValue($query);
								
								$Username = str_replace(" ", "_", trim($Username));
								$Username = str_replace("'", "", $Username);
								$Username = str_replace('"', "", $Username);
								$Username = str_replace("/", "", $Username);
								$Username = str_replace("&", "", $Username);
									
								if ($EmailExists > 0)
									$RegResult = 'Email Exists';
								else
									$RegResult = 'Clear';
							
								
								if ($RegResult == 'Clear') {

									$query = "SELECT count(*) FROM users where lower(username)='".mysql_real_escape_string(trim(strtolower($Username)))."'";
									$UserExists = $db->queryUniqueValue($query);
									if ($UserExists > 0)
										$RegResult = 'User Exists';
									else
										$RegResult = 'Clear';
								}
								
								if ($RegResult == 'Clear') {
										$UsersDirectory = $_SERVER['DOCUMENT_ROOT'].'/users/';
																		
										if(!is_dir($UsersDirectory. $Username)) { 
											@mkdir($UsersDirectory.$Username); chmod($UsersDirectory.$Username, 0777); 
										}
									
										if(!is_dir($UsersDirectory.$Username."/avatars")) { 
											@mkdir($UsersDirectory.$Username."/avatars"); chmod($UsersDirectory.$Username."/avatars", 0777); 
											@mkdir($UsersDirectory.$Username."/pdfs"); chmod($UsersDirectory.$Username."/pdfs", 0777); 
											@mkdir($UsersDirectory.$Username."/media"); chmod($UsersDirectory.$Username."/media", 0777); 
										}
																	
										copy($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/avatars/index.html");
										copy($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/index.html");
										copy($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/pdfs/index.html");
										
										$time = date('Y-m-d H:i:s'); 
										if (trim(strtolower($Gender)) == 'm')
											$Avatar = 'tempavatar.jpg';
										else if (trim(strtolower($Gender)) == 'f')
											$Avatar = 'tempavatarF.jpg';
										else 
											$Avatar = 'tempavatar.jpg';
											
										$gif = file_get_contents('http://www.wevolt.com/images/'.$Avatar);
										$LocalAvatar = $UsersDirectory.$Username.'/avatars/'.$Username.'_'.date('Y-m-d-H-i-s').'.jpg';
										$fp  = fopen($LocalAvatar, 'w+') or die('Could not create the file');
										fputs($fp, $gif) or die('Could not write to the file');
										fclose($fp);
										chmod($LocalAvatar,0777);
										$Avatar = 'http://www.wevolt.com/users/'.$Username.'/avatars/'.$Username.'_'.date('Y-m-d-H-i-s').'.jpg';
		
										$salt =  $this->generate_salt();
										$salt = str_replace("'", "!", $salt);
										
										$chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKLMNOPQRSTUV";
										srand((double)microtime()*1000000);
										$i = 0;
										$authode = '' ;
										while ($i <= 11) {
												$num = rand() % 33;
												$tmp = substr($chars, $num, 1);
												 $authode = $authode . $tmp;
												$i++;
										}
										
										$encrypted = md5(md5($Password).$salt);
										$query = "INSERT into users (username, email, password, salt, avatar, joindate, verified,realname,overage,gender,birthdate,authcode,referral,IsPublisher) values ('".mysql_real_escape_string($Username)."', '".$Email."', '$encrypted', '$salt', '$Avatar','$time','$verified','".mysql_real_escape_string($RealName)."','".strtolower($Overage)."','".strtolower($Gender)."','".strtolower($Birthday)."','".trim($authode)."','$Ref','$IsPublisher')";
										$db->execute($query);
										 
										$query = "SELECT userid FROM users WHERE username='".mysql_real_escape_string($Username)."' and email ='".$Email."'";
										$ID = $db->queryUniqueValue($query);
										$Encryptid = substr(md5($ID), 0,15).dechex($ID);
										
										$UserClear = 0;
										$Inc = 5;
										while ($UserClear == 0) {
												$query = "SELECT count(*) from users where encryptid='$Encryptid'";
												$Found = $db->queryUniqueValue($query);
												if ($Found == 1) {
													$Encryptid = substr(md5(($ID+$Inc)), 0, 15).dechex($ID+$Inc);
												} else {
													$query = "UPDATE users SET encryptid='$Encryptid' WHERE userid='$ID'";
													$db->execute($query);
													$UserClear = 1;
													$UserID = $Encryptid;
												}
												$Inc++;
										}
										$RegResult = $Encryptid;
										$query = "INSERT into users_settings (UserID) values ('$Encryptid')";
										$db->execute($query);
										
										$copy = 'theunlisted@gmail.com';
										$to = $_POST['regemail'];
										
										$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
										$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
										$header .= "X-Mailer: PHP/" . phpversion() . "\n";
										$header .= "X-Priority: 1";
										
									   //Send Account Email			
										$subject = "Your new WEvolt User Account";
										$body = "Hi, ".$Username.", thank you for registering with WEvolt. We hope you enjoy your experience.\n\nFor your records your login information is as follows, you will use your EMAIL ACCOUNT to login in.\n\nUSERNAME: ".$Username."\nEMAIL: ".$_POST['regemail']."\nPASSWORD: ".$password."\n\nIf you have any questions feel free to contact us at : listenup@wevolt.com \n\nCheers! \nThe WEvolt Team";
										$body .= "\n\n---------------------------\n";
										//SEND USER EMAIL
										 mail($to, $subject, $body, $header);
										 //SEND COPY
										 mail($copy, $subject, $body, $header);
										
										//Send Verification Email
										$subject = "WEvolt Account Verification";
										$body = "Hi, ".$Username.", please click the following link to complete your account verification.\n\nAfter your account is verified you can create create projects, blogs, WE pages and more. \n\nVERIFICATION LINK : http://www.wevolt.com/verifyaccount.php?id=".$Encryptid."&authcode=".trim($authode)."\n\nIf clicking on the link does not work, copy the link and paste it into your browser. \n\nCheers! \nThe WEvolt Team";
										$body .= "\n\n---------------------------\n";
										 mail($to, $subject, $body, $header);
										 mail($copy, $subject, $body, $header);
										 
										//SEND NOTICE EMAIL
										$subject = "A new user has registered for an account";
										$body = "Hi, ".$Username.", at ".$_POST['regemail']." has registered for a new account";
										$body .= "\n\n---------------------------\n";
										mail($copy, $subject, $body, $header);
								}
								$db->close();
								
								return 	$RegResult;
					}
					

					
	}



?>