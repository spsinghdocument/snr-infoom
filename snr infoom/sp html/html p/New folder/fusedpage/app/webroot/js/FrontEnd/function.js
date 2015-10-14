function clearText(thefield) {
  if (thefield.defaultValue==thefield.value) { thefield.value = "" }
} 
function replaceText(thefield) {
  if (thefield.value=="") { thefield.value = thefield.defaultValue }
}

function ShowHomeTab(tabopen,cl) 
{
	i=1;
	
	while (document.getElementById("pulic_"+i))
	 {
	 document.getElementById("pulic_"+i).style.display='none';
	 document.getElementById("a"+i).className='';
	 i++;	 
	 }
	 document.getElementById(tabopen).style.display='block';
	 document.getElementById(cl).className='sel';
}



function ShowHomeTabin(tabopen,cl) 
{
	i=1;
	
	while (document.getElementById("pulicone_"+i))
	 {
	 document.getElementById("pulicone_"+i).style.display='none';
	 document.getElementById("b"+i).className='';
	 i++;	 
	 }
	 document.getElementById(tabopen).style.display='block';
	 document.getElementById(cl).className='select';
}











