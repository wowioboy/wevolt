function makeSearch(content, objID,keywords) 
{
	var serverPage = "http://www.w3volt.com/connectors/getSearchResults.php";
  	var obj = document.getElementById(objID);
  	serverPage=serverPage+"?content="+content+"keywords"+keywords;
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