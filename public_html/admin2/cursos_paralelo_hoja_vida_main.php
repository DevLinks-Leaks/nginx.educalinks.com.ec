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

<div class="title">
  	<h3>
  		<span class="icon-eye icon"></span>
        Observaciones
	</h3>
</div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" --> 
                        <div  id="tab_libr">
                            <?
                            $curs_para_codi=$_GET['curs_para_codi'];
                            $params = array($curs_para_codi);
                            $sql="{call alum_curs_para_view(?)}";
                            $alum_curs_para_view = sqlsrv_query($conn, $sql, $params);
                            ?>
                            <table class="table_striped">
                                <tbody>
                                <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?>
                                    <tr>
                                        <td width="80%">
                                            <table class="table_basic">
                                                <tr>
                                                    <?php
                                                    $file_exi = $_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
                                                    if (file_exists($file_exi)) {
                                                        $pp=$file_exi;
                                                    } else {
                                                        $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
                                                    }
                                                    ?>
                                                    <td width="30" class="center"><?php echo $cc; ?></td>
                                                    <td width="40" class="center" >
                                                        <img src="<?php echo $pp; ?>" style=" text-align:right; border:none; width:40px; height:40px;"/>
                                                    </td>
                                                    <td width="404" class="left" ><?= $row_alum_curs_para_view["alum_codi"]; ?>
                                                        - <?= $row_alum_curs_para_view["alum_apel"]." ".$row_alum_curs_para_view["alum_nomb"]; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <div class="menu_options">
                                                <ul>
                                                    <li>
                                                        <button
                                                            class="btn btn-primary"
                                                            onClick="window.location='cursos_paralelo_hoja_vida_alum.php?alum_curs_para_codi=<?= $row_alum_curs_para_view["alum_curs_para_codi"];?>'">
                                                            <i class='fa fa-edit'></i> Editar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
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