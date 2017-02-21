<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/gestionFacturas/';
const HTML_FILES="finan/gestionFacturas/gestionFactura_";
# controladores
const RESEND_TO_SRI = 'resend_to_sri';
const SEND_TO_SRI = 'send_to_sri';
const SEND_TO_SRI_ALL = 'send_to_sri_all';

const AUTORIZAR_TO_SRI_ALL = 'autorizar_to_sri_all';
const GET_PENDING_BILLS = 'get_pending_bills';
const GET = 'editar_factura';
const GET_ALL_DATA = 'get_all_data';
const PRINT_EXCEL_ALL_DATA = 'print_excel_all_data';
const GET_QUERY_BANCOS = 'get_query_bancos';
const EDIT = 'edit';
const GET_PENDING_BILLS_CODI_JSON = 'get_fac_pdtes_codi_json';
# vistas
const VIEW_GET_ALL = 'buscar_todos';
const VIEW_RESULT_SRI = 'resultadoSRI';
const VIEW_RESULT_SRI_LOTE = 'resultadoSRIlote';
const VIEW_BADGE_FACT = 'badge_gest_fac';
const VIEW_EDITAR = 'editar';
const VIEW_QUERY_BANCOS = 'query_bancos';