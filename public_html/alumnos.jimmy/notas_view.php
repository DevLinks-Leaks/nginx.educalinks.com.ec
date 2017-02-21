<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->
  
  <?php include ('head.php');?>

	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=4;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
      <?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
          <?php include ('header.php');?>

  				<div class="main sectionBorder">
  					<div id="information">
            
              <div class="titleBar">
              <!-- InstanceBeginEditable name="Titulo Top" -->
              <?
        		  switch ($_SESSION['peri_dist_cab_tipo'])
        			{
        				case 'I':
        					$url_libreta = 'cursos_paralelo_notas_alum_libreta_inicial_'.$_SESSION['directorio'].'.php'; 
        				break;	
        				
        				case 'G':
        					$url_libreta = 'cursos_paralelo_notas_alum_libreta_'.$_SESSION['directorio'].'.php';
        				break;
        			}
        		  ?>
              <div class="title">
              <h3>
                  <span class="icon-briefcase icon"></span>
                  Notas
              </h3>
              </div>   <div class="options">
                    
                    <ul>
                     <?
            			   		$alum_codi=$_GET['alum_codi'];
            						$peri_dist_codi=$_GET['peri_dist_codi'];
                    
            						$peri_codi = $_SESSION['peri_codi'];
            						//VALIDA PERMISO
            						$peri_etap_codi = 'U';
            						$params = array($peri_codi, $_SESSION['peri_dist_cab_tipo'],$peri_etap_codi);
            						$sql="{call peri_dist_peri_view_Lb_etapa(?,?,?)}";
            						$peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);
            						$negar = 0;
            						while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
            						{ 	if($row_peri_dist_peri_view['peri_dist_codi'] == $peri_dist_codi)
            							$nonegar++;
            						}
            						if($nonegar != 0)
            						{	
                          if($_SESSION['directorio']!='arcoiris'){
                            echo '
              							<li>
              								<a  id="bt_mate_add"
              									class="button_text"
              									href="'.$url_libreta.'?peri_dist_codi='.$peri_dist_codi.'">
              									<span class="icon-print"></span>Imprimir Libreta
              								</a>
              							</li>';
                          }
            						}	
        				    ?>
                      
      
                    </ul>
                </div><!-- InstanceEndEditable -->
            </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                              
            <div  id="tab_libr">
							 <?php
							if($nonegar == 0)
							{	die ( "Resultado desconocido" );
							}
							else
							{   if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi']))
								{
									include($url_libreta); 
								}
								else
								{
									$sql		= "{call str_common_deudasMatricula_cons(?)}";
									$options	= array("scrollable"=>"buffered");
									$params		= array($_SESSION['alum_codi']);
									$stmt	 	= sqlsrv_query( $conn, $sql, $params, $options);
									if( $stmt === false )
									{	echo "Error in executing statement .\n";
										die( print_r( sqlsrv_errors(), true));
									}
									if (sqlsrv_has_rows($stmt))
									{	$row = sqlsrv_fetch_array($stmt);
										if( $row["totalDeuda"] != '0.00' )
										{   echo "<div class='alert alert-warning'>".
												  "<center>Usted no puede ver sus notas porque mantiene una deuda con la institución.<br></center>
											  </div>";
										}
									}
									/*echo "<div class='alert alert-warning'  style='align:center;'>
										  <strong>¡Deuda pendiente!</strong>".
										  "<center>Usted no puede ver sus notas porque mantiene deudas con la institución<br>
										  <span class='icon icon-file'></span>&nbsp;".
										  "<a href='../modulos/finan/clientes/controller.php?event=print_report&codigoAlumno=".$_SESSION['alum_codi'].
										  "&codigoPeriodo=&fechaInicio=&fechaFin=' target='_blank'>Ver estado de cuenta</a></center>
									  </div>";*/
								}						
							}
							?>
						</div>
                    
          </div>
				</div>
			</div>
    </div><!-- Page Container -->
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	  <input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
</body>

</html>