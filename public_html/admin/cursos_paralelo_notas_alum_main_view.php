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
	$sql="{call alum_curs_para_view_ret(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	
	/*Libreta por lotes*/
	$nive_codi = curs_para_nive_cons($curs_para_codi);
	
	if ($_SESSION["directorio"]=="liceopanamericano" or $_SESSION["directorio"]=="liceopanamericanosur" or $_SESSION["directorio"]=="moderna" or $_SESSION["directorio"]=="arcoiris" or $_SESSION["directorio"]=="ecobab" or $_SESSION["directorio"]=="ecobabvesp")
	{	if ($nive_codi==4 or $nive_codi==5)
		{	/*Archivo.php para libretas de inicial*/
			$url_libreta_general="lib_ini_all.php";
		}
		else
		{	/*Archivo.php para las demás libretas que no son de inicial*/
			$url_libreta_general="lib_all.php";
		}
	}
	else
	{	$url_libreta_general="lib_all.php";
	}
?>


<table  class="table_striped">
        <thead>
            <tr>
              <th  align="left">
					<? 	$params = array($curs_para_codi);
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
              <th>
              <div class="options">
              	<button 
                    class="btn btn-primary"
                    onClick="window.open('libretas/<?= $_SESSION['directorio']; ?>/<?= $_SESSION['peri_codi']; ?>/<?= $url_libreta_general?>?peri_dist_codi=' + selectvalue(document.getElementById('peri_dist_codi')) +'&curs_para_codi=<?= $_GET["curs_para_codi"]; ?>','_blank')"
                    style="margin: 10px 0px;">
                    <span class='icon-print'></span> Imprimir Todo
                </button>
                </div>
              </th>
            </tr>
        </thead>
        <tbody>
            <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?> 
            <tr>
              <td width="68%" height="26">

                <table class="table_basic" >
                  <tr>
                    <?php
                    $file_exi = $_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';

                    if (file_exists($file_exi)) {
                      $pp=$file_exi;
                    } else {
                      $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
                    }
					/*Libreta por lotes*/
					$nive_codi = curs_para_nive_cons($curs_para_codi);
					if ($nive_codi==4 or $nive_codi==5)
					{	/*Archivo.php para libretas de inicial*/
						$url_libreta_individual="lib_ini_one.php";
					}
					else
					{	/*Archivo.php para las demás libretas de inicial*/
						$url_libreta_individual="lib_one.php";
					}
                    ?>
                    <td width="30" class="center"><?php echo $cc; ?></td>
                    <td width="40" class="center" ><img src="<?php echo $pp; ?>"   style=" text-align:right; border:none; width:40px; height:40px;"/></td>
                    <td width="404" class="left" <?php if($row_alum_curs_para_view["estado_alumno"]=='R'){?> style="color:red;" <?php } ?> >
                    <?= $row_alum_curs_para_view["alum_codi"]; ?>
                      - <?= $row_alum_curs_para_view["alum_apel"]." ".$row_alum_curs_para_view["alum_nomb"]; ?></td>
                  </tr>
                </table>

              </td>
              <td width="10%"> 
                <div class="menu_options">
                  <ul>
                    <li>
                      <a  
                        class="option" 
                        onclick="window.open('libretas/<?= $_SESSION['directorio']; ?>/<?= $_SESSION['peri_codi']; ?>/<?= $url_libreta_individual; ?>?peri_dist_codi=' + selectvalue(document.getElementById('peri_dist_codi')) +'&alum_codi=<?= $row_alum_curs_para_view["alum_codi"]; ?>&curs_para_codi=<?= $curs_para_codi; ?>','_blank')">
                          <span class="icon-file icon"></span> 
                          Ver Notas
                      </a>
                    </li>
                  </ul>
                </div>    	 
              </td>
              </tr>
            <?php }?>
    </tbody>
</table>