<?php 
    session_start();	 
    include ('../framework/dbconf.php');
    //$peri_dist_codi= $_GET['peri_dist_codi'];
  
    $params = array($peri_dist_codi);
    $sql="{call cali_comp_valo_view(?)}";
    $cali_comp_valo_view = sqlsrv_query($conn, $sql, $params);  
    $cc = 0;
?>
<table class="table_striped" >
    <thead>
        <tr>
          <th>#</th>               
          <th> Valor</th>
          <th></th>
        </tr>
    </thead>
    <tbody>
        <?php  while ($row_cali_comp_valo_view = sqlsrv_fetch_array($cali_comp_valo_view)) { $cc +=1; ?> 
        <tr onclick="">
            <td class="center"><?= $cc; ?></td>
            <td ><?php echo $row_cali_comp_valo_view["valo_deta"]; ?></td>
            <td>               		
                <div class="menu_options">  
                  <ul>
                    <li>
                        <a class="option" onclick="window.location='cursos_paralelo_notas_comp_main.php?peri_dist_codi=<?= $peri_dist_codi; ?>&valo_codi=<?= $row_cali_comp_valo_view["valo_codi"]; ?>&curs_para_codi=<?= $_GET['curs_para_codi'];?>&nota_perm_codi=<?= $_GET['nota_perm_codi'];?>'"> 
                        <span class="icon-stats icon"> </span>Evaluar
                      </a>
                    </li>
                  </ul>
                </div>           
           </td>
        </tr>
        <?php }?>
    </tbody>
</table>