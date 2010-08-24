<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class site {
	
		var $GlobalTitle;
		var $GlobalCopyright;	
		var $GlobalDescription;	
		var $GlobalKeywords;
		var $ImageDomain;
		var $BaseDomain;
			
		
		function __construct() {
			if ($_SERVER['SCRIPT_NAME'] == '/index.php')
				$this->Home = true;
			else
				$this->Home = false;
				
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "select * from settings"; 
			$db->query($query);
			while ($setting = $db->fetchNextObject()) { 
				    $this->GlobalTitle = $setting->SiteTitle;
					$this->GlobalCopyright = $setting->Copyright;
					$this->GlobalDescription = $setting->Description;
					$this->GlobalKeywords = $setting->Keywords;
			}
			$db->close();

		}

		public function getSpotlight() 
		{ 
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$query = "SELECT * from spotlight";
				$query .= " where Published=1 "; 
				if ($_SESSION['userid'] != '')
					$query .= " and LoggedIn=1 "; 
				if (($_SESSION['overage'] == 'N') || ($_SESSION['overage'] == ''))
					$query .= " and Rating !='a' ";
				$query .= " order by CreatedDate DESC limit 6";
				$db->query($query);
				echo '<div id="spotlight_container" style="height:154px;">';
				while ($spotlight = $db->FetchNextObject()) {
					echo '<div style="width:276px;height:154px;visibility:hidden;">';
					if ($spotlight->FullImage == 0) { 
						echo '<div style="height:5px;"></div><table><tr><td valign="top"><img src="'.$spotlight->Thumb.'" width="100"></td><td valign="top" style="padding-left:5px;padding-right:2px;"><div class="sender_name">'.$spotlight->Header.'</div><div class="messageinfo" style="font-size:12px;color:#000000;">'.$spotlight->Comment.'<br/><a href="'.$spotlight->Link.'">CHECK IT OUT</a></div></td></tr></table>';
					} else {
						echo '<a href="'.$spotlight->Link.'"><img src="'.$spotlight->Thumb.'" height="154" width="276" border="0"></a>';
					}
					echo '</div>';
				}
				echo '</div>';
				$db->close();
		
		}
		
		public function drawSpotLight($type,$template='home') {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$query = "SELECT * from spotlight";
				$query .= " where Published=1 and SpotlightType='$type' "; 
				if ($_SESSION['userid'] != '')
					$query .= " and LoggedIn=1 "; 
				if (($_SESSION['overage'] == 'N') || ($_SESSION['overage'] == ''))
					$query .= " and Rating !='a' ";
				$query .= " order by RAND()";
				$SpotArray = $db->queryUniqueObject($query);
				
				if (($type == 'user') || ($type == 'creator')) {
					$FollowType = 'user';
					$query = "select count(*) from follows where user_id='".$_SESSION['userid']."' and follow_id='".$SpotArray->ContentID."' and type='user'";
					$IsFollowing = $db->queryUniqueValue($query);
					
					$query = "select count(*) from follows where follow_id='".$SpotArray->ContentID."' and type='user'";
					$NumFollowers = $db->queryUniqueValue($query);
						
						$query = "SELECT avatar as thumb, realname as title, level as rank
						          from users where encryptid='".$SpotArray->ContentID."'";
					
				} else if ($type == 'project') {
					$FollowType = 'project';
					$query = "select count(*) from follows where user_id='".$_SESSION['userid']."' and follow_id='".$SpotArray->ContentID."' and type='project'";
					$IsFollowing = $db->queryUniqueValue($query);
					
					$query = "select count(*) from follows where follow_id='".$SpotArray->ContentID."' and type='project'";
					$NumFollowers = $db->queryUniqueValue($query);
					$query = "SELECT thumb, title, ProjectType
						          from projects where ProjectID='".$SpotArray->ContentID."'";
					
				}
				$SpotInfo = $db->queryUniqueObject($query);
				
				if ($template == 'side') {
					echo '<table><tr>';
					echo '<td valign="top">';
					echo '<div class="sidebar_spot_title">';
					echo $SpotInfo->title;
					echo '</div>';
					echo '<div class="sidebar_spot_text" align="right">';
					echo $SpotInfo->ProjectType.'<br/>';
					if ($SpotInfo->rank != '')
					echo 'Rank '.$SpotInfo->rank.'<br/>';
					if ($NumFollowers != 0)
						echo 'Fans '.$NumFollowers;
					echo '</div>';
					echo '</td>';
					echo '<td valign="top" width="90" align="center">';
					echo '<a href="'.$SpotArray->Link.'">';
					echo '<img src="'.$SpotInfo->thumb.'" border="0" width="66" height="66"></a><br/>';
					if (($IsFollowing == 0) &&($_SESSION['userid'] != '')) {
						echo '<a href="javascript:void(0)" onclick="follow_content(\''.$SpotArray->ContentID.'\',\''.$FollowType.'\',\'follow_'.$type.'\');">';	
						echo '<img src="http://www.wevolt.com/images/follow_button.png" id="follow_'.$type.'" border="0">';
						echo '</a><br/>';
						
					}
					
					echo '</td>';
					echo '</tr></table>';
					
				} else {
					echo '<a href="'.$SpotArray->Link.'">';
					echo '<img src="'.$SpotInfo->thumb.'" border="0"></a><br/>';
					if (($IsFollowing == 0) &&($_SESSION['userid'] != '')) {
						echo '<a href="javascript:void(0)" onclick="follow_content(\''.$SpotArray->ContentID.'\',\''.$FollowType.'\',\'follow_'.$type.'\');">';	
						echo '<img src="http://www.wevolt.com/images/follow_button.png" id="follow_'.$type.'" border="0">';
						echo '</a><br/>';
						
					}
					echo '<div style="height:5px;"></div><div class="spot_title">';
					echo $SpotInfo->title;
					echo '</div>';
					echo '<div class="spot_text">';
					echo 'Rank '.$SpotInfo->rank.'<br/>';
					if ($NumFollowers != 0)
						echo 'Fans '.$NumFollowers;
					echo '</div>';
				}
				
				
		}
		
		public function drawLatestModule($Order, $big = false) 
		{
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$query = "SELECT * from latest_mod where IsActive = 1";
				if (($_SESSION['overage'] == 'N') || ($_SESSION['overage'] == ''))
					$query .= " and Rating !='a' ";
				$query .= " order by $Order limit 6";
				$db->query($query);
				echo '<div id="slider">';
				if ($big) {
					$style = 'width="680px" height="250px"';
				}
				while ($line = $db->FetchNextObject()) {
                	echo '<div style="visibility:hidden;">' .
                		 '<a href="' . $line->Link . '">' . 
                		 "<img src=\"{$line->Thumb}\" border=\"0\" $style />" .
                		 '</a>' .
                		 '</div>';
				}            
                echo '</div>';	
				$db->close();
		}
		
		public function drawLogoMenu($Version){
				echo '<a href="http://www.wevolt.com"><img src="http://www.wevolt.com/images/wevolt_logo_no_tag.png" border="0" onmouseover="hide_layer(\'popupmenu\', event);hide_layer(\''.$Version.'\', event);"/></a>';
				echo '<div style="height:5px;"></div>';
				echo '<a href="http://www.wevolt.com/enjoy.php?t=comic"><img tooltip="Go here to starting reading content right away!" src="http://www.wevolt.com/images/enjoy_btn.png" id="enjoy_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/enjoy_btn_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/enjoy_btn.png\')" class="navbuttons"/></a>';
				echo '&nbsp;';
				echo '<a href="http://www.wevolt.com/create.php"><img tooltip="Click here to start creating!" src="http://www.wevolt.com/images/create_btn.png" id="create_btn" onmouseover="roll_over(this, \'http://www.wevolt.com/images/create_btn_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/create_btn.png\')" class="navbuttons"/></a>';
				echo '&nbsp;';
				echo '<a href="';
				if ($_SESSION['userid'] == '') 
					echo 'http://www.wevolt.com/wevolt.php';
				else 
					echo 'http://users.wevolt.com/'.$_SESSION['username'].'/';
				echo '"><img tooltip="WEvolt is all about sharing, click here to find out more" src="http://www.wevolt.com/images/we_volt_logo_btn.png" id="we_btn" onmouseover="roll_over(this, \'http://www.wevolt.com/images/we_volt_logo_btn_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/we_volt_logo_btn.png\')" class="navbuttons"/></a><br />';
				echo '<img src="http://www.wevolt.com/images/yellow_line.png" />';

		}
		
		public function drawLoginDiv() {
			echo '<div id="login_div" align="center" style="display:none;">';
			echo '<form action="http://www.wevolt.com/connectors/login_auth.php" method="post" style="padding:0px;">';
			echo '<input type="text" value="EMAIL" name="email" style="width:125px; font-size:10px; height:12px;" onfocus="doClear(this);" onblur="setDefault(this);"/>';
			echo '&nbsp;';
			echo '<input type="password" name="userpass" value="PASSWORD" style="width:100px; font-size:10px; height:12px;" onfocus="doClear(this);" onblur="setDefault(this);"/>';
			echo '&nbsp;';
			echo '<input type="submit" value="LOGIN" style="font-size:10px; height:14px;"/>';
			echo '<input type="hidden" value="'.$_SESSION['refurl'].'" name="refurl">';
			echo '</form>';
			echo '<div class="spacer"></div>';
			echo '</div>';
		}
		
		public function showWelcome($user) 
		{
			echo '<div align="center" style="color:#FFFFFF; font-size:10px;">';
			echo 'hello, '. $user;
			echo '<div style="height:3px;"></div></div> ';
		}
		 
		public function drawMainNav() 
		{
			?>
			<script>
			function toggleSiteMap()
			{
				var sitemap = $('#sitemap');
				if (sitemap.css('display') == 'none') {
					sitemap.show();
				} else {
					sitemap.hide();
				}
			}
			</script>
			<?php 
			echo '<table cellpadding="0" cellspacing="0" border="0" id="left_nav"><tr>';
			echo '<td background="http://www.wevolt.com/images/main_nav_bar.png" width="289" height="52"  style="background-repeat:no-repeat;" align="center">';
			echo '<a href="javascript:toggleSiteMap()"><img src="http://www.wevolt.com/images/info_button.png" id="info_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/info_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/info_button.png\')" class="navbuttons"/></a>';
			echo '&nbsp;';
			if (isset($_SESSION['userid'])) {
                echo '<a href="http://www.wevolt.com/logout.php"><img src="http://www.wevolt.com/images/logout_button.png" id="logout_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/logout_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/logout_button.png\')" class="navbuttons"/></a>';
			} else {
				echo "<a href=\"#\"  onclick=\"pop_login('".urlencode($_SESSION['refurl'])."');return false;\"><img src=\"http://www.wevolt.com/images/login_button.png\" id=\"login_button\" onmouseover=\"roll_over(this, 'http://www.wevolt.com/images/login_button_over.png')\" onmouseout=\"roll_over(this, 'http://www.wevolt.com/images/login_button.png')\" class=\"navbuttons\"/></a>";
			} 
			echo '&nbsp;';
			echo '<a href="http://www.wevolt.com/contact.php" ><img tooltip="Need to get ahold of us? This is the place to do it" src="http://www.wevolt.com/images/contact_button.png" id="contact_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/contact_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/contact_button.png\')" class="navbuttons"/></a>';
			echo '&nbsp;';
			echo '<a href="http://store.wevolt.com/" ><img tooltip="All kinds of cool stuff to buy" src="http://www.wevolt.com/images/store_button.png" id="store_button" onmouseover="roll_over(\'store_button\', \'http://www.wevolt.com/images/store_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/store_button.png\')" class="navbuttons"/></a>';
			echo '&nbsp;';
			echo '<a href="http://www.wevolt.com/calendar.php"><img tooltip="Keep tabs on everything happening on WEvolt" src="http://www.wevolt.com/images/calendar_button.png" id="calendar_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/calendar_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/calendar_button.png\')" class="navbuttons"/></a>';
			echo '&nbsp;';
			echo '<a href="http://www.wevolt.com/search/"><img tooltip="The WEsearch engine is your one stop shop to find anything" src="http://www.wevolt.com/images/search_button.png" id="search_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/search_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/search_button.png\')" class="navbuttons"/></a>';
			echo '</td></tr></table>' . 
				 $this->drawSiteMap(15); 
		}
		
		
		public function drawMainNavPro() 
		{
			echo '<table cellpadding="0" cellspacing="0" border="0" id="left_nav">';
			echo '<tr>';
			echo '<td align="center"><a href="http://www.wevolt.com"><img tooltip="Go Home!" tooltip_position="right" src="http://www.wevolt.com/images/pro_home_btn.jpg" border="0" id="homebtn" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_home_btn_over.jpg\')" onmouseout="roll_over(this,\'http://www.wevolt.com/images/pro_home_btn.jpg\')"/></a>';
			echo '<br />';
			echo '<a href="javascript:toggleSiteMap()"><img src="http://www.wevolt.com/images/pro_menu_btn.jpg" id="info_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_menu_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_menu_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
		
				echo '<a href="http://www.wevolt.com/logout.php" ><img tooltip_position="right" src="http://www.wevolt.com/images/pro_logout_btn.jpg" id="logout_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_logout_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_logout_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<a href="http://www.wevolt.com/search/" id="search" ><img tooltip="The WEsearch engine is your one stop shop to find anything" tooltip_position="right" src="http://www.wevolt.com/images/pro_search_btn.jpg" id="search_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_search_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_search_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<a href="http://www.wevolt.com/calendar.php"><img tooltip="Keep tabs on everything happening on WEvolt" tooltip_position="right" src="http://www.wevolt.com/images/pro_cal_btn.jpg" id="calendar_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_cal_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_cal_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<a href="http://store.wevolt.com/" id="store"><img tooltip="All kinds of cool stuff to buy" tooltip_position="right" src="http://www.wevolt.com/images/pro_store_btn.jpg" id="store_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_store_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_store_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<a href="http://www.wevolt.com/contact.php" id="contact" ><img tooltip="Need to get ahold of us? This is the place to do it"  tooltip_position="right" src="http://www.wevolt.com/images/pro_contact_btn.jpg" id="contact_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_contact_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_contact_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<a href="#" onclick="show_user_panel();return false;" id="user" ><img src="http://www.wevolt.com/images/pro_user_btn.jpg" id="user_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_user_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_user_btn.jpg\')" class="navbuttons" tooltip="Click here to bring up your user panel" tooltip_position="bottom right"/></a>';
			echo '<br />';
			echo '<a href="http://users.wevolt.com/myvolt/'.$_SESSION['username'].'/?t=volts" id="volt"><img tooltip="Click here to go to your Volt Manager" tooltip_position="right" src="http://www.wevolt.com/images/pro_volt_btn.jpg" id="volt_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_volt_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_volt_btn.jpg\')" class="navbuttons"/></a>';
			echo '<br />';
			echo '<img tooltip="Mark pages on your string with this button" tooltip_position="right" src="http://www.wevolt.com/images/pro_mark_btn.jpg"  onclick="mark_page(\''.$_SESSION['currentStringID'].'\',\''.$_SESSION['CurrentMarkStatus'].'\');" id="mark_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_mark_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_mark_btn.jpg\')" class="navbuttons"/>';
			echo '<br />';
			echo '<span id="string_button_on"><img tooltip="This the trail of sites you visit on wevolt" tooltip_position="right" src="http://www.wevolt.com/images/pro_string_btn.jpg" id="showstring" onclick="toggle_string_button(\'on\');"  onmouseover="roll_over(this, \'http://www.wevolt.com/images/pro_string_btn_over.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/pro_string_btn.jpg\')" class="navbuttons" /></span>';
			echo '<span id="string_button_off" style="display:none;"><img src="http://www.wevolt.com/images/pro_string_btn_over.jpg" id="hidestring" onclick="toggle_string_button(\'off\');hide_layer(\'popupmenu\', event);" class="navbuttons"/></span></a>' . 
				 $this->drawSiteMap(65, -640, true);
				
				//DRAWERS
				echo '<div id=\'drawer_set_1\'>';
				echo '<table><tr><td>';
				$D = 1;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;" onmouseover="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg\';" onmouseout="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg\';"  tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
//				echo '<span id="drawer_'.$D.'_off" style="display:none;"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg" id="hidedrawer'.$D.'" onclick="toggle_drawer(\''.$D.'\',\'off\',\'right\');" style="cursor:pointer;"/></span>';
				echo '</td>';
				echo '<td>';
				
				$D = 2;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;" onmouseover="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg\';" onmouseout="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg\';" tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
//				echo '<span id="drawer_'.$D.'_off" style="display:none;"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg" id="hidedrawer'.$D.'" onclick="toggle_drawer(\''.$D.'\',\'off\',\'right\');" style="cursor:pointer;"/></span>';
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>';

				$D = 3;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;" onmouseover="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg\';" onmouseout="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg\';" tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
//				echo '<span id="drawer_'.$D.'_off" style="display:none;"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg" id="hidedrawer'.$D.'" onclick="toggle_drawer(\''.$D.'\',\'off\',\'right\');" style="cursor:pointer;"/></span>';
				echo '</td>';
				echo '<td>';
				
				$D = 4;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;" onmouseover="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg\';" onmouseout="this.src=\'http://www.wevolt.com/images/pro_drawer_'.$D.'_btn.jpg\';" tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
//				echo '<span id="drawer_'.$D.'_off" style="display:none;"><img src="http://www.wevolt.com/images/pro_drawer_'.$D.'_btn_over.jpg" id="hidedrawer'.$D.'" onclick="toggle_drawer(\''.$D.'\',\'off\',\'right\');" style="cursor:pointer;"/></span>';
				echo '</td>';
				echo '</tr>';
				echo '</table>';
				echo '</div>';
				
				echo '</td>';
				echo '</tr>';
				echo '</table>';

		}
		
		public function drawSiteMap($left = 0, $top = 5, $cap = false)
		{ 
			?>
			<style>
			#sitemap a {
				color:#fff;				
			}
			</style>
			<script>
			function toggleSiteMap()
			{
				var sitemap = $('#sitemap');
				if (sitemap.css('display') == 'none') {
					sitemap.show();
				} else {
					sitemap.hide();
				}
			}
			</script>
			<script>
			$(document).ready(function() {
				$('#sitemap').mouseout(function(e) {
					if ($.contains(this, e.relatedTarget) == false) {
						$(this).hide();
					}
				});
			});
			</script>
			<div id="sitemap" style="font-size:12px;<?php echo ($left) ? 'margin-left:' . $left . 'px;' : ''; ?><?php echo ($top) ? 'margin-top:' . $top . 'px;' : ''; ?>position:absolute;z-index:50;display:none;" align="center">
			  <img style="position:absolute;top:0;left:0;" src="http://www.wevolt.com/images/sub_menu_bg<?php echo ($cap) ? '' : '_no_cap'; ?>.png">
			  <table style="position:absolute;top:<?php echo ($cap) ? '40' : '30'; ?>px;left:20px;width:250px;" cellspacing="0" cellpadding="0">
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/register.php?a=pro">GO PRO</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/wevolt.php">ABOUT</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/w3forum/wevolt/">FORUM</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/contact.php">CONTACT</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/blog.php">BLOG</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://store.wevolt.com/">STORE</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/tutorials.php">TUTORIALS</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/calendar.php">CALENDAR</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/what.php">SAY WHAT?</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/search/">WESEARCH</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/mobile.php">MOBILE</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/matteblack/">MATT</a></td>
			    </tr>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/studio.php">STUDIO</a></td>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/jasonbadower/">JASON</a></td>
			    </tr>
			    <?php if (!$_SESSION['userid']) : ?>
			    <tr>
			      <td><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/register.php">REGISTER</a></td>
			      <td></td>
			    </tr>
			    <?php endif; ?>
			  </table>
			</div>
			<?php 
		}
		
		
		public function drawControlPanel($width=981) 
		{
			$db = new DB();
			$users = new Users();
			$username = trim($_SESSION['username']);
			$xp = $users->getxp($db, $username);
			$xpWidth = (int) floor(132 * $xp->percent);
			?>
			<script>
			$(document).ready(function(){
				$('.drawer').mouseleave(function(){
					$(this).slideUp();
				});
			});
			
			</script>
			<style>
			.xpbar {
				background:-webkit-gradient(
    linear,
    left top,
    left bottom,
    color-stop(0.24, rgb(99,155,207)),
    color-stop(0.8, rgb(32,70,116))
);
background:-moz-linear-gradient(
    center top,
    rgb(99,155,207) 24%,
    rgb(32,70,116) 80%
);
				background-color:#639bcf;
				position:absolute;
				top:0;
				bottom:0;
				left:0;
				width:<?php echo $xpWidth; ?>px;
			}
			</style>
			<?php 
			echo '<table cellpadding="0" cellspacing="0" border="0" width="'.$width.'">';
            echo '<tr>';
            echo '<td id="control_left_cap"></td>';
            echo '<td class="control_bg" style="width:36px;">';
            echo '<a href="http://users.wevolt.com/'.trim($_SESSION['username']).'/"><img src="'.$_SESSION['avatar'].'" width="34" height="34" border="0"/></a></td>';
			//XP METER
			?>
            <td class="xp_bg" style="width:132px;"> 
              <div style="position:relative;height:100%;">
                <div class="xpbar"></div>
                
                  <table width="100%" height="100%" style="position:absolute;">
                    <tr>
                      <td align="left" valign="top">
                        <?php echo $username; ?>
                      </td>
                      <td align="right" valign="bottom"><span style="font-size:20px;">4</span></td>
                    </tr>
                  </table>
              </div> 
            </td>
            <?php 
				//MAIN CONTROL BUTTONS
			echo '<td class="control_bg">';
            echo '<table cellpadding="0" cellspacing="0" width="100%"><tr>';
			echo '<td class="control_button"><a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/">MYvolt</a></td>';
            echo '<td class="control_divider"></td>';
            echo '<td class="control_button"><a href="http://www.wevolt.com/cms/admin/">Projects</a></td>';
			echo '<td class="control_divider"></td>';
            echo '<td class="control_button"><a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=network">Contacts</a></td>';
            echo '<td class="control_divider"></td>';
            echo '<td class="control_button"><a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/?t=volts">Volt Manager</a></td>';
            echo '<td class="control_divider"></td>';
            echo '<td width="100" class="control_button"></td>'; 
            echo '</tr>';
            echo '<tr>';
			//NOTIFICATION
            echo '<td colspan="9" id="notification_bar"></td>';
            echo '</tr></table>';
            echo '</td>';
			//STRING BUTTONS
			echo '<td id="string_buttons" style="width:71px;" valign="top" align="center">';
            echo '<img tooltip="Mark pages on your string with this button" tooltip_position="right" src="http://www.wevolt.com/images/panel/control_clip_btn.png"  onclick="mark_page(\''.$_SESSION['currentStringID'].'\',\''.$_SESSION['CurrentMarkStatus'].'\');" id="mark_button" class="navbuttons"/>';?><? echo '<span id="string_button_on"><img tooltip="This the trail of sites you visit on WEvolt" tooltip_position="right" src="http://www.wevolt.com/images/panel/control_string_btn.png" id="showstring" onclick="toggle_string_button(\'on\');" class="navbuttons" /></span>';
			echo '<span id="string_button_off" style="display:none;"><img src="http://www.wevolt.com/images/panel/control_string_btn.png" id="hidestring" onclick="toggle_string_button(\'off\');hide_layer(\'popupmenu\', event);" class="navbuttons"/></span>';
            echo '</td>';
            echo '<td class="control_bg" style="width:190px;" align="center">';
            echo '<div id=\'drawer_set_1\'>';
				echo '<table width="97%"><tr><td align="center">'; 
				$D = 1;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/panel/control_drawer_'.$D.'.png" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;"  tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
		
				echo '</td>';
				echo '<td align="center">';
				
				$D = 2;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/panel/control_drawer_'.$D.'.png" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;"  tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
			
				echo '</td>';
				
				echo '<td align="center">';

				$D = 3;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/panel/control_drawer_'.$D.'.png" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;"  tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';

				echo '</td>';
				echo '<td align="center">';
				
				$D = 4;
				echo '<span id="drawer_'.$D.'_on"><img src="http://www.wevolt.com/images/panel/control_drawer_'.$D.'.png" id="showdrawer'.$D.'"  onclick="$(\'.drawer[id!=drawer_'. $D .']\').slideUp();$(\'#drawer_'.$D.'\').slideToggle();" style="cursor:pointer;"  tooltip="Open your WEvolt drawer" tooltip_position="right"/></span>';
				echo '</td>';
				echo '</tr>';
				echo '</table>';
				echo '</div>';
           
                echo '<div id="drawerProHolder" style="position:relative;left:0px;">';
						include_once($_SERVER['DOCUMENT_ROOT'] . '/components/_drawers.php');
                    $drawers = new Drawers;
                    $drawers->getDrawers();
   
				echo '</div>'; 
                echo '</td>';
                echo '<td id="control_right_cap"></td>';
           		echo '</tr>';
                echo '</table>';
        	   
			
			
		}
		
		public function drawHeaderWide($width=981) {
			echo '<table width="'.$width.'"><tr>';
			echo '<td>&nbsp;';
			echo '<a href="http://www.wevolt.com"><img src="http://www.wevolt.com/images/new_logo_with_tag.png" border="0"></a>';
			echo '</td>';
			echo '<td width="240">';
			echo '</td>';
			echo '<td>';
				echo '<table width="352""><tr>';
				echo '<td width="182">';
				echo '</td>';
				echo '<td>';
					echo '<a href="http://www.wowio.com" target="_blank"><img src="http://www.wevolt.com/images/wowio_button.png" border="0"></a>';
				echo '</td>';
				echo '<td>';
					echo '<a href="http://www.drunkduck.com" target="_blank"><img src="http://www.wevolt.com/images/drunkduck_button.png" border="0"></a>';
				echo '</td>';
				echo '<td>';
					echo '<a href="http://www.wowiotv.com" target="_blank"><img src="http://www.wevolt.com/images/wowiotv_button.png" border="0"></a>';
				echo '</td>';
				echo '</tr>';
				
				echo '<tr>';
				echo '<td class="sub_nav_links" colspan="4" align="right">';
					echo '<a href="http://www.wevolt.com/tutorial/?tid=1">GET STARTED</a>&nbsp;&nbsp;&nbsp;';
					if (isset($_SESSION['userid'])) {
                		echo '<a href="http://www.wevolt.com/logout.php">LOGOUT</a>&nbsp;&nbsp;&nbsp;';
					} else {
						echo '<a href="javascript:void(0)" onclick="pop_login(\''.urlencode($_SESSION['refurl']).'\');return false;">LOGIN</a>&nbsp;&nbsp;&nbsp;';
					} 
					echo '<a href="http://www.wevolt.com/wevolt.php">ABOUT</a>&nbsp;&nbsp;&nbsp;';
					echo '<a href="http://www.wevolt.com/contact.php">CONTACT</a>&nbsp;&nbsp;&nbsp;';
					echo '<a href="http://www.wevolt.com/register.php?a=pro">GO PRO</a>';
				echo '<td>';
				echo '</tr></table>';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
		}
		
		public function drawHeaderSide($width=315) 
		{
		
			echo '<table width="'.$width.'" cellpadding="0" cellspacing="0">';
				echo '<tr>';
					echo '<td background="http://www.wevolt.com/images/sidebar_top_bg.png" style="background-repeat:no-repeat; height:94px;" valign="top">';
						echo '<table cellpadding="0" cellspacing="0"  width="'.$width.'">';
							echo '<tr>';
								echo '<td valign="top" colspan="2" style="padding-left:5px;padding-top:5px" align="left">';
									echo '<span class="blue_links"><a href="http://www.wevolt.com/tutorial/?tid=1">GET STARTED</a></span>&nbsp;&nbsp;&nbsp;';
									echo '<span class="blue_links">';
									if (isset($_SESSION['userid'])) {
										echo '<a href="http://www.wevolt.com/logout.php">LOGOUT</a>';
									} else {
										echo '<a href="javascript:void(0)" onclick="pop_login(\''.urlencode($_SESSION['refurl']).'\');return false;">LOGIN</a>';
									} 
									echo '</span>&nbsp;&nbsp;&nbsp;';
									echo '<span class="yellow_links"><a href="http://www.wevolt.com/register.php?a=pro">GO PRO</a></span>&nbsp;&nbsp;&nbsp;';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td valign="top" align="right" style="padding-top:3px;">';
									echo '<a href="http://www.wevolt.com"><img src="http://www.wevolt.com/images/sidebar_logo.png" border="0"></a>';
								echo '</td>';
								echo '<td width="90" align="right" style="padding-right:20px;">';
									echo '<div class="spacer"></div>';
									echo '<span class="sidebar_nav"><a href="">COMICS</a></span><br/>';
									echo '<span class="sidebar_nav"><a href="http://www.wevolt.com/cms/admin/">CREATE</a></span><br/>';
									echo '<span class="sidebar_nav"><a href="">COMMUNITY</a></span><br/>';
									echo '<span class="sidebar_sub_nav"><a href="http://www.wevolt.com/tutorials.php">TUTORIALS</a></span><br/>';
									echo '<span class="sidebar_sub_nav"><a href="http://www.wevolt.com/forum/">FORUM</a></span><br/>';
									echo '<span class="sidebar_sub_nav"><a href="http://www.wevolt.com/blog.php">BLOG</a></span><br/>';
									echo '<span class="sidebar_sub_nav"><a href="http://www.wevolt.com/calendar.php">EVENTS</a></span>';
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td style="padding-left:5px;"><div class="spacer"></div><input type="text" style="width:195px;" name="keywords" id="keywords"></td>';
								echo '<td width="90" align="center"><div class="spacer"></div><img src="http://www.wevolt.com/images/search_btn_new.png"></td>';
							echo '</tr>';
						echo '<table>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		}
		
		public function drawSiteNavWide($width=980) 
		{
			?>
			<style>
			.result {
				padding:10px;
				background-color:#999;
				border:1px solid #000;
				background:-webkit-gradient(
						    linear,
						    left bottom,
						    left top,
						    color-stop(0.08, rgb(153,153,153)),
						    color-stop(0.77, rgb(238,238,238))
						);
				background:-moz-linear-gradient(
							    center bottom,
							    rgb(153,153,153) 8%,
							    rgb(238,238,238) 77%
							);
				background:filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#eeeeee, endColorstr=#999999);
				background:-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#eeeeee, endColorstr=#999999, GradientType=1);
				color:#000;
			}
			.topless {
				border-top-style:none;
			}
			.result img {
				border:none;
			}
			#search_results {
				width:300px;
				position:absolute;
				z-index:99;
				display:none;
			}
			</style>
			<script>
			$(document).ready(function(){
				var preventBlur = false;
				$('#search_results').mouseenter(function() {
					preventBlur = true;
				});
				$('#search_results').mouseleave(function() {
					preventBlur = false;
				});
				$('#keywords').blur(function(){
					if (!preventBlur) {
						$('#search_results').fadeOut('fast');
					}
				});
				$('#keywords').focus(function(){
					var search = $.trim($(this).val());
					if (search != '') {
						$('#search_results').fadeIn('fast');
					}
				});
				$('#keywords').keyup(function(){
					var search = $.trim($(this).val());
					if (search != '') {
						$.getJSON('/ajax/search.php', {search: search}, function(data) {
							var html = '';
							var i = 0;
							$.each(data, function() {
								this.thumb = this.thumb.replace('/\\/', '');
								if (this.thumb.charAt(0) == '/') {
									this.thumb = 'http://www.wevolt.com' + this.thumb;
								}
								if (this.type == 'user') {
									var link = 'http://users.wevolt.com/' + this.name + '/';
								} else {
									var link = 'http://www.wevolt.com/' + this.name + '/';
								}
								var style = (i != 0) ? 'result topless' : 'result';
								html += '<a class="search_link" href="' + link + '">' + 
									     '<div class="' + style + '">' +
										  '<table width="100%" cellspacing="10">' +
										    '<tr>' +
										      '<td rowspan="2" width="50"><img width="50" height="50" src="' + this.thumb + '" /></td>' +
										      '<td align="left"><b>' + this.type + '</b></td>' + 
										    '</tr>' +
										      '<td align="left">' + this.name + '</td>' + 
										    '</tr>' + 
										  '</table>' + 
										'</div>' + 
										 '</a>';
								i++;
							});
							$('#search_results').html(html).show();
						});
					} else {
						$('#search_results').fadeOut('fast');
					}
				});
			});
			</script>
			<?php 
			 echo '<table cellpadding="0" cellspacing="0" width="'.$width.'"><tr>';
			echo '<td class="main_nav_buttons"><a href="">COMICS</a></td>';
            echo '<td class="main_nav_divider"></td>';
            echo '<td class="main_nav_buttons"><a href="http://www.wevolt.com/cms/admin/">CREATE</a></td>';
			echo '<td class="main_nav_divider"></td>';
            echo '<td class="main_nav_buttons"><a href="">COMMUNITY</a></td>';
            echo '<td class="main_nav_divider"></td>';
            echo '<td class="main_nav_sub_buttons"><a href="http://www.wevolt.com/tutorials.php">TUTORIALS</a></td>';
            echo '<td class="main_nav_sub_divider"></td>';
			echo '<td class="main_nav_sub_buttons"><a href="http://www.wevolt.com/forum/">FORUM</a></td>';
			 echo '<td class="main_nav_sub_divider"></td>';
			echo '<td class="main_nav_sub_buttons"><a href="http://www.wevolt.com/blog.php">BLOG</a></td>';
			 echo '<td class="main_nav_sub_divider"></td>';
			echo '<td class="main_nav_sub_buttons"><a href="http://www.wevolt.com/calendar.php">EVENTS</a></td>';
			echo '<td class="main_nav_sub_divider"></td>';
			?>
			<td class="main_nav_sub_buttons" width="300">
			  <input type="text" style="width:99%;" name="keywords" id="keywords">
			  <div id="search_results"></div>
			</td>
			<?php 
			echo '<td class="main_nav_sub_buttons" width="71"><img src="http://www.wevolt.com/images/search_btn_new.png"></td>';
			echo '<td class="main_nav_sub_buttons"></td>';
            echo '</tr>';
           echo '</table>';
			
			
		}
		
		public function drawUserPanelPro() 
		{
				echo '<div class="spacer"></div>';
				echo '<div id="main_sub_menu"></div>';
				echo '<div id="user_panel" style="display:none;position:absolute;z-index:50;">';
				echo '<div style="height:100px;" onmouseover="hide_layer(\'user_panel\', event);"></div>';
				echo $this->drawUserLevel();
				echo '<table cellpadding="0" cellspacing="0" border="0" width="447">';
				echo '<tr>';
				echo '<td align="center" style="background:url(http://www.wevolt.com/images/user_panel_bg.png); width:147px; height:52px; background-repeat:none;">';
				echo '<a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/"><img tooltip="Go to your MYvolt page" tooltip_position="bottom" src="http://www.wevolt.com/images/myvolt_button.png" id="myvolt_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/myvolt_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/myvolt_button.png\')" class="navbuttons" hspace="2" /></a>';
				echo '<a href="http://users.wevolt.com/'.trim($_SESSION['username']).'/"><img tooltip="Go to your WEvolt page" tooltip_position="bottom" src="http://www.wevolt.com/images/w3volt_button.png" id="wevolt_button" onmouseover="this.src=\'http://www.wevolt.com/images/w3volt_button_over.png\';" onmouseover="this.src=\'http://www.wevolt.com/images/w3volt_button.png\';" class="navbuttons" /></a>';
				echo '<a href="http://www.wevolt.com/r3volt/admin/"><img tooltip="Launch the Project CMS" tooltip_position="bottom" src="http://www.wevolt.com/images/r3volt_button.png" id="r3volt_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/r3volt_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/r3volt_button.png\')" class="navbuttons" hspace="2"/></a>';
				
                   echo '</td>
                    <td width="300"  onmouseover="hide_layer(\'user_panel\', event);">&nbsp;
                    </td>
      	          </tr>
        	    </table>
            	<div style="height:100px;" onmouseover="hide_layer(\'user_panel\', event);"></div>
      			 </div>
				</div>';            
		}
		
		public function drawUserLevel()
		{
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$username = $_SESSION['username'];
			$users = new Users;
			$rank = $users->getxp($db, $username);
			$percent = $rank->percent;
			?>
			<style cache="<?php echo date('Y-m-d H:i:s'); ?>">
			  .rank_piece {
			  	font-size:10px;
			  	background-color:#999;
			  	-webkit-border-radius: 20px;
				-moz-border-radius: 20px;
				border-radius: 20px;
				text-align:center; 
				padding:2px;
				border-style:solid;
				border-color:#333;
				border-width:2px;
				color:#333;
				background:-webkit-gradient(
							    linear,
							    left bottom,
							    left top,
							    color-stop(0, rgb(100,100,100)),
							    color-stop(0.50, rgb(250,250,250))
							);
				background:-moz-linear-gradient(
							    center bottom,
							    rgb(100,100,100) 0%,
							    rgb(250,250,250) 50%
							);
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#646464);
				-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#646464, GradientType=1);
			  }
			  .rank_label {
			  	margin-bottom:2px;
			  	color:#000;
			  }
			  .rank_holder {
			  	-webkit-border-radius: 20px;
				-moz-border-radius: 20px;
				border-radius: 20px;
				text-align:center; 
				padding:5px;
				border-style:solid;
			  	border-width:2px;
			  	background-color:#ddd;
			  	border-color:#333;
			  	width:215px;
			  	text-shadow: 1px 1px 1px #4d4d4d;
				filter: dropshadow(color=#4d4d4d, offx=1, offy=1);
			  	background:-webkit-gradient(
							    linear,
							    left bottom,
							    left top,
							    color-stop(0, rgb(100,100,100)),
							    color-stop(0.50, rgb(250,250,250))
							);
				background:-moz-linear-gradient(
							    center bottom,
							    rgb(100,100,100) 0%,
							    rgb(250,250,250) 50%
							);
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#646464);
				-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#646464, GradientType=1);
			  }
			  .xpprogress {
			  	color:#333;
			  	background-color:#eee;
			  	background:-webkit-gradient(
							    linear,
							    left top,
							    right top,
							    color-stop(<?php echo $percent; ?>, rgb(254,216,0)),
							    color-stop(<?php echo $percent + .1; ?>, rgb(255,255,255))
							);
				background:-moz-linear-gradient(
							    left center,
							    rgb(254,216,0) <?php echo $percent * 100; ?>%,
							    rgb(255,255,255) <?php echo ($percent * 100) + 10; ?>%
							);
			  }
			</style>
			<div class="rank_holder" tooltip_position="top" tooltip="This is your WEvolt XP meter. Gain XP and levels by doing all kinds of things on the site.">
			  <div style="display:inline-block;margin-right:2px;width:150px;">
			    <div class="rank_label">xp/nxt lvl</div>
			    <div class="rank_piece xpprogress"><?php echo $rank->xp . '/' . $rank->next_level; ?></div>
			  </div>
			  <div style="display:inline-block;width:50px;">
			    <div class="rank_label">lvl</div>
			    <div class="rank_piece"><?php echo $rank->level; ?></div>
			  </div>
			</div>
			<?php 
		}
		
		public function drawGetStartedMod() {
				$this->drawStandardModuleTop('<div style="height:5px;"></div><img src="http://www.wevolt.com/images/get_started_text.png">', 300, '', 12,'');
 				echo '<a href="http://www.wevolt.com/get_started.php">';
				echo '<img src="http://www.wevolt.com/images/get_started_OFF2.jpg" id="get_started" onmouseover="roll_over(this, \'http://www.wevolt.com/images/get_started_OVER2.jpg\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/get_started_OFF2.jpg\')" class="navbuttons" />';
				echo '</a><div style="display:none;"><img src="http://www.wevolt.com/images/get_started_OVER2.jpg" /></div>';
  				$this->drawStandardModuleFooter();
		}
		
		public function drawUserMenu() {
				  echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
				  echo '<td background="http://www.wevolt.com/images/user_nav_bg.png" width="289" height="52"  style="background-repeat:no-repeat;" align="center">';
				  echo '<a href="http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/"><img tooltip="Go to your MYvolt page" src="http://www.wevolt.com/images/myvolt_button.png" id="myvolt_button" onmouseover="roll_over(\'myvolt_button\', \'http://www.wevolt.com/images/myvolt_button_over.png\')" onmouseout="roll_over(\'myvolt_button\', \'http://www.wevolt.com/images/myvolt_button.png\')" class="navbuttons" hspace="2"/></a>';
				  echo '<a href="http://users.wevolt.com/'.trim($_SESSION['username']).'/"><img tooltip="Go to your WEvolt page" src="http://www.wevolt.com/images/w3volt_button.png" id="w3volt_button" onmouseover="roll_over(\this, \'http://www.wevolt.com/images/w3volt_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/w3volt_button.png\')" class="navbuttons"/></a>';
				  echo '<a href="http://www.wevolt.com/r3volt/admin/"><img tooltip="Create and manage projects" src="http://www.wevolt.com/images/r3volt_button.png" id="r3volt_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/r3volt_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/r3volt_button.png\')" class="navbuttons" hspace="2"/></a>';
				  echo '<a href="http://users.wevolt.com/myvolt/'.$_SESSION['username'].'/?t=volts"><img tooltip="Open your Volt Manager" src="http://www.wevolt.com/images/volt_manager.png" id="voltmanager" onmouseover="roll_over(this, \'http://www.wevolt.com/images/volt_manager_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/volt_manager.png\')"border="0"/></a>';
				  echo '<img tooltip="Mark the current page on your string" src="http://www.wevolt.com/images/mark_button.png"  onclick="mark_page(\''. $_SESSION['currentStringID'].'\',\''.$_SESSION['CurrentMarkStatus'].'\');" id="mark_button" onmouseover="roll_over(this, \'http://www.wevolt.com/images/mark_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/mark_button.png\')" class="navbuttons"/>';
				  echo '<a id="westring"><span id="string_button_on"><img src="http://www.wevolt.com/images/string_button.png" id="showstring" onclick="toggle_string_button(\'on\');"  onmouseover="roll_over(this, \'http://www.wevolt.com/images/string_button_over.png\')" onmouseout="roll_over(this, \'http://www.wevolt.com/images/string_button.png\')" class="navbuttons" tooltip="The string keeps track of all the pages you visit on the WEvolt" /></span>';
				  echo '<span id="string_button_off" style="display:none;"><img src="http://www.wevolt.com/images/string_button_over.png" id="hidestring" onclick="toggle_string_button(\'off\');hide_layer(\'popupmenu\', event);" class="navbuttons"/></span></a>';
				  echo '</td></tr></table>';
		
		
		}
		
		public function drawDrawerMenu($set, $Total, $Position) {
				$Count = ($Total - 3);
				echo '<div id="drawer_set_'.$set.'">';
				echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';


				echo '<td background="http://www.wevolt.com/images/drawer_nav_bg.png" width="177" height="52"  style="background-repeat:no-repeat;" align="center">';
				while ($Count <= $Total) {
					echo '<span id="drawer_'.$Count.'_on"><img src="http://www.wevolt.com/images/drawer_'.$Count.'_button.png" id="showdrawer'.$Count.'" onclick="$(\'.drawer[id!=drawer_'. $Count .']\').slideUp();$(\'#drawer_'.$Count.'\').slideToggle();" style="cursor:pointer;" onmouseover="roll_over(\'showdrawer'.$Count.'\', \'http://www.wevolt.com/images/drawer_'.$Count.'_button_over.png\')" onmouseout="roll_over(\'showdrawer'.$Count.'\', \'http://www.wevolt.com/images/drawer_'.$Count.'_button.png\')" tooltip="Open your WEvolt drawer"/></span>';
					$Count++;
				}
				echo '</td></tr></table>';
				echo '</div>';
		
		
		}
		
		public function drawLegal() {
			echo '<div class="legal" align="center">';
			echo '<div class="spacer"></div>';
			echo '<a href="http://www.wowio.com" target="_blank">2010 WOWIO</a> | <a href="http://www.wevolt.com/privacy_policy.php">Privacy Policy</a> | <a href="http://www.wevolt.com/terms_of_use.php">Terms of Use</a>';
			echo '</div>';
		}

		public function drawHeader() {
				echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
				echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
				echo '<head>';
			
		}
		
		public function drawMenuExtras() {
				echo '<div id="popupmenu" style="display:none;"></div>';
				echo '<div id="mainpop" style="display:none;"></div>';
				echo '<div id="popclose" style="display:none;" onmouseover="close_popup();"></div>';
				echo '<div id="popclosetop" style="display:none;" onmouseover="close_popup();"></div>';
				echo '<div id="popclosebottom" style="display:none;" onmouseover="close_popup();"></div>';
				echo '<div id="drawerclose" style="display:none;" onmouseover="hide_drawer();"></div>';
				echo '<div id="drawerclosetop" style="display:none;" onmouseover="hide_drawer();"></div>';
				echo '<div style="display:none;">';
				echo '<input type=\'hidden\' name=\'mousex\' id=\'mousex\' />';
				echo '<input type=\'hidden\' name=\'mousey\' id=\'mousey\' />';
				echo '<input type=\'hidden\' name=\'selectedMini\' id=\'selectedMini\' />';
				echo '<input type=\'hidden\' name=\'CurrentDrawer\' id=\'CurrentDrawer\' />';
				echo '</div>';
		}
		
		
		
		public function drawCSS() 
		{
			$cssArray = array(
							  'css/pf_css_new.css',
							  'scripts/skins/tango/skin.css',
							  'scripts/lib/jquery.jcarousel.css',
							  'css/modal-window.css',
							  'css/lightbox_black.css',
							  'css/superfish.css',
							  'css/superfish-vertical.css',
							  'css/superfish-navbar.css',
							  'css/jquery.contextMenu.css',
							  'css/fullcalendar.css?cache=' . time(),
							  'css/jquery.tweet.css',
							  'css/cupertino/jquery-ui-1.8.1.custom.css',
							  'css/global.css'
			);   
			foreach ($cssArray as $css) {
				echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"http://www.wevolt.com/$css\" />";
			}
		}
		
		public function drawUpdateCSS() {
				echo '<style type="text/css">';
				echo '#updateBox_T {
							background-color:#e9eef4;
							height:8px;
					  }

					.updateboxcontent {
							color:#000000;
							background-color:#e9eef4;
					}
					
					#updateBox_B {
							background-color:#e9eef4;
							height:8px;
					 
					}
					
					#updateBox_TL{
							width:8px;
							height:8px; 
							background-image:url(http://www.wevolt.com/images/update_wrapper_TL.png);
							background-repeat:no-repeat;
					}
					
					#updateBox_TR{
							width:8px;
							height:8px; 
							background-image:url(http://www.wevolt.com/images/update_wrapper_TR.png);
							background-repeat:no-repeat;
					}
					
					#updateBox_BR{
							width:8px;
							height:8px; 
							background-image:url(http://www.wevolt.com/images/update_wrapper_BR.png);
							background-repeat:no-repeat;
					}
					#updateBox_BL{
							width:8px;
							height:8px; 
							background-image:url(http://www.wevolt.com/images/update_wrapper_BL.png);
							background-repeat:no-repeat;
					}
					</style>';
		}
		
		public function drawGlobalScripts() {
				echo '<script type="text/javascript" src="http://www.wevolt.com/scripts/menu_functions.js"></script>';
				echo '<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>';
				echo '<script type="text/javascript" src="/scripts/wizard_functions.js?cache=' . date('Y-m-d H:i:s') . '"></script>';
				echo '<script type="text/javascript" src="http://www.wevolt.com/js/swfobject.js"></script>';
		}
		
		public function drawJQueryScripts() 
		{
			$array = array('js/jquery-1.4.2.min.js',
						   'js/hoverIntent.js',
						   'js/superfish.js',
						   'scripts/jquery.qtip-1.0.0-rc3.js',
						   'scripts/jquery.cycle.all.js',
						   'scripts/lib/jquery.jcarousel.pack.js',
						   'scripts/modal-window.min.js',
						   'ajax/RssReader.js',
						   'js/jquery.contextMenu.js',
						   'js/jquery-ui-1.8.1.custom.min.js',
						   'js/jquery.tweet.js',
						   'js/fullcalendar.js');	
			foreach ($array as $script) {
				echo "<script src=\"http://www.wevolt.com/$script\"></script>";
			}
		}
		
		public function drawModuleCSS() {
				echo '<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">';
			
			
		}
		
		public function drawProjectScripts() {
				echo '<script  language="javascript" src="http://www.wevolt.com/js/swfaddress.js"></script>';
				echo '<link href="http://www.wevolt.com/scripts/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>';
				echo '<script src="http://www.wevolt.com/scripts/facebox/facebox.js" type="text/javascript"></script>';
			
		}
		
		public function drawStandardModuleTop($Header, $Width = null, $Height = null, $Dif = null, $TRNav = null) 
		{
			$style[] = 'margin:10px';
			if ($Width) {
				$style[] = "width:{$Width}px";
			}
			if ($Height) {
				if ($Height == 'auto') {
					$style[] = "height:auto";
				} else {
					$style[] = "height:{$Height}px";
				}
			} 
			if ($style) {
				$style = 'style="' . implode(";", $style) . '"';
			}
			echo "<div $style>
				  <div class=\"panel_top\">$Header</div>
				  <div class=\"panel_body\">";
		}
		
		public function drawStandardModuleFooter() 
		{
			echo '</div></div>';
		}		
			
		public function getTitle() {
				return $this->GlobalTitle;
		} 
		public function getGlobalCopyright() {
				return $this->GlobalCopyright;
		} 
		public function getGlobalDescription() {
				return $this->GlobalDescription;
		}
		public function getGlobalKeywords() {
				return $this->GlobalKeywords;
		}
			
			

	}




?>