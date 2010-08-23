<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class tutorial {
	
		var $Title;
		var $Description;	
		var $EncryptID;	
		var $TutorialID;
		var $Tags;
		var $TutorialArray;
		var $TutorialWidth;

		function __construct($TutorialID='') {
			
			$this->TutorialWidth = '800';
			if ($TutorialID == '') {
				$this->getTutorials();
			} else {
				
				$this->TutorialID = $TutorialID;
				$this->getTutorialSettings();
				
			}
			
		}
		 
		
		public function getTutorialSettings() {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "select t.*,ts.NextButton, ts.PreviousButton, ts.FooterCustom, ts.Width
					  from panel_tutorials.tutorial as t
					  join panel_tutorials.tutorial_settings as ts
					  where t.ID='".$this->TutorialID."'"; 
			$this->TutorialArray = $db->queryUniqueObject($query);
	
			$db->close();
		}
		
		public function buildStep($Step) {
			if ($Step == '')
				$Step = 1;
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "SELECT te.*, (select count(*) from panel_tutorials.tutorial_entry where TutorialID='".$this->TutorialID."'  and te.IsPublished=1) as TotalSteps
			           from panel_tutorials.tutorial_entry as te 
					   where te.TutorialID='".$this->TutorialID."' and te.Position='$Step' and te.IsPublished=1";
			$EntryArray = $db->queryUniqueObject($query);
			
			if (($Step == '') || ($Step == '1'))
				$PrevStep = 1;
			else
				$PrevStep = ($Step - 1);
			
			if ($Step == $EntryArray->TotalSteps)
				$NextStep = $EntryArray->TotalSteps;
			else
				$NextStep = ($Step + 1);	
			echo '<table cellspacing="0" cellpadding="0" border="0" width="'.$this->TutorialWidth.'"><tr><td valign="top" colspan="3">';
			echo $EntryArray->StepHeader;
			echo '</td></tr>';
			echo '<tr><td valign="top" colspan="3">';
			echo nl2br(stripslashes($EntryArray->Content));
			echo '</td></tr>';
			echo '<tr><td valign="top" width="25%" align="left">';
			if ($Step != 1) {
				echo '<a href="/tutorial/?tid='.$this->TutorialID.'&step='.$PrevStep.'">';
				if ($this->TutorialArray->FooterCustom == 1) 
					echo '<img src="'.$this->TutorialArray->PreviousButton.'" border="0">';
				else
					echo 'PREVIOUS';
				echo '</a>';
			}
			echo '</td>';
			echo '<td valign="top" width="75%">';
			if ($this->TutorialArray->FooterCustom == 1) 
				echo '<div align="center">'.$EntryArray->StepFooter.'</div>';
			else
				echo '<div class="steplinks">Step '.$Step .' of '. $EntryArray->TotalSteps.'</div>';
				
			echo '</a>';
			echo '</td>';
			echo '<td valign="top" width="25%" align="right">';
			if ($Step <$EntryArray->TotalSteps) {
				echo '<a href="/tutorial/?tid='.$this->TutorialID.'&step='.$NextStep.'">';
				if ($this->TutorialArray->FooterCustom == 1) 
					echo '<img src="'.$this->TutorialArray->NextButton.'" border="0">';
				else
					echo 'NEXT';
				echo '</a>';
			}
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			
			$db->close();
		}
			
		public function get_title() {
				return $this->TutorialArray->Title;
		}
			
			
	

	}




?>