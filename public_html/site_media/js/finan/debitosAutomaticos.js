// JavaScript Document
$(document).ready(function(){
    $("#txt_fecha_debito").datepicker();
    $("#cmb_producto").select2();
    $( "#div_campos" ).sortable({
        axis: 'y',
        cursor: 'move',
        containment: 'parent',
        tolerance: "pointer",
        change: function(event, ui)
        {   validate_save_button_followed(false);
        }
    });
    $( "#div_campos" ).disableSelection();
    $('#modal_formato').on('hidden.bs.modal', function () {
        document.getElementById('forma_descripccion_add').style.border = "1px solid #CCCCCC";
        document.getElementById('lbl_forma_descripccion_add').style.color = "black";
    });
    $('#modal_cargarFormatoArchivo').on('show.bs.modal', function () {
        get_formatos('div_cmb_carga_formato',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
    });
    $('#modal_exportarFormatoArchivo').on('hidden.bs.modal', function () {
        $(this).find("input,textarea").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(this).find(".collapse").collapse('hide').end();
        $(this).find("#cmb_tipo_formato").val('xlsx').end();
    });
});
var num_campos = 0;
var num_total_campos = 0;
function nuevo_formato()
{   var r = false;
    if($('#span_status_disk').hasClass('glyphicon glyphicon-floppy-saved'))
    {   r = true;
    }
    else
    {   r = confirm("¿Terminar edición de formato actual? Los cambios no guardados se perderán.");
    }
    if (r)
    {   limpia_crear_formato();
        document.getElementById('hd_nombreformato').value = "";
        document.getElementById('hd_id_cabecera').value = "";
        document.getElementById('span_info_formato').innerHTML = "";
        document.getElementById('btn_choose_view').disabled = false;
        document.getElementById('cmb_vista').disabled = false;
    }
}
function limpia_crear_formato()
{   num_campos = 0;
    num_total_campos = 0;
    validate_save_button(num_total_campos);
    document.getElementById('secuencial').checked = false;
    cambia_check_sec(document.getElementById('secuencial'));
    document.getElementById('div_campos').innerHTML = "";
    document.getElementById('div_file_status').innerHTML = "";
    document.getElementById('div_file_status_top').innerHTML = "";
    document.getElementById('lbl_num_total_campos').value = "0";
}
function validate_save_button(num_total_campos)
{   if(num_total_campos === 0)
    {   validate_save_button_followed(true);
    }
    else
    {   validate_save_button_followed(false);
    }
}
function validate_save_button_followed(toggle)
{   var nombre = document.getElementById('hd_nombreformato').value;
    if (nombre)
    {   var title = " title='Modificado: \"" + nombre + "\"' ";
    }
    else
    {   var title = " title='Modificado: [nuevo formato]' ";
        toggle = false;
    }
    if(toggle)
    {   document.getElementById('div_file_status').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='left' title='Modificado' style='color:green;' class='glyphicon glyphicon-floppy-saved'></span>";
        document.getElementById('div_file_status_top').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='right' " + title + " style='color:green;' class='glyphicon glyphicon-floppy-saved'></span>";
        document.getElementById('btn_formato_nuevo_guardar').disabled = toggle;
        document.getElementById('cmb_vista').value = document.getElementById('hd_vista').value;
    }
    else
    {   document.getElementById('div_file_status').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='left' title='Modificado' style='color:red;' class='glyphicon glyphicon-floppy-remove'></span>";
        document.getElementById('div_file_status_top').innerHTML = "<span id='span_status_disk' name='span_status_disk' onmouseover='$(this).tooltip(\"show\")' data-placement='right' " + title + " style='color:red;' class='glyphicon glyphicon-floppy-remove'></span>";
        document.getElementById('btn_formato_nuevo_guardar').disabled = toggle;
        document.getElementById('cmb_vista').value = document.getElementById('hd_vista').value;
    }
}
function remove_column(obj)
{   var obj_name = obj.attributes["name"].value;
    var wordsToFind = ["quitar_", "*quitar_*"];
    if (obj_name.toLowerCase().indexOf(wordsToFind[0]) === 0 || obj_name.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   var nombre = obj_name.replace("quitar_", "");
        $("#li_campo_" + nombre).remove();
        num_total_campos = num_total_campos - 1;
        document.getElementById("lbl_num_total_campos").value = num_total_campos;
        $.growl.error({title: 'Educalinks Informa:', message: 'Campo eliminado.'});
        validate_save_button(num_total_campos);
    }
}
function carga_archivo(field, div, url)
{   nuevo_formato();
    document.getElementById(div + '_load_gif').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Cargando formato. Por favor, espere...</div>';
    var data = new FormData();
    data.append('event', 'carga_formato');
    data.append('formatos_add', field);
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', url , true);
    xhraf.onreadystatechange=function()
    {   if (xhraf.readyState==4 && xhraf.status==200)
        {   $('#modal_cargarFormatoArchivo').modal('hide');
            obj = JSON.parse(xhraf.responseText);
            if(obj['secuencial']===1)
            {   document.getElementById('secuencial').checked = true;
            }
            else
            {   document.getElementById('secuencial').checked = false;
            }
            cambia_check_sec(document.getElementById('secuencial'));
            document.getElementById('secuencia').value = obj['secuencia']; //numero del secuencial
            document.getElementById('ubicacion').value = obj['ubicacion']; //columna en la que va ubicado el secuencial en el documento
            document.getElementById('cmb_vista').value = obj['vista']; //vista
            document.getElementById('hd_vista').value = obj['vista']; //vista
            document.getElementById('lbl_num_total_campos').value = (obj['numrows']-1);
            document.getElementById(div).style.display='none';
            document.getElementById('btn_choose_view').disabled = true;
            document.getElementById('cmb_vista').disabled = true;
            js_debtAut_carga_archivo_followed ( div, url, obj, 0, obj.form_debi_deta_codigos.length );
			
            var dataII = new FormData();
            dataII.append('event', 'cambiar_vista');
            dataII.append('vista', obj['vista']);
            var xhrafII = new XMLHttpRequest();
            xhrafII.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php', true);
            xhrafII.onreadystatechange=function()
            {   if ( xhrafII.readyState === 4 && xhrafII.status === 200 )
                {   document.getElementById('div_cmb_campos').innerHTML = xhrafII.responseText;
                }
            };
            xhrafII.send(dataII);
        }
    };
    xhraf.send(data);
}
function js_debtAut_carga_archivo_followed(div, url, obj, indice, obj_len )
{   if( ( indice < obj_len ) )
    {   var data = new FormData();
        data.append('event', 'carga_formato_campo');
        data.append('text', obj.form_debi_deta_codigos[indice]['text']);
        data.append('value', obj.form_debi_deta_codigos[indice]['value'] );
        data.append('num_campo', obj.form_debi_deta_codigos[indice]['num_campo'] );
        data.append('text_predif', obj.form_debi_deta_codigos[indice]['text_predif'] );
        data.append('num_caracteres', obj.form_debi_deta_codigos[indice]['num_caracteres'] );
        data.append('val_izq', obj.form_debi_deta_codigos[indice]['val_izq'] );
        data.append('text_izq', obj.form_debi_deta_codigos[indice]['text_izq'] );
        data.append('val_der', obj.form_debi_deta_codigos[indice]['val_der'] );
        data.append('text_der', obj.form_debi_deta_codigos[indice]['text_der'] );
        var xhraf = new XMLHttpRequest();
        xhraf.open('POST', url , true);
        xhraf.onreadystatechange=function()
        {   if (xhraf.readyState==4 && xhraf.status==200)
            {   var container = document.createElement("div");
                container.innerHTML = xhraf.responseText;
                document.getElementById(div).appendChild(container);
                js_debtAut_carga_archivo_followed(div, url, obj, indice + 1, obj_len )
            }
        };
        xhraf.send(data);
    }
    else
    {   document.getElementById(div).style.display='block';
        document.getElementById(div + '_load_gif').innerHTML="";
        num_campos = (obj['numrows']-1);
        num_total_campos = (obj['numrows']-1);
        cuadro_guardado_sin_modificacion(obj['hd_nombreformato'], obj['hd_id_cabecera']);
        $.growl.notice({title: 'Educalinks Informa', message: 'Formato "' + obj['hd_nombreformato'] + '" cargado correctamente'});
    }
}
function js_debtAut_copiar_archivo_open_modal(codigo, url)
{   $('#modal_copy_paste').modal('show');
    document.getElementById('cmb_formato_copyPaste').value = codigo;
    var sel = document.getElementById('cmb_formato_copyPaste');
    var nombre_formato = sel.options[sel.selectedIndex].text;
    document.getElementById('forma_descripccion_copy_paste').innerHTML = "<small>Realizando copia del formato '<b>" + nombre_formato + "</b>'.</small>";
}
function js_debtAut_copiar_archivo_copy(codigo, div, url)
{   var f = document.getElementById('txt_forma_descripccion_copyPaste').value;
    if(f.length>0)
    {   var data = new FormData();
        data.append('event', 'copy_file');
        data.append('form_debi_codigo', codigo);
        data.append('form_debi_descripcion', f);
        var xhraf = new XMLHttpRequest();
        xhraf.open('POST', url , true);
        xhraf.onreadystatechange=function()
        {   if (xhraf.readyState==4 && xhraf.status==200)
            {   var n = xhraf.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhraf.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                }
                js_debtAuto_mantenimiento_buscar_todos(div,url);
                $('#modal_copy_paste').modal('hide');
            }
        };
        xhraf.send(data);
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre del formato."});
        document.getElementById('txt_forma_descripccion_copyPaste').style.border = "1px solid #A94442";
        document.getElementById('lbl_forma_descripccion_copyPaste').style.color = "#A94442";
    }
}
function add_field(field, div, url, obj)
{   var obj_id = obj.attributes["id"].value;
    document.getElementById(obj_id).disabled = true;
    document.getElementById(div + '_load_gif').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var combo=field;
    var valor=combo.value;
    var texto = combo.options[combo.selectedIndex].text;
    var data = new FormData();
    data.append('event', 'get_campos');
    data.append('text',texto);
    data.append('value',valor);
    data.append('num_campo', parseInt(num_campos)+parseInt(1));
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', url , true);
    xhraf.onreadystatechange=function()
    {   if (xhraf.readyState==4 && xhraf.status==200)
        {   num_campos = num_campos+1;
            num_total_campos = num_total_campos+1;
            document.getElementById(div + '_load_gif').innerHTML="";
            var container = document.createElement("div");
            container.innerHTML = xhraf.responseText;
            document.getElementById(div).appendChild(container); //De esta forma no se borra el contenido del formulario al agregar o quitar.
            document.getElementById(obj_id).disabled = false;
            document.getElementById("lbl_num_total_campos").value = num_total_campos;
            $.growl.notice({title: 'Educalinks Informa:', message: 'Campo "' + texto + '" agregado.'});
            validate_save_button(num_total_campos);
        }
    };
    xhraf.send(data);
}
function get_formatos(div,url)
{   var data = new FormData();
    data.append('event', 'get_formatos');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
        }
    };
    xhrafe.send(data);
}
function get_formatos_copy_paste(div,url)
{   var data = new FormData();
    data.append('event', 'get_formatos_copy_paste');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
        }
    };
    xhrafe.send(data);
}
function js_debtAut_del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el formato seleccionado? Una vez eliminado no se podrá recuperar más."))
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('form_debi_codigo', codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                }
                js_debtAuto_mantenimiento_buscar_todos('div_tbl_format',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
            }
        };
        xhr.send(data);
    }
}
function js_debtAuto_mantenimiento_buscar_todos(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById('menu3_loader').innerHTML = '<span title="Cargando consulta"><br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div></span>';
    var data = new FormData();
    data.append('event', 'get_maint');
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML = xhrafe.responseText;
            $('#table_formato').addClass( 'nowrap' ).DataTable({
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                "bScrollAutoCss": true,
                "bProcessing": true,
                "bRetrieve": true,
                "sDom": '<"H"CTrf>t<"F"lip>',
                "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                "sScrollXInner": "110%",
                "fnInitComplete": function() {
                    this.css("visibility", "visible");
                },
                paging: true,
                lengthChange: true,
                searching: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center"  , "targets": [0]},
                    {className: "dt-body-left"  , "targets": [1]},
                    {className: "dt-body-center"  , "targets": [2]},
                    {className: "dt-body-center"  , "targets": [3]},
                    {className: "dt-body-center"  , "targets": [4]}
                ]
            });
            var table = $('#table_formato').DataTable();
            table.column( '1:visible' ).order( 'asc' );
            $('#btn_maint_buscar_todos').find(".glyphicon").removeClass("glyphicon-folder-close").addClass("glyphicon-folder-open");
            document.getElementById('menu3_loader').innerHTML = "";
            get_formatos_copy_paste('div_cmb_formato_copyPaste',document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php');
            $('#modal_copy_paste').on('hidden.bs.modal', function () {
                document.getElementById('txt_forma_descripccion_copyPaste').style.border = "1px solid #CCCCCC";
                document.getElementById('lbl_forma_descripccion_copyPaste').style.color = "black";
            });
        }
    };
    xhrafe.send(data);
}
function js_debtAut_toggle_readonly_tarj_banco( check, combo )
{   var chk_tneto = document.getElementById(check).checked;
    if(chk_tneto)
    {   document.getElementById(combo).disabled = false;
        document.getElementById(combo).value = "-1";
    }
    else
    {   document.getElementById(combo).disabled = true;
        document.getElementById(combo).value = "";
    }
}
function create_file_guardar(formulario, url)
{   var nombre = document.getElementById('hd_nombreformato').value;
    var id = document.getElementById('hd_id_cabecera').value;
    if(nombre.length > 0) //guardar directamente
    {   guarda_formato_como(formulario, url, nombre, id);
    }
    else //llamar modal primero
    {   $('#modal_formato').modal('show');
    }
}
function procesar_Archivo( div, url )
{   document.getElementById('btn_procesar_carga_xls').disabled = true;
    var data = new FormData();
    data.append( 'event',   'procesar_archivo' );
    data.append( 'textook', document.getElementById( 'textook' ).value);
    data.append( 'codeuda', document.getElementById( 'coddeuda' ).options[document.getElementById( 'coddeuda' ).selectedIndex].text );
    data.append( 'estado',  document.getElementById( 'estado' ).options[document.getElementById( 'estado' ).selectedIndex].text );
    data.append( 'valor',   document.getElementById( 'valor' ).options[document.getElementById( 'valor' ).selectedIndex].text );
    data.append( 'fecha_debito', document.getElementById( 'fecha_debito' ).value );
    document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Cargando pagos al sistema. Por favor, espere... Esta tarea puede tardar unos minutos.</div>';
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML=xhrafe.responseText;            
        }
    };
    xhrafe.send(data);
}
function get_procesar(div,url)
{   var data = new FormData();
    data.append( 'event', 'get_procesar' );
    data.append( 'filainicia', document.getElementById('filainicia').value );
    data.append( 'txt_fecha_debito', document.getElementById('txt_fecha_debito').value );
    var xhrafe = new XMLHttpRequest();
    xhrafe.open('POST', url , true);
    xhrafe.onreadystatechange=function()
    {   if (xhrafe.readyState==4 && xhrafe.status==200)
        {   document.getElementById(div).innerHTML=xhrafe.responseText;
        }
    };
    xhrafe.send(data);
}
function validasubirarchivo(formulario,div,url)
{   subirarchivo(formulario,div,url);
    return false;
}
function subirarchivo(formulario,div,url)
{   if ( document.getElementById('hd_caja_abierta').value ==  'false' )
    {   document.getElementById('procesar').innerHTML='<div class="callout callout-info">'+
                        '<h4><strong><li class="fa fa-exclamation"></li> Carga de archivo de débito bancario</strong></h4>'+
                        ' Usuario debe estar a <b>asignado a una caja</b> y/o'+
                        ' estar trabajando con una <b>caja abierta</b> para poder realizar esta operación.'+
                    '</div>';
    }
    else
    {   var file = document.getElementById( 'fileToUpload' ).value;
        var row = document.getElementById( 'filainicia' ).value;
        if(file)
        {   if(row)
            {   var r = confirm("¿Está seguro que desea cargar el archivo?");
                if (r)
                {   document.getElementById( 'evento' ).value='subir_archivo';
                    document.getElementById( 'btn_formato_nuevo_generar' ).disabled = true;
                    document.getElementById( formulario ).submit();
                    get_procesar( div, url );
                }
            }
            else
            {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el inicio de la cabecera."});
                document.getElementById('filainicia').style.border = "1px solid #A94442";
                document.getElementById('span_ig_filainicia').style.color = "#A94442";
                document.getElementById('span_ig_filainicia').style.background = "#F2DEDE";
                document.getElementById('span_ig_filainicia').style.border = "1px solid #A94442";
            }
        }
        else
        {   alert("Seleccione un archivo de su equipo, primero, para continuar.");
        }
    }
}
function closeself()
{    self.close;
}
function guarda_formato_como(formulario, url, formatonombre, id)
{   var f = formatonombre;
    var frm = document.getElementById(formulario);
    var nombre = "";
    var valor = "";
    var tipo = "";
    var formato = {};
    formato['nombre_formato'] = f;
    formato['id_formato'] = id;
    formato['detalles'] = [];
    var numero = 0;
    var numero_old = 1;
    var detalle = {};
    var i = 0;
    var orden = 1;
    for (i=0;i<frm.elements.length;i++)
    {   nombre=frm.elements[i].name;
        valor=frm.elements[i].value;
        var activado=frm.elements[i].checked;
        tipo=frm.elements[i].type;
        if((tipo=="checkbox" || tipo=="text" || tipo=="number") && ((nombre.substring(0,4)=="camp") || (nombre.substring(0,4)=="cabe") || (nombre.substring(0,4)=="nmax") || (nombre.substring(0,4)=="orde") || (nombre.substring(0,4)=="izqi") || (nombre.substring(0,4)=="dere") || (nombre.substring(0,4)=="cade") || (nombre.substring(0,4)=="caiz"))){
            numero=parseInt(nombre.substring(parseInt(nombre.indexOf("__"))+parseInt(2)));
            if(numero!=numero_old)
            {   numero_old=numero;
                formato['detalles'].push(detalle);
                detalle={};
            }
            var campo = nombre.substring(5,nombre.indexOf("__"));
            switch(nombre.substring(0,4))
            {   case 'cabe':
                    detalle['orden'] = orden;
                    detalle['cabecera'] = valor;
                    orden = orden + 1;
                break;
                case 'camp':
                    detalle['campo'] = campo;
                    detalle['text_predif'] = valor;
                break;
                case 'nmax':
                    detalle['num_caracteres'] = valor;
                break;
                case 'izqi':
                    if(activado){detalle['izquierda'] = 1;}else{detalle['izquierda'] = 0;}
                break;
                case 'dere':
                    if(activado){detalle['derecha'] = 1;}else{detalle['derecha'] = 0;}
                break;
                case 'cade':
                    detalle['caracder'] = valor;
                break;
                case 'caiz':
                    detalle['caracizq'] = valor;
                break;
            }
        }
    }
    formato['detalles'].push(detalle);
    var data = new FormData();
    var check=0,secuencia1=0,ubicacion=0;
    
    if(document.getElementById('secuencial').checked)
        check = 1;
    else
        check = 0;
    if(document.getElementById('secuencia').value!=='')
        secuencia1 = document.getElementById('secuencia').value;
    else
        secuencia1 = 0;
    if(document.getElementById('ubicacion').value!=='')
        ubicacion = document.getElementById('ubicacion').value;
    else
        ubicacion = 0;
    
    data.append('event', 'save_format' );
    data.append('formato', JSON.stringify( formato ) );
    data.append('check', check );
    data.append('iniciosecuencial', secuencia1 );
    data.append('ubicasecuencia', ubicacion );
    data.append('vista', document.getElementById('cmb_vista').value );
    var xhrej = new XMLHttpRequest();
    xhrej.open('POST', url , true);
    xhrej.onreadystatechange=function()
    {   if ( xhrej.readyState === 4 && xhrej.status === 200 )
        {   obj = JSON.parse(xhrej.responseText);
            var n = obj['mensaje'].length;
            if (n > 0)
            {   valida_tipo_growl(obj['mensaje']);
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
            }
            $('#modal_formato').modal('hide');
            cuadro_guardado_sin_modificacion(obj['hd_nombreformato'], obj['hd_id_cabecera']);
        }
    };
    xhrej.send(data);
}
function cuadro_guardado_sin_modificacion(nombreformato, id_cabecera)
{   document.getElementById('span_info_formato').innerHTML = ' "' + nombreformato + '"'; //nombre del formato
    document.getElementById('hd_nombreformato').value = nombreformato; //nombre del formato
    document.getElementById('hd_id_cabecera').value = id_cabecera; //nombre del formato
    document.getElementById('cmb_vista').disabled = true;
    validate_save_button_followed(true); //icono de guardado a green.
}
function guarda_formato(formulario,url)
{   if (!js_debtAuto_validar_formulario())
    {   var f = document.getElementById('forma_descripccion_add').value;
        var id = -1;
        if(f.length>0)
        {   guarda_formato_como(formulario, url, f, id);
        }
        else
        {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre del formato."});
            document.getElementById('forma_descripccion_add').style.border = "1px solid #A94442";
            document.getElementById('lbl_forma_descripccion_add').style.color = "#A94442";
        }
    }
    else
    {   $('#modal_formato').modal('toggle');
        var mensaje = "Ning&uacute;n campo 'Nombre cabecera' puede ir vac&iacute;o. Por favor, complete.";
        $.growl.error({title: 'Educalinks Informa', message: "No se realizaron los cambios, faltan datos importantes."});
    }
}
function js_debtAuto_validar_formulario()
{   var validador=false;
    var i = 0;
    for (i = 1; i <= num_campos; i++)
    {   if(document.getElementById( 'cabe_campo_'+ i +'__'+ i ))
        {   if(document.getElementById( 'cabe_campo_'+ i +'__'+ i ).value.length<=0)
            {   validador=true;
            }
        }
    }
    return validador;
}
function js_debtAuto_cmb_tipo_formato_onchange(obj, div)
{   var formato = obj.value;
    if (formato != 'xlsx')
    {   $(document.getElementById(div)).collapse(200).collapse('show');
    }
    else
    {   $(document.getElementById(div)).collapse(200).collapse('hide');
    }
}
function js_debtAut_genera_archivo()
{   if($('#span_status_disk').hasClass('glyphicon glyphicon-floppy-saved'))
    {   $('#modal_exportarFormatoArchivo').modal('show');
        document.getElementById('chk_banco').checked = true;
        document.getElementById('chk_tarjeta').checked = true;
        document.getElementById('cmb_banco').disabled = false;
        document.getElementById('cmb_tarjCredito').disabled = false;
        $("#cmb_banco option[value='']").remove();
        $("#cmb_tarjCredito option[value='']").remove();
        document.getElementById('cmb_banco').value = -1;
        document.getElementById('cmb_tarjCredito').value = -1;
        document.getElementById('forma_descripccion_exp').innerHTML = "<small>Exportando archivo con el formato de '<b>" + document.getElementById('hd_nombreformato').value + "</b>'.</small>";
        document.getElementById('hd_id_formato_exp').value = document.getElementById('hd_id_cabecera').value;
    }
    else
    {   alert("¡Debe guardar los cambios, primero!");
    }
}
function js_debtAut_genera_archivo_followed(formulario)
{   document.getElementById('evento').value='create_file';
    var txt;
    var r = confirm("¿Exportar formato ahora?");
    if (r)
    {   document.getElementById(formulario).submit();
    }
}
function js_debtAut_genera_archivoind(codigo_formato)
{   $('#modal_exportarFormatoArchivo').modal('show');
    document.getElementById('chk_banco').checked = true;
    document.getElementById('chk_tarjeta').checked = true;
    document.getElementById('cmb_banco').disabled = false;
    document.getElementById('cmb_tarjCredito').disabled = false;
    $("#cmb_banco option[value='']").remove();
    $("#cmb_tarjCredito option[value='']").remove();
    document.getElementById('cmb_banco').value = -1;
    document.getElementById('cmb_tarjCredito').value = -1;
        
    document.getElementById('cmb_formato_copyPaste').value = codigo_formato;
    var sel = document.getElementById('cmb_formato_copyPaste');
    var nombre_formato = sel.options[sel.selectedIndex].text;
    document.getElementById('forma_descripccion_exp').innerHTML = "<small>Exportando archivo con el formato de '<b>" + nombre_formato + "</b>'.</small>";
    document.getElementById('hd_id_formato_exp').value = codigo_formato;
}
function cambia_check(obj)
{   "use strict";
    var chk_nombre = obj.attributes["name"].value;
    var wordsToFind = ["izqi_", "*izqi_*"];
    var nombre = "";
    if (chk_nombre.toLowerCase().indexOf(wordsToFind[0]) === 0 || chk_nombre.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   nombre = chk_nombre.replace("izqi_", "");
        if(obj.checked)
        {   document.getElementById("caiz_" + nombre).disabled = false;
            document.getElementById("cade_" + nombre).disabled = true;
            document.getElementById("cade_" + nombre).value = "";
            document.getElementById("dere_" + nombre).checked = false;
        }else
        {   document.getElementById("caiz_" + nombre).disabled = true;
            document.getElementById("caiz_" + nombre).value = "";
        }
    }
    wordsToFind = ["dere_", "*dere_*"];
    if (chk_nombre.toLowerCase().indexOf(wordsToFind[0]) === 0 || chk_nombre.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   nombre = chk_nombre.replace("dere_", "");
        if(obj.checked)
        {   document.getElementById("cade_" + nombre).disabled = false;
            document.getElementById("caiz_" + nombre).disabled = true;
            document.getElementById("caiz_" + nombre).value = "";
            document.getElementById("izqi_" + nombre).checked = false;
        }else
        {   document.getElementById("cade_" + nombre).disabled = true;
            document.getElementById("cade_" + nombre).value = "";
        }
    }
}
function cambia_check_sec(obj)
{   "use strict";
    if(obj.checked)
    {   document.getElementById("secuencia").disabled=false;
        document.getElementById("ubicacion").disabled=false;
    }
    else
    {   document.getElementById("secuencia").disabled=true;
        document.getElementById("ubicacion").disabled=true;
        document.getElementById("secuencia").value="";
        document.getElementById("ubicacion").value="";
    }
    validate_save_button_followed(false);
}
function js_debtAut_change_view()
{   var vista = document.getElementById('cmb_vista').value;
    var r= confirm("Cambiar el recurso de datos implica iniciar un formato nuevo. ¿Terminar edición de formato actual? Los cambios no guardados se perderán.");
    if (r)
    {   limpia_crear_formato();
        document.getElementById('hd_nombreformato').value = "";
        document.getElementById('hd_id_cabecera').value = "";
        document.getElementById('span_info_formato').innerHTML = "";
    }
    var data = new FormData();
    data.append('event', 'cambiar_vista');
    data.append('vista', vista);
    var xhraf = new XMLHttpRequest();
    xhraf.open('POST', document.getElementById('ruta_html_finan').value + '/debitosAutomaticos/controller.php', true);
    xhraf.onreadystatechange=function()
    {   if ( xhraf.readyState === 4 && xhraf.status === 200 )
        {   //$('#modal_cargarFormatoArchivo').modal('hide');
            document.getElementById('div_cmb_campos').innerHTML = xhraf.responseText;
            document.getElementById('hd_vista').value = vista;
            document.getElementById('cmb_vista').value = vista;
        }
    };
    xhraf.send(data);
}
function disableizq()
{
}
function disableder()
{
}