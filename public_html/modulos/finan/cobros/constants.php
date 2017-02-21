<?php
const API="/educalinks/";
const MODULO = 'modulos/finan/cobros/';
const HTML_FILES="finan/cobros/cobro_";
# controladores
const GET_CLIENT = 'get_client';
const GET_DEUDAS = 'get_deudas';
const GET_METADATA_FORM = 'get_metadata_form';
const GET_DEUDAS_VENC_ANT = 'trae_deudas_vencidas_anteriores';
# vistas
const VIEW_BILL = 'imprimir';
const PRINT_BILL = 'factura';
const PRINT_PAYMENT = 'pago';
const PRINT_NOTA_CREDITO = 'notaCredito';
const PRINT_PDF_PAGO = 'print_pdf_pago';
const PRINTREPVISOR = 'print_rep_visor';

const VIEW_GET_ALL = 'buscar_todos'; 
const VIEW_CAJA_CERRADA = 'cajaCerrada'; 
const VIEW_GET_CLIENT = 'buscar_clientes'; 
const VIEW_RESULT_PAYMENT = 'ingresaPago';
const VIEW_DETAILS_DEBT = 'detalleDeuda';
const VIEW_DETAILS_PAYMENT = 'detallePagosDeuda';
const VIEW_EDIT_PAYMENT_WAY = 'editarPago'; 
const VIEW_NO_PAYMENT_WAY = 'formaPagoNones'; // Ninguna forma de pago
const VIEW_GET_PAYMENT_WAY = 'agregarPago'; // Formulario para contener los formularios metadata
const MARCAR_PAGADO_CERO = 'marcar_pagado_cero';

// Formularios para agregar los metadatos de cada forma de pago
const VIEW_SET_CASH = 'formaPagoEfectivoAgregar';
const VIEW_SET_SALDOAFAVOR = 'formaPagoSaldoaFavor';
const VIEW_SET_MENSAJESALDOAFAVOR = 'mensajesaldoafavor';
const VIEW_SET_CHEK = 'formaPagoChequeAgregar';
const VIEW_SET_CHEK_ALERT = 'formaPagoChequeAgregarAlerta';
const VIEW_SET_CREDITCARD = 'formaPagoTarjetaCreditoAgregar'; 
const VIEW_SET_TX = 'formaPagoTransferenciaAgregar';
const VIEW_SET_ESCROW = 'formaPagoDepositoAgregar'; 
const VIEW_SET_DOCINT = 'formaPagoDocumentoInternoAgregar';
const SEND_FACTURA_SRI = 'SendfacturaSRI';
const VIEW_RESULT_PAYMENT_ELEC = 'ingresapagoElec';
// Formularios para actualizar los metadatos de cada forma de pago
const VIEW_EDIT_CASH = 'formaPagoEfectivoEditar';
const VIEW_EDIT_CHEK = 'formaPagoChequeEditar';
const VIEW_EDIT_CREDITCARD = 'formaPagoTarjetaCreditoEditar'; 
const VIEW_EDIT_TX = 'formaPagoTransferenciaEditar';
const VIEW_EDIT_ESCROW = 'formaPagoDepositoEditar'; 
const VIEW_EDIT_DOCINT = 'formaPagoDocumentoInternoEditar';
// Migrar contifico
const MIGRARFACTURASINDIVIDUALES='migrarfacturasindividuales';
const UPDDEUDA = 'upddeuda'; // Actualiza los datos en la BD

?>