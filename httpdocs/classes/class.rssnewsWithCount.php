<?php
/**
 * class.googlerssWithCount.php
 * The RSS Feeds retrieving class. Only top 10 news will be retrieved.
 * 
 * created by Nitesh Apte
 * License: GNU Public License 
 */
class  googlerss
{	
	private $rss;
	private $items;
	private $item;
	private $count;
	private $title;
	private $link;
	
	/**
	 * __construct
	 * This function retrieve the xml feed and displays it.
	 *
	 */
	function __construct($url)
	{
		$this->url = "http://news.google.co.in/nwshp?hl=en&tab=wn&output=rss";
		$this->rss = simplexml_load_file($this->url);
		if($this->rss)
		{	
			$this->items = $this->rss->channel->item;
			$this->count = 0;
			foreach($this->items as $this->item)
			{
				$this->title = $this->item->title;
				$this->link = $this->item->link;
				echo '<a href="'.$this->link.'" target="_blank">'.$this->title.'</a><br/>';
				$this->count++;
				if($this->count==10)
				{
					break;
				}
			}
		}
	}
}
?>