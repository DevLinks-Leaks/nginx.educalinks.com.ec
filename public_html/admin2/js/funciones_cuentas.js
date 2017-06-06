function mostrar_tarjeta(value){
    if (value==23)
        $('#div_tarjeta').collapse(200).collapse('show');
    else
        $('#div_tarjeta').collapse('hide');
}
function cuentas_del(url,dat,alum_codi){
    $('#btn_cuenta_del').button('loading');
    //document.getElementById(div).innerHTML='';
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
            var json = JSON.parse(xmlhttp.responseText);
            if (json.state=="success"){             
                $.growl.notice({ title: "Listo!",message: json.result });               
            }else{
                $.growl.error({ title: "Atención!",message: json.result }); 
            }
            $('#btn_cuenta_del').button('reset');
            load_cuentas('opcion82','alumnos_add_cuentas.php','alum_codi='+alum_codi);
        }
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data); 
}
function cuenta_add(url,alum_codi){
    if(ValidarCuenta()){
        $('#btn_guardar_cuen').button('loading');
        //document.getElementById(div).innerHTML='';
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        $alum_cuen_codi = document.getElementById('alum_cuen_codi').value;
        var data = new FormData();
        if ($alum_cuen_codi == 0)
            data.append('opc', 'alum_cuen_add');
        else
            data.append('opc', 'alum_cuen_edit');
        data.append('alum_cuen_codi', $alum_cuen_codi);
        data.append('alum_codi', alum_codi);
        data.append('alum_cuen_form_pago', $('#sl_form_pago').val());
        data.append('alum_cuen_banc_tarj', $('#alum_cuen_banc_tarj').val());
        data.append('alum_cuen_banc_emis', ($('#alum_cuen_banc_emis').val()=='' ? 0 : $('#alum_cuen_banc_emis').val()));
        data.append('alum_cuen_fech_venc', $('#alum_cuen_fech_venc').val());
        data.append('alum_cuen_nume', $('#alum_cuen_nume').val());
        data.append('alum_cuen_tipo', (document.getElementById('cta_corriente').checked?'C':'A'));
        data.append('alum_cuen_nomb', $('#alum_cuen_nomb').val());
        data.append('alum_cuen_cedu', $('#alum_cuen_cedu').val());
        data.append('alum_cuen_tipo_iden', $('#alum_cuen_tipo_iden').val());
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var json = JSON.parse(xmlhttp.responseText);
                if (json.state=="success"){             
                    $.growl.notice({ title: "Listo!",message: json.result });               
                }else{
                    $.growl.error({ title: "Atención!",message: json.result }); 
                }
                $('#btn_guardar_cuen').button('reset');
                $('#modal_metodo_pago').modal('hide');
                load_cuentas('opcion82','alumnos_add_cuentas.php','alum_codi='+alum_codi);
            }
        }
        xmlhttp.open("POST",url,true);
        // xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data); 
    }
}

function load_cuentas(div,url,data){
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
            $.extend(
                $.fn.dataTable.RowReorder.defaults,
                { selector: '.roworder' }
            );  
            $('#tbl_metodo_pago').DataTable({
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "bSort": false ,
                rowReorder: true,
                "info": false,
                // "ordering": false,
                "searching":false,
                "lengthChange":false,
                "paging":false
            });
        }
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data); 
}
function load_modal_cuentas(div,url,data){
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
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
            $("#alum_cuen_fech_venc").datepicker();
        }
    }
    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xmlhttp.send(data); 
}
function load_ajax_edit_auto(div,url,data){
    if(validar_auto_edit()){
        $('#btn_auto_edit').button('loading');
        //document.getElementById(div).innerHTML='';
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
                var json = JSON.parse(xmlhttp.responseText);
                if (json.state=="success"){             
                    $.growl.notice({ title: "Listo!",message: json.result });               
                }else{
                    $.growl.error({ title: "Atención!",message: json.result }); 
                }
                $('#btn_auto_edit').button('reset');
                $('#modal_autor_edit').modal('hide');
                load_ajax_autores_main('autor_main','autor_view.php','');
            }
        }
        xmlhttp.open("POST",url,true);
        xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data); 
    }
}
function ValidarCuenta ()
{   
    if ($('#sl_form_pago').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor escoja la forma de pago." });
        $('#sl_form_pago').closest('.form-group').addClass('has-error');
        $('#sl_form_pago').focus();
        return false;
    }
    else
    {   $('#sl_form_pago').closest('.form-group').removeClass('has-error');
    }
    if ($('#alum_cuen_banc_tarj').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor escoja el Banco/Tarjeta." });
        $('#alum_cuen_banc_tarj').closest('.form-group').addClass('has-error');
        $('#alum_cuen_banc_tarj').focus();
        return false;
    }
    else
    {   $('#alum_cuen_banc_tarj').closest('.form-group').removeClass('has-error');
    }
    if($('#sl_form_pago').val()==23){
        if ($('#alum_cuen_banc_emis').val().trim() == '')
        {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el banco emisor de la tarjeta de crédito." });
            $('#alum_cuen_banc_emis').closest('.form-group').addClass('has-error');
            $('#alum_cuen_banc_emis').focus();
            return false;
        }
        else
        {   $('#alum_cuen_banc_emis').closest('.form-group').removeClass('has-error');
        }
        if ($('#alum_cuen_fech_venc').val().trim() == '')
        {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la fecha de vencimiento de la tarjeta de crédito." });
            $('#alum_cuen_fech_venc').closest('.form-group').addClass('has-error');
            $('#alum_cuen_fech_venc').focus();
            return false;
        }
        else
        {   $('#alum_cuen_fech_venc').closest('.form-group').removeClass('has-error');
        }
    }
    if ($('#alum_cuen_nomb').val().trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el nombre del propietario de la cuenta." });
        $('#alum_cuen_nomb').closest('.form-group').addClass('has-error');
        $('#alum_cuen_nomb').focus();
        return false;
    }
    else
    {   $('#alum_cuen_nomb').closest('.form-group').removeClass('has-error');
    }
    if (document.getElementById('alum_cuen_cedu').value.trim() == '' ){
        $('#alum_cuen_cedu').closest('.form-group').addClass('has-error');
        $.growl.error({ title: 'Educalinks informa', message: 'Por favor ingrese el número de identificación del propietario de la cuenta.' });
        document.getElementById('alum_cuen_cedu').focus();
        return false;
    }
    else if (document.getElementById('alum_cuen_cedu').value.trim() != '')
    {
        response = validarNI(document.getElementById('alum_cuen_cedu').value,document.getElementById('alum_cuen_tipo_iden').options[document.getElementById('alum_cuen_tipo_iden').selectedIndex].value);
        if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" )
        {   $('#alum_cuen_cedu').closest('.form-group').removeClass('has-error');
        }
        else
        {   $.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
            $('#alum_cuen_cedu').closest('.form-group').addClass('has-error');
            document.getElementById('alum_cuen_cedu').focus();
            return false;
        }
    }
    if (document.getElementById('alum_cuen_nume').value.trim() == '')
    {   $.growl.error({ title: "Educalinks informa",message: "Por favor ingrese número de cuenta o tarjeta." });
        $('#alum_cuen_nume').closest('.form-group').addClass('has-error');
        document.getElementById('alum_cuen_nume').focus();
        return false;
    }
    else
    {   $('#alum_cuen_nume').closest('.form-group').removeClass('has-error');
    }
    
    return true;
}
function CargarBancosTarjetas (codigo)
{   var xmlhttp;
    if (window.XMLHttpRequest)
    {   xmlhttp = new XMLHttpRequest ();
    }
    else
    {   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xmlhttp.onreadystatechange = function ()
    {   if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {   
            if(xmlhttp.responseText==''){
                $('#alum_cuen_banc_tarj').attr('disabled','disabled');
                document.getElementById('alum_cuen_banc_tarj').innerHTML='<option value="0">SELECCIONE</option>';
            }
            else{
                $('#alum_cuen_banc_tarj').attr('disabled',false);
                document.getElementById('alum_cuen_banc_tarj').innerHTML=xmlhttp.responseText;
                $('#alum_cuen_banc_tarj').select2({
                    placeholder: "SELECCIONE",
                    allowClear: true,
                    language: "es"
                });
            }
        }
    }
    xmlhttp.open("GET", "select_banco_tarjeta.php?idpadre="+codigo, true);
    xmlhttp.send();
}