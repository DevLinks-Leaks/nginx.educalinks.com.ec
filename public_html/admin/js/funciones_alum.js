// $('#repr_fech_naci').inputmask({mask: "99/99/9999"});

function activar_boton(value){
    var deuda = (document.getElementById('total_deuda')==null ? 0 : document.getElementById('total_deuda').value);
    var bloqueo_hard = document.getElementById('bloqueo_hard').value;
    if ( value === 0 || deuda>0 || bloqueo_hard > 0 )
        $('#btn_aplicar').prop('disabled', true);
    else
        $('#btn_aplicar').prop('disabled', false);
}
function load_ajax_esta_codi( div, url, data )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var bloqueo_hard = document.getElementById('bloqueo_hard').value;
    if ( bloqueo_hard > 0 )
        $('#btn_aplicar').prop('disabled', true);
    else
        $('#btn_aplicar').prop('disabled', false);
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange=function()
    {   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
        {   document.getElementById( div ).innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.send(data);
}
function CargarProvincias(id,value)
{   
    var xmlhttp;
    if (window.XMLHttpRequest)
    {   xmlhttp = new XMLHttpRequest ();
    }
    else
    {   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function ()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   document.getElementById(id).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "select_provincia.php?codigo="+value, true);
    xmlhttp.send();
}
function CargarCiudades(id,value)
{   
    var xmlhttp;
    if (window.XMLHttpRequest)
    {   xmlhttp = new XMLHttpRequest ();
    }
    else
    {   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function ()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   document.getElementById(id).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "select_ciudad.php?codigo="+value, true);
    xmlhttp.send();
}
function CargarParroquias(id,value)
{   
    var xmlhttp;
    if (window.XMLHttpRequest)
    {   xmlhttp = new XMLHttpRequest ();
    }
    else
    {   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function ()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   document.getElementById(id).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "select_parroquia.php?codigo="+value, true);
    xmlhttp.send();
}
function alum_change_course (curs_para_codi,alum_curs_para_codi)
{   $('#btn_curs_para_change').button('loading');
    var data = new FormData();    
    data.append('opc', 'alum_change_course');
    data.append('alum_curs_para_codi', alum_curs_para_codi);
    data.append('curs_para_codi', curs_para_codi);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'script_alum.php' , true);
    xhr.send(data);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   obj = JSON.parse(xhr.responseText);
            if (obj.state == "success")
            {   $.growl.notice({ title: "Educalinks informa",message: obj.mensaje });
                $('#btn_curs_para_change').button('reset');
                $('#ModalCambiarCurso').modal('hide');
                BuscarAlumnos(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value,document.getElementById('curs_para_codi_in').value);
            }else if (obj.state == "warning"){
                $.growl.warning({ title: "Educalinks informa",message: obj.mensaje });
                $('#btn_curs_para_change').button('reset');
            }
            else
            {   $.growl.error({ title: "Educalinks informa",message: obj.mensaje });
                $('#btn_curs_para_change').button('reset');
            }
            
        } 
    };
}
function BuscarAlumnos(alum_codi,alum_apel,curs_para_codi)
{    document.getElementById('alum_main').innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/> Buscando registros...</div>';
    var data = new FormData();    
    data.append('alum_codi', alum_codi);
    data.append('alum_apel', alum_apel);
    data.append('curs_para_codi', curs_para_codi);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'alumnos_main_lista.php' , true);
    xhr.send(data);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById('alum_main').innerHTML=xhr.responseText;

        $('#alum_table').datatable({
            pageSize: 30,
            sort: [true,true, true, true, false],
            filters: [false,false, false, false, false],
            filterText: 'Buscar... '
        }) ;

        } 
    };
}
function aplicar_estado(div,alum_curs_para_codi,alum_codi)
{   
    $('#btn_aplicar').button('loading');
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', 'add_curs_para');
    data.append('esta_codi', document.getElementById('esta_codi').value);
    data.append('curs_para_codi', (document.getElementById('curs_para_codi') === null) ? '0' : document.getElementById('curs_para_codi').value);
    data.append('alum_codi', alum_codi);
    data.append('alum_curs_para_codi', alum_curs_para_codi);
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var json = JSON.parse(xmlhttp.responseText);
            if (json.state=="success"){               
                $.growl.notice({ title: "Educalinks informa",message: alum_est_mensaje('add_alum_est_reg', true) });
                $('#btn_aplicar').button('reset');
                $('#ModalEstado').modal('hide');
                BuscarAlumnos(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value,document.getElementById('curs_para_codi_in').value);            
            }
            else
            {
                $.growl.error({ title: "Educalinks informa",message: alum_est_mensaje('add_alum_est_reg', false) });
                $('#btn_aplicar').button('reset');
                // $('#ModalMatri').modal('hide');
            }
            // location.reload();
            //  Descomentar en caso de querer que la ventana matriculado se mantenga abierta despues de darle click a Matricular.
            
            // document.getElementById('div_adm_est_alum_curs_para_codi').innerHTML='Matriculado Por Pagar';
            // document.getElementById('div_curs').innerHTML ='';
            // document.getElementById('div_alumno_estado_periodo').innerHTML ='';
            // document.getElementById('adm_est_curs_para_codi').value=curs_para_codi;
            // document.getElementById('adm_est_alum_est_det').value='Matriculado Por Pagar';
            // load_ajax_si_valor_es_igual('Matriculado Por Pagar', 'Matriculado Por Pagar', 'div_checks','alumno_estado_detalle.php','div_alumno_estado_periodo', 'alumnos_main_estado_combo.php','peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=Matriculado Por Pagar&alum_codi=' + document.getElementById('alum_codi').value + '&peri_tipo=R');
        }
    };
    xmlhttp.open("POST","script_alum.php",true);
 // xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);
}
function alum_est_mensaje(opc, respuesta)
{   if (opc=='alum_info_alum_est_check' && respuesta === true)
	{
		return 'Cambio guardado.';
	}
	if (opc=='alum_info_alum_est_check' && respuesta === false)
	{
		return 'Error al hacer visto.';
	}
	if (opc=='alum_info_docu_check' && respuesta === true)
	{
		return 'Cambio guardado.';
	}
	if (opc=='alum_info_docu_check' && respuesta === false)
	{
		return 'Error al hacer visto.';
	}
	if (opc=='add_alum_est_reg' && respuesta === true)
	{
		return 'Cambio de estado guardado.';
	}
	if (opc=='add_alum_est_reg' && respuesta === false)
	{
		return 'Error al guardar cambios.';
	}
}
function load_ajax_retiro(div,url,check,alum_codi,alum_curs_para_codi){
    //document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', 'alum_ret');
    data.append('alum_curs_para_codi', alum_curs_para_codi);
    data.append('check', check);
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            var json = JSON.parse(xmlhttp.responseText);
            if (json.state=="success"){               
                $.growl.notice({ title: "Educalinks informa", message: json.result });
                                
            }else{
                $.growl.error({ title: "Educalinks informa",message: json.result });
                
                // $('#ModalMatri').modal('hide');
            }
            load_ajax_noload(div,'modal_estado_retiro_view.php','alum_codi='+alum_codi);
            BuscarAlumnos(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value,document.getElementById('curs_para_codi_in').value);
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.send(data);        
}
function load_ajax_alum_curso_cupo( div, url, data, curso )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange=function()
    {   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
        {   document.getElementById(div).innerHTML=xmlhttp.responseText;
            var cupo = document.getElementById('span_cupo');
            var c = cupo.getAttribute('data-cupo');
            var deuda = (document.getElementById('total_deuda')==null ? 0 : document.getElementById('total_deuda').value);
            var bloqueo_hard = document.getElementById('bloqueo_hard').value;
            if ( curso === 0 || c === 0 || deuda > 0 || bloqueo_hard > 0 )
                $('#btn_aplicar').prop('disabled', true);
            else
                $('#btn_aplicar').prop('disabled', false);
        }
    };
    xmlhttp.send(data);    
}
function load_ajax_alum_curso_combo(div,url,data){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById('div_curs').innerHTML ='';

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
        {   document.getElementById(div).innerHTML=xmlhttp.responseText;
            load_ajax_alum_curso_cupo('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ document.getElementById('curs_para_codi').value);    
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    
}
function visualizar(flag,alum_codi){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('alum_codi', alum_codi);
    data.append('flag', flag);
    data.append('opc', 'desmask');
    xmlhttp.onreadystatechange=function()
    {   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
        {   document.getElementById('alum_resp_form_banc_tarj_nume').value=xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST",'script_alum.php',true);
    xmlhttp.send(data);    
}
// function load_ajax_cambio_estado(div,url, div2, url2, data){
//     document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
//     if (window.XMLHttpRequest)
//     {// code for IE7+, Firefox, Chrome, Opera, Safari
//         xmlhttp=new XMLHttpRequest();
//     }
//     else
//     {// code for IE6, IE5
//         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//     }
//     xmlhttp.onreadystatechange=function()
//     {   if (xmlhttp.readyState==4 && xmlhttp.status==200){
//             document.getElementById(div).innerHTML=xmlhttp.responseText;
//             load_ajax_alum_est_matr_checks(div2,url2,data)
//         }
//     };
//     console.log(url);
//     xmlhttp.open("POST",url,true);
//     xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//     xmlhttp.send(data);    
// }
function load_ajax_alum_est_matr_checks(div,url,alum_codi){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('alum_codi', alum_codi);
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(div).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.send(data);    
}
function load_ajax_alumno_estado_combo(div,url,data){
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
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    
}
function load_ajax_documentos(div,url,alum_codi){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('alum_codi', alum_codi);
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById(div).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.send(data);        
}
function load_ajax_add_alum_est_reg(div,url,data){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById('ModalMatri_footer').innerHTML='<small><i>Por favor espere...</i></small>';
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
            
            if (xmlhttp.responseText>0){
                $.growl.notice({ title: "Educalinks informa",message: alum_est_mensaje('add_alum_est_reg', true) });
            }else{
                $.growl.error({ title: "Educalinks informa",message: alum_est_mensaje('add_alum_est_reg', false) });
            }
            var text="";
            $('#ModalMatri').modal('hide');
            load_ajax('alum_main','alumnos_main_lista.php','');
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    
}
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
function load_ajax_add_alum(div,url,elem)
{   //document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if(ValidarAlumno() && ValidarUsuario())
    {   document.getElementById(div).innerHTML='';
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        var data = new FormData();
        data.append('opc', 'add');
        data.append('curs_prom', document.getElementById('curs_prom') === null ? '0' : $('#curs_prom').val() );
        data.append('alum_nomb', document.getElementById('alum_nomb').value);
        data.append('alum_apel', document.getElementById('alum_apel').value);
        data.append('alum_fech_naci', document.getElementById('alum_fech_naci').value);
        data.append('alum_cedu', document.getElementById('alum_cedu').value);
        data.append('alum_tipo_iden', document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
        data.append('alum_mail', document.getElementById('alum_mail').value);
        data.append('alum_celu', document.getElementById('alum_celu').value);
        data.append('alum_domi', document.getElementById('alum_domi').value.trim());
        data.append('alum_telf', document.getElementById('alum_telf').value);
        data.append('alum_ciud', $('#alum_ciud option:selected').text());
        data.append('alum_parroquia', $('#alum_parroquia option:selected').text());
        data.append('alum_telf_emerg', document.getElementById('alum_telf_emerg').value);
        data.append('alum_ex_plantel', document.getElementById('alum_ex_plantel').value.trim());
        data.append('alum_usua', document.getElementById('alum_usua').value);
        data.append('alum_vive_con', document.getElementById('alum_vive_con').value);
        data.append('alum_movilizacion',$('#alum_movilizacion option:selected').text());
        data.append('alum_motivo_cambio', document.getElementById('alum_motivo_cambio').value);
        data.append('alum_discapacidad', document.getElementById('alum_discapacidad').value);
        data.append('alum_condicionado', document.getElementById('alum_condicionado').value);
        data.append('alum_conducta', document.getElementById('alum_conducta').value);
        data.append('alum_ultimo_anio', document.getElementById('alum_ultimo_anio').value);
        data.append('alum_nacionalidad', document.getElementById('alum_nacionalidad').value);
        data.append('alum_motivo_condicion', document.getElementById('alum_motivo_condicion').value);
        data.append('alum_resp_form_pago', document.getElementById('sl_form_pago').value);
        data.append('alum_resp_form_banc_tarj', document.getElementById('sl_banco_tarjeta').value);
        data.append('alum_resp_form_banc_tarj_nume', document.getElementById('alum_resp_form_banc_tarj_nume').value);
        data.append('alum_resp_form_banc_tipo', (document.getElementById('cta_corriente').checked?'C':'A'));
        data.append('alum_resp_form_cedu', document.getElementById('alum_resp_form_cedu').value);
        data.append('alum_resp_form_nomb', document.getElementById('alum_resp_form_nomb').value);
        data.append('alum_grup_econ', document.getElementById('sl_alum_grup_econ').value);
        data.append('alum_tiene_discapacidad', document.getElementById('alum_tiene_discapacidad').checked);
        data.append('alum_genero', document.querySelector('input[id="genero"]:checked').value);
        data.append('idreligion', document.getElementById('alum_religion').value);
        data.append('idparentescovivecon', document.getElementById('alum_parentesco_vive_con').value);
        data.append('idestadocivilpadres', document.getElementById('alum_estado_civil_padres').value);
        data.append('alum_activ_deportiva', document.getElementById('alum_activ_deportiva').value);
        data.append('alum_activ_artistica', document.getElementById('alum_activ_artistica').value);
        data.append('alum_resp_form_fech_vcto', document.getElementById('alum_resp_form_fech_vcto').value);
        data.append('alum_enfermedades', document.getElementById('alum_enfermedades').value);
        data.append('alum_banc_emisor', document.getElementById('sl_banco_emisor').value);
        data.append('alum_parentesco_emerg', document.getElementById('alum_parentesco_emerg').value);
        data.append('alum_pers_emerg', document.getElementById('alum_pers_emerg').value);
        data.append('alum_tipo_sangre', document.getElementById('alum_tipo_sangre').value);
        data.append('alum_resp_form_tipo_iden', document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value);
        data.append('alum_pais',$('#alum_pais option:selected').text());
        data.append('alum_prov_naci', $('#alum_prov_naci option:selected').text());
        data.append('alum_ciud_naci', $('#alum_ciud_naci option:selected').text());
        data.append('alum_parr_naci', $('#alum_parr_naci option:selected').text());
        data.append('alum_sect_naci', $('#alum_sect_naci option:selected').text());
        data.append('alum_ex_plantel_dire', $('#alum_ex_plantel_dire').val());
        data.append('alum_etnia', document.getElementById('alum_etnia').value );
        data.append('alum_ingreso_familiar', document.getElementById('alum_ingreso_familiar').value );
        data.append('alum_hijo_ex_cadete', document.getElementById('alum_hijo_ex_cadete') === null ? '0' : document.getElementById('alum_hijo_ex_cadete').checked );
        data.append('alum_hno_ex_cadete', document.getElementById('alum_hno_ex_cadete') === null ? '0' : document.getElementById('alum_hno_ex_cadete').checked );
        data.append('alum_prov', $('#alum_prov option:selected').text());

        xmlhttp.onreadystatechange=function()
        {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {   if ( xmlhttp.responseText > 0 )
                {   document.getElementById(elem).value=xmlhttp.responseText;
                    $.growl.notice({ title: "Educalinks informa",message: "Se guardaron correctamente los datos del alumno." });
                    $('#btn_inscribir').hide();
                    $('#btn_cancelar').hide();
                    document.getElementById('btn_repre').style.display='Block';
                    load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
                }else
                {   $.growl.error({ title: "Educalinks informa",message: "Ocurrió un error al grabar los datos del alumno." }); 
                document.getElementById('alum_usua').focus();
                }
            }
        };
        xmlhttp.open("POST",url,true);
        // xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data);    
    }
}
function load_ajax_edit_alum( div, url, alum_codi )
{   if(ValidarAlumno())
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        document.getElementById(div).innerHTML='';
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        var data = new FormData();
        data.append('opc', 'edi');
        data.append('alum_codi', alum_codi);
        data.append('alum_nomb', document.getElementById('alum_nomb').value);
        data.append('alum_apel', document.getElementById('alum_apel').value);
        data.append('alum_fech_naci', document.getElementById('alum_fech_naci').value);
        data.append('alum_cedu', document.getElementById('alum_cedu').value);
        data.append('alum_tipo_iden', document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
        data.append('alum_mail', document.getElementById('alum_mail').value);
        data.append('alum_celu', document.getElementById('alum_celu').value);
        data.append('alum_domi', document.getElementById('alum_domi').value.trim());
        data.append('alum_telf', document.getElementById('alum_telf').value);
        data.append('alum_ciud', $('#alum_ciud option:selected').text());
        data.append('alum_parroquia', $('#alum_parroquia option:selected').text());
        data.append('alum_telf_emerg', document.getElementById('alum_telf_emerg').value);
        data.append('alum_ex_plantel', document.getElementById('alum_ex_plantel').value.trim());
        data.append('alum_usua', document.getElementById('alum_usua').value);
        data.append('alum_vive_con', document.getElementById('alum_vive_con').value);
        data.append('alum_movilizacion',$('#alum_movilizacion option:selected').text());
        data.append('alum_motivo_cambio', document.getElementById('alum_motivo_cambio').value);
        data.append('alum_discapacidad', document.getElementById('alum_discapacidad').value);
        data.append('alum_condicionado', document.getElementById('alum_condicionado').value);
        data.append('alum_conducta', document.getElementById('alum_conducta').value);
        data.append('alum_ultimo_anio', document.getElementById('alum_ultimo_anio').value);
        data.append('alum_nacionalidad', document.getElementById('alum_nacionalidad').value);
        data.append('alum_motivo_condicion', document.getElementById('alum_motivo_condicion').value);
        data.append('alum_resp_form_pago', document.getElementById('sl_form_pago').value);
        data.append('alum_resp_form_banc_tarj', document.getElementById('sl_banco_tarjeta').value);
        data.append('alum_resp_form_banc_tarj_nume', document.getElementById('alum_resp_form_banc_tarj_nume').value);
        data.append('alum_resp_form_banc_tipo', (document.getElementById('cta_corriente').checked?'C':'A'));
        data.append('alum_resp_form_cedu', document.getElementById('alum_resp_form_cedu').value);
        data.append('alum_resp_form_nomb', document.getElementById('alum_resp_form_nomb').value);
        data.append('alum_grup_econ', document.getElementById('sl_alum_grup_econ').value);
        data.append('alum_tiene_discapacidad', document.getElementById('alum_tiene_discapacidad').checked);
        data.append('alum_genero', document.querySelector('input[id="genero"]:checked').value);
        data.append('idreligion', document.getElementById('alum_religion').value);
        data.append('idparentescovivecon', document.getElementById('alum_parentesco_vive_con').value);
        data.append('idestadocivilpadres', document.getElementById('alum_estado_civil_padres').value);
        data.append('alum_activ_deportiva', document.getElementById('alum_activ_deportiva').value);
        data.append('alum_activ_artistica', document.getElementById('alum_activ_artistica').value);
        data.append('alum_resp_form_fech_vcto', document.getElementById('alum_resp_form_fech_vcto').value);
        data.append('alum_enfermedades', document.getElementById('alum_enfermedades').value);
        data.append('alum_banc_emisor', document.getElementById('sl_banco_emisor').value);
        data.append('alum_parentesco_emerg', document.getElementById('alum_parentesco_emerg').value);
        data.append('alum_pers_emerg', document.getElementById('alum_pers_emerg').value);
        data.append('alum_tipo_sangre', document.getElementById('alum_tipo_sangre').value);
        data.append('alum_resp_form_tipo_iden', document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value);
        data.append('alum_pais',$('#alum_pais option:selected').text());
        data.append('alum_prov_naci', $('#alum_prov_naci option:selected').text());
        data.append('alum_ciud_naci', $('#alum_ciud_naci option:selected').text());
        data.append('alum_parr_naci', $('#alum_parr_naci option:selected').text());
        data.append('alum_sect_naci', $('#alum_sect_naci option:selected').text());
        data.append('alum_ex_plantel_dire', $('#alum_ex_plantel_dire').val());
        data.append('alum_etnia', document.getElementById('alum_etnia').value );
        data.append('alum_ingreso_familiar', document.getElementById('alum_ingreso_familiar').value );
        data.append('alum_hijo_ex_cadete', document.getElementById('alum_hijo_ex_cadete') === null ? '0' : document.getElementById('alum_hijo_ex_cadete').checked );
        data.append('alum_hno_ex_cadete', document.getElementById('alum_hno_ex_cadete') === null ? '0' : document.getElementById('alum_hno_ex_cadete').checked );
        data.append('alum_prov', $('#alum_prov option:selected').text());

        xmlhttp.onreadystatechange=function()
        {   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
            {   var n = xmlhttp.responseText.length;
                //console.log(xmlhttp.responseText);
                if (n > 0)
                {   js_funciones_valida_tipo_growl(xmlhttp.responseText); /*Esta función se encuentra en framework/funciones.js*/
                    if ( xmlhttp.responseText != '-1' )
                        load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
                    else
                        load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
                }
                else
                {   $.growl.error({ title: "Educalinks informa",message: "Error al intentar obtener respuesta. Por favor, vuelva a intentarlo" });
                    load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
                }
            }
        };
        xmlhttp.open("POST",url,true);
        // xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data);
    }
}
function alum_bloq_view()
{   
    /*div='alum_bloq_view';
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    
    url='alumnos_bloq_view.php?';
    url += data =     'alum_bloq_nomb='   + document.getElementById('alum_nomb').value + 
            '&alum_bloq_apel='  + document.getElementById('alum_apel').value + 
            '&alum_bloq_cedu='  + document.getElementById('alum_cedu').value;
            
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
    xmlhttp.open("GET",url + data,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    */
}
function vali_matri(cupo_actual,curs_para_codi,alum_codi)
{   
    $('#btn_matricular').button('loading');
    if (cupo_actual>0)
    {
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if (xmlhttp.responseText!="KO"){
                    alert("Se realizó correctamente la matriculación");
                    location.reload();
                    /* Descomentar en caso de querer que la ventana matriculado se mantenga abierta despues de darle click a Matricular.
                    
                    document.getElementById('div_adm_est_alum_curs_para_codi').innerHTML='Matriculado Por Pagar';
                    document.getElementById('div_curs').innerHTML ='';
                    document.getElementById('div_alumno_estado_periodo').innerHTML ='';
                    document.getElementById('adm_est_curs_para_codi').value=curs_para_codi;
                    document.getElementById('adm_est_alum_est_det').value='Matriculado Por Pagar';
                    load_ajax_si_valor_es_igual('Matriculado Por Pagar', 'Matriculado Por Pagar', 'div_checks','alumno_estado_detalle.php','div_alumno_estado_periodo', 'alumnos_main_estado_combo.php','peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=Matriculado Por Pagar&alum_codi=' + document.getElementById('alum_codi').value + '&peri_tipo=R');
                    */
                    $('#btn_matricular').button('reset');
                    $('#ModalMatri').modal('hide');
                    load_ajax('alum_main','alumnos_main_lista.php','');
                }else{
                    alert("Ocurrió un problema al procesar la matriculación.");
                    $('#btn_matricular').button('reset');
                    $('#ModalMatri').modal('hide');
                    load_ajax('alum_main','alumnos_main_lista.php','');
                }
            }
        };
        xmlhttp.open("POST","script_alum.php",true);
        xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        var data="opc=add_curs_para&alum_codi="+alum_codi+"&curs_para_codi="+curs_para_codi;
        xmlhttp.send(data);
    }else{
        alert("El curso se encuentra sin cupo disponible. Por favor elija otro");
    }
}
function load_ajax_del_alum( data ){
	$('#modal_alum_main_ask').modal("show");
	document.getElementById('modal_alum_main_ask_body').innerHTML = '<div class="row"><div class="col-md-12">¿Está seguro de querer eliminar al estudiante? Se perderán las <b>notas</b>, <b>registros de faltas</b> y <b>todos los datos</b> relacionados con el estudiante.</div></div>';
	document.getElementById('modal_alum_main_ask_footer').innerHTML = 
	"<button class='btn btn-danger' type='button' onclick=\"load_ajax_del_alum_followed('"+data+"')\"><span class='fa fa-trash'></span>&nbsp;Eliminar</button>"+
	'<button class="btn btn-default" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li>&nbsp;No Eliminar</button>';
}
function load_ajax_del_alum_followed( data ){
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('modal_alum_main_ask_footer').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	xmlhttp.onreadystatechange=function()
	{   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
		{   if( xmlhttp.responseText > 0 )
			{   $.growl.notice({ title: "Educalinks informa",message: "Se eliminó correctamente los datos del alumno." });    
			}
			else
			{   $.growl.error({ title: "Educalinks informa",message: "Ocurrió un error al eliminar los datos del alumno." });    
			}
			$('#btn_buscar_alumnos').trigger("click");
			$('#modal_alum_main_ask').modal("hide");
		}
	};
	xmlhttp.open("POST",'script_alum.php',true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);
}
function load_ajax_retiro_alum(div,url,data)
{
    if (confirm ("¿Está seguro de querer retirar al estudiante?"))
    {
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText>0)
                {
                    $.growl.notice({ title: "Educalinks informa",message: "Retiro exitoso del estudiante." });    
                    location.reload();
                }
                else
                {
                    $.growl.error({ title: "Educalinks informa",message: "No se pudo procesar el retiro del estudiante." });    
                }
            }
        };
        xmlhttp.open("POST",url,true);
        xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data);
    }
}
function alumno_bloqueado( alum_cedu, alum_apel, alum_nomb )
{   url = 'script_alum.php?';
    url = 'cursos_paralelo_falt_alum_main_view.php';
    div = 'divview';
    
    opc       = document.getElementById('veri_bloq').value ;                     
    alum_cedu = document.getElementById('alum_cedu').value;
    alum_apel = document.getElementById('alum_apel').value ;
    alum_nomb = document.getElementById('alum_nomb').value ;
    
    var data = new FormData();        
    data.append('opc', opc);        
    
    data.append('alum_cedu', alum_cedu);    
    data.append('alum_apel', alum_apel);
    data.append('alum_nomb', alum_nomb);
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onload = function () {
        // do something to response
        //console.log(this.responseText);
    };
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){          
            document.getElementById(div).innerHTML=xhr.responseText;    
        } 
        
    };
    xhr.send(data);
}

function curs_para_cambiar_load (alum_curs_para_codi, alum_codi)
{
    document.getElementById("alum_curs_para_codi").value=alum_curs_para_codi;
    document.getElementById("alum_codi").value=alum_codi;
    document.getElementById("sl_curs_para_codi_1").value=-1;
    document.getElementById("div_matching").innerHTML="";
}

function curs_para_cambiar(alum_curs_para_codi, curs_para_codi)
{
    if (confirm ("¿Está seguro de querer cambiar al estudiante de paralelo, se perderán todas sus notas y deberá volver a ingresarlas?"))
    {
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
                if (xmlhttp.responseText!="KO")
                {
                    alert("Cambio de paralelo existoso.");
                    location.reload();
                }
                else
                {
                    alert("Ocurrió un problema al cambiar de paralelo.");
                }
            }
        };
        xmlhttp.open("POST","script_alum.php",true);
        xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        var data="opc=camb_curs_para&alum_curs_para_codi="+alum_curs_para_codi+"&curs_para_codi="+curs_para_codi;
        xmlhttp.send(data);    
    }
}
function ActivarDesactivarText(ckeck_box,text_box)
{
    if (document.getElementById(ckeck_box).checked)
    {
        document.getElementById(text_box).disabled=false;
        document.getElementById(text_box).setAttribute('placeholder','Ingrese aquí');
        document.getElementById(text_box).focus();
		document.getElementById(text_box).style.backgroundColor='white';
    }
    else
    {
        document.getElementById(text_box).disabled=true;
        document.getElementById(text_box).value='';
		document.getElementById(text_box).style.backgroundColor='#d1d1d1';
        document.getElementById(text_box).setAttribute('placeholder','No tiene');
    }
}
function load_ajax_alum_info_est(div, url, opc, check, alum_curs_para_codi, alum_codi, columna)
{   
    var data = new FormData();
    data.append('opc', opc);
    data.append('check', check);
    data.append('alum_curs_para_codi', alum_curs_para_codi);
    data.append('columna', columna);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   if (xhr.responseText>0)
            {   $.growl.notice({ title: "Educalinks informa",message: alum_est_mensaje(opc, true) });
            }
            else
            {   $.growl.error({ title: "Educalinks informa",message: alum_est_mensaje(opc, false) });
            }
            var text="";
            load_ajax_alum_est_matr_checks(div,'modal_estado_detalle_view.php',alum_codi);
        }
    };
    xhr.send(data);
}
function js_student_verify_user(div,url,data)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   obj = JSON.parse( xmlhttp.responseText );
            var n = obj[ 'MENSAJE' ].length;
            if ( n > 0 )
            {   document.getElementById(div).innerHTML = obj[ 'MENSAJE' ];
                document.getElementById('hd_user_verified').value = obj[ 'VERIFIED' ];
            }
            else
            {   document.getElementById(div).innerHTML = obj[ 'MENSAJE' ];
                document.getElementById('hd_user_verified').value = obj[ 'VERIFIED' ];
            }
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    
}
function load_ajax_alum_docu(div, url, opc, check, alum_codi, peri_codi, docu_peri_codi)
{   
    //document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', opc);
    data.append('check', check);
    data.append('alum_codi', alum_codi);
    data.append('peri_codi', peri_codi);
    data.append('docu_peri_codi', docu_peri_codi);
    xmlhttp.onreadystatechange=function()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200){
            //alert(xhr.responseText);
            if (xmlhttp.responseText>0){
                $.growl.notice({ title: "Educalinks informa",message: alum_est_mensaje(opc, true) });
            }else{
                $.growl.error({ title: "Educalinks informa",message: alum_est_mensaje(opc, false) });
            }
            var text="";
            load_ajax_documentos(div,'modal_estado_documento_view.php',alum_codi);
        }
    };
    xmlhttp.open("POST",url,true);
    //xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data);    
}

function show_edit_bloqueo (div,alum_codi,opc)
{   document.getElementById('alum_bloq_codi').value=alum_codi;
    load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
}
function load_ajax_lista_alum_bloq(div,url,alum_codi,opc){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {   // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {   // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', opc);
    data.append('alum_codi', alum_codi);
    xmlhttp.onreadystatechange=function()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   if( xmlhttp.responseText.length > 0 )
            {   document.getElementById(div).innerHTML=xmlhttp.responseText;
                $('#tbl_alum_bloq').datatable({pageSize: 5,sort: [true, true, false],filters: [false, false, false]});
            }
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.send(data);    
}
function alum_bloq_moti_opci_add(div,alum_codi,opc)
{   if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', 'alum_moti_bloq_opci_add');
    data.append('alum_codi', alum_codi);
    data.append('moti_bloq_codi', document.getElementById('cmb_motivos').value);
    data.append('opci_codi', document.getElementById('cmb_opciones').value);
    xmlhttp.onreadystatechange=function()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
        }
    };
    xmlhttp.open("POST","script_alum.php",true);
    xmlhttp.send(data);    
}
function alum_bloq_moti_opci_del(div,alum_codi,alum_moti_bloq_opci_codi,opc){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    var data = new FormData();
    data.append('opc', 'alum_moti_bloq_opci_del');
    data.append('alum_codi', alum_codi);
    data.append('alum_moti_bloq_opci_codi', alum_moti_bloq_opci_codi);
    xmlhttp.onreadystatechange=function()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
        }
    };
    xmlhttp.open("POST","script_alum.php",true);
    xmlhttp.send(data);
}
function load_ajax_lista_alum_bloq_matriz( div, url, alum_codi, opc, actual )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    if (window.XMLHttpRequest)
    {   // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {   // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var bandera_mora = 0;
    var data = new FormData();
    var sl_estado = document.getElementById('sl_estado');
    data.append('opc', opc);
    data.append('alum_codi', alum_codi);
    xmlhttp.onreadystatechange=function()
    {   if( xmlhttp.readyState === 4 && xmlhttp.status == 200 )
        {   if( xmlhttp.responseText != "No Mora" )
            {   bandera_mora = bandera_mora + 1 ;
                document.getElementById(div).innerHTML = "<br>" + xmlhttp.responseText;
                document.getElementById( 'div_curs' ).innerHTML="";
                $('#tbl_alum_bloq').datatable({pageSize: 5,sort: [true, true, false],filters: [false, false, false]});
            }
            else
            {   document.getElementById(div).innerHTML="";
            }
            if (window.XMLHttpRequest)
            {   // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttpII = new XMLHttpRequest();
            }
            else
            {   // code for IE6, IE5
                xmlhttpII = new ActiveXObject("Microsoft.XMLHTTP");
            }
            var data2 = new FormData();
            data2.append( 'opc', 'alum_deudaMatricula' );
            data2.append( 'alum_codi', alum_codi );
            xmlhttpII.onreadystatechange=function()
            {   if( xmlhttpII.readyState === 4 && xmlhttpII.status == 200 )
                {   if( xmlhttpII.responseText != "<center>Alumno no tiene deudas financieras pendientes.</center>" )
                    {   bandera_mora = bandera_mora + 1 ;
                        document.getElementById( 'div_curs' ).innerHTML = "<br>" + xmlhttpII.responseText;
                    }
                    else
                    {   document.getElementById( 'div_curs' ).innerHTML="";
                    }
                    if( bandera_mora === 0 )
                    {   if( actual != sl_estado.options[sl_estado.selectedIndex].innerHTML )
                        {   load_ajax('div_curs','cursos_paralelo_main_combo.php','peri_codi=' + document.getElementById('peri_0').value + '&alum_est_peri_codi=' + sl_estado.options[sl_estado.selectedIndex].innerHTML + '&prev_curs_para_codi='  + document.getElementById('prev_curs_para_codi').value + '&prev_alum_est=' + document.getElementById('prev_alum_est').value);
                        }
                    }
                }
            };
            xmlhttpII.open("POST",url,true);
            xmlhttpII.send(data2);    
        }
    };
    xmlhttp.open("POST",url,true);
    xmlhttp.send(data);    
}
function ValidarAlumno ()
{   var response = "";
    if (document.getElementById('alum_nomb').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los nombres del estudiante." });
        document.getElementById('alum_nomb').style.border='solid 1px red';
        document.getElementById('alum_nomb').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_nomb').style.border='';
    }
    if (document.getElementById('alum_apel').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los apellidos del estudiante." });
        document.getElementById('alum_apel').style.border='solid 1px red';
        document.getElementById('alum_apel').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_apel').style.border='';
    }
    if (document.getElementById('alum_usua').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el usuario del estudiante." });
        document.getElementById('alum_usua').style.border='solid 1px red';
        document.getElementById('alum_usua').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_usua').style.border='';
    }
    if (document.getElementById('alum_cedu').value === '' && $('#alum_cedu').hasClass('required')){
        document.getElementById('alum_cedu').style.border='solid 1px red';
        $.growl.error({ title: 'Educalinks informa', message: 'Por favor ingrese la cédula del alumno.' });
        document.getElementById('alum_cedu').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else if (document.getElementById('alum_cedu').value != '')
    {
        response = validarNI(document.getElementById('alum_cedu').value,document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" )
        {   document.getElementById('alum_cedu').style.border='';
        }
        else
        {   $.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
            document.getElementById('alum_cedu').style.border='solid 1px red';
            document.getElementById('alum_cedu').focus();
            $('#tabs a[href="#tab1"]').tab('show');
            return false;
        }
    }
    if (document.getElementById('alum_fech_naci').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la fecha de nacimiento del estudiante." });
        document.getElementById('alum_fech_naci').style.border='solid 1px red';
        document.getElementById('alum_fech_naci').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_fech_naci').style.border='';
    } 
    if (document.getElementById('alum_domi').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el domicilio del estudiante." });
        document.getElementById('alum_domi').style.border='solid 1px red';
        document.getElementById('alum_domi').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_domi').style.border='';
    }
    if (document.getElementById('alum_telf').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el teléfono del estudiante." });
        document.getElementById('alum_telf').style.border='solid 1px red';
        document.getElementById('alum_telf').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_telf').style.border='';
    }
    if (document.getElementById('alum_ciud').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la ciudad de residencia del estudiante." });
        document.getElementById('alum_ciud').style.border='solid 1px red';
        document.getElementById('alum_ciud').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_ciud').style.border='';
    }
        /*if (document.getElementById('alum_parroq').value === '')
        {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la parroquia de residencia del estudiante." });
            document.getElementById('alum_parroq').style.border='solid 1px red';
            return false;
        }
        else
        {   document.getElementById('alum_parroq').style.border='';
    }*/
    if (document.getElementById('alum_pais').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la nacionalidad del estudiante." });
        document.getElementById('alum_pais').style.border='solid 1px red';
        document.getElementById('alum_pais').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_pais').style.border='';
    }
    if (document.getElementById('alum_nacionalidad').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la nacionalidad del estudiante." });
        document.getElementById('alum_nacionalidad').style.border='solid 1px red';
        document.getElementById('alum_nacionalidad').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_nacionalidad').style.border='';
    }
    if (document.getElementById('alum_tipo_sangre').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el tipo de sangre del estudiante." });
        document.getElementById('alum_tipo_sangre').style.border='solid 1px red';
        document.getElementById('alum_tipo_sangre').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_tipo_sangre').style.border='';
    }
    if ($('#alum_resp_form_banc_tarj_nume').val().trim() === '' && $('#alum_resp_form_banc_tarj_nume').hasClass('required'))
    {   $.growl.error({title: 'Educalinks informa', message: 'Por favor ingresar número de tarjeta o cuenta de banco.' });
        document.getElementById('alum_resp_form_banc_tarj_nume').style.border='solid 1px red';
        document.getElementById('alum_resp_form_banc_tarj_nume').focus();
        $('#tabs a[href="#tab3"]').tab('show');
        return false;
    }else
    {   document.getElementById('alum_resp_form_banc_tarj_nume').style.border='';
    }
    if (document.getElementById('alum_telf_emerg').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el teléfono de emergencia del estudiante." });
        document.getElementById('alum_telf_emerg').style.border='solid 1px red';
        document.getElementById('alum_telf_emerg').focus();
        $('#tabs a[href="#tab4"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_telf_emerg').style.border='';
    }
    if (document.getElementById('alum_pers_emerg').value === '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el nombre de contacto de emergencia del estudiante." });
        document.getElementById('alum_pers_emerg').style.border='solid 1px red';
        document.getElementById('alum_pers_emerg').focus();
        $('#tabs a[href="#tab4"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_pers_emerg').style.border='';
    }
    if (document.getElementById('alum_resp_form_cedu').value === '')
    {   //do nothing
    }
    else
    {   response = validarNI(document.getElementById('alum_resp_form_cedu').value,document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value);
        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" )
        {
            document.getElementById('alum_resp_form_cedu').style.border='';
        }
        else
        {   
            $.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación del propietario de la cuenta de acuerdo al tipo correctamente." });
            document.getElementById('alum_resp_form_cedu').style.border='solid 1px red';
            document.getElementById('alum_resp_form_cedu').focus();
            $('#tabs a[href="#tab3"]').tab('show');
            return false;
        }
    }
    return true;
}
function ValidarUsuario()
{   if (document.getElementById('hd_user_verified').value!="1")
    {   $.growl.error({ title: "Educalinks informa",message: "Usuario no válido. Debe ingresar un usuario válido." });    
        document.getElementById('alum_usua').style.border='solid 1px red';
        document.getElementById('alum_usua').focus();
        $('#tabs a[href="#tab1"]').tab('show');
        return false;
    }
    else
    {   document.getElementById('alum_usua').style.border='';
    }
    return true;
}
function carga_dscto(tipo_dscto,alum_codi)
{   //document.getElementById('alum_desc_porcentaje').value='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
    var data = new FormData();    
    data.append('opc', 'carga_dscto');
    data.append('alum_codi', alum_codi);
    data.append('tipo_dscto', tipo_dscto);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'script_alum.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById('alum_desc_porcentaje').value= xhr.responseText;
        } 
    };
    xhr.send(data);
}
function alum_curs_para_info (alum_curs_para_codi)
{   var data = new FormData();    
    data.append('opc', 'alum_curs_para_info');
    data.append('alum_curs_para_codi', alum_curs_para_codi);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'script_alum.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   obj = JSON.parse(xhr.responseText);
            if (obj.error == "no")
            {   document.getElementById("estudiante_info").innerHTML = obj.alum_codi+" / "+obj.alum_nomb+" "+obj.alum_apel;
                document.getElementById("curso_actual").innerHTML = obj.curs_deta+" / "+obj.para_deta;
            }
            else
            {   document.getElementById("estudiante_info").innerHTML = obj.mensaje;
            }
        }
    };
    xhr.send(data);
}
function validarNI(strCedula,tipo_iden)
{   var total = 0;
    var residuo = 0;
    var resultado = 0;
    var valor3 = 0;
    var nro_region = 0;
    if (tipo_iden==3)
    {   return 'Pasaporte';
    }
    else if(isNumeric(strCedula))
    {   
        var total_caracteres=strCedula.length;// se suma el total de caracteres
        if(tipo_iden==1)
        {
            if(total_caracteres==10)
            {   //compruebo que tenga 10 digitos la cedula
                nro_region = strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
                if(nro_region>=1 && nro_region<=24)
                {   // compruebo a que region pertenece esta cedula//
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
                    valor3=parseInt(strCedula.charAt(2));
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

                    var suma_impares = (valor1 + valor3 + valor5 + valor7 + valor9);
                    suma = (suma_pares + suma_impares);
                    var temp = ''+suma;
                    var dis = parseInt(temp.charAt(0));//extraigo el primer numero de la suma
                    dis = ((dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
                    var digito=(dis - suma);
                    if(digito==10){ digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
                    if (digito==parseInt(ult_digito))
                    {   //comparo los digitos final y ultimo
                        return "Cédula Correcta";
                    }
                    else
                    {   return "Cédula Incorrecta";
                        document.getElementById('alum_cedu').focus();
                        $('#tabs a[href="#tab1"]').tab('show');
                    }
                }
                else
                {   //echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
                    return "Cédula Incorrecta";
                    document.getElementById('alum_cedu').focus();
                    $('#tabs a[href="#tab1"]').tab('show');
                }
                //echo "Es un Numero y tiene el numero correcto de caracteres que es de ".total_caracteres."";
            }
            else //numero 10
            {   //echo "Es un Numero y tiene solo".total_caracteres;
                return "Cédula Incorrecta";
                document.getElementById('alum_cedu').focus();
                $('#tabs a[href="#tab1"]').tab('show');
            }
        }
        else if (tipo_iden==2)
        {   if(total_caracteres==13)
            {   //compruebo que tenga 10 digitos la cedula
                nro_region = strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
                if(nro_region>=1 && nro_region<=24)
                {   var primeros_digitos;
                    var array_coeficientes;
                    var digito_verificador;
                    valor3 = strCedula.charAt(2);
                    if(valor3>=0 && valor3<=5)
                    {   //Persona natural
                        primeros_digitos = strCedula.substring( 0, 9);
                        array_coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
                        digito_verificador = parseInt(strCedula.charAt(9));
                        primeros_digitos = primeros_digitos.split("");

                        total = 0;

                        primeros_digitos.forEach(function(item,index,arr)
                        {   var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
                            if (valor_Posicion >= 10)
                            {   var valor_char = valor_Posicion.toString();
                                valor_char = valor_char.split("");
                                var temp = 0;
                                valor_char.forEach(function(item)
                                {   temp = temp + parseInt(item);
                                });
                                valor_Posicion = temp;
                            }
                            total = total + valor_Posicion;
                        });

                        residuo =  total % 10;
                        resultado = 0;
                        if (residuo === 0) {
                            resultado = 0;        
                        } else {
                            resultado = 10 - residuo;
                        }
                        if (resultado != digito_verificador) {
                            return 'RUC Incorrecto';
                        }else{
                            return 'RUC Correcto';
                        }
                    }
                    else if (valor3==6)
                    {   // Entidad Publica
                        primeros_digitos = strCedula.substring( 0, 8);
                        array_coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
                        digito_verificador = parseInt(strCedula.charAt(8));
                        primeros_digitos = primeros_digitos.split("");


                        total = 0;
                        primeros_digitos.forEach(function(item,index,arr){
                            var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
                            total = total + valor_Posicion;
                        });

                        residuo =  total % 11;
                        resultado = 0;
                        if (residuo === 0)
                        {   resultado = 0;        
                        }
                        else
                        {   resultado = 11 - residuo;
                        }
                        if (resultado != digito_verificador)
                        {   return 'RUC Incorrecto';
                        }
                        else
                        {   return 'RUC Correcto';
                        }
                    }
                    else if (valor3==9)
                    {   // Sociedad Privada
                        primeros_digitos = strCedula.substring( 0, 9);
                        array_coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
                        digito_verificador = parseInt(strCedula.charAt(9));
                        primeros_digitos = primeros_digitos.split("");

                        total = 0;
                        primeros_digitos.forEach(function(item,index,arr)
                        {   var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
                            total = total + valor_Posicion;
                        });
                        residuo =  total % 11;
                        resultado = 0;
                        if (residuo === 0)
                        {   resultado = 0;        
                        }
                        else
                        {   resultado = 11 - residuo;
                        }
                        if (resultado != digito_verificador)
                        {   return 'RUC Incorrecto';
                        }
                        else
                        {   return 'RUC Correcto';
                        }
                    }
                    else
                    {   return 'RUC Incorrecto';
                    }    
                }
                else
                {   //echo "Este Nro de RUC no corresponde a ninguna provincia del ecuador";
                return 'RUC Incorrecto';
                }
                //echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";
            }
            else //numero 10
            {   //return "Es un Numero y tiene solo".$total_caracteres;
                return 'RUC Incorrecto';
            }
        }
    }
    else
    {   return "Esta Cédula o RUC no corresponde a un Nro de Identidad de Ecuador";
        //return "Incorrecto"
    }
}
function isNumeric(n)
{   return !isNaN(parseFloat(n)) && isFinite(n);
}