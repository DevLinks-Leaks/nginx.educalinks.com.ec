	function validar_upload(){
		if($('#file').val()==''){
			$('#file').closest('.form-group').addClass('has-error');
			return false;
		}
		$('#file').closest('.form-group').removeClass('has-error');
		return true;
	}
	function upload_data(){
		if(validar_upload()){
			// $('#btn_subir').button('loading');
			$('#btn_subir').attr('disabled',true);
			$('#btn_subir .fa').removeClass('fa-cloud-upload');
			$('#btn_subir .fa').addClass('fa-spinner fa-pulse');
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
			var archivo = document.getElementById('file');
			var my_file = archivo.files[0];
			data.append('file', my_file);
			data.append('opc', document.getElementById('opc').value);

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var json = JSON.parse(xmlhttp.responseText);
					if (json.state=="success"){				
						$.growl.notice({ title: "Listo!",message: json.result });				
					}else{
						$.growl.error({ title: "Atención!",message: json.result });	
					}
					// $('#btn_subir').button('reset');
					$('#btn_subir').prop('disabled',false);
					$('#btn_subir .fa').removeClass('fa-spinner fa-pulse');
					$('#btn_subir .fa').addClass('fa-cloud-upload');
					$('#modal_importacion').modal('hide');
				}
			}
			xmlhttp.open("POST",'script_upload.php',true);
			//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			xmlhttp.send(data);	
		}
	}