<?php

require_once("../../../core/viewBase.php");
session_start();
$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear un nuevo deudor',
        VIEW_SET_GET_ALL=>'Crear y mostrar los deudores',
        VIEW_GET=>'Consulta de deudores vencidos',
        VIEW_GET_ALL=>'Consulta de todos los deudores',
        VIEW_DELETE=>'Eliminar un deudor vencido',
        VIEW_EDIT=>'Modificar deudor vencido'
                     ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu501}',
    'open'  => '{open5}', 
        'mainmenu' => '{menu5}' 
                        ),
  'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()
?>