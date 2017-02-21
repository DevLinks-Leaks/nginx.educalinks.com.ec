<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/cierre_caja/';
const HTML_FILES="finan/cierre_caja/cierre_caja_";
# controladores
const GET_ALL_DATA = 'get_all_data';
const SET = 'set'; // Ingresar en la BD
const CLOSE = 'close_caja'; // Elimina de la BD
const RE_OPEN = 'reopen_caja';
const GET = 'get'; // Consulta especifica
const PRINTREP_ITEM = 'print_item'; 
const PRINTREP_FP = 'print_fp'; 
const PRINTREP_NOTACREDITO = 'print_nc'; 
const PRINTREPVISOR_ITEM = 'printvisor_item';
const PRINTREPVISOR_FP = 'printvisor_fp';
const PRINTREPVISOR = 'printvisor';

# vistas
const VIEW_GET_ALL = 'buscar_todos'; // Carga toda la vista con todos los datos
const VIEW_SET = 'agregar'; // Mostrar formulario para agregar
const VIEW_EDIT = 'modificar'; // Consulta especifica y Mostrar formulario para editar
?>