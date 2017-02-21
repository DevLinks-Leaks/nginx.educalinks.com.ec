
//inicio de proceso de actualizacion
var Monitor_timer=setInterval(function () {monitor_log()}, 120000);


function monitor_log( ){
	 	 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var cc='';
			cc=xmlhttp.responseText;
			if (cc > 0 ) load_ajax_get('tab4','index_tab4.php');
		}
	}
	xmlhttp.open("GET",'script_monitoreo.php?admin_moni_general_new_cc=' + document.getElementById('admin_moni_general_new_cc').value,true);	 
	xmlhttp.send();	
	
	
}	


