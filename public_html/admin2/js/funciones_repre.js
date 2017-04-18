// JavaScript Document
function valida_repre(repr_cedu,div,url){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var tipo_iden = document.getElementById('repr_tipo_iden');
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			if (xmlhttp.responseText=="OK"){
				$("#repr_cedula").css("border","solid 1px #eeeeee");
				$("#lbl_repr_cedula").css("color","#017eba");
				$("#repr_cedula").css("color","rgba(0, 0, 0, 0.7)");
				document.getElementById(div).innerHTML="<div class='form_element'><p>Para precargar la información del representante, haz clic <a style='cursor:pointer;'  onclick=carga_data_repre(document.getElementById('repr_cedula').value,document.getElementById('repr_tipo_iden').options[document.getElementById('repr_tipo_iden').selectedIndex].value,'script_repr.php','repre_data'); >aquí.</a></p></div><div class='form_element'></div><div id='repre_data'>&nbsp;</div>";
			}else{
				if(xmlhttp.responseText=="Cédula Correcta" || xmlhttp.responseText=="RUC Correcto" || xmlhttp.responseText=="Pasaporte"){
					document.getElementById(div).innerHTML="<div id='repre_data'>&nbsp;</div>";
					$("#repr_cedula").css("border","solid 1px #eeeeee");
					$("#lbl_repr_cedula").css("color","#017eba");
					$("#repr_cedula").css("color","rgba(0, 0, 0, 0.7)");
					carga_data_repre(document.getElementById('repr_cedula').value,tipo_iden.options[tipo_iden.selectedIndex].value,'script_repr.php','repre_data');
				}else{
					$("#repr_cedula").css("border","solid 1px red");
					$("#lbl_repr_cedula").css("color","red");
					$("#repr_cedula").css("color","red");
					document.getElementById(div).innerHTML="<div class='form_element'><p> <font color='red'> <b>Educalinks informa:</b> "+xmlhttp.responseText+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente.</font> </p></div><div class='form_element'></div>";
				}
			}
		}
	}
	var data="opc=vali_repr&repr_cedu="+repr_cedu+"&tipo_iden="+tipo_iden.options[tipo_iden.selectedIndex].value;		
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function repr_upd_princ(div,url,alum_codi,repr_cedu){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	var n = xmlhttp.responseText.length;
			if (n > 0)
			{	$.growl.notice({ title: "Educalinks informa:", message: 'Representante principal actualizado.' });
			}
			else
			{	$.growl.error({ title: "Educalinks informa:",message: "No se pudo realizar los cambios." });
			}
			load_list_repr('div_repr_list','script_repr.php','opc=repr_list&alum_codi='+alum_codi);
		}
	};
	var data="opc=upd_repr_princ&repr_cedu="+repr_cedu+"&alum_codi="+alum_codi;	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function repr_upd_princ_finan(div,url,alum_codi,repr_cedu){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	var n = xmlhttp.responseText.length;
			if (n > 0)
			{	$.growl.notice({ title: "Educalinks informa:", message: 'Representante financiero actualizado.' });
			}
			else
			{	$.growl.error({ title: "Educalinks informa:",message: "No se pudo realizar los cambios." });
			}
			load_list_repr('div_repr_list','script_repr.php','opc=repr_list&alum_codi='+alum_codi);
		}
	};
	var data="opc=upd_repr_princ_finan&repr_cedu="+repr_cedu+"&alum_codi="+alum_codi;	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}


function update_relative(div,url,alum_codi,repr_codi,idparentesco){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	var n = xmlhttp.responseText.length;
			if (n > 0)
			{	$.growl.notice({ title: "Educalinks informa:", message: 'Parentesco actualizado.' });
			}
			else
			{	$.growl.error({ title: "Educalinks informa:",message: "No se pudo realizar los cambios." });
			}
			load_list_repr('div_repr_list','script_repr.php','opc=repr_list&alum_codi='+alum_codi);
		}
	};
	var data="opc=update_relative&repr_codi="+repr_codi+"&alum_codi="+alum_codi+"&idparentesco="+idparentesco;	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function quitar_representado(url,alum_codi,repr_codi){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if(confirm("¿Está seguro que desea quitar a este alumno como representado?")){
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
				location.reload();
			}
		}
		var data="opc=remove_alum&repr_codi="+repr_codi+"&alum_codi="+alum_codi;	
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
function carga_data_repre(cedula,tipo_iden,url,div){
	document.getElementById(div).innerHTML='';
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
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			$("#repr_fech_promoc").datepicker();
			$("#repr_fech_naci").datepicker();
		}
	}
	var data="opc=carga_data_repre&repr_cedu="+cedula+"&tipo_iden="+tipo_iden;	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);
}

function load_ajax_add_repr(div,url){	
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (ValidarRepresentante())
	{	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'repr_add');
		data.append('repr_nomb', document.getElementById('repr_nomb').value);
		data.append('repr_apel', document.getElementById('repr_apel').value);
		data.append('repr_cedula', document.getElementById('repr_cedula').value);
		data.append('repr_tipo_iden', $('#repr_tipo_iden').val());
		data.append('repr_email', document.getElementById('repr_email').value);
		data.append('repr_telf', document.getElementById('repr_telf').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_domi', document.getElementById('repr_domi').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_profesion', document.getElementById('repr_profesion').value);
		data.append('repr_nacionalidad', document.getElementById('repr_nacionalidad').value);
		data.append('repr_lugar_trabajo', document.getElementById('repr_lugar_trabajo').value);
		data.append('repr_direc_trabajo', document.getElementById('repr_direc_trabajo').value);
		data.append('repr_telf_trab', document.getElementById('repr_telf_trab').value);
		data.append('repr_cargo', document.getElementById('repr_cargo').value);
		data.append('repr_religion', $('#idreligion').val());
		data.append('repr_estudios', document.getElementById('repr_estudios').value);
		data.append('repr_institucion', document.getElementById('repr_institucion').value);
		data.append('repr_motivo_representa', document.getElementById('repr_motivo_representa').value);
		data.append('repr_estado_civil', $('#idestadocivil').val());
		data.append('repr_escolaborador',$('#repr_escolaborador').prop('checked'));
		data.append('repr_fech_promoc', document.getElementById('repr_fech_promoc').value);
		data.append('repr_ex_alum',$('#repr_ex_alum').prop('checked') );
		data.append('repr_fech_naci', $('#repr_fech_naci').val());
		data.append('repr_pais_naci', $('#repr_pais_naci option:selected').text());
		data.append('repr_prov_naci', $('#repr_prov_naci option:selected').text());
		data.append('repr_ciud_naci', $('#repr_ciud_naci option:selected').text());
		data.append('identificacion_niv_1', ($('#identificacion_niv_1').val() > 0 ? $('#identificacion_niv_1').val() : ''));
        data.append('identificacion_niv_2', ($('#identificacion_niv_2').val() > 0 ? $('#identificacion_niv_2').val() : '') );
        data.append('identificacion_niv_3', ($('#identificacion_niv_3').val() > 0 ? $('#identificacion_niv_3').val() : '') );
		data.append('alum_codi', document.getElementById('alum_codi').value);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText=="OK"){
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del representante." });	
					var data_new="opc=repr_list&alum_codi="+document.getElementById('alum_codi').value;
					document.getElementById('repr_cedula').value='';
					document.getElementById('div_precargar').innerHTML='';
					load_list_repr(div,url,data_new);
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del representante." });	
				}
			}
		}
		
		xmlhttp.open("POST",url,true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_ajax_del_repr(div,url,data){	
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (confirm("¿Desea eliminar el representante?")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				if (xmlhttp.responseText > 0) {
					$.growl.notice({title: "Listo!", message: "Se eliminó correctamente los datos del representante."});
					var data_new = "opc=repr_list_gen";
					load_list_repr(div, 'alumnos_repre_main_lista.php', data_new);
				} else {
					$.growl.error({
						title: "Atención!",
						message: "Ocurrió un error al eliminar los datos del representante."
					});
					var data_new = "opc=repr_list&alum_codi=" + document.getElementById('alum_codi').value;
					load_list_repr(div, url, data_new);
				}
			}
		}

		xmlhttp.open("POST", url, true);
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_ajax_upd_repr(div,url,repr_codi){	
	if (ValidarRepresentante())
	{	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'repr_upd');
		data.append('repr_codi', repr_codi);
		data.append('repr_nomb', document.getElementById('repr_nomb').value);
		data.append('repr_apel', document.getElementById('repr_apel').value);
		data.append('repr_cedula', document.getElementById('repr_cedula').value);
		data.append('repr_tipo_iden', $('#repr_tipo_iden').val());
		data.append('repr_email', document.getElementById('repr_email').value);
		data.append('repr_telf', document.getElementById('repr_telf').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_domi', document.getElementById('repr_domi').value);
		data.append('repr_celular', document.getElementById('repr_celular').value);
		data.append('repr_profesion', document.getElementById('repr_profesion').value);
		data.append('repr_nacionalidad', document.getElementById('repr_nacionalidad').value);
		data.append('repr_lugar_trabajo', document.getElementById('repr_lugar_trabajo').value);
		data.append('repr_direc_trabajo', document.getElementById('repr_direc_trabajo').value);
		data.append('repr_telf_trab', document.getElementById('repr_telf_trab').value);
		data.append('repr_cargo', document.getElementById('repr_cargo').value);
		data.append('repr_religion', $('#idreligion').val());
		data.append('repr_estudios', document.getElementById('repr_estudios').value);
		data.append('repr_institucion', document.getElementById('repr_institucion').value);
		data.append('repr_motivo_representa', document.getElementById('repr_motivo_representa').value);
		data.append('repr_estado_civil', $('#idestadocivil').val());
		data.append('repr_escolaborador',$('#repr_escolaborador').prop('checked'));
		data.append('repr_fech_promoc', document.getElementById('repr_fech_promoc').value);
		data.append('repr_ex_alum',$('#repr_ex_alum').prop('checked') );
		data.append('repr_fech_naci', $('#repr_fech_naci').val());
		data.append('repr_pais_naci', $('#repr_pais_naci option:selected').text());
		data.append('repr_prov_naci', $('#repr_prov_naci option:selected').text());
		data.append('repr_ciud_naci', $('#repr_ciud_naci option:selected').text());
		data.append('alum_codi', document.getElementById('alum_codi').value);
		data.append('identificacion_niv_1', ($('#identificacion_niv_1').val() > 0 ? $('#identificacion_niv_1').val() : ''));
        data.append('identificacion_niv_2', ($('#identificacion_niv_2').val() > 0 ? $('#identificacion_niv_2').val() : ''));
        data.append('identificacion_niv_3', ($('#identificacion_niv_3').val() > 0 ? $('#identificacion_niv_3').val() : ''));
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText=="OK"){
					$.growl.notice({ title: "Listo!",message: "Se actualizaron correctamente los datos del representante." });	
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al actualizar los datos del representante." });	
				}
			}
		}
		xmlhttp.open("POST",url,true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_list_repr(div,url,data){	
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
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
			document.getElementById(div).innerHTML=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);
}
function ValidarRepresentante ()
{	if (document.getElementById('repr_nomb').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los nombres del representante" });	
		document.getElementById('repr_nomb').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('repr_nomb').style.border='';
	}
	if (document.getElementById('repr_apel').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los apellidos del representante" });	
		document.getElementById('repr_apel').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('repr_apel').style.border='';
	}
	if (document.getElementById('repr_email').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el correo electrónico del representante" });	
		document.getElementById('repr_email').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('repr_email').style.border='';
	}
	return true;
}
function CargarIdentNiv2(id){
	$('#identificacion_niv_3').empty();
	var data = "id="+id+"&opc=cargar_idenficacion_nivel_2";
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {	if (xmlhttp.readyState==4 && xmlhttp.status==200){
        	resp = JSON.parse(xmlhttp.responseText);
        	options = "<option value='-1'>Seleccione</option>";
			if (resp.res == "success")
			{	for (key in resp.data)
                options = options + "<option value='"+resp.data[key].id+"'>"+resp.data[key].nombre+"</option>";
                document.getElementById('identificacion_niv_2').innerHTML = options;
			}
        }
    }
    xmlhttp.open("POST","script_repr.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}
function CargarIdentNiv3(id){
    var data = "id="+id+"&opc=cargar_idenficacion_nivel_3";
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {	if (xmlhttp.readyState==4 && xmlhttp.status==200){
        resp = JSON.parse(xmlhttp.responseText);
        options = "<option value='-1'>Seleccione</option>";
        if (resp.res == "success")
        {	for (key in resp.data)
            options = options + "<option value='"+resp.data[key].id+"'>"+resp.data[key].nombre+"</option>";
            document.getElementById('identificacion_niv_3').innerHTML = options;
        }
    }
    }
    xmlhttp.open("POST","script_repr.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}