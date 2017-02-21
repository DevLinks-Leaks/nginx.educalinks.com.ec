
$(document).ready(function(){   

	$("#recu_cate_codi").select2();
	$("#recu_desc_codi").select2();
	$("#recu_auto_codi").select2();
	$("#recu_acto_codi").select2();
	$("#recu_dire_codi").select2();
	$("#recu_vide_dura").timepicker({
		showMeridian: false,
		showInputs: false,
		defaultTime: false
	});

});

function validar_recu(){
	if($('#recu_titu').val()==''){
		$('#recu_titu').closest('.form-group').addClass('has-error');
		return false;
	}
	$('#recu_titu').closest('.form-group').removeClass('has-error');
	return true;
}
//window.history.back();
function load_ajax_recu_dynamic(div,url,data){
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
			$("#recu_auto_codi").select2();
			$("#recu_dire_codi").select2();
			$("#recu_acto_codi").select2();
			$("#recu_vide_dura").timepicker({
				showMeridian: false,
				showInputs: false,
				defaultTime: false
			});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function load_ajax_add_recurso(recu_codi){
	if(validar_recu()){
		$('#btn_recu_add').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var url = 'script_recursos.php';
		var jsonAutores = [];

		$('#recu_auto_codi :selected').each(function(i, selected){ 
	  		jsonAutores.push({
	  			auto_codi: selected.value,
	  			auto_tipo: 'A' //Autor
	  		});
		});
		$('#recu_dire_codi :selected').each(function(i, selected){ 
	  		jsonAutores.push({
	  			auto_codi: selected.value,
	  			auto_tipo: 'D' //Director
	  		});
		});
		$('#recu_acto_codi :selected').each(function(i, selected){ 
	  		jsonAutores.push({
	  			auto_codi: selected.value,
	  			auto_tipo: 'AC' //Actor Principal o Secundario
	  		});
		});

		var jsonDescriptores = [];

		$('#recu_desc_codi :selected').each(function(i, selected){ 
	  		jsonDescriptores.push({
	  			desc_codi: selected.value 
	  		});
		});

		var jsonCategoria = [];

		$('#recu_cate_codi :selected').each(function(i, selected){ 
	  		jsonCategoria.push({
	  			cate_codi: selected.value 
	  		});
		});
		var archivo = document.getElementById('recu_cara');
		var recu_cara = archivo.files[0];

		var data = new FormData();
		data.append('recu_titu', document.getElementById('recu_titu').value );
		data.append('recu_tipo_codi', $('#recu_tipo_codi').val() );
		data.append('recu_edit_codi', document.getElementById('recu_edit_codi').value );
		data.append('recu_cole_codi', document.getElementById('recu_cole_codi').value );
		data.append('recu_fech_publ', document.getElementById('recu_fech_publ').value );
		data.append('recu_cate', JSON.stringify(jsonCategoria) );
		data.append('recu_desc', JSON.stringify(jsonDescriptores) );
		data.append('recu_auto', JSON.stringify(jsonAutores) );
		data.append('recu_isbn', (document.getElementById('recu_isbn')==null) ? '' : document.getElementById('recu_isbn').value );
		data.append('recu_issn', (document.getElementById('recu_issn')==null) ? '' : document.getElementById('recu_issn').value );
		data.append('recu_vide_dura', (document.getElementById('recu_vide_dura')==null) ? '' : document.getElementById('recu_vide_dura').value );
		data.append('recu_vide_resu', (document.getElementById('recu_vide_resu')==null) ? '' : document.getElementById('recu_vide_resu').value );
		data.append('recu_codi',recu_codi);
		data.append('recu_cara',recu_cara);
		data.append('opc','add');

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){			
					$.growl.notice({ title: "Listo!",message: json.result });
					$('#btn_recu_add').button('reset');
					window.history.back();		
				}else if(json.state=="warning"){
					$.growl.notice({ title: "Listo!",message: json.result, duration: 5600 });
					$('#btn_recu_add').button('reset');
				}else{
					$.growl.error({ title: "Atención!",message: json.result });
					$('#btn_recu_add').button('reset');
				}
				
			}
		}
		xmlhttp.open("POST",url,true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}

function load_ajax_del_recu(div,url,data){
	$('#btn_recu_del').button('loading');
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
			$('#btn_recu_del').button('reset');
			$('#modal_recurso_del').modal('hide');
			load_ajax_recursos_main('recurso_main','recurso_view.php','');
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

function load_ajax_recursos_main(div,url,data){
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
			$('#tbl_recursos').addClass( 'nowrap' ).DataTable({
			
				"bPaginate": true, //paginacion anterior siguiente
				"bStateSave": false, //nose
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"scrollX": true,
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
			});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}