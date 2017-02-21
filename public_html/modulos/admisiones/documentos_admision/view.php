<?php
require_once("../../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Nuevo documento para admisi&oacute;n',	 
        VIEW_GET=>'Consulta documentos para admisi&oacute;n',
        VIEW_GET_ALL=>'Consulta de documentos para admisi&oacute;n',
        VIEW_DELETE=>'Eliminar un documento para admisi&oacute;n',
        VIEW_EDIT=>'Modificar un documento para admisi&oacute;n'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menuopenSoliConfigSist02}',
		'open'  => '{openSoliConfigSist}', 
        'mainmenu' => '{menuSoliConfigSist}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>