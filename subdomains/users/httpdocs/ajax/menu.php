<?php 
session_start();
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
$function = $_REQUEST['action'];
$obj = new ajax_menu;
return $obj->$function();

class ajax_menu
{
	public function getDrawers() 
	{
		$style = 'position:absolute;display:none;';
		if ($_REQUEST['sidemenu']) {
			$style .= 'bottom:0px;';
		}
		$userid = $_SESSION['userid'];
		?>
		<div style="position:relative;">
		<?php for ($i = 1; $i < 5; $i++) : ?>
		<ul id="drawer_<?php echo $i; ?>" class="sf-menu sf-vertical drawer" style="<?php echo $style; ?>">
		    <li>
		      <a href="#" onclick="edit_drawer('<?php echo $i; ?>'); return false;">
		      <b>EDIT DRAWER <?php echo $i ?></b>
<!--		        <img src="http://www.wevolt.com/images/edit_drawer.png" border="0">-->
		      </a>
		    </li>
		    <?php echo $this->build_drawers($userid, $i); ?>
		  </ul>
		</div>
		<?php endfor; ?>
		</div>
		<?php 
	}
	
		public function format_drawer_title($string) 
		{
				$string = urldecode($string);
				$string = str_replace("%20"," ",$string);
				$string = str_replace("%27","'",$string);
				$string = ucwords(substr(strtolower($string),0,28));
				return $string;
		}
		
		public function build_drawers($userid, $drawerid)
		{
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query ="select * from drawers where UserID='$userid' and ParentID='0' and DrawerID='$drawerid' order by Position";
			$db->query($query);
			while ($drawerObj = $db->FetchNextObject()) {
				$drawers .= $this->buildDrawer($drawerObj);
			}
			$db->close();
			return $drawers;
		}
		
	public function buildDrawer($drawerObj)
	{
		if ($drawerObj->DrawerType == 'label') {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$drawer = '<li><a href="#">' . $this->format_drawer_title($drawerObj->Title) . '</a><ul>';
			$query ="select * from drawers where UserID='{$drawerObj->UserID}' and ParentID='{$drawerObj->ID}' order by Position";
			$db->query($query);
			while ($childDrawer = $db->FetchNextObject()) {
				$drawer .= $this->buildDrawer($childDrawer);
			}
			$db->close();
			$drawer .= '</ul></li>';
		} else {
		   	$drawer = "<li><a href=\"{$drawerObj->Link}\">" . $this->format_drawer_title($drawerObj->Title) . '</a></li>';
		}
		return $drawer;
	}
}
