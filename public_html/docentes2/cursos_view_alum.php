 
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	 
	 if(isset($_POST['curs_para_codi'])) $curs_para_codi=$_POST['curs_para_codi'];

	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc2 = 0;
	
?>

<table >
      

            <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc2 +=1; ?> 
            <tr>
              <td>
              
              <table  >
                <tr>    
                <td ><?= $cc2; ?>. </td> 
				<?php
          	$file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
	
			if (file_exists($file_exi)) {
				$pp=$file_exi;
			} else {
				$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
			}
		  ?>
                    <td>
         
                    
                    <img src="<?php echo $pp; ?>" width="58" height="59"  style=" text-align:right; border:none; width:30px; height:30px;"/>
                    </td>
                  
                    <td ><?= $row_alum_curs_para_view["alum_codi"]; ?> - <?php echo $row_alum_curs_para_view["alum_nomb"]; ?></td>
                  </tr>
              </table>
              </td>
              </tr>
            <?php }?>
          </table>