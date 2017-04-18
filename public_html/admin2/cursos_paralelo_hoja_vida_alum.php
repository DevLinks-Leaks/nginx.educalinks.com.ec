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
          <?
            $alum_curs_para_codi=$_GET['alum_curs_para_codi'];
          ?>

        <div class="title">
            <h3>
                <span class="icon-eye icon"></span>
                Observaciones
            </h3>
        </div>
        <div class="options">
          <ul>
              <li>
                  <a class="button_text" data-toggle="modal" data-target="#modal_new_obse">
                      <span class="icon icon-add"></span> Observación
                  </a>
              </li>
              <li>
                  <a class="button_text" href="reportes_generales/hoja_vida_estudiante.php?alum_curs_para_codi=<?= $alum_curs_para_codi; ?>" target="_blank">
                      <span class="icon icon-print"></span> Imprimir
                  </a>
              </li>
          </ul>
        </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script src="js/funciones_observaciones.js?<?= $rand?>"></script>
                        <div id="div_obs_list">
                            <?php
                            $params_obs=array($alum_curs_para_codi);
                            $sql_obs="{call observacion_alum_info(?)}";
                            $stmp_obs = sqlsrv_query($conn, $sql_obs,$params_obs);
                            if( $conn === false)
                            {
                                echo "Error in connection.\n";
                                die( print_r( sqlsrv_errors(), true));
                            }
                            ?>
                            <table class="table_striped">
                                <thead>
                                <tr>
                                    <th width="15%">Tipo de Observaci&oacute;n</th>
                                    <th width="40%">Observaci&oacute;n</th>
                                    <th width="15%">Ingresado por</th>
                                    <th width="15%">Rol</th>
                                    <th width="15%">Fecha de Ingreso</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while($row_obs_view=sqlsrv_fetch_array($stmp_obs)){?>
                                    <tr>
                                        <td><?=$row_obs_view['obse_tipo_deta'];?></td>
                                        <td><?=$row_obs_view['obse_deta'];?></td>
                                        <td><?=$row_obs_view['usua_deta'];?></td>
                                        <td><?=$row_obs_view['usua_tipo'];?></td>
                                        <td><?=date_format($row_obs_view['obse_fech'],"d/m/Y");?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>
	</div>

    <!--Modal para agregar observación-->
    <div
        class="modal fade"
        id="modal_new_obse"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        Nueva observación
                    </h4>
                </div>
                <div id="modal_main" class="modal-body">
                    <div id="div_usua_edi">
                        <div class="form_element">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="25%" style="padding-top: 15px;">
                                        <label>Tipo de observación: </label>
                                    </td>
                                    <td style="padding-top: 15px;">
                                        <?php
                                        $sql="{call tipo_observacion_view()}";
                                        $tipo_obs_view = sqlsrv_query($conn, $sql);
                                        ?>
                                        <select id="tipo_obs" name="tipo_obs" style="width: 100%">
                                            <?php while($row_tipo_obs_view = sqlsrv_fetch_array($tipo_obs_view)){?>
                                                <option value="<?=$row_tipo_obs_view['obse_tipo_codi']?>"><?=$row_tipo_obs_view['obse_tipo_deta']?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" style="padding-top: 15px;">Escriba la observación</td>
                                    <td style="padding-top: 15px;"><textarea id="obs_deta" style="width:100%; height: 200px;resize: none;" ></textarea></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form_element">&nbsp;</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        id="btn_obs_add"
                        class="btn btn-primary"
                        type="button"
                        data-loading="Agregando.."
                        onClick="obs_add('div_obs_list','script_observaciones_alum.php','<?=$alum_curs_para_codi?>')"
                        >
                        Agregar
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--Fin-->
    
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
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_dperi_deta"]; ?></button></td>
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