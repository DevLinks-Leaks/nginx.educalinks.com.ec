<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_GET_ALL=>'Convenio de pago'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  	=> '{menu112}',
		'open'  	=> '{open1}', 
        'mainmenu' 	=> '{menu1}'
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>