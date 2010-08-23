<?php
/*
* Here you can handle your Inputs
*
*/
if(isset($_REQUEST))
{
  switch($_REQUEST['editorId'])
  {
    case 'test1':  
      //some SQL or other actions can be placed here
      echo $_REQUEST['value'];
    break;
    case 'test2':  
      //some SQL or other actions can be placed here
      echo $_REQUEST['value'];
    break;

  
  }
}
?> 