<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nueva banco',
		VIEW_SET_GET_ALL=>'Crear y mostrar los bancos',
        VIEW_GET=>'Buscar bancos',
        VIEW_GET_ALL=>'Consultar todos los bancos',					  
        VIEW_DELETE=>'Eliminar un banco',
        VIEW_EDIT=>'Modificar banco'),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu208}',
		'open'  => '{open2}', 
        'mainmenu' => '{menu2}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>