<?php

	/**
	 * @author Oliver Lillie (aka buggedcom) <publicmail@buggedcom.co.uk>
	 * 
	 * @license BSD
	 * @copyright Copyright (c) 2007 Oliver Lillie <http://www.buggedcom.co.uk>
	 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation 
	 * files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, 
	 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software 
	 * is furnished to do so, subject to the following conditions:  The above copyright notice and this permission notice shall be 
	 * included in all copies or substantial portions of the Software.  
	 * 
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE 
	 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR 
	 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, 
	 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.  
	 * 
	 * @name ffmpeg
	 * @version 0.0.1
	 * @abstract This class can be used in conjunction with several server binary libraries to manipulate video and audio
	 * through PHP. It is not intended to solve any particular problems, however you may find it usefull. This php class
	 * is in no way associated with the actuall FFmpeg releases. Any mistakes contained in this php class are mine and mine
	 * alone.
	 * 
	 * Please Note: There are several prerequistes that are required before this class can be used as an aid to manipulate
	 * video and audio. You must at the very least have FFMPEG compiled on your server. If you wish to use this class for FLV
	 * manipulation you must compile FFMPEG with LAME and Ruby's FLVTOOL2. I cannot answer questions regarding the install of 
	 * the server binaries needed by this class. I had too learn the hard way and it isn't easy, however it is a good learning
	 * experience. For those of you who do need help read the install.txt file supplied along side this class. It wasn't written
	 * by me however I found it usefull when installing ffmpeg for the first time. The original source for the install.txt file
	 * is located http://www.luar.com.hk/blog/?p=669 and the author is Lunar.
	 * 
	 * @see install.txt
	 * 
	 * @uses ffmpeg http://ffmpeg.sourceforge.net/
	 * @uses lame http://lame.sourceforge.net/
	 * @uses flvtool2 http://www.inlet-media.de/flvtool2 (and ruby http://www.ruby-lang.org/en/)
	 * 
	 * @example ffmpeg.example1.php Converts video to Flash Video (ie FLV).
	 * @example ffmpeg.example2.php Screen grabs video frames.
	 * @example ffmpeg.example3.php Converts an image sequence into a video mpeg.
	 * 
	 * @todo Functions to add
	 * 			- exportSpecificFrames
	 * 				Will add funcitonality to export specific frames from one execute call.
	 * 			- exportFrameWithWatermark
	 * 			- exportFramesWithWatermark
	 * 			- exportSepcificFramesWithWatermark
	 * 				Will add funcitonality to export frames with a watermark.
	 * 			- extractAudio
	 * 				To extract audio from any video
	 * 			- combineVideo
	 * 				Will add the functionality to combine multiple videos into once source
	 * Also I have many more plans so there is much more to come. If anypody has any suggestions please feel free to email me.
	 */
	
	/**
	 * Set the ffmpeg binary path
	 */
	if(!defined('FFMPEG_BINARY'))
	{
		define('FFMPEG_BINARY', '/usr/local/bin/ffmpeg');
	}
	/**
	 * Set the flvtool2 binary path
	 */
	if(!defined('FFMPEG_FLVTOOLS_BINARY'))
	{
		define('FFMPEG_FLVTOOLS_BINARY', '/usr/bin/flvtool2');
	}
	
	/**
	 * Set the formats
	 * 
	 * 3g2             3gp2 format
	 * 3gp             3gp format
	 * aac             ADTS AAC
	 * aiff            Audio IFF
	 * amr             3gpp amr file format
	 * asf             asf format
	 * avi             avi format
	 * flv             flv format
	 * gif             GIF Animation
	 * mov             mov format
	 * mov,mp4,m4a,3gp,3g2,mj2 QuickTime/MPEG4/Motion JPEG 2000 format
	 * mp2             MPEG audio layer 2
	 * mp3             MPEG audio layer 3
	 * mp4             mp4 format
	 * mpeg            MPEG1 System format
	 * mpeg1video      MPEG video
	 * mpeg2video      MPEG2 video
	 * mpegvideo       MPEG video
	 * psp             psp mp4 format
	 * rm              rm format
	 * swf             Flash format
	 * vob             MPEG2 PS format (VOB)
	 * wav             wav format
	 */
	define('FFMPEG_FORMAT_3GP2', '3g2');
	define('FFMPEG_FORMAT_3GP', '3gp');
	define('FFMPEG_FORMAT_AAC', 'aac');
	define('FFMPEG_FORMAT_AIFF', 'aiff');
	define('FFMPEG_FORMAT_AMR', 'amr');
	define('FFMPEG_FORMAT_ASF', 'asf');
	define('FFMPEG_FORMAT_AVI', 'avi');
	define('FFMPEG_FORMAT_FLV', 'flv');
	define('FFMPEG_FORMAT_GIF', 'gif');
	define('FFMPEG_FORMAT_MJ2', 'mj2');
	define('FFMPEG_FORMAT_MP2', 'mp2');
	define('FFMPEG_FORMAT_MP3', 'mp3');
	define('FFMPEG_FORMAT_MP4', 'mp4');
	define('FFMPEG_FORMAT_M4A', 'm4a');
	define('FFMPEG_FORMAT_MPEG', 'mpeg');
	define('FFMPEG_FORMAT_MPEG1', 'mpeg1video');
	define('FFMPEG_FORMAT_MPEG2', 'mpeg2video');
	define('FFMPEG_FORMAT_MPEGVIDEO', 'mpegvideo');
	define('FFMPEG_FORMAT_PSP', 'psp');
	define('FFMPEG_FORMAT_RM', 'rm');
	define('FFMPEG_FORMAT_SWF', 'swf');
	define('FFMPEG_FORMAT_VOB', 'vob');
	define('FFMPEG_FORMAT_WAV', 'wav');
	
	class ffmpeg
	{
		private $version		= '0.0.5';
		
		/**
		 * Private var that detects if the $ffmpeg->setFormatToFLV function has been used as an additional exec call to flvtool2 is needed
		 * @var boolean
		 */
		private $flv_conversion		= FALSE;
		
		/**
		 * Determines what happens when an error occurs
		 * @var boolean If TRUE then the script will die, if not FALSE is return by the error
		 */
		public $on_error_die		= FALSE;
		
		/**
		 * Holds the current execute commands that will need to be combined
		 * @var array
		 */
		private $commands 			= array();

		/**
		 * Holds the commands executed
		 * @var array
		 */
		private $processed 			= array();
		
		/**
		 * Holds the file references to those that have been processed
		 * @var array
		 */
		private $files	 			= array();
		
		/**
		 * Holds the errors encountered
		 * @var array
		 */
		private $errors 			= array();
		
		/**
		 * Holds the input file / input file sequence
		 * @var string
		 */
		private $input_file 		= NULL;
		
		/**
		 * Holds the output file / output file sequence
		 * @var string
		 */
		private $output_address 	= NULL;
		
		/**
		 * Temporary filename prefix
		 * @var string
		 */
		private $tmp_file_prefix	= 'tmp_';
		
		/**
		 * Holds the temporary directory name
		 * @var string
		 */
		private $tmp_directory 		= NULL;
		
		/**
		 * Holds the directory paths that need to be removed by the ___destruct function
		 * @var array
		 */		
		private $unlink_dirs		= array();
		
		/**
		 * Holds the file paths that need to be deleted by the ___destruct function
		 * @var array
		 */
		private $unlink_files		= array();
		
		/**
		 * Constructs the class and sets the temporary directory.
		 *
		 * @param string $tmp_directory A full absolute path to you temporary directory
		 */
		function __construct($tmp_directory='/tmp/')
		{
			$this->tmp_directory = $tmp_directory;
		}
		
		/**
		 * Resets the class
		 *
		 * @param boolean $keep_input_file Determines whether or not to reset the input file currently set.
		 */
		public function reset($keep_input_file=FALSE)
		{
			if($keep_input_file === FALSE)
			{
				$this->input_file = NULL;
			}
			$this->flv_conversion = FALSE;
			$this->output_address = NULL;
			$this->commands = array();
			$this->__destruct();
		}
		
		/**
		 * Sets the input file that is going to be manipulated.
		 *
		 * @param string $file The absolute path of the file that is required to be manipulated.
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function setInputFile($file)
		{
//			check the input file, if there is a %d in there or a similar %03d then the file inputted is a sequence, if neither of those is found
//			then qheck to see if the file exists
			if(!preg_match('/\%([0-9]+)\d/', $file) && strpos($file, '%d') === FALSE && !is_file($file))
			{
//				input file not valid
				return $this->_raiseError('Input file "'.$file.'" does not exist');
//<-			exits				
			}
			$this->input_file = $file;
			return TRUE;
		}
		
		/**
		 * A shortcut for converting video to FLV.
		 *
		 * @param integer $audio_sample_frequency
		 * @param integer $audio_bitrate
		 */
		public function setFormatToFLV($audio_sample_frequency=44100, $audio_bitrate=64)
		{
			$this->addCommand('-sameq');
			$this->addCommand('-acodec', 'mp3');
//			adjust the audio rates
			$this->setAudioBitRate($audio_bitrate);
			$this->setAudioSampleFrequency($audio_sample_frequency);
//			set the video format
			$this->setFormat(FFMPEG_FORMAT_FLV);
//			flag that the flv has to have meta data added after the excecution of this command
			$this->flv_conversion = TRUE;
		}
		
		/**
		 * When converting video to FLV the meta data has to be added by a ruby program called FLVTools2.
		 * This is a second exec call only after the video has been converted to FLV
		 * http://inlet-media.de/flvtool2
		 */
		private function _addMetaToFLV()
		{
//			prepare the command suitable for exec
			$exec_string = $this->_prepareCommand(FFMPEG_FLVTOOLS_BINARY, '-U '.$this->output_address);
//			execute the command
			exec($exec_string);
			$this->processed[0] = array($this->processed[0], $exec_string);
		}
		
		/**
		 * Sets the new video format.
		 *
		 * @param defined $format The format should use one of the defined variables stated below.
		 * 		FFMPEG_FORMAT_3GP2 - 3g2
		 * 		FFMPEG_FORMAT_3GP - 3gp
		 * 		FFMPEG_FORMAT_AAC - aac
		 * 		FFMPEG_FORMAT_AIFF - aiff
		 * 		FFMPEG_FORMAT_AMR - amr
		 * 		FFMPEG_FORMAT_ASF - asf
		 * 		FFMPEG_FORMAT_AVI - avi
		 * 		FFMPEG_FORMAT_FLV - flv
		 * 		FFMPEG_FORMAT_GIF - gif
		 * 		FFMPEG_FORMAT_MJ2 - mj2
		 * 		FFMPEG_FORMAT_MP2 - mp2
		 * 		FFMPEG_FORMAT_MP3 - mp3
		 * 		FFMPEG_FORMAT_MP4 - mp4
		 * 		FFMPEG_FORMAT_M4A - m4a
		 * 		FFMPEG_FORMAT_MPEG - mpeg
		 * 		FFMPEG_FORMAT_MPEG1 - mpeg1video
		 * 		FFMPEG_FORMAT_MPEG2 - mpeg2video
		 * 		FFMPEG_FORMAT_MPEGVIDEO - mpegvideo
		 * 		FFMPEG_FORMAT_PSP - psp
		 * 		FFMPEG_FORMAT_RM - rm
		 * 		FFMPEG_FORMAT_SWF - swf
		 * 		FFMPEG_FORMAT_VOB - vob
		 * 		FFMPEG_FORMAT_WAV - wav
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function setFormat($format)
		{
//			validate input
			if(!in_array($format, array(FFMPEG_FORMAT_3GP2, FFMPEG_FORMAT_3GP, FFMPEG_FORMAT_AAC, FFMPEG_FORMAT_AIFF, FFMPEG_FORMAT_AMR, FFMPEG_FORMAT_ASF, FFMPEG_FORMAT_AVI, FFMPEG_FORMAT_FLV, FFMPEG_FORMAT_GIF, FFMPEG_FORMAT_MJ2, FFMPEG_FORMAT_MP2, FFMPEG_FORMAT_MP3, FFMPEG_FORMAT_MP4, FFMPEG_FORMAT_M4A, FFMPEG_FORMAT_MPEG, FFMPEG_FORMAT_MPEG1, FFMPEG_FORMAT_MPEG2, FFMPEG_FORMAT_MPEGVIDEO, FFMPEG_FORMAT_PSP, FFMPEG_FORMAT_RM, FFMPEG_FORMAT_SWF, FFMPEG_FORMAT_VOB, FFMPEG_FORMAT_WAV)))
			{
				return $this->_raiseError('Value "'.$format.'" set from $ffmpeg->setFormat, is not a valid format. Valid values are FFMPEG_FORMAT_3GP2, FFMPEG_FORMAT_3GP, FFMPEG_FORMAT_AAC, FFMPEG_FORMAT_AIFF, FFMPEG_FORMAT_AMR, FFMPEG_FORMAT_ASF, FFMPEG_FORMAT_AVI, FFMPEG_FORMAT_FLV, FFMPEG_FORMAT_GIF, FFMPEG_FORMAT_MJ2, FFMPEG_FORMAT_MP2, FFMPEG_FORMAT_MP3, FFMPEG_FORMAT_MP4, FFMPEG_FORMAT_M4A, FFMPEG_FORMAT_MPEG, FFMPEG_FORMAT_MPEG1, FFMPEG_FORMAT_MPEG2, FFMPEG_FORMAT_MPEGVIDEO, FFMPEG_FORMAT_PSP, FFMPEG_FORMAT_RM, FFMPEG_FORMAT_SWF, FFMPEG_FORMAT_VOB, FFMPEG_FORMAT_WAV. If you wish to specifically try to set another frequency you should use the advanced function $ffmpeg->addCommand. Set $command to "-f" and $argument to your required value.');
//<-			exits
			}
			return $this->addCommand('-f', $format);
		}
		
		/**
		 * Sets the audio sample frequency for audio outputs
		 *
		 * @param integer $audio_sample_frequency Valid values are 11025, 22050, 44100
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function setAudioSampleFrequency($audio_sample_frequency)
		{
//			validate input
			if(!in_array(intval($audio_sample_frequency), array(11025, 22050, 44100)))
			{
				return $this->_raiseError('Value "'.$audio_sample_frequency.'" set from $ffmpeg->setAudioSampleFrequency, is not a valid integer. Valid values are 11025, 22050, 44100. If you wish to specifically try to set another frequency you should use the advanced function $ffmpeg->addCommand. Set $command to "-ar" and $argument to your required value.');
//<-			exits
			}
			return $this->addCommand('-ar', $audio_sample_frequency);
		}
		
		/**
		 * Sets the audio bitrate
		 *
		 * @param integer $audio_bitrate Valid values are 16, 32, 64
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function setAudioBitRate($audio_bitrate)
		{
//			validate input
			if(!in_array(intval($audio_bitrate), array(16, 32, 64)))
			{
				return $this->_raiseError('Value "'.$audio_bitrate.'" set from $ffmpeg->setAudioBitRate, is not a valid integer. Valid values are 16, 32, 64. If you wish to specifically try to set another bitrate you should use the advanced function $ffmpeg->addCommand. Set $command to "-ab" and $argument to your required value.');
//<-			exits
			}
			return $this->addCommand('-ab', $audio_bitrate);
		}
		
		/**
		 * Compiles an array of images into a video. This sets the input file (setInputFile) so you do not need to set it.
		 * The images should be a full absolute path to the actuall image file.
		 * (Note; This copies and renames all the supplied images into a temporary folder so the images don't have to be specifically named. However, when
		 * creating the ffmpeg instance you will need to set the absolute path to the temporary folder. The default path is '/tmp/'.
		 *
		 * @param array $images An array of images that are to be joined and converted into a video
		 * @return boolean Returns FALSE on encountering an error
		 */
		public function prepareImagesForConversionToVideo($images)
		{
//			http://ffmpeg.mplayerhq.hu/faq.html#TOC3
//			ffmpeg -f image2 -i img%d.jpg /tmp/a.mpg
			if(empty($images))
			{
				return $this->_raiseError('When compiling a movie from a series of images, you must include at least one image.');
//<-			exits				
			}
//			loop through and validate existence first before making a temporary copy
			foreach ($images as $key=>$img) 
			{
				if(!is_file($img))
				{
					return $this->_raiseError('"'.$img.'" does not exist');
//<-				exits				
				}
			}
			if(!is_dir($this->tmp_directory))
			{
				return $this->_raiseError('The temporary directory does not exist.');
//<-			exits				
			}
			if(!is_writeable($this->tmp_directory))
			{
				return $this->_raiseError('The temporary directory is not writeable by the webserver.');
//<-			exits				
			}
//			get the number of preceding places for the files based on how many files there are to copy
			$total = count($images);
			$pad_num = 0;
			while(($total = ($total/10)) > 1)
			{
				$pad_num += 1;
			}
//			create a temp dir in the temp dir
			$uniqid = $this->unique();
			mkdir($this->tmp_directory.$uniqid, 0777);
//			loop through, copy and rename specified images to the temp dir
			foreach ($images as $key=>$img) 
			{
				$ext = array_pop(explode('.', $img));
				$tmp_file = $this->tmp_directory.$uniqid.DIRECTORY_SEPARATOR.$this->tmp_file_prefix.$key.'.jpg';
				if(!@copy($img, $tmp_file))
				{
					return $this->_raiseError('"'.$img.'" can not be copied to "'.$tmp_file.'"');
//<-				exits				
				}
//				push the tmp file name into the unlinks so they can be deleted on class destruction
				array_push($this->unlink_files, $tmp_file);
			}
//			add the directory to the unlinks
			array_push($this->unlink_dirs, $this->tmp_directory.$uniqid);
//			get the input file format
			$file_iteration = $this->tmp_file_prefix.'%d.jpg';
//			set the input filename
			return $this->setInputFile($this->tmp_directory.$uniqid.DIRECTORY_SEPARATOR.$file_iteration);
		}
		
		/**
		 * Sets the video otput dimensions (in pixels)
		 *
		 * @param integer $width
		 * @param integer $height
		 */
		public function setVideoOutputDimensions($width, $height)
		{
			$this->addCommand('-s', floatval($width).'x'.floatval($height));
		}
		
		/**
		 * Sets the video aspect ratio
		 * 
		 * @param string|integer $ratio Valid values are '4:3', '16:9' or 1.3333, 1.7777
		 */
		public function setVideoAspectRatio($ratio)
		{
			$this->addCommand('-aspect', $ratio);
		}
		
		/**
		 * Extracts frames from a video.
		 * (Note; If set to 1 and the duration set by $extract_begin_timecode and $extract_end_timecode is equal to 1 you get more than one frame.
		 * For example if you set $extract_begin_timecode='00:00:00' and $extract_end_timecode='00:00:01' you might expect because the timespan is
		 * 1 second only to get one frame if you set $frames_per_second=1. However this is not correct. The timecode you set in $extract_begin_timecode
		 * acts as the begining frame. Thus in this example the first frame exported will be from the very begining of the video, the video will 
		 * then move onto the next frame and export a frame there. Therefore if you wish to export just one frame from one position in the video, 
		 * say 1 second in you should set $extract_begin_timecode='00:00:01' and set $extract_end_timecode='00:00:01'.)
		 *
		 * @param string|integer $extract_begin_timecode A timecode (hh:mm:ss) or interger (in seconds) for where the extraction process is to start
		 * @param string|integer $extract_end_timecode A timecode (hh:mm:ss) or interger (in seconds) for where the extraction process is to end
		 * @param integer $frames_per_second The number of frames per second to extract. 
		 * @param boolean|integer $frame_limit Frame limiter. If set to FALSE then all the frames will be exported from the given timecodes, however
		 * 			if you wish to set a export limit to the number of frames that are exported you can set an integer. For example; if you set
		 * 			$extract_begin_timecode='00:00:11', $extract_end_timecode='00:01:10', $frames_per_second=1, you will get one frame for exvery second
		 * 			in the video between 00:00:11 and 00:01:10 (ie 60 frames), however if you ant to artifically limit this to exporting only ten frames
		 * 			then you set $frame_limit=10. You could of course alter the timecode to reflect you desired frame number, however there are situations
		 * 			when a shortcut such as this is usefull and neccesary.
		 */
		public function extractFrames($extract_begin_timecode='00:00:01', $extract_end_timecode='00:00:01', $frames_per_second=1, $frame_limit=FALSE)
		{
//			/usr/local/bin/ffmpeg -i /Users/ollie/Sites/ffmpeg/testmedia/mov02622.mpg -an -itsoffset 00:00:00 -ss 00:01:05 -s 320x240 -t 00:00:10 -r 1 -y /Users/ollie/Sites/ffmpeg/testmedia/frames/mov02622-%d.jpg
			$this->addCommand('-an');
			$this->addCommand('-ss', $extract_begin_timecode);
			$this->addCommand('-t', $extract_end_timecode);
			$this->addCommand('-r', $frames_per_second);
			if($frame_limit !== FALSE)
			{
				$this->addCommand('-vframes', $frame_limit);
			}
		}
		
		/**
		 * Extracts one frame
		 * @uses $ffmpeg->extractFrames
		 */
		public function extractFrame($extract_begin_timecode='00:00:00')
		{
			$this->extractFrames($extract_begin_timecode, $extract_begin_timecode, 1, 1);
		}
		
		/**
		 * Sets the output.
		 *
		 * @param string $output_directory The directory to output the command output to
		 * @param string $output_name The filename to output to.
		 * 			(Note; if you are outputing frames from a video then you will need to add an extra item to the output_name. The output name you set is required
		 * 			to contain '%d'. '%d' is replaced by the image number (Subnote; Frustratingly this is not the timecode position that the frame came from but
		 * 			the number of the extract. If anyone knows of way to extract the timecode please let me know). Thus entering setting output_name
		 * 			$output_name='img%d.jpg' will output  'img1.jpg', 'img2.jpg', etc... However 'img%03d.jpg' generates `img001.jpg', `img002.jpg', etc...)
		 * @param boolean $overwrite If you want ffmpeg to overrite any confilcting file set this to TRUE, otherwise if a confilcting file is found 
		 * 			ffmpeg will not produce the video.
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function setOutput($output_directory, $output_name, $overwrite=FALSE)
		{
//			check if directoy exists
			if(!is_dir($output_directory))
			{
				return $this->_raiseError('Output directory "'.$output_directory.'" does not exist!');
//<-			exits				
			}
//			check if directory is writeable
			if(!is_writable($output_directory))
			{
				return $this->_raiseError('Output directory "'.$output_directory.'" is not writable!');
//<-			exits				
			}
//			set the output address
			$this->output_address = $output_directory.$output_name;
//			add the overwrite command if desired
			if($overwrite === TRUE)
			{
				$this->addCommand('-y');
			}
			return TRUE;
		}
		
		/**
		 * Commits all the commands and excecutes the ffmpeg procedure. This will also attempt to validate any outputted files in order to provide
		 * some level of stop and check system.
		 *
		 * @return boolean FALSE on error encountered, TRUE otherwise
		 */
		public function execute()
		{
// 			check for inut and output params
			if($this->input_file === NULL && !preg_match('/\%([0-9]+)\d/', $this->output_address) && strpos($file, '%d') === FALSE)
			{
				return $this->_raiseError('Execute error. Input file missing.');
//<-			exits				
			}
//			check to see if the output address has been set
			if($this->output_address === NULL)
			{
				return $this->_raiseError('Execute error. Output not set.');
//<-			exits				
			}
			
//			add the input file command to the mix
			$this->addCommand('-i', $this->input_file);
			
//			combine all the output commands
			$command_string = $this->_combineCommands();
			
//			prepare the command suitable for exec
//			the input and overwrite commands have specific places to be set so they have to be added outside of the combineCommands function
			$exec_string = $this->_prepareCommand(FFMPEG_BINARY, '-i '.$this->commands['-i'].' '.$command_string, (isset($this->commands['-y']) ? '-y' : '').$this->output_address);
			
//			execute the command
      exec($exec_string, $command_output);
      
//			track the processed command by adding it to the class
			array_unshift($this->processed, $exec_string);
			
//			special exception for adding the meta data to the flv via flvtools after the flv has been created by ffmpeg
			if($this->flv_conversion)
			{
				$this->flv_conversion = FALSE;
				$this->_addMetaToFLV();
			}
		
//			must validate a series of outputed items
//			detect if the output address is a sequence output
			if(preg_match('/\%([0-9]+)\d/', $this->output_address) || strpos($this->output_address, '%d') !== FALSE)
			{
//				get the path details
				$file 	= basename($this->output_address);
				$dir 	= dirname($this->output_address);
				
//				seperate out the filename and padding parts of the sequence
				$parts 		= explode('%', $file);
				$prefix		= $parts[0];
				$endparts	= explode('d', $parts[1]);
				$padding	= substr($endparts[0], 0, 1);
				$length		= substr($endparts[0], 1);
				$ending 	= $endparts[1];
				
//				init the iteration values
				$num 		= 1;
				$files 		= array();
				$error		= FALSE;
				$filename 	= $dir.DIRECTORY_SEPARATOR.$prefix.str_pad($num, $length, $padding, STR_PAD_LEFT).$ending;
				
//				loop and iterate checking for files
				while(@file_exists($filename))
				{
				  $size = filesize($filename);
				  
				  $files[$filename] = $size > 0 ? basename($filename) : FALSE;
					if($size == 0)
					{
						$error = TRUE;
					}
					$filename = $dir.DIRECTORY_SEPARATOR.$prefix.str_pad($num, $length, $padding, STR_PAD_LEFT).$ending;
					$num += 1;
				}
				
//				if the file was detected but were empty then display a different error
				if($error === TRUE)
				{
					return $this->_raiseError('Execute error. Output for file "'.$this->input_file.'" encountered a partial error. Files were generated, however one or more of them were empty.');
//<-				exits				
				}
				
//				no files were generated in this sequence
				if($num - 1 == 0)
				{
					return $this->_raiseError('Execute error. Output for file "'.$this->input_file.'" was not found. No files were generated.');
//<-				exits				
				}
				
//				add the files the the class a record of what has been generated
				array_unshift($this->files, $files);
				
				return $num-1;
			}
//			must validate one file
			else 
			{
//				check that it is a file
				if(!is_file($this->output_address))
				{
					return $this->_raiseError('Execute error. Output for file "'.$this->input_file.'" was not found. Please check server write permissions and/or available codecs compiled with FFmpeg.');
//<-				exits				
				}
//				the file does exist but is it empty?
				if(filesize($this->output_address) == 0)
				{
					return $this->_raiseError('Execute error. Output for file "'.$this->input_file.'" was found, but the file contained no data. Please check the available codecs compiled with FFmpeg can support this type of conversion.');
//<-				exits				
				}
//				add the file the the class a record of what has been generated
				array_unshift($this->files, array($this->output_address));
				return TRUE;
			}
			
			return NULL;
			
		}
		
		/**
		 * Returns the last outputted file that was processed by ffmpeg from this class.
		 *
		 * @return mixed array|string Will return an array if the output was a sequence, or string if it was a single file output
		 */
		public function getLastOutput()
		{
			return $this->files[0];
		}
		
		/**
		 * Returns all the outputted files that were processed by ffmpeg from this class.
		 *
		 * @return array
		 */
		public function getOutput()
		{
			return $this->files;
		}
		
		/**
		 * Returns the last encountered error message.
		 *
		 * @return string
		 */
		public function getLastError()
		{	
			return $this->errors[0];
		}
		
		/**
		 * Returns all the encountered errors as an array of strings
		 *
		 * @return array
		 */
		public function getErrors()
		{
			return $this->errors;
		}
		
		/**
		 * Returns the last command that ffmpeg was given.
		 * (Note; if setFormatToFLV was used in the last command then an array is returned as a command was also sent to FLVTool2)
		 *
		 * @return mixed array|string
		 */
		public function getLastCommand()
		{
			return $this->processed[0];
		}
		
		/**
		 * Returns all the commands sent to ffmpeg from this class
		 *
		 * @return unknown
		 */
		public function getCommands()
		{
			return $this->processed;
		}
		
		/**
		 * Raises an error
		 *
		 * @param string $message
		 * @return boolean Only returns FALSE if $ffmpeg->on_error_die is set to FALSE
		 */
		private function _raiseError($message)
		{
			$msg = 'CLASS FFMPEG ERROR: '.$message;
//			check what the error is supposed to do
			if($this->on_error_die === TRUE)
			{
				die($msg);
//<-			exits				
			}
//			add the error message to the collection
			array_unshift($this->errors, $msg);
			return FALSE;
		}
		
		/**
		 * Adds a command to be bundled into the ffmpeg command call. 
		 * (SPECIAL NOTE; None of the arguments are checked or sanitised by this function. BE CAREFULL if manually using this. The commands and arguments are escapped
		 * however it is still best to check and santise any params given to this function)
		 *
		 * @param string $command
		 * @param mixed $argument
		 * @return boolean
		 */
		public function addCommand($command, $argument='')
		{
			$this->commands[$command] = escapeshellarg($argument);
			return TRUE;
		}
		
		/**
		 * Combines the commands stored into a string
		 *
		 * @return string
		 */
		private function _combineCommands()
		{
			$command_string = '';
			foreach ($this->commands as $command=>$argument) 
			{
//				check for specific none combinable commands as they have specific places they have to go in the string
				switch($command)
				{
					case '-i' :
					case '-y' :
						break;
					default : 
						$command_string .= trim($command.' '.$argument).' ';
				}
			}
			return trim($command_string);
		}
		
		/**
		 * Prepares the command for excecution
		 *
		 * @param string $path Path to the binary
		 * @param string $command Command string to excecute
		 * @param string $args Any additional arguments
		 * @return string
		 */
		private function _prepareCommand($path, $command, $args='')
		{
	        if (!OS_WINDOWS || !preg_match('/\s/', $path)) 
	        {
	            return $path.' '.$command.' ' .$args;
	        }
	        return 'start /D "'.$path.'" /B '.$command.' '.$args;
		}
		
		/**
		 * Generates a unique id. Primarily used in jpeg to movie production
		 *
		 * @param string $prefix
		 * @return string
		 */
		public function unique($prefix='')
		{
			return uniqid($prefix.time().'-'.rand(1, 100).'-');
		}
		
		/**
		 * Destructs ffmpeg and removes any temp files/dirs
		 */
		function __destruct()
		{
//			loop through the temp files to remove first as they have to be removed before the dir can be removed
			if(!empty($this->unlink_files))
			{
				foreach ($this->unlink_files as $key=>$file) 
				{
					@unlink($file);
				}
				$this->unlink_files = array();
			}
//			loop through the dirs to remove
			if(!empty($this->unlink_dirs))
			{
				foreach ($this->unlink_dirs as $key=>$dir) 
				{
					@rmdir($dir);
				}
				$this->unlink_dirs = array();
			}
		}
	}

?>
