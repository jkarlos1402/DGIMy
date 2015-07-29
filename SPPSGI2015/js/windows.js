function WindowRpt(url,t){			
	var mypage = url;	
	var myname = t;
	var sc = 1;
	var r = 1;
	var st = 0;
	var winl = (screen.width)-8; 
	var wint = (screen.height)-80; 			
	var subventana = window.self;
	
	winprops = 'height='+wint+',width='+winl+',top=0,left=0,scrollbars='+sc+',resizable='+r+',status='+st+',Location=0,fullscreen=0,channelmode=1';		
	win = window.open(mypage, myname, winprops); 
	if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }

	subventana.opener = window.self;
}

function NewWindow(mypage, myname, w, h, sc, r ,st) { 
		var winl = (screen.width - w) / 2; 
		var wint = (screen.height - h) / 2; 
    	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+sc+',resizable='+r+',status='+st+'';
		win = window.open(mypage, myname, winprops);
		if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}

//funcion ventana de mensajes
function PopItMsg(imsg,smsg){
		var img ="";
		if(imsg>9 && imsg<20) img = "ico_candado";
		if(imsg>99 && imsg<200) img = "ico_ok";  
		if(imsg>199 && imsg<300) img = "ico_error";  
		if(imsg>299 && imsg<400) img = "ico_question";  
		if(imsg>399 && imsg<500) img = "ico_admiracion";  
				
        var sBody = "<TITLE>Mensaje</TITLE><body marginwidth='0'><FORM>"
				+"	  <table width='100%' border='0' cellspacing='4' cellpadding='0'>"
				+"		<tr>"
				+"		<td height='1' colspan='3' bgcolor='#CCCCCC'><img src='../img/null.gif' width='1' height='1'></td>"
				+"	  </tr>"
				+"	  <tr>"
				+"	    <td width='100'><img src='../img/"+img+".png' border='0'></td>"
				+"		<td><font color='#006600' size='2' face='Arial, Helvetica, sans-serif'><b>"+smsg+"</b></font></td>"
				+"		<td  width='10'>&nbsp;</td>"
				+"	  </tr>"
				+"		<tr>"
				+"		<td height='1' colspan='3' bgcolor='#CCCCCC'><img src='../img/null.gif' width='1' height='1'></td>"
				+"	  </tr>"				
				+"	  <tr>"
				+"		<td>&nbsp;</td>"
				+"		<td><div align='center'>"
				+"			  <INPUT TYPE='BUTTON' VALUE='Aceptar' onClick='self.close()'>"
				+"			</div></td>"
				+"		<td>&nbsp;</td>"
				+"	  </tr>"
				+"	</table>"
				+"	</FORM></body>";		
		var w=310;
		var h=150;
		var winL = (screen.width - w) / 2; 
		var winT = (screen.height - h) / 2; 		
        popup = window.open('','Mensaje','height='+h+',width='+w+',top='+winT+',left='+winL+',resizable=0,toolbar=0,menubar=0,scrollbars=0,status=0')  	
        popup.document.write(sBody)  
        popup.document.close()
		popup.setTimeout("self.close()",2500); 								
}

function openInNewTab(URL) {
    var temporalForm = document.createElement('form');
    with (temporalForm) {
        setAttribute('method', 'GET');
        setAttribute('action', URL);
        setAttribute('target', '_blank');
    }

    var paramsString = URL.substring(URL.indexOf('?') + 1, URL.length);
    var paramsArray = paramsString.split('&');

    for (var i = 0; i < paramsArray.length; ++i) {
        var elementIndex = paramsArray[i].indexOf('=');
        var elementName = paramsArray[i].substring(0, elementIndex);
        var elementValue = paramsArray[i].substring(elementIndex + 1, paramsArray[i].length);
  
        var temporalElement = document.createElement('input');
        with(temporalElement) {
            setAttribute('type', 'hidden');
            setAttribute('name', elementName);
            setAttribute('value', elementValue);
        }
 
        temporalForm.appendChild(temporalElement);
    }
 
    document.body.appendChild(temporalForm);
    temporalForm.submit();
    document.body.removeChild(temporalForm);
}