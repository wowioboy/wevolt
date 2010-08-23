<? 

function remove_element($arr, $val){
$count = 0;
//print_r($arr);
	foreach ($arr as $value){
	
	
	//'k'. $arr[$key].'<br/>';
	//print'v'. $val.'<br/>';
		if ($value[0] == $val){
			unset($arr[$count]);
			//print 'Removed ' . $val.'<br/>'; 
		}
		$count++;
	}
	
	return $arr = array_values($arr);

}

$AvailableModuleArray = array (
					array('comiccredits','Credits'),
					array('othercreatorcomics','Other Projects'),
					array('comicsynopsis','Synopsis'),
					array('custommod1','Custom Mod 1'),
					array('custommod2','Custom Mod 2'),
					array('comform','Comment Form'),
					array('linksbox','Links'),
					array('mobile','Mobile'),
					array('status','Status'),
					array('products','Products'),
					array('characters','Characters'),
					array('downloads','Downloads'),
					array('authcomm','Author Comment'),
					array('twitter','Twitter'),
					array('blog','Blog'),
					array('pagecom','Page Comments'),
					array('LatestPageMod','Latest Page'),
					array('recentforum','Forum Posts'),
					array('fbgroup','Facebook Group')
					);
					
					?>