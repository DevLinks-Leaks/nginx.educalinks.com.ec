<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>  
<div class="main_lista">
	<?php 
	$params = array();
	$sql	= "{call bloq_opci_all()}";
	$stmt 	= sqlsrv_query($conn, $sql, $params);
	if ($stmt === false)
	{	die(print_r(sqlsrv_errors(),true));
	}
	$cc = 0;
	?>
    <table class="table_striped" id="bloq_table">
	<thead>
		<tr>
			<th width="40%">Motivo</th>
			<th width="40%">Opción bloqueada</th>
			<th width="20%">Opciones</th>
		</tr>
	</thead>
      <tbody>
     <?php  while ($row = sqlsrv_fetch_array($stmt)){ $cc +=1;?>
      <tr>
        <td><?= $row["moti_bloq_deta"]; ?></td>
		<td><?= $row["opci_deta"]; ?></td>
        <td>
        <div class="menu_options">
			<ul>
				<li>
					<a class="option" onclick="load_ajax_bloq('bloq_main','script_bloq.php','del',<?= $row["bloq_opci_codi"];?>);">
						<span class="icon-remove icon"></span> Quitar
					</a>
				</li>
			</ul>
        </div>
        </td>
      </tr>
     <?php  }?>
      </tbody>
      <tfoot>
      	<tr class="pager_table">
            <td colspan="1">
            <span class="icon-users icon"></span> Total de Opciones Bloqueadas ( <?= $cc;?> )
            </td>
            <td colspan="2" class="right"><div class="paging"></div></td>
        </tr>
      </tfoot>
    </table>
</div>