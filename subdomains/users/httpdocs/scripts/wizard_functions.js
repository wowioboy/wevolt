// ALL WIZARD/CONTENT POPUP FUNCTIONS
function add_drawer_item(refer,itemid,itemtitle,itemlink){
	$(this).modal({width:624, height:416,src:"/connectors/add_drawer_item.php?refer="+refer+"&id="+itemid+"&title="+escape(itemtitle)+"&link="+escape(itemlink)}).open(); 
}

function edit_drawer(drawerid){
	$(this).modal({width:624, height:416,src:"/connectors/edit_drawer.php?id="+drawerid}).open(); 
}

function edit_item(itemid,section){
	
	$(this).modal({width:624, height:416,src:"/connectors/edit_item.php?id="+itemid+"&section="+section}).open(); 
}

function send_item(itemid,section){
	
	$(this).modal({width:624, height:416,src:"/connectors/send_item.php?id="+itemid+"&section="+section}).open(); 
}


function show_beta(){
	$(this).modal({width:624, height:416,src:"http://www.wevolt.com/betaalert.html"}).open(); 
}

function play_embed(itemid,module,ewidth, eheight){

	$(this).modal({width:ewidth, height:eheight,src:"http://www.wevolt.com/connectors/play_embed.php?module="+module+"&item="+itemid}).open(); 
}

function invite_friends(){
	$(this).modal({width:624, height:416,src:"/connectors/invite_friends.php"}).open(); 
}
function edit_signature(){
	$(this).modal({width:624, height:416,src:"/connectors/edit_wevolt_sig.php"}).open(); 
}

function add_volt(itemid,refer, Subvariable1, Subvariable2){
	$(this).modal({width:624, height:416,src:"/connectors/volt_item.php?refer="+refer+"&id="+itemid+"&var1="+escape(Subvariable1)+"&var2="+escape(Subvariable2)}).open(); 
};

function update_excite(projectid,cat, type){
		
		$(this).modal({width:624, height:416,src:"/connectors/update_excite.php?id="+projectid+"&type="+type+'&cat='+cat}).open(); 
}
function window_wizard(action){
		$(this).modal({width:624, height:416,src:"/connectors/feed_wizard.php"}).open(); 
	
}

function edit_wevolt_window(module){

		$(this).modal({width:624, height:416,src:"/connectors/edit_wevolt_window.php?window="+module}).open(); 
	
}

function edit_wevolt_window_label(module){

		$(this).modal({width:624, height:416,src:"/connectors/edit_wevolt_window_label.php?window="+module}).open(); 
	
}

function volt_wizard(projectid, cat, type){
		$(this).modal({width:624, height:416,src:"/connectors/volt_wizard.php?id="+projectid+"&type="+type+"&cat="+cat}).open(); 
}

function edit_template_section(section,projectid,template,skin,theme){
		$(this).modal({width:750, height:650,src:"/connectors/edit_template_settings.php?section="+section+"&project="+projectid+"&template="+template+"&skin="+skin+"&theme="+theme}).open(); 
};

function network_wizard(frienduser,userid,other) {
		$(this).modal({width:624, height:416,src:"/connectors/network_wizard.php?user="+frienduser}).open(); 
	
}
function edit_window(windowid,type,action,section){
		
		$(this).modal({width:624, height:416,src:"/connectors/update_window_myvolt.php?window="+windowid+"&stype="+type+"&action="+action+"&section="+section}).open(); 
}

function preview_theme(theme,projectid){
		$(this).modal({width:840, height:700,src:"/connectors/preview_theme.php?theme="+theme+"&project="+projectid}).open(); 
};
 
function open_event_wizard(action,eventid) {
	$(this).modal({width:700, height:467,src:"/connectors/event_wizard.php?a="+action+"&e="+eventid}).open(); 
	
}
function open_feed_wizard(title, contentid, contentlink, contenttype, action,username){
	var querystring = '?name='+username+'&title='+escape(title)+'&content='+escape(contentid)+'&ctype='+escape(contenttype)+'&link='+contentlink;
	if (action == 'add')
		 querystring =  querystring + '&add=1';
		 $(this).modal().close();
		$(this).modal({width:624, height:416,src:"/connectors/feed_wizard.php"+querystring}).open(); 
};


function install_theme(theme,projectid){ 
		$(this).modal({width:500, height:400,src:"/connectors/use_theme.php?theme="+theme+"&project="+projectid}).open(); 
 
};

function edit_module(theme,projectid,type,placement){
		$(this).modal({width:624, height:416,src:"/connectors/edit_modules.php?module="+theme+"&project="+projectid+"&type="+type+"&placement="+placement}).open(); 
};

function pop_login(ref){
		$(this).modal({width:314, height:396,src:"http://www.wevolt.com/connectors/login_form.php?f=iframe&r="+ref}).open(); 
};

function reader_config(project,page,redirect,episode,series){
	$(this).modal({width:624, height:416,src:"/connectors/reader_config.php?project="+project+"&page="+page+"&episode="+episode+"&series="+series+"&ref="+escape(redirect)}).open(); 
};

function reply_comment(cid,pid,section,user){
	var postback = document.getElementById("postback").value;
	$(this).modal({width:624, height:416,src:"/connectors/reply_comment.php?cid="+cid+"&pid="+pid+"&user="+user+"&section="+section+"&postback="+escape(postback)}).open(); 
};

function share_project(itemid,title){
	if (usermail == null)
		var usermail = '';
	$(this).modal({width:624, height:416,src:"/connectors/share_project.php?id="+itemid+"&refer="+escape(usermail)+"&title="+escape(title)}).open(); 
};

function view_event(action, id) {
	$(this).modal({width:700, height:467,src:"http://www.wevolt.com/connectors/view_event.php?id="+id+"&action="+action}).open(); 
	
}
function open_pro_features() {
	$(this).modal({width:700, height:467,src:"http://www.wevolt.com/connectors/pro_features.html"}).open(); 
	
}

function new_wizard(wiztype, id, type, contenttype) { 
	$(this).modal().close();
	if (wiztype == 'excite') { 
		update_excite(id,type,contenttype);
	}
}

