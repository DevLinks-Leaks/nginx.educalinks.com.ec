<?php

require_once("../../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva residencia',
		VIEW_SET_GET_ALL=>'Crear y mostrar las residencias',
        VIEW_GET=>'Buscar residencia',
        VIEW_GET_ALL=>'Consultar todas las residencias',					  
        VIEW_DELETE=>'Eliminar una residencia',
        VIEW_EDIT=>'Modificar residencia'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu503}',
		'open'  => '{open5}', 
        'mainmenu' => '{menu5}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>