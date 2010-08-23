<?php 
include '../includes/db.class.php';
$DB = new DB();
 $query = "SELECT * from comics where installed=1";
$DB->query($query);
while ($Comic = $DB->FetchNextObject()) {
		$ComicID = $Comic->comiccrypt;
		$ComicName = $Comic->title;
		$UserID =  $Comic->userid;
	
	
	
		print 'COMIC = '.$ComicName.'<br/>'; 
		$DB2 = new DB();
		
		$query = "SELECT count(*) from content_section where ProjectID='$ComicID'";
		$HasSections = $DB2->queryUniqueValue($query);
		
		
		if ($HasSections == 0) {
			$query = "UPDATE projects set installed=1,comiccrypt='$ComicID' where ProjectID='$ComicID'";
			 $DB2->execute($query);
			 print $query.'<br/>';
			$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Episodes', '$ComicID', '$UserID', 0, 'tabbed', '$CreatedDate','episodes')";
					$DB2->query($query);
					print $query.'<br/>';
					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Links', '$ComicID', '$UserID', 0, 'list', '$CreatedDate','links')";
					$DB2->query($query);
					print $query.'<br/>';
					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Reader', '$ComicID', '$UserID', 0, 'list', '$CreatedDate','reader')";
					$DB2->query($query);
					print $query.'<br/>';
					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Credits', '$ComicID', '$UserID', 0, 'tabbed', '$CreatedDate','credits')";
					$DB2->query($query);
					print $query.'<br/>';
					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Home', '$ComicID', '$UserID', 0, 'reader', '$CreatedDate','home')";
					$DB2->query($query);
					print $query.'<br/>';
					$query = "INSERT into content_section  (Title, ProjectID, UserID, IsCustom, Template, CreatedDate, TemplateSection) values ('Archives', '$ComicID', '$UserID', 0, 'thumb_list', '$CreatedDate','archives')";
					$DB2->query($query);
					print $query.'<br/>';
			
			
			
		}
	/*	if ($HasBlog > 0) {
		
				$query = "SELECT count(*) from content_section where ProjectID='$ComicID' and TemplateSection='blog'";
				$Found = $DB2->queryUniqueValue($query);
				
				if ($Found == 0) {
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,CreatedDate,TemplateSection, Variable1, Variable2) values ('Blog','$ComicID','$UserID',0,'2_column','$CreatedDate','blog','','')";
				$DB2->execute($query);
				print $query.'<br/>';
				}
		
		}
		*/	
	/*
	$query = "SELECT * from comic_settings where ComicID='$ComicID'";
	$SettingsArray = $DB2->queryUniqueObject($query);
	$Skin = $SettingsArray->Skin;
	$query = "SELECT * from template_skins where SkinCode='$Skin'";
	$SkinArray = $DB2->queryUniqueObject($query);
	//print $query.'<br/>';
	//print_r($SkinArray);
	$query = "SELECT count(*) from characters where ComicID='$ComicID'";
	$HasCharacters = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from comic_downloads where ComicID='$ComicID'";
	$HasDownloads = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from pf_store_items where ComicID='$ComicID'";
	$HasProducts = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from mobile_content where ComicID='$ComicID'";
	$HasMobile = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from links where ComicID='$ComicID'";
	$HasLinks = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from comic_pages where ComicID='$ComicID' and Episode=1";
	$HasEpisodes = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from comic_pages where ComicID='$ComicID' and PageType='pages'";
	$HasPages = $DB2->queryUniqueValue($query);
	
	$query = "SELECT count(*) from comic_pages where ComicID='$ComicID' and PageType='extras'";
	$HasGallery = $DB2->queryUniqueValue($query);
	
	//ARCHIVES
	//CREATOR
	//

	$CreatedDate = date('Y-m-d h:i:s');
	
	if ($HasCharacters > 0) {
			$Custom = $SettingsArray->CharactersCustom;
			$HTMLCode = $SettingsArray->CharactersHTML;
		
		$Template = $SkinArray->CharacterReader;
		$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Characters','$ComicID','$UserID','$Custom','$Template','$HTMLCode','$CreatedDate','characters')";
		$DB2->execute($query);
		print $query.'<br/>';
	}
		if ($SettingsArray->BioSetting != 0) {
				$Custom = $SettingsArray->CreditsCustom;
				$HTMLCode = $SettingsArray->CreditsHTML;
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Credits','$ComicID','$UserID','$Custom','tabbed','$HTMLCode','$CreatedDate','credits')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		
		if ($HasDownloads > 0) {
				$Custom = $SettingsArray->DownloadsCustom;
				$HTMLCode = $SettingsArray->DownloadsHTML;
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Downloads','$ComicID','$UserID','$Custom','tabbed','$HTMLCode','$CreatedDate','downloads')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		if ($HasProducts > 0) {
			   $query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Products','$ComicID','$UserID','0','tabbed','$HTMLCode','$CreatedDate','products')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		if ($HasEpisodes > 0) {
				$Custom = $SettingsArray->EpisodesCustom;
				$HTMLCode = $SettingsArray->EpisodesHTML;
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Episodes','$ComicID','$UserID','$Custom','tabbed','$HTMLCode','$CreatedDate','episodes')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		
		if ($HasMobile > 0) {
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Mobile','$ComicID','$UserID','0','thumb_list','$HTMLCode','$CreatedDate','mobile')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		
		if ($HasLinks > 0) {
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Links','$ComicID','$UserID','0','list','$HTMLCode','$CreatedDate','links')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		
		if ($HasPages > 0) {
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Reader','$ComicID','$UserID','0','','$HTMLCode','$CreatedDate','reader')";
				$DB2->execute($query);
				print $query.'<br/>';
		}
		
		if ($HasGallery > 0) {
				$query = "INSERT into content_section (Title,ProjectID,UserID,IsCustom,Template,HTMLCode,CreatedDate,TemplateSection) values ('Gallery','$ComicID','$UserID','0','lightbox','$HTMLCode','$CreatedDate','gallery')";
				$DB2->execute($query);
				print $query.'<br/>';
				$DB3 = new DB();
				$query = "SELECT * from comic_pages where ComicID='$ComicID' and PageType='extras' order by Position";
				$DB3->query($query);
				print $query.'<br/>';
				$Count = 0;
				while ($page = $DB3->FetchNextObject()) {
						if ($Count == 0) {
							$query = "INSERT into pf_galleries (UserID, ProjectID, GalleryType, Title, Description, PrivacySetting, CreatedDate) values ('$UserID', '$ComicID', 'image', 'Extras', 'Extra content', 'public', '$CreatedDate')";
							 $DB2->execute($query);	
							 print $query.'<br/>';
							 $query ="SELECT ID from pf_galleries where UserID='$UserID' and CreatedDate='$CreatedDate'";
							 $GalleryID =  $DB2->queryUniqueValue($query);
								print $query.'<br/>';
							 $query = "INSERT into pf_gallery_categories (UserID, ProjectID, Title, PrivacySetting, Position,CreatedDate) values ('$UserID', '$ComicID','Extras', 'public',1, '$CreatedDate')";
							 $DB2->execute($query);	
							 print $query.'<br/>';
							 $query ="SELECT ID from pf_gallery_categories where UserID='$UserID' and CreatedDate='$CreatedDate'";
							 $CategoryID =  $DB2->queryUniqueValue($query);
						print $query.'<br/>';
						}
						$count++;
						
						$query = "INSERT into pf_gallery_content (UserID, ProjectID, Title, Description, Tags, Filename, ThumbLg, ThumbMd, ThumbSm, CreatedDate, GalleryID, EncryptID, CategoryID, Position, PrivacySetting) values 
						('$UserID', 
						'$ComicID', 
						'".mysql_real_escape_string($page->Title)."', 
						'".mysql_real_escape_string($page->Comment)."', 
						'',
						'".$page->Filename."',  
						'".$page->ThumbLg."',
						'".$page->ThumbMd."',
						'".$page->ThumbSm."', 
						'".$page->PublishDate."', 
						'$GalleryID',
						'".$page->EncryptPageID."', 
						'$CategoryID', 
						'".$page->Position."', 
						'public')";	
						$DB2->execute($query);	
						print $query.'<br/>';		
				}
				
		}
			
			*/	
			
			

	
}
$DB->close();
$DB2->close();

?>


