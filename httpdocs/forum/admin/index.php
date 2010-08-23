<? 
include 'includes/forum_admin_functions_inc.php';
if($AdminUser) {
 if ($_GET['task'] == '') {
		$IncludeFile = 'dash_template.php';
} else if ($_GET['task'] == 'list_boards') {
		$IncludeFile = 'board_list_template.php';

} else if ($_GET['task'] == 'edit_board') {

		$IncludeFile = 'edit_board_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'save')){
			  save_board($_POST['txtID'],$_POST['txtTitle'], $_POST['txtDescription'], $ForumOwner, $ProjectID, $ForumType, $_POST['txtCat'], $_POST['txtModerators'],$_POST['txtPermissions'],$_POST['txtPrivacy'],$_POST['txtPosition'],$_POST['txtTags'], $_POST['txtGroups'], $_POST['txtPro']);
			  $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards";
			// header("location:);
			 // print ' redirect  ' . "location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards";
		}
} else if ($_GET['task'] == 'delete_board') {
		$IncludeFile ='delete_board_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'delete')){
			  delete_board($_POST['txtID'], $_POST['txtCat'], $ForumOwner, $ProjectID, $ForumType);
			  $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards";
			 // header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards");
		}
} else if ($_GET['task'] == 'new_board') {
		$IncludeFile = 'new_board_template.php';

		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'new')){
			add_board($_POST['txtTitle'], $_POST['txtDescription'], $ForumOwner, $ProjectID, $ForumType, $_POST['txtCat'], $_POST['txtModerators'],$_POST['txtPermissions'],$_POST['txtPrivacy'],$_POST['txtPosition'],$_POST['txtTags'], $_POST['txtGroups'], $_POST['txtPro']);
			   $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards";
		//	header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_boards");
		}

} else if ($_GET['task'] == 'global_settings') {

		$IncludeFile = 'global_settings_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'save')){
			  save_forum_settings($ForumOwner, $BoardID, $ProjectID, $SettingsArray);
			   $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin";
			 // header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin");
		}
} else if ($_GET['task'] == 'list_categories') {
		$IncludeFile ='category_list_template.php';

} else if ($_GET['task'] == 'new_category') {
		$IncludeFile = 'edit_category_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'new')){

		add_category($_POST['txtTitle'], $_POST['txtDescription'],$ForumOwner, $ProjectID, $ForumType);
				   $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_categories";
		 
			//  header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_categories");
		}
} else if ($_GET['task'] == 'edit_category') {
		$IncludeFile = 'edit_category_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'save')){
			   save_category($_POST['txtID'],$_POST['txtTitle'], $_POST['txtDescription'],$ForumOwner, $ProjectID, $ForumType, $_POST['txtPosition']);
			 $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_categories";

			  //header("location:/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_categories");
		}
} else if ($_GET['task'] == 'delete_category') {

		$IncludeFile = 'delete_category_template.php';
		if ((isset($_POST['submitted'])) && ($_POST['txtAction'] == 'delete')){
			 
			  delete_category($_POST['txtID'],$ForumOwner, $ProjectID, $ForumType, $_GET['txtCurrentPosition']);
			  $ReloadUrl = "/forum/index.php?".$ForumType."=".$TargetName."&a=admin&task=list_categories";

		}
}



if ($ReloadUrl != '') {?>
<script type="text/javascript">
document.location.href='<? echo $ReloadUrl;?>';
</script>	
	
	
<? } ?>


 <table width="721" cellpadding="0" cellspacing="0" border="0">
           <tr>
             <td align="left" width="120" height="20" style="background-image:url(http://www.wevolt.com/images/myvolt_base_left.png); background-repeat:no-repeat;font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;color:#15528e;">
               &nbsp;&nbsp; &nbsp;&nbsp;FORUM ADMIN <div style="height:1px;"></div>
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_bg.png); background-repeat:repeat-x; background-position:top;" width="600" align="right"><div style="height:1px;"></div>
             <?php if ($_GET['task'] == 'list_boards') : ?>
                 <img src="http://www.wevolt.com/images/forums/editboards_on.png" />
               <?php else: ?>
              <a href="index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_boards">
                 <img src="http://www.wevolt.com/images/forums/editboards_off.png" onmouseover="this.src='http://www.wevolt.com/images/forums/editboards_over.png';" onmouseout="this.src='http://www.wevolt.com/images/forums/editboards_off.png';" class="navbuttons" hspace="4"/>
               </a>
               <?php endif; ?>
               
               <?php if ($_GET['task'] == 'new_board') : ?>
                 <img src="http://www.wevolt.com/images/forums/newboard_on.png" />
               <?php else: ?>
              <a href="index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=new_board">
                 <img src="http://www.wevolt.com/images/forums/newboard_off.png" onmouseover="this.src='http://www.wevolt.com/images/forums/newboard_over.png';" onmouseout="this.src='http://www.wevolt.com/images/forums/newboard_off.png';" class="navbuttons" hspace="4"/>
               </a>
               <?php endif; ?>
               
               <?php if ($_GET['task'] == 'list_categories') : ?>
                 <img src="http://www.wevolt.com/images/forums/editcat_off.png" />
               <?php else: ?>
              <a href="index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=list_categories">
                 <img src="http://www.wevolt.com/images/forums/editcat_off.png" onmouseover="this.src='http://www.wevolt.com/images/forums/editcat_over.png';" onmouseout="this.src='http://www.wevolt.com/images/forums/editcat_off.png';" class="navbuttons" hspace="4"/>
               </a>
               <?php endif; ?>
               <?php if ($_GET['task'] == 'new_category') : ?>
                 <img src="http://www.wevolt.com/images/forums/newcat_off.png" />
               <?php else: ?>
              <a href="index.php?<? echo $ForumType;?>=<? echo $TargetName;?>&a=admin&task=new_category">
                 <img src="http://www.wevolt.com/images/forums/newcat_off.png" onmouseover="this.src='http://www.wevolt.com/images/forums/newcat_over.png';" onmouseout="this.src='http://www.wevolt.com/images/forums/newcat_off.png';" class="navbuttons" hspace="4"/>
               </a>
               <?php endif; ?>
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_right.png);  background-position:top right;background-repeat:no-repeat;" width="21" align="left"></td>
           </tr>
         </table><div class="spacer"></div><? 
		 $Site->drawStandardModuleTop('<div class="sender_name">'.ucfirst(str_replace('_', ' ', $_GET['task'])).'</div><div style="height:3px;"></div>', 721, '', 12,'');?>
<? include $IncludeFile; 
$Site->drawStandardModuleFooter();
}


?>