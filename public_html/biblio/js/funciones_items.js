
	function validar_item(){
		if($('#item_prec').val()==''){
			$('#item_prec').closest('.form-group').addClass('has-error');
			return false;
		}else
			$('#item_prec').closest('.form-group').removeClass('has-error');
		if($('#item_fech_ing').val()==''){
			$('#item_fech_ing').closest('.form-group').addClass('has-error');
			return false;
		}else
			$('#item_fech_ing').closest('.form-group').removeClass('has-error');
		if($('#item_cant').val()==''){
			$('#item_cant').closest('.form-group').addClass('has-error');
			return false;
		}
		$('#item_fech_ing').closest('.form-group').removeClass('has-error');
		$('#item_cant').closest('.form-group').removeClass('has-error');
		return true;
	}

	function load_ajax_add_item(div,url,recu_codi){
		if(validar_item()){
			$('#btn_item_add').button('loading');
			//document.getElementById(div).innerHTML='';
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			var item_codi= document.getElementById('item_codi').value;
			var data = new FormData();
			data.append('item_codi', item_codi );
			data.append('item_edic', document.getElementById('item_edic').value );
			data.append('item_proc_codi', $('#item_proc_codi').val() );
			data.append('item_fech_ing', document.getElementById('item_fech_ing').value );
			data.append('item_prec', document.getElementById('item_prec').value );
			data.append('item_cant', document.getElementById('item_cant') == null ? '' : document.getElementById('item_cant').value );
			data.append('recu_codi',recu_codi);
			if(item_codi>0)
				data.append('opc','edit');
			else
				data.append('opc','add');
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var json = JSON.parse(xmlhttp.responseText);
					if (json.state=="success"){				
						$.growl.notice({ title: "Listo!",message: json.result });				
					}else{
						$.growl.error({ title: "Atención!",message: json.result });	
					}
					$('#btn_item_add').button('reset');
					$('#modal_item_add').modal('hide');
					load_ajax_items_main('item_main','item_view.php?recu_codi='+recu_codi);
				}
			}
			xmlhttp.open("POST",url,true);
			//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);	
		}
		
	}

	function load_ajax_items_main(div,url){
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
				$('#tbl_items').addClass( 'nowrap' ).DataTable({

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
		xmlhttp.open("GET",url,true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send();	
	}

	function load_ajax_del_item(div,url,recu_codi){
		$('#btn_item_del').button('loading');
		//document.getElementById(div).innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var selected = $('#tbl_items').DataTable().rows('.selected').data();
		var jsonSel = [];

		selected.each(function(i, selected){ 
			jsonSel.push({
				item_codi: i[1] 
			});
		});

		var data = new FormData();
		var item_codi_del = document.getElementById('item_codi_del').value;
		data.append('item_codi', item_codi_del );
		data.append('item_json', jsonSel );
		data.append('opc','del');
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Listo!",message: json.result });				
				}else{
					$.growl.error({ title: "Atención!",message: json.result });	
				}
				$('#btn_item_del').button('reset');
				$('#modal_item_del').modal('hide');
				load_ajax_items_main('item_main','item_view.php?recu_codi='+recu_codi);
			}
		}
		xmlhttp.open("POST",url,true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
	function load_ajax_nuevo_item(div,url,item_codi, recu_codi){
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
		data.append('item_codi', item_codi );
		data.append('recu_codi', recu_codi );
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(div).innerHTML=xmlhttp.responseText;
				$('#item_prec').maskMoney({thousands:'', decimal:'.', allowZero:true});
				$('#item_prec').val('0.00');
				$('#item_cant').keyup(function () { 
					this.value = this.value.replace(/[^0-9\.]/g,'');
				});
				$('#item_fech_ing').datetimepicker({
					format: 'DD/MM/YYYY',
					locale: 'es',
					showTodayButton: true,
					tooltips: {
						today: 'Ir al día actual',
						clear: 'Borrar selección',
						close: 'Cerrar el Seleccionador',
						selectMonth: 'Seleccione el Mes',
						prevMonth: 'Mes Anterior',
						nextMonth: 'Mes Siguiente',
						selectYear: 'Seleccione el Año',
						prevYear: 'Año Anterior',
						nextYear: 'Año Siguiente',
						selectDecade: 'Seleccione la Década',
						prevDecade: 'Década Anterior',
						nextDecade: 'Década Siguiente',
						prevCentury: 'Siglo Anterior',
						nextCentury: 'Siglo Siguiente'
					}
				});
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.send(data);	
	}