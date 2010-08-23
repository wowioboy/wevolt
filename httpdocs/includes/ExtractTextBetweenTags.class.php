<?php

    class ExtractTextBetweenTags
    {

        function extract($string,$ot,$ct)
        {

            $string    = trim($string);
            $start    = intval(strpos($string,$ot) + strlen($ot));

            $mytext    = substr($string,$start,intval(strpos($string,$ct) - $start));

            return $mytext;
        }

    }

?> 
