<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva factura',
        VIEW_SET_GET_ALL=>'Gestión de facturas',
        VIEW_GET=>'Buscar factura',
        VIEW_GET_ALL=>'Gestión de facturas',
        VIEW_DELETE=>'Eliminar una factura',
        VIEW_EDIT=>'Modificar una factura'
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu105}',
        'open'  => '{open1}',
        'mainmenu' => '{menu1}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()