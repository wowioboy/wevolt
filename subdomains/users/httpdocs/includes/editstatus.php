<?php
	/**
	 * This file saves the edited text in the database/file
	 */
	if ($_POST['id'] == 'desc' ) {
		$fp = fopen('text.txt', 'w') or die("Failed to open file for writing.");
		$content = $_POST['content'];

		if(fwrite($fp, $content)) {
			echo $content;
		}
		else {
			echo "Failed to update the text";
		}
	}
	elseif ($_POST['id'] == 'desc2' ) {
		$fp = fopen('text2.txt', 'w') or die("Failed to open file for writing.");
		$content = $_POST['content'];
		if(fwrite($fp, $content)) {
			echo $content;
		}
		else {
			echo "Failed to update the text";
		}
	}
?>