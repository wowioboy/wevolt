// ALL CMS WIZARD/CONTENT FUNCTIONS
function edit_script_peel(pageid){
	$(this).modal({width:624, height:416,src:"/connectors/script_peel.php?pageid="+pageid}).open(); 
}

function edit_hotspot_content(id,cid){
	$(this).modal({width:624, height:416,src:"/pf_16_core/write_hot_spot_html.php?id="+id+"&cid="+cid}).open(); 
}
function select_rg_entry(){
	$(this).modal({width:624, height:416,src:"/connectors/select_rg_entry.php"}).open(); 
}


function open_menu_wizard(id, a,project, theme) { 
	$(this).modal({width:800, height:500,src:"/pf_16_core/includes/edit_menu_links_inc.php?id="+id+"&a="+a+"&comic="+project+"&theme="+theme}).open(); 
}

function edit_template_section(section,projectid,template,skin,theme){
		$(this).modal({width:800, height:489,src:"/connectors/edit_template_settings.php?section="+section+"&project="+projectid+"&template="+template+"&skin="+skin+"&theme="+theme}).open(); 
};

function preview_theme(theme,projectid){
		$(this).modal({width:800, height:700,src:"/connectors/preview_theme.php?theme="+theme+"&project="+projectid}).open(); 
};
 
 function install_theme(theme,projectid){ 
		$(this).modal({width:500, height:400,src:"/connectors/use_theme.php?theme="+theme+"&project="+projectid}).open(); 
 
};
