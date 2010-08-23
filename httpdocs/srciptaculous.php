<?php
/*
 *    Srciptaculous.php 
 *     
 * This LICENSE is in the BSD license style.
 *
 *  for germans:
 *  http://de.wikipedia.org/wiki/BSD-Lizenz
 *    
 * Copyright (c) 2008-2009, Christian Zinke
 * http://christianzinke.wordpress.com/  
 * All rights reserved.
 *   
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   Redistributions of source code must retain the above copyright
 *   notice, this list of conditions and the following disclaimer.
 *
 *   Redistributions in binary form must reproduce the above copyright
 *   notice, this list of conditions and the following disclaimer in the
 *   documentation and/or other materials provided with the distribution.
 *
 *   Neither the name of Christian Zinke nor the names of his contributors
 *   may be used to endorse or promote products derived from this software
 *   without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/* Class is mostly selfdeclaring..*/
class handl_scriptac
{
//Output Scripttext
  private $scripttext;
  
  //reset scripttext  
  public function __construct()
  {
    $this->scripttext='';
  }
  

  //Options as array
  public function add_inPlaceEditor($id_element, $php_file, $options)
  {
    $this->scripttext.='var '.$id_element.' = new Ajax.InPlaceEditor(\''.$id_element.'\',\''.$php_file.'\',{';
    if(is_array($options))
    {
        $i=0;
        foreach($options as $key => $value)
        {
          $i++;
          if($i==count($options))
          {
              $this->scripttext.=$key.':\''.$value.'\'';
          }
          else
          {
              $this->scripttext.=$key.':\''.$value.'\',';
          }
        } 
    }      
    else
    {
      return 'Your set Option is not an array';
    }     
    $this->scripttext.='} );';
  }
  
  public function place_inPlaceEditor()
  {
    $return_value='<script type="text/javascript">
    window.onload = function() {';
    $return_value.=$this->scripttext;
    $return_value.='} </script>';
    return $return_value;
  }
  
}
?>