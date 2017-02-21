<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->

  <?php include ('head.php');?>

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
                 <div class="title"><h3><span class="icon-books icon"></span>Clases</h3></div> 
            </div>
          
            <div class="alumnos_curso zones">
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                  <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab1" data-toggle="tab">Posts</a></li>
                      <li><a href="#tab2" data-toggle="tab">Materiales</a></li>
                      <li><a href="#tab3" data-toggle="tab">Alumnos</a></li>
                      <li><a href="#tab4" data-toggle="tab">Profesor</a></li>
                  </ul>
                  <div class="tab-content">
                      <div class="tab-pane active" id="tab1">
                          <div >
                              <?
                              if (para_sist(401))
                              {
                              ?>
                             <form action="" enctype="multipart/form-data" method="post" id="frm_post" name="frm_post">
                                  <div class="container">
                                      <label for="text_post">Escriba su comentario:</label>
                                      <textarea id="text_post" name="text_post" rows="5" placeholder="asdfasdf" ></textarea>
                                      <script>
                                          CKEDITOR.replace('text_post', {
                                             removePlugins:'elementspath,resize,toolbar',
                                             height:'100px',
                                          });
                                      </script>
                                      <input type="hidden" id="text_post_hd" name="text_post_hd" value="" />
                                      <?php
                                      if (isset($_GET['curs_para_mate_codi'])){$curs_para_mate_codi=$_GET['curs_para_mate_codi'];}else{$curs_para_mate_codi=0;}
                                      ?>
                                      <input type="hidden" id="curs_para_mate_codi_hd" name="curs_para_mate_codi_hd" value="<?=$curs_para_mate_codi?>" />
                                      </div>
                                      <div class="container">
                                        
                                      <button type="button" class="btn btn-primary" onclick="post_main_add('posts_div','script_post.php');"> <span class="icons icon-checkmark"></span>  Enviar Comentario</button>
                                  </div>
                             </form>
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


                           <div class="post_list" id="posts_div">
                              <?php
                              if ($curs_para_mate_codi==0){
                                  $params_post = array($_SESSION['curs_para_codi']);
                                  $sql_post="{call wall_curs_para_view_all(?)}";
                                  $stmp_post = sqlsrv_query($conn, $sql_post, $params_post);
                              }else{
                                  $params_post = array($curs_para_mate_codi);
                                  $sql_post="{call wall_curs_para_mate_view_all(?)}";
                                  $stmp_post = sqlsrv_query($conn, $sql_post, $params_post);
                              }
                              while($row_wall_curs_view= sqlsrv_fetch_array($stmp_post)){?>
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
                              	<img src="<?php echo $pp;?>" border="0" />
                                </div>
                                                                  
                                <div class="information">
                                    <div class="user">
                                      <strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
                                    </div>
                                    <div class="text">
                                      <?=$row_wall_curs_view['wall_curs_para_text']?>
                                    </div>
                                   


                                    <div id="fb-root" style="clear:both;"></div>
                                              
                                    <script>(function(d, s, id) {
                                                                              
                                      var js, fjs = d.getElementsByTagName(s)[0];
                                                                              
                                      if (d.getElementById(id)) {return;}
                                                                              
                                      js = d.createElement(s); js.id = id;
                                                                              
                                      js.src = "http://connect.facebook.net/en_US/all.js#xfbml=1";
                                                                              
                                      fjs.parentNode.insertBefore(js, fjs);
                                                                              
                                    }(document, 'script', 'facebook-jssdk'));</script> 
                                      
                                    <?php 
                                        $url_param="?wall_curs_para_codi=".$row_wall_curs_view['wall_curs_para_codi'];
                                    ?>    
                                    <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo "http://uemag.ingeniumlinks.com".$_SERVER['SCRIPT_NAME'].$url_param; ?>&layout=button_count&show_faces=false&action=like&colorscheme=light"scrolling="no" frameborder="0" style="border:none; height:25px; width: 440px;"></iframe>
                                    </div></div> <!-- COLOQUE ESTA LINEA PORQUE MOLESTA, HAY DIV SIN CERRAR DESDE ALGUN LUGAR DEL PROG. o DEL IFRAME -->
                                    <?php } ?>                             
                              </div>
                            </div>

                                    <!--Seccion de Materiales-->
                                    <div class="tab-pane" id="tab2">
                                    	<?php 
                                        $params_mater = array($_GET['curs_para_mate_prof_codi']);
                                        $sql_mater="{call curs_para_mate_mater_view(?)}";
                                        $stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);?>
                                        <div class="container">
                                          <table class="table_striped">
                                              <thead>
                                                  <tr>
                                                      <th>Detalle</th>
                                                      <th>Fecha</th>
                                                      <th>Opciones</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              <?php while($row_mater_view = sqlsrv_fetch_array($stmp_mater)){?>
                                                  <tr>
                                                      <td><h4><?= $row_mater_view['mater_titu'];?></h4><br><?= $row_mater_view['mater_deta'];?></td>
                                                      <td><?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?></td>
                                                      <td><div class="menu_options"><ul><li><a class="option" target="_blank" href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>" ><span class="icon-download icon"></span>Descargar</a></li></ul></div></td>
                                                  </tr>
                                              <?php }?>
                                              </tbody>
                                          </table>
                                        </div>
								                    </div>
                                    <!--Seccion de Alumnos del curso-->
                                    <div class="tab-pane" id="tab3">
                                    <div class="container">                         
                                    	<table class="table_striped">
										                  <?php 
                                        $params_compa = array($_GET['curs_para_mate_prof_codi']);
                                        $sql_compa="{call curs_para_prof_alums_view(?)}";
                                        $stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
                                        $colum=6;
                                        ?>
                                        <thead>
                                        <tr>
                                        <th colspan="2">
                                        <h4>Compañeros de Curso:</h4>
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody>
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
                                                    <img onClick="MostrarInfoAlumno(this.id);" id="<?=$row_compas_view['alum_curs_para_codi']?>" src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb']?>"  border="0" style="border-color:#F0F0F0;"/>
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

                              <div class="teacher">
                                <div class="image">
                                <img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:120px; height:120px;"/>
                                </div>
                                <div class="information">
                                  <div class="name">
                                  <?= $row_curs_mate_view["prof_nomb"]; ?>
                                  </div>
                                  <div class="email">
                                  <?= $row_curs_mate_view["prof_mail"]; ?>
                                  </div>
                                </div>                                      
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div><!-- InstanceEndEditable -->
				</div>
			</div>
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>


<!-- InstanceEnd --></html>