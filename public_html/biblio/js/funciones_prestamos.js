	$(document).ready(function(){


		$('#recu_tipo_codi').on('change',function(){
			document.getElementById('recu_codi').value='';
			document.getElementById('recu_titu').value='';
			document.getElementById('recu_isbn').value='';
			document.getElementById('recu_edit_deta').value='';
			document.getElementById('recu_cole_deta').value='';
			load_ajax_item_prest('prestamos_items','prestamo_items_view.php',0);
		});

		var table = $('#tbl_items_sele').DataTable({
    		select: false,
    		lengthChange: false,
    		searching: false,
    		ordering: false,
    		"info" : false,
    		"pageLength" : 4,
    		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
    	});
		table.columns.adjust().draw();
	});
	
	

	$('#tbl_items_sele tbody').on('click','.selec_del',function(){
		var table = $('#tbl_items_prestamo').DataTable();
		var table_selec = $('#tbl_items_sele').DataTable();

		var idx = $(this).closest('tr').index();
		var item_codi = table_selec.cell( idx, 0).data();
		$('#'+item_codi).attr("disabled", false);


		table_selec.row( $(this).parents('tr')).remove().draw();
	});

	function load_ajax_usua_prest(div,url){
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
		data.append('usua_tipo_codi', $('#pres_usua_tipo_codi').val() );

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(div).innerHTML=xmlhttp.responseText;
				var table = $('#table_cons_Usuarios').DataTable({
            		select: false,
            		lengthChange: false,
            		searching: true,
            		"columnDefs": [{className: "dt-body-left" , "targets": [0],"visible":false},
								{className: "dt-body-left" , "targets": [1]},
								{className: "dt-body-left" , "targets": [2]}
								],
            		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
            	});
				table.columns.adjust().draw();
	  
				$('#table_cons_Usuarios tbody').on( 'click', 'tr', function () {
						var table2 = $('#table_cons_Usuarios').DataTable();

						var idx = table2.row(this).index();
						document.getElementById('pres_usua_codi').value=table2.cell( idx, 0).data();
						document.getElementById('pres_usua_deta').value=table2.cell( idx, 1).data()+' '+table2.cell( idx, 2).data(); 
						
						$('#modal_usuarios').modal('hide');
				});
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.send(data);	
	}



	function load_ajax_recu_prest(div,url){
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
		data.append('recu_tipo_codi', $('#recu_tipo_codi').val() );

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(div).innerHTML=xmlhttp.responseText;
				var table = $('#table_cons_libros_items').DataTable({
						select: false,
						lengthChange: false,
						searching: true,
						"columnDefs": [{className: "dt-body-left" , "targets": [0],"visible":false},
								{className: "dt-body-left" , "targets": [1]},
								{className: "dt-body-left" , "targets": [2]}
								],
						language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
					});
	            table.columns.adjust().draw();
	       	
			
				$('#table_cons_libros_items tbody').on( 'click', 'tr', function () {
						var table3 = $('#table_cons_libros_items').DataTable();
						var idx = table3.row(this).index();
						
						document.getElementById('recu_codi').value=table3.cell( idx, 0).data();
						document.getElementById('recu_isbn').value=table3.cell( idx, 1).data(); 
						document.getElementById('recu_titu').value=table3.cell( idx, 2).data();
						document.getElementById('recu_edit_deta').value=table3.cell( idx, 3).data(); 
						document.getElementById('recu_cole_deta').value=table3.cell( idx, 4).data();  
						$('#modal_items').modal('hide');
						load_ajax_item_prest('prestamos_items','prestamo_items_view.php',table3.cell( idx, 0).data());
						
				});
				
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.send(data);	
	}

	function load_ajax_item_prest(div,url,recu_codi){
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
		data.append('recu_codi', recu_codi );

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(div).innerHTML=xmlhttp.responseText;
				initialize_tbl_prestamos_items();
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.send(data);	
	}

	function initialize_tbl_prestamos_items(){
		var table = $('#tbl_items_prestamo').DataTable({
				select: false,
				lengthChange: false,
				searching: true,
				"pageLength" : 4,
				// scrollY: 220,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
			});

        table.columns.adjust().draw();

		$('#tbl_items_prestamo tbody').on('click','.selec_add',function(){
			var table = $('#tbl_items_prestamo').DataTable();
			var table_selec = $('#tbl_items_sele').DataTable();
			var idx = $(this).closest('tr').index();
			var item_codi_sel =table.cell( idx, 0).data();
			var flag = 0;
			$('#tbl_items_sele').find('tr').each(function(i,el){
	            var item_codi = $(this).find('td').eq(0).text();
	            if(item_codi==item_codi_sel){
	            	flag++;
	            }
	        });
			if(flag==0){
				table_selec.row.add([
					item_codi_sel,
					$('#recu_isbn').val(),
					$('#recu_titu').val(),
					$('#recu_tipo_codi option:selected').text(),
					'<button type="button" class="btn btn-danger selec_del" ><i class="fa fa-trash"></i></button>'
				]).draw(false);
	        	$(this).attr("disabled", true);
			}
			
		});
	}

	function validar_pres(){
		var items_count = $('#tbl_items_sele tbody tr').length;
		if($('#pres_usua_codi').val()==''){
			$('#pres_usua_codi').closest('.form-group').addClass('has-error');
			$('#pres_usua_deta').closest('.form-group').addClass('has-error');
			return false;
		}else
			$('#pres_usua_codi').closest('.form-group').removeClass('has-error');
			$('#pres_usua_deta').closest('.form-group').removeClass('has-error');
		if($('#pres_fech_devo').val()==''){
			$('#pres_fech_devo').closest('.form-group').addClass('has-error');
			return false;
		}else
			$('#pres_fech_devo').closest('.form-group').removeClass('has-error');
		if ( items_count ==0 ) {
			$.growl.error({ title: "Atención!",message: 'Debe seleccionar items para guardar el prestamo.' });	
		    return false;
		}
		$('#pres_usua_codi').closest('.form-group').removeClass('has-error');
		$('#pres_usua_deta').closest('.form-group').removeClass('has-error');
		$('#pres_fech_devo').closest('.form-group').removeClass('has-error');
		return true;
	}

	function load_ajax_add_prestamo(pres_codi){
		if(validar_pres()){
			$('#btn_pres_add').button('loading');
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			var url = 'script_prestamos.php';
			var jsonItems = [];

			$('#tbl_items_sele tbody').find('tr').each(function(i,el){
	            var $tds = $(this).find('td');
	            
	            jsonItems.push({
	            	item_codi : $tds.eq(0).text()
	            });
	        });

			var data = new FormData();
			data.append('pres_codi', document.getElementById('pres_codi').value );
			data.append('pres_usua_tipo_codi', $('#pres_usua_tipo_codi').val() );
			data.append('pres_usua_codi', document.getElementById('pres_usua_codi').value );
			data.append('pres_obse', document.getElementById('pres_obse').value );
			data.append('pres_fech_devo', document.getElementById('pres_fech_devo').value );
			data.append('pres_item', JSON.stringify(jsonItems) );
			data.append('opc','add');

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var json = JSON.parse(xmlhttp.responseText);
					if (json.state=="success"){
						$.growl.notice({ title: "Listo!",message: json.result });
						$('#btn_pres_add').button('reset');	
						window.history.back();		
					}else{
						$.growl.error({ title: "Atención!",message: json.result });
						$('#btn_pres_add').button('reset');
					}
					
				}
			}
			xmlhttp.open("POST",url,true);
			//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);
		}
	}

	function load_ajax_prestamos_main(div,url,data){
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
				$('#tbl_prestamos').addClass( 'nowrap' ).DataTable({
				
					"bPaginate": true, //paginacion anterior siguiente
					"bStateSave": false, //nose
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"sScrollXInner": "110%",
					"scrollX": true,
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

	function load_ajax_del_pres(div,url,data){
		$('#btn_pres_del').button('loading');
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
				$('#btn_pres_del').button('reset');
				$('#modal_prestamo_del').modal('hide');
				load_ajax_prestamos_main('prestamo_main','prestamo_view.php','');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}

	function load_ajax_devolucion_main(div,url,data){
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
				$('#tbl_items_devo').addClass( 'nowrap' ).DataTable({
				
					"bPaginate": true, //paginacion anterior siguiente
					"bStateSave": false, //nose
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
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

	function load_ajax_pres_devo(url,data){
		$('#btn_devo_add').button('loading');
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
				$('#btn_devo_add').button('reset');
				$('#modal_devolucion_add').modal('hide');
				load_ajax_prestamos_main('prestamo_main','prestamo_view.php','');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}

	function load_ajax_pres_devo_item(url,data,pres_codi){
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
				load_ajax_devolucion_main('modal_main_devolucion','devolucion_view.php','pres_codi='+pres_codi);
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}