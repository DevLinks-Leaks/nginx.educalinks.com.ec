<div class="panel panel-default">
    <div class="panel-body">
    	<table class="table table-responsive table-hover" id="table_visitas" data-page-length='10'>
			<thead>
				<tr>
					<th style="text-align: center;">Motivo</th>
					<th style="text-align: center;">Fecha - Hora</th>
					<th style="text-align: center;">Tratamiento</th>
					<th style="text-align: center;">Opciones</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					include ('../framework/dbconf.php');        
					$sql="{call med_alum_atenciones(?)}";
					$params_opc= array($_SESSION['alum_codi']);
					$stmt = sqlsrv_query($conn, $sql,$params_opc);
			
					if( $stmt === false )
					{
						echo 'Error in executing statement .\n';
						die( print_r( sqlsrv_errors(), true));
					}
					
					while($atencion_result= sqlsrv_fetch_array($stmt))
					{
						echo "<tr>";
						echo '<td class="text-center">'.$atencion_result['enfe_descripcion'].'</td>';
						echo '<td class="text-center">'.date_format($atencion_result['aten_fechaCreacion'],"d/m/Y H:i:s").'</td>';
						echo '<td >
								<ul>';
						$sql2="{call med_atenciones_detalle_info(?)}";
						$params_opc2= array($atencion_result['aten_codigo']);
						$stmt2 = sqlsrv_query($conn, $sql2,$params_opc2);
						while($detalle_result= sqlsrv_fetch_array($stmt2)){
							echo "<li> <ul class='list-inline'> 
											<li><b>Medicamento: </b>".$detalle_result['med_descripcion']."</li>
									 		<li><b>Cant: </b>".$detalle_result['aten_deta_med_cantidad']."</li>
									 	</ul>
								</li>";
						}
						echo '</ul></td>';
						echo '<td class="text-center"><a class="btn btn-success" href="../medic/comprobante_atencion/'.$atencion_result['aten_codigo'].'" target="_blank"><span class="fa fa-download" aria-hidden="true"></span> Comprobante Atención</a></td>';
						echo "</tr>";
					}
					
				?>
			</tbody>
		</table>
    </div>
</div>

	