<?php
session_start();
require_once("../../../core/viewBase.php");

//Como del menú se llama al mismo controller en más de una opción, 
//se manda desde el menu.js (funciones cuyo nombre inician con js_verSolicitud) una variable
//'submenu', que selecciona el active en el menú. Y una variable 'soli_estado', 
//que carga la misma bandeja con diferentes registros.

if( !empty ( $_POST['submenu'] ) )
	$submenu = $_POST['submenu'];
else
	$submenu = '{menuSoli01}';

$diccionario = array(
    'subtitle'	=>array(
        VIEW_GET_ALL	=> 'Bandeja de solicitudes'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  		=> $submenu,
		'open'  		=> '{openSoli}', 
        'mainmenu' 		=> '{menuSoli}'
                        ),
	'usua_datos'=>array(
        'usua_nombres'   => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>