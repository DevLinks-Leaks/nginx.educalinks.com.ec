<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva solicitud',
		VIEW_SET_GET_ALL=>'Crear y solicitudes',
        VIEW_GET=>'Buscar solicitud',
        VIEW_GET_ALL=>'Env&iacute;o de solicitud',					  
        VIEW_DELETE=>'Eliminar una solicitud',
        VIEW_EDIT=>'Modificar una solicitud'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu304}',
		'open'  => '{open3}', 
        'mainmenu' => '{menu3}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>