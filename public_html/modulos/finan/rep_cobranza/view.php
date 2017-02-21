<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo reporte de cobranza',
		VIEW_SET_GET_ALL=>'Crear y mostrar los repotes de cobranza',
        VIEW_GET=>'Buscar bancos',
        VIEW_GET_ALL=>'Reporte de cobranza',					  
        VIEW_DELETE=>'Eliminar un reporte de cobranza',
        VIEW_EDIT=>'Modificar reporte de cobranza'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu402}',
		'open'  => '{open4}', 
        'mainmenu' => '{menu4}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()