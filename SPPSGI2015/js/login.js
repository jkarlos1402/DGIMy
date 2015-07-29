// JavaScript Document
function cierra(){
	var s = '';
		s = "s"+document.location;
	var out = s.split("=")	
	var ventana = window.self;
	if(out[1]){
		ventana.opener = window.self;
		ventana.close();	
	}
}

function login(year){
	var usu = document.FrmLog.TxtUsu.value;
	var pwd = document.FrmLog.TxtPwd.value ;

	var encypwd = hex_md5(pwd);

	var url ="#";
	if(year==2007){
		url = "http://148.215.1.4/sgc/pgs/LogIn.php?TxtUsu="+usu+'&TxtPwd='+encypwd;
	}else if(year==2008){
		url = "sgc2008/pgs/LogIn.php?TxtUsu="+usu+'&TxtPwd='+encypwd;	
	}else if(year==2009){
		url = "spp2009/contenido/LogIn.php?TxtUsu="+usu+'&TxtPwd='+encypwd;
	}else if(year==2010){
		url = "spp2010/contenido/LogIn.php?TxtUsu="+usu+'&TxtPwd='+encypwd;
	}else if(year==2011){
		url = "spp2011/contenido/LogIn.php?TxtUsu="+usu+'&TxtPwd='+encypwd;
	}
			
	//var mypage = 'pgs/login.php?TxtUsu='+usu+'&TxtPwd='+encypwd;
	var mypage = url;
	
	var myname = "index";
	var sc = 1;
	var r = 1;
	var st = 1;
	var w=800;
	var h=600;
	var winl = (screen.width)-8; 
	var wint = (screen.height)-80; 		
	
	var ventana = window.self;
	
	document.FrmLog.TxtUsu.value = '';
	document.FrmLog.TxtPwd.value = '';
	
	winprops = 'height='+wint+',width='+winl+',top=0,left=0,scrollbars='+sc+',resizable='+r+',status='+st+', fullscreen=0';		
//	win = window.open(mypage,"_blank", myname, winprops); 
	win = window.open(mypage,"", winprops); 
	if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

	if (ventana != win){
		ventana.opener = window.self;
//		document.location="index.html";
		ventana.close();		
	}

}

function A(e,t,l)
{
	var k=null;
	(e.keyCode) ? k=e.keyCode : k=e.which;
	
	if(k==13 && l==1) login();
	if(k==13) (!t) ? B() : t.focus();
}

function B()
{
	document.forms[0].submit();
	return true;
}