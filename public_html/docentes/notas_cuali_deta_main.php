<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
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
          <?php 

			session_start();	 
			include ('../framework/dbconf.php');
					
			 
			$peri_dist_codi=$_GET['peri_dist_codi'];
			$curs_para_mate_codi =$_GET['curs_para_mate_codi'];
		
			$params = array($curs_para_mate_codi);
			$sql="{call curs_para_mate_info(?)}";
			$curs_para_mate_info = sqlsrv_query($conn, $sql, $params); 
			$row_curs_para_mate_info= sqlsrv_fetch_array($curs_para_mate_info);		 
			
		?>
          
          <div class="title"><h3><span class="icon-briefcase icon"></span>Notas Ingreso / Permiso Cod. <?= $_GET['nota_perm_codi'];?></h3></div>
		   <div class="options">

              <ul>

                  
                 <li>
                  <h4> Curso: <?= $row_curs_para_mate_info['mate_deta'];?>&nbsp;&nbsp;&nbsp;<br>
                    Curso: <?= $row_curs_para_mate_info['curs_deta'];?>  Paralelo:  <?= $row_curs_para_mate_info['para_deta'];?>&nbsp;&nbsp;&nbsp;</h4>
                   
                </li>
				<li>
                  <a class="button_text"  id="bt_curs_print"  href="notas_deta_acta.php?peri_dist_codi=<?= $peri_dist_codi?>&curs_para_mate_codi=<?=$curs_para_mate_codi?>&nota_perm_codi=0" >
                    <span class="icon-print"></span> Imprimir
                  </a>
                </li>
              </ul>
            </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script src="js/notas_proyecto.js"></script>
                       
                    	<div  id="notas_view">
							 <?php 	include('notas_cuali_deta_view.php') ?>
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