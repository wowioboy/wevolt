<?php
  //----------------------------------------------------------------
  // Apply Round Corner PHP-GD
  // Revision 2 [2009-07-01]
  // Corrected inconsistent corner problem caused by PHP bug 42685
  //----------------------------------------------------------------

  //
  // source: path or url of a gif/jpeg/png image -- php fopen url wrapper must be enabled if using url
  // radius: corner radius in pixels -- default value is 10
  // colour: corner colour in rgb hex format -- default value is FFFFFF
  //

  $source = $_GET[ "source" ];
  $radius = isset( $_GET[ "radius" ] ) ? $_GET[ "radius" ] : 10;
  $colour = isset( $_GET[ "colour" ] ) ? $_GET[ "colour" ] : "FFFFFF";

  //
  // 1) open source image and calculate properties
  //

  list( $source_width, $source_height, $source_type ) = getimagesize( $source );

  switch ( $source_type )
  {
    case IMAGETYPE_GIF:
      $source_image = imagecreatefromgif( $source );
      break;
    case IMAGETYPE_JPEG:
      $source_image = imagecreatefromjpeg( $source );
      break;
    case IMAGETYPE_PNG:
      $source_image = imagecreatefrompng( $source );
      break;
  }

  //
  // 2) create mask for top-left corner in memory
  //

  $corner_image = imagecreatetruecolor(
    $radius,
    $radius
  );

  $clear_colour = imagecolorallocate(
    $corner_image,
    0,
    0,
    0
  );

  $solid_colour = imagecolorallocate(
    $corner_image,
    hexdec( substr( $colour, 0, 2 ) ),
    hexdec( substr( $colour, 2, 2 ) ),
    hexdec( substr( $colour, 4, 2 ) )
  );

  imagecolortransparent(
    $corner_image,
    $clear_colour
  );

  imagefill(
    $corner_image,
    0,
    0,
    $solid_colour
  );

  imagefilledellipse(
    $corner_image,
    $radius,
    $radius,
    $radius * 2,
    $radius * 2,
    $clear_colour
  );

  //
  // 3) render the top-left, bottom-left, bottom-right, top-right corners by rotating and copying the mask
  //

  imagecopymerge(
    $source_image,
    $corner_image,
    0,
    0,
    0,
    0,
    $radius,
    $radius,
    100
  );

  $corner_image = imagerotate( $corner_image, 90, 0 );

  imagecopymerge(
    $source_image,
    $corner_image,
    0,
    $source_height - $radius,
    0,
    0,
    $radius,
    $radius,
    100
  );

  $corner_image = imagerotate( $corner_image, 90, 0 );

  imagecopymerge(
    $source_image,
    $corner_image,
    $source_width - $radius,
    $source_height - $radius,
    0,
    0,
    $radius,
    $radius,
    100
  );

  $corner_image = imagerotate( $corner_image, 90, 0 );

  imagecopymerge(
    $source_image,
    $corner_image,
    $source_width - $radius,
    0,
    0,
    0,
    $radius,
    $radius,
    100
  );

  //
  // 4) output the image -- revise this step according to your needs
  //

  header( "Content-type: image/png" );
  imagepng( $source_image );
?>
