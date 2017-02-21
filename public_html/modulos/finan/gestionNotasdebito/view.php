<?php
session_start();
require_once("../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva Nota de D&eacute;bito',
        VIEW_SET_GET_ALL=>'Gestión de Notas de D&eacute;bito pendientes',
        VIEW_GET=>'Buscar Nota de D&eacute;bito',
        VIEW_GET_ALL=>'Gestión de Notas de D&eacute;bito pendientes',
        VIEW_DELETE=>'Eliminar una Nota de D&eacute;bito',
        VIEW_EDIT=>'Modificar una Nota de D&eacute;bito'
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu107}',
        'open'  => '{open1}',
        'mainmenu' => '{menu1}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()