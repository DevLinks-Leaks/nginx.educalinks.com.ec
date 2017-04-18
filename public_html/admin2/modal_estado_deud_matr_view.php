<?php
	include ('../framework/dbconf.php');

	$sql		= "{call str_common_deudasMatricula_cons(?)}";
	$options	= array("scrollable"=>"buffered");
	$params		= array($_POST['alum_codi']);
	$deudas	 	= sqlsrv_query( $conn, $sql, $params, $options);

	$total_deuda = 0;

	if (sqlsrv_has_rows($deudas))
	{
		$row = sqlsrv_fetch_array($deudas);
		if( $row["totalDeuda"] != '0.00' )
			{ $total_deuda=$row["totalDeuda"];
?>	
	<!-- <div class='alert alert-warning'> -->
	<li class="list-group-item list-group-item-danger">
			<strong>¡Bloqueo por Deuda pendiente!</strong>
			<center>No se puede matricular. Tiene una deuda pendiente de $<?= $row["totalDeuda"]; ?>.<br>
		  	<span class='icon icon-file'></span>&nbsp;
		  	<a href='../modulos/finan/clientes/controller.php?event=print_report&codigoAlumno=<?= $alum_codi;?>&codigoPeriodo=&fechaInicio=&fechaFin=' target='_blank'>Ver estado de cuenta</a></center>

	</li>
  	<!-- </div> -->
		<?}	?>
	<!-- 	else {
		<center>Alumno no tiene deudas financieras pendientes.</center> -->
<? } ?>
<input type="hidden" id="total_deuda" value="<?= $total_deuda; ?>" />