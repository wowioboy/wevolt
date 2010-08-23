<div id="divAddEvent" style="left:200px; top:100px;">
    <table id="divAddEvent_Header" width='100%'>				
    <tr>
        <td>						
            <table class='header{h:class_move}'>
            <tr>
                <td align='left'><b>Add Event</b></td>
                <td align='right'><a href="javascript:__HideEventForm('divAddEvent');">[Close]</a></td>						
            </tr>
            </table>					
        </td>					
    </tr>
    </table>
    
    <table width='100%' align='right'>				
    <tr>
        <td align='left'>Event Name:</td>
        <td align='left'>
            <input type='radio' id='sel_event_new' name='sel_event' value='new' checked='checked' onclick='javascript:__EventSelectedDDL(1);' />
            <input type='text' style='width:225px' id='event_name' name='event_name' /><br />
            <input type='radio' id='sel_event_current' name='sel_event' value='current' onclick='javascript:__EventSelectedDDL(2);' />
            <select id='sel_event_name' name='sel_event_name' onchange='javascript:__EventSelectedDDL(2);'><br />
            <option value=''>-- select --</option>
            {h:ddl_event_name}
            </select>
        </td>
    </tr>
    <tr>
        <td align='left'>Event Decription:</td>
        <td><textarea style='width:240px; height:50px;' id='event_description' name='event_description'></textarea></td>
    </tr>
    <tr>
        <td align='left'>From:</td>
        <td nowrap='nowrap'>{h:ddl_from}</td>
    </tr>
    <tr>
        <td align='left'>To:</td>
        <td nowrap='nowrap'>{h:ddl_to}</td>
    </tr>
    <tr><td colspan='2' align='center' style='height:25px;padding:0px;'><div id='divAddEvent_msg'></div></td></tr>
    <tr><td colspan='2' align='right' style='padding-right:12px;'><input class='form_button' type='button' name='btnSubmit' value='Add' onclick='javascript:__AddEvent();'/></td></tr>
    </table>
</div>
