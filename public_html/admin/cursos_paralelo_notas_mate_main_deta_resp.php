<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
      	<script src="../framework/includes/maskmoney/src/jquery.maskMoney.js" type="text/javascript"></script>
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
         <?php 
						session_start();
						include ('../framework/dbconf.php');
						include ('../framework/funciones.php');
						
						if (isset($_POST['peri_dist_codi'])){$peri_dist_codi=$_POST['peri_dist_codi'];}else{if (isset($_GET['peri_dist_codi'])){$peri_dist_codi=$_GET['peri_dist_codi'];}}
						if (isset($_POST['curs_para_mate_codi'])){$curs_para_mate_codi=$_POST['curs_para_mate_codi'];}else{if (isset($_GET['curs_para_mate_codi'])){$curs_para_mate_codi=$_GET['curs_para_mate_codi'];}}		
								
						/*Pregunto si hicieron click en GRABAR*/
						if(isset($_POST['graba']) && $_POST['graba']=='S')
						{
							
							if (isset($_POST['cc']))
								{$cc=$_POST['cc'];}
							
							if (isset($_POST['CC_COLUM_index']))
								{$cc_index=$_POST['CC_COLUM_index'];}
							
							
							//Inicia en 1
							$i=1;
							
							$xml='<?xml version="1.0" encoding="utf-8"?>';
							//Lista de Alumnos		  
							$xml.='<ns u="'.$_SESSION['usua_codi'].'" t="A" m="'.$peri_dist_codi.'">';
							while ($i<=$cc)
							{
								//Lista las columnnas de ingreso		
								$alum_curs_para_mate_codi= $_POST['alum_curs_para_mate_codi_'.$i];
								$i2=0;
								$xml.='<a c="'.$alum_curs_para_mate_codi.'">';
								
								//Detalle de auditoría
								$detalle ="<b>alum_curs_para_mate_codi </b>".$alum_curs_para_mate_codi;
								
								while ($i2<$cc_index)
								{
									$peri_dist_codi=$_POST['peri_dist_codi_'.($i2+ 1)];
									$nota=$_POST['nota_'.$i.'_'.$i2];
									$i2+=1;
									$xml.='<n p="'.$peri_dist_codi.'" v="'.$nota.'" />';
												
									//Detalle de auditoría de notas
									$detalle.=", <b>peri_dist_codi </b>".$peri_dist_codi;
									$detalle.=" <b>nota </b>".$nota;				
								}
								$i+=1;
								$xml.='</a>';
								
								//Registro de la auditoría
								registrar_auditoria(19,$detalle);
							}
							$xml.='</ns>';
							
						
							
							$params = array($xml);
							$sql = "{call notas_xml_add(?)}";
							$stmt_xml = sqlsrv_prepare($conn,$sql,$params);
							if( !$stmt_xml ) {
								die( print_r( sqlsrv_errors(), true));
							}
							if( sqlsrv_execute( $stmt_xml ) === false ) {
							  die( print_r( sqlsrv_errors(), true));
							}
							else
							{?>
                                <div class="title">
                                	<h3><span class="icon-books icon"></span> Resultado: </h3>
                                </div>
								
								<?php 
								if (isset($_POST['peri_dist_codi'])){$peri_dist_codi=$_POST['peri_dist_codi'];}else{if (isset($_GET['peri_dist_codi'])){$peri_dist_codi=$_GET['peri_dist_codi'];}}
								if (isset($_POST['curs_para_mate_codi'])){$curs_para_mate_codi=$_POST['curs_para_mate_codi'];}else{if (isset($_GET['curs_para_mate_codi'])){$curs_para_mate_codi=$_GET['curs_para_mate_codi'];}}
								if (isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{if (isset($_GET['alum_codi'])){$alum_codi=$_GET['alum_codi'];}}
								
								$params32 = array($curs_para_mate_codi);
								$sql32="{call alum_curs_para_mate_view(?)}";
								$alum_proc_notas_view32 = sqlsrv_prepare($conn, $sql32, $params32); 
								if( !$alum_proc_notas_view32 ) {
									die( print_r( sqlsrv_errors(), true));
								}
								if( sqlsrv_execute( $alum_proc_notas_view32 ) === false ) {
									die( print_r( sqlsrv_errors(), true));
								}
								
								
								$c=0;
								while($row_alum_proc_notas_view32= sqlsrv_fetch_array($alum_proc_notas_view32))
								{   $c++;
									$respuesta=nota_refe_exec($row_alum_proc_notas_view32['alum_curs_para_mate_codi'],$peri_dist_codi,$conn);
								}
							}
						}
						function nota_refe_exec($alum_curs_para_mate_codi,$peri_dist_codi,$conn)
						{   $params21 = array($alum_curs_para_mate_codi,$peri_dist_codi);
							$sql21="{call nota_refe_exec(?,?)}";
							
							$notas_proc_view21 = sqlsrv_prepare($conn, $sql21, $params21);
							if( !$notas_proc_view21 )
							{   die( print_r( sqlsrv_errors(), true));
							return "KO-";
							}
							if( sqlsrv_execute( $notas_proc_view21 ) === false )
							{   die( print_r( sqlsrv_errors(), true));
							return 'KO-';
							}else{
								//$row_resp=sqlsrv_fetch_array($notas_proc_view21);
								//var_dump($row_resp);
								return $row_resp;
								
							}
							
							
						}
						?>
						<!-- InstanceEndEditable -->
						</div>
          
                        <!-- InstanceBeginEditable name="information" -->
						<div class="title">
                         <?php 	$param_alum_codi = "";
								if( isset( $alum_codi ) )
									$param_alum_codi = '&alum_codi='.$alum_codi;
								else
									$param_alum_codi = '';
								echo ' 	<div class="alert alert-success" style="width: 50%; align:center;">
											<h2><strong><span class="icon-exclamation icon"></span></strong> ¡Notas grabadas con &eacute;xito!</h2>
										<br>
										<h3><a href="cursos_paralelo_notas_mate_main_deta.php?peri_dist_codi='.$peri_dist_codi.'&curs_para_mate_codi='.$curs_para_mate_codi.$param_alum_codi.'">
												Haga clic aqu&iacute; para regresar.
											</a>
										</h3>
										</div>';
						 ?>
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
<script type="text/javascript" language="javascript">
function ejecutar_submit(frm){
	document.getElementById(frm).submit();
}
</script><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>