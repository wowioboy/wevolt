<fieldset style='margin-top:20px; padding-bottom:7px;'>
<legend><b>Edit Event</b></legend>
<table align='center'>				
<tr>
    <td align='left'>Event Name:</td>
    <td><input type='text' style='width:270px' id='event_name' name='event_name' value='{h:event_name}' /></td>
</tr>
<tr>
    <td align='left'>Event Decription:</td>
    <td><textarea style='width:270px; height:50px;' id='event_description' name='event_description' />{h:event_description}</textarea></td>
</tr>
<tr><td colspan='2' align='center' style='height:25px;padding:0px;'><div id='divEventsEdit_msg'></div></td></tr>
<tr>
    <td align='right' style='padding-right:5px;'>
        <input class='form_button' type='button' name='btnCancel' value='Cancel' onclick='javascript:__EventsCancel();'/>
    </td>
    <td align='left' style='padding-right:5px;'>
        <input class='form_button' type='button' name='btnSubmit' value='Update Event' onclick='javascript:__EventsUpdate({h:event_id});'/>
    </td>
</tr>
</table>
</fieldset>