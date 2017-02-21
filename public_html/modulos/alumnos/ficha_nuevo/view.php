<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(	
        VIEW_SET=>'Crear una nueva ficha médica',
        VIEW_SET_GET_ALL=>'Ficha médica ocupacional',
        VIEW_GET=>'Buscar fichas médicas',
        VIEW_GET_ALL=>'Nueva ficha médica',
		VIEW_CONSULTA=>'Bandeja de fichas médicas',
        VIEW_DELETE=>'Eliminar una ficha médica',
        VIEW_EDIT=>'Modificar una ficha médica'
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu603}',
        'open'  => '{open6}',
        'mainmenu' => '{menu6}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    ),
    'links_menu'=>array(
        'cmb_sidebar_periodo'  => $_SESSION['cmb_sidebar_periodo']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()