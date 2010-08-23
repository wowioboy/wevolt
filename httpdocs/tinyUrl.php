<?php
function createTinyUrl($strURL) {
    $tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$strURL);
    return $tinyurl;
}
?>
<a href='
<?php
echo(createTinyUrl('http://www.w3volt.com/Stupid_Users/reader/episode/1/page/1/'));
?>'>CUSTOM TINY URL</a>

