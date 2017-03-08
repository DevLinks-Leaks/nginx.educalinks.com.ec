<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=411;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title" style="width:25%; float:left;">
              <h3><span class="icon-print icon"></span>Usuarios y claves</h3>
          </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div class="alumnos_main_lista" style="float:none; width:100%;">
                            <table class="table_striped" id="alum_table">
                             <tbody>
                             <? 
							 if (permiso_activo(88))
							 {
							 ?>
                             <tr>
                             	<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
                           	 	<td><h3>Alumnos</h3></td>
                                <td>
                                <label>Curso:</label>
									<?
										include ('select_cursos_usua_pass.php');
							 		?>
                             	</td>
                                <td>
                                	<div id="lbl_paralelo">
                                    <label>Paralelo:</label>
                                        <select id="sl_paralelos" name="sl_paralelos"  disabled="disabled">
                                        	<option value="*">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                	<a href="JavaScript:getURLAlumnos();" >
                                    	<img src="../imagenes/report_to_pdf.png" style="width:45px;">
                                    </a>
                                </td>
                             </tr>
                             <? 
							 } 
							 if (permiso_activo(89))
							 {
							 ?>
                             <tr>
                             	<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
                           	 	<td><h3>Profesores</h3></td>
                                <td>
                             	</td>
                                <td>
                                </td>
                                <td>
                                	<a target="_blank" href="reportes_generales/usuarios_claves_profesores.php" >
                                    	<img src="../imagenes/report_to_pdf.png" style="width:45px;">
                                    </a>
                                </td>
                             </tr>
                              <? 
							 } 
							 if (permiso_activo(90))
							 {
							 ?>
                              <tr>
                             	<td><img src="../imagenes/repo_icon.png" style="width:60px;"></td>
                           	 	<td><h3>Administrativos</h3></td>
                                <td>
                             	</td>
                                <td>
                                </td>
                                <td>
                                	<a target="_blank" href="reportes_generales/usuarios_claves_administrativos.php" >
                                    	<img src="../imagenes/report_to_pdf.png" style="width:45px;">
                                    </a>
                                </td>
                             </tr>
                              <? 
							 } 
							 ?>
                             </tbody>
                            </table>
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
    
</body>
<!-- InstanceEnd --></html>