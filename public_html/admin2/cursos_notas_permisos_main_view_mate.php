<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
 
 
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}
	
	
	$params = array($curs_para_codi);
	$sql="{call nota_perm_curs_para_view(?)}";
	$nota_perm_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<table width="100%" class="table table-striped table-bordered">
        	<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
              <th width="3%">#               
              <th width="57%"> Materias/Profesores</td>
              <th width="5%" style='text-align:center;' valign="middle">A</td>
              <th width="5%" style='text-align:center;' valign="middle">P</td>
              <th width="5%" style='text-align:center;' valign="middle">T
              <th width="5%" style='text-align:center;' valign="middle">I</td>           
              <th width="15%" style='text-align:center;'>Ver detalle</td>   
            </thead>
            <tbody>
            <?php  while ($row_nota_perm_curs_para_view = sqlsrv_fetch_array($nota_perm_curs_para_view)) { $cc +=1; ?>   
			<?php
					$file_exi=$_SESSION['ruta_foto_docente'] . $row_nota_perm_curs_para_view["prof_codi"] . '.jpg';
			
					if (file_exists($file_exi)) {
						$pp=$file_exi;
					} else {
						$pp=$_SESSION['ruta_foto_docente'].'0.jpg';
					}
			  ?>
            <tr onclick="">
              <td><?= $cc; ?>&nbsp;</td>
              <td align="left"><img src="<?php echo $pp; ?>" width="58" height="59"  style="   border:none; width:25px; height:25px; float:left;"/> <h6><strong><?php echo $row_nota_perm_curs_para_view["mate_deta"]; ?> </strong>  Prof.: <strong><?php echo $row_nota_perm_curs_para_view["prof_nomb"]; ?>                </strong>             (<strong>
              <?= $row_nota_perm_curs_para_view["curs_para_mate_codi"]; ?>
              </strong>)   <h6></td>
              <td style='text-align:center;' valign="middle"><strong><?= $row_nota_perm_curs_para_view["perm_acti"]; ?></strong></td>
              
			  
			
                    <td style='text-align:center;' valign="middle"><strong><?= $row_nota_perm_curs_para_view["perm_pend"]; ?>
                    </strong>
              </td>
                    <td style='text-align:center;' valign="middle"><strong>
                      <?= $row_nota_perm_curs_para_view["perm_term"]; ?>
                    </strong></td>
                    <td style='text-align:center;' valign="middle"><strong>
                      <?= $row_nota_perm_curs_para_view["perm_ingr"]; ?>
                    </strong></td>
              <td style='text-align:center;' valign="middle">
				  <a href="cursos_notas_permisos_main_deta.php?curs_para_mate_codi=<?= $row_nota_perm_curs_para_view["curs_para_mate_codi"]; ?>&curs_para_mate_prof_codi=<?= $row_nota_perm_curs_para_view["curs_para_mate_prof_codi"]; ?>" class="btn btn-default"
					title='Ver detalle' onmouseover='$(this).tooltip("show");' data-placement='left'>
					  <span style='color:#3c8dbc;' class="fa fa-check-square-o"> </span>
				  </a>
              </td>
              </tr>
            <?php }?>
  
            </tbody>
          </table>
