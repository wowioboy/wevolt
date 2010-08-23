<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/pagination.php');
							$query = "SELECT * from pf_gallery_content where GalleryID='Extras' and ProjectID='eed5af6a1b7'order by Position ASC";
							$pagination    =    new pagination();  
							
							$pagination->createPaging($query,20); 
							$String = "<table  border='0' cellspacing='0' cellpadding='0'><tr>";
							while($line=mysql_fetch_object($pagination->resultpage)) {
								$String .= "<td width='110'><a href='/".$SafeFolder."/".$ContentUrl."/?gid=".$_GET['gid']."&item=".$line->EncryptID."' border='1' >";
								$String .= "<img src='/".$line->Thumb100."' class='g_module_thumb' vspace='5' hspace='5'></td>";
								if ($Count == 5) {
									$String .= "</tr><tr>";
									$Count = 1;
								} else {
									$Count++;
								}
						
							}
							if (($Count < 5) && ($Count != 1)) {
								while ($Count <=5) {
									$String .= '<td></td>';	
									$Count++;
								}
						
							}
							$String .= '</tr></table>';	
				echo 'STring = ' . $String;			
							?>