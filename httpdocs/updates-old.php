<?php 
include_once('includes/init.php'); 
$PageTitle = 'updates';
include_once('includes/header_template_new.php');
$Site->drawModuleCSS();
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = "select *, up.createddate as date, count(1) as count
			from users_updates uu 
			left join updates up 
			on uu.update_id = if(uu.type = 'project', up.actionID, up.userid) 
			left join users u 
			on up.userid = u.encryptid
			left join projects p 
			on up.actionid = p.ProjectID
			where uu.user_id = '{$_SESSION['userid']}'
			group by u.username, up.actiontype
			order by up.createddate desc 
			limit 20"; 
$results = $db->query($query);
?>
<div align="left" style="font-style:italic">
<table cellpadding="0" cellspacing="0" border="0" <?php if ($_SESSION['IsPro'] == 1) : ?> width="100%"<?php endif; ?>>
  <tr>
    <?php if ($_SESSION['IsPro'] == 1) : ?>
      <?php $_SESSION['noads'] = 1; ?>
      <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><?php include 'includes/site_menu_popup_inc.php';?></td>
    <?php else : ?>
    <td width="<?php echo $SideMenuWidth;?>" valign="top"><?php include 'includes/site_menu_inc.php';?></td>
    <?php endif; ?>
    <td  valign="top" <?php if ($_SESSION['IsPro'] == 1) : ?>align="center"<?php endif; ?>>
    <?php if ($_SESSION['noads'] != 1) : ?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
    <?php endif; ?>
        <?php echo $Site->drawStandardModuleTop('updates', 600, 'auto'); ?>
        <?php while ($row = mysql_fetch_assoc($results)) : ?>
            <div style="margin:10px;">
              <img src="<?php echo $row['avatar']; ?>" width="50" height="50" />
              <div style="display:inline-block;text-align:left;">
	            <?php echo $row['username']; ?>
	            <br />
	            <?php echo $row['ActionType']; ?>
	            <br />
	            <?php $date = new DateTime($row['date']); ?>
	            <?php echo $date->format('F j, Y') . ' @ ' . $date->format('g:i a'); ?>
	            <br />
	            updates: <?php echo $row['count']; ?>
              </div>
            </div>
        <?php endwhile; ?>
      <?php echo $Site->drawStandardModuleFooter(); ?>
    </td>
  </tr>
</table>
</div>
<?php include_once('includes/footer_template_new.php'); ?>