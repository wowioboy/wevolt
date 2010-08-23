<? $text = '<select name="url" onchange="if(this.options[this.selectedIndex].value != -1){ window.location = this.options[this.selectedIndex].value; }">';


$SelectStart = strpos($text, '<select id="search1" name="url" onchange="if(this.options[this.selectedIndex].value != -1){ window.location = this.options[this.selectedIndex].value; }">');

if ($SelectStart == '') {
echo 'Not Found';
}

?>