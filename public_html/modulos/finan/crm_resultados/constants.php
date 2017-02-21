<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/crm_resultados/';
const HTML_FILES="finan/crm_resultados/resu_";
# controladores
const GET_ALL_DATA = 'get_all_data';
const GET_ALL_DETAS = 'get_all_detalles';
const SET = 'set'; // Ingresar en la BD
const DELETE = 'delete'; // Elimina de la BD
const GET = 'get'; // Consulta especifica
const EDIT = 'edit'; // Actualiza los datos en la BD
const ASIGN = 'asign';
const DEL_ASIGN = 'del_asign';

# vistas
const VIEW_GET_ALL = 'buscar_todos'; // Carga toda la vista con todos los datos
const VIEW_SET = 'agregar'; // Mostrar formulario para agregar
const VIEW_EDIT = 'modificar'; // Consulta especifica y Mostrar formulario para editar
const VIEW_ASIGN = 'asignar';
?>