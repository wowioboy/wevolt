<?

    /*
    worldlocator image generator v.1.0.0b
    Map generator script
        
    By Llorenç Herrera [lha@hexoplastia.com]
    Using "NetGeo IP locator service interface class" by Manuel Lemos [http://www.phpclasses.org/browse.html/package/514.html]
    Please do not remove this credits
    */
    
    include "worldlocator_files.inc.php";
    
    $map = $maps[$map];
    $mark = $marks[$mark];
    
    $map_file = $maps_dir."/".$map[0].".".$map[1];
    $mark_file = $marks_dir."/".$mark[0].".".$mark[1];
    
    // Creating our image based on the map
    switch ($map[1])
    {
        case "gif":
            $map_image = @imagecreatefromgif ($map_file);
            break;
        case "jpg":
            $map_image = @imagecreatefromjpeg ($map_file);
            break;
        case "png":
            $map_image = @imagecreatefrompng ($map_file);
            break;
    }
    
    // Loading the marker
    switch ($mark[1])
    {
        case "gif":
            $mark_image = @imagecreatefromgif ($mark_file);
            break;
        case "jpg":
            $mark_image = @imagecreatefromjpeg ($mark_file);
            break;
        case "png":
            $mark_image = @imagecreatefrompng ($mark_file);
            break;
    }
    
    // Calculating the position of the mark on to the map based on latitude/longitude and map width and height
    $map_width = $map[2];
    $map_height = $map[3];
    
    $long += 180;
    $lat = ($lat*-1) + 90;

    $x = round (($map_width*$long)/360)-$mark[4];
    $y = round (($map_height*$lat)/180)-$mark[5];
    
    // Puts the mark over the map
    imagecopy ($map_image, $mark_image, $x, $y, 0, 0, $mark[2], $mark[3]);

    // Dump the image to the browser
    header ("Content-type: image/png");
    imagepng ($map_image);

?> 