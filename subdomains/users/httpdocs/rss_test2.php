<?
include("classes/gFeed.php");
$f = fopen("http://www.comicbookresources.com/feed.php?feed=news","r");
/* Rewinding && reading the first line, which is the RSS information. */

rewind($f);
fread($f,1);

print "<h1>${title}</h1>";
print "<b>Link</b>: ${link}<br/>\r\n";
print "<b>Description</b>: ${description}<br/>\r\n";
print "<b>Generator</b>: ${generator}<br/>\r\n";
print "<b>Lenguage</b>: ${language}<br/>\r\n";
print "<b>Encoding</b>: ${encoding}<br/>\r\n";

print "<br/>\r\n";

print "<hr>\r\n";



while ( fread($f, 1) ) {
    /*

     *    After the first read (information of blog), comes

     *    the RSS entries

     */

    print "<b>Title</b>: ${title}<br/>\r\n";

    print "<b>Link</b>: ${link}<br/>\r\n";

    print "<b>Author</b>: ${author}<br/>\r\n";

    print "<b>Date</b>: ${date}<br/>\r\n";

    print "<b>Description</b>: ${description}<br/>\r\n";

    print "<hr>\r\n";

}

fclose($f);
?> 