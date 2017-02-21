<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_GET_ALL=>'Consultar todos los cursos por nivel económico',
        VIEW_EDIT=>'Modificar curso por nivel económico'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu206}', 
		    'open'  => '{open2}',
        'mainmenu' => '{menu2}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()