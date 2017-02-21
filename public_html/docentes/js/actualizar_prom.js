function actualizarProm (path_auditoria,nota_perm_codi,curs_para_mate_prof_codi,peri_dist_codi,es_hija,mensaje,firstTime)
{	var xmlhttp;
	/*Agrego la data*/
	$('#btn_actualizar').button('loading');
	var tabla_info = document.getElementById("tabla_info");
	if (firstTime==1)
		while(tabla_info.rows.length > 1)
			tabla_info.deleteRow(-1);
	var fila = tabla_info.insertRow(-1);
	var cellMensaje	= fila.insertCell(0);
	var cellProgreso = fila.insertCell(1);
	cellMensaje.innerHTML = mensaje;
	cellProgreso.innerHTML = '<div id="prog_info_'+peri_dist_codi+'"><img src="../../imagenes/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append("peri_dist_codi", peri_dist_codi);
	var peri_dist_padr_previous = peri_dist_codi;
	data.append("curs_para_mate_prof_codi", curs_para_mate_prof_codi);
	data.append("es_hija", es_hija);
	data.append("path",path_auditoria);
    data.append("opc", "actualizar_prom");
	if (window.XMLHttpRequest)
  	{	xmlhttp = new XMLHttpRequest ();
  	}
  	else
  	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  	}
  	xmlhttp.onreadystatechange = function ()
  	{	
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		{	obj = JSON.parse(xmlhttp.responseText);
			if (obj.error == "no" && obj.peri_dist_codi!=-1 && obj.peri_dist_codi!=null)
			{	document.getElementById('prog_info_'+peri_dist_codi).innerHTML="Finalizado";
				actualizarProm(path_auditoria,nota_perm_codi,curs_para_mate_prof_codi,obj.peri_dist_codi,es_hija,obj.mensaje,0);
			}
			else
			{	if (obj.error == "no")
				{	if (obj.mensaje==null)
						actualizarProm(path_auditoria,nota_perm_codi,curs_para_mate_prof_codi, peri_dist_padr_previous, es_hija, "Reintentando", 0 );
					else
					{	var fila = tabla_info.insertRow(-1);
						var cellMensaje	= fila.insertCell(0);
						var cellProgreso = fila.insertCell(1);
						document.getElementById('prog_info_'+peri_dist_codi).innerHTML="Finalizado";
						cellMensaje.innerHTML = obj.mensaje;
						cellProgreso.innerHTML = "Actualización de notas completa";
						$.growl.notice({ title: "Educalinks informa: ",message: "¡Notas guardadas exitosamente!" });
						$('#btn_actualizar').button('reset');
						/*Desactivar permiso*/
						nota_perm_in (nota_perm_codi);
						window.setTimeout(function(){
							window.location.href='notas.php';
							}, 5000);
					}
				}
				else
				{	var fila = tabla_info.insertRow(-1);
					var cellMensaje	= fila.insertCell(0);
					var cellProgreso = fila.insertCell(1);
					cellMensaje.innerHTML = obj.mensaje;
					$.growl.error({ title: "Educalinks informa: ",message: "¡No se completó la actualización de notas!" });
					cellProgreso.innerHTML = "No se ha completado la actualización de notas, intente nuevamente y luego comunique a sistemas.";
					$('#btn_actualizar').button('reset');
				}
			}
  		}
  	}
  	xmlhttp.open("POST", "script_actualizar_prom.php", false);
  	xmlhttp.send(data);
}
function nota_perm_in (nota_perm_codi)
{	var xmlhttp;
    var data = new FormData();
    data.append("nota_perm_codi", nota_perm_codi);
	data.append("opc", "nota_perm_in");
	if (window.XMLHttpRequest)
  	{	xmlhttp = new XMLHttpRequest ();
  	}
  	else
  	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  	}
  	xmlhttp.onreadystatechange = function ()
  	{	
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		{	obj = JSON.parse(xmlhttp.responseText);
			if (obj.error == "no")
			{	$.growl.notice({ title: "Educalinks informa: ",message: obj.mensaje });
			}
			else
			{	$.growl.error({ title: "Educalinks informa: ",message: obj.mensaje });
			}
  		}
  	}
  	xmlhttp.open("POST", "script_actualizar_prom.php", false);
  	xmlhttp.send(data);
}