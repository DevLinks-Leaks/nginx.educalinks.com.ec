<div class="header">

    <a id="btn" href="#" > <span class=" icon-menu"> </span> Mostrar / Ocultar Menu</a> 
    
		
     <div  style=" position:absolute;left: 35%;display:block;width: 150px;top:8px;">                  
        <button   data-toggle="modal" data-target="#ModalPeriodoActivo" style=" width:200px; height:40px;">
         Peridodo Activo <?= $_SESSION['peri_deta']; ?>
        </button> 
     </div>

    <div class="userbar dropdown">
			
				<ul>
					<li class="userProfile">
							<a class="profile" href="#" data-toggle="dropdown"  >
							
									<div class="photo">
										<?php
											$file_exi=$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
			                                if (file_exists($file_exi)) {
			                            ?>
		                              		<img src="<?= $_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'];?>.jpg" alt="user" style=" height:60px; width:60px;">
		                             	<?php      
			                                } else {
			                            ?>
			                            	<img src="<?= $_SESSION['ruta_foto_usuario'];?>admin.jpg" alt="user" style=" height:60px; width:60px;">
			                             <?php 
			                              	}
										?> 
										
									</div>
									<div class="username">
										<h5>Bienvenido,</h5>
										<?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?> <b>(<?= $_SESSION['usua_codi']; ?></b>)
									</div>
								
							</a>
							<ul class="dropdown-menu" role="menu" >
								<li><a href="admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
								<li><a href="admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
								<li><a href="admin_info.php"> <span class="li_user">Ver Información</span></a></li>
								<li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>

							</ul>
						</li>

					<li class="userButtons">
                    	<ul>
                        <li>
					 
								<div id="mens_alert" >
								<?php include ('script_mens_view.php'); ?>
                           		</div>
                        </li>
                         <li>
					 
								<div id="mens_alert" >
								<a  id="link_cards" class="button" href="../finan/main.php" target="_blank">
                                    <img src="../theme/images/icons/ico_card.png" border="0" title="Sistema Financiero">
                                </a>
                           		</div>
                        </li>
                        </ul>
					</li>
				</ul>								
			</div>
</div>
<div class="modal fade bd-example-modal-lg" id="modal_leer_ext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="modal_main_ext" width="100%" class="modal-content">
            
        </div>
    </div>
  </div>

<script>
function envio_mensaje_nuevo(){		
	
	$('#envio_mensaje').button('loading');
	
	if (validar_envio()){
			
		tipo = document.getElementById('mens_tipo').value;
		cc = document.getElementById('mens_cc_usua').value;
		
		url='mensajes_nuevo_script_envio.php';
		
		mens_ok=0;
		mens_ko=0;
		mm=0;
		i=1;
		
		var jsonArr = [];

		while (i<=cc){
			
		 	if (document.getElementById('ch_'+ tipo + '_' + i) != null)	{
				if (document.getElementById('ch_'+ tipo + '_' + i).checked){
					jsonArr.push({
				        mens_para: document.getElementById('ch_'+ tipo + '_' + i).value,
				        mens_para_tipo: tipo,
				        mens_alum_codi: document.getElementById('ch_'+ tipo + '_' + i).getAttribute("data-alum-codi")
				    });
				}
		
			}
			i+=1;
						
		}
		var data = new FormData();
		data.append('mens_de', document.getElementById('mens_de').value );
		data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
		//data.append('mens_para', document.getElementById('ch_'+ tipo + '_' + i).value);
		//data.append('mens_para_tipo', tipo);
		data.append('mens_dest', JSON.stringify(jsonArr));
		data.append('mens_titu', document.getElementById('mens_titu').value);
		data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
		data.append('DO','ADD');
	
		var xhr_mensaje = new XMLHttpRequest();
		xhr_mensaje.open('POST', url , true);
		//xhr_mensaje.setRequestHeader("Content-Type", "application/json");
		xhr_mensaje.onload = function () {
			// do something to response
			//console.log(this.responseText);
		};
		xhr_mensaje.onreadystatechange=function(){
			if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200){
				obj = JSON.parse(xhr_mensaje.responseText);
				if (obj.tipo == "error")
				{	$.growl.error({ title: "Error: ",message: obj.mensaje });
					$('#envio_mensaje').button('reset');
				}
				else //if(obj.tipo == "warning")
				{	
					var repr="";
					obj.forEach(function(entry){
						if (entry.tipo=="warning") {
							repr=repr+"</br>"+entry.repr+", ";
						}
					});
					if(repr==""){
						$.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
						$('#envio_mensaje').button('reset');
						$('#nuev_mens').modal('hide');	
					}else{
						$.growl.warning({ title: "Advertencia: "
							,duration: 5600
							,size: 'large'
							,message: "Mail no enviado a los siguientes representantes: <b>"+repr+"</b></br>verificiar formato de e-mail." });
						$('#envio_mensaje').button('reset');
						$('#nuev_mens').modal('hide');
					}
				}
						 
			}
		}
		xhr_mensaje.send(data);
		
	}
	
}
function envio_mensaje_resp(mens_para,mens_para_tipo){		
	
	$('#responder_mensaje').button('loading');
	
	if (validar_envio_respuesta()){
		
		url='mensajes_nuevo_script_envio.php';
		
		
		var data = new FormData();
		data.append('mens_de', document.getElementById('mens_de').value );
		data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
		data.append('mens_para', mens_para);
		data.append('mens_para_tipo', mens_para_tipo);
		data.append('mens_titu', document.getElementById('mens_titu').value);
		data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
		data.append('DO','RESP');
	
		var xhr_mensaje = new XMLHttpRequest();
		xhr_mensaje.open('POST', url , true);
		//xhr_mensaje.setRequestHeader("Content-Type", "application/json");
		xhr_mensaje.onload = function () {
			// do something to response
			console.log(this.responseText);
		};
		xhr_mensaje.onreadystatechange=function(){
			if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200){
				obj = JSON.parse(xhr_mensaje.responseText);
				if (obj.tipo == "error")
				{	$.growl.error({ title: "Error: ",message: obj.mensaje });
					$('#responder_mensaje').button('reset');
				}
				else //if(obj.tipo == "warning")
				{	
					var repr="";
					obj.forEach(function(entry){
						if (entry.tipo=="warning") {
							repr=repr+"</br>"+entry.repr+", ";
						}
					});
					if(repr==""){
						$.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
						$('#responder_mensaje').button('reset');
						$('#mens_responder').modal('hide');	
					}else{
						$.growl.warning({ title: "Advertencia: "
							,duration: 5600
							,message: "Mail no enviado al representante: <b>"+repr+"</b></br>verificiar formato de e-mail." });
						$('#responder_mensaje').button('reset');
						$('#mens_responder').modal('hide');
					}
				}
						 
			}
		}
		xhr_mensaje.send(data);
		
	}
	
}
</script>