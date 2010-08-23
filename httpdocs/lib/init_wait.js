function initWait() {
  if (!document.getElementsByTagName){ return; }
  $("upload").onclick = function () { 
    $("submit").className = "hidden"; 
    $("wait").className = "";
    }
} 

Event.observe(window, 'load', initWait, false);