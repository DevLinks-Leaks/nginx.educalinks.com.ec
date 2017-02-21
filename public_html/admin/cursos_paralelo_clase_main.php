<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=3; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title"><h3> <span class="icon-books icon"></span>Clases</h3></div> 
               
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->

<div class="docentes_clases">                        
    <table class="table_striped">
        <thead>
            <tr>
                <td>
                    <div class="title">
                        <h4>MATERIAS:</h4>
                    </div>
                </td>
            </tr>
        </thead>
    <tbody>
        <tr style="display:none;">
            <td></td>
        </tr>
        <tr>
            <td>
            <?php
            $curs_para_codi=$_GET['curs_para_codi'];
            $params_mate = array($curs_para_codi);
            $sql_mate="{call curs_peri_mate_view_v2(?)}";
            $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate);
            while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
            {
            ?>
                <div class="accordion" id="mate_h<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>">
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>">
                        <div style="width:70%;float:left;" ><?= strtoupper($row_curs_mate_view["mate_deta"].' ('.$row_curs_mate_view["prof_apel"].' '.$row_curs_mate_view["prof_nomb"]).' )'; ?></div>
                      </a>
                    </div>
                    <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" class="accordion-body collapse in">
                      <div  id="mate-inner_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" class="accordion-inner">
                        <div class="zone">
                         <table class="table_striped">
                            <?php
                            $ruta=$_SESSION['ruta_foto_docente'];
                            $full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
                            $file_exi=$full_name;
                            if (file_exists($file_exi)){
                                $pp=$file_exi;
                            } else {
                                $pp=$_SESSION['foto_default'];
                            }?>
                            <thead>
                              <tr>
                                <th>
                                  <span class="icons icon-parent"></span>Profesor
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td  class="no-padding">
                                    <div class="teacher">
                                        <div class="image">
                                            <img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:55px; height:55px;"/>
                                        </div>
                                        <div class="information">
                                            <div class="name">
                                                <?= $row_curs_mate_view["prof_nomb"]; ?>
                                            </div>
                                            <div class="email">
                                                <?= $row_curs_mate_view["prof_mail"]; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </div>
                <div class="zone-last">
                    <?
                    $sql = "{call prof_summary (?)}";
                    $params = array ($row_curs_mate_view["curs_para_mate_prof_codi"]);
                    $stmt = sqlsrv_query($conn, $sql, $params);
                    if ($stmp === false)
                    {
                        die(print_r (sqlsrv_errors(), true));
                    }
                    $row_summary = sqlsrv_fetch_array($stmt);
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    <span class="icons icon-bars3"></span>
                                    Resumen
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <table style="margin-top: 10px">
                                        <tr>
                                            <td width="5%"><span class="icon-calendar icon"></span></td>
                                            <td width="60%"><strong>Agendas activas</strong></td>
                                            <td><?= $row_summary['num_agendas']?></td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><span class="icon-attachment icon"></span></td>
                                            <td width="60%"><strong>Materiales subidos</strong></td>
                                            <td><?= $row_summary['num_materiales']?></td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><span class="icon-envelope icon"></span></td>
                                            <td width="60%"><strong>Mensajes enviados (últimos 30 días)</strong></td>
                                            <td><?= $row_summary['num_mensajes']?></td>
                                        </tr>
                                        <tr>
                                            <td width="5%"><span class="icon-clock icon"></span></td>
                                            <td width="60%"><strong>Última sesión</strong></td>
                                            <td><?= $row_summary['ultima_sesion']?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <a
                                                    class="btn btn-primary center-block"
                                                    href="cursos_paralelo_clase_deta.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view["curs_para_mate_prof_codi"]?>">
                                                    Ver Detallado
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>

              </div>
            </div>
          </div>


    <?php
            }
    ?>
    </td>
    </tr>
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
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>