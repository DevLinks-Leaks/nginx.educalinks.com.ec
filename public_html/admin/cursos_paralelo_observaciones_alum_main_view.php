<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
			
	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}
	
	$peri_codi= $_GET['peri_codi'];
	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	/*Libreta por lotes*/
		if ($_GET['nive_codi']==4 or $_GET['nive_codi']==5)
		{
			/*Archivo.php para libretas de inicial*/
			$url_libreta="cursos_paralelo_notas_alum_observaciones_inicial_";
		}
		else
		{
			/*Archivo.php para las demás libretas*/
			$url_libreta="cursos_paralelo_notas_alum_observaciones_";
		}
?>

<?php echo $row_alum_curs_para_view["alum_nomb"]; ?>
<table  class="table_striped">
    <thead>
        <tr>
          <th align="left" colspan="2">
                <? 	
                    $params = array($curs_para_codi);
                    $sql="{call peri_dist_peri_view_Lb_NEW(?)}";
                    $peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);  
                ?>
                <select  id="peri_dist_codi" >
                  <? 
                  while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
                  { 
                  ?>
                  <option value="<?= $row_peri_dist_peri_view['peri_dist_codi'];?>">
                    <?= (($row_peri_dist_peri_view['padre']=='')?
                        $row_peri_dist_peri_view['padre']:
                        $row_peri_dist_peri_view['padre'].' - ').
                        $row_peri_dist_peri_view['peri_dist_deta'];
                    ?>
                  </option>
                  <?php
                  } 
                  ?>
                </select> 
          </th>
        </tr>
    </thead>
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
                    class="icon-pencil btn btn-primary"
                    onClick="window.location='<?= $url_libreta.$_SESSION['directorio'] ?>.php?peri_dist_codi=' + selectvalue(document.getElementById('peri_dist_codi')) +'&alum_codi=<?= $row_alum_curs_para_view["alum_codi"]; ?>&curs_para_codi=<?= $curs_para_codi; ?>'">
                    Editar
                </button>
                </li>
              </ul>
            </div>
          </td>
          </tr>
        <?php }?>   
    </tbody>
</table>