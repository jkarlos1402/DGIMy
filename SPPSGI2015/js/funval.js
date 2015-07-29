
function acceptNum(evt){
	var nav = window.event ? true : false;
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57 [45 -]
	var key = nav ? evt.which : evt.keyCode;
	//return (key == 45 || key == 46 || key == 8 || (key >= 48 && key <= 57));
	return (key == 45 || key == 46 || key == 8  ||  key == 13  (key >= 48 && key <= 57));
}

function acceptNumN(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav ? evt.which : evt.keyCode;	
	//return (key == 45 || key == 46 || key <= 8 || (key >= 48 && key <= 57));
	return (key == 45 || key == 46 || key <= 13 || (key >= 48 && key <= 57));
}

function envia(m,e)
{
	document.location= "index.php?M="+m+"&E="+e;					
}


function NumCheck(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  // backspace
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{2}$/
    return !(regexp.test(field.value))
  }
  // .
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  // other key
  return false

}

/*
	<input type="text" onkeypress="return NumCheck(event, this)"/>
*/