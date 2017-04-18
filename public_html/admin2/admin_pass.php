<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=101;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title"><h3><span class="icon-lock icon"></span>Cambio de Contrase&ntilde;a</div><!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
						<?php  
						session_start();
                        include ('../framework/dbconf.php');
						if(isset($_POST['current_pass'])){
							$params = array($_SESSION['usua_codi']);
							$sql="{call usua_info(?)}";
							$stmt = sqlsrv_query($conn, $sql, $params);
							if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
							$usua_view= sqlsrv_fetch_array($stmt);
							if($usua_view['usua_pass']==$_POST['current_pass']){
								if ($_POST['new_pass_1']==$_POST['new_pass_2']){
								$params_usua = array($_SESSION['usua_codi'],$_POST['new_pass_1']);
								$sql_usua="{call usua_pass_upd(?,?)}";
								$stmt_usua = sqlsrv_query($conn, $sql_usua, $params_usua);
								if( $stmt_usua === false )
								{
									echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
								}
								else
								{
							?>
								<script>
									$.growl.notice({ title: "Listo!",message: "Se actualiz&oacute; la contrase&ntilde;a correctamente." });
								</script>
							<?
								}
							}
							else
							{
						?>
							<script>
								$.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseñas no coinciden." });
							</script>
						<?
							}
						}
						else
						{
						?>
							<script>
								$.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseña ingresada no es la correcta." });
							</script>
						<?
							
						}
					}
						?>


            <div class="alumnos_add_script admin_pass">
                        <form id="usua_pass_form" name="usua_pass_form" enctype="multipart/form-data" action="" method="post">
                        
                             <div>
                                <div class="form_element">
                                    <label for="current_pass">Contrase&ntilde;a Actual:</label>
                                    <input id="current_pass" name="current_pass" type="password" placeholder="Ingrese su clave actual..." value="">
                                </div>
                                 <div class="form_element">
                                    <label for="new_pass_1">Nueva Contrase&ntilde;a:</label>
                                    <input id="new_pass_1" name="new_pass_1" type="password" placeholder="Ingrese su nueva clave..." value="">
                                </div>
                                 <div class="form_element">
                                    <label for="new_pass_2">Confirme su nueva contrase&ntilde;a:</label>
                                    <input id="new_pass_2" name="new_pass_2" type="password" placeholder="Confirme su nueva clave..." value="">
                                </div>
                                <div class="buttons">
                                    <ul>
                                      <li>
                                    	<button id="pass_guardar" name="pass_guardar" type="submit" >Grabar</button>
                                        
                                      </li>
                                    </ul>
                                </div>
                            </div>
                        
                        </form>
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->
		<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>