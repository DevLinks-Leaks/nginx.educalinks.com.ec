<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva Nota de Cr&eacute;dito',
        VIEW_SET_GET_ALL=>'Gestión de Notas de Cr&eacute;dito',
        VIEW_GET=>'Buscar Nota de Cr&eacute;dito',
        VIEW_GET_ALL=>'Gestión de Notas de Cr&eacute;dito',
        VIEW_DELETE=>'Eliminar una Nota de Cr&eacute;dito',
        VIEW_EDIT=>'Modificar una Nota de Cr&eacute;dito'
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu106}',
        'open'  => '{open1}',
        'mainmenu' => '{menu1}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()