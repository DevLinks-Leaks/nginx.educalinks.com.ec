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
                include ('../framework/dbconf.php');
                session_start();

                if(isset($_GET['curs_para_mate_codi'])){
                    $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
                }
                
                if(isset($_GET['peri_dist_codi'])){
                    $peri_dist_codi=$_GET['peri_dist_codi'];
                }

                $PERI_CODI = $_SESSION['peri_codi'];

                $params = array($curs_para_mate_codi);
                $sql="{call curs_peri_mate_info(?)}";
                $curs_peri_mate_info = sqlsrv_query($conn, $sql, $params);
                $row_curs_peri_mate_info = sqlsrv_fetch_array($curs_peri_mate_info);	
            ?>
            <div class="title">
                <h3><span class="icon-books icon"></span> <?= $row_curs_peri_mate_info['curs_deta'];?> - <?= $row_curs_peri_mate_info['para_deta'];?> - <?= $row_curs_peri_mate_info['mate_deta'];?></h3>
            </div>        
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
						<script src="js/funciones_notas.js"></script>
                        <div  id="notas_view">
                            <?php include('cursos_paralelo_notas_valo_main_view.php') ?>
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

var myVar=setInterval(function () {myTimer()}, 5000);


</script>
<!-- InstanceEnd --></html>