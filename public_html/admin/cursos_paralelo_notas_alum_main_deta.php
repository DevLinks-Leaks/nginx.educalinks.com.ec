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
                  <h3><span class="icon-books icon"></span>Libreta</h3>
              </div> 
              <div class="options">
                  <ul>
                   <?
				   		$alum_codi=$_GET['alum_codi'];
						$peri_dist_codi=$_GET['peri_dist_codi'];
						$curs_para_codi=$_GET['curs_para_codi'];
						
						
						/*Libreta por lotes*/
						$nive_codi = curs_para_nive_cons($curs_para_codi);
						if ($nive_codi==4 or $nive_codi==5)
						{
							/*Archivo.php para libretas de inicial*/
							$url_libreta_individual="cursos_paralelo_notas_alum_libreta_inicial_";
						}
						else
						{
							/*Archivo.php para las demás libretas de inicial*/
							$url_libreta_individual="cursos_paralelo_notas_alum_libreta_";
						}
				    ?>
                    <li>
                      <a id="bt_mate_add"  class="button_text"  href="<?= $url_libreta_individual.$_SESSION['directorio']?>.php?peri_dist_codi=<?= $peri_dist_codi ?>&alum_codi=<?= $alum_codi?>&curs_para_codi=<?= $curs_para_codi ?>">
                        <span class="icon-print"></span>Imprimir Libreta
                      </a>
                    </li>
    
                  </ul>
              </div>
          
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
              
                        <div  id="tab_libr" align="center">
                        
							 <?php 	
							 //echo $url_libreta_individual.$_SESSION['directorio'].'.php';
							 include($url_libreta_individual.$_SESSION['directorio'].'.php') ?>
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>