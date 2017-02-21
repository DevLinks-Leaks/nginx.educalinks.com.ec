<?php
session_start();
require_once("../../../core/viewBase.php");

if( !empty ( $_POST['submenu'] ) )
	$submenu = $_POST['submenu'];
else
	$submenu = '{menuPaciente02}';

$diccionario = array(
    'subtitle'=>array(	
        VIEW_SET=>'Paciente nuevo',
        VIEW_GET=>'Consulta de paciente',
        VIEW_GET_ALL=>'Bandeja de pacientes',
        VIEW_DELETE=>'Eliminar registro de paciente',
        VIEW_EDIT=>'Modificar registro de paciente'
    ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => $submenu,
        'open'  => '{openPaciente}',
        'mainmenu' => '{menu2}'
    ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'],
        'usua_apellidos' => $_SESSION['usua_apellidos']
    ),
    'links_menu'=>array(
        'cmb_sidebar_periodo'  => $_SESSION['cmb_sidebar_periodo']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()