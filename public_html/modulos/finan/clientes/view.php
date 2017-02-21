<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo cliente',
		VIEW_SET_GET_ALL=>'Crear y mostrar los clientes',
        VIEW_GET=>'Buscar cliente',
        VIEW_GET_ALL=>'Consultar todos los clientes',					  
        VIEW_DELETE=>'Eliminar un cliente',
        VIEW_EDIT=>'Modificar cliente'
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