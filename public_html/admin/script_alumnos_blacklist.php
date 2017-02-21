<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'add':

	$params = array($_POST['alum_codi']);
	$sql="{call alum_info_blacklist(?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params); 

	$row = sqlsrv_fetch_array($alum_busq);
	
	if($row['repr_cedula']){
		$url = $_SESSION['web_service_url'].'/api/crearbl?api_token='.$_SESSION['api_token'];
		$data = array('data' => array(	'bl_codi'=>'',
										'bl_alum_nomb' => $row['alum_nomb'],
										'bl_alum_apel' => $row['alum_apel'],
										'bl_repr_cedu' => $row['repr_cedula'],
										'bl_moti_bloq_deta' => $_POST['bl_moti_bloq_deta'],
										'bl_usua_bloq' => $_SESSION['usua_codi'],
										'bl_alum_codi' => $row['alum_codi']
									)
					);

		$options = array(
			'http' => array(
				'method'  => 'POST',
				'content' => json_encode($data) ,
				'header'=>  "Content-Type: application/json"
				)
			);

		$context  = stream_context_create( $options );
		$result = file_get_contents( $url, false, $context );

	}else
	{
		$result= json_encode(array ('state'=>'error',
						'result'=>'No se puede agregar a blacklist alumno sin representante asociado.' ));
	}

	echo $result;
	break;
	case 'upd':
	$url = $_SESSION['web_service_url'].'/api/crearbl?api_token='.$_SESSION['api_token'];
	$data = array('data' => array('bl_codi'=>$_POST['bl_codi'],'bl_moti_bloq_deta' => $_POST['bl_moti_bloq_deta']));
	$options = array(
		'http' => array(
			'method'  => 'POST',
			'content' => json_encode($data) ,
			'header'=>  "Content-Type: application/json"
			)
		);

	$context  = stream_context_create( $options );
	$result = file_get_contents( $url, false, $context );
	echo $result;
	break;
	case 'del':
	$url = $_SESSION['web_service_url'].'/api/inactivarbl/'.$_POST['bl_codi'].'?api_token='.$_SESSION['api_token'];
	$result = file_get_contents( $url );
	echo $result;

	break;

	case 'edit_view':
	$response = '<table width="100%" style="margin-bottom:20px">
	<tr>
		<td width="30%">
			Motivo Bloqueo: 
		</td>
		<td style="margin-top:5px">
			<select id="cmb_motivos" style="width: 75%">';

				$sql	= "{call moti_bloq_all()}";
				$params	= array();
				$stmt	= sqlsrv_query($conn,$sql,$params);
				if ($stmt === false)
					{	die(print_r(sqlsrv_errors(),true));
					}
					if($_POST['bl_moti_bloq_deta']==''){
						$response .= "<option value=''>Selecciones motivo... </option>";
					}
					while ($row = sqlsrv_fetch_array($stmt))
					{	
						if($row["moti_bloq_deta"]==$_POST['bl_moti_bloq_deta'])
							$response .= "<option value='".$row["moti_bloq_deta"]."' selected>".$row["moti_bloq_deta"]."</option>";
						else
							$response .= "<option value='".$row["moti_bloq_deta"]."'>".$row["moti_bloq_deta"]."</option>";
					}
					$response .= '</select>
				</td>
			</tr>
		</table>
		<input type="hidden" id="bl_codi" name="bl_codi" value="'.$_POST['bl_codi'].'">';
		echo $response;
		break;
	case 'edit_view_new':

	$url = $_SESSION['web_service_url'].'/api/mostrarblalum/'.$_POST['bl_alum_codi'].'?api_token='.$_SESSION['api_token'];
	$result = file_get_contents( $url );
	$result = json_decode($result,true);

	if($result['state']=='success'){ //no es nulo - esta en blacklist
		$result=$result['result'];
		$bl_codi=$result['bl_codi'];
		$select = '<select id="cmb_motivos_bl" style="width: 75%">';
		
		$sql	= "{call moti_bloq_all()}";
		$params	= array();
		$stmt	= sqlsrv_query($conn,$sql,$params);
		if ($stmt === false)
		{	die(print_r(sqlsrv_errors(),true));
		}
		while ($row = sqlsrv_fetch_array($stmt))
		{	
			if($row["moti_bloq_deta"]==$result['bl_moti_bloq_deta'])
				$select .= "<option value='".$row["moti_bloq_deta"]."' selected>".$row["moti_bloq_deta"]."</option>";
			else
				$select .= "<option value='".$row["moti_bloq_deta"]."'>".$row["moti_bloq_deta"]."</option>";
		}
		$select .= '</select>';

		$boton = '<? if (permiso_activo(527)){ ?>
					<button id="btn_blacklist_save" type="button" class="btn btn-success" data-loading-text="Editando..." onclick="load_ajax_edit_alum_bl(\'blacklist_main\',\'script_alumnos_blacklist.php\',\'opc=upd&bl_codi=\'+document.getElementById(\'bl_codi\').value+\'&bl_moti_bloq_deta=\'+document.getElementById(\'cmb_motivos_bl\').options[document.getElementById(\'cmb_motivos_bl\').selectedIndex].value,false);">Editar</button>
				<?}?>';

		$hidden = '<input type="hidden" id="bl_codi" name="bl_codi" value="'.$result['bl_codi'].'">';

	}else{ //es nulo
		$alum_codi=$_POST['bl_alum_codi'];
		
		$select = '<select id="cmb_motivos_bl" style="width: 75%">';
		
		$sql	= "{call moti_bloq_all()}";
		$params	= array();
		$stmt	= sqlsrv_query($conn,$sql,$params);
		if ($stmt === false)
		{	die(print_r(sqlsrv_errors(),true));
		}
		$select .= "<option value=''>Selecciones motivo... </option>";
		while ($row = sqlsrv_fetch_array($stmt))
		{	
			$select .= "<option value='".$row["moti_bloq_deta"]."'>".$row["moti_bloq_deta"]."</option>";
		}
		$select .= '</select>';

		$boton = '<? if (permiso_activo(526)){ ?>
					<button id="btn_blacklist_add" type="button" class="btn btn-success" data-loading-text="Agregando..." onclick="load_ajax_add_alum_bl(\'blacklist_main\',\'script_alumnos_blacklist.php\',\'opc=add&alum_codi=\'+document.getElementById(\'alum_codi_bl\').value+\'&bl_moti_bloq_deta=\'+document.getElementById(\'cmb_motivos_bl\').options[document.getElementById(\'cmb_motivos_bl\').selectedIndex].value);">Agregar</button>
				<?}?>';

		$hidden = '<input type="hidden" id="alum_codi_bl" name="alum_codi_bl" value="'.$alum_codi.'">';
	}

	$response = '<div class="modal-header">
					<button 
						type="button" 
						class="close" 
						data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Blacklist</h4>
				</div>
				<div  class="modal-body">
					<table width="100%" style="margin-bottom:20px">
						<tr>
							<td width="30%">
								Motivo Bloqueo: 
							</td>
							<td style="margin-top:5px">'
								.$select.
							'</td>
						</tr>
					</table>'
					.$hidden.
				'</div>
				<div class="modal-footer">'
					.$boton.
					'<button 
						type="button" 
						class="btn btn-default" 
						data-dismiss="modal">
							Cerrar
					</button>
				</div>';
			echo $response;
		break;
	case 'alert_blacklist':
		$params = array($_POST['alum_codi']);
		$sql="{call alum_info_blacklist(?)}";
		$alum_busq = sqlsrv_query($conn, $sql, $params); 

		$row = sqlsrv_fetch_array($alum_busq);

		$metodo_busqueda = (($_SESSION['certus_blacklist'])=='1')?'buscarbl':'buscarbllocal';
		$url = $_SESSION['web_service_url'].'/api/'.$metodo_busqueda.'?api_token='.$_SESSION['api_token'];
		$data = array('data' => array('alum_apel'=>$row['alum_apel'],
										'alum_nomb' => $row['alum_nomb'],
										'repr_cedu' => $row['repr_cedu']));
		$options = array(
			'http' => array(
				'method'  => 'POST',
				'content' => json_encode($data) ,
				'header'=>  "Content-Type: application/json"
				)
			);

		$context  = stream_context_create( $options );
		$result = file_get_contents( $url, false, $context );
		$result = json_decode($result,true);
		//echo var_dump($result);
		if($result['state']=='success'){ //no es nulo - esta en blacklist
			// Por temas visuales solo se muestra el primero de todos los resultados.
			$result = $result['result'];
			echo '<div class="alert alert-warning">
					  <strong>¡Advertencia de Blacklist!</strong> <small>( <b>'.count($result).'</b> alumno(s) encontrados en Blacklist. )</small>'.
					  '<center>El alumno(a) con apellido: <b>'.$result[0]['bl_alum_apel'].'</b> ,nombre: <b>'.$result[0]['bl_alum_nomb'].'</b>  y representante con cédula <b>'.$result[0]['bl_repr_cedu'].'</b><br>
					  fue encontrado debido al motivo: <b>'.$result[0]['bl_moti_bloq_deta'].'</b> por la institución "<b>'.$result[0]['bl_clie_nomb'].'</b>" en la fecha <b>'.date_format(date_create($result[0]['created_at']), 'Y/m/d').'</b>
					  </center>
				  </div>';
		}else
			echo '';

	break;
	case 'warning_blacklist':

		$metodo_busqueda = (($_SESSION['certus_blacklist'])=='1')?'buscarbl':'buscarbllocal';
		$url = $_SESSION['web_service_url'].'/api/'.$metodo_busqueda.'?api_token='.$_SESSION['api_token'];
		$data = array('data' => array('alum_apel'=>$_POST['alum_apel'],
										'alum_nomb' => $_POST['alum_nomb'],
										'repr_cedu' => $_POST['repr_cedu']));
		$options = array(
			'http' => array(
				'method'  => 'POST',
				'content' => json_encode($data) ,
				'header'=>  "Content-Type: application/json"
				)
			);

		$context  = stream_context_create( $options );
		$result = file_get_contents( $url, false, $context );
		$result = json_decode($result,true);
		//echo var_dump($result);
		if($result['state']=='success'){ //no es nulo - esta en blacklist
			// Por temas visuales solo se muestra el primero de todos los resultados.
			$result = $result['result'];
			echo '<div class="alert alert-warning">
					  <strong>¡Advertencia de Blacklist!</strong> <small>( <b>'.count($result).'</b> alumno(s) encontrados en Blacklist. )</small>'.
					  '<center>El alumno(a) con apellido: <b>'.$result[0]['bl_alum_apel'].'</b> ,nombre: <b>'.$result[0]['bl_alum_nomb'].'</b> y representante con cédula <b>'.$result[0]['bl_repr_cedu'].' </b>
					  fue encontrado debido al motivo: <b>'.$result[0]['bl_moti_bloq_deta'].'</b> por la institución "<b>'.$result[0]['bl_clie_nomb'].'</b>" en la fecha <b>'.date_format(date_create($result[0]['created_at']), 'Y/m/d').'</b>
					  </center>
				  </div>';
		}else
			echo '';

	break;
}
?>