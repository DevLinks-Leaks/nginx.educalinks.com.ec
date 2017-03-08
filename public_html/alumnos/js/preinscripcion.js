function check_repr_finan(check){
	$('.check_finan').prop('checked',false);
	$(check).prop('checked',true);
}
function CargarBancosTarjetas (codigo)
{	
	if(codigo==22 || codigo==0){
		$('#alum_resp_tarj_banco_emisor').val('0');
		$('#alum_resp_tarj_banco_emisor').prop('disabled',true);
	}
	else
		$('#alum_resp_tarj_banco_emisor').prop('disabled',false);
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById('div_banco_tarjeta').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_banco_tarjeta.php?idpadre="+codigo, true);
	xmlhttp.send();
}
function CargarProvincias(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_provincia.php?codigo="+value, true);
	xmlhttp.send();
}
function CargarCiudades(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_ciudad.php?codigo="+value, true);
	xmlhttp.send();
}
function CargarParroquias(id,value)
{	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{	xmlhttp = new XMLHttpRequest ();
	}
	else
	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "select_parroquia.php?codigo="+value, true);
	xmlhttp.send();
}
function load_modal_preinscripcion_view(div,url,data){
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
			$("#repr_fech_promoc").datepicker();
			$("#repr_fech_naci").datepicker();
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function actualizar_representante(repr_codi)
{	
	if(comprobarObligatoriosRepre()){
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
		data.append('opc', 'repr_upd');
		data.append('repr_codi', repr_codi);
		data.append('repr_nomb', document.getElementById('repr_nomb').value);
		data.append('repr_apel', document.getElementById('repr_apel').value);
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
		data.append('repr_religion', $('#repr_religion').val());
		data.append('repr_estudios', document.getElementById('repr_estudios').value);
		data.append('repr_institucion', document.getElementById('repr_institucion').value);
		data.append('repr_motivo_representa', document.getElementById('repr_motivo_representa').value);
		data.append('repr_estado_civil', $('#repr_estado_civil').val());
		data.append('repr_escolaborador',$('#repr_escolaborador').prop('checked'));
		data.append('repr_fech_promoc', document.getElementById('repr_fech_promoc').value);
		data.append('repr_ex_alum',$('#repr_ex_alum').prop('checked') );
		data.append('repr_fech_naci', $('#repr_fech_naci').val());
		data.append('repr_pais_naci', $('#repr_pais_naci option:selected').text());
		data.append('repr_prov_naci', $('#repr_prov_naci option:selected').text());
		data.append('repr_ciud_naci', $('#repr_ciud_naci option:selected').text());

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					$('#btn_guardar_repr').button('reset');
					$('#modal_preinscripcion').modal('hide');
					
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_guardar_repr').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_preinscripcion.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function preinscribir_alumno()
{	
	if(comprobarObligatoriosAlum()){
		$('#btn_reservar').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'res_add');
		data.append('alum_nomb', document.getElementById('alum_nomb').value);
		data.append('alum_apel', document.getElementById('alum_apel').value);
		data.append('alum_fech_naci', document.getElementById('alum_fech_naci').value);
		data.append('alum_genero', $('.alum_genero:checked').val());
		data.append('alum_cedu', document.getElementById('alum_cedu').value);
		data.append('alum_tipo_iden', $('#alum_tipo_iden').val());
		data.append('alum_mail', document.getElementById('alum_mail').value);
		data.append('alum_celu', document.getElementById('alum_celu').value);
		data.append('alum_domi', document.getElementById('alum_domi').value);
		data.append('alum_telf', document.getElementById('alum_telf').value);
		data.append('alum_ciud', $('#alum_ciud option:selected').text());
		data.append('alum_parroquia', $('#alum_parroquia option:selected').text());
		data.append('alum_nacionalidad', $('#alum_nacionalidad').val());
		data.append('alum_religion', $('#alum_religion').val());
		data.append('alum_vive_con', $('#alum_vive_con').val());
		data.append('alum_parentesco_vive_con', $('#alum_parentesco_vive_con').val());
		data.append('alum_estado_civil_padres', $('#alum_estado_civil_padres').val());
		data.append('alum_movilizacion',$('#alum_movilizacion option:selected').text());
		data.append('alum_activ_deportiva', document.getElementById('alum_activ_deportiva').value);
		data.append('alum_activ_artistica',document.getElementById('alum_activ_artistica').value );
		data.append('alum_enfermedades', document.getElementById('alum_enfermedades').value);
		data.append('alum_telf_emerg', document.getElementById('alum_telf_emerg').value);
		data.append('alum_parentesco_emerg', $('#alum_parentesco_emerg').val());
		data.append('alum_pers_emerg', document.getElementById('alum_pers_emerg').value);
		data.append('alum_tipo_sangre', $('#alum_tipo_sangre').val());
		data.append('alum_resp_form_pago', $('#alum_resp_form_pago').val());
		data.append('alum_resp_form_banc_tarj', document.getElementById('alum_resp_form_banc_tarj').value);
		data.append('alum_resp_tarj_banco_emisor', document.getElementById('alum_resp_tarj_banco_emisor').value);
		data.append('alum_resp_form_banc_tarj_nume', document.getElementById('alum_resp_form_banc_tarj_nume').value);
		data.append('alum_resp_form_fech_vcto', document.getElementById('alum_resp_form_fech_vcto').value);
		data.append('alum_resp_form_banc_tipo', $('.alum_resp_form_banc_tipo:checked').val());
		data.append('alum_resp_form_cedu', document.getElementById('alum_resp_form_cedu').value);
		data.append('alum_resp_form_tipo_iden', $('#alum_resp_form_tipo_iden').val());
		data.append('alum_resp_form_nomb', document.getElementById('alum_resp_form_nomb').value);
		data.append('alum_pais',$('#alum_pais option:selected').text());
		data.append('alum_prov_naci', $('#alum_prov_naci option:selected').text());
		data.append('alum_ciud_naci', $('#alum_ciud_naci option:selected').text());
		data.append('alum_parr_naci', $('#alum_parr_naci option:selected').text());
		data.append('alum_sect_naci', $('#alum_sect_naci option:selected').text());
		data.append('alum_ex_plantel', $('#alum_ex_plantel').val());
		data.append('alum_ex_plantel_dire', $('#alum_ex_plantel_dire').val());
		data.append('alum_repr_finan', $('.check_finan:checked').attr('id'));

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					// $('#btn_reservar').button('reset');
					// $('#modal_preinscripcion').modal('hide');
					window.location.reload();
					
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_reservar').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_preinscripcion.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function comprobarObligatoriosRepre(){
	if ($('#repr_nomb').val().trim()=='')
	{	$('#repr_nomb').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_nomb').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_apel').val().trim()=='')
	{	$('#repr_apel').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_apel').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_email').val().trim()=='')
	{	$('#repr_email').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_email').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_telf').val().trim()=='')
	{	$('#repr_telf').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_telf').closest('.form-group').removeClass('has-error');
	}
	if ($('#repr_celular').val().trim()=='')
	{	$('#repr_celular').closest('.form-group').addClass('has-error');
		return false;
	}
	else
	{	$('#repr_celular').closest('.form-group').removeClass('has-error');
	}
	return true;
}
function comprobarObligatoriosAlum(){
	if ($('#alum_fech_naci').val().trim()=='')
	{	$('#alum_fech_naci').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingrese fecha de nacimiento del alumno.' });
		return false;
	}
	else
	{	$('#alum_fech_naci').closest('.form-group').removeClass('has-error');
	}
	if (document.getElementById('alum_cedu').value.trim()=='' && $('#alum_cedu').hasClass('required'))
	{	$('#alum_cedu').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingrese la cédula del alumno.' });
		return false;
	}else{
		var response = validarNI(document.getElementById('alum_cedu').value,document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
			$('#alum_cedu').closest('.form-group').removeClass('has-error');
		}else{
			$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar número de cédula o RUC correcto.' });
			$('#alum_cedu').closest('.form-group').addClass('has-error');
			return false;
		}
	}
	if ($('#alum_domi').val().trim()=='')
	{	$('#alum_domi').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_domi').closest('.form-group').removeClass('has-error');
	}
	if ($('#alum_ciud').val().trim()=='')
	{	$('#alum_ciud').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar ciudad domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_ciud').closest('.form-group').removeClass('has-error');
	}
	if ($('#alum_parroquia').val().trim()=='')
	{	$('#alum_parroquia').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar parroquia domicilio del alumno.' });
		return false;
	}
	else
	{	$('#alum_parroq').closest('.form-group').removeClass('has-error');
	}
	if ($('#alum_resp_form_banc_tarj_nume').val().trim()=='' && $('#alum_resp_form_banc_tarj_nume').hasClass('required'))
	{	$('#alum_resp_form_banc_tarj_nume').closest('.form-group').addClass('has-error');
		$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor ingresar número de tarjeta o cuenta de banco.' });
		return false;
	}else
	{	$('#alum_resp_form_banc_tarj_nume').closest('.form-group').removeClass('has-error');
	}
	if (document.getElementById('alum_resp_form_cedu').value.trim()=='')
	{	$('#alum_resp_form_cedu').closest('.form-group').addClass('has-error');
		return false;
	}else{
		var response = validarNI(document.getElementById('alum_resp_form_cedu').value,$('#alum_resp_form_tipo_iden').val());
		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
			$('#alum_resp_form_cedu').closest('.form-group').removeClass('has-error');
		}else{
			$('#alum_resp_form_cedu').closest('.form-group').addClass('has-error');
			return false;
		}
	}
	if (!document.getElementById('aceptar_terminos').checked)
	{	$.growl.error({
				title: 'Educalinks informa',
				message: 'Por favor acepte los términos.' });
		document.getElementById('aceptar_terminos').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('aceptar_terminos').style.border='';
	}
	return true;
}
// *JBZ*
function validarNI(strCedula,tipo_iden)
{	
	if (tipo_iden==3){
			return 'Pasaporte';
	}else if(isNumeric(strCedula))
	{	
		var total_caracteres=strCedula.length;// se suma el total de caracteres
		if(tipo_iden==1)
		{
			if(total_caracteres==10)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	// compruebo a que region pertenece esta cedula//
					var ult_digito=strCedula.substring( total_caracteres-1,total_caracteres);//extraigo el ultimo digito de la cedula
					//extraigo los valores pares//
					var valor2=parseInt(strCedula.charAt(1));
					var valor4=parseInt(strCedula.charAt(3));
					var valor6=parseInt(strCedula.charAt(5));
					var valor8=parseInt(strCedula.charAt(7));
					var suma_pares=(valor2 + valor4 + valor6 + valor8);
					//extraigo los valores impares//
					var valor1=parseInt(strCedula.charAt(0));
					valor1=(valor1 * 2);
					if(valor1>9){ valor1=(valor1 - 9); }else{ }
					var valor3=parseInt(strCedula.charAt(2));
					valor3=(valor3 * 2);
					if(valor3>9){ valor3=(valor3 - 9); }else{ }
					var valor5=parseInt(strCedula.charAt(4));
					valor5=(valor5 * 2);
					if(valor5>9){ valor5=(valor5 - 9); }else{ }
					var valor7=parseInt(strCedula.charAt(6));
					valor7=(valor7 * 2);
					if(valor7>9){ valor7=(valor7 - 9); }else{ }
					var valor9=parseInt(strCedula.charAt(8));
					valor9=(valor9 * 2);
					if(valor9>9){ valor9=(valor9 - 9); }else{ }

					var suma_impares=(valor1 + valor3 + valor5 + valor7 + valor9);
					var suma=(suma_pares + suma_impares);
					var temp=''+suma;
					var dis=parseInt(temp.charAt(0));//extraigo el primer numero de la suma
					var dis=((dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
					var digito=(dis - suma);
					if(digito==10){ digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
					if (digito==parseInt(ult_digito))
					{	//comparo los digitos final y ultimo
						return "Cédula Correcta";
					}
					else
					{	return "Cédula Incorrecta";
					}
				}else
				{	//echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
					return "Cédula Incorrecta";
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".total_caracteres."";

			}else //numero 10
			{	//echo "Es un Numero y tiene solo".total_caracteres;
				return "Cédula Incorrecta";
			}
		} else if (tipo_iden==2)
		{
			if(total_caracteres==13)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	
					var primeros_digitos;
					var array_coeficientes;
					var digito_verificador;
					var valor3 = strCedula.charAt(2);
					if(valor3>=0 && valor3<=5){ //Persona natural
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;

						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            if (valor_Posicion >= 10) {
				            	var valor_char = valor_Posicion.toString();
				                valor_char = valor_char.split("");
				                var temp=0;
				                valor_char.forEach(function(item){
				                	temp = temp + parseInt(item);
				                });
				                valor_Posicion = temp;
				            }
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 10;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 10 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==6){ // Entidad Publica
						primeros_digitos = strCedula.substring( 0, 8);
						array_coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(8));
						primeros_digitos = primeros_digitos.split("");


						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==9){ // Sociedad Privada
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});
				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else {
						return 'RUC Incorrecto';
					}	
				}else
				{	//echo "Este Nro de RUC no corresponde a ninguna provincia del ecuador";
					return 'RUC Incorrecto';
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

			}else //numero 10
			{	//return "Es un Numero y tiene solo".$total_caracteres;
				return 'RUC Incorrecto';
			}
		}
	}else
	{	return "Esta Cédula o RUC no corresponde a un Nro de Identidad de Ecuador";
		//return "Incorrecto"
	}
	
}
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}