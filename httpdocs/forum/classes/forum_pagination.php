<?php

class pagination {

    var $fullresult;    // record set that contains whole result from database
    var $totalresult;   // Total number records in database
    var $query;         // User passed query
    var $resultPerPage; //Total records in each pages
    var $resultpage;    // Record set from each page
    var $pages;            // Total number of pages required
    var $openPage;        // currently opened page
    var $querystring;
/*
@param - User query
@param - Total number of result per page
*/
    function createPaging($query,$resultPerPage, $querystring,$page='') 
    {
        $this->query        =    $query;
		$this->querystring = $querystring;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
        $this->page = $page;
		if ($this->page == '')
			$this->page = $_GET['page'];
	    if($this->page>0) {
            $this->openPage    =    $this->page;
            if($this->openPage > $this->pages) { 
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($this->page>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
    }
/*
function to calculate the total number of pages required
@param - Total number of records available
@param - Result per page
*/
    function findPages($total,$perpage) 
    {
        $pages    =    intval($total/$perpage);
        if($total%$perpage > 0) $pages++;
        return $pages;
    }
    
/*
function to display the pagination
*/
    function displayPaging() 
    {
        $self    =    $_SERVER['PHP_SELF'];
        if($this->openPage<=0) {
            $next    =    2;
        }

        else {
            $next    =    $this->openPage+1;
        }
        $prev    =    $this->openPage-1;
        $last    =    $this->pages;
echo '<table width="100%"><tr><td width="25" align="center">';
        if($this->openPage > 1) {
        /*   echo ",<a href=/search/?page=1";
					if (isset($_GET['keywords'])) {
						echo '&keywords='.$_GET['keywords'];
					}
					if (isset($_GET['sort'])) {
						echo '&sort='.$_GET['sort'];
					}
					if (isset($_GET['filters'])) {
						echo '&filters='.$_GET['filters'];
					}
					if (isset($_GET['content'])) {
						echo '&content='.$_GET['content'];
					}
					if (isset($_GET['tags'])) {
						echo '&tags='.$_GET['tags'];
					}
			
			echo ">First</a><span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
			*/
           	echo "<a href=/forum/index.php?page=$prev".$this->querystring;
				
			
			echo "><img src='http://www.wevolt.com/images/search_arrow_left.png' border='0' vspace='5' hspace='5'></a>";
        }
        else {
            echo "<img src='http://www.wevolt.com/images/search_arrow_left_inactive.png' border='0' vspace='5' hspace='5'>";
           // echo "Prev]&nbsp;&nbsp;";
        }
	echo '</td><td>';
		$StartPage = $this->page;
		if ($StartPage == '') {
			$StartPage = 1;
			
			if ($this->pages > 14)
				$EndPage = 14;
			else
				$EndPage = $this->pages;	
		} else {
			if (($StartPage -6) > 1)
				$StartPage = $StartPage - 6;		
			else
				$StartPage = 1;
			
			if (($this->page+6) < $this->pages)
				$EndPage =$this->page+6;
			else
				$EndPage = $this->pages;	
		
		}
		$TotalInter = $StartPage - $EndPage;
		if (($TotalInter < 14) && ($this->pages >= 14)){
			while($EndPage < 14) {
				$EndPage++;
			}
		}
		//print 'PAGI PAGE ' .  $_GET['page'].'<br/>';
	//	print 'TOTAL PAGE = '.$this->pages.'<br/>';
		//print 'START PAGE = '.$StartPage.'<br/>';
		//print 'EndPage = '.$EndPage.'<br/>';
		$InitClear = 1;
        for($i=$StartPage;$i<=$EndPage;$i++) {
            if($i == $this->openPage) 
				if ($InitClear==1)
                	echo "$i";
				else 
					 echo ",$i";
            else
			if ($InitClear==1) {
						 echo "<a href=/forum/index.php?page=$i".$this->querystring;
                		//echo "<a href=/get_search.php?page=$i";
				
					echo ">$i</a>";
				}else{ 
               		echo "<a href=/forum/index.php?page=$i".$this->querystring;
					
					echo ">,$i</a>";
        }
		
		$InitClear = 0;
		
		 }
		echo '</td><td  width="25" align="center" style="padding-right:3px;">';
        if($this->openPage < $this->pages) {
           echo "<a href=/forum/index.php?page=$next".$this->querystring;
				
			
			echo "><img src='http://www.wevolt.com/images/search_arrow_right.png' border='0' vspace='5' hspace='5'></a>";
           /*
		    echo "<a href=/search/?page=$last";
					if (isset($_GET['keywords'])) {
						echo '&keywords='.$_GET['keywords'];
					}
					if (isset($_GET['sort'])) {
						echo '&sort='.$_GET['sort'];
					}
					if (isset($_GET['filters'])) {
						echo '&filters='.$_GET['filters'];
					}
					if (isset($_GET['content'])) {
						echo '&content='.$_GET['content'];
					}
					if (isset($_GET['tags'])) {
						echo '&tags='.$_GET['tags'];
					}
			echo ">Last</a>]";*/
        }
        else {
            echo "<img src='http://www.wevolt.com/images/search_arrow_right_inactive.png' border='0 vspace='5' hspace='5''>";
           // echo "Last]";
        } 
		echo '</td></tr></table>';  
		
    }
}
?>