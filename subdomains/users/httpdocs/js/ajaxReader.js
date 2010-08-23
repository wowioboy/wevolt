/**
* Create a boolean variable to check for a valid Internet Explorer instance.
*/
var xmlhttp = false;

/**
* Check if we are using IE.
*/
try 
{
  	/**
  	* If the Javascript version is greater than 5.
  	*/
  	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  	
} 
catch (e) 
{
 	/**
 	* If not, then use the older active x object.
 	*/
  	try 
  	{
    		/**
    		* If we are using Internet Explorer.
    		*/
    		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  
  	} 
  	catch (E) 
  	{
    		/**
    		* Else we must be using a non-IE browser.
    		*/
    		xmlhttp = false;
  	}
}
/**
* If we are using a non-IE browser, create a javascript instance of the object.
*/
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
{
  	xmlhttp = new XMLHttpRequest();  	
}

function makeRequest(cat, objID, rsslink) 
{
	
	var serverPage = "/connectors/getRemoteRss.php";
  	var obj = document.getElementById(objID);
  	serverPage=serverPage+"?q="+cat;
	if (rsslink != '')
		serverPage = serverPage+'&link='+escape(rsslink);
	
  	xmlhttp.open("GET", serverPage);
  	xmlhttp.onreadystatechange = function() 
  	{
    		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    		{
      			obj.innerHTML = xmlhttp.responseText;
    		}
  	}
  	xmlhttp.send(null);
}