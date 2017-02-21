<?php
session_start();
require_once("../../../core/viewBase.php");
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Agrega un nuevo item al periodo',
		VIEW_SET_GET_ALL=>'Crear y mostrar los items obligatorios del periodo',
        VIEW_GET_ALL=>'Gestión de deudas por enviar a Contabilidad',					  
        VIEW_DELETE=>'Eliminar un item del periodo',
        VIEW_EDIT=>'Modificar las fechas de cobro de un item'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu108}',
		'open'  => '{open1}', 
        'mainmenu' => '{menu1}'),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'])
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()