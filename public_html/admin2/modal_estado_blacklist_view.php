<?php
	include ('../framework/dbconf.php');

	$params = array($alum_codi);
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

	if($result['state']=='success'){
		$result = $result['result'];
?>	
<li class="list-group-item list-group-item-warning">
	<!-- <div class='alert alert-warning'> -->
		<strong>¡Advertencia de Blacklist!</strong>
		<small>( <b><?=count($result);?></b> alumno(s) encontrados en Blacklist. )</small>
		<center>El alumno(a) con apellido: <b><?= $result[0]['bl_alum_apel']; ?></b>,nombre: <b><?= $result[0]['bl_alum_nomb'];?>
		</b>  y representante con cédula <b> <?=$result[0]['bl_repr_cedu'];?> </b><br> fue encontrado debido al motivo: <b> <?= $result[0]['bl_moti_bloq_deta']; ?></b> por la institución "<b><?= $result[0]['bl_clie_nomb'];?></b>" en la fecha <b><?= date_format(date_create($result[0]['created_at']), 'Y/m/d');?></b>
		  </center>
	  <!-- </div> -->
</li>
<? } ?>