function cw_Process(){var cu="http://tag.contextweb.com/TAGPUBLISH/getad.aspx";var cp="503940";var ct="17397";var cf="160X600";var ca="VIEWAD";var cr="200";var cw="160";var ch="600";var cn="1";var cads="0";var _cwd=document;var _cww=window;var _cwu="undefined";var _cwn=navigator;var _cwl="cwl";cu+="?tagver=1";if(typeof(_cww.addEventListener)!=_cwu){_cww.addEventListener('beforeunload',CWLD,false);}else{_cww.attachEvent('onbeforeunload',CWLD);}writeAd();function writeAd(){if(typeof(cd)!=_cwu)cu+="&cd=1";if(_cwd.location==top.location){cu+="&if=0";}else{cu+="&if=1";}cu+="&ca="+ca;cu+="&cp="+cp;cu+="&ct="+ct;cu+="&cf="+CWE(cf);cu+="&cn="+cn;cu+="&cr="+cr;cu+="&cw="+cw;cu+="&ch="+ch;cu+="&cads="+cads;cu+="&rq="+CWL();cu+="&fldc="+fld();cu+="&dw="+visibleWidth();cu+="&cwu="+CWE(CWP());cu+="&mrnd="+Math.floor(Math.random()*100000000);if(typeof(crtc)!=_cwu){cu+="&crtc="+crtc;}if(typeof(crtg)!=_cwu){cu+="&crtg="+crtg;}if(typeof(crtr)!=_cwu){cu+="&crtr="+crtr;}if(typeof(crtuid)!=_cwu){cu+="&crtuid="+crtuid;}_cwd.writeln("<scr"+"ipt type=\"text/javascript\" src=\""+cu+"\"></scr"+"ipt>");};function fld(){try{if(_cww!=top)return ifrps();}catch(e){return-15;}try{var d="cw_td_"+Math.floor(Math.random()*100000000);_cwd.write("<div id=\""+d+"\" style=\"height:0;width:0;\"></div>");var e=_cwd.getElementById(d);var h= -10;try{h=gtpg(e);}catch(e){;}e.style.display="none";return h;}catch(e){return-11;}};function ifrps(){try{if(_cww.location.host!=top.location.host)return-12;}catch(e){return-13;}var t=tpele();if(typeof(t)=="number")return t;var f=top.document.getElementsByTagName("IFRAME");for(var i=0;i<f.length;i++){var l=f[i].contentWindow.location;if(l==t){return gtpg(f[i]);}}return-14;};function tpele(){try{var w=[];var c=_cww;while(true){w.push(c);if((c==top)||(c.parent==null))break;c=c.parent;}return w[w.length-2].location;}catch(e){return-15;}};function gtpg(o){var c=0;try{while(o!=null){c+=o.offsetTop;o=o.offsetParent;}}catch(e){return-16;}if(c<1)return-17;try{var a=0;var w=top.window;if(typeof w.innerHeight!='undefined'){a=w.innerHeight;}if(a<20){try{a=w.document.documentElement.clientHeight;}catch(e){;}}if(a<20){try{a=w.document.getElementsByTagName('body')[0].clientHeight;}catch(e){return-18}}if(a<20)return-19;return Math.floor(c/a);}catch(e){return-20;}};function CWL(){var c=_cwl;var l=cp+"_"+cf+"_"+ct;var n=_cwn;if(typeof(n[c])!=_cwu){if(!n[c][l])n[c][l]=1;else n[c][l]++;}else{n[c]=new Array();n[c][l]=1;}return n[c][l];};function CWE(uri){var st=escape(uri);st=st.replace(/\+/g,"%2B");st=st.replace(/\//g,"%2F");return st;};function CWLD(ev){var c=_cwl;for(x in _cwn[c]){_cwn[c][x]=0;}};function CWP(){var R='';var L='';var F='';var T=_cww;var d=_cwd;try{L=d.location;if(L==top.location){R=L;}else{while(true){R=T.document.location;if(T.document.referrer){F=T.document.referrer;}if(T==T.parent){break;}else if(T.document.referrer){R=F;}T=T.parent;}}if(R==''||R==null){if(F){R=F;}else{R=L;}}}catch(e){if(F&&''!=F){R=F;}else{if(R=='')R=L;}}return R;};function visibleWidth(){var w=0;try{if(!document.body){document.write('<div id="cwViz1" style="width:0px; height:0px; display:none; visibility:hidden;">o</div>');}if(self.innerHeight){w=self.innerWidth;}else if(document.documentElement&&document.documentElement.clientHeight){w=document.documentElement.clientWidth;}else if(document.body){w=document.body.clientWidth;}}catch(e){w= -1;}return w;}};cw_Process();