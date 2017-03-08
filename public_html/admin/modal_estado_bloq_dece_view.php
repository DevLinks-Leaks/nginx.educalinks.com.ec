<?php
	include ('../framework/dbconf.php');

	$sql		= "{call alum_bloq_opc_all(?)}";
	$options	= array("scrollable"=>"buffered");
	$params		= array($alum_codi);
	$alum_bloq_opc_all	 	= sqlsrv_query( $conn, $sql, $params, $options);

	if (sqlsrv_has_rows($alum_bloq_opc_all))
	{
?>
<li class="list-group-item list-group-item-info">

		<strong>¡Advertencia de Bloqueos!</strong>
		<ul class="">
			
			<?php	while ($row_alum_bloq_opc_all = sqlsrv_fetch_array($alum_bloq_opc_all)){ ?>
				<li class="">Bloqueo con motivo <b>"<?=$row_alum_bloq_opc_all["moti_bloq_deta"];?>"</b> de tipo <b>"<?=$row_alum_bloq_opc_all["opci_deta"];?>"</b> del período <b>"<?=$row_alum_bloq_opc_all["peri_deta"];?>"</b> </li>
			<? } ?>
		</ul>

</li>

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