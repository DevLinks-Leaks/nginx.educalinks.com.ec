	function validar_tipo(){
		if($('#tipo_deta').val()==''){
			$('#tipo_deta').closest('.form-group').addClass('has-error');
			return false;
		}
		$('#tipo_deta').closest('.form-group').removeClass('has-error');
		return true;
	}
	function validar_tipo_edit(){
		if($('#tipo_deta_edit').val()==''){
			$('#tipo_deta_edit').closest('.form-group').addClass('has-error');
			return false;
		}
		$('#tipo_deta_edit').closest('.form-group').removeClass('has-error');
		return true;
	}
	function load_ajax_add_tipo(div,url,data){
		if(validar_tipo()){
			$('#btn_tipo_add').button('loading');
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
					$('#btn_tipo_add').button('reset');
					$('#modal_tipo_add').modal('hide');
					load_ajax_tipos_main('tipo_main','tipo_view.php','');
				}
			}
			xmlhttp.open("POST",url,true);
			xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);	
		}
	}

	function load_ajax_tipos_main(div,url,data){
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
				$('#tbl_tipos').addClass( 'nowrap' ).DataTable({
				
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

	function load_ajax_edit_tipo(div,url,data){
		if(validar_tipo_edit()){
			$('#btn_tipo_edit').button('loading');
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
					$('#btn_tipo_edit').button('reset');
					$('#modal_tipo_edit').modal('hide');
					load_ajax_tipos_main('tipo_main','tipo_view.php','');
				}
			}
			xmlhttp.open("POST",url,true);
			xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);	
		}
	}
	function load_ajax_del_tipo(div,url,data){
		$('#btn_tipo_del').button('loading');
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
				$('#btn_tipo_del').button('reset');
				$('#modal_tipo_del').modal('hide');
				load_ajax_tipos_main('tipo_main','tipo_view.php','');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}