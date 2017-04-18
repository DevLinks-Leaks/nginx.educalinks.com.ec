<?php
	include ('../framework/dbconf.php');

	$sql		= "{call alum_bloq_opc_by_peri(?,?)}";
	$options	= array("scrollable"=>"buffered");
	$params		= array($alum_codi,$_SESSION['peri_codi']);
	$alum_bloq_opc_all	 	= sqlsrv_query( $conn, $sql, $params, $options);

	if (sqlsrv_has_rows($alum_bloq_opc_all))
	{	$bloqueo_hard = 0;
		while ($row_alum_bloq_opc_all = sqlsrv_fetch_array($alum_bloq_opc_all))
		{	if ( $row_alum_bloq_opc_all["opci_codi"] != 3 )
			{?>
			<li class="list-group-item list-group-item-info">
				<strong>¡Advertencia de Bloqueos!</strong>
				<ul class="">
				<li class="">Bloqueo con motivo <b>"<?=$row_alum_bloq_opc_all["moti_bloq_deta"];?>"</b> de tipo <b>"<?=$row_alum_bloq_opc_all["opci_deta"];?>"</b> del período <b>"<?=$row_alum_bloq_opc_all["peri_deta"];?>"</b> </li>
				</ul>
			</li>
	<? 		}
			if ( $row_alum_bloq_opc_all["opci_codi"] == 3 )
			{	$bloqueo_hard++;?>
			<li class="list-group-item list-group-item-danger">
				<strong>¡Bloqueo!</strong>
				<ul class="">
				<li class="">Bloqueo con motivo <b>"<?=$row_alum_bloq_opc_all["moti_bloq_deta"];?>"</b> de tipo <b>"<?=$row_alum_bloq_opc_all["opci_deta"];?>"</b> del período <b>"<?=$row_alum_bloq_opc_all["peri_deta"];?>"</b> </li>
				</ul>
			</li>
	<? 		}
		} ?>
		

<!-- SEGUNDA FORMA DE VISTA -->
<!-- <table class='table_striped' id='tbl_alum_bloq'>
	<thead>
		<tr>
			<th>Motivo</th>
			<th>Opción Bloqueada</th>
			<th>Periodo</th>
		</tr>
	</thead>
	<tbody>
<?php	while ($row_alum_bloq_opc_all = sqlsrv_fetch_array($alum_bloq_opc_all)){ ?>
		<tr>
			<td><?=$row_alum_bloq_opc_all["moti_bloq_deta"];?></td>
			<td><?=$row_alum_bloq_opc_all["opci_deta"];?></td>
			<td><?=$row_alum_bloq_opc_all["peri_deta"];?></td>
		</tr>
<? } ?>
	</tbody>
</table>-->
<? } ?>
<input type="hidden" id="bloqueo_hard" name="bloqueo_hard" value="<?= $bloqueo_hard; ?>" />