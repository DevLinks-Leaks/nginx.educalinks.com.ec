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
                           	 	<td><h3>Materias</h3></td>
                                <td>
                                	<input id="file_materia" class="btn" type="file" accept="application/vnd.ms-excel"/>
                                </td>
                                <td><a href="../importacion_datos/downloads/tmp_materias.xls">Descargar</a></td>
                                <td>
                                	<button onClick="Subir(document.getElementById('file_materia'),'div_progreso_materia', 'materias');">
                                    	Subir Archivo
                                    </button>
                                </td>                                
                                <td>
                                	<div id="div_progreso_materia">
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
                               <td><img src="../imagenes/load-icon.png" alt="" style="width:60px;"></td>
                               <td><h3>Matriculación</h3></td>
                               <td><input id="file_matriculas" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_matriculas.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_matriculas'),'div_progreso_matriculas', 'alumnos_cursos_paralelos');">Subir Archivo</button></td>
                               <td><div id="div_progreso_matriculas"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Sucursales</h3></td>
                                <td><input id="file_sucursal" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_sucursal.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_sucursal'),'div_progreso_sucursal', 'sucursal');">Subir Archivo</button></td>
                               <td><div id="div_progreso_sucursal"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Puntos de Ventas</h3></td>
                                <td><input id="file_puntoVenta" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_puntoVenta.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_puntoVenta'),'div_progreso_puntoVenta', 'puntoVenta');">Subir Archivo</button></td>
                               <td><div id="div_progreso_puntoVenta"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Categorias</h3></td>
                                <td><input id="file_categoria" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_categoria.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_categoria'),'div_progreso_categoria', 'categoria');">Subir Archivo</button></td>
                               <td><div id="div_progreso_categoria"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Productos</h3></td>
                                <td><input id="file_producto" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_producto.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_producto'),'div_progreso_producto', 'producto');">Subir Archivo</button></td>
                               <td><div id="div_progreso_producto"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Precios</h3></td>
                                <td><input id="file_precio" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_precio.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_precio'),'div_progreso_precio', 'precio');">Subir Archivo</button></td>
                               <td><div id="div_progreso_precio"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Formas de Pago</h3></td>
                                <td><input id="file_formapago" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_formaPago.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_formapago'),'div_progreso_formapago', 'formaPago');">Subir Archivo</button></td>
                               <td><div id="div_progreso_formapago"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Deuda</h3></td>
                                <td><input id="file_deuda" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_deuda.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_deuda'),'div_progreso_deuda', 'deuda');">Subir Archivo</button></td>
                               <td><div id="div_progreso_deuda"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Detalle Factura</h3></td>
                                <td><input id="file_detalleFactura" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_detalleFactura.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_detalleFactura'),'div_progreso_detalleFactura', 'detalleFactura');">Subir Archivo</button></td>
                               <td><div id="div_progreso_detalleFactura"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Cabecera Factura</h3></td>
                                <td><input id="file_cabeceraFactura" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_cabeceraFactura.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_cabeceraFactura'),'div_progreso_cabeceraFactura', 'cabeceraFactura');">Subir Archivo</button></td>
                               <td><div id="div_progreso_cabeceraFactura"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Cabecera Pago</h3></td>
                                <td><input id="file_cabeceraPago" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_cabeceraPago.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_cabeceraPago'),'div_progreso_cabeceraPago', 'cabeceraPago');">Subir Archivo</button></td>
                               <td><div id="div_progreso_cabeceraPago"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Detalle Pago</h3></td>
                                <td><input id="file_detallePago" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_detallePago.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_detallePago'),'div_progreso_detallePago', 'detallePago');">Subir Archivo</button></td>
                               <td><div id="div_progreso_detallePago"></div></td>
                             </tr>
                             <tr>
                             	<td><img src="../imagenes/load-icon.png" style="width:60px;"></td>
                           	 	<td><h3>Deuda Afectada</h3></td>
                                <td><input id="file_deudaAfectada" class="btn" type="file" accept="application/vnd.ms-excel"/></td>
                               <td><a href="../importacion_datos/downloads/tmp_deudaAfectada.xls">Descargar</a></td>
                               <td><button onClick="Subir(document.getElementById('file_deudaAfectada'),'div_progreso_deudaAfectada', 'deudaAfectada');">Subir Archivo</button></td>
                               <td><div id="div_progreso_deudaAfectada"></div></td>
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