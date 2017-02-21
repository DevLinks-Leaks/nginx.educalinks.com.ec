<!DOCTYPE html >
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{proyecto} | {subtitulo}</title>
		<style type="text/css">
			#contenedor{
				width: 45%;
				margin: 0 auto;
				font-family: "Helvetica";
				border: solid 1px black;
			}
			#cabeceraIzquierda{
				float: left;
				width: 47%;
				margin-right: 3px;
				margin-bottom: 0px;
				padding: 0px;
				height: 275px;
			}
			#logo{
				display: block;
				margin: 0px;
				float: left;
				width: 97%;
				height: 30%;
			}
			#cabeceraIzquierda figure img{
				width: 100%;
			}

			#cabeceraIzquierda td:first-child{
				font-weight: bold;
			}
			#cabeceraIzquierda td:last-child{
				font-size: x-small;
			}

			#datosEmpresa{
				height: 70%;
				float: left;
				vertical-align: bottom;
				width: 97%;
				padding: 5px;
				border: 1px solid;
				border-radius: 10px;
				margin-bottom: 0px;
				font-size: small;
			}
			
			#cabeceraDerecha{
				float: right;
				width: 50%;
				padding: 5px;
				border: 1px solid;
				border-radius: 10px;
				font-size: small;
				height: 275px;
			}
			#cabeceraDerecha td:first-child{
				font-weight: bold;
			}
			#cabeceraDerecha td:last-child{
				font-size: x-small;
			}
			
			#datosCliente{
				width: 99%;
				float: left;
				border: 1px solid;
				padding: 3px;
				margin-top: 5px;
				margin-bottom: 5px;
			}
			#datosCliente > table{
				width: 100%;
				font-size: small;
			}

			.nombreCampo{
				font-weight: bold;
			}
			.valorCampo{
				font-weight: normal;
			}
			#detalleFactura{
				width: 100%;
				float: left;
			}
			#detalleFactura > table{
				width: 100%;
				font-size: small;
				border-collapse: collapse;
			}
			#detalleFactura > table > thead > tr > th{
				text-align: center;
				font-size: small;
			}
			#detalleFactura > table > tr > td{
				border: 1px solid black;
			}
			#detalleFactura td:last-child, #detalleFactura td:nth-child(4), #detalleFactura td:nth-child(5), #detalleFactura td:nth-child(6), #detalleFactura td:nth-child(7), #detalleFactura td:nth-child(8) {
				text-align: right;
			}
			#detalleFactura td:last-child:before, #detalleFactura td:nth-child(4):before, #detalleFactura td:nth-child(5):before, #detalleFactura td:nth-child(6):before, #detalleFactura td:nth-child(7):before, #detalleFactura td:nth-child(8):before {
				content: "$ ";
			}
			#detalleFactura td:last-child{
				font-weight: bold;
			}
			
			#termino{
				float: left;
				width: 100%;
				margin-top: 5px;
			}
			#pieIzquierda{
				width: 37%;
				margin-right: 5px;
				float: left;
				font-size: x-small;
				border: 1px solid;
				padding: 5px;
			}
			#pieIzquierda > table{
				width: 100%;
			}
			#pieDerecha{
				width: 50%;
				float: right;
				font-size: x-small;
				margin-right: none;
			}
			#pieDerecha > table{
				width: 100%;
				border-collapse: collapse;
			}
			.valorDecimal{
				text-align: right;
			}
			
			@media print {
			    .page-break { 
			        display: block; 
			        page-break-before: always; 
			    }
			    
			    @page {  
			        size: A4 landscape;
			        border: 1px solid black;
			    } 
			
				#contenedor{
					width: 75%;
				}

				#datosEmpresa{
					font-size: x-small;
				}

				#cabeceraDerecha{
					font-size: x-small;
				}

				#datosCliente > table{
					font-size: x-small;
				}

				#pieIzquierda{
					font-size: xx-small;
				}

				#detalleFactura > table > thead > tr > th{
					font-size: xx-small;
				}
			}
		</style>
	<head>
<body>
	<div id="contenedor">
		<div><font color='red'>ESTE ES UN DOCUMENTO NO AUTORIZADO, USAR S&Oacute;LO POR REFERENCIA.</font></div>
		<section id="cabeceraIzquierda">
			<figure id="logo">
				<img src="{ruta_logoEmpresa}" alt="" style="width: 50%; height: 50%"/>
			</figure>
			<div id="datosEmpresa">
				<table border="0">
					<caption>{nombreComercial_empresa}</caption>
					<tbody>
						<tr>
							<td>Dir. Matriz</td>
							<td>{direccion_matrizEmpresa}</td>
						</tr>
						<tr>
							<td>Dir. Sucursal</td>
							<td>{direccion_sucursalEmpresa}</td>
						</tr>
						<tr>
							<td>Contribuyente Especial Nro.</td>
							<td>{no_contribuyenteEspecial}</td>
						</tr>
						<tr>
							<td>Obligado a llevar contabilidad</td>
							<td>{contabilidad_obligada}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section> <!-- fin del detalle de la cabecera izquierda -->
		<section id="cabeceraDerecha">
			<div id="datosFactura">
				<table border='0' style="width:100%" >
					<tbody>
						<tr>
							<td>R.U.C.</td>
							<td>{ruc_empresa}</td>
						</tr>
						<tr>
							<td colspan='2'>FACTURA</td>
						</tr>
						<tr>
							<td>No.</td>
							<td>{prefijo_sucursal}-{prefijo_puntoVenta}-{secuencia_factura}</td>
						</tr>
						<tr>
							<td colspan='2'>NÚMERO DE AUTORIZACIÓN</td>
						</tr>
						<tr>
							<td colspan='2' style="text-align: center;" >{numero_autorizacion}</td>
						</tr>
						<tr>
							<td>FECHA Y HORA DE AUTORIZACIÓN</td>
							<td>{fechaHora_autorizacion}</td>
						</tr>
						<tr>
							<td>AMBIENTE</td>
							<td>{ambiente_emision}</td>
						</tr>
						<tr>
							<td>EMISIÓN</td>
							<td>{tipo_emision}</td>
						</tr>
						<tr>
							<td colspan='2'>CLAVE DE ACCESO</td>
						</tr>
						<tr>
							<td colspan='2' style="text-align: center;">{clave_acceso}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section> <!-- fin de la cabecera derecha -->
		<section id="datosCliente">
			<table border='0'>
				<tr style="width:30%;margin-right:10px;">
					<td class="nombreCampo">Razón Social/Nombres y Apellidos:</td>
					<td>{nombres_titular}</td>
					<td class="nombreCampo">Identificación:</td>
					<td>{identificacion_titular}</td>
				</tr>
				<tr style="width:30%;">
					<td class="nombreCampo">Fecha de Emisión:</td>
					<td>{fecha_emision}</td>
					<td class="nombreCampo">Guía de remisión:</td>
					<td>{guia_remision}</td>
				</tr>
			</table>
		</section> <!-- fin de datos del cliente -->
		<section id="detalleFactura">
			{tabla_detalleFactura}
		</section> <!-- fin del detalle de la factura -->
		<section id="termino">
			<section id="pieIzquierda">
				<table border='0'>
					<caption>Información Adicional</caption>
					<tbody>
						<tr>
							<td class="nombreCampo">Cliente</td>
							<td>{nombre_cliente}</td>
						</tr>
						<tr>
							<td class="nombreCampo">Telefono</td>
							<td>{telefono_cliente}</td>
						</tr>
						<tr>
							<td class="nombreCampo">Dirección</td>
							<td>{direccion_cliente}</td>
						</tr>
						<tr>
							<td class="nombreCampo">Email</td>
							<td>{email_cliente}</td>
						</tr>
					</tbody>
				</table>
			</section> <!-- fin de la información adicional -->
			<section id="pieDerecha">
				<table border='1'>
					<tbody>
						<tr>
							<td class="nombreCampo">SUBTOTAL 14%</td>
							<td class="valorDecimal">{subtotal_12}</td>
						</tr>
						<tr>
							<td class="nombreCampo">SUBTOTAL 0%</td>
							<td class="valorDecimal">{subtotal_0}</td>
						</tr>
						<tr>
							<td class="nombreCampo">SUBTOTAL no objeto de IVA</td>
							<td class="valorDecimal">{subtotal_noObjetoIVA}</td>
						</tr>
						<tr>
							<td class="nombreCampo">SUBTOTAL Exento de IVA</td>
							<td class="valorDecimal">{subtotal_exentoIVA}</td>
						</tr>
						<tr>
							<td class="nombreCampo">SUBTOTAL SIN IMPUESTOS</td>
							<td class="valorDecimal">{subtotal_sinImpuestos}</td>
						</tr>
						<tr>
							<td class="nombreCampo">DESCUENTO</td>
							<td class="valorDecimal">{total_descuento}</td>
						</tr>
						<tr>
							<td class="nombreCampo">ICE</td>
							<td class="valorDecimal">{total_ice}</td>
						</tr>
						<tr>
							<td class="nombreCampo">IVA 14%</td>
							<td class="valorDecimal">{total_iva}</td>
						</tr>
						<tr>
							<td class="nombreCampo">IRBPNR</td>
							<td class="valorDecimal">{irbpnr}</td>
						</tr>
						<tr>
							<td class="nombreCampo">PROPINA</td>
							<td class="valorDecimal">{propina}</td>
						</tr>
						<tr>
							<td class="nombreCampo">VALOR TOTAL</td>
							<td class="valorDecimal">{total_neto}</td>
						</tr>
					</tbody>
				</table>
			</section> <!-- fin de la información de los totales -->
		</section>
	</div>
</body>
</html>