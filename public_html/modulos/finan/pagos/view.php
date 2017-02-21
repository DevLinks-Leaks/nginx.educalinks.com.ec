<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo registro de pago',
        VIEW_SET_GET_ALL=>'Bandeja de pagos recibidos',
        VIEW_GET=>'Buscar pagos',
        VIEW_GET_ALL=>'Pagos',
        VIEW_DELETE=>'Eliminar un pago',
        VIEW_EDIT=>'Modificar un pago'
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