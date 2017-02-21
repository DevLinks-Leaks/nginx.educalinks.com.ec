<?php

require_once("../../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Nuevo Tipo de Descuento',	 
        VIEW_GET=>'Consulta de Tipos de Descuento',
        VIEW_GET_ALL=>'Consulta de Tipos de Descuento',
        VIEW_DELETE=>'Eliminar un Tipo de Descuento',
        VIEW_EDIT=>'Modificar un Tipo de Descuento'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu303}',
		'open'  => '{open3}', 
        'mainmenu' => '{menu3}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()