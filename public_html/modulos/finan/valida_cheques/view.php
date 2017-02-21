<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo cheque',
		VIEW_SET_GET_ALL=>'Crear y mostrar los cheques',
        VIEW_GET=>'Buscar cheques',
        VIEW_GET_ALL=>'Gesti&oacute;n de cheques por depositar',					  
        VIEW_DELETE=>'Eliminar un cheque',
        VIEW_EDIT=>'Modificar un cheque'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu109}',
		'open'  => '{open1}', 
        'mainmenu' => '{menu1}'
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()