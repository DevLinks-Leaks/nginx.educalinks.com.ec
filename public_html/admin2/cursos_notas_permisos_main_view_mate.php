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
<table width="100%" class=" table_striped " >
        	<thead>
             
              <th width="3%">#               
              <th width="42%"> Materias/Profesores</td>
              <th width="5%" align="center" valign="middle">A</td>
              <th width="5%" align="center" valign="middle">P</td>
              <th width="5%" align="center" valign="middle">T
              <th width="5%" align="center" valign="middle">I</td>           
              <th width="30%">  </td>   
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
              <td align="center" valign="middle"><strong><?= $row_nota_perm_curs_para_view["perm_acti"]; ?></strong></td>
              
			  
			
                    <td align="center" valign="middle"><strong><?= $row_nota_perm_curs_para_view["perm_pend"]; ?>
                    </strong>
              </td>
                    <td align="center" valign="middle"><strong>
                      <?= $row_nota_perm_curs_para_view["perm_term"]; ?>
                    </strong></td>
                    <td align="center" valign="middle"><strong>
                      <?= $row_nota_perm_curs_para_view["perm_ingr"]; ?>
                    </strong></td>
              <td align="center" valign="middle">
                <div class="menu_options">
                          <ul>
                        
                            </li>
                            <li>
                              
                              <a href="cursos_notas_permisos_main_deta.php?curs_para_mate_codi=<?= $row_nota_perm_curs_para_view["curs_para_mate_codi"]; ?>&curs_para_mate_prof_codi=<?= $row_nota_perm_curs_para_view["curs_para_mate_prof_codi"]; ?>"  class="option" > 
                                  <span class="icon-checkbox-checked"> </span> Ver Detalle
                              </a>
                        
                            </li>
                          </ul>
                        </div>
              
              </td>
              </tr>
            <?php }?>
  
            </tbody>
          </table>
