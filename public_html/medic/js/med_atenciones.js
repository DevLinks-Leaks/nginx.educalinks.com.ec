/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var counter=0;
function carga_ficha_med_formulario_pdf( fmex_codi )
{   var data = new FormData();
	var url2 = document.getElementById( "ruta_html_medic" ).value + '/ficha_nuevo/controller.php?event=print_ficha_med_pdf&fmex_codi=' + fmex_codi;
	window.open(url2);
}
function carga_ficha_medica( alum_codi, div_body,  url )
{   document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var perX  = 'perMain'; 
	var data = new FormData();
	data.append( 'option', 'get_ficha_med_listado_individual' );
	data.append( 'alum_codi', alum_codi );
	data.append( 'is_back' , 1 );
	var xhr = new XMLHttpRequest(  );
	xhr.open( 'POST', url , true );
	xhr.onreadystatechange=function(  )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   if ( xhr.responseText.length > 0 )
			{   document.getElementById( div_body ).innerHTML = xhr.responseText;
				$('#tbl_ficha_med_consulta').DataTable({
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
						{className: "dt-body-center"  , "targets": [1]},
						{className: "dt-body-center"  , "targets": [2]},
						{className: "dt-body-center"  , "targets": [3]},
						{className: "dt-body-center"  , "targets": [4]},
						{className: "dt-body-center"  , "targets": [5]},
						{className: "dt-body-center"  , "targets": [6]}
					]
				});
				var table = $('#tbl_ficha_med_consulta').DataTable();
				table.column( '2:visible' ).order( 'asc' );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
											" Si el problema persiste, comuníquese con soporte." });
			}
		}
	};
	xhr.send(data);
}
function carga_materias(div,url,alum_codi,curs_para_codi){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','carga_materias');
    data.append('alum_codi',alum_codi);
    data.append('curs_para_codi',curs_para_codi);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
        }
    }
    xhr_tick_ok.send(data);
}
function carga_alergias(div,url,alum_codi){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','carga_alergias');
    data.append('alum_codi',alum_codi);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
        }
    }
    xhr_tick_ok.send(data);
}

function carga_profesor(select,atr1,inp1,atr2,inp2){   
    var element = $('#'+select).find('option:selected'); 
    var myTag = element.attr(atr1); 
    $('#'+inp1).val(myTag);
    var myTag2 = element.attr(atr2); 
    $('#'+inp2).val(myTag2);
}

function addZero(i)
{   if (i < 10)
	{   i = "0" + i;
    }
    return i;
}
function mueveReloj()
{   momentoActual = new Date();
    hora = momentoActual.getHours();
    minuto = momentoActual.getMinutes();
    segundo = momentoActual.getSeconds();

    horaImprimible = addZero(hora) + " : " + addZero(minuto) + " : " + addZero(segundo);

    document.getElementById("reloj").value = horaImprimible;

    setTimeout("mueveReloj()",1000);
}
function carga_stock(div,url,med_codigo){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('option','carga_stock');
    data.append('med_codigo',med_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            
            $('#table_tratamientos tbody tr').each(function(){
                if($(this).find('td').eq(1).text()==$("#medicamentos option:selected").text()){
                    var cell = parseInt($(this).find('td').eq(2).text());
                    $("#stock_med").val(parseInt($("#stock_med").val())-cell);
                }
            });
        }
    }
    xhr_tick_ok.send(data);
}
function agrega_tratamiento(tratamiento,cantidad,stock,tabla,btn){
    counter=counter+1;
    var t = $('#'+tabla).DataTable();
    var codigo=$("#"+tratamiento).val();
    var existe_medicina=0;
    $('#'+tabla+' tbody tr').each(function(){
        if($(this).find('td').eq(1).text()==$("#"+tratamiento+" option:selected").text()){
            existe_medicina=existe_medicina+1;
            var cell = t.cell( $(this).find('td').eq(2) );
            cell.data( parseInt(cell.data()) + parseInt($("#"+cantidad).val()) ).draw();
        }
    });
    if(existe_medicina==0){
        t.row.add(
                [counter,
                "<input id='cod_med_"+counter+"' name='cod_med_"+counter+"' type='hidden' value='"+codigo+"'/>"+$("#"+tratamiento+" option:selected").text(),
                $("#"+cantidad).val(),
                "<span class='glyphicon glyphicon-trash cursor_link' onclick='elimina_fila("+counter+");'></span>"]).draw( false );
    }
    $("#"+stock).val($("#"+stock).val()-$("#"+cantidad).val());
    $("#"+btn).button('reset');
    $("#"+cantidad).val("");
}
function elimina_fila(idx){
    var t = $('#table_tratamientos').DataTable();
    $("#table_tratamientos tbody tr").each(function(){
        if($(this).find('td').eq(0).text()==idx){
            t.rows($(this)).remove().draw();	
        }
    });
}
function deshabilita_boton(btn){   
    /*$("#"+btn).button('complete');*/
    return "complete";
}
function habilita_boton(btn){
    $('#'+btn).prop('disabled', false);
    return "fail";
}
function agrega_atencion(div,url,btn){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var atencion = {};
    atencion['cabecera'] = {};
    atencion['cabecera']['alum_codi'] = $('#alum_codi').val();
    atencion['cabecera']['mate_codi'] = $('#mate_alum_curso').val();
    atencion['cabecera']['curs_para_codi'] = $('#curs_para_codi').val();
    atencion['cabecera']['prof_codi'] = $('#prof_codi').val();
    atencion['cabecera']['motivo_id'] = $('#motivo_id').val();
    atencion['cabecera']['observaciones'] = $('#observaciones').val();
    atencion['cabecera']['motivo'] = $('#motivo').val();
    atencion['detalle'] = [];
    var idx
    $("#table_tratamientos tbody tr").each(function(){
        idx=$(this).find('td').eq(0).text();
        var detalle = {};
        detalle['med_codigo'] = $("#cod_med_"+idx).val();
        detalle['med_cantidad'] = $(this).find('td').eq(2).text();
        atencion['detalle'].push(detalle);
    });
    
    var data = new FormData();
    data.append('option','agrega_atencion');
    data.append('atencion_json',JSON.stringify(atencion));
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var result=deshabilita_boton($("#"+btn).attr("id"));
            $("#"+btn).button(result);
            if(document.getElementById('compr_tipo').checked){
                $("#frm_impr").attr("action", "comprobante_salida.php");
            }else{
                $("#frm_impr").attr("action", "comprobante_atencion.php");
            }
            document.frm_impr.submit();
            limpiar_pagina()
        }
    }
    xhr_tick_ok.send(data);
}
function agrega_atencion_personal(div,url,btn){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var atencion = {};
    atencion['cabecera'] = {};
    atencion['cabecera']['usua_codi'] = $('#alum_codi').val();
    atencion['cabecera']['usua_tipo'] = $('#usua_tipo').val();
    atencion['cabecera']['motivo_id'] = $('#motivo_id').val();
    atencion['cabecera']['observaciones'] = $('#observaciones').val();
    atencion['cabecera']['motivo'] = $('#motivo').val();
    atencion['detalle'] = [];
    var idx
    $("#table_tratamientos tbody tr").each(function(){
        idx=$(this).find('td').eq(0).text();
        var detalle = {};
        detalle['med_codigo'] = $("#cod_med_"+idx).val();
        detalle['med_cantidad'] = $(this).find('td').eq(2).text();
        atencion['detalle'].push(detalle);
    });
    
    var data = new FormData();
    data.append('option','agrega_atencion_personal');
    data.append('atencion_json',JSON.stringify(atencion));
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
            var result=deshabilita_boton($("#"+btn).attr("id"));
            $("#"+btn).button(result);
            if(document.getElementById('compr_tipo').checked){
                $("#frm_impr").attr("action", "comprobante_salida_personal.php");
                document.frm_impr.submit();
            }            
            limpiar_pagina()
        }
    }
    xhr_tick_ok.send(data);
}
function limpiar_pagina(){
    document.frm_actu.submit();
}