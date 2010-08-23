<?php

class pagination {

    var $fullresult;    // record set that contains whole result from database
    var $totalresult;   // Total number records in database
    var $query;         // User passed query
    var $resultPerPage; //Total records in each pages
    var $resultpage;    // Record set from each page
    var $pages;            // Total number of pages required
    var $openPage;        // currently opened page
    
/*
@param - User query
@param - Total number of result per page
*/
    function createPaging($query,$resultPerPage) 
    {
		
        $this->query        =    $query;
        $this->resultPerPage=    $resultPerPage;
        $this->fullresult    =    mysql_query($this->query);
        $this->totalresult    =    mysql_num_rows($this->fullresult);
        $this->pages        =    $this->findPages($this->totalresult,$this->resultPerPage);
        if(isset($_GET['page']) && $_GET['page']>0) {
            $this->openPage    =    $_GET['page'];
            if($this->openPage > $this->pages) { 
                $this->openPage    =    1;
            }
            $start    =    $this->openPage*$this->resultPerPage-$this->resultPerPage;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        elseif($_GET['page']>$this->pages) {
            $start    =    $this->pages;
            $end    =    $this->resultPerPage;
            $this->query.=    " LIMIT $start,$end";
        }
        else {
            $this->openPage    =    1;
            $this->query .=    " LIMIT 0,$this->resultPerPage";
        }
        $this->resultpage =    mysql_query($this->query);
		
		if ($_GET['gid'] != '') {
			if ($this->queryString == '')
				$this->queryString ='?';
			else 
				$this->queryString.='&';
			
			$this->queryString .='gid='.$_GET['gid'];
		}
		$this->BaseURL = '/'.$_GET['project'].'/'.$_GET['section'].'/';
		//print $this->query;
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

        if($this->openPage > 1) {
            echo "[<a href=".$this->BaseURL.$this->queryString."&page=1";
					
			echo ">First</a><span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            echo "<a href=".$this->BaseURL.$this->queryString."&page=$prev";
		
			
			echo ">Prev</a>]&nbsp;&nbsp;";
        }
        else {
            echo "[First<span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            echo "Prev]&nbsp;&nbsp;";
        }
        for($i=1;$i<=$this->pages;$i++) {
            if($i == $this->openPage) 
				if ($i==1)
                	echo "$i";
				else 
					 echo ", $i";
            else
			if ($i==1) {
                	echo "<a href=".$this->BaseURL.$this->queryString."&page=$i";
					
					echo ">$i</a>";
				}else{ 
               		echo ",<a href=".$this->BaseURL.$this->queryString."&page=$i";
					
					echo "> $i</a>";
        } }
        if($this->openPage < $this->pages) {
            echo "&nbsp;&nbsp;[<a href=".$this->BaseURL.$this->queryString."&page=$next";
						
			echo ">Next</a><span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            echo "<a href=".$this->BaseURL.$this->queryString."&page=$last";
		
			echo ">Last</a>]";
        }
        else {
            echo "&nbsp;&nbsp;[Next<span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            echo "Last]";
        }    
    }
	
	 function displayPagingConc() 
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

        if($this->openPage > 1) {
            $String .="[<a href=".$this->BaseURL.$this->queryString."&page=1";
					
			$String .=">First</a><span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            $String .="<a href=".$this->BaseURL.$this->queryString."&page=$prev";
		
			
			$String .=">Prev</a>]&nbsp;&nbsp;";
        }
        else {
            $String .="[First<span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            $String .="Prev]&nbsp;&nbsp;";
        }
        for($i=1;$i<=$this->pages;$i++) {
            if($i == $this->openPage) 
				if ($i==1)
                	$String .="$i";
				else 
					 $String .=", $i";
            else
			if ($i==1) {
                	$String .="<a href=".$this->BaseURL.$this->queryString."&page=$i";
					
					$String .=">$i</a>";
				}else{ 
               		$String .=",<a href=".$this->BaseURL.$this->queryString."&page=$i";
					
					$String .="> $i</a>";
        } }
        if($this->openPage < $this->pages) {
            $String .="&nbsp;&nbsp;[<a href=".$this->BaseURL.$this->queryString."&page=$next";
						
			$String .=">Next</a><span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            $String .="<a href=".$this->BaseURL.$this->queryString."&page=$last";
		
			$String .=">Last</a>]";
        }
        else {
            $String .="&nbsp;&nbsp;[Next<span style='color:#e5e5e5; padding-left:2px;padding-right:2px;'>|</span>";
            $String .="Last]";
        }    
    return $String;
	}
}
?>