<?php
	session_start();	 
	include ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
		
	$usuarios = array();
	$usuarios = json_decode( $_POST['usuarios'], true );
	
	$xml_usuario = '';
	$xml_usuario.=  '<Usuarios>';
	foreach ( $usuarios as $usuario )
	{	$xml_usuario.=   '<Usuario codigo="' . $usuario . '"/>';
	}
	$xml_usuario.=   " </Usuarios>";
	
	$acciones = array();
	$acciones = json_decode( $_POST['acciones'], true );
	
	$xml_acciones = '';
	$xml_acciones.=  '<Acciones>';
	foreach ( $acciones as $accion )
	{	$xml_acciones.=   '<Accion codigo="' . $accion . '"/>';
	}
	$xml_acciones.=   " </Acciones>";
?>	
	<table id='tbl_auditoria_resultados' name='tbl_auditoria_resultados' class="table table-striped">
		<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
			<tr>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Usuario Tipo</th>
				<th>Usuario</th>
				<th>Acción</th>
				<th>Detalle</th>
			</tr>
		</thead>
	    <tbody>
            <?php
				$params = array( $xml_usuario, $xml_acciones, $_POST['audi_fec_ini'], $_POST['audi_fec_fin'] );
				$sql="{call audi_view(?,?,?,?)}";
				$res = sqlsrv_query( $conn, $sql, $params ); 
				while ( $row = sqlsrv_fetch_array( $res ) )
				{	$tabla.='
						<tr>
							<td class="left">'.   $row['audi_fecha'].'</td>
							<td class="center">'. $row['audi_hora'].'</td>
							<td class="center">'. $row['usua_tipo_deta'].'</td>
							<td class="center">'. $row['usua_codi'].'</td>
							<td class="center">'. $row['audi_tipo_deta'].'</td>
							<td class="left">'.   $row['audi_deta'].'</td>
						</tr>';
				}
				echo $tabla;
            ?>
	    </tbody>
	</table>