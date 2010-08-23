<? 
function getWeekNoByDay($year = 2007,$month = 5,$day = 5) {
       return ceil(($day + date("w",mktime(0,0,0,$month,1,$year)))/7);   
   }  
?>
Now check the function with Test Cases.
For 07/03/2009 or 7th March 2009:
<?

echo getWeekNoByDay('2009','01','15');

?>