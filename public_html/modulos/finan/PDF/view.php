<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear',
		VIEW_SET_GET_ALL=>'Crear y mostrar',
        VIEW_GET=>'Buscar',
        VIEW_GET_ALL=>'Reporte',					  
        VIEW_DELETE=>'Eliminar',
        VIEW_EDIT=>'Modificar'),
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