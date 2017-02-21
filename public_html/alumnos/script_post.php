<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'post_add':
		$texto=$_POST['text_post_hd'];
		if($_SESSION['USUA_TIPO']=='A'){
			$tipo_usua="A";
			$nombre=$_SESSION['alum_nomb'].' '.$_SESSION['alum_apel'];
			$codi=$_SESSION['alum_codi'];
			$usua=$_SESSION['alum_usua'];
		}else{
			$tipo_usua="R";
			$nombre=$_SESSION['repr_nomb'].' '.$_SESSION['repr_apel'];
			$codi=$_SESSION['repr_codi'];
			$usua=$_SESSION['repr_usua'];
		}
		$params_form = array($texto,$_SESSION['curs_para_codi'],$codi,$usua,$tipo_usua,$nombre);
		$sql_form="{call wall_curs_para_add(?,?,?,?,?,?)}";
		$stmp_form = sqlsrv_query($conn, $sql_form, $params_form);	
		if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
		
		$params_post = array($_SESSION['curs_para_codi']);
		$sql_post="{call wall_curs_para_view(?)}";
		$stmp_post = sqlsrv_query($conn, $sql_post, $params_post); 
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
                  	<img src="<?php echo $pp;?>"  border="0" />
                </div>
                                                
                <div class="information">
                    <div class="user">
                      <strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
                    </div>
                    <div class="text">
                      <?=$row_wall_curs_view['wall_curs_para_text']?>
                    </div>
                </div>
            </div>
		<?php }?>
      
        <!--<div style="width:95%; float:none; text-align:right;"><a href="posts_main.php">Ver mas...</a>-->
        <?php
	break;
	case 'post_main_add':
		$texto=$_POST['text_post_hd'];
		if($_SESSION['USUA_TIPO']=='A'){
			$tipo_usua="A";
			$nombre=$_SESSION['alum_nomb'].' '.$_SESSION['alum_apel'];
			$codi=$_SESSION['alum_codi'];
			$usua=$_SESSION['alum_usua'];
		}else{
			$tipo_usua="R";
			$nombre=$_SESSION['repr_nomb'].' '.$_SESSION['repr_apel'];
			$codi=$_SESSION['repr_codi'];
			$usua=$_SESSION['repr_usua'];
		}
		$params_form = array($texto,$_SESSION['curs_para_codi'],$codi,$usua,$tipo_usua,$nombre);
		$sql_form="{call wall_curs_para_add(?,?,?,?,?,?)}";
		$stmp_form = sqlsrv_query($conn, $sql_form, $params_form);	
		if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
		
		$params_post = array($_SESSION['curs_para_codi']);
		$sql_post="{call wall_curs_para_view_all(?)}";
		$stmp_post = sqlsrv_query($conn, $sql_post, $params_post); 
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
                  	<img src="<?php echo $pp;?>"  border="0" />
                </div>
                                                
                <div class="information">
                    <div class="user">
                      <strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
                    </div>
                    <div class="text">
                      <?=$row_wall_curs_view['wall_curs_para_text']?>
                    </div>
                     <div id="fb-root"></div>

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
                                                   
                                <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo "http://uemag.ingeniumlinks.com/alumnos/".$_SERVER['SCRIPT_NAME'].$url_param; ?>&layout=button_count&show_faces=false&action=like&colorscheme=light"scrolling="no" frameborder="0" style="height:35px; "></iframe>
                </div>
            </div>
		<?php }
	break;
	case 'post_mate_add':
		$texto=$_POST['text_post_hd'];
		$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
		if($_SESSION['USUA_TIPO']=='A'){
			$tipo_usua="A";
			$nombre=$_SESSION['alum_nomb'].' '.$_SESSION['alum_apel'];
			$codi=$_SESSION['alum_codi'];
			$usua=$_SESSION['alum_usua'];
		}else{
			$tipo_usua="R";
			$nombre=$_SESSION['repr_nomb'].' '.$_SESSION['repr_apel'];
			$codi=$_SESSION['repr_codi'];
			$usua=$_SESSION['repr_usua'];
		}
		$params_form = array($texto,$_SESSION['curs_para_codi'],$codi,$usua,$tipo_usua,$nombre,$curs_para_mate_codi);
		$sql_form="{call wall_curs_para_mate_add(?,?,?,?,?,?,?)}";
		$stmp_form = sqlsrv_query($conn, $sql_form, $params_form);	
		if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
		
		$params_post = array($curs_para_mate_codi);
		$sql_post="{call wall_curs_para_mate_view_all(?)}";
		$stmp_post = sqlsrv_query($conn, $sql_post, $params_post); 
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
      	<img src="<?php echo $pp;?>"  border="0" />
    </div>
                                    
    <div class="information">
        <div class="user">
          <strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
        </div>
        <div class="text">
          <?=$row_wall_curs_view['wall_curs_para_text']?>
        </div>
        <div id="fb-root"></div>

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
                                                   
                                <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo "http://uemag.ingeniumlinks.com/alumnos/".$_SERVER['SCRIPT_NAME'].$url_param; ?>&layout=button_count&show_faces=false&action=like&colorscheme=light"scrolling="no" frameborder="0" style="height:35px; "></iframe>
    </div>
</div>


		<?php }
	break;
}
?>