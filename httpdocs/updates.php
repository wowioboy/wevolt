<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php'); 
$PageTitle .= 'updates';
require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();
$tab = $_GET['tab'];
if ($tab == 'calendar') {
	$tab = 3;
} else {
	$tab = 0;
}
if ($_SESSION['IsPro'] != 1) {
	$SideMenuWidth = '60px';
} else {

}
?>
<script>
$(document).ready(function(){
	$('#tabs').tabs({
		selected: <?php echo $tab; ?>
	});
	$('.expander').live('click', function(){
		var expander = $(this);
		var id = expander.attr('subjectid');
		var update = expander.attr('updateid');
		var type = expander.attr('update_type');
		var filter = expander.attr('filter');
		var box = $('#' + filter + '_' + type + '_' + id);
		if (box.css('display') == 'none') {
			var object = {
				id: id,
				type: type,
				update: update
			};
			$.get('/updates/expanded.php', object, function(data){ 
				var data = $.parseJSON(data);
				var string = '<ul>';
				$.each(data, function(){
					var date = $.fullCalendar.parseDate(this.date);
					var title = this.title;
					date = $.fullCalendar.formatDate(date, 'MMMM dS, yyyy @ h:mm tt');
					string += '<li>' + this.action + ' <a href="' + this.link + '">';
					if (title) {
						if (title.length > 17) {
							title = title.substr(0, 17) + '...';
						}
						string += title;
					} else {
						string += this.subject;
					}
					string += '</a> - ' + date + '</li>';
				});
				string += '</ul>';
				box.html(string);
				box.slideDown();
				expander.attr('src', '/images/silk/arrow_on.png');
			});
		} else {
			box.slideUp();
			expander.attr('src', '/images/silk/arrow_off.png');
		}
	});
	$('.followButton').live('click', function(){
		var button = $(this);
		var filter = button.attr('filter');
		var type = button.attr('update_type');
		var id = button.attr('subjectid');
		var object = {
			type: type,
			id: id
		};
		$.get('/updates/follow.php', object, function(data){
			// 1 = followed
			// 2 = unfollowed
			// 3 - error
			if (data == '1') {
				button.html('unfollow');
				alert("You're now a fan.");
			} else if (data == '2') {
				if (filter == 'my') {
					$('#' + id + '_' + type + '_' + filter).hide();
				} else {
					button.html('follow');
				}
				alert("You're no longer a fan.");
			} else if (data == '3') {
				alert('ajax data corrupt!');
			} else {
				alert("error occured: " + data);
			}
		});
	});
});
</script>


<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
   <div style="width:<? echo $SiteTemplateWidth;?>px;">
 <div id="tabs" style="display:inline-block;width:<? echo $SiteTemplateWidth;?>px;">
	  <ul>
	  <?php if ($_SESSION['userid']) : ?>
	    <li><a href="/updates/subtab.php?filter=my"><span>Following</span></a></li>
	    <li><a href="/updates/subtab.php?filter=friends"><span>Friends</span></a></li>
	  <?php endif; ?>
	    <li><a href="/updates/subtab.php?filter=all"><span>All</span></a></li>
	  <?php if ($_SESSION['userid']) : ?>
	  <li><a href="/updates/subtab.php?filter=calendar"><span>Calendar</span></a></li>
	  <?php endif; ?>
	  </ul>
	</div>
 </div>

	</td>
  </tr>
 
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>

