<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=201;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
		 <script type="text/javascript" src="../framework/funciones.js"></script>
         <script type="text/javascript" src="js/funciones_curs.js"></script>
         <script type="text/javascript" src="js/funciones_alum.js"></script>
         <script type="text/javascript" src="js/funciones_notas.js"></script>
          <?php
			session_start();	 
			include ('../framework/dbconf.php');
			
			if(isset($_GET['curs_para_codi'])){
			 $curs_para_codi=$_GET['curs_para_codi'];
			}
			
			$params = array($curs_para_codi);
			$sql="{call curs_para_info(?)}";
			$curs_para_info = sqlsrv_query($conn, $sql, $params);  
			$row_curs_para_info = sqlsrv_fetch_array($curs_para_info); 
		?>
      	<div class="title" style="display: block; float: left; width: 100%; height: 50px;">
            <h3 style="margin: 0 0;padding:15px 0;">
            	<span class="icon-books icon"></span>
				<?php 
				echo $row_curs_para_info["curs_deta"]; 
				?> 
                - Paralelo: 
				<?php 
				echo $row_curs_para_info["para_deta"]; 
				?>
            	Nivel: 
				<?php 
				echo $row_curs_para_info["nive_deta"]; 
				?> 
            	- Cupos:  
				<?php 
				echo $row_curs_para_info["cupo_cc"]; ?> / <?php echo $row_curs_para_info["curs_para_cupo"]; 
				?>
            </h3>
            <input 
            	type="hidden" 
                id="curs_para_cupo" 
                data-alum_num = <?=$row_curs_para_info["cupo_cc"];?>
                data-cupo_actual="<?=$row_curs_para_info["curs_para_cupo"]?>" />
            </div>
            <div class="options" style="display: block; float: left; width: 100%; height: 50px;">
              <ul style="display: block; float: left;">
              <li>
                  <a 
                  	class="button_text"  
                    onclick="document.getElementById('texto_mate').value='';" 
					data-toggle="modal" 
                    data-target="#ModalMate" 
                    title="">
                    	<span class="icon-add icon"></span>Materias
                  </a>
                </li>
				<!--
                 <li>
                  <a 
                  	class="button_text"    
                    onclick="document.getElementById('texto_alum').value='';
                    		 texto_buscar_alum();" 
					data-toggle="modal" 
                    data-target="#ModalAlum" 
                    title="">
                    	<span class="icon-add icon"></span>Alumnos
                  </a>
                </li>
				-->
               <?php if (permiso_activo(96)){?>
               <li>
                  <a 
                  	class="button_text"  
                    onclick="" 
                    data-toggle="modal" 
                    data-target="#ModalCopiadeMaterias" 
                    title="">
                    	<span class="icon-copy icon"></span>Copiar materias
                   </a>
                </li>
                <? } ?>
                <?php if (permiso_activo(97)){?>
              <li>
                  <a 
                  	class="button_text"  
                    onclick="curs_para_cupo_upd_dial();" 
                    data-toggle="modal" 
                    data-target="#ModalEditCupo" 
                    title="">
                    	<span class="icon-list icon"></span>Modificar cupo
                  </a>
                </li>
                 <? } ?>
                  <li>
                  <a 
                  	class="button_text"    
                    href="cursos_paralelo_info_main_impr.php?curs_para_codi=<?= $_GET['curs_para_codi']; ?>">
                    	<span class="icon-print icon"></span>Imprimir
                  </a>
                </li>
              </ul>
            </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                         
                         <div id="curs_main" >
                             <?php include ('cursos_paralelo_info_main_view.php'); ?>
                         </div>

         
                    
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
    <!-- Modal SELECCION DE PERIODO -->
    <div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
          </div>
          <div class="modal-body">
           
                <table>
                    <tr>
                        <td>PERIODOS</td>                        
                        
                    </tr>
                            
                     <? 	
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    
                     <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
                     <tr>    
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
                    </tr>
                    <?php  } ?>


                     
                   
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>