<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/aniosPeriodo/';
const HTML_FILES="finan/aniosPeriodo/anioPeriodo_";
# controladores
const GET_ALL_DATA 				= 'get_all_data';
const GET_ALL_DEUDA 			= 'get_all_deuda';
const GET_PRODUCTO 				= 'get_producto';
const SET 						= 'set'; // Ingresar en la BD
const GENERA_DEUDA 				= 'set_deuda';
const GENERA_DEUDA_IND 			= 'set_deuda_ind';
const BLOQUEA_ALUMNO 			= 'set_bloqueo_alumno';
const DELETE_BLOQUEO_ALUMNO 	= 'del_bloqueo_alumno';
const DELETE 					= 'delete'; // Elimina de la BD
const GET 						= 'get'; // Consulta especifica
const DEUDA 					= 'deuda'; // Consulta especifica
const EDIT 						= 'edit'; // Actualiza los datos en la BD
const RESULTADO 				= 'resultado'; // Actualiza los datos en la BD
const UPDDEUDA 					= 'upddeuda'; // Actualiza los datos en la BD
const GET_CURSO					= 'get_curso'; //Obtiene cursos para combobox
const GET_ALUMNOS				= 'get_alumnos';//Obtiene alumnos para combobox
const MIGRARFACTURAS			= 'migrarfacturas';
const MIGRARFACTURASINDIVIDUALES= 'migrarfacturasindividuales';
const VIEW_MIGRACION			= 'migracion';
# vistas
const VIEW_GET_ALL				= 'buscar_todos'; // Carga toda la vista con todos los datos
const VIEW_SET					= 'agregar'; // Mostrar formulario para agregar
const VIEW_EDIT					= 'modificar'; // Consulta especifica y Mostrar formulario para editar
const VIEW_GENERA_DEUDAS		= 'genera_deudas';
const VIEW_BLOQUEO_ALUMNOS 		= 'bloqueo_alumnos';
const VIEW_GET_DEUDAS 			= 'deudas';
const VIEW_MIGRARDEUDAS 		= 'migrardeudas';
const VIEW_RESULTADO 			= 'resultado';
const VIEW_MIGRACION			= 'migracion';
const VIEW_RESULTADOINDIVIDUAL 	= 'resultadoindividual';
const VIEW_SET_DEBTS_TO_ALL 	= 'resultadoDeudasLote';
const VIEW_MIGRACIONINDIVIDUAL	= 'migrardeudasindividuales';
?>