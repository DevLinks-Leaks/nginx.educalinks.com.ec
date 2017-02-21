<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nuevo item',
		    VIEW_SET_GET_ALL=>'Crear y mostrar los items',
        VIEW_GET=>'Buscar item',
        VIEW_GET_ALL=>'Consultar todas los items',					  
        VIEW_DELETE=>'Eliminar un item',
        VIEW_EDIT=>'Modificar item'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu202}',
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