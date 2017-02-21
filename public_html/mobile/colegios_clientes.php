
<?php
include("Classes/Clientes.php");
$colegios = new Clientes;
$colegios->getClients();
$json_colegios = array();
foreach($colegios->rows as $colegio){
	$json_colegios[] = array("id"=>$colegio['clie_codi'],"texto"=>$colegio['clie_nomb']);
}
$array_users = array ("result"=>$json_colegios);
echo json_encode($array_users);
?>