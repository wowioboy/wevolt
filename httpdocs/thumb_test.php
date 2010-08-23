<? 

require_once('pf_16_core/html2ps/config.inc.php');
$WEBPAGE = 'http://www.w3volt.com';

		require_once(HTML2PS_DIR.'pipeline.factory.class.php');
		@set_time_limit(10000);
		parse_config_file(HTML2PS_DIR.'html2ps.config');
			//require_once 'pdfclasses/HTML_ToPDF.php';
			$randName = md5(rand() * time());
			$htmlFile = $WEBPAGE;
			//$defaultDomain = $_SERVER['SERVER_NAME'];
			// Full path to the PDF we are creating
			$pdfFile = 'temp/'.$randName.'.pdf';
			$PDFWIDTH = 300;
			//print 'PDF = ' . $pdfFile.'<br/>';
			//print 'htmlFile = ' . $htmlFile.'<br/>';

class MyDestinationFile extends Destination {
  /**
   * @var String result file name / path
   * @access private
   */
  			var $_dest_filename;
		
			function MyDestinationFile($dest_filename) {
    				$this->_dest_filename = $dest_filename;
			}

			function process($tmp_filename, $content_type) {
   				 copy($tmp_filename, $this->_dest_filename);
 			 }
}

class MyFetcherMemory extends Fetcher {
 				 var $base_path;
  				var $content;

 				 function MyFetcherMemory($content, $base_path) {
   					 $this->content   = $content;
    					$this->base_path = $base_path;
  					}

  				function get_data($url) {
    				if (!$url) {
						 return new FetchedDataURL($this->content, array(), "");
    				} else {
      // remove the "file:///" protocol
      					if (substr($url,0,8)=='file:///') {
					 	 $url=substr($url,8);
        // remove the additional '/' that is currently inserted by utils_url.php
       				 	if (PHP_OS == "WINNT") $url=substr($url,1);
      					}
     			 return new FetchedDataURL(@file_get_contents($url), array(), "");
    			}
			 }

 		 function get_base_url() {
    			return 'file:///'.$this->base_path.'/dummy.html';
  			}
}

function convert_to_pdf($html, $path_to_pdf, $base_path='') {
		global $PDFWIDTH; 
		  $pipeline = PipelineFactory::create_default_pipeline('', // Attempt to auto-detect encoding
															   '');
		
		  // Override HTML source 
		  // @TODO: default http fetcher will return null on incorrect images 
		  // Bug submitted by 'imatronix' (tufat.com forum).
		  //	print 'DEST NAME = ' .  $html.'<br/>';
		  $pipeline->fetchers[] = new MyFetcherMemory($html, $base_path);
		
		  // Override destination to local file
		  $pipeline->destination = new MyDestinationFile($path_to_pdf);
		
		  $baseurl = '';
		  $media =& Media::predefined('A4');
		  $media->set_landscape(false);
		  $media->set_margins(array('left'   => 0,
									'right'  => 0,
									'top'    => 0,
									'bottom' => 0));
		  $media->set_pixels($PDFWIDTH); 
		
		  global $g_config;
		  $g_config = array( 
							'cssmedia'     => 'screen',
							'scalepoints'  => '1',
							'renderimages' => false,
							'renderlinks'  => false,
							'renderfields' => true,
							'renderforms'  => false,
							'pixels' => $PDFWIDTH,
							'mode'         => 'html',
							'output' => '1',
							'media' => 'A3',
							'scalepoint' => '1',
							'encoding'     => '',
							'method' => 'fpdf',
							'imagequality_workaround' => '1',
							'html2xhtml' => '1',
							'debugbox'     => false,
							'pdfversion'    => '1.4',
							'pslevel' => '3',
							'draw_page_border' => false
							);
		
		  $pipeline->configure($g_config);
		  $pipeline->process_batch(array($baseurl), $media);
}

convert_to_pdf(file_get_contents($htmlFile), $pdfFile);	
$originalimage = 'temp/'.$randName.'.jpg';
$convertString = "convert  -geometry 300x300 -density 300x300  -quality 100 $pdfFile $originalimage";
exec($convertString);

?>
<img src="<? echo $originalimage;?>">
		