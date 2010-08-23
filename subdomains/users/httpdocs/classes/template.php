 <?
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class template {
	
		var $TemplateCode;
		var $SkinCode;
		var $CurrentTheme;
		var $TemplateArray;
		var $ProjectID;
		var $TemplateHTML;
		var $MenuCustom;
		var $SafeFolder;
		var $BodyStyle;
		
		function __construct($ProjectID,$CurrentTheme,$SkinCode,$TemplateCode, $MenuCustom) {
							$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			
							$query =  "SELECT ts.*,tsk.*, t.HTMLCode, t.MenuLayout, p.SafeFolder
								from pf_themes as th
								join templates as t on th.TemplateCode=t.TemplateCode
								join template_settings as ts on ('$TemplateCode'=ts.TemplateCode and th.ID=ts.ThemeID and ProjectID='$ProjectID')
								join project_skins as tsk on '$SkinCode'=tsk.SkinCode 
								join projects as p on p.ProjectID='$ProjectID'
								where th.ID='$CurrentTheme'";
							$this->TemplateArray = $db->queryUniqueObject($query);
						
							if ($this->TemplateArray->ID == '') {
								$this->NoTemplate = 1;
								$query =  "SELECT ts.*,tsk.*, t.HTMLCode, t.MenuLayout
											from pf_themes as th
											join templates as t on th.TemplateCode=t.TemplateCode
											join template_settings as ts on ('TPL-001'=ts.TemplateCode and th.ID=ts.ThemeID)
											join template_skins as tsk on '$SkinCode'=tsk.SkinCode 
											join projects as p on p.ProjectID='$ProjectID'
											where th.ID='$CurrentTheme'";
								$this->TemplateArray = $db->queryUniqueObject($query);
							}
							
					
								//print $query.'<br/>';
							$this->ProjectID = $ProjectID;
							$this->CurrentTheme=$CurrentTheme;
							$this->SkinCode = $SkinCode;
							$this->TemplateCode = $TemplateCode;
							$this->TemplateHTML = $this->TemplateArray->HTMLCode;
							$this->MenuCustom = $MenuCustom;
							$this->SafeFolder =  $this->TemplateArray->SafeFolder;
							$this->HeaderPlacement = $this->TemplateArray->HeaderPlacement;
							$this->ModuleSeparation =  $this->TemplateArray->ModuleSeparation;
							$db->close();
		}
		
		public function getTemplateHtml() {
						return $this->TemplateHTML;
		
		}
		
		public function getHeaderImage() {
		
					return $this->HeaderImage;
		}
		
		
		public function getTemplateSection($Section) {
	
					switch ($Section) {
							case ('Header'):
								$TargetWidth = $this->TemplateArray->HeaderWidth;
								$TargetHeight = $this->TemplateArray->HeaderHeight;
								$TargetImage = $this->TemplateArray->HeaderImage;
								$_SESSION['comicheader'] = $this->TemplateArray->HeaderImage;
								
								$TargetBackground = $this->TemplateArray->HeaderBackground;
								$TargetBackgroundRepeat =  $this->TemplateArray->HeaderBackgroundRepeat;
								$TargetContent = $this->TemplateArray->HeaderContent;
								$TargetLink = $this->TemplateArray->HeaderLink;
								$TargetRollover = $this->TemplateArray->HeaderRollover;
								$TargetAlign = $this->TemplateArray->HeaderAlign;
								$TargetBackgroundImagePosition = $this->TemplateArray->HeaderBackgroundImagePosition;
								$TargetPadding =  $this->TemplateArray->HeaderPadding;
								$TargetVAlign =  $this->TemplateArray->HeaderVAlign;
								$TargetScroll=  $this->TemplateArray->HeaderScroll;
								break;
							case ('Footer'):
								$TargetWidth = $this->TemplateArray->FooterWidth;
								$TargetHeight = $this->TemplateArray->FooterHeight;
								$TargetImage = $this->TemplateArray->FooterImage;
								$TargetBackground = $this->TemplateArray->FooterBackground;
								$TargetBackgroundRepeat =  $this->TemplateArray->FooterBackgroundRepeat;
								$TargetContent = $this->TemplateArray->FooterContent;
								$TargetLink = $this->TemplateArray->FooterLink;
								$TargetRollover = $this->TemplateArray->FooterRollover;
								$TargetAlign = $this->TemplateArray->FooterAlign;
								$TargetBackgroundImagePosition = $this->TemplateArray->FooterBackgroundImagePosition;
								$TargetPadding =  $this->TemplateArray->FooterPadding;
								$TargetVAlign =  $this->TemplateArray->FooterVAlign;
								$TargetScroll=  $this->TemplateArray->FooterScroll;
								break;
							case ('Content'):
								$TargetWidth = $this->TemplateArray->ContentWidth;
								$TargetHeight = $this->TemplateArray->ContentHeight;
								$TargetImage = $this->TemplateArray->ContentImage;
								$TargetBackground = $this->TemplateArray->ContentBackground;
								$TargetBackgroundRepeat =  $this->TemplateArray->ContentBackgroundRepeat;
								$TargetContent = $this->TemplateArray->ContentContent;
								$TargetLink = $this->TemplateArray->ContentLink;
								$TargetRollover = $this->TemplateArray->ContentRollover;
								$TargetAlign = $this->TemplateArray->ContentAlign;
								$TargetBackgroundImagePosition = $this->TemplateArray->ContentBackgroundImagePosition;
								$TargetPadding =  $this->TemplateArray->ContentPadding;
								$TargetVAlign =  $this->TemplateArray->ContentVAlign;
								$TargetScroll=  $this->TemplateArray->ContentScroll;
								
								break;
							case ('Menu'):
								$TargetWidth = $this->TemplateArray->MenuWidth;
								$TargetHeight = $this->TemplateArray->MenuHeight;
								$TargetImage = $this->TemplateArray->MenuImage;
								$TargetBackground = $this->TemplateArray->MenuBackground;
								$TargetBackgroundRepeat =  $this->TemplateArray->MenuBackgroundRepeat;
								$TargetContent = $this->TemplateArray->MenuContent;
								$TargetLink = $this->TemplateArray->MenuLink;
								$TargetRollover = $this->TemplateArray->MenuRollover;
								$TargetAlign = $this->TemplateArray->MenuAlign;
								$TargetBackgroundImagePosition = $this->TemplateArray->MenuBackgroundImagePosition;
								$TargetPadding =  $this->TemplateArray->MenuPadding;
								$TargetVAlign =  $this->TemplateArray->MenuVAlign;
								$TargetScroll=  $this->TemplateArray->MenuScroll;
								break;
					
					}
					
						$Align = 'text-align:'.$TargetAlign.';';
						$VAlign = 'vertical-alignment:'.$TargetVAlign.';';
						$BackgroundImagePosition = $TargetBackgroundImagePosition;
						$Padding = 'padding:'.$TargetPadding.';';
						if ($TargetBackground != '')
							$Background  ='background-image:url('.$TargetBackground.');';	
						if ($TargetBackgroundRepeat != '')
							$BackgroundRepeat  = 'background-repeat:'.$TargetBackgroundRepeat.';';
						if ($TargetBackgroundImagePosition != '')
							$BackgroundImagePosition  = 'background-position:'.$TargetBackgroundImagePosition.';';
					
						$Height  = 'height:'.$TargetHeight.';';
						$Width  = 'width:'.$TargetWidth.';';
					
						if ($TargetImage != '')
							$Image = '<img src="/'.$TargetImage.'" border="0">';
							
						if (($TargetLink != '') &&($TargetImage != ''))
							$Image = '<a href="'.$TargetLink.'">'.$Image.'</a>';
						else if ($TargetImage != '')
							$Image = '<a href="http://www.wevolt.com/'.$this->SafeFolder.'/">'.$Image.'</a>';
						
						if ($TargetScroll != '')
							$Scroll = 'scroll:'.$TargetScroll.';';
							
						$Content  = $Image.$TargetContent;
						$Style = $Width.$Height.$Background.$BackgroundRepeat.$BackgroundImagePosition.$Align.$VAlign.$Padding.$Scroll;
						
						$TemplateSectionArray = array (
														'Content'=> $Content,
														'Style'=> $Style
												);
						
						return $TemplateSectionArray; 
		}
		
		function setTemplate() {
				$TemplateWidth = $this->TemplateArray->TemplateWidth;
					if ($TemplateWidth == '')
						$TemplateWidth = '100%';
						
				if(($_SESSION['IsPro'] == 0) && ((TemplateWidthBase > 800) || ($TemplateWidth == '100%')|| ($TemplateWidth == '')))  {
					$TemplateWidth = '800px';
				} else if (($_SESSION['IsPro'] == 1) && ($TemplateWidth == '100%')|| ($TemplateWidth == ''))  {
					$TemplateWidth = '1000px';
				}  
				
				$TemplateWidth = 'width:'.$TemplateWidth.'; text-align=center;';
				$this->TemplateHTML=str_replace("{TemplateStyle}",$TemplateWidth,$this->TemplateHTML);
				
				//BUILD HEADER
				$HeaderSection = $this->getTemplateSection('Header');
				$this->TemplateHTML=str_replace("{HeaderStyle}",$HeaderSection['Style'],$this->TemplateHTML);
				$this->TemplateHTML=str_replace("{HeaderContent}",$HeaderSection['Content'],$this->TemplateHTML);
				
				//BUILD FOOTER
				$FooterSection = $this->getTemplateSection('Footer');
				$this->TemplateHTML=str_replace("{FooterStyle}",$FooterSection['Style'],$this->TemplateHTML);
				$this->TemplateHTML=str_replace("{FooterContent}",$FooterSection['Content'],$this->TemplateHTML);
				
				//SET MENU STYLE
				$MenuSection = $this->getTemplateSection('Menu');
				$this->TemplateHTML=str_replace("{MenuStyle}",$MenuSection['Style'],$this->TemplateHTML);
				$MenuContent = $MenuSection['Content'].$this->build_menus($this->CurrentTheme,$this->ProjectID,$this->MenuCustom,$this->TemplateArray->MenuLayout);
				$this->TemplateHTML=str_replace("{MenuContent}",$MenuContent,$this->TemplateHTML);

				//CONTENT STYLE
				$ContentContentSection = $this->getTemplateSection('Content');
				$this->ContentWidth = $ContentContentSection['Width'];
				$this->TemplateHTML=str_replace("{ContentStyle}",$ContentContentSection['Content'],$this->TemplateHTML);
		}
		
		public function insertTemplateContent($ContentString) {
		
				$this->TemplateHTML=str_replace("{ContentContent}",$ContentString,$this->TemplateHTML);
				
				return $this->TemplateHTML;
		}  
		
		function drawStyle() {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$query = "SELECT * from project_skins where SkinCode='".$this->SkinCode."'";
					
					$SkinArray= $db->queryUniqueObject($query);
									
					//BUTTONS
					$ButtonImage= $SkinArray->ButtonImage;
					$ButtonBGColor= $SkinArray->ButtonBGColor;
					$ButtonImageRepeat= $SkinArray->ButtonImageRepeat;
					$ButtonTextColor= $SkinArray->ButtonTextColor;
					$ButtonFontSize= $SkinArray->ButtonFontSize;
					$ButtonFontStyle= $SkinArray->ButtonFontStyle;
					$ButtonFontFamily = $SkinArray->ButtonFontFamily;
					$ButtonAlign = $SkinArray->ButtonAlign;
					$ButtonPaddingArray = explode(' ',$SkinArray->ButtonPadding);
					$ButtonPaddingTop = $ButtonPaddingArray[0];
					$ButtonPaddingRight = $ButtonPaddingArray[1];
					$ButtonPaddingBottom = $ButtonPaddingArray[2];
					$ButtonPaddingLeft = $ButtonPaddingArray[3];
							
					//CONTENT BOX
					if ($SkinArray->ModTopRightImage != '') 
						$ModTopRightImage= $BaseSkinDir.$SkinArray->ModTopRightImage;
					$ModTopRightBGColor= $SkinArray->ModTopRightBGColor;
			
					if ($SkinArray->ModTopLeftImage != '') 
						$ModTopLeftImage= $BaseSkinDir.$SkinArray->ModTopLeftImage;
					$ModTopLeftBGColor= $SkinArray->ModTopLeftBGColor;
					
					if ($SkinArray->ModBottomLeftImage != '') 
						$ModBottomLeftImage= $BaseSkinDir.$SkinArray->ModBottomLeftImage;
					$ModBottomLeftBGColor= $SkinArray->ModBottomLeftBGColor;
					
					if ($SkinArray->ModBottomRightImage != '') 
						$ModBottomRightImage= $BaseSkinDir.$SkinArray->ModBottomRightImage;
					$ModBottomRightBGColor= $SkinArray->ModBottomRightBGColor;
					
					if ($SkinArray->ModRightSideImage != '') 
						$ModRightSideImage= $BaseSkinDir.$SkinArray->ModRightSideImage;
					$ModRightSideBGColor= $SkinArray->ModRightSideBGColor;
					
					if ($SkinArray->ModLeftSideImage != '') 
						$ModLeftSideImage= $BaseSkinDir.$SkinArray->ModLeftSideImage;
					$ModLeftSideBGColor= $SkinArray->ModLeftSideBGColor;
					
					if ($SkinArray->ModTopImage != '') 
						$ModTopImage= $BaseSkinDir.$SkinArray->ModTopImage;
					$ModTopBGColor= $SkinArray->ModTopBGColor;
					
					if ($SkinArray->ModBottomImage != '') 
						$ModBottomImage= $BaseSkinDir.$SkinArray->ModBottomImage;
					$ModBottomBGColor= $SkinArray->ModBottomBGColor;
					
					if ($SkinArray->ContentBoxImage != '') 
						$ContentBoxImage= $BaseSkinDir.$SkinArray->ContentBoxImage;
					$ContentBoxBGColor= $SkinArray->ContentBoxBGColor;
					
					$ContentBoxImageRepeat= $SkinArray->ContentBoxImageRepeat;
					$ContentBoxTextColor= $SkinArray->ContentBoxTextColor;
					$ContentBoxFontSize= $SkinArray->ContentBoxFontSize;
					$Corner= $SkinArray->Corner;
					$ModuleSeparation = $SkinArray->ModuleSeparation;
					$RightColumnWidth = $SkinArray->RightColumnWidth;
					$LeftColumnWidth = $SkinArray->LeftColumnWidth;
					
					list($CornerWidth,$CornerHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopLeftImage);
					echo '<style type="text/css" media="screen">';
					echo '#top { 
								outline:none; 
								background-color:#'.$SkinArray->ControlBarBGColor.';
							}';
					
					echo '#bottomcontrols { 
									outline:none;
									display:block;  
							}';
					echo '#mpl {
								outline:none;
								display:block;  
							}';		
						
					echo '#pfreader {
								outline:none;
								display:block;  
							}';		
					echo '#pagediv {
								outline:none;
								display:block;  
							}';	
					echo '#bubble_tooltip{
							width:300px;
							position:absolute;
						    display:none;
							z-index:3;
						}';
						
					echo '#bubble_tooltip .bubble_top{
								background-image: url(/'.PFENGINEDIR.'/images/bubble_top.png);
								background-repeat:no-repeat;
								height:16px;	
							}';
							
					echo '#bubble_tooltip .bubble_middle{
							background-image: url(/'.PFENGINEDIR.'/images/bubble_middle.png);
							background-repeat:repeat-y;	
							background-position:bottm left;
							padding-left:7px;
							padding-right:7px;
					}';
					
					echo '#bubble_tooltip .bubble_middle span{
									position:relative;
									top:-8px;
									font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
									font-size:11px;
							}';
					echo '#bubble_tooltip .bubble_bottom{
							background-image: url(/'.PFENGINEDIR.'/images/bubble_bottom.png);
							background-repeat:no-repeat;
							background-repeat:no-repeat;	
							height:44px;
							position:relative;
							top:-6px;
						}';

					echo '#facebox .body {
							  padding: 10px;
							  background: #'.$SkinArray->ContentBoxBGColor.';
							  width: 370px;
						}';

					echo '#facebox .b {
						  background:url(/'.PFENGINEDIR.'/scripts/facebox/b.png);
						}';
					
					echo '#facebox .tl {
						  background:url(/'.PFENGINEDIR.'/scripts/facebox/tl.png);
						}';
					
					echo '#facebox .tr {
						  background:url(/'.PFENGINEDIR.'/scripts/facebox/tr.png);
						}';
					
					echo '#facebox .bl {
						  background:url(/'.PFENGINEDIR.'/scripts/facebox/bl.png);
						}';
					
					echo '#facebox .br {
						  background:url(/'.PFENGINEDIR.'/scripts/facebox/br.png);
						}';

					echo '.tabactive {
							height:12px;
							background-color:#'.$SkinArray->GlobalTabActiveBGColor.';
							text-align:center;
							padding:5px;
							cursor:pointer;';
							if ($SkinArray->GlobalTabActiveFontStyle != '') {
								if ($SkinArray->GlobalTabActiveFontStyle == 'bold') 
									$StyleTag = 'font-weight:bold;';
								if ($SkinArray->GlobalTabActiveFontStyle == 'regular')  
									$StyleTag = 'font-style:normal;';
								if ($SkinArray->GlobalTabActiveFontStyle == 'underline') 
									$StyleTag = 'text-decoration:underline;';
								echo $StyleTag;	
							}
							echo 'font-size:'.$SkinArray->GlobalTabActiveFontSize.'px;
							width:100px;
							color:#'.$SkinArray->GlobalTabActiveTextColor.';
					}';
					
					echo '.tabinactive { 
								height:12px;
								background-color:#'.$SkinArray->GlobalTabInActiveBGColor.';
								text-align:center;
								padding:5px;
								cursor:pointer;';
								if ($SkinArray->GlobalTabInActiveFontStyle != '') {
									if ($SkinArray->GlobalTabInActiveFontStyle == 'bold') 
										$StyleTag = 'font-weight:bold;';
									if ($SkinArray->GlobalTabInActiveFontStyle == 'regular') 
										$StyleTag = 'font-style:normal;';
									if ($SkinArray->GlobalTabInActiveFontStyle == 'underline') 
										$StyleTag = 'text-decoration:underline;';
									echo $StyleTag;	
								}
								echo 'font-size:'.$SkinArray->GlobalTabInActiveFontSize.'px;
								width:100px;
								color:#'.$SkinArray->GlobalTabInActiveTextColor.';
					}';
					echo '.tabhover{
								height:12px;
								background-color:#'.$SkinArray->GlobalTabHoverBGColor.';
								text-align:center;
								padding:5px;
								cursor:pointer;';
								if ($SkinArray->GlobalTabHoverFontStyle != '') {
									if ($SkinArray->GlobalTabHoverFontStyle == 'bold') 
										$StyleTag = 'font-weight:bold;';
									if ($SkinArray->GlobalTabHoverFontStyle == 'regular') 
										$StyleTag = 'font-style:normal;';
									if ($SkinArray->GlobalTabHoverFontStyle == 'underline') 
										$StyleTag = 'text-decoration:underline;';
									echo $StyleTag;	
								}
								echo 'font-size:'.$SkinArray->GlobalTabHoverFontSize.'px;
								width:100px;
								color:#'.$SkinArray->GlobalTabHoverTextColor.';
					}';

					echo '.peeltabactive {
							height:10px;
							background-color:#'.$SkinArray->GlobalTabActiveBGColor.';
							text-align:center;
							padding:5px;
							cursor:pointer;
							font-size:10px;
							width:50px;
							color:#'.$SkinArray->GlobalTabActiveTextColor.';
					}';
					echo '.peeltabinactive {
							height:10px;
							background-color:#'.$SkinArray->GlobalTabInActiveBGColor.';
							text-align:center;
							padding:5px;
							cursor:pointer;
							font-size:10px;
							width:50px;
							color:#'.$SkinArray->GlobalTabInActiveTextColor.';
					}';
					echo '.peeltabhover{
                            height:10px;
                            background-color:#'.$SkinArray->GlobalTabHoverBGColor.';
                            text-align:center;
                            padding:5px;
                            cursor:pointer;
                            font-size:10px;
                            width:50px;
                            color:#'.$SkinArray->GlobalTabHoverTextColor.';
					}';
					
					echo '#projectmodrightside {';
							if ($SkinArray->ModRightSideImage != '')
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModRightSideImage.');
                            		  background-repeat:repeat-y;';

                           if ($SkinArray->ModRightSideBGColor != '')
                           	 echo 'background-color:#'.$SkinArray->ModRightSideBGColor.';';

                            echo 'width: '.$CornerWidth.'px;
					}';
					
					echo '#projectmodleftside {';
							if ($SkinArray->ModRightSideImage != '')
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModLeftSideImage.');
                            		  background-repeat:repeat-y;';

                           if ($SkinArray->ModRightSideBGColor != '')
                           	 echo 'background-color:#'.$SkinArray->ModLeftSideBGColor.';';

                            echo 'width: '.$CornerWidth.'px;
					
					}';
					
					echo '#projectmodtop {';
							if ($SkinArray->ModTopImage != '')
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopImage.');
                            		  background-repeat:repeat-x;';
                            
                           if ($SkinArray->ModTopBGColor != '') 
                          	 	echo 'background-color:#'.$SkinArray->ModTopBGColor.';';
                        
                           echo 'height:'.$CornerHeight.'px;
					}';
					
					echo '.projectboxcontent {';
							if ($SkinArray->ContentBoxImage != '')
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ContentBoxImage.');
                            			background-repeat:'.$SkinArray->ContentBoxImageRepeat.';';
                           
                           if ($SkinArray->ContentBoxBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ContentBoxBGColor.';';
                        	else
                            	echo 'background-color:#ffffff;';
                            
                           if ($SkinArray->ContentBoxTextColor != '') 
                            	echo 'color:#'.$SkinArray->ContentBoxTextColor.';';
                           else 
                           		echo 'color:#000000;';
                   
                            if ($SkinArray->ContentBoxFontSize != '')
								echo 'font-size:'.$SkinArray->ContentBoxFontSize.'px;';
                            else
                            	echo 'font-size:12px;';
                        
					
					echo '}';
					
					echo '#projectmodbottom { ';
						 if ($SkinArray->ModBottomImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomImage.');
                            		background-repeat:repeat-x;';
									
							if ($SkinArray->ModBottomBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ModBottomBGColor.';';
								
                            echo 'height:'.$CornerHeight.'px;
					
					}';
					
					echo '#projectmodbottomleft {';
						 if ($SkinArray->ModBottomLeftImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomLeftImage.');
                            background-repeat:none;';
							
							if ($SkinArray->ModBottomLeftBGColor != '') 
                            echo 'background-color:#'.$SkinArray->ModBottomLeftBGColor.';';
							 
                           echo 'height:'.$CornerHeight.'px;
                            	width:'.$CornerWidth.'px;
					}';
					
					echo '#projectmodtopleft {'; 
							if ($SkinArray->ModTopLeftImage != '') 
                            	echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopLeftImage.');
                            		background-repeat:none;';
							if ($SkinArray->ModTopLeftBGColor != '')
                           		echo 'background-color:#'.$SkinArray->ModTopLeftBGColor.';';
							 
                            echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px; 
					}';
					
					
					echo '#projectmodtopright {';
						  if ($SkinArray->ModTopRightImage != '') 
						       echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopRightImage.');
                           			 background-repeat:none;';
							
							if ($SkinArray->ModTopRightBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ModTopRightBGColor.';';
							
                            echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px; 
					}';
					
					echo '#projectmodbottomright { ';
							if ($SkinArray->ModBottomRightImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomRightImage.');
                            	  background-repeat:none;';
							if ($SkinArray->ModBottomRightBGColor != '')
                            	echo 'background-color:#'.$SkinArray->ModBottomRightBGColor.';';
                             
                           echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px; 
					}';
					
				
					echo '#bubblerightside {'; 
							 if ($SkinArray->ModRightSideImage != '') 
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModRightSideImage.');
                           			 background-repeat:repeat-y;';
                           
                             if ($SkinArray->ModRightSideBGColor != '') 
                            		echo 'background-color:#'.$SkinArray->ModRightSideBGColor.';';
                             
                            echo 'width:'.$CornerWidth.'px; 
					}';
					
					echo '#bubbleleftside {';
						 if ($SkinArray->ModLeftSideImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModLeftSideImage.');
                            		background-repeat:repeat-y;';
                             
                             if ($SkinArray->ModLeftSideBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ModLeftSideBGColor.';';
                             
                            echo 'width:'.$CornerWidth.'px;
					}';
					
					
					echo '#bubbletop {';
							 if ($SkinArray->ModTopImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopImage.');
									background-repeat:repeat-x;';
                             
                             if ($SkinArray->ModTopBGColor != '')                            		
							 	echo 'background-color:#'.$SkinArray->ModTopBGColor.';';
                            
                            echo 'height:'.$CornerHeight.'px;
					}';
					
					echo '#bubble_tooltip_content {';
							 if ($SkinArray->ContentBoxImage != '') 
                            		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ContentBoxImage.');
                           				 background-repeat:'.$SkinArray->ContentBoxImageRepeat.';';
                             
                             if ($SkinArray->ContentBoxBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ContentBoxBGColor.';';
                             else  
								echo 'background-color:#ffffff;';
                             
                             if ($SkinArray->ContentBoxTextColor != '') 
                            	echo 'color:#'.$SkinArray->ContentBoxTextColor.';';
                             else
                            	echo 'color:#000000;';
                            
                             if ($SkinArray->ContentBoxFontSize != '')
                            	echo 'font-size:'.$SkinArray->ContentBoxFontSize.'px;';
                            else
                           		echo 'font-size:12px;';
                          
					echo '}';
					
					echo '#bubblebottom {';
						 if ($SkinArray->ModBottomImage != '') 
                        	 echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomImage.');
                            		background-repeat:repeat-x;';
                            
                             if ($SkinArray->ModBottomBGColor != '') 
                            	echo 'background-color:#'.$SkinArray->ModBottomBGColor.';';
                            
                            echo 'height:'.$CornerHeight.'px;
                            
					}';
					
					echo '#bubblebottomleft {';
							if ($SkinArray->ModBottomLeftImage != '') 
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomLeftImage.');
                           		 background-repeat:none;';
                             
							if ($SkinArray->ModBottomLeftBGColor != '') 
                            	echo 'background-color:#'.$SkinArray->ModBottomLeftBGColor.';';
                           
                            echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px;
					}';
						
					echo '#bubbletopleft{';
							 if ($SkinArray->ModTopLeftImage != '')
                            	echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopLeftImage.');
                           			 background-repeat:none;';
                            
                             if ($SkinArray->ModTopLeftBGColor != '')
                            	echo 'background-color:#'.$SkinArray->ModTopLeftBGColor.';';
                           
                            echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px;
					}';
					
					echo '#bubbletopright{';
						 if ($SkinArray->ModTopRightImage != '')
                            	echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModTopRightImage.');
                           			 background-repeat:none;';
                            
                             if ($SkinArray->ModTopRightBGColor != '')
                            		echo 'background-color:#'.$SkinArray->ModTopRightBGColor.';';
                           
                           echo 'height:'.$CornerHeight.'px;
                            	 width:'.$CornerWidth.'px;
					}';
					
					echo '#bubblebottomright{';
							 if ($SkinArray->ModBottomRightImage != '') 
                           		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ModBottomRightImage.');
                            		  background-repeat:none;';
                           
                             if ($SkinArray->ModBottomRightBGColor != '') 
                           		echo 'background-color:#'.$SkinArray->ModBottomRightBGColor.';';
                            
                            echo 'height:'.$CornerHeight.'px;
                            width:'.$CornerWidth.'px;
					}';
					

					if ($SkinArray->ControlBarImage != '')
						list($ControlWidth,$ControlHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$SkinArray->ControlBarImage);

					echo '#ControlBar{';
					
						if ($SkinArray->ControlBarImage != '') 
                            echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->ControlBarImage.');
                            		background-repeat:'.$SkinArray->ControlBarImageRepeat.';
                            		height:'.$ControlHeight.'px;';
                            
                           echo  'background-color:#'.$SkinArray->ControlBarBGColor.';';
						   
                           if ($SkinArray->ControlBarFontSize != '') 
                            echo 'font-size:'.$SkinArray->ControlBarFontSize.'px;';
                             
                             if ($SkinArray->ControlBarFontStyle != '') {
									if ($SkinArray->ControlBarFontStyle == 'bold') 
										$StyleTag = 'font-weight:bold;';
									if ($SkinArray->ControlBarFontStyle == 'regular') 
										$StyleTag = 'font-style:normal;';
									if ($SkinArray->ControlBarFontStyle == 'underline') 
										$StyleTag = 'text-decoration:underline;';
									echo $StyleTag;
                             }
					echo '}';				
					
					echo '#AuthorComment{';
					
							 if (($SkinArray->AuthorCommentTextColor == 'global') || ($SkinArray->AuthorCommentTextColor == ''))
                                $TextColor = $GlobalHeaderTextColor;
                              else 
                                $TextColor = $AuthorCommentTextColor;
                           
						   echo  'color:#'.$TextColor.';
                            	  text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';';
							
                           if (($SkinArray->AuthorCommentImage != '') || ($SkinArray->GlobalHeaderImage != '')) {
                                     if ($SkinArray->AuthorCommentImage == '') {
                                        $CSSImage =$SkinArray->GlobalHeaderImage;
                                        $CSSRepeat = $SkinArray->GlobalHeaderImageRepeat; 
                                    } else {
                                        $CSSImage =$SkinArray->AuthorCommentImage;
                                        $CSSRepeat = $SkinArray->AuthorCommentImageRepeat;
                                    } 
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                                    
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
										
								   echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->CSSImage.');
										 background-repeat:'.$CSSRepeat.';
										  height:'.$HeaderHeight.'px;';
                             }
                             if (($SkinArray->AuthorCommentBGColor != '') || ($SkinArray->GlobalHeaderBGColor != '')) {
                                     if ($SkinArray->AuthorCommentBGColor == '') {
                                        $BgColor =$SkinArray->GlobalHeaderBGColor;
                            
                                    } else {
                                        $BgColor =$SkinArray->AuthorCommentBGColor;
                                    } 
                            
                          			 echo 'background-color:#'.$BgColor.';';
						   
                             }
                             if (($SkinArray->AuthorCommentFontSize != '') || ($SkinArray->GlobalHeaderFontSize != '')) {
                                     if ($SkinArray->AuthorCommentFontSize == '') {
                                        $FontSize =$SkinArray->GlobalHeaderFontSize;
                            
                                    } else {
                                        $FontSize =$SkinArray->AuthorCommentFontSize;
                                    } 
                            
                            		echo 'font-size:'.$FontSize.'px;';
                            } 
                            
                            
                            if (($SkinArray->AuthorCommentFontStyle != '') || ($SkinArray->GlobalHeaderFontStyle != '')) {
                                     if ($SkinArray->AuthorCommentFontStyle == '')
                                        $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                    else
                                        $FontStyle =$SkinArray->AuthorCommentFontStyle;

                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';
                           		    echo $StyleTag; 
							}
					
					echo '}';
					
					$GlobalHeaderImageRepeat = $SkinArray->GlobalHeaderImageRepeat;
					 if ($GlobalHeaderImageRepeat == 'none') 
                         $GlobalHeaderImageRepeat = 'no-repeat';
						 
					echo '#LinksBox {';
                            echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                                   padding:2px;';
							if ($SkinArray->GlobalHeaderImage != '') {
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalHeaderImage);
                           			
									echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalHeaderImage.');
                           				  background-repeat:'.$GlobalHeaderImageRepeat.';
                           				 height:'.$HeaderHeight;px;';';
							}
                            echo 'background-color:#'.$SkinArray->GlobalHeaderBGColor.'; 
                            		font-size:'.$SkinArray->GlobalHeaderFontSize.'px;
                            		color:#'.$SkinArray->GlobalHeaderTextColor.';'; 
                            
                                if ($SkinArray->GlobalHeaderFontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                if ($SkinArray->GlobalHeaderFontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                if ($SkinArray->GlobalHeaderFontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';
					
					echo '.modheader{';
                            echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                                  padding:2px;';
							if ($SkinArray->GlobalHeaderImage != '') {
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalHeaderImage);
                           			 echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalHeaderImage.');
                            		background-repeat:'.$GlobalHeaderImageRepeat;'
                           			 height:'.$HeaderHeight.'px;'; 
							}
                            echo 'background-color:#'.$SkinArray->GlobalHeaderBGColor.'; 
                           		  font-size:'.$SkinArray->GlobalHeaderFontSize.'px;
                            	  text-align:left;
								  color:#'.$SkinArray->GlobalHeaderTextColor.';'; 
                                if ($SkinArray->GlobalHeaderFontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                if ($SkinArray->GlobalHeaderFontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                if ($SkinArray->GlobalHeaderFontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';
					
					echo '#ComicSynopsis{';
							echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
							     padding:3px;'; 
						    if (($SkinArray->ComicSynopsisTextColor == 'global') || ($SkinArray->ComicSynopsisTextColor == ''))
                                $TextColor = $SkinArray->GlobalHeaderTextColor;
                              else 
                                $TextColor = $SkinArray->ComicSynopsisTextColor;
                            
                            echo 'color:#'.$TextColor.';';

							if (($SkinArray->ComicSynopsisImage != '') || ($SkinArray->GlobalHeaderImage != '')) {
                                     if ($ComicSynopsisImage == '') {
                                        $CSSImage =$SkinArray->GlobalHeaderImage;
                                        $CSSRepeat = $GlobalHeaderImageRepeat;
                                    } else {
                                        $CSSImage =$SkinArray->ComicSynopsisCommentImage;
                                        $CSSRepeat = $SkinArray->ComicSynopsisImageRepeat;
                                    } 
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                            
                            		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
								} 
								
								if (($SkinArray->ComicSynopsisBGColor != '') || ($SkinArray->GlobalHeaderBGColor != '')) {
                                     if ($SkinArray->ComicSynopsisBGColor == '') 
                                        $BgColor =$SkinArray->GlobalHeaderBGColor;
                                     else
                                        $BgColor =$SkinArray->ComicSynopsisBGColor;

                            		echo 'background-color:#'.$BgColor.';';
									 } 
									 
									 if (($SkinArray->ComicSynopsisFontSize != '') || ($SkinArray->GlobalHeaderFontSize != '')) {
                                     	if ($SkinArray->ComicSynopsisFontSize == '')
                                       		 $FontSize =$SkinArray->GlobalHeaderFontSize;
                                    	else 
                                        	$FontSize =$SkinArray->ComicSynopsisFontSize;
                           				echo 'font-size:'.$FontSize.'px;';
									
									} 
							
							if (($SkinArray->ComicSynopsisFontStyle != '') || ($SkinArray->GlobalHeaderFontStyle != '')) {
                                     if ($SkinArray->ComicSynopsisFontStyle == '') {
                                        $FontStyle = $SkinArray->GlobalHeaderFontStyle;
                                    } else {
                                        $FontStyle =$SkinArray->ComicSynopsisFontStyle;
                                    } 
                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag; }
					
					echo '}';
					
					echo '#ComicInfo{';
					
                           echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
								padding:3px;';
							
							if (($SkinArray->ComicInfoTextColor == 'global')  || ($SkinArray->ComicInfoTextColor == ''))
                                $TextColor = $SkinArray->GlobalHeaderTextColor;
                              else 
                                $TextColor = $SkinArray->ComicInfoTextColor;
                            
                            echo 'color:#'.$TextColor.';';
							
							 if (($SkinArray->ComicInfoImage != '') || ($SkinArray->GlobalHeaderImage != '')) {
                                     if ($SkinArray->ComicInfoImage == '') {
                                        $CSSImage =$SkinArray->GlobalHeaderImage;
                                        $CSSRepeat = $GlobalHeaderImageRepeat;
                                    } else {
                                        $CSSImage =$SkinArray->ComicInfoImage;
                                        $CSSRepeat = $SkinArray->ComicInfoImageRepeat;
                                    } 
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                            
                            		echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            			  background-repeat:'.$CSSRepeat.';
                           				 height:'.$HeaderHeight.'px;';
							  } 
							  
							  if (($ComicInfoBGColor != '') || ($GlobalHeaderBGColor != '')) {
                                     if ($ComicInfoBGColor == '')
                                        $BgColor =$GlobalHeaderBGColor;
                            		 else
                                        $BgColor =$ComicInfoBGColor;
                                                      
                           			echo 'background-color:#'.$BgColor.';';
							   } 
							 
							 if (($SkinArray->ComicInfoFontSize != '') || ($SkinArray->GlobalHeaderFontSize != '')) {
                                     if ($SkinArray->ComicInfoFontSize == '')
                                        $FontSize =$SkinArray->GlobalHeaderFontSize;
                                     else
                                        $FontSize =$SkinArray->ComicInfoFontSize;

                            		echo 'font-size:'.$FontSize.'px;';
							 } 
							 
							 if (($SkinArray->ComicInfoFontStyle != '') || ($SkinArray->GlobalHeaderFontStyle != '')) {
                                     if ($SkinArray->ComicInfoFontStyle == '') {
                                        $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                    } else {
                                        $FontStyle =$SkinArray->ComicInfoFontStyle;
                                    } 
                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag; }
					
					echo '}';		
					
					echo '#UserComments{';
					        echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                           			 padding:3px;';
						 if (($SkinArray->UserCommentsTextColor == 'global')  || ($SkinArray->UserCommentsTextColor == ''))
                                $TextColor = $SkinArray->GlobalHeaderTextColor;
                              else 
                                $TextColor = $SkinArray->UserCommentsTextColor;
                            
                            echo 'color:# '.$TextColor.';';
						
						if (($SkinArray->UserCommentsImage != '') || ($SkinArray->GlobalHeaderImage != '')) {
                                     if ($SkinArray->UserCommentsImage == '') {
                                        $CSSImage =$SkinArray->GlobalHeaderImage;
                                        $CSSRepeat = $GlobalHeaderImageRepeat;
                                    } else {
                                        $CSSImage =$SkinArray->UserCommentsImage;
                                        $CSSRepeat = $SkinArray->UserCommentsImageRepeat;
                                    } 
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                            
                           			echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
						 } 
						 if (($SkinArray->UserCommentsBGColor != '') || ($SkinArray->GlobalHeaderBGColor != '')) {
                                     if ($SkinArray->UserCommentsBGColor == '') {
                                        $BgColor =$SkinArray->GlobalHeaderBGColor;
                            
                                    } else {
                                        $BgColor =$SkinArray->UserCommentsBGColor;
                                    } 
                            
                            echo 'background-color:#'.$BgColor.';';
							
						 } 
						 if (($SkinArray->UserCommentsFontSize != '') || ($SkinArray->GlobalHeaderFontSize != '')) {
                                     if ($SkinArray->UserCommentsFontSize == '') {
                                        $FontSize =$SkinArray->GlobalHeaderFontSize;
                            
                                    } else {
                                        $FontSize =$SkinArray->UserCommentsFontSize;
                                    } 
                            
                            echo 'font-size:'.$FontSize.'px;';
						} 
						if (($SkinArray->UserCommentsFontStyle != '') || ($SkinArray->GlobalHeaderFontStyle != '')) {
                                     if ($SkinArray->UserCommentsFontStyle == '') {
                                        $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                    } else {
                                        $FontStyle =$SkinArray->UserCommentsFontStyle;
                                    } 
                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag; }
					
					echo '}';			
						
					echo '#ComicSynopsis{';
                            echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                           			 padding:3px;';
									 
						 if (($SkinArray->ComicSynopsisTextColor == 'global') || ($SkinArray->ComicSynopsisTextColor == ''))
                                $TextColor = $SkinArray->GlobalHeaderTextColor;
                              else 
                                $TextColor = $SkinArray->ComicSynopsisTextColor;
                            
                            echo 'color:#'.$TextColor.';';
							
						if (($SkinArray->ComicSynopsisImage != '') || ($SkinArray->GlobalHeaderImage != '')) {
                                     if ($SkinArray->ComicSynopsisImage == '') {
                                        $CSSImage =$SkinArray->GlobalHeaderImage;
                                        $CSSRepeat = $GlobalHeaderImageRepeat;
                                    } else {
                                        $CSSImage =$SkinArray->ComicSynopsisImage;
                                        $CSSRepeat = $SkinArray->ComicSynopsisImageRepeat;
                                    } 
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                            
                        		   echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
						} 
						
						if (($ComicSynopsisBGColor != '') || ($GlobalHeaderBGColor != '')) {
                                     if ($SkinArray->ComicSynopsisBGColor == '') {
                                        $BgColor =$SkinArray->GlobalHeaderBGColor;
                            
                                    } else {
                                        $BgColor =$SkinArray->ComicSynopsisBGColor;
                                    } 
                            
                            echo 'background-color:#'.$BgColor.';';
						} 
						if (($SkinArray->ComicSynopsisFontSize != '') || ($SkinArray->GlobalHeaderFontSize != '')) {
                                     if ($ComicSynopsisFontSize == '') {
                                        $FontSize =$SkinArray->GlobalHeaderFontSize;
                            
                                    } else {
                                        $FontSize =$SkinArray->ComicSynopsisFontSize;
                                    } 
                            
                            echo 'font-size:'.$FontSize.'px;';
						 } 
						 
						 if (($SkinArray->ComicSynopsisFontStyle != '') || ($SkinArray->GlobalHeaderFontStyle != '')) {
                                     if ($SkinArray->ComicSynopsisFontStyle == '') {
                                        $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                    } else {
                                        $FontStyle =$SkinArray->ComicSynopsisFontStyle;
                                    } 
                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag; }
                            
					echo '}';	
					
						
					echo '.latestpageheader  {';
                            echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                            color:#'.$SkinArray->GlobalHeaderTextColor.';';
							if ($GlobalHeaderImage != '') {
								$CSSImage =$SkinArray->GlobalHeaderImage;
								$CSSRepeat = $GlobalHeaderImageRepeat;
								list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
                            
                            	echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
											
							}
                            echo 'background-color:#'.$SkinArray->ControlBarBGColor.';
                            font-size:'.$SkinArray->GlobalHeaderFontSize.'px;';
							
                                $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                 if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';
					  
					echo '.latestpageheader a:link{
                            text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                            padding:3px;
                            color:#'.$SkinArray->GlobalHeaderTextColor.';';
							if ($GlobalHeaderImage != '') {
									$CSSImage =$SkinArray->GlobalHeaderImage;
									$CSSRepeat = $GlobalHeaderImageRepeat;
									list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
									
								   echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
							}
                            
                           echo 'background-color:#'.$SkinArray->ControlBarBGColor.';
                            font-size:'.$SkinArray->GlobalHeaderFontSize.'px;';
							
                                $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                 if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';

					echo '.latestpageheader a:visited{';
                           echo 'text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                            padding:3px;
                            color:#'.$SkinArray->GlobalHeaderTextColor.';'; 
							if ($GlobalHeaderImage != '') {
									$CSSImage =$SkinArray->GlobalHeaderImage;
									$CSSRepeat = $GlobalHeaderImageRepeat;
									list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
									
								   echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
							}
                            
                           echo 'background-color:#'.$SkinArray->ControlBarBGColor.';
                            font-size:'.$SkinArray->GlobalHeaderFontSize.'px;';
                           							
                                $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                 if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';
					
					echo '.blogtitle {
                            font-size:14px;
                            font-weight:bold;
					}';
					
					echo '.blogdate {
							font-size:12px;
					}';
					
					echo '.globalheader{
                            text-transform:'.$SkinArray->GlobalHeaderTextTransformation.';
                            padding:3px;
                            text-align:left;
                            color:#'.$SkinArray->GlobalHeaderTextColor.';';
							
							if ($GlobalHeaderImage != '') {
									$CSSImage =$SkinArray->GlobalHeaderImage;
									$CSSRepeat = $GlobalHeaderImageRepeat;
									list($HeaderWidth,$HeaderHeight)=@getimagesize(PFENGINEDIR.'/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage);
									
								   echo 'background-image:url(/templates/skins/'.$this->SkinCode.'/images/'.$CSSImage.');
                            				background-repeat:'.$CSSRepeat.';
                            				height:'.$HeaderHeight.'px;';
							}
                            
                           echo 'background-color:#'.$SkinArray->GlobalHeaderBGColor.';
                            font-size:'.$SkinArray->GlobalHeaderFontSize.'px;';
                           							
                                $FontStyle =$SkinArray->GlobalHeaderFontStyle;
                                 if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
					echo '}';
                             
                     echo '.global_button {';
                            echo 'padding:3px;';
							if ($SkinArray->ButtonImage != '') {
                                        $CSSImage =$SkinArray->ButtonImage;
                                        $CSSRepeat = $SkinArray->ButtonImageRepeat;
                                    if ($CSSRepeat == 'none') 
                                        $CSSRepeat = 'no-repeat';
                                    list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
                            
								   echo 'background-image:url(/'.$CSSImage.');
									background-repeat:'.$CSSRepeat.';
									height:'.$HeaderHeight.'px;';
							
							 } 
							 if ($SkinArray->ButtonBGColor != '') {
                                        $BgColor =$SkinArray->ButtonBGColor;
                             			 echo 'background-color:#'.$BgColor.';';
							  } 

							   
							   if ($SkinArray->ButtonTextColor != '') {
                                        $TextColor =$SkinArray->ButtonTextColor;
                           				 echo 'color:#'.$SkinArray->ButtonTextColor.';'; 
								} 
							
							if ($ButtonFontSize != '') {
                                        $FontSize =$SkinArray->ButtonFontSize;
            
                            			echo 'font-size:'.$FontSize.'px;'; 
							} 
							if ($SkinArray->ButtonFontStyle != '') {
                                    $FontStyle =$SkinArray->ButtonFontStyle;
                                    if ($FontStyle == 'bold') 
                                        $StyleTag = 'font-weight:bold;';
                                    if ($FontStyle == 'regular') 
                                        $StyleTag = 'font-style:normal;';
                                    if ($FontStyle == 'underline') 
                                        $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag; }
					
					echo '}';		
					
					echo '#FirstButton{ ';
						if ($SkinArray->HomeButtonImage == '') {
							echo 'padding:5px;';
						} 
						if ($SkinArray->FirstButtonBGColor != '') { 
                           echo 'background-color:#'.$SkinArray->FirstButtonBGColor.';';
						 } 
						 if ($SkinArray->FirstButtonTextColor != '') { 
                            echo 'color:#'.$SkinArray->FirstButtonTextColor.';';
						 }
					echo '}';
					
					echo '#NextButton{ ';
						if ($SkinArray->HomeButtonImage == '') {
							echo 'padding:5px;';
						 } 
						 if ($SkinArray->NextButtonBGColor != '') { 
                           echo 'background-color:#'.$SkinArray->NextButtonBGColor.';';
						  } 
						  if ($SkinArray->NextButtonTextColor != '') { 
                            echo 'color:#'.$SkinArray->NextButtonTextColor.';';
						 }
					echo '}';
					
					echo '#BackButton{ ';
						 if ($SkinArray->HomeButtonImage == '') {
						 	echo 'padding:5px;';
						} 
						if ($SkinArray->BackButtonBGColor != '') { 
                           echo 'background-color:#'.$SkinArray->BackButtonBGColor.';';
						} 
						if ($SkinArray->BackButtonTextColor != '') { 
                            echo 'color:#'.$SkinArray->BackButtonTextColor.';';
						 }
					echo '}';
					
					echo '#LastButton{ ';
							if ($HomeButtonImage == '') {
								echo 'padding:5px;';
							} 
							if ($SkinArray->LastButtonBGColor != '') { 
                           		echo 'background-color:#'.$SkinArray->LastButtonBGColor.';';
						   } 
						   if ($SkinArray->LastButtonTextColor != '') { 
                            echo 'color:#'.$SkinArray->LastButtonTextColor.';';
						 }
					echo '}';	
								
					echo '.pagelinks { ';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                             
							 echo 'color:#'.$SkinArray->GlobalSiteLinkTextColor.';';
					echo '}';
					
					echo '.pagelinks a{ ';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                           echo 'color:#'.$SkinArray->GlobalSiteLinkTextColor.';';
					echo '}';
					echo '.pagelinks a:link{ ';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalSiteLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                                echo 'color:#'.$SkinArray->GlobalSiteLinkTextColor.';';
					echo '}';
					echo '.pagelinks a:visited { ';
                            if ($SkinArray->GlobalSiteVisitedFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalSiteVisitedFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;'; 
                            if ($SkinArray->GlobalSiteVisitedFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                            echo 'color:#'.$SkinArray->GlobalSiteVisitedTextColor.';';
					echo '}';
					echo '.pagelinks a:hover{ ';
                            if ($SkinArray->GlobalSiteHoverFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalSiteHoverFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalSiteHoverFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                              echo 'color:#'.$SkinArray->GlobalSiteHoverTextColor.';';
					echo '}';
					
					echo '.buttonlinks { ';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                                 echo 'color:#'.$SkinArray->GlobalButtonLinkTextColor.';';
					echo '}';
					echo '.global_button a{ ';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                                 echo 'color:#'.$SkinArray->ButtonTextColor.';';
					echo '}';
					echo '.global_button a:link{ ';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalButtonLinkFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                                echo 'color:#'.$SkinArray->ButtonTextColor.';';
					echo '}';
					echo '.global_button a:visited{ ';
                            if ($SkinArray->GlobalButtonVisitedFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalButtonVisitedFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;'; 
                            if ($SkinArray->GlobalButtonVisitedFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                            echo 'color:#'.$SkinArray->GlobalButtonVisitedTextColor.';';
					echo '}';
                    echo '.global_button a:hover{ ';
                            if ($SkinArray->GlobalButtonHoverFontStyle == 'bold') 
                                $StyleTag = 'font-weight:bold;';
                            if ($SkinArray->GlobalButtonHoverFontStyle == 'regular') 
                                $StyleTag = 'font-style:normal;';
                            if ($SkinArray->GlobalButtonHoverFontStyle == 'underline') 
                                $StyleTag = 'text-decoration:underline;';	
                             echo $StyleTag;
                                echo 'color:#'.$SkinArray->GlobalButtonVisitedTextColor.';';
					echo '}';
					echo '</style>';
					
					
					
					
					//CHARACTERS
					$CharacterReader = $SkinArray->CharacterReader;
					
					$GlobalSiteWidth = $TemplateWidth;
										
					if ($SkinArray->GlobalSiteBGImage != '') {
							$this->BodyStyle .= 'background-image:url(http://www.wevolt.com/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalSiteBGImage.');';
							$this->BodyStyle .= 'background-repeat:'.$SkinArray->GlobalSiteImageRepeat.';';
					}
					$this->BodyStyle .= 'color:#'.$SkinArray->GlobalSiteTextColor.';';
					$this->BodyStyle .= 'font-size:'.$SkinArray->GlobalSiteFontSize.'px;';
					$this->BodyStyle .= 'background-color:#'.$SkinArray->GlobalSiteBGColor.';';
						
											 
					$CharacterReader = $SkinArray->CharacterReader;
							
					//HotSpot Settings		
					if ($HotSpotImage != '') {
						list($HotSpotWidth,$HotSpotHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->HotSpotImage);
					}else {
						$HotSpotHeight = 5;
						$HotSpotWidth = 5;
					}
						
					
					$BubbleClose = $SkinArray->BubbleClose;
					$BubbleOpen = $SkinArray->BubbleOpen;
					$HotSpotImage = $SkinArray->HotSpotImage;
					$HotSpotBGColor = $SkinArray->HotSpotBGColor;
					
					$this->BubbleSettingArray = array (	   'Close'=>$BubbleClose,
														   'Open'=>$BubbleOpen,
														   'Image'=>$HotSpotImage,
														   'SpotColor'=>$HotSpotBGColor,
														   'Width'=>$HotSpotWidth,
														   'Height'=>$HotSpotHeight
														);
						
					if ($CornerWidth == '') 
						$CornerWidth = '15';
											
					if ($CornerHeight == '')
						$CornerHeight = '15';
						
					$this->CornerWidth = $CornerWidth;
					$db->close();
							
		 }
		 
		 public function getModuleCornerWidth() {
		 				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
						$query = "SELECT ModTopLeftImage from project_skins where SkinCode='".$this->SkinCode."'";
						$ModTopLeftImage= $db->queryUniqueValue($query);
		 				list($Width,$Height)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$this->SkinCode.'/images/'.$ModTopLeftImage);
						unset($SkinArray);
						$db->close();
		 		return $Width;
		 }
		 
		 

		public function build_menus($theme,$project,$custom,$MenuLayout) {
					global $NextPage, $lastpage, $PrevPage;
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

					if ($custom == 0) 
						$query = "select * from pf_themes_menus where ThemeID='$theme' and MenuParent=1 ORDER BY Parent, Position ASC";
					else
						$query = "select * from menu_links where ComicID='$project' and MenuParent=1 ORDER BY Parent, Position ASC";
				
					$db->query($query);
					$NumLinks = $db->numRows();
					
					if ($NumLinks > 0) {
					$String = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>';				
					
					
					while ($line = $db->fetchNextObject()) { 
					
						$ContentSection = ucfirst($line->ContentSection);
						$LinkType = $line->LinkType;
						$Button =  $line->ButtonImage;
						$ButtonRollOver =  $line->ButtonRolloverImage;
						$Url = $line->Url;
						$String .= '<td>';
						$String .= '<span id="'.$ContentSection.'Button" class="global_button">';
						
						if ($Button != '') {
						
							$LinkStuff .= '<img src="'.$this->ProjectFolder.'/images/'.$Button.'" id="'.$ContentSection.'_'.Button.'" alt="'.$line->Title.'" border="0"';
							if ($ButtonRollOver != '') 
								$LinkStuff .= ' onMouseOver="this.src=\''.$this->ProjectFolder.'/images/'.$ButtonRollOver.'\';"onMouseOver="this.src=\''.$this->ProjectFolder.'/images/'.$Button.'\';"';
							$LinkStuff .= '/>'; 
						} else {
							$LinkStuff .= $line->Title;
						}	
						$String .= '<a href="';
					
						if ($line->Target == '_blank')
							$TargetStuff = '_blank';
						else
							$TargetStuff='_parent';
			
						if ($line->ContentSection == 'home'){
							$Url = '/'.$_SESSION['safefolder'].'/';
						}else if ($line->LinkType == 'section'){
							$Url = '/'.$this->SafeFolder.'/'.$Url.'/';
						}else if ($line->LinkType == 'page')	{
							if ($Url == '{FirstPage}')
								$Url = '/'.$this->SafeFolder.'/reader/page/1/';
							else if ($Url == '{NextPage}')
								$Url = '/'.$this->SafeFolder.'/reader/page/'.$NextPage.'/';
							else if ($Url == '{PrevPage}')
								$Url = '/'.$this->SafeFolder.'/reader/page/'.$PrevPage.'/';
							else if ($Url == '{LastPage}')
								$Url = '/'.$this->SafeFolder.'/reader/page/'.$lastpage.'/';
						}
						$String .= $Url.'" target="'.$TargetStuff.'">'.$LinkStuff.'</a>';
						$LinkStuff = '';
						$String .= '</span>';
						$String .= '</td>';
					
						if ($MenuLayout == 'vertical')
							$String .='</tr><tr>';
						
					}
						
					$String .='</tr></table>';
					}
					$db->close();
					return $String;
		
		}		 
		public function getBodyStyle() {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$query = "SELECT * from project_skins where SkinCode='".$this->SkinCode."'";
					$SkinArray = $db->queryUniqueObject($query);
					if ($SkinArray->GlobalSiteBGImage != '') {
							$this->BodyStyle .= 'background-image:url(http://www.wevolt.com/templates/skins/'.$this->SkinCode.'/images/'.$SkinArray->GlobalSiteBGImage.');';
							$this->BodyStyle .= 'background-repeat:'.$SkinArray->GlobalSiteImageRepeat.';';
					}
					$this->BodyStyle .= 'color:#'.$SkinArray->GlobalSiteTextColor.';';
					$this->BodyStyle .= 'font-size:'.$SkinArray->GlobalSiteFontSize.'px;';
					$this->BodyStyle .= 'background-color:#'.$SkinArray->GlobalSiteBGColor.';';
					unset($SkinArray);
					$db->close();
					return $this->BodyStyle;
		}
		
		public function SetProjectDirectory($Dir) {
						$this->ProjectFolder = $Dir;
		
		}
		
		public function getBubbleSettings() {
				return $this->BubbleSettingArray;
		}
	}

?>