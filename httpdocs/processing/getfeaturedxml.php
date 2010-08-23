<? 
include '../includes/db.class.php';
$db = new DB();
$query = "SELECT * from features order by DateFeatured DESC limit 5"; 
		$db->query($query);
		$FeaturedXML = '<featured>';
		while ($line = $db->fetchNextObject()) { 
			$comicDB2 = new DB();
			$ComicID = $line->ComicID;
			$query = "SELECT * from comics where comiccrypt='$ComicID'"; 
			$ComicArray = $db->queryUniqueObject($query);
			$FeaturedXML .='<comic>';
			$FeaturedXML .="<title>".$ComicArray->title.'</title>';
			$FeaturedXML .="<image>".$ComicArray->thumb.'</image>';
			$FeaturedXML .="<description>".$ComicArray->short.'</description>';
			$FeaturedXML .="<link>".$ComicArray->url.'</link>';
			$FeaturedXML .='</comic>';
		} 
		$FeaturedXML .= '</featured>';
		$fp = fopen("../xml/featured.xml",'w');
		$write = fwrite($fp,$FeaturedXML);
		chmod("../xml/featured.xml",0777);
		echo '&featuredxml='.$FeaturedXML;
		?>