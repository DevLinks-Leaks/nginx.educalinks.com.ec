function curs_del(curs_codi){
		if (confirm("Esta seguro que desea Eliminar" + curs_codi )) {					 
				load_ajax('curs_curs_main','cursos_cursos_main_lista.php','curs_codi=' + curs_codi + '&del_curs=Y'); 					
		}
}

function curs_add_upd(){
 	if (document.getElementById('n_que').value=='N'){
		load_ajax('curs_curs_main','cursos_cursos_main_lista.php','curs_deta=' 
		  		+ document.getElementById('n_curs_deta').value  
				+ '&nive_codi=' + document.getElementById('n_nive_codi').value + '&add_curs=Y');		
	}else{
		url='curs_codi=' + document.getElementById('n_curs_codi').value
		url+= '&curs_deta=' + document.getElementById('n_curs_deta').value 
		url+= '&nive_codi=' + document.getElementById('n_nive_codi').value 
		url+= '&upd_curs=Y';
		load_ajax('curs_curs_main','cursos_cursos_main_lista.php',url);
	}		 
}

function curs_nuev_dial(){
	
	document.getElementById('n_curs_codi').value='';	
	document.getElementById('n_curs_deta').value='';
	document.getElementById('n_que').value='N';
}

function curs_upda_dial(curs_codi,curs_deta,nive_codi){
	document.getElementById('n_que').value='U';
	document.getElementById('n_curs_codi').value=curs_codi;	
	document.getElementById('n_curs_deta').value=curs_deta;
	document.getElementById('n_nive_codi').value=nive_codi;	
}
 
function curs_para_cupo_upd_dial()
{
	document.getElementById('curs_para_cupo_edit').value = document.getElementById('curs_para_cupo').getAttribute('data-cupo_actual');
	document.getElementById('curs_para_cupo_edit').setAttribute('min',document.getElementById('curs_para_cupo').getAttribute('data-alum_num'));
}

function curs_para_cupo_edit(curs_para_codi, cupo)
{
		load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_codi=' + curs_para_codi + '&curs_para_cupo=' + cupo + '&edit_cupo=' + 'Y');	
}
 
function curs_para_mate_up_down(curs_para_mate_codi,curs_para_codi,accion){
	if (accion=='up')	
		load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_codi=' + curs_para_codi + '&curs_para_mate_codi=' + curs_para_mate_codi + '&mate_up=' + 'Y');	
	else
		load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_codi=' + curs_para_codi + '&curs_para_mate_codi=' + curs_para_mate_codi + '&mate_down=' + 'Y');	
}

function curs_para_mate_add(curs_para_codi,mate_codi){ 
	load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_codi=' +curs_para_codi + '&mate_codi=' + mate_codi + '&add_mate=' + 'Y') ;	
}

function curs_para_mate_del(curs_para_mate_codi,curs_para_codi){	
 	if (confirm("Esta seguro que desea Eliminar, se perdera la informacion registrada en este Curso")) {
		load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi +  '&del_mate=' + 'Y') ;	
	}	
}

function curs_para_mate_prof_del(curs_para_mate_prof_codi,curs_para_codi){	
 	if (confirm("¿Está seguro que desea quitar al profesor asignado?")) {
		load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_prof_codi=' + curs_para_mate_prof_codi + '&curs_para_codi=' + curs_para_codi +  '&del_prof=' + 'Y') ;	
	}	
}

function curs_para_alum_add(curs_para_codi,alum_codi){ 
	load_ajax('alum_view','cursos_paralelo_info_main_alum_view.php','curs_para_codi=' +curs_para_codi + '&alum_codi=' + alum_codi + '&add_alum=' + 'Y') ;	
}

function alum_curs_para_mate_del(curs_para_mate_codi,curs_para_codi){	
 	if (confirm("Esta seguro que desea Eliminar, se perdera la informacion registrada en este Alumno en este Curso")) {
		load_ajax('alum_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi +  '&del_mate=' + 'Y') ;	
	}	
}


function alum_curs_para_mate_upd(curs_para_mate_codi, curs_para_mate_prof_codi, aula_codi, prof_codi){
		load_ajax('edit_curs_main','cursos_paralelo_info_main_mate_deta_diag.php','prof_codi=' + prof_codi + '&aula_codi=' + aula_codi + '&curs_para_mate_prof_codi=' + curs_para_mate_prof_codi + '&curs_para_mate_codi=' + curs_para_mate_codi);
}


function alum_curs_para_mate_upd_save(curs_para_mate_codi,curs_para_mate_prof_codi,prof_codi,aula_codi,curs_para_codi)
{
			load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi  + '&prof_codi=' + prof_codi  + '&aula_codi=' + aula_codi + '&curs_para_mate_prof_codi=' + curs_para_mate_prof_codi +  '&edit_curs=' + 'Y' );	
}

function curs_para_save(peri_codi,peri_dist_cabe_codi,curs_codi,para_codi,curs_para_cupo){
				load_ajax('curs_para_main','cursos_paralelo_main_lista.php','peri_codi=' + peri_codi  
												+  '&curs_codi=' 		+ curs_codi 
												+  '&peri_dist_cabe_codi=' 		+ peri_dist_cabe_codi 
												+  '&para_codi=' 		+ para_codi 
												+  '&curs_para_cupo=' 	+ curs_para_cupo 
												+ '&add_curs_para=Y'); 
}

function alum_curs_para_mate_del_2(alum_curs_para_mate_codi, curs_para_codi, alum_curs_para_codi){	
 	if (confirm("¿Está seguro que desea Eliminar? Se eliminarán todas las notas ingresadas de esta asignatura."+alum_curs_para_mate_codi)) {
		load_ajax('alum_mate_main','cursos_paralelo_info_main_mate_conf_diag.php','alum_curs_para_mate_codi='+alum_curs_para_mate_codi+'&curs_para_codi='+curs_para_codi+'&alum_curs_para_codi='+alum_curs_para_codi+'&del_alum_mate=' + 'Y') ;	
	}	
}

function alum_curs_para_mate_add_2(alum_curs_para_codi, curs_para_mate_codi, alum_codi, curs_para_codi)
{	
	load_ajax('alum_mate_main','cursos_paralelo_info_main_mate_conf_diag.php','alum_curs_para_codi='+alum_curs_para_codi+'&curs_para_mate_codi='+curs_para_mate_codi+'&alum_codi='+alum_codi+'&curs_para_codi='+curs_para_codi+'&add_alum_mate='+'Y');
}

function copy_curs_mate(curs_origen, curs_destino)
{
			load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php',
			'curs_para_codi_orig=' + curs_origen + '&curs_para_codi=' + curs_destino +  '&copy_curs=' + 'Y');	
}

function CargarModelos(peri_dist_cab_codi, nota_refe_cab_codi)
{
	var xmlhttp;

	if (window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest ();
	}
	else
	{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	xmlhttp.onreadystatechange = function ()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById('div_modelos').innerHTML=xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET", "select_modelos.php?peri_dist_cab_codi="+peri_dist_cab_codi+'&nota_refe_cab_codi='+nota_refe_cab_codi, true);
	xmlhttp.send();
}

function curs_para_mate_mode_upd (curs_para_mate_codi, nota_refe_cab_codi)
{
	document.getElementById('curs_para_mate_codi').value=curs_para_mate_codi;
	document.getElementById('sl_modelos').value=nota_refe_cab_codi;
}

function alum_curs_para_mate_mode_upd(curs_para_mate_codi, nota_refe_cabe_codi, curs_para_codi)
{
	load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi +'&nota_refe_cabe_codi='+nota_refe_cabe_codi + '&curs_para_codi=' + curs_para_codi + '&add_model=' + 'Y' );	
}

function Asignar_Profesor(curs_para_mate_prof_codi)
{
	var xmlhttp;
	
	var total_alumnos;
	total_alumnos=document.getElementById('total_alumnos').value
	
	var data = new FormData();
	
	/*Profesor asignado*/
	data.append('curs_para_mate_prof_codi',curs_para_mate_prof_codi);
	
	i=1;
	seleccionados=0;
	while (i<=total_alumnos)
	{
		/*Pregunto si fue seleccionado y lo agrego a la cola*/
		if (document.getElementById('alumno_'+i).checked)
		{
			seleccionados++;
			//alert(document.getElementById('alumno_'+seleccionados).value);
			data.append('alumno_'+seleccionados, document.getElementById('alumno_'+i).value);
		}
		i++;
	}
	/*Total de alumnos seleccionados*/
	data.append('alumnos_seleccionados',seleccionados);
	
	if (window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest ();
	}
	else
	{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	xmlhttp.onreadystatechange = function ()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$.growl.notice({ title: "Informacion: ",message: "Alumnos asignados correctamente" });
			//alert (xmlhttp.responseText);
		}
	}

	xmlhttp.open("POST", "script_asignar_profesor.php", true);
	xmlhttp.send(data);
}

function curs_para_mate_prof_tutor(curs_para_mate_prof_codi, curs_para_codi){ 
	load_ajax('mate_view','cursos_paralelo_info_main_mate_view.php','curs_para_codi=' +curs_para_codi + '&curs_para_mate_prof_codi=' + curs_para_mate_prof_codi + '&add_tutor=' + 'Y') ;	
}

function CambiarParalelo ()
{
	if (ValidarSeleccionadoTodo ())
	{
		if (confirm("Los cambios realizados no se podrán deshacer, ¿desea continuar?"))
		{
			total_materias = document.getElementById('txt_datos').getAttribute('data-num_materias');
			var cambioParalelo = {};
			cambioParalelo["cambio"] = {};
			cambioParalelo["cambio"]["curs_para_dest"] = document.getElementById('txt_datos').getAttribute('data-curs_para_codi_dest');
			cambioParalelo["cambio"]["curs_para_orig"] = document.getElementById('txt_datos').getAttribute('data-curs_para_codi_orig');
			cambioParalelo["cambio"]["alum_codi"] = document.getElementById('txt_datos').getAttribute('data-alum_codi');
			cambioParalelo["cambio"]["materias"] = [];
			i=1;
			while (i<=total_materias)
			{
				var materias = {};
				materias["curs_para_mate_prof_dest"] = document.getElementById('sl_materias_dest_'+i).options[document.getElementById('sl_materias_dest_'+i).selectedIndex].getAttribute('data-curs_para_mate_prof_codi');
				materias["curs_para_mate_dest"] = document.getElementById('sl_materias_dest_'+i).options[document.getElementById('sl_materias_dest_'+i).selectedIndex].getAttribute('data-curs_para_mate_codi');
				materias["curs_para_mate_orig"]= document.getElementById('txt_materias_orig_'+i).getAttribute('data-curs_para_mate_codi');
				cambioParalelo["cambio"]["materias"].push(materias);
				i++;
			}
			
			var xmlhttp;
			var data = new FormData ();
			data.append("datos", JSON.stringify(cambioParalelo));
			if (window.XMLHttpRequest)
			{
				xmlhttp = new XMLHttpRequest ();
			}
			else
			{
				xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
		
			xmlhttp.onreadystatechange = function ()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					if (xmlhttp.responseText=="error")
					{
						$.growl.error({ title: "Error: ",message: "No se pudo realizar el cambio" });
					}
					if (xmlhttp.responseText=="exito")
					{
						$.growl.notice({ title: "Información: ",message: "El cambio se ha realizado con éxito" });
						load_ajax('alum_view','cursos_paralelo_info_main_alum_view.php','curs_para_codi='+document.getElementById('txt_datos').getAttribute('data-curs_para_codi_orig')) ;	
					}
				}
			}
			xmlhttp.open("POST", "script_cambio_paralelo.php", true);
			xmlhttp.send(data);
		}
	}
}

function ValidarSeleccionadoTodo ()
{
	total_materias = document.getElementById('txt_datos').getAttribute('data-num_materias');
	i=1;
	while (i<=total_materias)
	{
		if (document.getElementById('sl_materias_dest_'+i).
			options[document.getElementById('sl_materias_dest_'+i).selectedIndex].
			getAttribute('data-curs_para_mate_codi')=="-1")
		{
			alert ("¡Debe seleccionar una materia de destino a TODAS las de origen!");
			return false;
		}
		i++;
	}
	return true;
}

function curs_para_mate_agend_add (checkbox, curs_para_codi, curs_para_mate_codi)
{
	load_ajax('mate_view',
				'cursos_paralelo_info_main_mate_view.php',
				'curs_para_codi=' + curs_para_codi + '&tiene_agenda=' + checkbox.checked + '&curs_para_mate_codi=' + curs_para_mate_codi + '&add_agenda=' + 'Y');	
}
function curs_para_mate_promoc_add (checkbox, curs_para_codi, curs_para_mate_codi)
{
	load_ajax('mate_view',
				'cursos_paralelo_info_main_mate_view.php',
				'curs_para_codi=' + curs_para_codi + '&mostrar_materia=' + checkbox.checked + '&curs_para_mate_codi=' + curs_para_mate_codi + '&add_promoc=' + 'Y');	
}