<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nueva banco',
		VIEW_SET_GET_ALL=>'Crear y mostrar los repotes de saldos favor',
        VIEW_GET=>'Buscar bancos',
        VIEW_GET_ALL=>'Reporte de Saldos a favor',					  
        VIEW_DELETE=>'Eliminar un reporte de saldo a favor',
        VIEW_EDIT=>'Modificar reporte de saldo a favor'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu407}',
		'open'  => '{open4}', 
        'mainmenu' => '{menu4}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>