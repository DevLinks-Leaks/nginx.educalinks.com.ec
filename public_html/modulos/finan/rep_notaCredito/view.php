<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo reporte de nota de cr&eacute;dito',
		VIEW_SET_GET_ALL=>'Crear y mostrar los reporte de nota de cr&eacute;dito',
        VIEW_GET=>'Buscar bancos',
        VIEW_GET_ALL=>'Reporte de nota de cr&eacute;dito',					  
        VIEW_DELETE=>'Eliminar un reporte de nota de cr&eacute;dito',
        VIEW_EDIT=>'Modificar reporte de nota de cr&eacute;dito'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu404}',
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