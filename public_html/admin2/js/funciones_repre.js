// JavaScript Document
function inicializar_radioBtn(){
	$('input').iCheck({
	    checkboxClass: 'icheckbox_flat-blue',
	    radioClass: 'iradio_flat-blue'
  	});
	$('.principal').on('ifChecked', function(event){
		if($(this).is(':checked')){
			var repr_codi=$(this).data('reprcodi');
		    repr_upd_princ('div_repr_list','script_repr.php',document.getElementById('hd_alum_codi').value,repr_codi);
		}
	});
	$('.financiero').on('ifChecked', function(event){
		if($(this).is(':checked')){
			var repr_codi=$(this).data('reprcodi');
		    repr_upd_princ_finan('div_repr_list','script_repr.php',document.getElementById('hd_alum_codi').value,repr_codi);
		}
	});
	
}
function repre_exist_edit(div,url){
	document.getElementById(div).innerHTML='';
	if($('#hd_repr_cedula').val()!=$('#repr_cedula').val()){
		
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
					//La identificación ya se encuentra registrada
					$('#btn_guardar_repr').attr('disabled',true);
					
					document.getElementById(div).innerHTML=
					'<div class="alert alert-warning alert-dismissible col-md-10 col-md-offset-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Alerta!</h4><p id="alert_repr_content">El <b>número de identificación</b> ingresado ya se encuentra registrado.<br/>Para agregar representantes ya registrados realizarlo desde la opción "<span class="fa fa-plus"></span> Representante".</p></div>';
					// document.getElementById(div).innerHTML='<span class="fa fa-exclamation-triangle"></span> El <b>número de identificación</b> ingresado ya se encuentra registrado.<br/>Para agregar representantes ya registrados realizarlo desde la opción "<span class="fa fa-plus"></span> Representante".';
				}else{
					$('#btn_guardar_repr').attr('disabled',false);
					if(xmlhttp.responseText=="Cédula Correcta" || xmlhttp.responseText=="RUC Correcto" || xmlhttp.responseText=="Pasaporte"){
						//La identificación no se encuentra registrada pero es correcto el formato
						$('#btn_guardar_repr').attr('disabled',false);
					}else{
						$('#btn_guardar_repr').attr('disabled',true);
						document.getElementById(div).innerHTML=
					'<div class="alert alert-danger alert-dismissible col-md-10 col-md-offset-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alerta!</h4><p id="alert_repr_content">El <b>número de identificación</b> ingresado es incorrecto.</p></div>';
						//La identificación no se encuentra registrada y es incorrecto el formato
					}
				}
			}
		}
		var data="opc=vali_repr&repr_cedu="+$('#repr_cedula').val()+"&tipo_iden="+$('#repr_tipo_iden').val();		
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_modal_repre_view(div,url,data){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
			document.getElementById('repr_cedula').focus();
			$("#repr_fech_promoc").datepicker();
			$("#repr_fech_naci").datepicker();
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_modal_content(div,url,repr_codi){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
			document.getElementById('hd_repr_codi').value=repr_codi;
			$("#repr_fech_promoc").datepicker();
			$("#repr_fech_naci").datepicker();
		}
	}
	var data="repr_codi="+repr_codi;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function reset(){
	$('#repr_cedula').attr('disabled',false);
	$('#repr_tipo_iden').attr('disabled',false);
	$('#repr_cedula').val('');
	$('#repr_tipo_iden').val($('#repr_tipo_iden option:first').val());
	document.getElementById('alert_repr').innerHTML='';
	load_modal_content('repr-tab-content','representantes_add_modal_content.php',-1);
}
function valida_repre(repr_cedu,div,url){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	// document.getElementById(div).innerHTML='';
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
			var resp = JSON.parse(xmlhttp.responseText);
			if (resp.state=="OK"){
				$('#repr_cedula').closest('.form-group').removeClass('has-error');
				load_modal_content(div,'representantes_add_modal_content.php',resp.result);
				document.getElementById('alert_repr').innerHTML=
					'<div class="alert alert-info alert-dismissible col-md-10 col-md-offset-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-info"></i> Información</h4><p id="alert_repr_content">Se han cargado los datos del representante de acuerdo a número de identificación.</p></div>';
				$('#btn_guardar_repr').attr('disabled',false);
				$('#repr_cedula').attr('disabled',true);
				$('#repr_tipo_iden').attr('disabled',true);
				load_ajax_blacklist_warning_repr('div_blacklist_warning_repr','script_alumnos_blacklist.php','warning_blacklist' );
			}else if (resp.state=="NO"){
				var response = validarNI(repr_cedu,$('#repr_tipo_iden').val());
		        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
		            $('#repr_cedula').closest('.form-group').removeClass('has-error');
		            load_modal_content(div,'representantes_add_modal_content.php',0);
		            document.getElementById('alert_repr').innerHTML='';
		            $('#btn_guardar_repr').attr('disabled',false);
		            load_ajax_blacklist_warning_repr('div_blacklist_warning_repr','script_alumnos_blacklist.php','warning_blacklist' );
		        }else{
		        	$('#repr_cedula').closest('.form-group').addClass('has-error');
					load_modal_content(div,'representantes_add_modal_content.php',-1);
					document.getElementById('alert_repr').innerHTML=
					'<div class="alert alert-danger alert-dismissible col-md-10 col-md-offset-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alerta!</h4><p id="alert_repr_content">El <b>número de identificación</b> ingresado es incorrecto.</p></div>';
					$('#btn_guardar_repr').attr('disabled',true);
				}
			}
		}
	}
	var data="opc=repr_search&repr_cedu="+repr_cedu+"&tipo_iden="+$('#repr_tipo_iden').val();	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function repr_upd_princ(div,url,alum_codi,repr_codi){
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
			load_list_repr('div_repr_list','representantes_add_script.php','alum_codi='+alum_codi);
		}
	};
	var data="opc=upd_repr_princ&repr_codi="+repr_codi+"&alum_codi="+alum_codi;	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function repr_upd_princ_finan(div,url,alum_codi,repr_codi){
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
			load_list_repr('div_repr_list','representantes_add_script.php','alum_codi='+alum_codi);
		}
	};
	var data="opc=upd_repr_princ_finan&repr_codi="+repr_codi+"&alum_codi="+alum_codi;	
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
			load_list_repr('div_repr_list','representantes_add_script.php','alum_codi='+alum_codi);
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
		data.append('repr_lugar_trabajo', document.getElement4183ById('repr_lugar_trabajo').value);
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
					js_alumnos_repr_main_search(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value);
					// load_list_repr(div, 'alumnos_repre_main_lista.php', data_new);
				} else {
					$.growl.error({
						title: "Atención!",
						message: "Ocurrió un error al eliminar los datos del representante."
					});
					var data_new = "opc=repr_list&alum_codi=" + document.getElementById('alum_codi').value;
					// load_list_repr(div, url, data_new);
				}
			}
		}

		xmlhttp.open("POST", url, true);
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_ajax_upd_repr(url,flag){	
	if (ValidarRepresentante())
	{	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		$('#btn_guardar_repr').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		var repr_codi =document.getElementById('hd_repr_codi').value;
		
		data.append('opc', 'repr_add');
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
		data.append('alum_codi', (document.getElementById('hd_alum_codi')==null ? '' : document.getElementById('hd_alum_codi').value));
		data.append('identificacion_niv_1', ($('#identificacion_niv_1').val() > 0 ? $('#identificacion_niv_1').val() : ''));
        data.append('identificacion_niv_2', ($('#identificacion_niv_2').val() > 0 ? $('#identificacion_niv_2').val() : ''));
        data.append('identificacion_niv_3', ($('#identificacion_niv_3').val() > 0 ? $('#identificacion_niv_3').val() : ''));
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText=="OK"){
					$.growl.notice({ title: "Listo!",message: "Se actualizaron correctamente los datos del representante." });	
					$('#btn_guardar_repr').button('reset');
					$('#modal_representante_edit').modal('hide');
					if(flag==0)
						load_list_repr('div_repr_list','representantes_add_script.php','alum_codi='+document.getElementById('hd_alum_codi').value);
					else
						js_alumnos_repr_main_search(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value);
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al actualizar los datos del representante." });	
					$('#btn_guardar_repr').button('reset');
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
			inicializar_radioBtn();
		}
	}
	
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);
}
function ValidarRepresentante ()
{	if (document.getElementById('repr_cedula').value.trim() == ''){
        $('#repr_cedula').closest('.form-group').addClass('has-error');
        $.growl.error({ title: 'Educalinks informa', message: 'Por favor ingrese la cédula del alumno.' });
        document.getElementById('repr_cedula').focus();
        return false;
    }
    else if (document.getElementById('repr_cedula').value.trim() != '')
    {
        response = validarNI(document.getElementById('repr_cedula').value,document.getElementById('repr_tipo_iden').options[document.getElementById('repr_tipo_iden').selectedIndex].value);
        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" )
        {   $('#repr_cedula').closest('.form-group').removeClass('has-error');
        }
        else
        {   $.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
            $('#repr_cedula').closest('.form-group').addClass('has-error');
            document.getElementById('repr_cedula').focus();
            return false;
        }
    }
	if (document.getElementById('repr_nomb').value.trim()=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los nombres del representante" });	
		$('#repr_nomb').closest('.form-group').addClass('has-error');
		$('#repr_nomb').focus();
        $('#tabs a[href="#tab1"]').tab('show');
		return false;
	}
	else
	{	$('#repr_nomb').closest('.form-group').removeClass('has-error');
	}
	if (document.getElementById('repr_apel').value.trim()=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los apellidos del representante" });	
		$('#repr_apel').closest('.form-group').addClass('has-error');
		$('#repr_apel').focus();
        $('#tabs a[href="#tab1"]').tab('show');
		return false;
	}
	else
	{	$('#repr_apel').closest('.form-group').removeClass('has-error');
	}
	if (document.getElementById('repr_email').value.trim()=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el correo electrónico del representante" });	
		$('#repr_email').closest('.form-group').addClass('has-error');
		$('#repr_email').focus();
        $('#tabs a[href="#tab2"]').tab('show');
		return false;
	}
	else
	{	$('#repr_email').closest('.form-group').removeClass('has-error');
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