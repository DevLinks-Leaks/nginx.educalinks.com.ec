<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un punto de emisión',
        VIEW_SET_GET_ALL=>'Crear y mostrar punto de emisión',
        VIEW_GET=>'Buscar punto de emisión',
        VIEW_GET_ALL=>'Consultar punto de emisión',                     
        VIEW_DELETE=>'Eliminar un punto de emisión',
        VIEW_EDIT=>'Modificar punto de emisión'
                     ),
    'links_menu'=>array(
        'VIEW_SET'=>MODULO.VIEW_SET.'/',
        'VIEW_SET_GET_ALL'=>MODULO.VIEW_SET_GET_ALL.'/',
        'VIEW_GET'=>MODULO.VIEW_GET.'/',
        'VIEW_GET_ALL'=>MODULO.VIEW_GET_ALL.'/',        
        'VIEW_EDIT'=>MODULO.VIEW_EDIT.'/',
        'VIEW_DELETE'=>MODULO.VIEW_DELETE.'/'
                        ),
    'form_actions'=>array(
        'SET'=>API.MODULO.SET.'/',
        'SET_GET_ALL'=>API.MODULO.SET_GET_ALL.'/',
        'GET'=>API.MODULO.GET.'/',
        'GET_ALL'=>API.MODULO.GET_ALL.'/',
        'DELETE'=>API.MODULO.DELETE.'/',
        'EDIT'=>API.MODULO.EDIT.'/'
                        ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu302}',
        'open'  => '{open3}', 
        'mainmenu' => '{menu3}' 
                        ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()