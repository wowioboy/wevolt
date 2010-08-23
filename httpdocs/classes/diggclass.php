<?php

//***********************************************************************************************************************
//* Library Description: Digg API Wrapper Library Version 1.0   - Released August 4th, 2007 
//*
//* Questions/comments?
//* http://www.jaslabs.com
//* Justin Silverton
//* justin@jaslabs.com
//*
//* requirements:
//* 	php curl extension and PHP4
//*
//***********************************************************************************************************************

/*
Error codes and meanings
# 403: Forbidden
# 404: Not found
# 500: Internal error
# 1001: Unrecognized argument
# 1002: A Digg API request is missing the callback argument.
# 1003: A Digg API request has an invalid callback argument.
# 1005: Application key required
# 1006: Argument less than minimum value
# 1007: Argument greater than maximum value
# 1008: No such story
# 1009: Date/time range may not be more than 60 minutes
# 1010: That user has not commented on that story.
# 1011: No such comment for that story
# 1012: The story endpoint requires a title or numeric ID
# 1013: At most 100 stories may be requested by ID
# 1014: Unknown container or topic
# 1015: Invalid domain argument
# 1016: Invalid link argument
# 1017: Unrecognized sort argument
# 1018: Submit and promote date/time ranges may not be used together
# 1019: Promote date range may not specified for upcoming stories
# 1020: Date/time range may not be more than 30 days
# 1021: No such user
# 1022: That user is not a friend of that user
# 1023: That user is not befriended by that user
# 1024: Unrecognized period argument
# 1025: Unrecognized error code
# 1026: Invalid integer argument
# 1027: At most 100 users' diggs or comments may be requested by username
# 1028: Invalid application key
# 1029: HTTP User-Agent header required
# 1030: Invalid argument value
# 1031: Date ranges may not be specified for hot stories
# 1032: Date ranges may not be specified for top stories
# 1033: The sort argument may not specified for top stories
# 1034: The sort argument may not specified for top stories
*/

//template classes for the response
class DiggAPIDigg {}
class DiggAPIEvents {}
class DiggAPIStories{}
class DiggAPIComment{}
class DiggAPITopics{}
class DiggAPITopic{}
class DiggAPIContainer{}
class DiggAPIUsers{}
class DiggAPIUser{}
class DiggAPIStory{}

$apiclass = new DiggAPIDigg ();
$storyclass = new DiggAPIStories();
$commentclass = new DiggAPIComment();
$topicsclass = new DiggAPITopics();
$topicclass = new DiggAPITopic();
$containerclass = new DiggAPIContainer();
$userclass = new DiggAPIUser();
$storyclass = new DiggAPIStory();
//end template classes

define("TYPE_FAN","0");
define("TYPE_FRIEND","1");

define("TYPE_UPCOMING","2");
define("TYPE_POPULAR","3");

class diggclass {

	
var $timestamp;				//timestamp of digg query
var $totalCount;			//total number of results available
var $errorCode; 			//errorcode returned from the digg servers

//general function for connecting to the digg servers through CURL
function connect($hostname) {
	//this is an ID that is unique to your app.  It is auto-generated, based on the calling URL
	$appid = urlencode("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	
	$host = $hostname."&appkey=".$appid;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_URL,$host);
	curl_setopt ($ch,CURLOPT_USERAGENT,"www.jaslabs.com: simple digg library 1.0");
	curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT,60);
	$response = curl_exec ( $ch );
	curl_close($ch);
	
	return $response;
}

//***********************************************************************************************************************
//* Function description: gets global story diggs 
//* Parameters: $type 	  - story type (no type = all, "upcoming", or "popular'
//*				$count	  -	number of results to return (default 10)
//*				$offset	  - offset from within the results to start
//* Returns:	date	  - date and time story was dugg (separated by space)
//*				story	  - story number
//*				id		  - story ID
//*				user	  -username of story
//*				status	  -status of story (upcoming,popular)
//*
//*				either an array will be returned with all items or false will be returned, which means the query has failed.
//*				if false is returned, the error code will be added to the $errorCode variable of the class.
//***********************************************************************************************************************

function getDiggs($type=null,$count=10,$offset=0,$mindate=null,$maxdate=null,$storyid=null) {
	return $this->getUserDiggs($type,$count,$offset,$mindate,$maxdate,$storyid);
}

//***********************************************************************************************************************
//* Function description: gets diggs based on user
//* Parameters: $username - digg username
//*				$count	  -	number of results to return (default 10)
//*				$offset	  - offset from within the results to start
//* Returns:	date	  - date and time story was dugg (separated by space)
//*				story	  - story number
//*				id		  - story ID
//*				user	  -username of story
//*				status	  -status of story (upcoming,popular)
//*
//*				either an array will be returned with all items or false will be returned, which means the query has failed.
//*				if false is returned, the error code will be added to the $errorCode variable of the class.
//***********************************************************************************************************************

function getUserDiggs($username="",$count=10,$offset=0,$mindate=null,$maxdate=null,$storyid=null) {
	
	if ($mindate)
	{
		$mindate = strtotime($mindate);
		$minquery = "&min_date=".$mindate;
	}
	
	if ($maxdate)
	{
		$maxdate = strtotime($maxdate);
		$maxquery = "&max_date=".$maxdate;
	}
	
	switch ($username)
	{
		case "upcoming":
			$userloc = "stories/upcoming";
		break;
		case "popular":
			$userloc = "stories/popular";
		break;
		case "":
			if ($storyid)
			{
				if(!strstr($storyid,','))
					$userloc = "story/".$storyid;
				else
					$userloc = "stories/".$storyid;
			} else
					$userloc = "stories";
		break;
		default:
			if ($storyid)
			{
				$userloc = "story/".$storyid."/user/".$username;
			} else {
			
					//check to see if we are looking up multiple users and connect to the respective URL
					if (!strstr($username,','))
						$userloc = "user"."/".$username;
					else
						$userloc = "users"."/".$username;
					//end check
			}
		break;
	}
		
	$response = $this->connect("http://services.digg.com/".$userloc."/diggs?type=php&offset=".$offset."&count=".$count.$minquery.$maxquery);
				
	$objects = unserialize($response);
	$results = array();
	
	foreach($objects as $var => $value) {
        if (is_array($value))
        {
	
	        for ($x=0;$x<count($value);$x++)
	        {
		        $apiclass = $value[$x];  
	    		$results[] = array("date"=>strftime("%b %d %Y %H:%M:%S",$apiclass->date),"story"=>$apiclass->story,"id"=>$apiclass->id,"user"=>$apiclass->user,"status"=>$apiclass->status);
	    	}  
		} else {				
				switch($var)
				{
					case "timestamp":
						$this->timestamp = $value;
					break;
					case "total":
						$this->totalCount = $value;
					break;
					case "code":
						$this->errorCode = $value;
						return false;
					break;
				}
		}
    }
    
   return $results;
}


//***********************************************************************************************************************
//* Function description: gets digg story comments 
//* Parameters: $type 	  - story type (no type = all, "upcoming", or "popular'
//*				$count	  -	number of results to return (default 10)
//*				$offset	  - offset from within the results to start
//* Returns:	date	  - date and time story was dugg (separated by space)
//*				story	  - story number
//*				id		  - story ID
//*				user	  - username of story
//*				status	  - status of story (upcoming,popular)
//*				up		  - positive comment diggs
//*				down	  - negative comments diggs
//*				replies	  - number of replies
//*				replyto	  - reply id
//*				content	  - actual comment
//*				either an array will be returned with all items or false will be returned, which means the query has failed.
//*				if false is returned, the error code will be added to the $errorCode variable of the class.
//***********************************************************************************************************************

function getComments($type=null,$count=10,$offset=0,$mindate=null,$maxdate=null,$storyid=null,$commentid=null) {
	return $this->getUserComments($type,$count,$offset,$mindate,$maxdate,$storyid,$commentid);
}

//***********************************************************************************************************************
//* Function description: gets digg story comments by a user
//* Parameters: $username - digg username
//*				$count	  -	number of results to return (default 10)
//*				$offset	  - offset from within the results to start
//* Returns:	date	  - date and time story was dugg (separated by space)
//*				story	  - story number
//*				id		  - story ID
//*				user	  - username of story
//*				status	  - status of story (upcoming,popular)
//*				up		  - positive comment diggs
//*				down	  - negative comments diggs
//*				replies	  - number of replies
//*				replyto	  - reply id
//*				content	  - actual comment
//*				either an array will be returned with all items or false will be returned, which means the query has failed.
//*				if false is returned, the error code will be added to the $errorCode variable of the class.
//***********************************************************************************************************************

function getUserComments($username="",$count=10,$offset=0,$mindate=null,$maxdate=null,$storyid=null,$commentid=null) {

	if ($mindate)
	{
		$mindate = strtotime($mindate);
		$minquery = "&min_date=".$mindate;
	}
	
	if ($maxdate)
	{
		$maxdate = strtotime($maxdate);
		$maxquery = "&max_date=".$maxdate;
	}
	
	switch ($username)
	{
		case "upcoming":
			$userloc = "stories/upcoming";
		break;
		case "popular":
			$userloc = "stories/popular";
		break;
		case "":
			if ($storyid)
			{
				if(!strstr($storyid,',')) {
					if ($commentid)
						$userloc = "story/".$storyid."/comment/".$commentid;
					else
						$userloc = "story/".$storyid."/comments";
				} else
					$userloc = "stories/".$storyid."/comments";
			} else
					$userloc = "stories/comments";
		break;
		default:
			if ($storyid)
			{
				$userloc = "story/".$storyid."/user/".$username."/comments";
			} else {
			
					//check to see if we are looking up multiple users and connect to the respective URL
					if (!strstr($username,','))
						$userloc = "user"."/".$username."/comments";
					else
						$userloc = "users"."/".$username."/comments";
					//end check
			}
		break;
	}
		
	$response = $this->connect("http://services.digg.com/".$userloc."?type=php&offset=".$offset."&count=".$count.$minquery.$maxquery);
				
	$objects = unserialize($response);
	$results = array();
	
	foreach($objects as $var => $value) {
        if (is_array($value))
        {
	
	        for ($x=0;$x<count($value);$x++)
	        {
		        $apiclass = $value[$x];  
	    		$results[] = array("date"=>strftime("%b %d %Y %H:%M:%S",$apiclass->date),"story"=>$apiclass->story,"id"=>$apiclass->id,"user"=>$apiclass->user,"up"=>$apiclass->up,"down"=>$apiclass->down,"replies"=>$apiclass->replies,"replyto"=>$apiclass->replyto,"content"=>$apiclass->content);
	    	}  
		} else {				
				switch($var)
				{
					case "timestamp":
						$this->timestamp = $value;
					break;
					case "total":
						$this->totalCount = $value;
					break;
					case "code":
						$this->errorCode = $value;
						return false;
					break;
				}
		}
    }

return $results;
}


//***********************************************************************************************************************
//* Function description: gets a digg topic
//* Parameters: $shortName: The digg topic short name
//* Returns: name: 		  			topic name
//*		     short_name:            topic short name
//*			 container_name:        topic container name
//*			 container_short_name:	topic container short name
//***********************************************************************************************************************

function getTopics($shortName="")
{
	if ($shortName != "")
		$shortURL = "topic/".$shortName;
	else
		$shortURL = "topics";
			
	$response = $this->connect("http://services.digg.com/".$shortURL."?type=php");
				
	$objects = unserialize($response);
	$results = array();

	foreach($objects as $var => $value) 
	{	
		if (is_array($value))
        {
	        
	        for ($x=0;$x<count($value);$x++)
	        {
		        
		        $topicclass = $value[$x];
		       	$results[] = array("name"=>$topicclass->name,"short_name"=>$topicclass->short_name,"container_name"=>$topicclass->container->name,"container_short_name"=>$topicclass->container->short_name);
	    	}  
		} else {
		
			switch($var)
			{
				case "timestamp":
					$this->timestamp = $value;
				break;
				case "total":
					$this->totalCount = $value;
				break;
				case "code":
					$this->errorCode = $value;
					return false;
				break;
			}
			
		}
	
	}
	
return $results;	
}

//***********************************************************************************************************************
//* Function description: gets information about a user (friends,fans,etc)
//* Parameters: $username: digg username
//*				$count	 		 -	number of results to return (default 10)
//*				$offset	  		 - offset from within the results to start
//*				$type	  		 - TYPE_FAN or TYPE_FRIEND
//*				$friendname 	 - friend name or fan name
//*	Returns:	name			 - name of digg user
//*				icon			 - url to digg user icon
//*				registered		 - time and date user registered
//*				profileviews	 - number of profile views for user
//***********************************************************************************************************************

function getUsers($username="",$count=10,$offset=0,$type=null,$friendname="")
{

if ($username == "")
	$userloc = "users";
else 
{
	switch($type)
	{
		case TYPE_FRIEND:
			if ($friendname == "")
				$userloc = "user/".$username."/friends";
			else
				$userloc = "user/".$username."/friend/".$friendname;
		break;
		case TYPE_FAN:
			if ($friendname == "")
				$userloc = "user/".$username."/fans";
			else
				$userloc = "user/".$username."/fan/".$friendname;
		break;
		default:
			$userloc = "user/".$username;
	}
}	
$response = $this->connect("http://services.digg.com/".$userloc."?type=php&count=".$count."&offset=".$offset);
				
$objects = unserialize($response);
$results = array();

foreach($objects as $var => $value) 
	{	
		if (is_array($value))
        {
	        
	        for ($x=0;$x<count($value);$x++)
	        {
		        
		        $userclass = $value[$x];
		       	$results[] = array("name"=>$userclass->name,"icon"=>$userclass->icon,"registered"=>strftime("%b %d %Y %H:%M:%S",$userclass->registered),"profileviews"=>$userclass->profileviews);
	    	}  
		} else {
		
			switch($var)
			{
				case "timestamp":
					$this->timestamp = $value;
				break;
				case "total":
					$this->totalCount = $value;
				break;
				case "code":
					$this->errorCode = $value;
					return false;
				break;
			}
			
		}
	
	}
	
return $results;
}

//***********************************************************************************************************************
//* Function description: gets information about digg stories
//* Parameters: $type: (TYPE_UPCOMING or TYPE_POPULAR)
//*				$storyid: digg storyid
//*				$contianer: digg container for story
//*				$topic: story topic
//*				$title: story clean title (with _ for space, etc)
//*				$username: digg username
//*				$count:	total count of returned results
//*				$offset: offset of returned results
//*				$min_submit_date: minimum submission date
//*				$max_submit_date: maximum submission date
//*				$min_promote_date: minimum promotion date
//*				$max_promote_date: maximum promotion date
//*
//*	Returns:	id: id of story
//*				link: link of story (on original site)
//*				submit_date: story submission date/time
//*				diggs: number of diggs on story
//*				comments: number of comments on story
//*				digg_link: link of story (on digg)
//*				status: status (upcoming,popular,etc)
//*				title: story title
//*				description: story description
//*				user_name: username of person that submitted story
//*				user_icon: user icon link if person that submitted story
//*				user_registered: registration date of user that submitted article
//*				user_profileviews: number if profile views of user that submitted story
//*				topic_name: story topic name
//*				topic_short_name: story topic short name (URL converted)
//*				container_name: story container name
//*				container_short_name: story container short name
//***********************************************************************************************************************

function getStories($type="",$storyid="",$container="",$topic="",$title="",$username="",$count=10,$offset=0,$min_submit_date=null,$max_submit_date=null,$min_promote_date=null,$max_promote_date=null)
{
if ($min_submit_date)
{
		$min_submit_date = strtotime($min_submit_date);
		$min_submit_date_query = "&min_submit_date=".$min_submit_date;
}
	
if ($max_submit_date)
{
		$max_submit_date = strtotime($max_submit_date);
		$max_submit_date_query = "&max_date=".$max_submit_date;
}

if ($min_promote_date)
{
		$min_promote_date = strtotime($min_promote_date);
		$min_promote_date_query = "&min_promote_date=".$min_promote_date;
}

if ($max_promote_date)
{
		$max_promote_date = strtotime($max_promote_date);
		$max_promote_date_query = "&max_promote_date=".$max_promote_date;
}
	
if ($storyid== "")
{
	$storyloc = "stories";
	
	if ($container != "")
		$storyloc .= "/container/".$container;
	
	if ($topic != "")
		$storyloc .= "/topic/".$topic;
	
	if ($title != "")
		$storyloc = "story/".$title;
	
	if ($username != "")
		$storyloc = "user/".$username."/submissions";
		
	switch($type)
	{
		case TYPE_UPCOMING:
			$storyloc .= "/upcoming";
		break;
		
		case TYPE_POPULAR:
			$storyloc .= "/popular";
		break;
	}
} else {
	if(!strstr($storyid,','))
		$storyloc = "story/".$storyid;
	else {
		$storyloc = "stories/".$storyid;
	}
}

$response = $this->connect("http://services.digg.com/".$storyloc."?type=php&count=".$count."&offset=".$offset.$min_submit_date_query.$max_submit_date_query.$min_promote_date_query.$max_promote_date_query);
				
$objects = unserialize($response);
$results = array();

foreach($objects as $var => $value) 
	{	
		if (is_array($value))
        {
	        
	        for ($x=0;$x<count($value);$x++)
	        {
		        
		        $storyclass = $value[$x];   
		        
		        $results[] = array("id"=>$storyclass->id,"link"=>$storyclass->link,"submit_date"=>strftime("%b %d %Y %H:%M:%S",$storyclass->submit_date),"diggs"=>$storyclass->diggs,"comments"=>$storyclass->comments,
		        			"digg_link"=>$storyclass->href,"status"=>$storyclass->status,"title"=>$storyclass->title,"description"=>$storyclass->description,
		        			"user_name"=>$storyclass->user->name,"user_icon"=>$storyclass->user->icon,"user_registered"=>strftime("%b %d %Y %H:%M:%S",$storyclass->user->registered),"user_profileviews"=>$storyclass->user->profileviews,
		        			"topic_name"=>$storyclass->topic->name,"topic_short_name"=>$storyclass->topic->short_name,"container_name"=>$storyclass->container->name,"container_short_name"=>$storyclass->container->short_name,"thumb"=>$storyclass->thumbnail);
	    	}  
		} else {
		
			switch($var)
			{
				case "timestamp":
					$this->timestamp = $value;
				break;
				case "total":
					$this->totalCount = $value;
				break;
				case "code":
					$this->errorCode = $value;
					return false;
				break;
			}
			
		}
	
	}
return $results;
}
}
?>