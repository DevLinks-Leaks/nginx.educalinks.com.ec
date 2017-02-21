<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_GENERA_FILE=>'Débitos bancarios automáticos',					  
        VIEW_CARGA_FILE=>'Débitos bancarios automáticos',
		 VIEW_SHOWMENSAJE=>'Resultados:'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu314}',
		'open'  => '{open3}', 
        'mainmenu' => '{menu3}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()