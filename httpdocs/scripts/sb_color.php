<?php 

	// The Simple PHP Blog is released under the GNU Public License.
	//
	// You are free to use and modify the Simple PHP Blog. All changes 
	// must be uploaded to SourceForge.net under Simple PHP Blog or
	// emailed to apalmo <at> bigevilbrain <dot> com
	
	// ---------------
	// Color Functions
	// ---------------
	function hsv_to_rgb( $hue, $saturation, $brightness ) {
		// Convert HSV to RGB values
		//
		//   $hue        = 0.0 to 360.0
		//   $saturation = 0.0 to 100.0
		//   $brightness = 0.0 to 100.0
		//
		// HSV to RGB
		$r = 0;
		$g = 0;
		$b = 0;
		$degree_hue = $hue;
		// Do $hue Calcutaion
		if ( $degree_hue<=60 ) {
			$r = 255;
			$g = round( 255 * ( $degree_hue / 60 ) );
		} else if ( $degree_hue<=120 ) {
			$r = round( 255 * ( ( ( 120 - $degree_hue ) / 60 ) ) );
			$g = 255;
		} else if ( $degree_hue<=180 ) {
			$g = 255;
			$b = round( 255 * ( 1 - ( ( 180 - $degree_hue ) / 60 ) ) );
		} else if ( $degree_hue<=240 ) {
			$g = round( 255 * ( ( ( 240 - $degree_hue ) / 60 ) ) );
			$b = 255;
		} else if ( $degree_hue<=300 ) {
			$r = round( 255 * ( 1 - ( ( 300 - $degree_hue ) / 60 ) ) );
			$b = 255;
		} else if ( $degree_hue<=360 ) {
			$r = 255;
			$b = round( 255 * ( ( ( 360 - $degree_hue ) / 60 ) ) );
		}
		//
		$r += ( 255 - $r ) * ( 1 - ( $saturation / 100 ) );
		$g += ( 255 - $g ) * ( 1 - ( $saturation / 100 ) );
		$b += ( 255 - $b ) * ( 1 - ( $saturation / 100 ) );
		//
		$r *= ( $brightness / 100 );
		$g *= ( $brightness / 100 );
		$b *= ( $brightness / 100 );
		//
		$r = round( $r );
		$g = round( $g );
		$b = round( $b );
		//
		return Array( $r, $g, $b );
	}
	
	function rgb_to_hsv( $r, $g, $b ) {
		// Convert RGB to HSV values
		//
		//    $r = 0 to 255
		//    $g = 0 to 255
		//    $b = 0 to 255
		//
		//
		// Figure Out $saturation and $brightness
		$min_val = min( min( $r, $g ), $b );
		$max_val = max( max( $r, $g ), $b );
		if ( $max_val == 0 ) {
			$s = 0;
		} else {
			$s = ( $max_val - $min_val ) / $max_val;
		}
		$v = $max_val / 255;
		// Default Values
		$h = 0;
		// $nr = $brightness;
		// $ng = $brightness;
		// $nb = $brightness;
		// Figure out $hue
		if ( ( $max_val - $min_val ) != 0 ) {
			// Normalized Values
			$nr = ( $r - $min_val ) / ( $max_val - $min_val );
			$ng = ( $g - $min_val ) / ( $max_val - $min_val );
			$nb = ( $b - $min_val ) / ( $max_val - $min_val );
			if ( $nb == 0 ) {
				// Red & Green
				if ( $nr == 1 ) {
					// 0  -  - > 60
					$h = round( 60 * $ng );
				} else {
					// 60  -  - > 120
					$h = round( 120 - ( 60 * $nr ) );
				}
			} else if ( $nr == 0 ) {
				// Blue & Green
				if ( $ng == 1 ) {
					// 120  -  - > 180
					$h = round( ( 60 * $nb ) + 120 );
				} else {
					// 180  -  - > 240 $nb == 1
					$h = round( 240 - ( 60 * $ng ) );
				}
			} else if ( $ng == 0 ) {
				// Red & Blue
				if ( $nb == 1 ) {
					// 240  -  - > 300
					$h = round( ( 60 * $nr ) + 240 );
				} else {
					// 300  -  - > 360 $nb == 1
					$h = round( 360 - ( 60 * $nb ) );
				}
			}
		}
		return Array( $h, $s, $v, $nr, $ng, $nb );
	}
	
	function HexToDec( $hex_value ) {
		$r = hexdec( substr( $hex_value, 0, 2 ) );
		$g = hexdec( substr( $hex_value, 2, 2 ) );
		$b = hexdec( substr( $hex_value, 4, 2 ) );
		return Array( $r, $g, $b );
	}
	
	function DecToHex( $colorArr ) {
		$r = dechex( $colorArr[0] );
		$g = dechex( $colorArr[1] );
		$b = dechex( $colorArr[2] );
		if ( strlen($r) == 1 ) {
			$r = '0' . $r;
		}
		if ( strlen($g) == 1 ) {
			$g = '0' . $g;
		}
		if ( strlen($b) == 1 ) {
			$b = '0' . $b;
		}
		return( $r . $g . $b );
	}
?>