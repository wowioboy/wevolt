<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class comment {
		
				
	
					public function pageComment($Section, $ProjectID, $PageID, $UserID, $Comment,$CommentUsername,$PostBack='',$ParentComment='0'){
											$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
											if (($_SESSION['userid'] != '') && ($UserID!='none')) {
											$BannedUsers = array('cjpuw','nizpw','qxqug','gligaclb','lshky','lribg','rbnrp','lady_sonia','vimax');
											if ($CommentUsername == '') 
												$CommentUsername = $_SESSION['username'];
												
											if (!in_array($CommentUsername,$BannedUsers)) {
												
												$CommentDate = date('D M j');
												$Comment = mysql_real_escape_string($Comment);
												$query = "SELECT c.CreatorID, c.SafeFolder, (SELECT email from users as u2 where u2.encryptid=c.CreatorID) as CreatorEmail
															from projects as c 
															where c.ProjectID='$ProjectID'";
												$CreatorArray = $db->queryUniqueObject($query);	
												$Email = $CreatorArray->CreatorEmail;
												$UID = $CreatorArray->CreatorID;
												$SafeFolder = $CreatorArray->SafeFolder;
												$query = "SELECT AllowPublicComents from comic_settings where ComicID='$ProjectID'";
												$AllowPublicComents  = $db->queryUniqueValue($query); 
												
												$query = "SELECT CommentNotify from panel_panel.users where email='$Email'";
												$CommentNotify  = $db->queryUniqueValue($query);
											
												
												if (($AllowPublicComents == 0) && ($UserID == 'none'))
													$PostComment = 0;
												else
													$PostComment = 1;
		
												if ($PostComment == 1) {
													
														if ($Section =='Pages'){ 
																$query = "INSERT into pagecomments 
																		  (comicid, pageid, userid, comment, commentdate, Username,ParentComment) 
																		   values 
																		   ('$ProjectID', '$PageID','$UserID','$Comment','$CommentDate','$CommentUsername','$ParentComment')";
														
																
															
														} else if ($Section == 'Blog') {
																$query = "INSERT into blogcomments 
																		  (ComicID, PostID, UserID, comment, commentdate, Username,ParentComment) 
																		   values 
																		   ('$ProjectID', '$PageID','$UserID','$Comment','$CommentDate','$CommentUsername','$ParentComment')";
														
														
														}
														$db->execute($query);
													
														//SEND AN EMAIL ALERT	
														if (($CommentNotify == 'both') || ($CommentNotify == 'email')) {
															$query = "SELECT * from comic_pages where EncryptPageID='$PageID' and ComicID='$ProjectID'";
															$PageArray = $db->queryUniqueObject($query);
															$PagePosition = $PageArray->Position;
															
															$PageLink = '<a href="'.$PostBack.'"></a>';
															$WePageLink = '<a href="javascript:void(0)" onclick="parent.window.location.href=\''.$PostBack.'\';"></a>';
															$to = $Email;
															$subject = 'A New Comment has been posted to your project';
															$body .= "------NEW COMMENT ----\nComment Date: ".$CommentDate."\nPage: ".$PageLink."\n\n".$CommentUsername." said: ".$Comment;
															$Webody .= "------NEW COMMENT ----\nComment Date: ".$CommentDate."\nPage: ".$WePageLink."\n\n".$CommentUsername." said: ".$Comment;
															
																mail($to, $subject, $body, "From: NO-REPLY@wevolt.com");
															
															
														}
														
														if (($CommentNotify == 'both') || ($CommentNotify == 'pfbox')) {
															$body = mysql_real_escape_string($body);
															$DateNow = date('m-d-Y');
															$query = "INSERT into panel_panel.messages 
																			(userid, sendername, senderid, subject, message, date) 
																			values 
																			('$UID','wevolt','64223ccf3b0','New Comment posted to your project','".mysql_real_escape_string($Webody)."','$DateNow')";
															$db->execute($query);
														}
												}
											}
											}
											$db->close();			
					}
					
					
					public function deleteComment($Section, $ProjectID, $PageID, $CommentID) {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								if ($Section == 'Extras')
									$query = "DELETE from extracomments WHERE id ='$CommentID' and comicid='$ProjectID' and pageid='$PageID'";
								else if ($Section == 'Blog')
									$query = "DELETE from blogcomments WHERE ID='$CommentID' and ComicID='$ProjectID' and PostID='$PageID'";
								else
									$query = "DELETE from pagecomments WHERE id ='$CommentID' and comicid='$ProjectID' and pageid='$PageID'";
								
								$db->execute($query);
								
								$query = "DELETE from pagecomments WHERE ParentComment ='$CommentID' and comicid='$ProjectID' and pageid='$PageID'";
								
								$db->execute($query);
								//print $query;
								$db->close();	
 
					}
	
	
	}



?>