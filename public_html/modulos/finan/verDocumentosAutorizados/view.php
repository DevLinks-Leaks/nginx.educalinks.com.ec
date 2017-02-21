<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET_GET_ALL=>'Gestión de documentos autorizados',
        VIEW_GET_ALL=>'Documentos autorizados',
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu602}',
        'open'  => '{open6}',
        'mainmenu' => '{menu6}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()