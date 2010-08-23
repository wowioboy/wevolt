<?php 

define('CA2',dirname(__FILE__));
print 'MY CA2 = '.CA2; 
define('CB3','/bloly-theme/');
require_once(dirname(__FILE__)."/bloly-inc/settings.php");
require_once(dirname(__FILE__)."/bloly-inc/lang.php");

if(ERROR_LEVEL<1) {
	error_reporting(0);
} 

define('CC4','0');
define('CD5','1');
define('CE6','2');
define('Log','3');
define('CG8','4');
define('CH9','5');
define('CI0','6');
define('EditMessage','7');
define('CK2','8');
define('CL3','9');
define('CM4','10');
define('Search','11');
define('CO6','12');
unset($CP7);
unset($MessageArray);
unset($CR9);
unset($CS0);
$CS0=null;
$CP7['year' ]=@ (int)$_GET['year'];
$CP7['month']=@ (int)$_GET['month'];
$CP7['day' ]=@ (int)$_GET['day'];
$CP7['number']=@ (int)$_GET['number'];
$CP7['offset']=@ (int)$_GET['offset'];
$CP7['user' ]=@ (int)$_GET['user'];
$CP7['mod_rewrite']=@ (int)$_GET['rewrite'];
$CP7['action']=@ (int)$_GET['action'];
$CP7['email' ]=@ preg_replace("/[^\w\._@-]+/","",$_COOKIE['email']);
$CP7['password' ]=@ AF5($_COOKIE['password']);
$CP7['name' ]="Anonymous";
$CP7['level']=0;
$CP7['BLOG_TITLE']=BLOG_TITLE;
$CP7['BLOG_SLOGAN']=BLOG_SLOGAN;

if($CP7['year']<0 || $CP7['year']>2100){
	$CP7['year']=date("Y");
}

if($CP7['month']<0 || $CP7['month']>12){
	$CP7['month']=date("m");
}

if($CP7['day']<0 || $CP7['day']>31){
	$CP7['day']=date("d");
}

$CP7['PHP_SELF']=@$_SERVER['PHP_SELF'];
$CP7['URL_INDEX']=@$_SERVER['PHP_SELF'];
$CP7['URL_SELF']=@AR7("");
$CR9['action']=Search;
$CP7['URL_SEARCH']=AR7("");

foreach($CP7 as $Keyword=>$CU2) {

	$CR9[$Keyword]=0;
} 

$CR9['action']=CO6;

$CP7['URL_RSS']=AR7("");
$CR9['offset']=1;
$CP7['URL_RSS_ALL']=AR7("");
unset($CR9);
$CV3='';

if(!function_exists('substr_compare')){

	function substr_compare($CW4,$ErrorMesage,$CY6,$CZ7=NULL,$DA8=false){

		$CY6=(int) $CY6;
		
		if($CY6 >= strlen($CW4)) 
		return false;

		if($CY6 == 0 && is_int($CZ7) && $DA8 === true){
		return strncasecmp($CW4,$ErrorMesage,$CZ7);
		}

		if(is_int($CZ7)){
			$DB9=substr($CW4,$CY6,$CZ7);
			$DC0=substr($ErrorMesage,0,$CZ7);
		}else{
		$DB9=substr($CW4,$CY6);$DC0=$ErrorMesage;
		}

		if($DA8 === true){
		return strcasecmp($DB9,$DC0);
		}

	return strcmp($DB9,$DC0);
	}
}

function AB1($DD1){
	return "<span class=error>&nbsp;".str_replace("\n","<br>&nbsp;",htmlspecialchars($DD1))." &nbsp;</span><br>\n";
	}

function AC2($DD1){
	global $CV3;

		if(!headers_sent()){
		echo "<html><body bgcolor=#FFFFFF text=#000000><p class=error>{$CV3}</p>\n";
		}

	echo AB1($DD1);

}

function GetError($ErrorMesage,$SearchQueryString){
	global $CS0;

	if(ERROR_LEVEL>0) $ErrorMesage.="\n".Mysql_Error();

	if(ERROR_LEVEL & 128) 
	$ErrorMesage.="\n".str_replace($CS0['password'],"<i>skipped</i>",$SearchQueryString);

return $ErrorMesage;
}

function AE4($ErrorMesage,$SearchQueryString){

AC2(GetError($ErrorMesage,$SearchQueryString))."<BR>";

}

function AF5($query){

return @ preg_replace("/[^a-zA-Z0-9]+/","",$query);
}

function AG6($DG4){
$DH5=@filesize($DG4);
$DI6=@fopen($DG4,"r");

	if($DI6){
		$ErrorMesage=fread($DI6,$DH5);fclose($DI6);return $ErrorMesage;
	}
	return AB1("<include> file not found");
}

function AH7($DJ7){
	if(count($DJ7)!=2){
	return AB1("Bad <include> format!");
	}
	return AI8(AG6(CA2.$DJ7[1]));
}
	
function AI8($ErrorMesage){
return preg_replace_callback("/<include\\s+([\w+\.\/-]+)>/is","AH7",$ErrorMesage);
}

function AJ9($DG4){

$DG4=CA2.$DG4;$SearchArray=@File($DG4);

	if($SearchArray && @count($SearchArray)>1){

		$DL9=AI8(implode("",$SearchArray));
		$DL9=preg_replace_callback("/\<%(\w+)%\>/i",'AM2',$DL9);
		$DM0="PHAgY2xhc3M9Y3ByPiNibG9seS5jb20+QmxvbHk8L2E+IHYxLjMgYnkgI3NvZnRjYWIuY29tPlNvZnRDYWIgSW5jPC9hPjwvcD4K";
		$DN1="PGEgY2xhc3M9Y3BybCB0YXJnZXQ9X2JsYW5rIGhyZWY9aHR0cDovL3d3dy4=";
		$DO2=base64_decode("PC9ib2R5");
		$DP3=str_replace("#",base64_decode($DN1),base64_decode($DM0));
		echo str_replace($DO2,$DP3.$DO2,$DL9);
	}else{
	AC2("Could not read template");
	}
} 

function AK0($query){
	$query=str_replace("\\","\\\\",$query);
	$query=str_replace("\"","\\\"",$query);
	$query=str_replace("\n","\\n",$query);
	$query=str_replace("\r","\\r",$query);
	$query=str_replace("\t","\\t",$query);
	return $query;
}

function AL1($query,$DQ4,$DR5){

	if($DQ4){
	return AK0($query);
	}
	if($DR5){
	return htmlspecialchars($query);
	}
	return $query;
}

function AM2($DJ7){
	global $CP7,$CR9,$CS0,$MessageArray;$DS6=$DJ7[1];;

	if(strcmp("js_",substr($DS6,0,3))) {
		$DQ4=0;
	} else {$DS6=substr($DS6,3);

	$DQ4=1;

	} 
	
	if(strcmp("f_",substr($DS6,0,2))) {
	$DR5=0;
	} else {
		$DS6=substr($DS6,2);
		$DR5=1;
	} 

	if(!substr_compare($DS6,"g_",0,2)){
		foreach($CP7 as $DT7=>$DU8){
			if(!substr_compare($DS6,$DT7,2)){
				return AL1($DU8,$DQ4,$DR5);
			}
		} 
	return "";
	}

	if(!substr_compare($DS6,"user_",0,5)){
		if(isset($CS0) && null!=$CS0){
			foreach($CS0 as $DT7=>$DU8){
				if(!substr_compare($DS6,$DT7,5)){
					return AL1($DU8,$DQ4,$DR5);
				}
			}
		}
	return AL1(AB1(IDS_AUTH_ERROR),$DQ4,$DR5);
	}

	if(!substr_compare($DS6,"msg_",0,4)){
		if(isset($MessageArray) && null!=$MessageArray){
			foreach($MessageArray as $DT7=>$DU8){
				if(!substr_compare($DS6,$DT7,4)){
					return AL1($DU8,$DQ4,$DR5);
				}
			}
		}
	return "";
	}

	if(!substr_compare($DS6,"post_",0,5)){
		if(isset($_POST)){
			foreach($_POST as $DT7=>$DU8){
				if(!substr_compare($DS6,$DT7,5)){
					return AL1($DU8,$DQ4,$DR5);
				}
			}
		}
	return "";
	}

	if(!substr_compare($DS6,"get_",0,4)){
		if(isset($_GET)){
			foreach($_GET as $DT7=>$DU8){
				if(!substr_compare($DS6,$DT7,4)){
					return AL1($DU8,$DQ4,$DR5);
				}
			}
		}
	return "";
	}
$DV9="";

	if(!strcmp($DJ7[1],"messages")){
		return AY4();
	}

	if(!strcmp($DJ7[1],"comments")){
		return BA6();
	}

	if(!strcmp($DJ7[1],"authentication")){
		return BC8();
	}

	if(!strcmp($DJ7[1],"authentication_ok")){
		if(isset($CS0) && null!=$CS0) 
			return IDS_LOGGED_IN;
	
	return "<input type=submit value=Ok>";
	}
	
	if(!strcmp($DJ7[1],"welcome")){
		if(isset($CS0) && null!=$CS0){
			$CR9['action']=CG8;$CR9['offset']=0;
			$CR9['number']=0;
			$CR9['user']=0;
			$DW0=AR7("");
			$CR9['action']=CH9;
			$CR9['number']=0;
			$CR9['user']=0;
			if($CS0['level']>1) {
				$DX1=AR7("");
			} else {$DX1=IDS_URL_POSTING_DENIED;
		} 
			
		$CR9['action']=CI0;
		$DY2=AR7("");
		$query=preg_replace("/%name/i",$CS0['name'],IDS_AUTH_WELCOME1);
		$query=preg_replace("/%email/i",$CS0['email'],$query);
		$query=preg_replace("/%logout/i",$DW0,$query);
		$query=preg_replace("/%post/i",$DX1,$query);
		$query=preg_replace("/%account/i",$DY2,$query);
		
	}else {
	$CR9['action']=Log;
	$CR9['offset']=0;
	$DZ3=AR7("");
	$query=preg_replace("/%link/i",$DZ3,IDS_AUTH_WELCOME2);
	}
	return $query;
	
	}

	if(!strcmp($DJ7[1],"info")){
		return BB7();
	}
	if(!strcmp($DJ7[1],"calendar")){
	return BY0();
	}
	if(!strcmp($DJ7[1],"archive")){
	return BR3();
	}
	return "";
}
	
function AN3($UserEmail){
	return preg_match("/^([\w9\-\.])+@([\w\-])+(.([\w\-])+)+$/i",$UserEmail);
}

function AO4($ErrorMesage){
	return preg_match("/^\w+$/i",$ErrorMesage) && strlen($ErrorMesage)>2;
}
function AP5($ErrorMesage){
	return preg_match("/^[^\<\>]+$/i",$ErrorMesage) && strlen($ErrorMesage)>2;
}

function AQ6($ErrorMesage,$EB5){
	global $CP7,$CR9;
	
	$EC6=isset($CR9[$EB5]) ? $CR9[$EB5] : $CP7[$EB5];
	if($EC6==0){
		return $ErrorMesage;
	}
return $ErrorMesage . (strlen($ErrorMesage)>0?"&":"") . "{$EB5}=" . $EC6;

}

function AR7($ED7){
	global $CP7,$CR9;
$query=AQ6("","year");
$query=AQ6($query,"month");
$query=AQ6($query,"day");
$query=AQ6($query,"user");
$query=AQ6($query,"number");
$query=AQ6($query,"offset");
$query=AQ6($query,"action");

if(strlen($query)>0) $query="?" . $query;
if(strlen($ED7)>0) $ED7="#" . $ED7;
return $CP7['PHP_SELF'] . $query . $ED7;
}

function AS8($String,$EF9,$ED7){
	$EG0=AR7($ED7);
return "<a href=\"{$EG0}\" class=\"{$EF9}\">{$String}</a>";
}

function AT9($EH1,$EI2){
global $CS0;

	if(!isset($CS0)) 
		return 0;

	if(null==$CS0) 
		return 0;
	if($CS0['level']<2){
	AC2(IDS_POSTING_DENIED);
	return 0;
	}
	
	$EJ3=0;
	$EH1=mysql_escape_string($EH1);
	$EI2=mysql_escape_string($EI2);
	$EK4=mysql_escape_string($CS0['user']);
	$query="INSERT INTO ".PREFIX."Message (idx,user,t,header,body) ";
	$query.= "VALUES (4294967294,{$EK4},NOW(),\"$EH1\",\"$EI2\")";
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult && 1==mysql_affected_rows()){
	@ Mysql_free_result($QueryResult);
	$query="SELECT cnt from ".PREFIX."Message WHERE(idx=4294967294 AND user={$EK4})";
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		if($EM6=mysql_fetch_array($QueryResult,MYSQL_NUM)) {
			$EJ3=$EM6[0];
		} else {
		AC2("Could not FETCH idx");
		return 0;
		}
	} else {
	AE4("Could not SELECT idx",$query);
	return 0;
	}
	
	if($EJ3){
		$query="UPDATE ".PREFIX."Message SET ".PREFIX."Message.idx=$EJ3 WHERE(cnt=$EJ3)";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$EN7=mysql_affected_rows();
			@ Mysql_free_result($QueryResult);
			return ($EN7==1) ? $EJ3 : 0;}AE4("Could not UPDATE idx",$query);
		}else {
		AC2("Could not extract idx");
		}
    } else {AE4("Could not INSERT posting",$query);
}
return 0;
}

function AU0($EI2){
	global $CP7,$CS0;

		if(!isset($CP7['result'])) {
			$CP7['result']="";
		} 

		if(!isset($CS0)){
			$CP7['result'] .= AB1(IDS_MUST_LOGIN);
		return 0;
		}

		if(null==$CS0){
			$CP7['result'] .= AB1(IDS_MUST_LOGIN);
		return 0;
		}

		if($CS0['level']<1){
			$CP7['result'] .= AB1(IDS_LOW_RIGHTS);
			return 0;
		}
		
		if(!isset($CP7['result'])) {
			$CP7['result']="";
		} 
		$EO8=(int)$CP7['number'];
		$EP9=0;
		$query="SELECT COUNT(*) FROM ".PREFIX."Message WHERE (cnt=idx AND cnt={$EO8})";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$EQ0=mysql_fetch_array($QueryResult,MYSQL_NUM);
			if($EQ0) $EP9=$EQ0[0];
			@ Mysql_free_result($QueryResult);
			unset($EQ0,$QueryResult);
		}else {
		$CP7['result'] .= GetError("Could not SELECT user count",$query);
		}
		if($EP9<1){
			$CP7['result'] .= AB1(IDS_MSG_NOT_EXISTS);
			return 0;
		}
		
		$ER1=mysql_escape_string($EI2);
		$EK4=mysql_escape_string($CS0['user']);
		$query="INSERT INTO ".PREFIX."Message (idx,user,t,body) ";
		$query.= "VALUES ($EO8,{$EK4},NOW(),\"$ER1\")";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$EM6=@ mysql_affected_rows();
			@ Mysql_free_result($QueryResult);
			if($EM6>0){
				BK6($EO8,$CS0['name'],strip_tags($EI2));
			}
			return $EM6;
		}
		$CP7['result'] .= GetError("Could not INSERT comment",$query);
		return 0;
		
}
		
function AV1(){
	global $CP7;
	
	$query="SELECT * FROM ".PREFIX."Message AS m JOIN ".PREFIX."User USING (user) WHERE (";
	if($CP7['year']>0){
		$query.="YEAR(m.t)={$CP7['year']} AND ";
		if($CP7['month']>0){
			$query.="MONTH(m.t)={$CP7['month']} AND ";
				if($CP7['day']>0){
					$query.="DAY(m.t)={$CP7['day']} AND ";
				}
		}
	}
	
	if($CP7['user']>0){
		$query.="m.user={$CP7['user']} AND ";
	}
	if($CP7['number']>0){
		$query.="m.idx={$CP7['number']} AND ";
	}
	if($CP7['number']==0){
		$query.="LENGTH(m.header)>0 AND ";
	}
	$query.="1) ";
	
	if($CP7['number']==0){
	$query.="ORDER BY m.t DESC LIMIT ". (BLOG_MAX_MSG+1);
	} else{ 
		$query.="ORDER BY m.t ASC LIMIT ". (($CP7['offset']>0)?BLOG_MAX_COMM:(BLOG_MAX_COMM+1));
	}
	
	if($CP7['offset']>0){
	$query.=" OFFSET {$CP7['offset']}";
	}
	if($CP7['number']>0 && $CP7['offset']>0){
		$query="(SELECT * FROM ".PREFIX."Message AS m JOIN ".PREFIX."User USING (user) WHERE (cnt={$CP7['number']} AND idx={$CP7['number']})) UNION ({$query})";
	}
	return $query;
}

function AW2($ES2){
	$ET3=0;
	$ES2=(int)$ES2;
	$query="SELECT count(*) FROM ".PREFIX."Message WHERE (idx={$ES2})";
	$QueryResult=@ Mysql_Query($query);
	
	if($QueryResult){
		if($EQ0=mysql_fetch_array($QueryResult,MYSQL_NUM)){
		$ET3=$EQ0[0];
		}
		@ Mysql_free_result($QueryResult);
	} else {
	AE4("SELECT count(*) error",$query);
    }return $ET3;
}

function AX3($EU4,$EV5,$EW6){

	global $CS0,$CP7,$CR9;
		foreach($CR9 as $Keyword=>$CU2) {
		$CR9[$Keyword]=0;
		} 
		if(false==$EW6){
			$CR9['action']=CO6;
			$CR9['number']=$CP7['number'];
			$EX7="<img src=\"./bloly-files/rss.gif\" border=\"0\" alt=\"".htmlspecialchars(IDS_RSS_COMMENTS)."\">";
			$EY8=" ".AS8($EX7,"","");
		}else {
			$EY8="";
		}
		
		$DV9="<div class=msg{$EV5}>";
		$DV9.= "<div class=msg_hdr{$EV5}>{$EU4['header']}{$EY8}</div>";
		$CR9['action']=CE6;
		$CR9['user']=$EU4['user'];
		$EZ9=AS8($EU4['name'],"msg_author".$EV5,"");
		$FA0=date(IDS_POSTED_TIME,strtotime($EU4['t']));
		$FB1=preg_replace("/%name/i",$EZ9,IDS_POSTED_BY);
		$FB1=preg_replace("/%time/i",$FA0,$FB1);
		$DV9 .= "<div class=msg_info{$EV5}>{$FB1}</div>";
		if(isset($CS0) && null!=$CS0 && strlen($EU4['header'])>0){
			if(($EU4['user']==$CS0['user'] && $CS0['level']>1) || $CS0['level']>2){
				$CR9['action']=EditMessage;
				$CR9['number']=$EU4['idx'];
				$CR9['user']=0;
				$FC2=AS8(IDS_ADMIN_EDIT,"admin_link","");
				$CR9['action']=CL3;
				$CR9['number']=$EU4['cnt'];
				$CR9['user']=0;
				$FD3=AR7("");
				$String=htmlspecialchars(IDS_DEL_MSG_CONFIRM);
				$FE4 ="<a href=\"{$FD3}\" class=admin_link onClick=\"javascript:return confirm('{$String}')\">".IDS_ADMIN_DELETE."</a>";
				$DV9.="\n\n\n<div class=admin>{$FC2} | {$FE4}";
				if($CS0['level']>2){
					$CR9['action']=CM4;
					$CR9['number']=0;
					$CR9['user']=$EU4['user'];
					$FF5=AR7("");
					$String=htmlspecialchars(IDS_BAN_USER_CONFIRM);
					$DV9.=" | <a href=\"{$FF5}\" class=admin_link onClick=\"javascript:return confirm('{$String}')\">".IDS_ADMIN_BAN."</a>";
				}
				
				$DV9.="</div>\n\n\n";
				}
			} 
			
			if($EW6){
				$CR9['action']=CE6;
				$CR9['number']=$EU4['idx'];
				$CR9['user']=0;$CR9['year']=0;
				$CR9['month']=0;
				$CR9['day']=0;
				$FG6=AW2($EU4['idx']);
				if($FG6>1){
					$EZ9=sprintf(IDS_NUM_COMMENTS2,$FG6-1);
				}else
					$EZ9=sprintf(IDS_NUM_COMMENTS1,0);
				
				$CR9['action']=CD5;
				$FB1=AS8($EZ9,"msg_com_a".$EV5,"#comments");
				$FH7=AS8(IDS_READ_MORE,"msg_more".$EV5,"");
				$FI8=preg_replace("/<MORE>.+/si",$FH7,$EU4['body']);$DV9 .= "<div class=msg_body{$EV5}>{$FI8}</div>";
				$DV9 .= "<div class=msg_com{$EV5}>{$FB1}</div>";
			}else {
			$DV9 .= "<div class=msg_body{$EV5}>{$EU4['body']}</div>";
			}
			
			$DV9 .= "</div>\n";
			return $DV9;
}
	
function AY4(){

	global $CP7,$CR9;
	$DV9="";
	$query=AV1();
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		$FJ9=1;
			for($FK0=0;$FK0<BLOG_MAX_MSG && ($EU4=mysql_fetch_array($QueryResult,MYSQL_ASSOC));$FK0++){
			
			$DV9 .= AX3($EU4,$FJ9,true);
			$FJ9=($FJ9==1) ? 2 : 1;
			}
		@ Mysql_free_result($QueryResult);
		unset($CR9['year']);
		unset($CR9['month']);
		unset($CR9['day']);
		if($FK0>=BLOG_MAX_MSG){
			$CR9['number']=0;
			$CR9['user']=0;
			$CR9['action']=CC4;
			$CR9['offset']=$CP7['offset']+BLOG_MAX_MSG;
			$FL1=AS8(IDS_NEXT_PAGE,"next_link","");
			}else {
				$FL1=IDS_NEXT_PAGE;
			}
			if($CP7['offset']>=BLOG_MAX_MSG){
				$CR9['number']=0;
				$CR9['user']=0;
				$CR9['action']=CC4;
				$CR9['offset']=$CP7['offset']-BLOG_MAX_MSG;
				$LastKeyword=AS8(IDS_PREV_PAGE,"next_link","");
			}else {
				$LastKeyword=IDS_PREV_PAGE;
			}
			
			$DV9 .= "<div class=next_t>{$LastKeyword} | {$FL1}</div>\n";
		}else {
			$DV9=GetError("SELECT error",$query);
		}
	return $DV9;
}

function AZ5($EU4,$EV5){
	global $CP7,$CR9,$CS0;$DV9="<li class=comment{$EV5}>";
	$CR9['action']=CE6;
	$CR9['user']=$EU4['user'];
	$CR9['number']=0;
	$CR9['year']=0;
	$CR9['month']=0;
	$CR9['day']=0;
	$EZ9=AS8($EU4['name'],"comment_author".$EV5,"");
	$FA0=date(IDS_COMMENT_TIME,strtotime($EU4['t']));
	$FB1=preg_replace("/%name/i",$EZ9,IDS_COMMENT_BY);
	$FB1=preg_replace("/%time/i",$FA0,$FB1);
	$DV9 .= "<div class=comment_info{$EV5}>{$FB1}</div>";
	if(isset($CS0) && null!=$CS0 && strlen($EU4['header'])==0){
		if(($EU4['user']==$CS0['user'] && $CS0['level']>0) || $CS0['level']>2){
			$CR9['action']=CK2;
			$CR9['number']=$EU4['cnt'];
			$CR9['user']=0;
			$FC2=AS8(IDS_ADMIN_EDIT,"admin_link","");
			$CR9['action']=CL3;
			$CR9['number']=$EU4['cnt'];
			$CR9['user']=0;
			$FD3=AR7("");
			$String=htmlspecialchars(IDS_DEL_COM_CONFIRM);
			
			$FE4 ="<a href=\"{$FD3}\" class=admin_link onClick=\"javascript:return confirm('{$String}')\">".IDS_ADMIN_DELETE."</a>";
			
			$DV9.="\n\n\n<div class=admin>{$FC2} | {$FE4}";
			
			if($CS0['level']>2){
				$CR9['action']=CM4;
				$CR9['number']=0;
				$CR9['user']=$EU4['user'];
				$FF5=AR7("");
				$String=htmlspecialchars(IDS_BAN_USER_CONFIRM);
				$DV9.=" | <a href=\"{$FF5}\" class=admin_link onClick=\"javascript:return confirm('{$String}')\">".IDS_ADMIN_BAN."</a>";
			}
			
			$DV9.="</div>\n\n\n";
		}
	} 
	
	$DV9 .= "<div class=comment_body{$EV5}>{$EU4['body']}</div>";
	$DV9 .= "</li>\n";
	return $DV9;
}

function BA6(){
	global $CP7,$CR9;
	$DV9="";
	$query=AV1();
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		$FJ9=0;
			while($EU4=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
				if($FJ9>0){
					$DV9 .= AZ5($EU4,$FJ9);
					$FJ9=($FJ9==1) ? 2 : 1;
					}else {
						$CY6=$CP7['offset'];
						$DV9 .= AX3($EU4,1,false);
						$DV9.="<div class=comments><a name=comments></a>\n";
						$FN3=$CY6+($CY6>0?0:1);
						$DV9.="<ol class=comments_list start={$FN3}>";
						$FJ9=1;
					}
				} 
				if($FJ9>0) 
					$DV9 .= "</div></ol>\n";
			@ Mysql_free_result($QueryResult);
			$ET3=AW2($CP7['number'])-1;
			if($ET3>=BLOG_MAX_COMM){
				$DV9.="<div class=pages>".IDS_PAGES1;
					for($FK0=0;($FK0)*BLOG_MAX_COMM<$ET3;$FK0++){
						$CR9['action']=CD5;
						$CR9['offset']=($FK0)*BLOG_MAX_COMM+1;
						$CR9['number']=$CP7['number'];
						$CR9['user']=0;
						$CR9['year']=0;
						$CR9['month']=0;
						$CR9['day']=0;
						if($FK0>0) $DV9.= " - ";
						if($CR9['offset']==$CP7['offset'] || $CR9['offset']==$CP7['offset']+1){
							$DV9.="<span class=page_this>".($FK0+1)."</span>";
						}else {
						
						$DV9.= AS8($FK0+1,"page_link","#comments");
					}
			} 
			
			$DV9.=IDS_PAGES2."</div>\n";
		}
	} else {
	
		$DV9=GetError("SELECT error",$query);
	}
	return $DV9;
}

function BB7(){
	global $CP7,$CR9;
	$EK4=null;
	$query="SELECT * from ".PREFIX."User WHERE(user={$CP7['user']})";
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		if($EM6=mysql_fetch_array($QueryResult,MYSQL_ASSOC)) {
			$EK4=$EM6;
			} else {
				return AB1("Could not get user info");
			}
		} else {
		return GetError("Could not SELECT user info",$query);
	}
	
	if(null==$EK4) 
		return IDS_UNKNOWN_USER;
	foreach($CR9 as $Keyword=>$CU2) {
		$CR9[$Keyword]=0;
	} 
	
	$CR9['action']=CO6;
	$CR9['user']=$EK4['user'];
	$EX7="<img src=\"./bloly-files/rss.gif\" border=\"0\" alt=\"".htmlspecialchars(IDS_RSS_USER)."\">";$EY8=" ".AS8($EX7,"","");
	$FO4="<div class=ui_header>" . $EK4['name'] . $EY8 . "</div>\n";
	$FP5=strlen($EK4['info'])>0 ? $EK4['info'] : IDS_NO_USER_INFO;
	$FO4.= "<div class=ui_text>" . $FP5 . "</div>\n";
	$FQ6=mysql_escape_string($EK4['user']);
	$query="SELECT idx,header,t FROM ".PREFIX."Message WHERE (user={$FQ6} AND LENGTH(header)>0) ORDER BY t DESC";
	$QueryResult=@ Mysql_Query($query);
		foreach($CR9 as $Keyword=>$CU2) {
			$CR9[$Keyword]=0;
		} 
		
		if($QueryResult){$FJ9=1;
			$CR9['action']=CD5;
			$FR7=0;
			while($EU4=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
				if($FR7<1){
					$FR7=1;$FO4.= "<div class=ui_posts_header>" . sprintf(IDS_USER_POSTS,$EK4['name']) . "</div>\n";
					$FO4.= "<div class=ui_posts_text>";
				}
			if(strlen($EU4['header'])>40){
				$ER1=substr($EU4['header'],0,39) . "...";
			}else {
				$ER1=$EU4['header'];
			}
			
			$CR9['number']=$EU4['idx'];
			$DZ3=AS8($ER1,"ui_link","");
			$FO4 .= "<div class=ui_post{$FJ9}><span class=ui_time>{$EU4['t']}</span> - $DZ3</div>\n";$FJ9=($FJ9==1) ? 2 : 1;
		}
	@ Mysql_free_result($QueryResult);
	
	if($FR7>0) {
		$FO4.= "</div>";
	}
}else {return 
GetError("SELECT error",$query);
}return $FO4;
}

function BC8(){
	global $CP7,$CS0;
	if($CS0){
		$FO4="<input type=hidden name=email value=\"{$CS0['email']}\">";
		$FO4.= "<input type=hidden name=password value=\"{$CS0['password']}\">";
	}else {
	if(!isset($_POST['email'])) $_POST['email']="";
	$FO4="<table border=0>";
	$FO4.= "<tr><td class=t_auth>".IDS_AUTH_EMAIL."</td><td><input type=text name=email style=\"width:150px;\" value=\"{$_POST['email']}\"></td></tr>";
	$FO4.= "<tr><td class=t_auth>".IDS_AUTH_PASSWORD."</td><td><input type=password name=password style=\"width:150px;\" value=\"{$CP7['password']}\"></td></tr>";
	$FO4.= "</table><input type=hidden name=remember value=1>\n";
	}return $FO4;
}

function BD9($FS8){
	global $_SERVER,$_POST,$_COOKIE,$CS0;
	$UserEmail=@ $_POST['email'];
	$UserPass=@ $_POST['password'];
	if($FS8){
		$UserEmail="";
		$UserPass="";
		$CS0=null;
	}
	$query=str_replace('www.','',strtolower($_SERVER['HTTP_HOST']));
	SetCookie('email',$UserEmail,time()+(60*60*24*3650),"/",".".$query);
	$_COOKIE['email']=$UserEmail;
	@SetCookie('password',$UserPass,time()+(60*60*24*3650),"/",".".$query);
	$_COOKIE['password']=$UserPass;
}

$FU0=null;
$FV1=null;

function BE0($FW2){
	global $CP7,$FU0,$FV1;
		if(count($FW2)!=2){
			return "";
		};
		
		if(!isset($CP7['result'])) {
			$CP7['result']="";
		} 
		
		$DS6=preg_replace("/javascript:/i","",trim($FW2[1]));
		if(!strcasecmp($DS6,"MORE")){
			return "<MORE>";
		} 
		
		if(!strcmp(substr($DS6,0,1),"/")){
			$DS6=substr($DS6,1);
			$FX3=preg_match("/^[a-z]+/i",$DS6,$FY4);
			if(count($FY4)!=1) return "";
			$FZ5=explode(" ",$FU0);
			for($GA6=0;$GA6<count($FZ5);$GA6++){
				if(!strcasecmp($FY4[0],$FZ5[$GA6])){
					if(isset($FV1[$FZ5[$GA6]])){
						unset($FV1[$FZ5[$GA6]]);
						return "</" . $FY4[0] . ">";
					}else {
					
					$CP7['result']=AB1(sprintf(IDS_TAG5,$FZ5[$GA6]));
					return "";
				}
			}
		}
	return "";
	}
	$FZ5=explode(" ",$FU0);
	
	for($GA6=0;$GA6<count($FZ5);$GA6++){
		$FX3=preg_match("/^[a-z]+/i",$DS6,$ER1);
		$GB7=isset($ER1[0]) ? $ER1[0] : "";
		if(!strcasecmp($GB7,$FZ5[$GA6])){
			if(strcasecmp($GB7,"BR") && strcasecmp($GB7,"IMG")){
				$FV1[strtoupper($GB7)]=1;
			}
		
		$FX3=preg_match_all("/([a-z]+)\s*=\s*[\"]([^\"]+?)[\"]/i",$DS6,$FY4);
		
		if($FX3>0 && 3 == count($FY4) && count($FY4[1])==count($FY4[2])){
			for($FK0=0;$FK0<count($FY4[1]);$FK0++){
				$GC8=substr($FY4[1][$FK0],0,2);
				if(strcasecmp($GC8,"on") && strcasecmp($FY4[1][$FK0],"target") && strcasecmp($FY4[1][$FK0],"class") && strcasecmp($FY4[1][$FK0],"style")){
					if(!strcasecmp($GB7,$FZ5[$GA6])) $GB7 .= " {$FY4[1][$FK0]}=\"{$FY4[2][$FK0]}\"";
				}
			}
		}
		
		if(!strcasecmp($ER1[0],"A")) $GB7 .= " class=p_link target=_blank";
		return "<".$GB7.">";
		}
	}

	if(strlen($GB7)>0){
		$CP7['result']=AB1(sprintf(IDS_TAG6,$GB7));
	}return "";

}

function BF1($FO4,$GD9){
	global $CP7,$FU0,$FV1;
		if(!isset($CP7['result'])) {
			$CP7['result']="";
		} 
		
		$FU0=$GD9;
		$FV1=null;
		$FO4=stripcslashes($FO4);
		if(preg_match("/^[^<]*>/",$FO4)){
			$CP7['result'].=AB1(IDS_TAG1);
		return "";
		}
		
		if(preg_match("/<[^>]*$/",$FO4)){
			$CP7['result'].=AB1(IDS_TAG2);
		return "";
		}
		
		if(preg_match("/<[^>]*</",$FO4)){
			$CP7['result'].=AB1(IDS_TAG3);
			return "";
		}
		
		if(preg_match("/>[^<]*>/",$FO4)){
			$CP7['result'].=AB1(IDS_TAG4);
			return "";
		}
		
		$FO4=preg_replace_callback("/<([^<>]+)>/","BE0",$FO4);
		$FO4=preg_replace("/\r+/","",$FO4);
		$FO4=preg_replace("/[\t ]+/"," ",$FO4);
		$FO4=preg_replace("/\n+/","\n",$FO4);
		$FO4=trim($FO4);
			if($FV1){
				foreach($FV1 as $ER1=>$CU2){
					$FO4.="</$ER1>";
				}
			} 
		$FU0=null;$FV1=null;return $FO4;
}


function BG2(){
	global $CP7,$CR9,$CS0,$_SERVER,$_POST;
	$CP7['result']="";
	if(strcasecmp($_SERVER['REQUEST_METHOD'],"POST")){
	return;
	} 
	if(!isset($CS0) || null==$CS0){
		if(isset($_POST['remember']) && 1==(int)$_POST['remember']){
			@ LogIn($_POST['email'],$_POST['password']);
		}
	} 
	
	if(!isset($CS0) || null==$CS0){
		$CP7['result']="<span class=error>".IDS_MUST_LOGIN."</span>";
		return;
	}
	if(isset($_POST['reply']) && 1==$_POST['reply']){
		if(isset($_POST['header'])){
			$CP7['result']=AB1("Header unexpexted!");
			return;
		}
	if(!isset($_POST['txt'])){
		$CP7['result']=AB1("TXT expexted!");
		return;
	}
	$GE0=BF1($_POST['txt'],ALLOWED_TAGS_TEXT);
	if(strlen($GE0)>0){
		if(AU0($GE0)) {
			$CP7['result'].=IDS_POST_OK;
		} else {$CP7['result'].=AB1("Unexpected error");
	}
	}else {
	$CP7['result'].=AB1(IDS_EMPTY_BODY);
	}
	} else { 
	if(isset($_POST['reply'])){
		$CP7['result'].=AB1("REPLY fieled unexpexted!");
		return;
	}

	if(!isset($_POST['header'])){
		$CP7['result'].=AB1("Header expexted!");
		return;
	}
	if(!isset($_POST['txt'])){
		$CP7['result'].=AB1("TXT expexted!");
		return;
	}
	$GF1=BF1($_POST['header'],ALLOWED_TAGS_HEADER);
	$GE0=BF1($_POST['txt'],ALLOWED_TAGS_TEXT);
	if(strlen($GF1)>0){
		if(strlen($GE0)>0){
			$ET3=AT9($GF1,$GE0);
			if($ET3>0){
				$CR9['action']=CD5;
				$CR9['number']=$ET3;
				$CR9['user']=0;
				$CR9['year']=0;
				$CR9['month']=0;
				$CR9['day']=0;
				$CP7['result'].=sprintf(IDS_NEW_POST_OK,AR7(""));
			}else {
				$CP7['result'].=AB1("Unexpected error");
			}
		} else {
			$CP7['result'].=AB1(IDS_EMPTY_BODY);
		}
		} else {
			$CP7['result']=AB1(IDS_EMPTY_HEADER);
		}
	}
}




function LogIn($UserEmail,$UserPass){
print "MY EMAIL = " . $UserEmail;
   	global $CP7,$CS0,$_POST;
	
	if(strlen($UserEmail)==0 || strlen($UserPass)==0) 
	return;
	
	if(isset($CS0) && null!=$CS0) 
	return;
	
	$UserEmail=mysql_escape_string($UserEmail);
	$UserPass=mysql_escape_string($UserPass);
	$query="SELECT * from ".PREFIX."User WHERE(email=\"{$UserEmail}\" AND password LIKE BINARY \"{$UserPass}\")";
	$CS0=null;
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		$CS0=mysql_fetch_array($QueryResult,MYSQL_ASSOC);
		@ Mysql_free_result($QueryResult);
	}else {
		AE4("Could not SELECT user",$query);
	}
	if($CS0){
		$_POST['email']=$CP7['email']=$UserEmail;
		$_POST['password']=$CP7['password']=$UserPass;
		$CP7['result']="";
		if(strlen($_COOKIE['password'])<1) {
			BD9(false);
		}
			
	}else {
		$CP7['email']="";
		$CP7['password']="";
		$CP7['result']=AB1(IDS_AUTH_ERROR);BD9(true);
	}
} 



function BI4(){
	global $CP7,$_POST;
	
	if(!isset($_POST['email'])) 
	return 0;
	if(!AN3($_POST['email'])){
		$CP7['result']=IDS_BAD_EMAIL;
		return 0;
	}
	
	$CP7['result']="";
	
	if(isset($_POST['register'])){
		$GG2=substr(md5(time()."x".microtime()),1,6);
		$UserName=mysql_escape_string(preg_replace("/@.+/","",$_POST['email']));
		$EP9=0;
		$GI4=mysql_escape_string($_POST['email']);$query="SELECT COUNT(*) FROM ".PREFIX."User WHERE (email='{$GI4}')";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$EQ0=mysql_fetch_array($QueryResult,MYSQL_NUM);
			if($EQ0) $EP9=$EQ0[0];
				@ Mysql_free_result($QueryResult);
				unset($EQ0,$QueryResult);
			}else {
				$CP7['result'].=GetError("Could not SELECT user count",$query);
			}
			if($EP9){$CP7['result'] .= AB1(IDS_EMAIL_EXISTS);
			return 0;
			}
			$EM6=BJ5("e_register.txt","",$_POST['email'],$GG2,"","");
			
			if($EM6){
				$query="INSERT INTO ".PREFIX."User (email,password,name,level,register_time) VALUES ('{$GI4}','{$GG2}','{$UserName}',".USER_LEVEL.",NOW())";
				$QueryResult=@ Mysql_Query($query);
				if($QueryResult){
					if(1==mysql_affected_rows()){
					$CP7['result'] .= IDS_REGISTRATION_OK;
					}else $CP7['result'] .= AB1("Unexpected database error");
				@ Mysql_free_result($QueryResult);
				}else {
				$CP7['result'] .= GetError("Coulf not INSERT user",$query);
				}
		} else {
		$CP7['result'] .= AB1(IDS_SENDMAIL_ERROR);
		}
	} 
	if(isset($_POST['remind'])){
		$GI4=mysql_escape_string($_POST['email']);
		$query="SELECT * FROM ".PREFIX."User WHERE (email=\"{$GI4}\")";$EK4=null;
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			if(1==mysql_num_rows($QueryResult)){
				$EK4=mysql_fetch_array($QueryResult,MYSQL_ASSOC);
			}
			@ Mysql_free_result($QueryResult);
			} else {
				$CP7['result'].=GetError("Could not SELECT user",$query);
			}
		if(null==$EK4){
			$CP7['result'] .= AB1(IDS_EMAIL_NOT_FOUND);
			return;
		}
		$EM6=BJ5("e_reminder.txt",$EK4['name'],$EK4['email'],$EK4['password'],"","");
		
		if($EM6){
		$CP7['result'] .= IDS_SENDMAIL_OK;
		}else {
			$CP7['result'] .= AB1(IDS_SENDMAIL_ERROR);
		}
	} 
	if(isset($_POST['change'])){
		$GI4=mysql_escape_string($_POST['email']);
		$GJ5=@ mysql_escape_string(AF5($_POST['old']));
		$GK6=@ mysql_escape_string(AF5($_POST['new1']));
		$GL7=@ mysql_escape_string(AF5($_POST['new2']));
		if(strlen($GJ5)<1 || strlen($GK6)<1 || strlen($GL7)<1 || strlen($GI4)<1){$CP7['result'] .= AB1(IDS_ALL_REQ);
		return;
		}
		if(strcmp($GK6,$GL7)){
			$CP7['result'] .= AB1(IDS_PASSW_NOT_MATCH);
		return;
		}
		$query="UPDATE ".PREFIX."User SET ".PREFIX."User.password=\"$GK6\" WHERE(email=\"{$GI4}\" AND password LIKE BINARY \"$GJ5\")";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			if(1==mysql_affected_rows()){
				$CP7['result'] .= IDS_PASSWORD_CHANGED;
			}else $CP7['result'] .= AB1(IDS_USER_NOT_FOUND);
		@ Mysql_free_result($QueryResult);
		}else {
			$CP7['result'] .= GetError("Could not UPDATE user",$query);
		}
	}
}

function BJ5($Template,$UserName,$UserEmail,$UserPass,$DD1,$GN9){

	global $CP7,$_SERVER;
	$SearchArray=@File(CA2.CB3.$Template);
		if(!($SearchArray) || (@count($SearchArray)<3)){
			$CP7['result'].=AB1("Template does not exists: {$Template}");
			return;
		}
		if(strlen($UserName)<1){
			$UserName=IDS_DEFAULT_NAME;
		}
		$GO0=str_replace("www.","",strtolower($_SERVER['SERVER_NAME']));
		if(strstr(strtolower($_SERVER['HTTP_REFERER']),$GO0)){
			$GP1=$_SERVER['HTTP_REFERER'];
		}else {
			$GP1="http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}
		$String=preg_replace("/%EMAIL/",$UserEmail,implode("",$SearchArray));
		$String=preg_replace("/%NAME/",$UserName,$String);
		$String=preg_replace("/%PASSWORD/",$UserPass,$String);
		$String=preg_replace("/%TEXT/",$DD1,$String);
		$String=preg_replace("/%POSTER/",$GN9,$String);
		$String=preg_replace("/%REFERER/",$_SERVER['HTTP_REFERER'],$String);
		$String=preg_replace("/%SERVER/",$GO0,$String);
		
		if(1==preg_match("/Subject:\s*(.+)/i",$String,$GQ2)) 
			$GR3=$GQ2[1];
		else 
			$GR3="";
			$GS4=preg_replace("/%SERVER/",$GO0,$String);
		
		$SearchArray=explode("\n\n",$String,2);
		
		if(count($SearchArray)!=2){
			$SearchArray=explode("\r\n\r\n",$String,2);
		}
		
		if(strlen(EMAIL_BCC)>0) {
			$SearchArray[0].="\nbcc: ".EMAIL_BCC;
		} 
		return @ mail($UserEmail,$GR3,$SearchArray[1],$SearchArray[0]);
}

function BK6($GT5,$GU6,$EI2){
	global $CS0;
	$GT5=(int)$GT5;
	$query="SELECT u.email FROM ".PREFIX."User AS u,".PREFIX."Message AS m WHERE (m.idx={$GT5} AND m.cnt={$GT5} AND u.user=m.user)";
	$UserEmail=null;
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		$EK4=mysql_fetch_array($QueryResult,MYSQL_NUM);
			if(null==$EK4){AC2("Could not FETCH email");
				return;
			}
			$UserEmail=$EK4[0];
	}else {
	AE4("Could not SELECT email",$query);return;
	}
	
	if(null==$UserEmail || strlen($UserEmail)<3){
		AC2("Bad email: ".htmlspecialchars($UserEmail));
		return;
	}
	
	BJ5("e_notify.txt",$CS0['name'],$UserEmail,"",$EI2,$GU6);
}

function BL7(){
	global $CP7,$CS0,$_POST,$_SERVER;
	$CP7['result']="";
	if(strcasecmp($_SERVER['REQUEST_METHOD'],"POST")){
		return;
	}
	
	if(!isset($CS0) || null==$CS0){
		if(isset($_POST['remember']) && 1==(int)$_POST['remember']){
			@ LogIn($_POST['email'],$_POST['password']);
		}
	} 
	
	if(!isset($CS0) || null==$CS0){
		$CP7['result']="<span class=error>".IDS_MUST_LOGIN."</span>";
			return;
	}
	if(isset($_POST['name']) && isset($_POST['txt'])){
		$UserName=@ mysql_escape_string(trim(strip_tags($_POST['name'])));
		$GV7=@ mysql_escape_string(BF1($_POST['txt'],ALLOWED_TAGS_INFO));
		if(strlen($UserName)==0 || strlen($GV7)==0){
			$CP7['result'].=AB1(IDS_ALL_REQ);return;
		}
		if(@ $_POST['notitication']==1) 
			$GW8=1;
		else
		$GW8=0;$query="UPDATE ".PREFIX."User SET ".PREFIX."User.name=\"$UserName\",".PREFIX."User.info=\"$GV7\",".PREFIX."User.notifications=\"{$GW8}\" WHERE(user=\"{$CS0['user']}\" AND level>0 AND password LIKE BINARY \"{$CS0['password']}\")";
			
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			if(1==mysql_affected_rows()){
				$CP7['result'] .= IDS_INFO_SAVED;$CS0=null;
				LogIn($CP7['email'],$CP7['password']);
			}else {
				if(mysql_errno()) $CP7['result'] .= AB1(IDS_USER_NOT_FOUND);
			}
			@ Mysql_free_result($QueryResult);
		}else {
			$CP7['result'] .= GetError("Could not UPDATE user",$query);}
	}
}
	
	
function BM8(){
	global $CP7,$CR9,$CS0,$MessageArray,$_POST,$_SERVER;
	$CP7['result']="";
	
	if(!strcasecmp($_SERVER['REQUEST_METHOD'],"POST")){
		if(!isset($CS0) || null==$CS0){
			if(isset($_POST['remember']) && 1==(int)$_POST['remember']){
				@ LogIn($_POST['email'],$_POST['password']);
			}
		}
		if(!isset($CS0) || null==$CS0){
			$CP7['result']=AB1(IDS_MUST_LOGIN);
			return;
		}
		
		if(isset($_POST['txt']) && isset($_POST['header'])){
			if($CS0['level']<2){
				$CP7['result']=AB1(IDS_LOW_RIGHTS);
				return;
			}
		$GF1=mysql_escape_string(BF1($_POST['header'],ALLOWED_TAGS_HEADER));
		$GE0=mysql_escape_string(BF1($_POST['txt'],ALLOWED_TAGS_TEXT));
		if(strlen($GF1)>0){
			if(strlen($GE0)>0){
				if($CS0['level']<3) {
					$GX9="AND user={$CS0['user']}";
				} else
				$GX9="";$query="UPDATE ".PREFIX."Message SET ".PREFIX."Message.header=\"{$GF1}\",".PREFIX."Message.body=\"{$GE0}\" WHERE(idx=cnt AND cnt={$CP7['number']} {$GX9})";
			
			$QueryResult=@ Mysql_Query($query);
			$EN7=0;
			
			if($QueryResult){
				$EN7=mysql_affected_rows();
			@ Mysql_free_result($QueryResult);
		}else {
		
		$CP7['result'].=GetError("Could not UPDATE message",$query);
		
		}
		
		if($EN7>0){
			$CR9['action']=CD5;$CP7['result']=sprintf(IDS_NEW_POST_OK,AR7(""));
		}else {
			$CP7['result']=AB1("Unexpected error");
		}
	} else {
		$CP7['result']=AB1(IDS_EMPTY_BODY);
	}
} else {
$CP7['result']=AB1(IDS_EMPTY_HEADER);
}
} 
if(isset($_POST['txt']) && !isset($_POST['header'])){
	if($CS0['level']<1){
		$CP7['result']=AB1(IDS_LOW_RIGHTS);
	return;
	}
$GF1=mysql_escape_string(BF1($_POST['txt'],ALLOWED_TAGS_TEXT));
if(strlen($GF1)>0){
	if($CS0['level']<3) {
		$GX9="AND user={$CS0['user']}";
	} else
	$GX9="";$query="UPDATE ".PREFIX."Message SET ".PREFIX."Message.body=\"{$GF1}\" WHERE(cnt!=idx AND cnt={$CP7['number']} {$GX9})";
	
	$QueryResult=@ Mysql_Query($query);
	$EN7=0;
	
	if($QueryResult){$EN7=mysql_affected_rows();
	@ Mysql_free_result($QueryResult);
	}else {
		$CP7['result'].=GetError("Could not UPDATE message",$query);
	}
	
	if($EN7>0){
		$CR9['action']=CD5;
		$CP7['result']=IDS_POST_OK;
	}else {
		$CP7['result']=AB1("Unexpected error");
	}
} else {

$CP7['result']=AB1(IDS_EMPTY_BODY);
}
}
}

$MessageArray=null;

$query="SELECT * FROM ".PREFIX."Message WHERE (cnt={$CP7['number']})";

$QueryResult=@ Mysql_Query($query);

if($QueryResult){
	$MessageArray=mysql_fetch_array($QueryResult,MYSQL_ASSOC);
	@ Mysql_free_result($QueryResult);
}else {
	$CP7['result'].=GetError("Could not SELECT message",$query);
}
} 


function BN9(){

	global $CP7;
	$CP7['result']="";
	
	if($CP7['number']>0) {
		BO0($CP7['number']);
	}
}

function BO0($EV5){
	global $CP7,$MessageArray,$CS0;
		if(!isset($CP7['result'])) {
			$CP7['result']="";
		} 
		$MessageArray=null;
		$query="SELECT * FROM ".PREFIX."Message WHERE (cnt={$EV5})";
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$MessageArray=mysql_fetch_array($QueryResult,MYSQL_ASSOC);
			@ Mysql_free_result($QueryResult);
		}else {
			$CP7['result'].=GetError("Could not SELECT message",$query);
		}
		
		if(null==$MessageArray){
			$CP7['result'].=AB1(IDS_DELETE_ERROR);
			return;
		}
		
		if($MessageArray['cnt']==$MessageArray['idx']){
			if($CS0['level']<2){
				$CP7['result'].=AB1(IDS_LOW_RIGHTS);
				return;
			}
			if($CS0['level']<3 && $CS0['user']!=$MessageArray['user']){
				$CP7['result'].=AB1(IDS_DELETE_OTHER);
				return;
			}
			
			if($CS0['level']<3) {
				$GX9="AND user=". $CS0['user'];
			} else {
				$GX9="";
			} 
			
			$query="DELETE LOW_PRIORITY FROM ".PREFIX."Message WHERE(idx={$EV5} {$GX9})";
			$QueryResult=@ Mysql_Query($query);
			$GY0=0;
			if($QueryResult){
				$GY0=mysql_affected_rows();
				@ Mysql_free_result($QueryResult);
			}else {
				$CP7['result'].=GetError("Could not DELETE message");
			}
			
			if($GY0>0) {
				$CP7['result'].=IDS_DELETE_OK;
			} else {
				$CP7['result'].=AB1(IDS_DELETE_ERROR);
			} 
			
			$CP7['result'].="<BR>";
			}else {
			
				if($CS0['level']<1){
					$CP7['result'].=AB1(IDS_LOW_RIGHTS);
					return;
				}
				
				if($CS0['level']<3 && $CS0['user']!=$MessageArray['user']){
					$CP7['result'].=AB1(IDS_DELETE_OTHER);
					return;
				}
				
				if($CS0['level']<3) {
					$GX9="AND user=". $CS0['user'];
				} else {
					$GX9="";
				} 
				
				$query="DELETE LOW_PRIORITY FROM ".PREFIX."Message WHERE(cnt={$EV5} {$GX9})";
				$QueryResult=@ Mysql_Query($query);
				$GY0=0;
				if($QueryResult){
					$GY0=mysql_affected_rows();
					@ Mysql_free_result($QueryResult);
				}else {
				$CP7['result'].=GetError("Could not DELETE message",$query);
				}
				if($GY0>0) {
					$CP7['result'].=IDS_DELETE_OK;
				} else {
					$CP7['result'].=AB1(IDS_DELETE_ERROR);
				} 
				
				$CP7['result'].="<BR>";
		}
		
} 

function BP1(){
	global $CP7,$CS0;
	
	$CP7['result']="";
	
	if($CS0['level']<3){
		$CP7['result'].=AB1(IDS_LOW_RIGHTS);
	return;
	}
	
	if($CS0['user']==$CP7['user']){
		$CP7['result'].=AB1(IDS_BAN_YOURSELF);
		return;
	}
	
	$query="UPDATE ".PREFIX."User SET ".PREFIX."User.level=0 WHERE(user={$CP7['user']})";
	$QueryResult=@ Mysql_Query($query);
	
	if($QueryResult){
		@ Mysql_free_result($QueryResult);
	}else {
	
		$CP7['result'].=GetError("Could not UPDATE user",$query);
	}
	
	$query="SELECT * FROM ".PREFIX."Message WHERE(user={$CP7['user']})";
	
	$QueryResult=@ Mysql_Query($query);
	
	if($QueryResult){
		while($MessageArray=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
			BO0($MessageArray['cnt']);
		}
		@ Mysql_free_result($QueryResult);
	}else {
	
		$CP7['result'].=GetError("Could not SELECT messages",$query);
	}
	$CP7['result']=IDS_USER_BAN_OK;
}

function BQ2(){

global $CP7,$CR9,$_SERVER,$_POST;

	if(strcasecmp($_SERVER['REQUEST_METHOD'],"POST") || !isset($_POST['q'])){
		$CP7['result']="";
		return;
	}
	
	$CR9['action']=CD5;
	$CR9['user']=0;
	$CR9['offset']=0;
	$CR9['year']=0;
	$CR9['month']=0;
	$CR9['day']=0;
	// Strip Search of Tags
	$_POST['q']=strip_tags($_POST['q']);
	//Take out bad characters in search
	$SearchString=preg_replace("/['\"\\\\]+/"," ",$_POST['q']);
	//Take out the excess Whitespace
	$SearchString=preg_replace("/\s+/"," ",$SearchString);
	//Explode into an array
	$SearchArray=explode(" ",$SearchString);
	//Sort that array
	sort($SearchArray);
	$SearchQueryString="";
	$LastKeyword="";
	
	foreach($SearchArray as $Keyword){
	
		if(strcasecmp($LastKeyword,$Keyword) && strlen($Keyword)>1){
		      
			if(strlen($SearchQueryString)>0) {
				$SearchQueryString.=" OR ";
			} 
		
		$SearchQueryString.="INSTR(CONCAT(body,header),\"".mysql_escape_string($Keyword)."\")";
		
		$LastKeyword=$Keyword;
		
		}
	
	} 
	
	$CP7['result']="<div>Searching for <b>{$SearchString}</b></div>\n";
	$query="SELECT * FROM ".PREFIX."Message WHERE (idx=cnt AND ({$SearchQueryString})) ORDER BY t DESC LIMIT 50";
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		while($MessageArray=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
			$CR9['number']=$MessageArray['cnt'];
			$DZ3=AS8($MessageArray['header'],"","");$CP7['result'].="<p><span class=ui_time>{$MessageArray['t']}</span> {$DZ3}</p>\n";
		}
		@ Mysql_free_result($QueryResult);
	}else{
		$CP7['result'].=GetError("Could not SELECT messages",$query);
	}
} 


function BR3(){
	global $CR9;
	$CR9['action']=CC4;
	$CR9['user']=0;
	$CR9['offset']=0;
	$CR9['number']=0;
	$CR9['day']=0;
	$FO4="";
	$query="SELECT count(*) AS c,MONTH(t) AS m,YEAR(t) AS y FROM ".PREFIX."Message WHERE (cnt=idx) GROUP BY m ORDER BY t DESC";
	$QueryResult=@ Mysql_Query($query);
	if($QueryResult){
		while($EQ0=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
			$HA2=BW8($EQ0['m']);
			if(strlen($FO4)>0) {
				$FO4.="<br>";
			} 
			
			$CR9['year']=$EQ0['y'];
			$CR9['month']=$EQ0['m'];
			$Sitelink=AS8($HA2.",".$EQ0['y'],"arch_link","");
			$FO4.="<nobr class=arch_p>{$Sitelink} <span class=arch_num>[{$EQ0['c']}]</span></nobr>";
		}
		@ Mysql_free_result($QueryResult);
	}else {
	return GetError("Could not SELECT archive",$query);
	}
	return $FO4;
}

function BS4($query){
	$query=preg_replace("/\\]\\]>/","&#93;]>",$query);
	return "<![CDATA[".$query."]]>";
}

function BT5(){
	global $CP7,$CR9,$_SERVER;
		header('Content-type: application/xml',true);
		foreach($CP7 as $Keyword=>$CU2) {
			$CR9[$Keyword]=0;
		} 
		
		$HC4="http://" . $_SERVER['SERVER_NAME'];
		$Sitelink=$HC4.AR7("");
		echo "<?xml version=\"1.0\" encoding=\"".DB_ENCODING."\"?>\n";
		echo "<rss version=\"2.0\">\n";
		echo "<channel>\n";
		echo "<title>".BLOG_TITLE."</title>\n";
		echo "<link>{$Sitelink}</link>\n";
		echo "<description>".BLOG_TITLE."</description>\n";
		echo "<language>".DB_LANG."</language>\n";
		echo "<pubDate>".date("r")."</pubDate>\n";
		echo "<lastBuildDate>".date("r")."</lastBuildDate>\n";
		echo "<generator>Panelflow.com</generator>\n";
		$query=preg_replace("/LIMIT\s+\d+/i","Limit ".RSS_MAX_ITEMS,AV1());
		$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$HD5="";
				while($FW2=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
					if(strlen($HD5)==0) {
						$HD5="Re: ".$FW2['header'];
					} 
					
					echo "<item>\n";
					$CR9['number']=$FW2['idx'];
					echo "\t<title>".BS4(strlen($FW2['header'])>0?$FW2['header']:$HD5)."</title>\n";
					echo "\t<link>".$HC4.AR7("")."</link>\n";
					echo "\t<description>".BS4($FW2['body'])."</description>\n";
					echo "\t<pubDate>".date("r",strtotime($FW2['t']))."</pubDate>\n";
					echo "\t<guid>".$HC4.AR7("comment")."</guid>\n";
					echo "</item>\n";
				}
				@ Mysql_free_result($QueryResult);
		}else {
				
			AE4("Could not SELECT messages",$query);
				
		}
		echo "</channel>\n";
		echo "</rss>\n";
}

function BU6($HE6,$HF7,$HG8){

	if($HE6<0 || $HF7<1 || $HF7>12 || $HG8<1 || $HG8>31) 
	return -1;
	
	$HH9=(int)($HE6 / 100);
	$HE6=(int)($HE6 % 100);
	if($HF7 < 3){
		$HF7 += 12;
		if($HE6 > 0) $HE6--;
		else {
		$HE6=99;$HH9--;
		}
	} 
	
	$HI0=$HG8;$HI0=$HI0 + (int)((($HF7 + 1) * 26) / 10);$HI0=$HI0 + $HE6;$HI0=$HI0 + (int)($HE6 / 4);$HI0=$HI0 + (int)($HH9 / 4);
	$HI0=$HI0 - $HH9 - $HH9;
	
	while($HI0<0) $HI0+=7;$HI0=$HI0 % 7;
	
	if($HI0==0) $HI0=7;
	return $HI0-1;
	
}

function BV7($HA2,$HJ1){
	$HK2=array(31,28,31,30,31,30,31,31,30,31,30,31);
	if($HA2==2) 
	return 28 + ($HJ1%4);
	
return ($HA2>0 && $HA2<13) ? $HK2[$HA2-1] : 12;
}

function BW8($HA2){
	$HL3=explode(" ",IDS_MONTHS);
	if(count($HL3)!=12 || $HA2<1 || $HA2>12) 
	return "Unknown";
return $HL3[$HA2-1];

}

function CalDays(){
	$HL3=explode(" ",IDS_DAYSOFWEEK);
	
	if(count($HL3)!=7) 
	return "<tr><td colspan=7>".AB1("ERROR")."</td></tr>";
	
	if(FIRST_SUNDAY){
	array_push($HL3,array_shift($HL3));
	}
	
	$FO4="<tr class=cal_tr_dweek>";
	foreach($HL3 as $query) 
		$FO4.="<td class=cal_td_dweek>".$query."</td>";
	return $FO4."</tr>";
}

function BY0(){
	global $CP7,$CR9;
	$CR9['action']=CC4;
	$CR9['user']=0;
	$CR9['offset']=0;
	$CR9['number']=0;
	$CP7['number']=0;
	$HM4=(int)date("Y");
	$HN5=(int)date("m");
	$HO6=(int)date("d");
	$HP7=($CP7['year']>0) ? $CP7['year'] : $HM4;$HQ8=($CP7['month']>0) ? $CP7['month'] : $HN5;
	
	if($CP7['day']>0){
		$HR9=$CP7['day'];
	}else {
		$HR9=(0==$CP7['year'] && 0==$CP7['month'])? $HO6 : 0;
	}
	
	$HS0=array();
	
	for($FK0=0;$FK0<32;$FK0++) {
		$HS0[$FK0]=0;
	} 
	
	$query="SELECT count(*) AS cnt,DAY(t) AS d FROM ".PREFIX."Message WHERE (cnt=idx AND YEAR(t)={$HP7} AND MONTH(t)={$HQ8}) GROUP BY d";
	
	$QueryResult=@ Mysql_Query($query);
	
	if($QueryResult){
		while($EQ0=mysql_fetch_array($QueryResult,MYSQL_ASSOC)){
			if($EQ0['d']>0 && $EQ0['d']<32) {$HS0[$EQ0['d']]=$EQ0['cnt'];
		}
	}
} else {} 

$ET3=BV7($HQ8,$HP7);

$HG8=1;
$FK0=BU6($HP7,$HQ8,$HG8) - FIRST_SUNDAY;

if($FK0<0) {
	$FK0=6;
} 

$HT1=BW8($HQ8);

$CalString="<div class=calendar><table border=0 cellspacing=0 cellpadding=2 class=cal_table>";
$CR9['year']=($HQ8>1)?$HP7:($HP7-1);$CR9['month']=($HQ8>1)?($HQ8-1):12;
$HV3=AS8("&lt;","cal_month_link","");$CR9['year']=($HQ8>11)?($HP7+1):$HP7;
$CR9['month']=($HQ8>11)?1:($HQ8+1);
$HW4=AS8("&gt;","cal_month_link","");
$CR9['year']=$HP7>0?($HP7-1):0;
$CR9['month']=$HQ8;
$HX5=AS8("&lt;","cal_year_link","");
$CR9['year']=$HP7+1;$CR9['month']=$HQ8;
$HY6=AS8("&gt;","cal_year_link","");
$CalString.="<tr class=cal_tr_hdr><td colspan=7 class=cal_td_hdr align=center>{$HV3}{$HT1}$HW4 &nbsp;{$HX5}{$HP7}{$HY6}</td></tr>";
$CalString.=CalDays();
$CalString.="<tr class=cal_tr_day>";

if($FK0<7){
	for($GA6=0;$GA6<$FK0;$GA6++) 
		$CalString.="<td class=calc_empty>&nbsp;</td>";
}

$CR9['year']=$HP7;$CR9['month']=$HQ8;

for($GA6=1;$GA6<7 && $HG8<=$ET3;$GA6++){
	while($FK0<7 && $HG8<=$ET3){
		if($HS0[$HG8]==0) {
			$HZ7=$HG8;
		} else {
		
		$CR9['day']=$HG8;$HZ7=AS8($HG8,"cal_day","");
	}
	
 	if($HG8==$HO6 && $HQ8==$HN5 && $HP7==$HM4){
	$CalString .= "<td class=cal_today align=right title=today>".$HZ7."</td>";
	}else if($HG8==$HR9){
		$CalString .= "<td class=cal_select align=right title=selected>".$HZ7."</td>";
	}else if($HS0[$HG8]==0){
	$CalString .= "<td class=cal_none align=right>".$HZ7."</td>";
}else {

$CalString .= "<td class=cal_td_day align=right>".$HZ7."</td>";

}
$HG8++;
$FK0++;

}

if($HG8>$ET3){

	for(;$FK0<7;$FK0++) 
		$CalString.="<td class=calc_empty>&nbsp;</td>";
	
}

$FK0=0;

$CalString .= "</tr>\n";

if($HG8<$ET3) $CalString .= "<tr class=cal_tr_day>";
}

$CalString .= "</table></div>";
return $CalString;
}

function BZ1($UserName,$IA8){
	global $IB9;$IC0=1;
	$query=Mysql_Query("SELECT * FROM $UserName");
	$QueryResult=@ Mysql_Query($query);
		if($QueryResult){
			$IC0=0;
			$IB9=1;
			@ Mysql_free_result($QueryResult);
		}else {
		AE4("Could not CREATE table",$query);
		}
		
		if($IC0){
			$QueryResult=@ Mysql_Query($IA8);
			
			if($QueryResult){
				@ Mysql_free_result($QueryResult);
			}else {
			AE4("AC2 creating table {$UserName}");
			$IC0=0;
			}
		} 
	return $IC0;
	}
	@ Mysql_Connect(DB_HOST,DB_USER,DB_PASSWORD);
	if(Mysql_Errno()){
		$CV3=Mysql_Error();
	}
	
	@ Mysql_Select_db(DB_NAME);
	if(Mysql_Errno()){
		$CV3 .= "\n" . Mysql_Error();
	}
	
	LogIn($CP7['email'],$CP7['password']);
	
	if(!isset($_SERVER['NOTMPL'])){
		if(CD5==$CP7['action']){
			BG2();
		AJ9(CB3.'post.tmpl');
	}else if(CC4==$CP7['action']){
		AJ9(CB3.'main.tmpl');
	}else if(Log==$CP7['action']){
		if(!BI4()){
			@ LogIn($_POST['email'],$_POST['password']);
			}AJ9(CB3.'auth.tmpl');
	}else if(CG8==$CP7['action']){
		BD9(true);AJ9(CB3.'main.tmpl');
	}else if(CE6==$CP7['action']){
		AJ9(CB3.'user.tmpl');
	}else if(CH9==$CP7['action']){
		BG2();
		AJ9(CB3.'new.tmpl');
	}else if(CI0==$CP7['action']){
		BL7();
		AJ9(CB3.'account.tmpl');
	}else if(EditMessage==$CP7['action']){
		BM8();
		AJ9(CB3.'edit_msg.tmpl');
	}else if(CK2==$CP7['action']){
		BM8();
		AJ9(CB3.'edit_com.tmpl');
	}else if(CL3==$CP7['action']){
		BN9();
		AJ9(CB3.'blank.tmpl');
	}else if(CM4==$CP7['action']){
		BP1();
		AJ9(CB3.'blank.tmpl');
	}else if(Search==$CP7['action']){
		BQ2();
		AJ9(CB3.'blank.tmpl');
	}else if(Search==$CP7['action']){
		BQ2();
		AJ9(CB3.'blank.tmpl');
	}else {
		BT5();
	}
	
} 



?>