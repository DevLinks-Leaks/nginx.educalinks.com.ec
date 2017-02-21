<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva cajas',
		VIEW_SET_GET_ALL=>'Crear y mostrar las cajas',
        VIEW_GET=>'Buscar categoria',
        VIEW_GET_ALL=>'Consultar todas las cajas',					  
        VIEW_DELETE=>'Eliminar una cajas',
        VIEW_EDIT=>'Modificar cajas'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu111}',
		'open'  => '{open1}',
        'mainmenu' => '{menu1}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>