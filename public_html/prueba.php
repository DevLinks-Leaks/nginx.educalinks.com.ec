<?php $datos =array();
$datos['cabecera']=array('codigo'=>1,'nombre'=>'juan');
$datos['detalle']=array(array('telefono'=>2221),array('telefono'=>22221311));
echo json_encode($datos);



?>