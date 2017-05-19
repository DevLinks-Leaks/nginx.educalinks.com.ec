function ValidarDatos(direc)
{	
	if(document.getElementById('alum_foto')!=null){
		if (document.getElementById('alum_foto').value.trim()=='')
		{	$.growl.error({
					title: 'Educalinks informa',
					message: 'Por favor ingrese la foto de su representado.' });
			$('#alum_foto').closest('.form-group').addClass('has-error');
			document.getElementById('alum_foto').focus();
	        $('#tabs a[href="#tab2"]').tab('show');
			return false;
		}
		else
		{	$('#alum_foto').closest('.form-group').removeClass('has-error');
		}
	}
	// if (document.getElementById('alum_fech_naci').value.trim()=='')
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor ingrese la fecha de nacimiento de su representado.' });
	// 	$('#alum_fech_naci').closest('.form-group').addClass('has-error');
	// 	document.getElementById('alum_fech_naci').focus();
 //        $('#tabs a[href="#tab1"]').tab('show');
	// 	return false;
	// }
	// else
	// {	$('#alum_fech_naci').closest('.form-group').removeClass('has-error');
	// }
	// if(direc!='arcoiris'){
	// 	if (document.getElementById('alum_cedu').value.trim()=='')
	// 	{	$.growl.error({
	// 				title: 'Educalinks informa',
	// 				message: 'Por favor ingrese el número de cédula de su representado.' });
	// 		$('#alum_cedu').closest('.form-group').addClass('has-error');
	// 		document.getElementById('alum_cedu').focus();
 //        	$('#tabs a[href="#tab1"]').tab('show');
	// 		return false;
	// 	}else{
	// 		var response = validarNI(document.getElementById('alum_cedu').value,document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
	// 		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
	// 			$('#alum_cedu').closest('.form-group').removeClass('has-error');
	// 		}else{
	// 			$.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
	// 			$('#alum_cedu').closest('.form-group').addClass('has-error');
	// 			document.getElementById('alum_cedu').focus();
 //        		$('#tabs a[href="#tab1"]').tab('show');
	// 			return false;
	// 		}
	// 	}
	// }
	// if (document.getElementById('alum_domi').value.trim()=='')
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor ingrese la dirección domiciliaria de su representado.' });
	// 	$('#alum_domi').closest('.form-group').addClass('has-error');
	// 	document.getElementById('alum_domi').focus();
	// 	$('#tabs a[href="#tab1"]').tab('show');
	// 	return false;
	// }
	// else
	// {	$('#alum_domi').closest('.form-group').removeClass('has-error');
	// }
	// if (document.getElementById('alum_ciud').value.trim()=='')
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor ingrese la ciudad donde vive su representado.' });
	// 	$('#alum_ciud').closest('.form-group').addClass('has-error');
	// 	document.getElementById('alum_ciud').focus();
	// 	$('#tabs a[href="#tab1"]').tab('show');
	// 	return false;
	// }
	// else
	// {	$('#alum_ciud').closest('.form-group').removeClass('has-error');
	// }
	// if (document.getElementById('alum_parroquia').value.trim()=='')
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor ingrese la parroquia donde vive su representado.' });
	// 	$('#alum_parroquia').closest('.form-group').addClass('has-error');
	// 	document.getElementById('alum_parroquia').focus();
	// 	$('#tabs a[href="#tab1"]').tab('show');
	// 	return false;
	// }
	// else
	// {	$('#alum_parroquia').closest('.form-group').removeClass('has-error');
	// }
	// if(direc!='arcoiris'){
	// 	if (document.getElementById('alum_tipo_sangre').value=='')
	// 	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el tipo de sangre del estudiante." });
	// 		$('#alum_tipo_sangre').closest('.form-group').addClass('has-error');
	// 		document.getElementById('alum_tipo_sangre').focus();
	// 		$('#tabs a[href="#tab1"]').tab('show');
	// 		return false;
	// 	}
	// 	else
	// 	{	$('#alum_tipo_sangre').closest('.form-group').removeClass('has-error');
	// 	}
	// }
	
	// if ( document.getElementById('hd_ha_actualizado_medic').value == 0 )
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor llene la ficha médica.' });
	// 	$('#tabs a[href="#tab3"]').tab('show');
	// 	return false;
	// }
	// if (!document.getElementById('aceptar_terminos').checked)
	// {	$.growl.error({
	// 			title: 'Educalinks informa',
	// 			message: 'Por favor acepte los términos.' });
	// 	document.getElementById('aceptar_terminos').style.border='solid 1px red';
	// 	return false;
	// }
	// else
	// {	document.getElementById('aceptar_terminos').style.border='';
	// }
	return true;
}
function actualizar_datos()
{	
	if(ValidarDatos()){
		$('#btn_actualizar').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var archivo = document.getElementById('alum_foto');
		if (archivo!=null)
			var alum_foto = archivo.files[0];
		else
			var alum_foto='';

		var data = new FormData();
		data.append('opc', 'alum_upd');
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
		data.append('alum_ciud', ($('#alum_ciud').val()=='' ? '' : $('#alum_ciud option:selected').text()));
		data.append('alum_parroq', ($('#alum_parroquia').val()=='' ? '' : $('#alum_parroquia option:selected').text()));
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
		data.append('alum_pais',($('alum_pais').val()=='' ? '' : $('#alum_pais option:selected').text()));
		data.append('alum_prov_naci', ($('#alum_prov_naci').val()=='' ? '' : $('#alum_prov_naci option:selected').text()));
		data.append('alum_ciud_naci', ($('#alum_ciud_naci').val()=='' ? '' : $('#alum_ciud_naci option:selected').text()));
		data.append('alum_parr_naci', ($('#alum_parr_naci').val()=='' ? '' : $('#alum_parr_naci option:selected').text()));
		data.append('alum_sect_naci', $('#alum_sect_naci option:selected').text());
		data.append('alum_ex_plantel', $('#alum_ex_plantel').val());
		data.append('alum_ex_plantel_dire', $('#alum_ex_plantel_dire').val());
		data.append('alum_etnia', document.getElementById('alum_etnia').value );
		data.append('alum_prov', ($('#alum_prov').val()=='' ? '' : $('#alum_prov option:selected').text()));
		data.append('alum_foto', alum_foto);
		data.append('alum_tiene_seguro', document.getElementById('alum_tiene_seguro').checked);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					$('#btn_actualizar').button('reset');
					// $('#modal_preinscripcion').modal('hide');
					// window.location.reload();
					window.open('index.php','_self')
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_actualizar').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_actualizacion_datos.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function js_actualizacion_datos_openfichamedica(  )
{   /*En esta función lo que se hace primero es guardar una ficha médica en blanco, y luego, se hace un submit
      a la página de ficha médica cargando los datos en blanco de esa ficha médica recientemente creada.*/
	var perX = 'fmex';
	var data = new FormData( );
	var tipo_persona = 1;
	data.append( 'event' , 'set_ficha_med_especifico' );
	data.append( 'perX' , perX );
	data.append( perX + '_fmex_codi' , '' );
	data.append( perX + '_per_codi' , document.getElementById( 'hd_alum_codi' ).value );
	var t = document.getElementById( 'hd_alum_codi' ).value;
	data.append( perX + '_tipo' , tipo_persona );
	data.append( perX + '_rdb_tipo_ficha' , 'UPD' );
	
	var xhr = new XMLHttpRequest();
    xhr.open('POST' , '/modulos/medic/ficha_nuevo/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   $.growl({
				title: 'Educalinks informa',
				message: obj['MENSAJE'] });
				var fmex_codi = obj['fmex_codi'];
				var url = '/alumnos/actualizacion_datos/';
				var f = document.createElement('form');
				f.action = url;
				f.method = 'POST';
				var i = document.createElement( 'input' );
				i.type = 'hidden';
				i.name = 'event';
				i.id = 'evento';
				i.value = 'MAIN';
				f.appendChild(i);
				var j = document.createElement( 'input' );
				j.type = 'hidden';
				j.name = 'fmex_codi';
				j.id = 'fmex_codi';
				j.value = fmex_codi;
				f.appendChild(j);
				document.body.appendChild(f);
				f.submit();
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema al obtener respuesta del sistema. Por favor, intente en unos minutos." });
            }
        }
    };
    xhr.send(data);
}
function js_actualizacion_datos_openfichamedica_editar( fmex_codi )
{   var url = '/alumnos/actualizacion_datos/';
	var f = document.createElement('form');
	f.action = url;
	f.method = 'POST';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'event';
	i.id = 'evento';
	i.value = 'MAIN';
	f.appendChild(i);
	var j = document.createElement( 'input' );
	j.type = 'hidden';
	j.name = 'fmex_codi';
	j.id = 'fmex_codi';
	j.value = fmex_codi;
	f.appendChild(j);
	document.body.appendChild(f);
	f.submit();
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