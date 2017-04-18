<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nuevo Grupo Economico',
		    VIEW_SET_GET_ALL=>'Crear y mostrar los grupos economico',
        VIEW_GET=>'Buscar item',
        VIEW_GET_ALL=>'Grupos económicos',					  
        VIEW_DELETE=>'Eliminar un grupo economico',
        VIEW_EDIT=>'Modificar un grupo economico'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu204}',
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