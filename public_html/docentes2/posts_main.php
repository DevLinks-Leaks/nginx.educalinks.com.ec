<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=0; ?>
								
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
          <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
               <div class="title" ><h3><span class="icon-pencil icon"></span>Posts</h3></div> 
               
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" --> 
<div class="docentes_post  zones">

<div class="panel">
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
            value="<?=$curs_para_mate_codi_hd?>" />
            
		<input 
        	type="hidden" 
            id="curs_para_codi_hd" 
            name="curs_para_codi_hd" 
            value="<?=$curs_para_codi?>" />
	</div>
	<div style="float:none; text-align:right; padding-top:10px;">
	<button 
    	type="button" 
        class="btn btn-primary" 
        onclick="post_add('posts_div','script_post.php');">
        Enviar
	</button>
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
                        
    <div id="posts_div"  class="post_list">
        <?php
        if ($curs_para_mate_prof_codi==0){
            $params_post = array($_SESSION['curs_para_codi']);
            $sql_post="{call wall_curs_para_view_all(?)}";
            $stmp_post = sqlsrv_query($conn, $sql_post, $params_post);
        }else{
            $params_post = array($curs_para_mate_prof_codi);
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
		<div id="fb-root"></div>

		<script>(function(d, s, id) {
        
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
                                                   
		<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo "http://uemag.ingeniumlinks.com/alumnos/".$_SERVER['SCRIPT_NAME'].$url_param; ?>&layout=button_count&show_faces=false&action=like&colorscheme=light"scrolling="no" frameborder="0" style="border:none; height:25px; width: 440px;"></iframe>
                                <?php echo "</div></div>"; ?> <!-- COLOQUE ESTA LINEA PORQUE MOLESTA, HAY DIV SIN CERRAR DESDE ALGUN LUGAR DEL PROG. o DEL IFRAME -->
                                <?php }?>
                              </div>
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

<!-- InstanceEnd --></html>