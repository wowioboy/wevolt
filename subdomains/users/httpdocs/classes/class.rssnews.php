<?php
/**
 * class.rssnews.php
 * The RSS Feeds retrieving class
 * 
 * created by Nitesh Apte
 * License: GNU Public License 
 */

class  rssnews
{	
	private $rss;
	private $items;
	private $item;
	private $title;
	private $link;
	public $RSSFEED;
	/**
	 * __construct
	 * This function retrieve the xml feed and displays it.
	 *
	 */
	function __construct($url,$link)
	{
		//print 'URL = '. $url.'<br/>';
	//	print 'LINK = ' . $link.'<br/>';
		if($url=="google")	
		$this->url = "http://news.google.co.in/nwshp?hl=en&tab=wn&output=rss";
		if($url=="bbc")	
		$this->url = "http://newsrss.bbc.co.uk/rss/newsonline_world_edition/asia-pacific/rss.xml";
		if($url=="reuters")	
		$this->url = "http://feeds.reuters.com/reuters/worldNews";
		if($url=="rediff")	
		$this->url = "http://www.rediff.com/rss/inrss.xml";
		if($url=="toi")	
		$this->url = "http://timesofindia.indiatimes.com/rssfeedsdefault.cms";
		if($url=="hindu")	
		$this->url = "http://www.hindu.com/rss/01hdline.xml";
		if($url=="pk")
		$this->url ="http://www.prabhatkhabar.com/rssfeedback.aspx?pageno=2";
		if($url=="cbr_reviews")
		$this->url = "http://www.comicbookresources.com/feed.php?feed=reviews";
		if($url=="cbr_news")	
		$this->url = "http://www.comicbookresources.com/feed.php?feed=news";
		if($url=="cbr_pr")	
		$this->url = "http://www.comicbookresources.com/feed.php?feed=pr";
		if($url=="cbr_previews")	
		$this->url = "http://www.comicbookresources.com/feed.php?feed=previews";
		if($url=="brokenfrontier")	
		$this->url = "http://www.brokenfrontier.com/headlines/p/rss";
		if($url=="custom")	
		$this->url = $link;
		
	//	http://www.comicbookresources.com/feed.php?feed=reviews
	//	print 'LINK = ' . $this->url;
		$this->rss = simplexml_load_file($this->url);
		if($this->rss)
		{	
			$this->items = $this->rss->channel->item;
			foreach($this->items as $this->item)
			{
				$this->title = $this->item->title;
				$this->description = $this->item->description;
				$this->link = $this->item->link;
				$this->RSSFEED .= '<div class="messageinfo">';
				$this->RSSFEED .= '<a href="'.$this->link.'" target="_blank"><b>'.$this->title.'</b></a><br/>';
				$this->description = preg_replace("/<img[^>]+\>/i", "", $this->description);
				$this->description = preg_replace("/<a[^>]+\>/i", "", $this->description);
				$this->description = preg_replace("/<object[^>]+\>/i", "", $this->description);
				$this->description = preg_replace("/<script[^>]+\>/i", "", $this->description);
				$this->description = preg_replace("/<embed[^>]+\>/i", "", $this->description);
				$this->description = preg_replace("/<param[^>]+\>/i", "", $this->description);
				$this->description = str_replace("so.addParam('allowfullscreen','true');", "", $this->description);
				$this->description = str_replace("so.addParam('allowscriptaccess','always');", "", $this->description);
				$this->description = str_replace("so.addParam('wmode','opaque');", "", $this->description);
				$this->description = str_replace("<!--", "", $this->description);
				$this->description = str_replace("-->", "", $this->description);
				$this->description = str_replace("var so = new SWFObject('http://cdn.pitchfork.com/streaming-player/player.swf','mpl','452','24','9');", "", $this->description);
				
				
				$this->RSSFEED .= $this->truncStringLink($this->description,200,' ','[read more]',$this->link); 
				$this->RSSFEED .= '<div style="height:5px;"></div></div>';
			}
		}
		else
		$this->RSSFEED .= "Unable to parse XML";
		
	}
	

	
	public function showFeed()
	{
   	 return $this->RSSFEED;

	}
	private function truncStringLink($string, $limit, $break=" ", $pad="(view)",$Link) { 
// return with no change if string is shorter than $limit  
		if(strlen($string) <= $limit) 

			return $string; 

		$string = substr($string, 0, $limit); 
		if(false !== ($breakpoint = strrpos($string, $break))) { 

		$string = substr($string, 0, $breakpoint);  

		} 
		return $string . '...<a href="'.$Link.'">'.$pad.'</a>'; 

		}    
	
		public function __toString()
	{
   	 return $this->RSSFEED;

	} 
}

?>