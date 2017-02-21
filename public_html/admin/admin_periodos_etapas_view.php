<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	//include ('script_cursos.php'); 
 	 
	if (isset($_GET['peri_codi']))
	 	$peri_codi= $_GET['peri_codi'];
		
	if (isset($_POST['peri_codi']))
	 	$peri_codi= $_POST['peri_codi'];
	
	$params = array($peri_codi);
	$sql="{call peri_acti_view_all(?)}";
	$peri_acti_view_all= sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<table class=" table_striped " >
        	<thead>
            <tr>
                  <th>#  </th>
                  <th>Etapa</th>            
                  <th>Unidad</th>                  
                  <th>Inicio</th>
                  <th>Fin</th>
                  <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php  while ($row_peri_acti_view_all = sqlsrv_fetch_array($peri_acti_view_all)) { $cc +=1; ?> 
                <tr onclick="">
                      <td class="center"><?= $cc; ?></td>
                      <td ><?= $row_peri_acti_view_all ['peri_etap_deta'];?> <? if ($row_peri_acti_view_all ['peri_etap_acti']=='A') echo '(Activo)'; ?></td>
                      <td ><?= $row_peri_acti_view_all ['peri_dist_deta'];?></td>
                      <td> <?=  date_format( $row_peri_acti_view_all["peri_fech_ini"], 'd/M/Y  h:m:s' ); ?> </td> 
                      <td ><?=  date_format( $row_peri_acti_view_all["peri_fech_fin"], 'd/M/Y  h:m:s' ); ?></td>
                      <td>
                            <div class="menu_options">
                              <ul>
                                <li>
                                  <a 
                                  	class="option" 
                                    onclick="peri_acti_del(<?= $row_peri_acti_view_all ['peri_acti_codi'];?>, <?= $peri_codi?>)"> 
                                    <span class="icon-close icon"> </span>   
                                  </a>
                            
                                </li>
                              </ul>
                            </div>              
                        </td>
                  </tr>
            <?php }?>
  
            </tbody>
          </table>
          
          

                        