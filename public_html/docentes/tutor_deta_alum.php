<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=7;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
          <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
            <div class="title">
                <h3>
                    <span class="icon-users icon"></span>
                    Alumnos
                </h3>
            </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
            <div id="alum_main" >
				<?php
					$curs_para_codi = $_GET['curs_para_codi'];
					$peri_dist_codi = $_GET['peri_dist_codi'];
					
					$nive_codi = curs_para_nive_cons($curs_para_codi);
					
					if ($nive_codi==4 or $nive_codi==5)
					{
						/*Archivo.php para libretas de inicial*/
						$url_libreta_individual="nota_obse_inicial";
					}
					else
					{
						/*Archivo.php para las demás libretas de inicial*/
						$url_libreta_individual="nota_obse";
					}
					
                    $sql = "{call alum_curs_para_view (?)}";
                    $params = array ($curs_para_codi);
                    $stmt = sqlsrv_query($conn, $sql, $params);
				?>
                <table class="table_striped" style="margin-bottom: 40px;">
                	<thead>
                    	<th width="5%" class="center">#</th>
                        <th width="75%">Alumnos</th>
                        <th width="20%" class="center">Opción</th>
                    </thead>
                    <tbody>
                    <?
					$cc=0;
					while ($row_alum = sqlsrv_fetch_array($stmt))
					{
						$cc++;
					?>
                    	<tr>
                        	<td class="center">
								<?= $cc ?>
							</td>
                        	<td>
								<?= $row_alum['alum_apel'].' '.$row_alum['alum_nomb'] ?>
							</td>
                            <td class="center">
                            	<button 
                                	class="icon-pencil btn btn-primary"
                                    onClick="window.location='<?= $url_libreta_individual?>.php?curs_para_codi=<?= $curs_para_codi?>&peri_dist_codi=<?= $peri_dist_codi?>&alum_codi=<?= $row_alum['alum_codi']?>'">
                                	Editar
								</button>
                            </td>
                        </tr>
                    <?
					}
					?>
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
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>