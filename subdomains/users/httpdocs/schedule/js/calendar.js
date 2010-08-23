<!--

   function __JumpTodayDate(){
      var jump_day   = GL_jump_day;
      var jump_month = GL_jump_month;
      var jump_year  = GL_jump_year;
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : GL_view_type;

      __doPostBack('view', view_type, jump_year, jump_month, jump_day);
   }

   function __JumpToDate(){
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

      __doPostBack('view', view_type, jump_year, jump_month, jump_day);
   }

   function __doPostBack(action, view_type, year, month, day, event_action, event_id)
   {			
      var action    = (action != null) ? action : 'view';
      var view_type = (view_type != null) ? view_type : 'monthly';
      var year      = (year != null) ? year : GL_today_year;
      var month     = (month != null) ? month : GL_today_mon;
      var day       = (day != null) ? day : GL_today_mday;
      var event_action = (event_action != null) ? event_action : '';
      var event_id  = (event_id != null) ? event_id : '';
      
      document.getElementById('hid_event_action').value = event_action;
      document.getElementById('hid_event_id').value = event_id;
      document.getElementById('hid_action').value = action;
      document.getElementById('hid_view_type').value = view_type;
      document.getElementById('hid_year').value = year;
      document.getElementById('hid_month').value = month;
      document.getElementById('hid_day').value = day;
      
      document.getElementById('frmCalendar').submit();
   }

   function __HideEventForm(el)
   {
      document.getElementById(el).style.display = 'none';
   }
   
   function __ShowEventForm(el)
   {
      document.getElementById(el).style.display = 'block';
   }
   
   function __CallAddEventForm(el, year, month, day, hour)
   {			
      document.getElementById(el).style.display = 'block';
      var event_from_year  = document.getElementById('event_from_year');
      var event_to_year 	 = document.getElementById('event_to_year');				
      var event_from_month = document.getElementById('event_from_month');
      var event_to_month 	 = document.getElementById('event_to_month');				
      var event_from_day   = document.getElementById('event_from_day');
      var event_to_day 	 = document.getElementById('event_to_day');				
      var event_from_hour  = document.getElementById('event_from_hour');
      var event_to_hour 	 = document.getElementById('event_to_hour');      
  
      for(i = 0; i < event_from_hour.length; i++){
         if(event_from_hour.options[i].value == hour){
            event_from_hour.options[i].selected = true;
            event_to_hour.options[i].selected = true;
         }
      }

      for(i = 0; i < event_from_day.length; i++){
         if(event_from_day.options[i].value == day){
            event_from_day.options[i].selected = true;
            event_to_day.options[i].selected = true;
         }
      }

      for(i = 0; i < event_from_month.length; i++){
         if(event_from_month.options[i].value == month){
            event_from_month.options[i].selected = true;
            event_to_month.options[i].selected = true;
         }
      }
      
      for(i = 0; i < event_from_year.length; i++){
         if(event_from_year.options[i].value == year){
            event_from_year.options[i].selected = true;
            event_to_year.options[i].selected = true;
         }
      }
      
      document.getElementById('divAddEvent_msg').innerHTML = '';
      document.getElementById('event_name').value = '';
      document.getElementById('event_description').value = '';
      document.getElementById('event_name').focus();
   }
   
   // Cancel event inserting 
   function __EventsCancel(){
      __JumpToDate();
   }

   // Delete event 
   function __EventsDelete(eid){			
      if(confirm('Are you sure you want to delete this event?')){			
         var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
         var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
         var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
         var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
     
         __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_delete', eid);
         return true;
      }
      return false;
   }

   // Edit event
   function __EventsEdit(eid){
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_edit', eid);
      return true;
   }   

   // Update event
   function __EventsUpdate(eid){
      var event_name = document.getElementById('event_name').value;
      var event_description = document.getElementById('event_description').value;

      if(trim(event_name) == '' || trim(event_description) == ''){
         document.getElementById('divEventsEdit_msg').innerHTML = '<font color=\'#a60000\'>Please fill all fields!</font>';
         return false;
      }

      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_update', eid);
      return true;
   }   

   // Add events 
   function __EventsAdd(){
      var event_name = document.getElementById('event_name').value;
      var event_description = document.getElementById('event_description').value;

      if(trim(event_name) == '' || trim(event_description) == ''){
         document.getElementById('divEventsAdd_msg').innerHTML = '<font color=\'#a60000\'>Please fill all fields!</font>';
         return false;
      }
      
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
      
      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_insert');
      return true;
   }

   // Add single event
   function __AddEvent(){			
      var event_name = document.getElementById('event_name').value;
      var sel_event_name = document.getElementById('sel_event_name').value;
      var event_description = document.getElementById('event_description').value;
      var sel_event = getCheckedValue(document.forms['frmCalendar'].sel_event);

      var event_from_year  = document.getElementById('event_from_year');
      var event_to_year    = document.getElementById('event_to_year');
      var event_from_month = document.getElementById('event_from_month');
      var event_to_month   = document.getElementById('event_to_month');
      var event_from_day   = document.getElementById('event_from_day');
      var event_to_day 	   = document.getElementById('event_to_day');
      var event_from_hour  = document.getElementById('event_from_hour');
      var event_to_hour    = document.getElementById('event_to_hour');
      
      start_datetime  = event_from_year.value+event_from_month.value+event_from_day.value+event_from_hour.value;
      finish_datetime = event_to_year.value+event_to_month.value+event_to_day.value+event_to_hour.value;
      
      if(sel_event == 'new' && trim(event_name) == ''){
         document.getElementById('event_name').focus();
         document.getElementById('divAddEvent_msg').innerHTML = '<font color=\'#a60000\'>Please enter event name!</font>';
         return false;
      }else	if(sel_event == 'new' && trim(event_description) == ''){
         document.getElementById('event_description').focus();
         document.getElementById('divAddEvent_msg').innerHTML = '<font color=\'#a60000\'>Please enter event description.</font>';
         return false;
      }else	if(sel_event == 'current' && sel_event_name == ''){
         document.getElementById('divAddEvent_msg').innerHTML = '<font color=\'#a60000\'>No event was selected! Please re-enter.</font>';
         return false;
      }else if(start_datetime >= finish_datetime){
         document.getElementById('divAddEvent_msg').innerHTML = '<font color=\'#a60000\'>Start date must be earlier than the end date! Please re-enter.</font>';
         return false;
      }
      
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
      
      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'add');
      __HideEventForm('divAddEvent');
      return true;
   }

   function __DeleteEvent(eid){			
      if(confirm('Are you sure you want to delete this event?')){			
          var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
          var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
          var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
          var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
      
          __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'delete', eid);				
      }
      return false;
   }

   function __EventSelectedDDL(sel_type){
      if(sel_type == 1){
         document.getElementById('sel_event_name').selectedIndex = 0;
         document.getElementById('event_name').readOnly = false;
         document.getElementById('event_name').style.backgroundColor = '#ffffff';
         document.getElementById('event_description').readOnly = false;
         document.getElementById('event_description').style.backgroundColor = '#ffffff';
      }else{
         document.getElementById('event_name').value = '';
         document.getElementById('event_name').readOnly = true;
         document.getElementById('event_name').style.backgroundColor = '#f1f2f3';
         document.getElementById('event_description').value = '';
         document.getElementById('event_description').readOnly = true;
         document.getElementById('event_description').style.backgroundColor = '#f1f2f3';
         document.getElementById('sel_event_current').checked = true;
      }
   }

   function trim(str, chars) {
      return ltrim(rtrim(str, chars), chars);
   }
    
   function ltrim(str, chars) {
      chars = chars || "\\s";
      return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
   }
    
   function rtrim(str, chars) {
      chars = chars || "\\s";
      return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
   }

   function getCheckedValue(radioObj) {
      if(!radioObj) return "";
      var radioLength = radioObj.length;
      if(radioLength == undefined)
        if(radioObj.checked)
            return radioObj.value;
        else
            return "";
      for(var i = 0; i < radioLength; i++) {
        if(radioObj[i].checked) {
            return radioObj[i].value;
        }
      }
      return "";
   }

//-->