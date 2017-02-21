$(document).ready(function()
{   js_facturas_consultaMetodoDescuento();
	$("#modal_adicionProducto_body").on("shown.bs.modal", function ()
	{	//do nothing.
	});
	$("#fechaInicio_add").datepicker();
	$("#fechaFin_add").datepicker();
	$("#fechaInicio_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	$("#fechaFin_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
});
var hay_descuento = 0;
var metodo_descuento = "";
var JSON_descuento = JSON.parse('[]');
function carga_busquedaCliente(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'buscar_clientes');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#clientes_table').DataTable({
                "info": false,
                "ordering": true,
                "searching":false,
                "lengthChange":false,
                "paging":true,
                "retrieve" : true
            });
        } 
    };
    xhr.send(data);
}
// Manda los datos del cliente seleccionado a la pagina de la factura (deuda)
function js_factura_selecciona( div_buttons, div_body, tipo_persona )
{   limpiaPagina('false');
    var codigoCliente = $('#persona_table tr.selected').find('td:nth-child(1)').text();
    $('#hd_tipo_persona').val( tipo_persona );
    $('#codigoCliente').val( codigoCliente );
    $('#numeroIdentificacionCliente').val($('#persona_table tr.selected').find('td:nth-child(2)').text());
    $('#nombresCliente').val($('#persona_table tr.selected').find('td:nth-child(3)').text());

    // === Consulta de los datos del titular del cliente seleccionado
    var data = new FormData();
    data.append('event', 'get_cliente_info_adicional');
    data.append('codigoCliente', codigoCliente );
    data.append('tipo_persona', tipo_persona );
    var nivel='';
    var grupo='';
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   // Parse del JSON enviado desde PHP
            //console.log( codigoCliente );
            if( xhr.responseText.length > 0 )
            {   var respuesta = JSON.parse(xhr.responseText);
                if( respuesta[0].codigoGrupoEconomico === null )
                {   grupo='-1';
                }
                else
                {   grupo=respuesta[0].codigoGrupoEconomico;
                }
                $('#txt_grupo_economico').attr("data-codigo",grupo);
                $('#txt_grupo_economico').val(respuesta[0].nombreGrupoEconomico);
                $('#txt_curso').attr("data-codigo",respuesta[0].codigoCurso);
                $('#txt_curso').val(respuesta[0].nombreCurso);
            
                if(respuesta[0].codigoNivelEconomico === null )
                {   nivel = '-1';
                }
                else
                {   nivel = respuesta[0].codigoNivelEconomico;
                }
                $('#txt_nivel_economico').attr("data-codigo",nivel);
                
                $('#txt_nivel_economico').val(respuesta[0].nombreNivelEconomico);
                $('#numeroIdentificacionTitular').val(respuesta[0].cedulatitular);
                $('#nombreTitular').val(respuesta[0].nombretitular);
                $('#emailTitular').val(respuesta[0].emailtitular);
                $('#telefonoTitular').val(respuesta[0].telefonotitular);
                $('#direccionTitular').val(respuesta[0].direcciontitular);
                var sql_tipo_id = "";
                if ( !respuesta[0].tipoid )
                {   sql_tipo_id = 'CI';
                    if(respuesta[0].cedulatitular.length == 10)
                        sql_tipo_id = 'CI';
                    if(respuesta[0].cedulatitular.length == 13)
                        sql_tipo_id = 'RUC';
                }
                else
                    sql_tipo_id = respuesta[0].tipoid;
                $('#tipoIdentificacionTitular').val( sql_tipo_id );
                if( tipo_persona == 1 )
                {   carga_cliente_opciones(codigoCliente,'client_options');
                    document.getElementById('div_datos_academicos_estudiante').style.display="inline";
                }
                else
                {   document.getElementById('client_options').innerHTML="";
                    document.getElementById('div_datos_academicos_estudiante').style.display="none";
                }
            }
            else
            {   $('#txt_grupo_economico').val('');
                $('#txt_grupo_economico').attr("data-codigo","");
                $('#txt_curso').val('');
                $('#txt_nivel_economico').val('');
                $('#txt_nivel_economico').attr("data-codigo","");
            }
        }
    };
    xhr.send(data);
}
// Carga el formulario para buscar y agregar un nuevo producto al detalle
function carga_adicionarProducto(div, url)
{   var data = new FormData(  );
    var xhr = new XMLHttpRequest(  );
    if( $('#codigoCliente').val() !== "" )
    {   if( $('#hd_tipo_persona').val() == "1" )
        {   if( $('#txt_curso').val() !== "" )
            {   if( $('#txt_grupo_economico').val( ) === "" )
                    $.growl.warning({ title: 'Educalinks informa', message: 'El alumno no tiene asignado "grupo económico".' });
            }
            else
                $.growl.error({ title: 'Educalinks informa', message: 'Debe inscribir al alumno en un curso primero para poder generarle una deuda.' });
        }
		data.append('event', 'agregar_producto');
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState === 4 && xhr.status === 200 )
			{   document.getElementById(div).innerHTML=xhr.responseText;
				$('#modal_adicionProducto').modal('show');
			}
		};
		xhr.send(data);
    }
    else
    {   document.getElementById( div ).innerHTML = "";
        $.growl.warning({ title: 'Educalinks informa', message: 'Consulte a un cliente para continuar.' });
    }
}
// Consulta los productos de una categoria especifica
function cargaProductos(div, url){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboCategoria = document.getElementById("codigoCategoria_busq");
    var data = new FormData();
    data.append('codigoCategoria', comboCategoria.options[comboCategoria.selectedIndex].value);    
    data.append('event', 'get_product');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
        } 
    };
    xhr.send(data);
}
// Consulta los productos de una categoria especifica
function mostrar_mensaje_error_cambio_metodo( div )
{   document.getElementById( div ).innerHTML=
		"<div id='facturasGeneradas' class='form-group'>" +
			"<div class='callout callout-danger' role='alert'>" +
				"<h4><i class='icon fa fa-info-circle'></i> Método de descuento cambiado</h4>" +
				"<p>No se pudo completar la operación porque parece ser que el método de descuento que " +
				" utiliza el sistema ha sido cambiado en medio de una operación. Por favor, restaurar el " +
				" método de sistema determinado o comuníquese con su supervisor de sistemas.</p>" +
			"</div>" +
		"</div>";
	//console.log( div );
	//console.log( document.getElementById( div ).innerHTML );
}
function js_facturas_buscaPrecio(url)
{   document.getElementById('precio_busq').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboProducto = document.getElementById("codigoProducto_busq");
    var codigocliente = document.getElementById("codigoCliente");
    var total = 0;
    var descuento = 0;
    var descuento_total = 0;
    var data = new FormData();
    var descuento_mucho_table = "<span style='font-size:small;'><i class='fa fa-info-circle'></i> Descuento aplicado sobre descuento</span>";
    data.append('event', 'get_price');
    data.append('codigoProducto', comboProducto.options[comboProducto.selectedIndex].value);
    data.append('codigoGrupoEconomico', $('#txt_grupo_economico').attr('data-codigo'));
    data.append('codigoNivelEconomico', $('#txt_nivel_economico').attr('data-codigo'));
    data.append('codigoCliente', codigocliente.value);
    
    //data.append('codigoCurso', $('#txt_curso').attr('data-codigo'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   var respuesta = JSON.parse(xhr.responseText);
            //console.log( xhr.responseText );
            
            $('#precio_busq').val(respuesta.precio); // Precio 
            total = parseFloat( respuesta.precio );
            document.getElementById('precio_busq').dataset.iva = respuesta.aplicaIVA; // Si lleva o no IVA
            
            $('#porcentajeIva_busq').val( respuesta.porcentajeIva );
            //console.log( respuesta );
            if( respuesta.descuento == 1 )
            {   hay_descuento += 1;
				if ( metodo_descuento === "desc_sobre" )
                {   JSON_descuento = respuesta.descuentoAsignado;
					var i = 0;
					descuento_mucho_table = descuento_mucho_table.concat('<table class="table table-bordered table-hover" id="descuento_mucho_table" name="descuento_mucho_table ">');
					descuento_mucho_table =  descuento_mucho_table.concat('<tr><td style="text-align:center;" ><b>Descuento (%)</b></td><td style="text-align:center;" ><b>Descuento (-)</b></td></tr>');
					for ( i = 0; i < respuesta.descuentoAsignado.length; i++ )
					{   $('#descuentoAsignado_busq').val( 0 );
						descuento = ( ( total )*( parseFloat(respuesta.descuentoAsignado[i].descuento) / 100 ) ).toFixed(2);
						descuento_total += descuento;
						$('#descuento_busq').val( descuento_total );
						total = total - descuento;
						descuento_mucho_table =  descuento_mucho_table.concat('<tr><td style="text-align:right;">'+respuesta.descuentoAsignado[i].descuento+'</td><td style="text-align:right;" >(-) $' + descuento+ '</td></tr>');
						descuento_mucho_table =  descuento_mucho_table.concat('<tr><td></td><td style="text-align:right;" >(=)$'+total+'</td></tr>');
					}
					descuento_mucho_table =  descuento_mucho_table.concat('</table>');
					$('#total_busq').val( total );
					document.getElementById('div_descuento_mucho_busq').innerHTML = descuento_mucho_table;
					document.getElementById('div_descuento_mucho_busq').style.display = 'inline';
					document.getElementById('div_descuento_poco_busq').style.display = 'none';
					calculaTotalesAsignacion();
                }
                else
                {   var v_desc_sumado = 0;
					var v_desc_sumado_per = 0;
					if (respuesta.descuentoAsignado[0])
					{	v_desc_sumado = respuesta.descuentoAsignado[0].descuento;
						v_desc_sumado_per = respuesta.descuentoAsignado[0].descuento / 100;
					}
						
					else
					{   v_desc_sumado = 0;
						v_desc_sumado_per = 1;
					}
					$('#descuentoAsignado_busq').val( v_desc_sumado );
					descuento = ( respuesta.precio )*( v_desc_sumado_per );
					$('#descuento_busq').val( descuento );
					total = total - descuento;
					$('#total_busq').val( total );
					document.getElementById('div_descuento_mucho_busq').style.display = 'none';
					document.getElementById('div_descuento_poco_busq').style.display = 'inline';
					calculaTotalesAsignacion();
                }
            }
            else
            {   $('#descuentoAsignado_busq').val( 0 );
                descuento=0;
                $('#descuento_busq').val( descuento );
                total=( respuesta.precio );
                $('#total_busq').val( total );
                document.getElementById('div_descuento_mucho_busq').style.display = 'none';
                document.getElementById('div_descuento_poco_busq').style.display = 'inline';
				calculaTotalesAsignacion();
            }
        }
    };
    xhr.send(data);
}
function calculaTotalesAsignacion()
{   var aplicaIVA = document.getElementById('precio_busq').dataset.iva;
    var iva = $('#porcentajeIva_busq').val();
	var  descuento = $('#descuentoAsignado_busq').val();//PENDIENTE
    calculaValores('precio_busq', 'cantidad_busq', 'iva_busq', 'descuento_busq', 'total_busq', descuento, iva, aplicaIVA );
}
/*function calculaTotalesModificacion()
{   var aplicaIVA = $('#ivaDetalle').attr('data-iva');
    var iva = $('#porcentajeIva_busq').val();
    var descuento = $('#descuentoAsignado_busq').val();//PENDIENTE
    calculaValores('precioDetalle', 'cantidadDetalle', 'ivaDetalle', 'descuentoDetalle', 'totalDetalle', descuento, iva, aplicaIVA);
}*/
function calculaValores(divPrecio, divCantidad, divIVA, divDescuento, divTotal, descuento, iva, aplicaIVA )
{   var descuento_mucho_table = "";
	var totalBrutoInicial = parseFloat( document.getElementById(divPrecio).value * document.getElementById(divCantidad).value ).toFixed(2);
    var totalBruto = totalBrutoInicial;
	var totalIVA = 0.00;
    var totalDescuento = 0.00;
    var totalNeto = 0.00;
		//console.log( totalBruto );
		//console.log( totalDescuento );
	if ( metodo_descuento === "desc_sobre" )
	{   var aux = 0; 
		descuento = 0.00;
		descuento_mucho_table = descuento_mucho_table.concat('<table class="table table-bordered table-hover" id="descuento_mucho_table" name="descuento_mucho_table ">');
		descuento_mucho_table =  descuento_mucho_table.concat('<tr><td style="text-align:center;" ><b>Descuento (%)</b></td><td style="text-align:center;" ><b>Descuento (-)</b></td></tr>');
		for ( aux = 0; aux < JSON_descuento.length; aux++ )
		{   $('#descuentoAsignado_busq').val( 0 );
			descuento = ( totalBruto )*( JSON_descuento[aux].descuento / 100 );
			totalDescuento += descuento;
			$('#descuento_busq').val( totalDescuento );
			totalBruto = totalBruto - descuento;
			descuento_mucho_table =  descuento_mucho_table.concat('<tr><td style="text-align:right;">'+JSON_descuento[aux].descuento+'</td><td style="text-align:right;" >(-) $'+descuento+'</td></tr>');
			descuento_mucho_table =  descuento_mucho_table.concat('<tr><td></td><td style="text-align:right;" >(=)$'+totalBruto+'</td></tr>');
			
            //console.log( totalBruto );
			//console.log( totalDescuento );
		}
		descuento_mucho_table =  descuento_mucho_table.concat('</table>');
		$('#total_busq').val( totalBruto );
		document.getElementById('div_descuento_mucho_busq').innerHTML = descuento_mucho_table;
		document.getElementById('div_descuento_mucho_busq').style.display = 'inline';
		document.getElementById('div_descuento_poco_busq').style.display = 'none';

		if(aplicaIVA == 1)
		{   totalIVA = parseFloat(((totalBrutoInicial - totalDescuento) * iva)/100).toFixed(2);
		}
		$('#'+divDescuento).val( parseFloat(totalDescuento).toFixed(2) );
		$('#'+divIVA).val( parseFloat(totalIVA).toFixed(2) );
		$('#'+divTotal).val( (parseFloat(totalBrutoInicial) - parseFloat(totalDescuento) + parseFloat(totalIVA)).toFixed(2) );		
	}
	if ( metodo_descuento === "desc_sumado" )
	{   totalBruto = parseFloat( document.getElementById(divPrecio).value * document.getElementById(divCantidad).value ).toFixed(2);
		totalDescuento = parseFloat((totalBruto * descuento) / 100).toFixed(2);
		if(aplicaIVA == 1)
		{   totalIVA = parseFloat(((totalBruto - totalDescuento) * iva)/100).toFixed(2);
		}
		$('#'+divDescuento).val( parseFloat(totalDescuento).toFixed(2) );
		$('#'+divIVA).val( parseFloat(totalIVA).toFixed(2) );
		$('#'+divTotal).val( (parseFloat(totalBruto) - parseFloat(totalDescuento) + parseFloat(totalIVA)).toFixed(2) );	
		document.getElementById('div_descuento_mucho_busq').style.display = 'none';
		document.getElementById('div_descuento_poco_busq').style.display = 'inline';	
	}
}
/*
==================================================================================================================
 CAMBIAR PARA AGREGAR LO DEL DESCUENTO Y LO DEL IVA
==================================================================================================================
*/
function randomString()
{   var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++)
    {   var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring( rnum, rnum + 1 );
    }
    //document.randform.randomfield.value = randomstring;
    return randomstring;
}
// Actualiza el total neto de la factura (Parte superior derecha de la pagina)
function actualizaTotalFactura()
{   var total = 0;
    $('#detalleFactura_table tbody tr').each(function(){
        var subtotalLinea = parseFloat($(this).find('td').eq(6).text());
        total += subtotalLinea;
    });
    $('#totalNetoFactura').val( parseFloat(total).toFixed(2) );    
}
// Agrega el producto al detalle
function AddItemToDetail(url)
{   if($('#precio_busq').val() !==''  &&  $('#precio_busq').val() > 0)
    {   if($('#cantidad_busq').val() !=='' &&  $('#cantidad_busq').val() >= 1)
        {   var claveDetalle = randomString(); // Identificador unico para cada linea del detalle.
            // Agrega el producto con los valores calculados al detalle de la factura
            var opcionA = "";//"<span onclick='cargaEditProducto("+'"'+claveDetalle+'","'+'modal_modificacionLinea_body'+'","'+url+'"'+")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_modificarLinea' onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement=\"left\"></span>&nbsp;";
            var opcionB = "<span onclick='remueveProductoFromDetail("+'"'+claveDetalle+'","'+'DIV_MODAL'+'","'+url+'"'+")' class='btn_opc_lista_eliminar glyphicon glyphicon-remove-circle cursorlink' aria-hidden='true' onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='bottom'></span>";
            var aplicaIVA = 0;
            if(document.getElementById('precio_busq').hasAttribute('data-iva'))
            {   aplicaIVA = $('#precio_busq').attr('data-iva');
            }

            var nuevaLinea = "<tr>";    
            nuevaLinea += "<td style='text-align:center;' data-linea='"+claveDetalle+"' data-codigo='"+$('#codigoCategoria_busq option:selected').val()+"'>"+$('#codigoCategoria_busq option:selected').text()+"</td>";
            nuevaLinea += "<td style='text-align:center;' data-codigo='"+$('#codigoProducto_busq option:selected').val()+"'>"+$('#codigoProducto_busq option:selected').text()+"</td>";
            nuevaLinea += "<td style='text-align:right;'>"+$('#precio_busq').val()+"</td>";
            nuevaLinea += "<td style='text-align:center;'>"+$('#cantidad_busq').val()+"</td>";
            nuevaLinea += "<td style='text-align:right;'>"+$('#descuento_busq').val()+"</td>";//PENDIENTE
            nuevaLinea += "<td style='text-align:right;' data-aplica='"+ aplicaIVA +"'>"+$('#iva_busq').val()+"</td>";
            nuevaLinea += "<td style='text-align:right;'>"+$('#total_busq').val()+"</td>";
            nuevaLinea += "<td style='text-align:center;'>"+opcionA+opcionB+"</td>";
            nuevaLinea += "</tr>";
            $('#detalleFactura_table tbody').append(nuevaLinea);

            // Actualiza el Total Neto de la factura
            actualizaTotalFactura();

            // Deshabilita las opciones de cambio de villa y de cliente (Por razon del precio)
            $('#btnBuscarCliente').attr("disabled","disabled");
        }
        else
        {   alert('No se agregará el producto al detalle proque no ha definido la cantidad');    
            $.growl.error({ title: 'Educalinks informa', message: 'Definir la cantidad que desea cobrar primero para continuar.' });
        }
    }
    else
    {   alert('No se agregará el producto al detalle proque no se ha definido el precio');
        $.growl.error({ title: 'Educalinks informa', message: 'Asignar un precio al producto primero para continuar.' });
    }
}
// Carga el formulario que contendra los datos de una linea especifica del detalle para ser modificada la cantidad
function cargaEditProducto(idDetalle, div, url)
{   if($('#codigoCliente').val() !== "")
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var nombreCategoria = '', codigoCategoria = '', nombreProducto  = '', codigoProducto  = '';
        var precio = '', cantidad = '', descuento = '', aplicaIVA = '0', iva = '', subtotal = '';    
        $('#detalleFactura_table tbody tr').each(function()
        {   if( $(this).find('td').eq(0).attr("data-linea").trim() == idDetalle.trim() )
            {   nombreCategoria = $(this).find('td').eq(0).text();
                codigoCategoria = $(this).find('td').eq(0).attr("data-codigo");
                nombreProducto  = $(this).find('td').eq(1).text();
                codigoProducto  = $(this).find('td').eq(1).attr("data-codigo");
                precio = $(this).find('td').eq(2).text();
                cantidad = $(this).find('td').eq(3).text();
                descuento = $(this).find('td').eq(4).text();
                iva = $(this).find('td').eq(5).text();
                aplicaIVA = $(this).find('td').eq(5).attr("data-aplica");
                subtotal = $(this).find('td').eq(6).text();    
            }
        });

        var data = new FormData();
        data.append('event', 'modificar_detalle');
        data.append('idDetalle', idDetalle);
        data.append('codigoCategoria', codigoCategoria);
        data.append('nombreCategoria', nombreCategoria);
        data.append('codigoProducto', codigoProducto);
        data.append('nombreProducto', nombreProducto);
        data.append('aplicaIVA', aplicaIVA);
        data.append('precio', precio);
        data.append('cantidad', cantidad);
        data.append('descuento', descuento);
        data.append('iva', iva);
        data.append('subtotal', subtotal);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   document.getElementById(div).innerHTML=xhr.responseText;
            } 
        };
        xhr.send(data);
    }
    else
    {   alert('Consulte primero al cliente!');
        $.growl.error({ title: 'Educalinks informa', message: 'Consultar al cliente primero para continuar.' });
    }
}
// Modifica una linea de detalle especifica (Producto)
function EditDetail(url)
{   if($('#cantidadDetalle').val() !=='' &&  $('#cantidadDetalle').val() >= 1)
    {   if(confirm("¿Está seguro de actualizar el detalle seleccionado?"))
        {   $('#detalleFactura_table tbody tr').each(function()
            {   if( $(this).find('td').eq(0).attr("data-linea").trim() == $('#idDetalle').val().trim() )
                {   $(this).find('td').eq(3).text($('#cantidadDetalle').val());
                    $(this).find('td').eq(4).text($('#descuentoDetalle').val());
                    $(this).find('td').eq(5).text($('#ivaDetalle').val());
                    $(this).find('td').eq(6).text($('#totalDetalle').val());
                }
            });
        }
    }
    else
    {   alert('No se actualizará el detalle proque no ha definido la cantidad');
        $.growl.error({ title: 'Educalinks informa', message: 'Definir la cantidad que desea cobrar primero para continuar.' });
    }
    actualizaTotalFactura();
}
// Quita una linea especifica del detalle de la factura
function remueveProductoFromDetail(idDetalle, div, url)
{   if(confirm("¿Está seguro de quitar el producto seleccionado?"))
    {   $('#detalleFactura_table tbody tr').each(function()
        {   if( $(this).find('td').eq(0).attr("data-linea").trim() == idDetalle.trim() )
            {   $(this).remove();
            }
        });
            
        // Vuelve a habilitar los controles deshabilitados 
        if($('#detalleFactura_table tbody tr').length <= 0)
        {   $('#btnBuscarCliente').removeAttr("disabled");                
        }
        // Actualiza el Total Neto de la factura
        actualizaTotalFactura();
    }
}
function limpiaPaginaPreguntar(albedrio)
{   var confirmacion = true;
    if(albedrio)
    {   confirmacion = confirm("¿Está seguro de eliminar todo y empezar nuevamente?");
    }
    if( confirmacion )
    {   limpiaPagina();
    }
}
function limpiaPagina()
{   // Total y numero de la factura
    $('#numeroFactura').val( '00000' );    
    $('#totalNetoFactura').val( '00.00' );    
    // Informacion del cliente
    $('#codigoCliente').val( '' );    
    $('#nombresCliente').val( '' );   
	$('#tipoIdentificacionTitular').val( '' );
    $('#numeroIdentificacionCliente').val( '' );
    $('#txt_curso').val( '' );
    $('#txt_grupo_economico').val( '' );
    $('#txt_nivel_economico').val( '' );
    $('#txt_curso').removeAttr("data-codigo");
    $('#txt_grupo_economico').removeAttr("data-codigo");
    $('#txt_nivel_economico').removeAttr("data-codigo");

    // Informacion del titular
    $('#numeroIdentificacionTitular').val( '' );    
    $('#nombreTitular').val( '' );    
    $('#emailTitular').val( '' );    
    $('#telefonoTitular').val( '' );    
    $('#direccionTitular').val( '' );
    $('#btnBuscarCliente').attr("enabled");
    $('#btnBuscarCliente').removeAttr("disabled");
    // Detalle de la factura
    $('#detalleFactura_table tbody tr').each(function(){
        $(this).remove();
    });
    document.getElementById('client_options').innerHTML="";
    document.getElementById('div_datos_academicos_estudiante').style.display="inline";
}
function facturaToJSON()
{   // ======================================================
    // => FORMATO
    // ======================================================
    var factura = {
        cabecera : {
            // Informacion del cliente
            md : '',
			codigoCliente : '',
            // Informacion del titular
            tipoIdentificacionTitular: '',
            numeroIdentificacionTitular: '',
            nombresTitular: '',
            emailTitular: '',
            telefonoTitular: '',
            direccionTitular: '',
            // Informacion de los totales
            totalBruto: '',
            totalDescuento: '',
            totalIVA: '',
            totalICE: 0,
            totalNeto: '',
			// Informacion deuda
			fechaInicio_cobro: '',
			fechaVencimiento:'',
			generaFactura:''
        },
        detalle: []
    };

    // ======================================================
    // => POBLACION CON DATOS
    // ======================================================
    var totalBruto = 0;    
    var totalDescuento = 0;    
    var totalIVA = 0;    
    var totalNeto = 0;

    $('#detalleFactura_table tbody tr').each(function(){
        totalBruto += parseFloat($(this).find('td').eq(2).text()) * parseFloat($(this).find('td').eq(3).text());    
        totalDescuento += parseFloat($(this).find('td').eq(4).text());    
        totalIVA += parseFloat($(this).find('td').eq(5).text());    
        totalNeto += parseFloat($(this).find('td').eq(6).text());    

        factura.detalle.push({
            codigoProducto : $(this).find('td').eq(1).attr('data-codigo'),
            precio : $(this).find('td').eq(2).text(),
            cantidad : $(this).find('td').eq(3).text(),
            totalBruto : (parseFloat($(this).find('td').eq(2).text()) * parseFloat($(this).find('td').eq(3).text())).toFixed(2),
            totalDescuento : $(this).find('td').eq(4).text(),
            totalIVA : $(this).find('td').eq(5).text(),
            totalICE : "0",
            totalNeto : $(this).find('td').eq(6).text()
        });

    });

	factura.cabecera.md = metodo_descuento; //variable global
    factura.cabecera.codigoCliente = $('#codigoCliente').val();
    factura.cabecera.tipoIdentificacionTitular = $('#tipoIdentificacionTitular').val();
    factura.cabecera.numeroIdentificacionTitular = $('#numeroIdentificacionTitular').val();
    factura.cabecera.nombresTitular = $('#nombreTitular').val();
    factura.cabecera.emailTitular = $('#emailTitular').val();
    factura.cabecera.telefonoTitular = $('#telefonoTitular').val();
    factura.cabecera.direccionTitular = $('#direccionTitular').val();

    factura.cabecera.totalBruto = totalBruto.toFixed(2);
    factura.cabecera.totalDescuento = totalDescuento.toFixed(2);
    factura.cabecera.totalIVA = totalIVA.toFixed(2);
    factura.cabecera.totalICE = "0";
    factura.cabecera.totalNeto = totalNeto.toFixed(2);
	
	factura.cabecera.fechaInicio_cobro = $('#fechaInicio_add').val();
	factura.cabecera.fechaVencimiento = $('#fechaFin_add').val();
	if ( document.getElementById('check_generar_FAC').checked )
		factura.cabecera.generaFactura = '1';
	else
		factura.cabecera.generaFactura = '0';
	
    return factura;
}
function js_facturas_consultaMetodoDescuento (  )
{   var data = new FormData();
	data.append('event', 'get_metodo_descuento');
	var xhr = new XMLHttpRequest();
	url_method = document.getElementById( 'ruta_html_finan' ).value + '/facturas/controller.php';
	xhr.open( 'POST', url_method , true );
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   metodo_descuento = xhr.responseText;
		}
	}
	xhr.send(data);
}
function generaFactura(div, url)
{   var error = 0;
	if ( hay_descuento > 0 )
	{   var current_metodo_descuento = "";
		var data = new FormData();
		data.append('event', 'get_metodo_descuento');
		var xhr = new XMLHttpRequest();
		url_method = document.getElementById( 'ruta_html_finan' ).value + '/facturas/controller.php';
		xhr.open( 'POST', url_method , true );
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   current_metodo_descuento = xhr.responseText;
				//console.log(current_metodo_descuento);
				//console.log(metodo_descuento);
				//metodo_descuento = current_metodo_descuento;
				if ( metodo_descuento != current_metodo_descuento )
				{   mostrar_mensaje_error_cambio_metodo( div );
					error = 1;
				}/*
				if ( JSON_descuento.length > 1 )
				{   if ( metodo_descuento <> current_metodo_descuento )
					{   mostrar_mensaje_error_cambio_metodo( div );
						error = 1;
					}
				}
				else
				{   if ( metodo_descuento === "desc_sobre" )
					{   mostrar_mensaje_error_cambio_metodo( div );
						error = 1;
					}
				}*/
				if ( error === 0 )
					generaFactura_followed(div, url);
			}
		}
		xhr.send(data);
	}
	else
	{   generaFactura_followed(div, url);
	}
}
function generaFactura_followed(div, url)
{   if( $('#detalleFactura_table tbody tr').length > 0 )
	{   var datosFactura = facturaToJSON();
		var tipo_persona = document.getElementById('hd_tipo_persona').value;
		var codigoCliente = document.getElementById('codigoCliente').value;
		var numeroIdentificacionCliente = document.getElementById('numeroIdentificacionCliente').value;
		var nombresCliente = document.getElementById('nombresCliente').value;
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'set_factura');
		data.append('datosFactura', JSON.stringify(datosFactura));
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{   document.getElementById(div).innerHTML=xhr.responseText;
				document.getElementById('modalFooter_mostrarFactura').innerHTML='<button class="btn btn-default" data-dismiss="modal">Cerrar</button>'; /*+
					'<a href="#" onclick="js_facturas_cobrar_deuda(\'' + codigoCliente + 
						'\', \'' + tipo_persona + 
						'\', \'' + nombresCliente + 
						'\', \'' + numeroIdentificacionCliente + 
						'\')" class="btn btn-primary"><span class="fa fa-dollar"></span>&nbsp;Cobrar deuda</a>';*/
				limpiaPagina();
			}
		};
		xhr.send(data);
	}
	else
	{   var mensajeError='No existe detalle alguno para enviar al servidor';
		document.getElementById('modal_mostrarFactura_body').innerHTML="<div class='alert alert-warning'><strong>¡Advertencia! </strong>"+mensajeError+"</div>";
	}
}
function js_facturas_check_generar_FAC()
{
	if ( document.getElementById('check_generar_FAC').checked )
		document.getElementById('btn_generar_deuda').innerHTML = '<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Generar deuda y factura';
	else
		document.getElementById('btn_generar_deuda').innerHTML = '<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Generar deuda';
}
function js_facturas_cobrar_deuda( codCliente, tipo_cliente )
{   var f     = document.createElement('form');
    f.action  = '../../finan/cobros/';
    f.method  = 'POST';
    //f.target= '_blank';
    var i     = document.createElement( 'input' );
    i.type    = 'hidden';
    i.name    = 'event';
    i.id      = 'evento';
    i.value   = 'buscar_todos';
    f.appendChild(i);
    var j     = document.createElement( 'input' );
    j.type    = 'hidden';
    j.name    = 'hd_codCliente';
    j.id      = 'hd_codCliente';
    j.value   = codCliente;
    f.appendChild(j);
    var k     = document.createElement( 'input' );
    k.type    = 'hidden';
    k.name    = 'hd_tipo_cliente';
    k.id      = 'hd_tipo_cliente';
    k.value   = tipo_cliente;
    f.appendChild(k);
    document.body.appendChild(f);
    f.submit();
}