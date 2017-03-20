<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
  
      <!-- Fin -->
  </head> 
  <body class="general admin"> 
                <!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=409;    ?><!-- InstanceEndEditable -->
    <div class="pageContainer"> 

      <?php include ('menu.php');?>

      <div id="mainPanel" class="section_main">
            
              <?php include ('header.php');?>
        
        <div class="main sectionBorder">
          <div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <script src="js/funciones_upload_data.js"></script>
          <div class="title" style="width:25%; float:left;">
              <h3><span class="icon-upload icon"></span>CARGA DE DATOS</h3>
          </div>
      <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div class="alumnos_main_lista" style="float:none; width:100%;">
                            <table class="table_striped" id="alum_table">
                             <thead>
                              <tr>
                                <th width="5%">&nbsp;</th>
                                <th width="30%" class="sort">Descripción</th>
                                <th width="40%" class="sort">Buscar archivo</th>
                                <th width="10%" class="sort">Plantilla</th>
                                <th width="10%">Acción</th>
                                <th width="5%">Progreso</th>
                              </tr>
                             </thead>
                             <tbody>
                             <tr>
                              <td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                              <td><h3>Alumnos</h3></td>
                                <td>
                                  <input id="file_alumno" class="btn" type="file" accept="application/vnd.ms-excel"/>
                                </td>
                                <td><a href="../importacion_datos/downloads/tmp_alumnos.xls">Descargar</a></td>
                                <td>
                                  <button onClick="Subir(document.getElementById('file_alumno'),'div_progreso_alumno', 'alumnos');">
                                      Subir Archivo
                                    </button>
                                </td>                                
                                <td>
                                  <div id="div_progreso_alumno">
                                    </div>
                                </td>
                             </tr>
                             
                             <tr>
                              <td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                              <td><h3>Representantes</h3></td>
                                <td>
                                  <input id="file_representantes" class="btn" type="file" accept="application/vnd.ms-excel"/>
                                </td>
                                <td><a href="../importacion_datos/downloads/tmp_representantes.xls">Descargar</a></td>
                                <td>
                                  <button onClick="Subir(document.getElementById('file_representantes'),'div_progreso_representante', 'representantes');">
                                      Subir Archivo
                                    </button>
                                </td>                                
                                <td>
                                  <div id="div_progreso_representante">
                                    </div>
                                </td>
                             </tr>
                             <tr>
                                <td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                                <td><h3>Representantes Alumnos</h3></td>
                                <td>
                                    <input id="file_alum_repr" class="btn" type="file" accept="application/vnd.ms-excel"/>
                                </td>
                                <td><a href="../importacion_datos/downloads/tmp_alum_repr.xls">Descargar</a></td>
                                <td>
                                    <button onClick="Subir(document.getElementById('file_alum_repr'),'div_progreso_alum_repr', 'alum_repr');">
                                        Subir Archivo
                                    </button>
                                </td>                                
                                <td>
                                    <div id="div_progreso_alum_repr">
                                    </div>
                                </td>
                             </tr>
                             <tr>
                              <td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                              <td><h3>Profesores</h3></td>
                                <td>
                                  <input id="file_profesor" class="btn" type="file" accept="application/vnd.ms-excel"/>
                                </td>
                                <td><a href="../importacion_datos/downloads/tmp_profesores.xls">Descargar</a></td>
                                <td>
                                  <button onClick="Subir(document.getElementById('file_profesor'),'div_progreso_profesor', 'profesores');">
                                      Subir Archivo
                                    </button>
                                </td>                                
                                <td>
                                  <div id="div_progreso_profesor">
                                    </div>
                                </td>
                             </tr>
                             </tbody>
                            </table>
                        </div>
                        <div id="div_resultado">
                        </div>
                        <!-- InstanceEndEditable -->
                    </div>
        </div>
      </div>

  
  </div>
    
    
    <input name="mens_de"     type="hidden" id="mens_de"    value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
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