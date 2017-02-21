<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva categoria',
		    VIEW_SET_GET_ALL=>'Crear y mostrar las categorias',
        VIEW_GET=>'Buscar categoria',
        VIEW_GET_ALL=>'Categorías de productos',					  
        VIEW_DELETE=>'Eliminar una categoria',
        VIEW_EDIT=>'Modificar categoria'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu201}', 
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