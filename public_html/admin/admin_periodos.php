<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=403;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          

          <div class="title"><h3><span class="icon-calendar icon"></span>Periodos</h3></div>
      <div class="options">
            <ul>
              <?php if (permiso_activo(52)){?>
                <li>
                  <a id="bt_peri_add" class="button_text" onclick="peri_nue()" data-toggle="modal" data-target="#peri_nuev" >
                    <span class="icon-add icon"></span> Nuevo periodo
                  </a>
                </li>
              <?php }?>
            </ul>
          </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
 
						   <script type="text/javascript" src="../framework/funciones.js"> </script>
                           <script src="js/funciones_periodos.js"></script>
                           
                           <div id="curs_peri_main" >
                           	 	<?php include ('admin_periodos_lista.php'); ?>                           
                           </div>

                    <!-- Modal -->
                    <input id="n_peri_codi" name="n_peri_codi" type="hidden" value="">
                    <input id="n_do" name="n_do" type="hidden" value="N">
					<div class="modal fade" id="peri_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title" id="myModalLabel"><label id="n_modaltitu">Nuevo Periodo </label></h4>
						  </div>
						  <div class="modal-body">
						  <div>
						  <div class="form_element">
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="25%">Nombre: </td>
								<td style="padding-top: 15px;"><input id="n_peri_deta" name="n_peri_deta" type="text" style="width: 90%;" value=""></td>
							</tr>
							<tr>
								<td width="25%">Año: </td>
								<td style="padding-top: 15px;"><input id="n_peri_ano" name="n_peri_ano" type="number" style="width: 25%;" value="<?= date("Y");?>"></td>
							</tr>
							</table>
							</div>
							<div class="form_element">&nbsp;</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="peri_aceptar()">
								Aceptar
							</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Cerrar
							</button>
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