<?php 
	session_start();	 
	include ('../framework/dbconf.php');
 	include ('../framework/funciones.php'); 
  
	$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi']; 
	$params = array($curs_para_mate_prof_codi);
	$sql="{call nota_perm_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
 <table class=" table_striped ">
 <thead>
    <tr>
        <th width="17">#</th>
        <th width="54">Cod. Permiso</th>
        <th width="60">Unidad</th>
        <th width="58">Fecha Inicio</th>
        <th width="99">Fecha Terminacion</th>
        <th width="46">Estado</th>
        <th width="75">Fecha de Ingreso</th>
        <th width="73">Usuario Asigno</th>
        <th width="129">Opciones</th>
	</tr>
</thead>
<?php  
	while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) 
	{ 
		$cc +=1; 
?>
    <tr>
      	<td><?= $cc?></td>
      	<td align="center"><?= $row_curs_peri_view['nota_perm_codi']?></td>
    	<td><?= $row_curs_peri_view['peri_dist_padr'].'-'.$row_curs_peri_view['peri_dist_deta']?></td>
        <td><?=  date_format($row_curs_peri_view['nota_peri_fec_ini'], 'd/M/Y' ); ?></td>
        <td><?= date_format($row_curs_peri_view['nota_peri_fec_fin'], 'd/M/Y' ); ?></td>
        <td><?= $row_curs_peri_view['resu']?></td>
        <td><?= date_format($row_curs_peri_view['nota_peri_fec_in'], 'd/M/Y' ); ?></td>
        <td><?= $row_curs_peri_view['usua_codi']?></td>
        <td> 
        <div class="menu_options">
          <ul>
            <li>
            <? 
            	$url_impr="actas/notas_ingresadas_pdf.php?peri_dist_codi="
	            		.$row_curs_peri_view['peri_dist_codi']."&curs_para_mate_codi="
	            		.$row_curs_peri_view['curs_para_mate_codi']."&curs_para_mate_prof_codi="
	            		.$row_curs_peri_view['curs_para_mate_prof_codi'];
            
				if ($row_curs_peri_view['nota_peri_esta_resu']=='A') 
              	{ 
					$url="notas_deta_main.php?peri_dist_codi="
					.$row_curs_peri_view['peri_dist_codi']."&curs_para_mate_codi="
					.$row_curs_peri_view['curs_para_mate_codi']
					."&nota_perm_codi=".$row_curs_peri_view['nota_perm_codi']
					."&curs_para_mate_prof_codi=".$row_curs_peri_view['curs_para_mate_prof_codi'];
              ?>
              <a href="<?= $url; ?>" class="option"> 
                  <span class="icon-add icon"> </span>Ingresar Notas</a>
             <? } ?>
            </li>
            <li>
            	<a href="<?= $url_impr; ?>" class="option"> 
                  <span class="icon-print icon"> </span>Imprimir  Notas
             	</a>
            </li>
          </ul>
        </div>           
     </td>
  </tr>
 <?php  }   ?>
</table>