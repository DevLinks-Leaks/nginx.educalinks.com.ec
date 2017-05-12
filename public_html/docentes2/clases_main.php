<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=3;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Clases</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-book"></i></a></li>
						<li class="active">Clases</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/upload.js"></script>
								    <ul class="nav nav-tabs">
										<li class="active"><a href="#tab1" data-toggle="tab">Posts</a></li>
										<li><a href="#tab2" data-toggle="tab">Materiales</a></li>
										<li><a href="#tab3" data-toggle="tab">Alumnos</a></li>
										<li><a href="#tab4" data-toggle="tab">Profesor</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab1">
											<div>
											<?
											if (para_sist(401))
											{
											?>
												<form 
													action="" 
													enctype="multipart/form-data" 
													method="post" 
													id="frm_post" 
													name="frm_post">
													<div 
														style="float:none; padding-left:5%; padding-top:10px;">
														<textarea 
															id="text_post" 
															name="text_post" 
															rows="5" 
															placeholder="Publique aquí">
														</textarea>
														<script>
															CKEDITOR.replace('text_post', {
															   removePlugins:'elementspath,resize,toolbar',
															   height:'100px',
															});
														</script>
														<input 
															type="hidden" 
															id="text_post_hd" 
															name="text_post_hd" 
															value="" />
														<?php
														if (isset($_GET['curs_para_mate_prof_codi']))
														{
															$curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
														}
														else
														{
															$curs_para_mate_prof_codi=0;
														}
														if (isset($_GET['curs_para_mate_codi']))
														{
															$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
														}
														else
														{
															$curs_para_mate_codi=0;
														}
														if (isset($_GET['curs_para_codi']))
														{
															$curs_para_codi=$_GET['curs_para_codi'];
														}
														else
														{
															$curs_para_codi=0;
														}
														?>
														<input 
															type="hidden" 
															id="curs_para_mate_prof_codi_hd" 
															name="curs_para_mate_prof_codi_hd" 
															value="<?=$curs_para_mate_prof_codi?>" />
														<input 
															type="hidden" 
															id="curs_para_mate_codi_hd" 
															name="curs_para_mate_codi_hd" 
															value="<?=$curs_para_mate_codi?>" />
														<input 
															type="hidden" 
															id="curs_para_codi_hd" 
															name="curs_para_codi_hd" 
															value="<?=$curs_para_codi?>" />
													</div>
													<div 
														style="float:none; text-align:right; padding-top:10px;">
														<button 
															type="button" 
															class="btn btn-primary" 
															onclick="post_add('posts_div','script_post.php');"> Enviar
														</button>
													</div>
												</form>
											</div>
											<div 
												class="post_list" 
												id="posts_div">
												<?php
												if ($curs_para_mate_codi==0){
													$params_post = array($_SESSION['curs_para_codi']);
													$sql_post="{call wall_curs_para_view_all(?)}";
													$stmp_post = sqlsrv_query($conn, $sql_post, $params_post);
												}else{
													$params_post = array($curs_para_mate_prof_codi);
													$sql_post="{call wall_curs_para_mate_view_all(?)}";
													$stmp_post = sqlsrv_query($conn, $sql_post, $params_post);
												}
												while($row_wall_curs_view= sqlsrv_fetch_array($stmp_post))
												{?>
												<div class="post">
													<div class="image">
														<?php
															if ($row_wall_curs_view['wall_curs_para_tipo_usua']=='A'){
																$ruta=$_SESSION['ruta_foto_alumno'];
															}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='D'){
																$ruta=$_SESSION['ruta_foto_docente'];
															}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='R'){
																$ruta=$_SESSION['ruta_foto_repre'];
															}
															$full_name=$ruta.$row_wall_curs_view['usua_codi'].".jpg";
															$file_exi=$full_name;
															if (file_exists($file_exi)){
																$pp=$file_exi;
															} else {
																$pp=$_SESSION['foto_default'];
															}
														?>
														<img 
															src="<?php echo $pp;?>" 
															border="0" />
													</div>
													<div class="information">
														<div class="user">
															<strong>
																<?=$row_wall_curs_view['wall_curs_para_nombre']?>
															</strong>
															<span>
																<?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?>
															</span> 
													</div>
													<div class="text">
														<?=$row_wall_curs_view['wall_curs_para_text']?>
													</div>
													<div 
														id="fb-root" 
														style="clear:both;">
													
													</div>
												
												  <script>
													  (function(d, s, id) 
													  {
														var js, fjs = d.getElementsByTagName(s)[0];
														if (d.getElementById(id)) {return;}
														js = d.createElement(s); js.id = id;
														js.src = "http://connect.facebook.net/en_US/all.js#xfbml=1";
														fjs.parentNode.insertBefore(js, fjs);
													  }(document, 'script', 'facebook-jssdk'));
												  </script> 
												  <?php 
													  $url_param="?wall_curs_para_codi=".$row_wall_curs_view['wall_curs_para_codi'];
												  ?>    
													<iframe 
														src="http://www.facebook.com/plugins/like.php?href=<?php echo "http://uemag.ingeniumlinks.com".$_SERVER['SCRIPT_NAME'].$url_param; ?>&layout=button_count&show_faces=false&action=like&colorscheme=light"
														scrolling="no" 
														frameborder="0" 
														style="border:none; height:25px; width: 440px;">
													</iframe>
												</div>
											</div> 
											<!-- COLOQUE ESTA LINEA PORQUE MOLESTA, HAY DIV SIN CERRAR DESDE ALGUN LUGAR DEL PROG. o DEL IFRAME -->
											<?php 
												}
											 ?>                                         
											 <?
											}
											else
											{
											?>
												<h4>Los comentarios están desactivados.</h4>
											<?
											}
											?>
										</div>
									</div>
																	<!--Seccion de Materiales-->
									<div class="tab-pane" id="tab2">
											<div class="form-horizontal">
												<div class="form-group">
													<div class="col-sm-12">
														<h4>Subir material nuevo</h4>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12">
														<form 
															action="javascript:void(0);" 
															enctype="multipart/form-data" 
															method="post">
															<div class="alumnos_add_script">
																<table class="table table-bordered">
																	<tr>
																		<td width='20%'>
																			<label for="mater_titu"> 
																				T&iacute;tulo del archivo: 
																			</label> 
																		</td>
																		<td>
																			<input class='form-control input-sm'
																				type="text" 
																				name="mater_titu" 
																				id="mater_titu"/>
																				
																			<input  class='form-control input-sm'
																				type="hidden" 
																				name="curs_para_mate_prof_codi" 
																				id="curs_para_mate_prof_codi"
																				value="<?=$_GET['curs_para_mate_prof_codi']?>"/>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<label for="mater_deta"> 
																				Detalle material: 
																			</label>
																		</td>
																		<td>
																			<textarea class='form-control input-sm' id="mater_deta" name="mater_deta" rows="3"></textarea>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td>
																			<input  class='form-control input-sm'type="file" name="archivo" id="archivo"/>
																		</td>
																	</tr>
																</table>
																<br>
																<div align="center" width='30%' style='atext-align:center'>
																	<button type="submit" id="boton_subir" class="btn btn-success"><span class='fa fa-upload'></span> Subir material</button>
																	<br>
																	<br>
																	<progress 
																		id="barra_de_progreso" 
																		value="0" 
																		min="0" 
																		max="100">
																	</progress>
																</div>
															</div>
														</form>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12">
														<div id="div_materiales">
														<hr>
														<h4>Materiales subidos</h4>
														<?php 
														$params_mater = array($_GET['curs_para_mate_prof_codi']);
														$sql_mater="{call curs_para_mate_mater_view(?)}";
														$stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);
														?>
															<table class="table table-striped table-bordered">
																<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
																	<tr>
																		<th>Detalle</th>
																		<th style='text-align:center;'>Fecha</th>
																		<th style='text-align:center;'>Opciones</th>
																	</tr>
																</thead>
																<tbody>
																<?php 
																while($row_mater_view = sqlsrv_fetch_array($stmp_mater))
																{
																?>
																	<tr>
																		<td style='vertical-align:middle;'>
																			<h4>
																				<?= $row_mater_view['mater_titu'];?>
																			</h4>
																			<br>
																			<?= $row_mater_view['mater_deta'];?>
																		</td>
																		<td style='text-align:center;vertical-align:middle;'>
																			<?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?>
																		</td>
																		<td style='text-align:center;vertical-align:middle;'>
																			<a  class="btn btn-default" 
																				href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>">
																				<span class="fa fa-download"></span> Descargar
																			</a>
																			<a  class="btn btn-default" 
																				href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi'];?>','<?=$_GET['curs_para_mate_codi']?>')">
																				<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar
																			</a>
																		</td>
																	</tr>
																<?php }?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
									</div>
									<div class="tab-pane" id="tab3">
									<br>
										<div class='form-horizontal'>
											<div class='form-group'>
												<div class="col-md-5">
													<div class="panel panel-default">
														<div class="panel-heading">
															<span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
														</div>
														<div class="panel-body">
															<?php 
															$params_compa = array($_GET['curs_para_mate_prof_codi']);
															$sql_compa="{call curs_para_prof_alums_view(?)}";
															$stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
															$colum=6;
															$cont=0;
															while($row_compas_view = sqlsrv_fetch_array($stmp_compa))
															{	$cont++;
																$ruta=$_SESSION['ruta_foto_alumno'];
																$full_name=$ruta.$row_compas_view['alum_codi'].".jpg";
																$file_exi=$full_name;
																if (file_exists($file_exi)){
																	$pp=$file_exi;
																} else {
																	$pp=$_SESSION['foto_default'];
																}
																?>
																<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2" id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
																	<img onClick="MostrarInfoAlumno(this.id);" 
																		id="<?=$row_compas_view['alum_curs_para_codi']?>" src="<?php echo $pp;?>"
																		title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb'] ?>"
																		onmouseover='$(this).tooltip("show");'
																		border="0" class="img-thumbnail"
																		style="border-color:#F0F0F0; width: 50px !important;height: 60px !important;"/>
																</div> 
																<?php if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
														<?php } ?>
														</div>
													</div>
												</div>
												<div class="col-md-7">
													<div id="alum_info_div">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab4">
										<br>
										<?php
										$params_mate = array($_GET['curs_para_mate_prof_codi']);
										$sql_mate="{call curs_para_mate_prof_info(?)}";
										$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
										$row_curs_mate_view=sqlsrv_fetch_array($stmp_mate);
										$ruta=$_SESSION['ruta_foto_docente'];
										$full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
										$file_exi=$full_name;
										if (file_exists($file_exi)){
											$pp=$file_exi;
										} else {
											$pp=$_SESSION['foto_default'];
										}?>										
										<div class='form-horizontal'>
											<div class='form-group'>
												<div class='col-sm-6'>
													<div class="panel panel-default" id="prof_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" name="prof_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-briefcase"></span> Profesor</h3>
														</div>
														<div class="panel-body">
															<?php
															$ruta=$_SESSION['ruta_foto_docente'];
															$full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
															$file_exi=$full_name;
															if (file_exists($file_exi)){
																$pp=$file_exi;
															} else {
																$pp=$_SESSION['foto_default'];
															}?>
															<div class='form-group'>
																<div class='col-sm-2'>
																	<img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:55px; height:55px;"/>
																</div>
																<div class='col-sm-10'>
																	<div class='row'>																					
																		<div class='col-sm-12'>Profesor: <?= $row_curs_mate_view["prof_nomb"]; ?></div>
																		<div class='col-sm-12'>Email: <?= $row_curs_mate_view["prof_mail"]; ?></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		
        <script type="text/javascript">
			function MostrarInfoAlumno (alum_curs_para_codi)
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
						document.getElementById('alum_info_div').innerHTML=xmlhttp.responseText;
					}
				}
		
				xmlhttp.open("GET", "info_alum.php?alum_curs_para_codi="+alum_curs_para_codi, true);
				xmlhttp.send();
			}
			function activa_subida()
			{
				document.getElementById('boton_subir').disabled=false;
				document.getElementById('archivo').disabled=false;
			}
			
			function carga_archivos(div,url,curs_para_mate_prof_codi)
			{
				document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
				var data = new FormData();
				data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
				data.append('opc', 'mater_view');
					
				var xhr = new XMLHttpRequest();
				xhr.open('POST', url , true);
				xhr.onreadystatechange=function(){
					if (xhr.readyState==4 && xhr.status==200){
						document.getElementById(div).innerHTML=xhr.responseText;
					} 
				}
				xhr.send(data);
			}
			function elimina_materiales(div,url,mater_codi,curs_para_mate_prof_codi){
				document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
				var data = new FormData();
				data.append('mater_codi', mater_codi);
				data.append('opc', 'mater_del');
					
				var xhr = new XMLHttpRequest();
				xhr.open('POST', url , true);
				xhr.onreadystatechange=function(){
					if (xhr.readyState==4 && xhr.status==200){
						document.getElementById(div).innerHTML=xhr.responseText;
						carga_archivos('div_materiales','script_materiales.php',curs_para_mate_prof_codi);
					} 
				}
				xhr.send(data);
			}
			function bloquea_subida(){
				document.getElementById('boton_subir').disabled=true;
				document.getElementById('archivo').disabled=true;
			}
            function subirArchivos() {
                if(document.getElementById("archivo").value!=""){
                    bloquea_subida();
                    $("#archivo").upload('subir_archivo.php',
                    {
                        mater_titu: $("#mater_titu").val(),
                        mater_deta: $("#mater_deta").val(),
                        curs_para_mate_prof_codi: $("#curs_para_mate_prof_codi").val()
                    },
                    function(respuesta) {
                        //Subida finalizada.
                        $("#barra_de_progreso").val(0);
                        if (respuesta === 1) {
                            activa_subida();
                            $.growl.notice({ title: "Informacion: ",message: "El archivo ha sido subido correctamente" });
                            //mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                            $("#nombre_archivo, #archivo").val('');
                            carga_archivos('div_materiales','script_materiales.php','<?=$_GET['curs_para_mate_prof_codi'];?>');
                        } else {
                            activa_subida();
                            if (respuesta === 0){
                            $.growl.error({ title: "Información: ",message: "El archivo NO se ha podido subir" });
                            }
                            else{
                            $.growl.warning({ title: "Información: ",message: "Archivos con extensión .exe no son permitidos" });
                            }
                            //mostrarRespuesta('El archivo NO se ha podido subir.', false);
                        }
                        //mostrarArchivos();
                    }, function(progreso, valor) {
                        //Barra de progreso.
                        $("#barra_de_progreso").val(valor);
                    });
                }else{
                    alert("Seleccione el archivo que desea subir primero.");
                }
            }
            $(document).ready(function() {
                $("#boton_subir").on('click', function() {
                    subirArchivos();
                });
            });
        </script>
	</body>
</html>