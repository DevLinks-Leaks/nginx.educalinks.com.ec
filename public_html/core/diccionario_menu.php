<?php 
$diccionario_menu=array(
/*COMMON*/
'{Usuarios}'	=>	array(
					'href'=>'../../common/usuarios/',
					'texto'=>'<span class=\'fa fa-users\'></span>&nbsp;Usuarios',
					'permiso'=>'16',
				),
/*ACADEMICO*/
/*ADMISIONES*/
'{adm_ing_solicitud}'	=>	array(
					'href'		=>'../../admisiones/enviarSolicitud/',
					'texto'		=>'<i class="fa fa-child"></i> <span>Ingresar solicitud</span>',
					'title'		=>'Ingreso de solicitud nueva e inicio del proceso de solicitud',
					'permiso'	=>'601',
				),
'{adm_band_recibida}'	=>	array(
						'href'=>'../../admisiones/verSolicitud/',
						'texto'=>'<i class="fa fa-send"></i> Recibidas',
						'permiso'=>'603',
					),
'{adm_band_pdte_pago}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('PDTE. PAGO', '{menuSoli02}');",
					'texto'		=>'<i class="fa fa-money"></i> Pdtes. Pago',
					'permiso'	=>'604',
				),
'{adm_band_asignar_fecha}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('PAGADA', '{menuSoli03}');",
					'texto'		=>'<i class="fa fa-clock-o"></i> Por asignar fechas',
					'permiso'	=>'605',
				),
'{adm_band_subir_sintesis}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('FECHA ASIGNADA', '{menuSoli04}');",
					'texto'		=>'<span class="glyphicon glyphicon-import"></span> Por subir síntesis',
					'permiso'	=>'606',
				),
'{adm_band_agregar_director}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('EX. APROBADO', '{menuSoli05}');",
					'texto'		=>'<i class="fa fa-check-circle"></i> Por aprobar director',
					'permiso'	=>'607',
				),
'{adm_band_aprobar_comite}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('APROBADO DIRECTORES', '{menuSoli06}');",
					'texto'		=>'<i class="fa fa-check-square"></i> Por aprobar comité',
					'permiso'	=>'608',
				),
'{adm_band_admitidos}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('ADMITIDO', '{menuSoli07}');",
					'texto'		=>'<i class="fa fa-child"></i> Admitidos',
					'permiso'	=>'609',
				),
'{adm_band_guardadas}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('GUARDADA', '{menuSoli08}');",
					'texto'		=>'<i class="fa fa-floppy-o"></i> Guardadas',
					'permiso'	=>'610',
				),
'{adm_band_no_admitidos}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('NO ADMITIDO', '{menuSoli09}');",
					'texto'		=>'<i class="fa fa-ban"></i> No admitidos',
					'permiso'	=>'611',
				),
'{adm_band_administrar}'	=>	array(
					'href'		=>'#',
					'onClick'	=>	"js_verSolicitud_submit('MANT', '{menuSoli10}');",
					'texto'		=>'<i class="fa fa-inbox"></i> Administrar todas',
					'permiso'	=>'612',
				),
'{adm_doc_adjuntos}'	=>	array(
					'href'		=>'../../admisiones/documentos_admision/',
					'texto'		=>'<i class="fa fa-paperclip"></i>Documentos adjuntos',
					'permiso'	=>'614',
				),
/*BIBLIOTECA*/
/*FINANCIERO*/
'{CobroGeneral}'	=>	array(
					'href'=>'../../finan/cobros/',
					'texto'=>'<span class=\'fa fa-dollar\'></span>&nbsp;Cobrar deuda',
					'permiso'=>'126',
				),
'{Deuda}'	=>	array(
					'href'=>'../../finan/facturas/',
					'texto'=>'<span class=\'fa fa-paperclip\'></span>&nbsp;Generar deuda',
					'permiso'=>'130',
				),
'{NotadeCredito}'	=>	array(
					'href'=>'../../finan/notaCredito/',
					'texto'=>'<span class=\'fa fa-minus\'></span>&nbsp;Generar n/cr&eacute;dito',
					'permiso'=>'133',
				),
'{NotadeDebito}'	=>	array(
					'href'=>'../../finan/notaDebito/',
					'texto'=>'<span class=\'fa fa-plus\'></span>&nbsp;Generar n/d&eacute;bito',
					'permiso'=>'133',
				),
'{GestionFacturas}'	=> 	array(
						'href'=>'../../finan/gestionFacturas/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gestión factura',
						'permiso'=>'125'
				),
'{GestionNotascredito}'	=> 	array(
						'href'=>'../../finan/gestionNotascredito/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gesti&oacute;n n/c',
						'permiso'=>'207'
				),
'{GestionNotasdebito}'	=> 	array(
						'href'=>'../../finan/gestionNotasdebito/',
						'texto'=>'<span class=\'icon icon-sri\'></span>&nbsp;Gesti&oacute;n n/d',
						'permiso'=>'207'
				),
'{GestionContifico}'	=>	array(
					'href'=>'../../finan/gestionContifico/',
					'texto'=>'<span class=\'icon icon-ctfco\'></span>&nbsp;Cont&iacute;fico',
					'permiso'=>'226',
				),
'{CierredeCaja}'	=>	array(
					'href'=>'../../finan/cierre_caja/',
					'texto'=>'<span class=\'fa fa-folder\'></span>&nbsp;Cerrar caja',
					'permiso'=>'170',
				),
'{Convenio_pago}'	=>	array(
					'href'=>'../../finan/convenio_pago/',
					'texto'=>'<span class=\'fa fa-handshake-o\'></span>&nbsp;Convenio Pago',
					'permiso'=>'170',
				),
'{Contabilidad}'	=>	array(
					'href'=>'../../finan/contabilidad/',
					'texto'=>'<span class=\'icon icon-ctfco\'></span>&nbsp;Contabilidad',
					'permiso'=>'226',
				),
'{VerSaldoaFavor}'	=>	array(
					'href'=>'../../finan/saldoaFavor/',
					'texto'=>'<span class=\'fa fa-balance-scale\'></span>&nbsp;Saldos a favor',
					'title'=>'ver y administrar Saldos a favor',
					'permiso'=>'209',
				),
'{VerDocumentosAutorizados}'	=>	array(
					'href'=>'../../finan/VerDocumentosAutorizados/',
					'texto'=>'<span class=\'fa fa-barcode\'></span>&nbsp;Doc. autorizados',
					'permiso'=>'227',),
'{VerPagos}'	=>	array(
					'href'=>'../../finan/pagos/',
					'texto'=>'<span class=\'fa fa-list\'></span>&nbsp;Pagos recibidos',
					'permiso'=>'227',),
'{VerDeudas}'	=>	array(
					'href'=>'../../finan/verDeuda/',
					'texto'=>'<span class=\'fa fa-list\'></span>&nbsp;Deudas (DNA\'s)',
					'permiso'=>'227',),
'{VerCaja}'	=>	array(
					'href'=>'../../finan/verCaja/',
					'texto'=>'<span class=\'fa fa-history\'></span>&nbsp;Historial cajas',
					'permiso'=>'170',
				),
'{Categorias}'	=>	array(
					'href'=>'../../finan/categorias/',
					'texto'=>'<span class=\'fa fa-tags\'></span>&nbsp;Categorías',
					'permiso'=>'136',
				),
'{Items}'	=>	array(
					'href'=>'../../finan/items/',
					'texto'=>'<span class=\'fa fa-shopping-cart\'></span>&nbsp;Items',
					'permiso'=>'139',
				),
'{Precios}'	=>	array(
					'href'=>'../../finan/precios/',
					'texto'=>'<span class=\'fa fa-dollar\'></span>&nbsp;Precios',
					'permiso'=>'143',
				),
'{GruposEconomicos}'	=>	array(
					'href'=>'../../finan/gruposEconomico/',
					'texto'=>'<span class=\'fa fa-users\'></span>&nbsp;Grupo economico',
					'permiso'=>'145',
				),
'{NivelEconomico}'	=>	array(
					'href'=>'../../finan/nivelEconomico/',
					'texto'=>'<span class=\'fa fa-diamond\'></span>&nbsp;Nivel económico',
					'permiso'=>'149',
				),
'{AgrupaciondeCursos}'	=>	array(
					'href'=>'../../finan/nivelEconomicoCursos/',
					'texto'=>'<span class=\'fa fa-object-group\'></span>&nbsp;Agrupación de cursos',
					'permiso'=>'153',
				),
'{Clientes}'	=>	array(
					'href'=>'../../finan/clientes/',
					'texto'=>'<span class=\'fa fa-graduation-cap\'></span>&nbsp;Clientes',
					'permiso'=>'103',
				),
'{Clientes_externos}'
				=>	array(
					'href'=>'../../finan/clientes_externos/',
					'texto'=>'<span class=\'fa fa-users\'></span>&nbsp;Clientes externos',
					'permiso'=>'103',
				),
'{Sucursales}'	=>	array(
					'href'=>'../../finan/sucursales/',
					'texto'=>'<span class=\'fa fa-institution\'></span>&nbsp;Sucursales',
					'permiso'=>'106',
				),
'{Bancos}'	=>	array(
					'href'=>'../../finan/bancos/',
					'texto'=>'<span class=\'glyphicon glyphicon-piggy-bank\'></span>&nbsp;Bancos',
					'permiso'=>'186',
				),
'{tarjetasCredito}'	=>	array(
					'href'=>'../../finan/tarjetasCredito/',
					'texto'=>'<span class=\'fa fa-cc-mastercard\'></span>&nbsp;Tarjetas de crédito',
					'permiso'=>'193',
				),
'{PuntosdeEmision}'	=>	array(
					'href'=>'../../finan/puntos_emision/',
					'texto'=>'<span class=\'glyphicon glyphicon-tent\'></span>&nbsp;Puntos de emisión',
					'permiso'=>'110',
				),
'{TiposdeDescuentos}'	=>	array(
					'href'=>'../../finan/tipo_descuento/',
					'texto'=>'<span class=\'fa fa-percent\'></span>&nbsp;Tipos de descuentos',
					'permiso'=>'115',
				),
'{PeriodosAnuales}'	=>	array(
					'href'=>'../../finan/aniosPeriodo/',
					'texto'=>'<span class=\'fa fa-calendar\'></span>&nbsp;Periodos anuales',
					'permiso'=>'119',
				),
'{Liquidez}'	=>	array(
					'href'=>'../../finan/liquidez/',
					'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Reporte de liquidez',
					'permiso'=>'192',
				),
'{Cobranza}'	=>	array(
					'href'=>'../../finan/cobranza/',
					'texto'=>'<span class=\'fa fa-phone-square\'></span>&nbsp;Cobranza',
					'permiso'=>'173',
				),
'{Resultados}'	=>	array(
					'href'=>'../../finan/crm_resultados/',
					'texto'=>'<span class=\'fa fa-book\'></span>&nbsp;Resultados',
					'permiso'=>'175',
				),
'{ValidadorCheques}'	=> 	array(
						'href'=>'../../finan/valida_cheques/',
						'texto'=>'<span class=\'fa fa-check-circle-o\'></span>&nbsp;Validar cheques',
						'permiso'=>'196'
				),
'{ConvenioMandato}'	=> 	array(
						'href'=>'../../finan/convenioMandato/',
						'texto'=>'<span class=\'fa fa-hand-grab-o\'></span>&nbsp;Convenio mandato',
						'permiso'=>'198'
				),
'{Descuentofacturas}'	=> 	array(
						'href'=>'../../finan/descuentofacturas/',
						'texto'=>'<span class=\'fa fa-barcode\'></span>&nbsp;Descuento de facturas',
						'permiso'=>'205'
			 	),
'{Reporte_CRM_Cobranza}'	=>	array(
					'href'=>'../../finan/rep_cobranza/',
					'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;CRM Cobranza',
					'permiso'=>'194',
				),
'{RepNC}'	=> 	array(
						'href'=>'../../finan/rep_notaCredito/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Notas de Crédito',
						'permiso'=>'201'
				),
'{RepND}'	=> 	array(
						'href'=>'../../finan/rep_notaDebito/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Notas de Débito',
						'permiso'=>'201'
				),
'{RepFACT}'	=> 	array(
						'href'=>'../../finan/rep_facturas/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Facturas emitidas',
						'permiso'=>'202'
				),
'{RepDescuentos}'	=> 	array(
						'href'=>'../../finan/rep_descuentos/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Descuentos otorgados',
						'permiso'=>'203'
				),
'{RepSaldosAFavor}'	=> 	array(
						'href'=>'../../finan/rep_saldosafavor/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Saldos a favor',
						'permiso'=>'224'
				),
'{RepCtasPorCobrar}'=> 	array(
						'href'=>'../../finan/rep_ctasporcobrar/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Cuentas por Cobrar',
						'permiso'=>'202'
				),
'{RepEmisiones}'=> 	array(
						'href'=>'../../finan/rep_emisiones/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Reporte Emisiones',
						'permiso'=>'202'
				),
'{RepAntiguedad}'=> 	array(
						'href'=>'../../finan/rep_antiquity/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;R. Antigüedad Saldos',
						'permiso'=>'202'
				),
'{RepMediacion}'=> 	array(
						'href'=>'../../finan/rep_mediacion/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Reporte mediación',
						'permiso'=>'202'
				),
'{RepFacturas}'	=> 	array(
						'href'=>'../../finan/rep_facturas/',
						'texto'=>'<span class=\'fa fa-bookmark-o\'></span>&nbsp;Facturas',
						'permiso'=>'202'
				),
'{DebitosAutomaticos}'	=> 	array(
						'href'=>'../../finan/debitosAutomaticos/',
						'texto'=>'<span class=\'glyphicon glyphicon-import\'></span>&nbsp;Débitos bancarios',
						'permiso'=>'206'
				),
'{DescuentoAlumnos}'	=> 	array(
						'href'=>'../../finan/descuentoalumnos/',
						'texto'=>'<span class=\'fa fa-graduation-cap\'></span>&nbsp;Descuento por alumno',
						'permiso'=>'208'
				),
/*MEDICO*/
);
?>