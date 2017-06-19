<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/descuentofacturas/';
const HTML_FILES="finan/descuentofacturas/descuentofacturas_";
# controladores
const GET_CLIENT 			= 'get_client';
const GET_DEUDAS 			= 'get_deudas';
const GET_METADATA_FORM 	= 'get_metadata_form';
const GET_DEUDAS_VENC_ANT 	= 'trae_deudas_vencidas_anteriores';
const GET_PORCENTAJE 		= 'get_porcentaje';
const GET_PREVISUALIZACION 	= 'get_previsualizacion';
const SET_CHANGES 			= 'set_changes';
const LOAD_DETA_DEUD_INFO 	= 'carga_detalle_deudas_info';
const DELETE = 'delete'; // Elimina de la BD
# vistas
const VIEW_BILL = 'imprimir';
const PRINT_BILL = 'factura';
const PRINT_PAYMENT = 'pago';
const PRINT_NOTA_CREDITO = 'notaCredito';
const GET_ALL_DATA = 'get_all_data';
const GET_ALL_DESCUENTOS = 'get_all_descuentos';
const GET_PTOVENTAS = 'get_ptoventas';
const GET_NUMEROSFACTURAS = 'get_numerosfacturas';
const VIEW_GET_ALL = 'buscar_todos'; 
const VIEW_CAJA_CERRADA = 'cajaCerrada'; 
const VIEW_GET_CLIENT = 'buscar_clientes'; 
const VIEW_RESULT_PAYMENT = 'ingresaPago';
const VIEW_DETAILS_DEBT = 'detalleDeuda';
const VIEW_DETAILS_PAYMENT = 'detallePagosDeuda';
const VIEW_EDIT_PAYMENT_WAY = 'editarPago'; 
const VIEW_NO_PAYMENT_WAY = 'formaPagoNones'; // Ninguna forma de pago
const VIEW_GET_PAYMENT_WAY = 'agregarPago'; // Formulario para contener los formularios metadata
const VIEW_SET_DISCOUNT = 'asignarDescuento';
// Formularios para agregar los metadatos de cada forma de pago
const VIEW_SET_CASH = 'formaPagoEfectivoAgregar';
const VIEW_SET_CHEK = 'formaPagoChequeAgregar';
const VIEW_SET_CREDITCARD = 'formaPagoTarjetaCreditoAgregar'; 
const VIEW_SET_TX = 'formaPagoTransferenciaAgregar';
const VIEW_SET_ESCROW = 'formaPagoDepositoAgregar'; 

// Formularios para actualizar los metadatos de cada forma de pago
const VIEW_EDIT_CASH = 'formaPagoEfectivoEditar';
const VIEW_EDIT_CHEK = 'formaPagoChequeEditar';
const VIEW_EDIT_CREDITCARD = 'formaPagoTarjetaCreditoEditar'; 
const VIEW_EDIT_TX = 'formaPagoTransferenciaEditar';
const VIEW_EDIT_ESCROW = 'formaPagoDepositoEditar'; 
?>