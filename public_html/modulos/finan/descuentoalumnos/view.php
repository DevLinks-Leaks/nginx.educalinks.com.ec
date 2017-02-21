<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nuevo descuento',
		VIEW_SET_GET_ALL=>'Crear y mostrar los descuentos',
        VIEW_GET=>'Buscar item',
        VIEW_GET_ALL=>'Consulta de alumnos con descuento',
        VIEW_DELETE=>'Eliminar un descuento',
        VIEW_EDIT=>'Modificar un descuento'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu315}',
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