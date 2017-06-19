<?	
	require_once('../../../framework/tcpdf/tcpdf.php');
	require_once('../../../Framework/funciones.php');

	class MYPDF extends TCPDF 
	{	private $codigo;
		private $nombre;
		private $apellido;
		private $curso;
		private $periodo;
		private $foto;
		
		public function Header() 
		{	
		}
		public function Footer()
		{	
		}
	}

	/*Conexión a la BD*/
	$serverName = "certuslinks.com";
	$db = "Educalinks_liceonavalvesp";
	$uid = "sa";
	$pwd = "$3cur!ty@@";
	$charset = "UTF-8";
	$connectionInfo = array("Database"=>$db, "UID"=>$uid, "PWD"=>$pwd, "CharacterSet"=>$charset);
	$conn = sqlsrv_connect($serverName, $connectionInfo);
	if(!$conn)
	{	echo "La conexión no se pudo establecer.<br/>";
		die( print_r( sqlsrv_errors(), true));
	}

	if(isset($_GET['id']))
		$pago_codi = $_GET['id'];

	$params = array($pago_codi);
	$sql="{call str_consultaInformacionPago(?)}";
	$pago_info = sqlsrv_query($conn, $sql, $params);
	$datosPago = sqlsrv_fetch_array($pago_info);

	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='estado_cuenta.pdf'");

	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator("Sistema académico Educalinks");
	$pdf->SetAuthor("Sistema académico Educalinks");
	$pdf->SetTitle("Estado de cuenta");
	$pdf->SetSubject("Estado de cuenta");
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	$codigoAlumno = $_GET["codigoAlumno"];
	$codigoPeriodo = $_GET["codigoPeriodo"];
	$fechaInicio = NULL; //substr($_GET["fechaInicio"], 6, 4).substr($_GET["fechaInicio"], 3, 2).substr($_GET["fechaInicio"], 0, 2) ;
	$fechaFin = NULL; //substr($_GET["fechaFin"], 6, 4).substr($_GET["fechaFin"], 3, 2).substr($_GET["fechaFin"], 0, 2) ;
	
	//http://moderna.educalinks.com.ec/admin/estado_cuenta/r_pago_app.php?codigoAlumno=2008300621&codigoPeriodo=11
	
	$params = array( $codigoAlumno, $codigoPeriodo, $fechaInicio, $fechaFin );
	$sql="{call str_consultaCabeceraEstadoCuenta(?,?,?,?)}";
	$cabecera_info = sqlsrv_query($conn, $sql, $params);
	$deudas = sqlsrv_fetch_array( $cabecera_info );
	
	$codigoAlumno = $deudas["codigoAlumno"];
	$nombresAlumno = $deudas["nombreAlumno"];
	$periodoInicial = $deudas["periodo"];
	if((strlen($_GET["fechaInicio"]) == 10) && (strlen($_GET["fechaFin"]) == 10))
		$desc_periodo = 'PERIODO del '.$_GET["fechaInicio"].' a '.$_GET["fechaFin"].'.';
	else
	{
		if (strlen($_GET["codigoPeriodo"]) > 0 )
			$desc_periodo = 'PERIODO '.$periodoInicial.'.';
		else
			$desc_periodo = 'REPORTE HISTORIAL COMPLETO.';
	}
	$params = array();
	$sql="{call str_consultaDatosInstitucion_info()}";
	$datosInst_info = sqlsrv_query($conn, $sql, $params);
	$datosInsT = sqlsrv_fetch_array($datosInst_info);
	
	$contador = 1;
	$pdf->AddPage();
	$tabla = '
			 <table border="0" >
				<tr style="text-align:center;">
				  <td width="30%" style="text-align:left;vertical-align:top;">
					<span style="font-size:18px;"><strong>'.$datosInsT['empr_razonSocial'].'</strong></span><br>
					<span style="font-size:10px;"><strong>RUC:</strong> '.$datosInsT['empr_ruc'].'</span><br>
					<span style="font-size:10px;"><strong>Dirección:</strong> '.$datosInsT['empr_direccionMatriz'].'</span><br>
					<span style="font-size:10px;"><strong>Telf.:</strong> '.$datosInsT['empr_contactoTelefono'].'</span>
				  </td>
				  <td width="40%" style="vertical-align:top;"><strong>ESTADO DE CUENTA<BR>ESTUDIANTE</strong></td>
				  <td width="30%" style="text-align:right;vertical-align:top;font-size:10px;"><strong>'.$desc_periodo.'</strong>
					<br>
					<br>
					<span style="font-size:large"><b>Total Deuda:</b></span>
					<br>
					<span style="font-size:x-large"><b>${deud_totalpendiente}</b></span>
				  </td>
				</tr>
			 </table></br><div /></br>'; //print_usua_info es llamado desde funciones.php.
	
	$params = array( $codigoAlumno, $codigoPeriodo );
	$sql="{call str_consultadatosadicionalesalumno_info(?,?)}";
	$cliente_info = sqlsrv_query($conn, $sql, $params);
	$cliente_da = sqlsrv_fetch_array( $cliente_info );
	
	$tabla.= '<table width="100%" style="font-size:xx-small;" border="0">
			  <tr>
				<td width="9%"><b>Cliente: </b></td>
				<td width="41%">'.$cliente_da['nombretitular'].'</td>
				<td width="9%"><b>Cédula: </b></td>
				<td width="10%">'.$cliente_da['cedulatitular'].'</td>
				<td width="12%"><b>Curso: </b></td>
				<td width="19%">'.$cliente_da['nombreCurso'].'</td>
			  </tr>
			  <tr>
				<td><b>Alumno: </b></td>
				<td>'.$nombresAlumno.'</td>
				<td><b>Código: </b></td>
				<td>'.$codigoAlumno.'</td>
				<td><b>Grupo econ.: </b></td>
				<td >'.$cliente_da['nombreGrupoEconomico'].'</td>
			  </tr>
			  <tr>
				<td><b>Dirección: </b></td>
				<td >'.$cliente_da['direcciontitular'].'</td>
				<td><b>Teléfono: </b></td>
				<td >'.$cliente_da['telefonotitular'].'</td>
				<td><b>Nivel econ.: </b></td>
				<td >'.$cliente_da['nombreNivelEconomico'].'</td>
			  </tr>
			</table>';
	$c_head = 0;
	$deuda_totalPendiente = 0;
	$detalle = "";
	while ( $deuda = sqlsrv_fetch_array( $cabecera_info ) )
	{	$detalle.= '<style>
					table{
						font-size:small;
					}
					.tituloPeriodo{
						background-color:#F5ECCE;
						font-size:xx-small;
					}
					.tituloDeuda{
						background-color:#FAFAFA;
						text-align:center;
					}
					.cabeceraDeuda{
						text-align:center; 
						font-weight: bold;
						font-size: 8px;
						background-color:#F6E3CE;
					}
					.detalleDeuda{
						text-align: center;
						background-color:#FBF5EF;
					}
					.tituloPago{
						text-align:center; 
						margin-top:0px;
						padding:0px;
						background-color:#FBF5EF;
					}
					.cabeceraPago{
						background-color:#CEE3F6;
					}
					.detallePago{
						background-color:#EFF5FB;
					}
					</style>';
		if($c_head == 0 )
		{	$c_head++;
		}
		
		$detalle .= '<table width="650px" border="0">';
		if( ( strlen( $_GET["codigoPeriodo"] ) == 0 ) || ( $_GET["codigoPeriodo"] == -1 ) )
		{   $detalle .= ' <tr class="tituloPeriodo">
						<td>Periodo</td>
						<td colspan="8">'.$deuda["periodo"].'</td>
					  </tr>';
		}
		/*$detalle .= '<tr class="tituloDeuda" >
						<td colspan="9" >Deudas</td>
					  </tr>';   */
		$detalle .=  '
				  <tr class="cabeceraDeuda">
					<td>F. inicio Cobro</td>
					<td>Producto</td>
					<td>T. Inicial</td>
					<td>T. N/C</td>
					<td>Descuento</td>
					<td>T. IVA</td>
					<td>T. Abonado</td>
					<td>T. Pdte.</td>
					<td>Estado</td>
				  </tr>
				  <tr class="detalleDeuda" >
					<td><div style="font-size:small">'.$deuda["fechaInicioCobro"].'</div></td>
					<td><div style="font-size:small">'.$deuda["descripcionDeuda"].'</div></td>
					<td>$ '.$deuda["totalInicial"].'</td>
					<td>$ '.$deuda["totalNotaCredito"].'</td>
					<td>$ '.$deuda["descuentofacturas"].'</td>
					<td>$ '.$deuda["totalIVA"].'</td>
					<td>$ '.$deuda["totalAbonado"].'</td>
					<td>$ '.$deuda["totalPendiente"].'</td>
					<td><strong>'.$deuda["estado"].'</strong></td>
				  </tr>
				  <tr>
					<td colspan="4"></td>
					<td class="tituloPago" colspan="6" >Pagos</td>
				  </tr>';
		
		$deuda_totalPendiente = $deuda_totalPendiente + $deuda["totalPendiente"];

		$detalle .='<tr>
					<td colspan="5"></td>
					<td colspan="6" style="text-align: center;" >
					  <table border="0" width="100%">
						<tr border="1" class="cabeceraPago" >
						  <td>N°</td>
						  <td>Fecha</td>
						  <td>Pago</td>
						  <td>Forma pago</td>
						  <td>Cajero</td>
						</tr>        
		';
		
		$params = array( $deuda["codigoDeuda"] );
		$sql="{call str_consultaDetalleEstadoCuenta(?)}";
		$pago_info = sqlsrv_query($conn, $sql, $params);
		//$datosPago = sqlsrv_fetch_array($pago_info);
		
		$bandera_pago = 0;
		while ($rows_pago=sqlsrv_fetch_array($pago_info))
		{	$detalle .= '<tr class="detallePago" >
								<td>'.$rows_pago["secuencial"].'</td>
								<td>'.$rows_pago["fechaPago"].'</td>
								<td>$ '.$rows_pago["totalPago"].'</td>
								<td>'.$rows_pago["formaPago"].'</td>
								<td>'.$rows_pago["usuario"].'</td>
							  </tr>';
			$bandera_pago++;
		}
		if( $bandera_pago == 0 )
		{   $detalle .= '<tr class="detallePago" >
								<td colspan="5">- Sin pagos realizados -</td>
							  </tr>';
		}
			$detalle .= '</table></td></tr>
			  ';
		$detalle .= '</table>';
	}
	$tabla = str_replace ( '{deud_totalpendiente}', number_format( $deuda_totalPendiente, 2 ), $tabla );
	$pdf->writeHTML($tabla, true, false, true, false, '');
	$pdf->writeHTML($detalle, true, false, true, false, '');
	$pdf->Output('estado_cuenta.pdf', 'I');
?>