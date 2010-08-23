function attach_file( p_script_url ) {

      // create new script element, set its relative URL, and load it 
      script = document.createElement( 'script' );
      script.src = p_script_url; 
      document.getElementsByTagName( 'head' )[0].appendChild( script );
}

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 
 function open_login() {
 	 document.getElementById('login_div').style.display = '';
 
 }
 
var theWidth, theHeight;
// Window dimensions:
if (window.innerWidth) {
   theWidth=window.innerWidth;
}
else if (document.documentElement && document.documentElement.clientWidth) {
   theWidth=document.documentElement.clientWidth;
}
else if (document.body) {
theWidth=document.body.clientWidth;
}
if (window.innerHeight) {
theHeight=window.innerHeight;
}
else if (document.documentElement && document.documentElement.clientHeight) {
theHeight=document.documentElement.clientHeight;
}
else if (document.body) {
theHeight=document.body.clientHeight;
}

function roll_over(img_name, img_src)
   {
	if (document[img_name] != null)
  		 document[img_name].src = img_src;
  	else
  		 img_name.src = img_src;
   }
 
function resize_iframe(iframe) {
            var myWidth = 0, myHeight = 0;
            if( typeof( window.innerWidth ) == 'number' ) {
                //Non-IE
                myWidth = window.innerWidth;
                myHeight = window.innerHeight;
            } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
                //IE 6+ in 'standards compliant mode'
                myWidth = document.documentElement.clientWidth;
                myHeight = document.documentElement.clientHeight;
            } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
                //IE 4 compatible
                myWidth = document.body.clientWidth;
                myHeight = document.body.clientHeight;
   
       }
}
        //-- see if there is already something on the onresize
        var tempOnresize = window.onresize; 
        //-- create our event handler
        window.onresize = function(){ 
            //-- if tempFunc is a function, try to call it
            if (typeof (tempOnresize) == "function"){ 
                try{ 
                    tempOnresize(); 
                } catch(e){} //--- if it errors, don't let it crash our script
            } 
            resize_iframe();
        }
