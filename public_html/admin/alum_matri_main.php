<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=605;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->

          <div class="title">
              <h3><span class="icon-users icon"></span>Alumnos</h3>
          </div> 





          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_alum.js"></script>     
                        <div id="alum_main" >
                             <?php include ('alum_matri_main_lista.php'); ?>
                        </div>
                                     
                        <div class="modal fade" id="ModalMatri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nueva Matriculaci&oacute;n</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_matri"> 
                                    <?
                                        $sql_peri="{call peri_0()}";
                                        $peri_busq = sqlsrv_query($conn, $sql_peri);
                                    ?>Periodo Lectivo:
                                    <select id="peri_0" name="peri_0"  onchange="load_ajax('div_curs','cursos_paralelo_main_combo.php','peri_codi=' + this.value)" class="select">
                                    <? while($row_peri_bus= sqlsrv_fetch_array($peri_busq)){?>
                                    <option value="<?= $row_peri_bus['peri_codi'];?>" <? echo $_SESSION['peri_codi']==$row_peri_bus['peri_codi']? "selected":"";?>><?= $row_peri_bus['peri_deta'];?></option>
                                    <? }?>
                                    </select>
                                    <input type="hidden" id="alum_codi" name="alum_codi" value="">
                                    <div id="div_curs">
                                        &nbsp;
                                    </div>
                                    <script>
							   			load_ajax_alum_curso_combo('div_curs','cursos_paralelo_main_combo.php','peri_codi='+ document.getElementById('peri_0').value);
									</script>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="vali_matri(document.getElementById('span_cupo').innerHTML,document.getElementById('curs_para_codi').value,document.getElementById('alum_codi').value);" >Matricular</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->

</body>
<!-- InstanceEnd --></html>