$(document).ready(function() {
	$("#txt_fecha_fin").datepicker();
	
	$("#boton_busqueda").click(function()
	{   $("#desplegable_busqueda").slideToggle(200);
	});
	
	$("#desplegable_busqueda").show();
});

function js_rep_antiquity_carga_reports_deudores( div, url, evento ) //PDF DE LA TABLA PRINCIPAL CON TOTALES VERTICALES Y HORIZONTALES
{   "use strict";
    var doit = 'yes';
    /*if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
    {   $('#modal_msg').modal('show');
        document.getElementById('modal_msg_body').innerHTML='¡Debe seleccionar un curso para poder realizar la consulta!';
        doit = 'no';
    }*/
    if( doit === 'yes' )
    {   var curso =0;
        var fecha_fin='';
        var nivelEcon='';
        if(document.getElementById('txt_fecha_fin').value.length>0)
        {    fecha_fin= document.getElementById('txt_fecha_fin').value;
        }
        else
        {    fecha_fin='';
        }
        if(document.getElementById('curso').value!=-1)
        {    curso= document.getElementById('curso').value;
        }
        else
        {    curso='';
        }
        if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
        {    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
        }
        else
        {    nivelEcon='';
        }
		var periodos= document.getElementById('periodos').value;
		if ( evento !== 'print_deudores_html' )
        {	var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_fin='+fecha_fin;
			window.open(url2);
		}
		else
		{   document.getElementById('resultado').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
			var data = new FormData();
			data.append('event', evento );
			data.append('curs_codi', curso);
			data.append('nivelEcon_codi', nivelEcon);
			data.append('peri_codi', periodos);
			data.append('fechavenc_fin', fecha_fin);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function()
			{	if (xhr.readyState==4 && xhr.status==200)
				{	document.getElementById( 'resultado' ).innerHTML=xhr.responseText;
					$('#antiquity_table').DataTable({
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
							{className: "dt-body-center" , "targets": [0]},
							{className: "dt-body-left"   , "targets": [1]},
							{className: "dt-body-right"  , "targets": [2]},
							{className: "dt-body-right"  , "targets": [3]},
							{className: "dt-body-right"  , "targets": [4]},
							{className: "dt-body-right"  , "targets": [5]},
							{className: "dt-body-right"  , "targets": [6]},
							{className: "dt-body-right"  , "targets": [7]},
							{className: "dt-body-right"  , "targets": [8]}
						]
					});
				}
			};
			xhr.send(data);
		}
    }
}
function js_rep_antiquity_check_fecha()
{   "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {   document.getElementById('txt_fecha_fin').disabled = true;
        document.getElementById('txt_fecha_fin').value = '';
    }else
    {   document.getElementById('txt_fecha_fin').disabled = false;
        document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
    }
}