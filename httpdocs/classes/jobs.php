<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class jobs {
	
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

	
		public function getJob($JobID) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "select j.*,p.Title as ProjectTitle, p.thumb as ProjectThumb, p.SafeFolder 
						from pf_jobs as j
						left join projects as p on j.project_id=p.ProjectID
						where j.encrypt_id='$JobID'";
			$this->JobArray = $db->queryUniqueObject($query);
			return $this->JobArray;
			$db->close();
			
			
		}
		
		public function getJobPositions($JobID, $UserID) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "select p.*,c.title as CatTitle 
						from pf_jobs_positions as p
						join pf_jobs_cats as c on p.job_type=c.id
						where p.job_id='$JobID' and p.hired=0";
			$db->query($query);
			$this->PositionArray = array();
			while ($line = $db->fetchNextObject()) {
					$db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$query = "SELECT count(*) from pf_jobs_applications where user_id='$UserID' and position_id='".$line->encrypt_id."'";
					$AlreadyApplied = $db2->queryUniqueValue($query);
					$db2->close();
					$this->PositionArray[] = array (
													'PositionID'=>$line->encrypt_id,
											  		'Title'=>$line->CatTitle,
													'Description'=>$line->description,
													'Rate'=>$line->rate,
													'RateType'=>$line->rate_type,
													'Start'=>$line->start_date,
													'Due'=>$line->due_date,
													'AlreadyApplied'=>$AlreadyApplied
													); 	
				
			}
			return $this->PositionArray;
			$db->close();
			
			
		}
		public function myTruncate($string, $limit, $break=".", $pad="...") { 

				if(strlen($string) <= $limit) return $string; 

				if(false !== ($breakpoint = strpos($string, $break, $limit))) { if($breakpoint < strlen($string) - 1) { $string = substr($string, 0, $breakpoint) . $pad; } }
				
				 return $string; 

		}
		
		public function getJobs($CatID, $Search) {
		
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			include_once($_SERVER['DOCUMENT_ROOT'].'/classes/jobs_pages.php');
			$query = "select * from pf_jobs";
			$Today = date('Y-m-d h:i:s');
			if ($Search != '') {
					$where = " where tags LIKE '%".mysql_real_escape_string($Search)."%' or title LIKE '%".mysql_real_escape_string($Search)."%'";
			
			}
			
			if ($CatID != '') {
				if ($where == '')
					$where = ' where ';
				else 
					$where .= ' and ';
				
				$where.= " cat_id='$CatID'";
			}
			
			$where .= " and publshed=1";
			
			
			$where .= " and (deadline='0000-00-00 00:00:00' or deadline>='$Today')";
			
			$refString = '';
			if ($_GET['p'] != '')
				$refString = '&p='.$_GET['p'];
			if ($_GET['cat'] != '')
				$refString .='&cat='.$_GET['cat'];	
			if ($_GET['search'] != '')
				$refString .='&search='.$_GET['search'];	
			$pagination    =    new pagination();  
			$pagination->createPaging($query,10);
			echo '<div class="cms_links" align="right">'.$pagination->displayPaging().'</div>';
			echo '<div class="spacer"></div>';
			 while($job=mysql_fetch_object($pagination->resultpage)) {
				 
				 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				 $query = "SELECT count(*) from pf_jobs_positions where job_id='".$job->id."'";
				 $TotalPositions = $db2->queryUniqueValue($query);
				 
				 if ($TotalPositions == 1) {
					 $query = "SELECT p.*, c.title as CatTitle 
					           from pf_jobs_positions as p
							   join pf_jobs_cats as c on c.id=p.job_type
					             where p.job_id='".$job->id."'";
					 $PositionArray = $db2->queryUniqueObject($query);
				 }
				 
				 $db2->close();
				
			
			echo '<table width="'.($_SESSION['contentwidth']-50).'" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td id="blue_cmsBox_TL"></td>
				  <td id="blue_cmsBox_T"></td>
				  <td id="blue_cmsBox_TR"></td></tr>
				  <tr><td class="blue_cmsBox_L" background="http://www.wevolt.com/images/cms/blue_cms_box_L.png" width="8"></td>
				  <td class="blue_cmsboxcontent" valign="top" width="'.($_SESSION['contentwidth']-66).'" align="left">';
										
						echo '<table width="100%" cellspacing="5"><tr>';
						echo '<td class="blue_cmsboxcontent" valign="top" colspan="4">';
						echo '<div style="float:left;"><b>'.$job->title.'</b></div><div style="float:right;">posted: '.date('m-d-Y',strtotime($job->created_date)).'</div>';
						echo '<div class="spacer"></div></td></tr>';					
						echo '<tr>';
						echo '<td class="blue_cmsboxcontent" width="200" valign="top">';
						
						if ($TotalPositions > 1) {
							echo 'Open Positions: '.$TotalPositions;
							
						} else {
						echo '<b>Job Type:</b><br/>';
						echo $PositionArray->CatTitle;
							
						}
						
					
						echo '</td>';
						echo '<td class="blue_cmsboxcontent" valign="top" style="padding-left:10px;padding-right:10px;"><b>Description:</b><br/><div style="font-size:10px;">';
						echo nl2br($this->myTruncate($job->description, 75,".","..."));
						echo '</div>';
						echo '<div class="spacer"></div>';
						if ($job->deadline != '0000-00-00 00:00:00')
							echo 'DEADLINE: '. date('m-d-Y',strtotime($job->deadline));
						echo '</td>';
						echo '<td class="blue_cmsboxcontent" width="200">';
						echo '<div class="cms_links">';
						echo '<a href="http://www.wevolt.com/jobs.php?view='.$job->encrypt_id.$refString.'"><img src="http://www.wevolt.com/images/view_job.png" border="0"></a>&nbsp;&nbsp;';
						if ($_SESSION['userid'] == $job->user_id)
							echo '<a href="http://www.wevolt.com/jobs.php?edit='.$job->encrypt_id.$refString.'"><img src="http://www.wevolt.com/images/edit_grey.png" border="0"></a>';
						echo '</div>';
						echo '</td>';
						echo '</tr></table>';
										
             echo '</td><td class="blue_cmsBox_R" background="http://www.wevolt.com/images/cms/blue_cms_box_R.png" width="8"></td>
				   </tr><tr><td id="blue_cmsBox_BL"></td><td id="blue_cmsBox_B"></td>
				   <td id="blue_cmsBox_BR"></td>
				   </tr></tbody></table>';
				echo '<div class="spacer"></div>';		
			
			}
			$db->close();
			
			
		}
		public function drawCatSelect($MediaID=1,$CatID,$OnChange='get_cat(this.options[this.selectedIndex].value)',$Name='catSelect') {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			if ($MediaID=='')
				$MediaID=1;
			$query = "select * from pf_jobs_cats where media_id='$MediaID' order by title ASC";
			echo '<select name="'.$Name.'" id="'.$Name.'" onChange="'.$OnChange.';">';
			$db->query($query);
			while ($job = $db->fetchNextObject()) {
					echo '<option value="'.$job->id.'"';
					if ($CatID == $job->id)
						echo ' selected ';
					echo '>'.$job->title.'</option>';
			}
			echo '</select>';
			$db->close();
			
			
		}
		
		public function drawMediaSelect($MediaID=1,$OnChange='get_media(this.options[this.selectedIndex].value)',$Name='mediaSelect') {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "select * from pf_jobs_media order by title ASC";
			echo '<select name="'.$Name.'" id="'.$Name.'" onChange="'.$OnChange.';">';
			$db->query($query);
			while ($job = $db->fetchNextObject()) {
					echo '<option value="'.$job->id.'"';
					if ($MediaID == $job->id)
						echo ' selected ';
					echo '>'.$job->title.'</option>';
			}
			echo '</select>';
			$db->close();
			
			
		}
		
		
		  
	

	}




?>