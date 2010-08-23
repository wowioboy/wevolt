<?

    /*
    worldlocator v.1.0.1b
    Main class
    
    Shows the geographic location of a host in a world map.
    Given an IP or a Hostname, it returns information about the country, latitude and longitude of the geographic location of the host on the world. It also shows a map image marking the location. This map can ve viewed perfectly even if your server doesn't have GD.
        
    By Llorenç Herrera [lha@hexoplastia.com]
    Using "NetGeo IP locator service interface class" by Manuel Lemos [http://www.phpclasses.org/browse.html/package/514.html]
    Please do not remove this credits
    */


    class worldlocator
    {
    
        var $maps_dir;
        var $marks_dir;
        var $maps;
        var $marks;
    
        var $netgeo_api_errors = array
        (
            "Not a valid public Internet address",
            "Could not query the NetGeo service",
            "Could not understand NetGeo service response",
            "No Match"
        );
        
        var $errornum;
        
        var $mapgenerator_script = "worldlocator_imagegenerator.php";
        
        function worldlocator ()
        {
            include "worldlocator_files.inc.php";
            $this->maps_dir = $maps_dir;
            $this->marks_dir = $marks_dir;
            $this->maps = $maps;
            $this->marks = $marks;
        }
        
        function getmap_byxy ($mapname, $markname, $markx, $marky)
        {
        }
        
        function getmap_bycoordinates ($mapname, $markname, $lat, $long)
        {
        }
        
        function query_byhostname ($hostname)
        {
            return $this->query (gethostbyname ($hostname));
        }
        
        function query ($address)
        {
            $location=array();
            if(!strcmp($address,"127.0.0.1"))
            {
                $this->errornum = 0;
                return false;
            }
            if(GetType($page=@file("http://netgeo.caida.org/perl/netgeo.cgi?method=getRecord&target=".UrlEncode($address)))!="array")
            {
                $this->errornum = 1;
                return false;
            }
            for($line=0;$line<count($page);$line++)
            {
                $data=strtok($page[$line],"<\r\n");
                if(!strcmp(strtok($data,"="),"VERSION"))
                    break;
            }
            if($line>=count($page))
            {
                $this->errornum = 2;
                return false;
            }
            for($line++;$line<count($page);$line++)
            {
                $attribute=strtok(strtok($page[$line],"<\r\n"),":");
                if(strcmp($attribute,""))
                    $location[$attribute]=trim(strtok("<\r\n"));
            }
            
            if ($location["STATUS"] == "No Match" || ($location["LAT"] == 0 && $location["LONG"] == 0))
            {
                $this->errornum = 3;
                return false;
            }
            
            $this->location = $location;
            return true;
        }
        
        function embed_image ($map, $marker, $style)
        {
            // Testing if this PHP compilation supports image creation and required image formats
            if (!function_exists ("imagecreate"))
                return "Warning: This PHP compilation does not support image creation, you have to rebuild it with GD support.";
            $map_format = $this->maps[$map][1];
            $marker_format = $this->markers[$map][1];
            
            if ($map_format == "gif" || $marker_format == "gif")
                if (!function_exists ("imagecreatefromgif"))
                    return "Warning: This PHP compilation supports GD, but does not supports GIF image format.";
            if ($map_format == "jpg" || $marker_format == "jpg")
                if (!function_exists ("imagecreatefromjpeg"))
                    return "Warning: This PHP compilation supports GD, but does not supports JPG image format.";
            if ($map_format == "png" || $marker_format == "png")
                if (!function_exists ("imagecreatefrompng"))
                    return "Warning: This PHP compilation supports GD, but does not supports PNG image format.";
                    
            return "<img width=\"".$this->maps[$map][2]."\" height=\"".$this->maps[$map][3]."\" src=\"".$this->mapgenerator_script."?map=$map&mark=$marker&lat=".$this->location["LAT"]."&long=".$this->location["LONG"]."\" style=\"$style\">";
        }
        
        function embed_image_withoutgd ($map, $marker, $style)
        {
            $map = $this->maps[$map];
            $mark = $this->marks[$marker];
    
            $map_file = $this->maps_dir."/".$map[0].".".$map[1];
            $mark_file = $this->marks_dir."/".$mark[0].".".$mark[1];
        
            // Calculating the position of the mark on to the map based on latitude/longitude and map width and height
            $lat = $this->location["LAT"];
            $long = $this->location["LONG"];
            
            $map_width = $map[2];
            $map_height = $map[3];
            
            $long += 180;
            $lat = ($lat*-1) + 90;
        
            $x = round (($map_width*$long)/360)-$mark[4];
            $y = round (($map_height*$lat)/180)-$mark[5];

            $retr = "";
            $retr .=
            "
                <table border=0 cellpadding=0 cellspacing=0 style=\"$style\" width=\"".$map[2]."\" height=\"".$map[3]."\"><tr><td background=\"".$map_file."\" valign=top>
                <table border=0 cellpadding=0 cellspacing=0><tr>
                    <td valign=top><img src=null.gif width=\"".$x."\" height=1></td>
                    <td valign=top><img src=null.gif width=1 height=\"".$y."\"><br><img src=\"".$mark_file."\"></td>
                </tr></table>
                </td></tr></table>
            ";
            return $retr;
        }
        
        function geterror ()
        {
            return "Error [".$this->errornum."] ".$this->netgeo_api_errors[$this->errornum];
        }
    
    }

?> 