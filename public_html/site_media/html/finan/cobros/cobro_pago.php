<!DOCTYPE html >
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{proyecto} | {subtitulo}</title>
	<head>
            
	<style type="text/css">
		#contenedor{
			width: 37%;
			margin: 0 auto;
			font-family: "Arial";
		}
		#cabecera{
			float: left;
			margin-bottom: 3px;
			width: 100%;
		}
		#cabecera > figure{
			float: left;
			margin-left: 0px;
			width: 50%;
		}
		#total{
			display: inline-block;
			float: right;
		}
		#cabeceraCliente{
			float: left;
			width: 48%;
			border: 1px solid black;
			border-radius: 10px;
			padding: 3px;
		}
		#cabeceraCliente > table {
			width: 100%;
			border-collapse: collapse;
			font-size: small;
		}
		#cabeceraCliente caption {
			font-weight: bold;
			font-size: small;
		}
		#cabeceraPago{
			float: right;
			width:48%;
			border: 1px solid black;
			border-radius: 10px;
			padding: 3px;
		}
		#cabeceraPago > table{
			width: 100%;
			border-collapse: collapse;
			font-size: small;
		}
		#cabeceraPago caption {
			font-weight: bold;
			font-size: small;
		}

		.nombreCampo{
			font-weight: bold;
		}
		
		#deudasAfectadas{
			margin-top: 3px;
			float: left;
			width: 100%;
			padding: 4px;
		}
		#deudasAfectadas > table{
			width: 100%;
			border-collapse: collapse;
			font-size: small;
		}
		#deudasAfectadas table td:nth-child(4), #deudasAfectadas table td:nth-child(3) {
			text-align: right;
			font-weight: bold;
		}
		#deudasAfectadas table td:nth-child(4)::before, #deudasAfectadas table td:nth-child(3):before, td:nth-child(4):before  {
			content: "$ ";
			text-align: right;
		}
		#deudasAfectadas table td:nth-child(5), #deudasAfectadas table td:nth-child(6) {
			text-align: right;
		}
		#detallePagos{
			margin-top: 3px;
			float: left;
			width: 100%;
			padding: 4px;
		}
		#detallePagos > table{
			width: 100%;
			border-collapse: collapse;
			font-size: small;
		}
		#detallePagos table td:last-child {
			text-align: right;
			font-weight: bold;	
		}

		@media print {
			.page-break { 
                            display: block; 
                            page-break-before: always; 
			}
                        @page { size:A4 landscape; border: 1px solid black; }
			#contenedor{
				width: 60%;
				margin: 0 auto;
				font-family: "Arial";
			}	

			#cabeceraCliente td:last-child {
				font-size: x-small;
			}
			#cabeceraPago td:last-child {
				font-size: x-small;
			}
		}
	</style>
<body>
	<div id="contenedor">
		<div><font color='red'>ESTE ES UN DOCUMENTO NO AUTORIZADO, USAR S&Oacute;LO POR REFERENCIA.</font></div>
		<section id="cabecera">
			<figure id="logo">
				<img src="{ruta_logoEmpresa}" alt="" style="width: 100%; height: 100%"/>
			</figure>
			<h2>{total}</h2>
		</section>
		<section id="cabeceraCliente">
			<table border="0">
				<caption>Información del cliente</caption>
				<tbody>
					<tr>
						<td class="nombreCampo">Código:</td>
						<td>{codigoCliente}</td>
					</tr>
					<tr>
						<td class="nombreCampo">Nombres</td>
						<td>{nombresCliente}</td>
					</tr>
					<tr>
						<td class="nombreCampo">Identificación:</td>
						<td>{identificacionCliente}</td>
					</tr>
				</tbody>
			</table>
		</section>
		<section id="cabeceraPago">
			<table border="0">
				<caption>Información del pago</caption>
				<tbody>
					<tr>
						<td class="nombreCampo">Código</td>
						<td>{codigoPago}</td>
					</tr>
					<tr>
						<td class="nombreCampo">Fecha</td>
						<td>{fechaEmision}</td>
					</tr>
					<tr>
						<td class="nombreCampo">Cajero</td>
						<td>{nombreUsuario}</td>
					</tr>
				</tbody>
			</table>
		</section>
		<section id="deudasAfectadas">
			{tabla_deudasAfectadas}
		</section>
		<section id="detallePagos">
			{tabla_detallePagos}
		</section>
	</div>
</body>
</html>