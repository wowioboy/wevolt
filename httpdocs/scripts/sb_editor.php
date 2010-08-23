
<script type="text/javascript">
	<!--
	
	// Insert Style Tags
	function ins_styles(theform,sb_code,prompt_text,tag_prompt) {
		// Insert [x]yyy[/x] style markup
		
		// Get selected text
		var selected_text = getSelectedText(theform);
		
		if (selected_text == '') {
			// Display prompt if no text is selected
			var inserttext = prompt( '<?php echo( $lang_string[ 'insert_styles' ] ); ?>'+"\n["+sb_code+"]xxx[/"+sb_code+"]", '' );
			if ( (inserttext != null) ) {
				insertAtCaret(theform, "["+sb_code+"]"+inserttext+"[/"+sb_code+"]");
				theform.focus();
			}
		} else {
			// Insert text automatically around selection
			insertAtCaret(theform, "["+sb_code+"]"+selected_text+"[/"+sb_code+"]");
			theform.focus();
		}
	}
	
	// Insert Style Tags
	function ins_style_dropdown(theform, sb_code) {
		// Insert [sb_code]xxx[/sb_code] style markup
		
		if ( sb_code != '-'+'-' ) {
			// Get selected text
			var selected_text = getSelectedText(theform);
		
			if (selected_text == '') {
				prompt_text = '[' + sb_code + ']xxx[/' + sb_code + ']';
				user_input = prompt( prompt_text, '' );
				if ( (user_input != null) ) {
					insertAtCaret(theform, '['+sb_code+']'+user_input+'[/'+sb_code+']');
					theform.focus();
				}
			} else {
				// Insert text automatically around selection
				insertAtCaret(theform, "["+sb_code+"]"+selected_text+"[/"+sb_code+"]");
				theform.focus();
			}				
		}
	}
	
	// Insert Image Tag
	function ins_image(theform,prompt_text) {
		// Insert [x]yyy[/x] style markup
		inserttext = prompt('<?php echo( $lang_string[ 'insert_image' ] ); ?>'+"\n[img="+prompt_text+"xxx]",prompt_text);
		if ((inserttext != null) && (inserttext != "")) {
			insertAtCaret(theform, "[img="+inserttext+"]");
		}
		theform.focus();
	}
	
	// Insert Image Tag
	function ins_image_v2(theform) {
		image_url = prompt('<?php echo( $lang_string[ 'insert_image' ] ); ?>'+'\n[img=http://xxx] or [img=xxx]\n\n<?php echo( $lang_string[ 'insert_image_optional' ] ); ?>\nwidth=xxx height=xxx popup=true/false float=left/right','http://');
		if ((image_url != null) && (image_url != '')) {
			// Optional
			image_width = prompt('<?php echo( $lang_string[ 'insert_image_width' ] ); ?>'+'\n[img=xxx width=xxx]','');
			image_height = prompt('<?php echo( $lang_string[ 'insert_image_height' ] ); ?>'+'\n[img=xxx height=xxx]','');
			image_popup = prompt('<?php echo( $lang_string[ 'insert_image_popup' ] ); ?>'+'\n[img=xxx popup=true/false]', '');
			image_float = prompt('<?php echo( $lang_string[ 'insert_image_float' ] ); ?>'+'\n[img=xxx float=left/right]','');
			
			str = '[img='+image_url;
			if ((image_width != null) && (image_width != '')) {
				str += ' width='+image_width;
			}
			if ((image_height != null) && (image_height != '')) {
				str += ' height='+image_height;
			}
			if ((image_popup != null) && (image_popup != '')) {
				image_popup.toLowerCase;
				if ( image_popup == 'true' || image_popup =