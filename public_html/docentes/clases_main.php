<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
        <!-- InstanceEndEditable -->
        <script src="js/upload.js">
        </script>
        
        <script type="text/javascript">
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
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=3; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
      <?php include ('menu.php');?>
			
			<div  id="mainPanel"  class="section_main">
            
				<?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
<div class="title">
	<h3>
    	<span class="icon-books icon"></span>Clases
	</h3>
</div> 
               
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
<div class="alumnos_curso zones">
<div class="tabbable"> 
                         <!-- Only required for left/right tabs -->
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
                            onclick="post_add('posts_div','script_post.php');">
                            Enviar
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
				<h3>Los comentarios están desactivados.</h3>
			<?
			}
			?>
 		</div>
	</div>
                                    <!--Seccion de Materiales-->
		<div class="tab-pane" id="tab2">
		<form 
        	action="javascript:void(0);" 
            enctype="multipart/form-data" 
            method="post">
			<div class="alumnos_add_script">
                <table class="table_simple">
                    <tr>
                        <td>
                        	<label for="mater_titu"> 
                            	T&iacute;tulo del archivo: 
							</label> 
						</td>
                        <td>
                        	<input 
                            	type="text" 
                                name="mater_titu" 
                                id="mater_titu"/>
                                
                        	<input 
                            	type="hidden" 
                                name="curs_para_mate_prof_codi" 
                                id="curs_para_mate_prof_codi"
                                value="<?=$_GET['curs_para_mate_prof_codi']?>"/>
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;
                        	
						</td>
                    </tr>
                    <tr>
                        <td>
                        	<label for="mater_deta"> 
                            	Detalle material: 
							</label>
						</td>
                        <td>
                        	<textarea id="mater_deta" name="mater_deta" rows="3"></textarea>
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;
                        	
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                        	<input 
                            	type="file" 
                                name="archivo" 
                                id="archivo"/>
						</td>
                    </tr>
                    <tr>
                    	<td colspan="2">&nbsp;
                        	
						</td>
                    </tr>
                    <tr>
                        <td>
                        	<input 
                            	type="submit" 
                                id="boton_subir" 
                                value="Subir" 
                                class="btn btn-primary"/>
						</td>
                        <td>
                        	<progress 
                            	id="barra_de_progreso" 
                                value="0" 
                                min="0" 
                                max="100">
							</progress>
						</td>
                    </tr>
                </table>                 
			</div>
		</form>
		<div id="div_materiales">
		<?php 
        $params_mater = array($_GET['curs_para_mate_prof_codi']);
        $sql_mater="{call curs_para_mate_mater_view(?)}";
        $stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);
		?>
            <table class="table_striped">
                <thead>
                    <tr>
                        <th>Detalle</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
				while($row_mater_view = sqlsrv_fetch_array($stmp_mater))
				{
				?>
                    <tr>
                        <td>
                        	<h4>
								<?= $row_mater_view['mater_titu'];?>
							</h4>
                            <br>
							<?= $row_mater_view['mater_deta'];?>
						</td>
                        <td>
							<?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?>
						</td>
                        <td>
                            <div class="menu_options">
                                <ul>
                                    <li>
                                        <a 
                                            class="option" 
                                            href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>">
                                            <span class="icon-download icon"></span>Descargar
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="option" 
                                            href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi'];?>','<?=$_GET['curs_para_mate_codi']?>')">
                                            <span class="icon-remove icon"></span>Eliminar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
	</div>
                                    <!--Seccion de Alumnos del curso-->
    <div class="tab-pane" id="tab3">
        <table class="table_striped">
			<?php 
            $params_compa = array($_GET['curs_para_mate_prof_codi']);
            $sql_compa="{call curs_para_prof_alums_view(?)}";
            $stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
            $colum=6;
            ?>
            <thead>
                <tr>
                    <td colspan="2">
                    	<div class="title"><h4>Compañeros de Curso:</h4></div>
                    </td>
                </tr>
            </thead>
        <tbody>
            <tr style="display:none;"><td></td></tr>
            <tr>
            <td width="40%">
            <?php $cont=0; while($row_compas_view = sqlsrv_fetch_array($stmp_compa)){?>
                
                    <?php
                            $cont++;
                            $ruta=$_SESSION['ruta_foto_alumno'];
                            $full_name=$ruta.$row_compas_view['alum_codi'].".jpg";
                            $file_exi=$full_name;
                            if (file_exists($file_exi)){
                                $pp=$file_exi;
                            } else {
                                $pp=$_SESSION['foto_default'];
                            }
                            ?>
                            <div id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
                                <img onClick="MostrarInfoAlumno(this.id);" id="<?=$row_compas_view['alum_curs_para_codi']?>" src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb'] ?>"  border="0" style="border-color:#F0F0F0;"/>
                            </div> 
                            <?php if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
                
            <?php } ?>
            </td>
            <td width="60%">
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
            </script>
            <div id="alum_info_div">
            </div>
            </td>
        	</tr>
        </tbody>
        </table>
    </div>
                                    <!--Seccion de Profesor-->
    <div class="tab-pane" id="tab4">
        <div>
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
            <p><img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:120px; height:120px;"/></p>
            <p>Profesor: <?= $row_curs_mate_view["prof_nomb"]; ?></p>
            <p>Email: <a href="mailto:<?= $row_curs_mate_view["prof_mail"]; ?>"><?= $row_curs_mate_view["prof_mail"]; ?></a></p>
        </div>
    </div>
</div>
</div>
</div>
						<!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>