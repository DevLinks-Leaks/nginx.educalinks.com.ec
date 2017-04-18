
	function validar_item(){
		if($('#item_prec').val()==''){
			$('#item_prec').closest('.form-group').addClass('has-error');
			return false;
		}else
			$('#item_prec').closest('.form-group').removeClass('has-error');
		return true;
	}

	function prom_upd(prom_codi,curs_codi){
		if(validar_item()){
			$('#btn_prom_upd').button('loading');
			//document.getElementById(div).innerHTML='';
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			var data = new FormData();
			data.append('prom_codi', prom_codi );
			data.append('curs_codi', curs_codi );
			data.append('prom_valu', document.getElementById('prom_valu').value );
			data.append('opc','upd');

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var json = JSON.parse(xmlhttp.responseText);
					if (json.state=="success"){				
						$.growl.notice({ title: "Listo!",message: json.result });				
					}else{
						$.growl.error({ title: "Atención!",message: json.result });	
					}
					$('#btn_prom_upd').button('reset');
					$('#edit_promo').modal('hide');
					load_promoc_main('prom_main','admin_periodos_promociones_view.php','');

				}
			}
			xmlhttp.open("POST",'script_prom.php',true);
			//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);	
		}
		
	}

	function load_promoc_main(div,url){
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
				$('#curs_promoc_table').datatable({
					pageSize: 20,
					sort: [false, false,false,false],
					filters: [true,'select',true,false],
					filterText: 'Escriba para buscar... '
				}) ;
			}
		}
		xmlhttp.open("GET",url,true);	 
		xmlhttp.send();	
	}