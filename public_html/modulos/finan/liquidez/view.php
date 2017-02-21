<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_GET_ALL=>'Reporteador de liquidez',
		VIEW_REP_EDIT=>'Reporteador de liquidez',
                     ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu401}', 
		    'open'  => '{open4}',
        'mainmenu' => '{menu4}' 
                        ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>