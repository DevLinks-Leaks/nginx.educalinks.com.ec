<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo periodo',
		    VIEW_SET_GET_ALL=>'Crear y mostrar las categorias',
        VIEW_GET=>'Buscar categoria',
        VIEW_GET_ALL=>'Periodos de admisión',					  
        VIEW_DELETE=>'Eliminar una categoria',
        VIEW_EDIT=>'Modificar categoria'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'	=> '{menuopenSoliConfigSist01}', 
		'open'		=> '{openSoliConfigSist}',
        'mainmenu'	=> '{menuSoliConfigSist}'
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>