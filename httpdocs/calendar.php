<?php 
include_once('includes/init.php'); 
$PageTitle .= 'calendar';
//include_once('includes/header_template_new.php');
$Site->drawModuleCSS();
if ($view = $_REQUEST['view']) {
	if ($view == 'week') {
		$view = 'basicWeek';
	} elseif ($view == 'day') {
		$view = 'basicDay';
	}
} else {
	$view = 'month';
}
if (!$date = $_REQUEST['date']) {
	$date = date('Y-m-d');
}
$date = explode('-', $date);
$year = $date[0];
$month = $date[1]-1;
$day = $date[2];
if (!$userid = $_GET['userid']) {
	$userid = '64223ccf3b0';
}
?>
<script>
$(document).ready(function() {
	var eventArray = new Array();
	$('#calendar').fullCalendar({
		theme: true,
		header: {
			left:   'prev,next today',
	    	center: 'title',
	    	right:  'sort month,basicWeek,basicDay'
		},
		defaultView: '<?php echo $view; ?>',
		year: '<?php echo $year; ?>',
		month: '<?php echo $month; ?>',
		date: '<?php echo $day; ?>',
		allDayDefault: false,
		userid: '<?php echo $userid; ?>',
		events: '/ajax/events.php',
		eventRender: function(event, element, view) {
			var html = '<a  href="javascript:void(0)" onclick="view_event(\'view\',\''+event.id+'\');">';
			element.attr('eventid', event.id);
			element.attr('encryptid', event.encrypt_id);
			element.addClass(event.type);
			if (view.name == 'month') {
				if ( event.thumb ) {
					html += '<img src="' + event.thumb + '" width="25" height="25" />';
				} else {
					html += '<div style="font-size:10px;"><b><i>' + event.title + '</i></b></div>';
				}
			} else if (view.name == 'basicWeek') {
				if ( event.thumb) {
					html += '<div><img src="' + event.thumb + '" width="50" height="50" /></div>';
				}
			    html += '<div><span style="font-size:10px;">' + $.fullCalendar.formatDate(event.start, 'h:mm tt');
				if (event.end) {
					html += ' - ' + $.fullCalendar.formatDate(event.end, 'h:mm tt');
				}
				html += '</span></div><div style="font-size:10px;">';
				html += '<b><i>' + event.title + '</i></b>';
				html += '</div>';
			}else if (view.name == 'basicDay') {
				html += '<table cellspacing="0" cellpadding="0"><tr>';
				if ( event.thumb) {
					html += '<td width="50" valign="top"><div><img src="' + event.thumb + '" width="40" height="40" hspace="5"/></div></td>';
				}
				html += '<td width="150" valign="top" style="color:#000;background-color:#e5e5e5; border:1px #666666 solid; padding:2px;overflow:hidden;height:40px;"><div style="overflow:hidden;height:40px;">';
				html += '<div style="font-size:10px;"><b><i>' + event.title + '</i></b></div></div></td></tr></table>';
			}
			html += '</a>';
			element.html(html);
	    },
		eventAfterRender: function(event, element, view) {
	    	element.draggable({
				revert: true,
				helper: 'clone',
				appendTo: 'body',
				opacity: .5
			});
			if (view.name == 'month') {
				element.qtip({
					content: '<div>' + $.fullCalendar.formatDate(event.start, 'h:mm tt') + ' - ' + event.type + '</div><hr /><div><b><i>' + event.title + '</i></b></div><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			} else if (view.name == 'basicWeek') {
				element.qtip({
					content: '<div>' + event.type + '</div><hr /><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			} else if (view.name == 'basicDay') {
				element.qtip({
					content: '<div>' + event.type + '</div><hr /><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			
			}
	    }
	});
	$('#calendar_selector').change(function(value){
		$('#calendar').fullCalendar('type', $(this).val()); 
		$('#calendar').fullCalendar('refetchEvents');
	});
	$('#cal_add_button').click(function(){
		open_event_wizard('add');
	});
	$('#cal_trash_button').qtip({
		content: 'Drag events here to delete them.',
		position: {
			target: 'mouse',
			adjust: {
				screen: true
			}
		},
		style: {
			name: 'blue'
		}
	});
	$('#cal_edit_button').qtip({
		content: 'Drag events here to edit them.',
		position: {
			target: 'mouse',
			adjust: {
				screen: true
			}
		},
		style: {
			name: 'blue'
		}
	});
	$('#cal_trash_button').droppable({
		tolerance: 'pointer',
		over: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_on.png');
		},
		out: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_off.png');
		},
		drop: function(event, ui) {
			var ans = confirm('are you sure you want to delete this event?');
			if (ans) {
				$.post('/ajax/events.php', {action: 'delete', id: ui.draggable.attr('eventid')}, function() {
					$('#calendar').fullCalendar('refetchEvents');
				});
			}
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_off.png');
		}
	});
	$('#cal_edit_button').droppable({
		tolerance: 'pointer',
		over: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_on.png');
		},
		out: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_off.png');
		},
		drop: function(event, ui) {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_off.png');
			open_event_wizard('edit', ui.draggable.attr('encryptid'));
		}
	});
});
</script>
<? require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

?>

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
 <div id="calendar"></div>
 </div>

	</td>
  </tr>
 
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>
