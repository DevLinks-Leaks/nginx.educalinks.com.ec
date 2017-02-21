<?php

require_once("../../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_GET_ALL=>'Consultar todos los resultados'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu502}',
    'open'  => '{open5}', 
        'mainmenu' => '{menu5}' 
                        ),
  'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>