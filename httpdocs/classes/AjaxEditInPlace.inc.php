<?php
	/**
	 * This class returns a DHTML code to enable some text to be edited on the fly (edit in place)
	 * This class is compatible for PHP 4.x and PHP 5.x
	 * 
	 * Version 2 enables you to create grid like structure and edit on the fly
	 *
	 *
	 * @version 2
	 * @author Rochak Chauhan
	 * @uses Prototype library for AJAX
	 */
	class AjaxEditInPlace {
		
		var $codeToBeEdited = '';
		var $styleSheetClassName = '';
				
		/**
		 * Constructor function
		 * 
		 * @param string $codeToBeEdited
		 * @param string $styleSheetClassName
		 *
		 */
		function AjaxEditInPlace($codeToBeEdited, $styleSheetClassName) {
			
			if ($styleSheetClassName == '') {
				die("INVALID stylesheet class Name");
			}
			
			if ($codeToBeEdited == '') {
				die("Please enter some text");
			}
			
			$this->codeToBeEdited = $codeToBeEdited;
			$this->styleSheetClassName = $styleSheetClassName;
		}
		
		/**
		 * This function returns the AJAX Code, which can be edited in place
		 * 
		 * @param string $idName
		 * 
		 * @return string
		 */
		function getEditInPlaceCode($idName) {
			return '<p class="'.$this->styleSheetClassName.'" id="'.$idName.'" title="Click here to edit this text">'.$this->codeToBeEdited.'</p>';
		}
}
?>