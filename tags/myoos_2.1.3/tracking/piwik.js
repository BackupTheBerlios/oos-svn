/*
 * Piwik - Web Analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: piwik.js 1320 2009-07-23 03:30:43Z vipsoft $
 */
var Piwik,piwik_log,piwik_track;if(!this.Piwik){Piwik=(function(){var c,i={},e=document,d=navigator,g=screen,l=window,f=false,n=[];function m(p){return typeof p!=="undefined"}function h(p,r,q,s){if(p.addEventListener){p.addEventListener(r,q,s);return true}else{if(p.attachEvent){return p.attachEvent("on"+r,q)}}p["on"+r]=q}function k(r,t){var s="",q,p;for(q in i){p=i[q][r];if(typeof p==="function"){s+=p(t)}}return s}function b(p){if(m(c)){var q=new Date();while(q.getTime()<c){q=new Date()}}k("unload")}function o(q){if(!f){f=true;k("load");for(var p=0;p<n.length;p++){n[p]()}}return true}function a(){if(e.addEventListener){h(e,"DOMContentLoaded",function(){e.removeEventListener("DOMContentLoaded",arguments.callee,false);o()})}else{if(e.attachEvent){e.attachEvent("onreadystatechange",function(){if(e.readyState==="complete"){e.detachEvent("onreadystatechange",arguments.callee);
o()}});if(e.documentElement.doScroll&&l==l.top){(function(){if(f){return}try{e.documentElement.doScroll("left")}catch(p){setTimeout(arguments.callee,0);return}o()}())}}}h(l,"load",o,false)}function j(Q,B){var D=Q||"",Z=B||"",X="",K="7z|aac|arc|arj|asf|asx|avi|bin|csv|doc|exe|flv|gif|gz|gzip|hqx|jar|jpe?g|js|mp(2|3|4|e?g)|mov(ie)?|msi|msp|pdf|phps|png|ppt|qtm?|ra(m|r)?|sea|sit|tar|tgz|torrent|txt|wav|wma|wmv|wpd||xls|xml|z|zip",z=[l.location.hostname],T=[],w=[],t=[],C=500,N,R="0",v,O={pdf:["pdf","application/pdf","0"],quicktime:["qt","video/quicktime","0"],realplayer:["realp","audio/x-pn-realaudio-plugin","0"],wma:["wma","application/x-mplayer2","0"],director:["dir","application/x-director","0"],flash:["fla","application/x-shockwave-flash","0"],java:["java","application/x-java-vm","0"],gears:["gears","application/x-googlegears","0"],silverlight:["ag","application/x-silverlight","0"]},G=false,r=l.encodeURIComponent||escape,W=l.decodeURIComponent||unescape,Y=function(ac){var af=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,ad={"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"};
function aa(ag){af.lastIndex=0;return af.test(ag)?'"'+ag.replace(af,function(ah){var ai=ad[ah];return typeof ai==="string"?ai:"\\u"+("0000"+ah.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+ag+'"'}function ab(ag){return ag<10?"0"+ag:ag}function ae(ak,ai){var aj,ah,ag,al,am=ai[ak];if(am===null){return"null"}if(am&&typeof am==="object"&&typeof am.toJSON==="function"){am=am.toJSON(ak)}switch(typeof am){case"string":return aa(am);case"number":return isFinite(am)?String(am):"null";case"boolean":case"null":return String(am);case"object":al=[];if(am instanceof Array){for(aj=0;aj<am.length;aj++){al[aj]=ae(aj,am)||"null"}ag=al.length===0?"[]":"["+al.join(",")+"]";return ag}if(am instanceof Date){return aa(am.getUTCFullYear()+"-"+ab(am.getUTCMonth()+1)+"-"+ab(am.getUTCDate())+"T"+ab(am.getUTCHours())+":"+ab(am.getUTCMinutes())+":"+ab(am.getUTCSeconds())+"Z")}for(ah in am){ag=ae(ah,am);if(ag){al[al.length]=aa(ah)+":"+ag}}ag=al.length===0?"{}":"{"+al.join(",")+"}";return ag}}return ae("",{"":ac})},u={};
function y(af,ad,ab,ae,aa,ag){var ac;if(ab){ac=new Date();ac.setTime(ac.getTime()+ab*86400000)}e.cookie=af+"="+r(ad)+(ab?";expires="+ac.toGMTString():"")+";path="+(ae?ae:"/")+(aa?";domain="+aa:"")+(ag?";secure":"")}function s(ae,ad,aa){var ab=new RegExp("(^|;)[ ]*"+ae+"=([^;]*)"+(ad?"(;[ ]*expires=[^;]*)?;[ ]*path="+ad.replace("/","\\/")+"":"")+(aa?";[ ]*domain="+aa+"(;|$)":"")),ac=ab.exec(e.cookie);return ac?W(ac[2]):0}function p(ac,ab){var aa=new Date(),ad=new Image(1,1);c=aa.getTime()+ab;ad.onLoad=function(){};ad.src=ac}function x(){var aa,ab;if(typeof d.javaEnabled!=="undefined"&&d.javaEnabled()){O.java[2]="1"}if(typeof l.GearsFactory==="function"){O.gears[2]="1"}if(d.mimeTypes&&d.mimeTypes.length){for(aa in O){ab=d.mimeTypes[O[aa][1]];if(ab&&ab.enabledPlugin){O[aa][2]="1"}}}}function J(){var aa="";try{aa=top.document.referrer}catch(ac){if(parent){try{aa=parent.document.referrer}catch(ab){aa=""}}}if(aa===""){aa=e.referrer}return aa}function E(){var aa="_pk_testcookie";if(!m(d.cookieEnabled)){y(aa,"1");
return s(aa)=="1"?"1":"0"}return d.cookieEnabled?"1":"0"}function I(){var ab,aa,ac;aa=new Date();ac="idsite="+Z+"&url="+r(e.location.href)+"&res="+g.width+"x"+g.height+"&h="+aa.getHours()+"&m="+aa.getMinutes()+"&s="+aa.getSeconds()+"&cookie="+R+"&urlref="+r(v)+"&rand="+Math.random();for(ab in O){ac+="&"+O[ab][0]+"="+O[ab][2]}ac=D+"?"+ac;return ac}function P(){var aa=I();aa+="&action_name="+r(X);if(m(N)){aa+="&data="+r(Y(N))}aa+=k("log");p(aa,C)}function V(aa,ad,ac){var ab=I();ab+="&idgoal="+aa;if(m(ad)&&ad!==null){ab+="&revenue="+ad}if(m(ac)){if(ac!==null){ab+="&data="+r(Y(ac))}}else{if(m(N)){ab+="&data="+r(Y(N))}}ab+=k("goal");p(ab,C)}function A(ab,aa,ad){var ac;ac="idsite="+Z+"&"+aa+"="+r(ab)+"&rand="+Math.random()+"&redirect=0";if(m(ad)){if(ad!==null){ac+="&data="+r(Y(ad))}}else{if(m(N)){ac+="&data="+r(Y(N))}}ac+=k("click");ac=D+"?"+ac;p(ac,C)}function L(ac){var ab,aa,ad;for(ab=0;ab<z.length;ab++){aa=z[ab];if(ac==aa){return true}if(aa.substr(0,2)=="*."){if((ac)==aa.substr(2)){return true
}ad=ac.length-aa.length+1;if((ad>0)&&(ac.substr(ad)==aa.substr(1))){return true}}}return false}function M(aa,ac){var ab,ad="(^| )(piwik_"+ac;if(m(aa)){for(ab=0;ab<aa.length;ab++){ad+="|"+aa[ab]}}ad+=")( |$)";return new RegExp(ad)}function q(ac,ab,aa){if(!aa){return"link"}var ad=M(w,"download"),ae=M(t,"link"),af=new RegExp("\\.("+K+")$","i");return ae.test(ac)?"link":(ad.test(ac)||af.test(ab)?"download":0)}function F(ag){var ae,ah,ai,aa;if(!m(ag)){ag=l.event}if(m(ag.target)){ae=ag.target}else{if(m(ag.srcElement)){ae=ag.srcElement}else{return}}while((ah=ae.parentNode)&&((ai=ae.tagName)!="A"&&ai!="AREA")){ae=ah}if(m(ae.href)){var ac=ae.hostname,ad=ac.toLowerCase(),af=ae.href.replace(ac,ad),ab=/^(javascript|vbscript|jscript|mocha|livescript|ecmascript): */i;if(!ab.test(af)){aa=q(ae.className,af,L(ad));if(aa){A(af,aa)}}}}function U(aa){h(aa,"click",F,false)}function H(){if(!G){G=true;var ab,aa=M(T,"ignore"),ac=e.links;if(ac){for(ab=0;ab<ac.length;ab++){if(!aa.test(ac[ab].className)){U(ac[ab])
}}}}}function S(aa,ac){var ab=null;if(typeof aa=="string"&&!m(u[aa])){if(typeof ac=="object"){ab=ac}else{if(typeof ac=="string"){try{eval("hookObj ="+ac)}catch(ad){}}}u[aa]=ab}return ab}v=J();R=E();x();k("run",S);return{hook:u,getHook:function(aa){return u[aa]},setTrackerUrl:function(aa){if(m(aa)){D=aa}},setSiteId:function(aa){if(m(aa)){Z=aa}},setCustomData:function(aa){if(m(aa)){N=aa}},setLinkTrackingTimer:function(aa){if(m(aa)){C=aa}},setDownloadExtensions:function(aa){if(m(aa)){K=aa}},addDownloadExtensions:function(aa){if(m(aa)){K+="|"+aa}},setDomains:function(aa){if(typeof aa=="object"&&aa instanceof Array){z=aa;z[z.length]=l.location.hostname}else{if(typeof aa=="string"){z=[aa,l.location.hostname]}}},setIgnoreClasses:function(aa){if(typeof aa=="object"&&aa instanceof Array){T=aa}else{if(typeof aa=="string"){T=[aa]}}},setDocumentTitle:function(aa){if(m(aa)){X=aa}},setDownloadClasses:function(aa){if(typeof aa=="object"&&aa instanceof Array){w=aa}else{if(typeof aa=="string"){w=[aa]
}}},setDownloadClass:function(aa){if(typeof aa=="string"){w=[aa]}},setLinkClasses:function(aa){if(typeof aa=="object"&&aa instanceof Array){t=aa}else{if(typeof aa=="string"){t=[aa]}}},setLinkClass:function(aa){if(typeof aa=="string"){t=[aa]}},addListener:function(aa){if(m(aa)){U(aa)}},enableLinkTracking:function(){if(f){H()}else{n[n.length]=function(){H()}}},trackGoal:function(aa,ac,ab){V(aa,ac,ab)},trackLink:function(ab,aa,ac){A(ab,aa,ac)},trackPageView:function(){P()}}}h(l,"beforeunload",b,false);a();return{addPlugin:function(p,q){i[p]=q},getTracker:function(p,q){return new j(p,q)}}}());piwik_log=function(c,f,a,e){function b(g){try{return eval("piwik_"+g)}catch(h){}return}var d=Piwik.getTracker(a,f);d.setDocumentTitle(c);d.setCustomData(e);d.setLinkTrackingTimer(b("tracker_pause"));d.setDownloadExtensions(b("download_extensions"));d.setDomains(b("hosts_alias"));d.setIgnoreClasses(b("ignore_classes"));d.trackPageView();if(b("install_tracker")!==false){piwik_track=function(i,j,h,g){d.setSiteId(j);
d.setTrackerUrl(h);d.trackLink(i,g)};d.enableLinkTracking()}}};