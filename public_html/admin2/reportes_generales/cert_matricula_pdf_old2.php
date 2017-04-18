<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='certificado_matricula.pdf'");
	session_start();
	
	require_once ('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php');
	require_once ('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$ciudad_mayus = str_replace("ó","Ó",strtoupper($ciudad));
	$nombre_colegio = strtoupper(para_sist(53));
	$antes_del_nombre = para_sist(36);
			
	$sql="{call cert_matricula_cons(?,?)}";
	$params = array($_GET['curso_paralelo'], $_GET['alumno']);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis_long'];
			$this->Image($logo_minis, 10, 10, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_distr = '../'.$_SESSION['ruta_foto_escudo_ecuador'];
			$this->Image($logo_distr, 170, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}

		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
		}
	}
		 
	$pdf = new MYPDF('PORTRAIT', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		// Añadir página
		$pdf->AddPage();
		$fecha_matricula=date_format($alumno["fecha"], "d/m/y");
		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_TIME, 'spanish');
		$fecha_hoy=strftime("$ciudad, %d de %B de %Y");
		
		$texto_titulo="";
		if($alumno['tit_deta']=='CIENCIAS'){
			if (($_SERVER['HTTP_HOST']=="liceopanamericano.educalinks.com.ec") or ($_SERVER['HTTP_HOST']=="liceopanamericanosur.educalinks.com.ec"))
			{
				$texto_titulo='<tr>
							<td class="texto_info"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info" colspan="3" width="100%">'.$alumno['curs_deta'].' '.$alumno['nive_deta'].' "'.$alumno['para_deta'].'"</td>
							</tr>';
			}
			else
			{
			$texto_titulo='<tr>
							<td class="texto_info"><strong>Tipo de Título:</strong></td>
							<td class="texto_info">'.$alumno["tit_tipo_deta"].'</td>
							<td class="texto_info"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info">'.$alumno["curs_deta"].' "'.$alumno["para_deta"].'" '.'</td>
						</tr>
						<tr>
							<td class="texto_info"><strong>Título:</strong></td>
							<td class="texto_info">'.$alumno["tit_deta"].'</td>
							<td class="texto_info"></td>
							<td class="texto_info"></td>
						</tr>';
			}
		}else{
			if (($_SERVER['HTTP_HOST']=="liceopanamericano.educalinks.com.ec") or ($_SERVER['HTTP_HOST']=="liceopanamericanosur.educalinks.com.ec"))
			{
				$texto_titulo='<tr>
							<td class="texto_info"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info" colspan="3" width="100%">'.$alumno['curs_deta'].' '.$alumno['nive_deta'].' "'.$alumno['para_deta'].'"</td>
							</tr>';
			}
			else
			{
				$texto_titulo='<tr>
							<td class="texto_info"><strong>Nivel de Educación:</strong></td>
							<td class="texto_info">'.$alumno["nive_deta"].'</td>
							<td class="texto_info"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info">'.$alumno["curs_deta"].'</td>
						</tr>';
			}
		}
		
		$tbl=<<<EOF
		<style>
		.titulo
		{	letter-spacing: 2px;
			text-align: center;
			font-size: 18px;
			font-weight: bold;
			font-family: sans-serif;
		}
		.subtitulo
		{	text-align: center;
			font-size: 16px;
			font-family: sans-serif;
		}
		.texto
		{	font-size: 12px;
			text-align:justified;
			letter-spacing: 1px;
			line-height: 200%;
			font-family: sans-serif;
		}
		.texto_info
		{	font-size: 12px;
			text-align:justified;
			line-height: 100%;
			font-family: sans-serif;
		}
		.firma
		{	font-size: 12px;
			font-weight: bold;
			text-align: center;
			font-family: sans-serif;
		}
		</style>
		<table width="100%" border="0">
			<tr>
				<td colspan="2" class="titulo"><br/><br/><br/>CERTIFICADO DE MATRÍCULA</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo"><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo"><br/>{$antes_del_nombre} <br/>"{$nombre_colegio}"</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo"><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo"><br/>{$ciudad_mayus} - ECUADOR</td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr>
							<td class="texto_info" width="27%"><strong>Año lectivo:</strong></td>
							<td class="texto_info" width="23%">{$alumno["periodo"]}</td>
							<td class="texto_info" width="20%"><strong>Nº matrícula:</strong></td>
							<td class="texto_info" width="30%">{$alumno["folio"]}</td>
						</tr>
						{$texto_titulo}
						<tr>
							<td class="texto_info"><strong>Fecha:</strong></td>
							<td class="texto_info" colspan="3">{$fecha_hoy}</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					<p>Quien suscribe, {$etiqueta_rector} y {$etiqueta_secretario}, certifica que el(a) estudiante:</p>
					<p align="center"><b>{$alumno["apellidos"]} {$alumno["nombres"]}</b></p>
					<p>Previo al cumplimiento de los requisitos legales, se matriculó en el curso indicado 
					según consta en los registros de matrículas que reposan en esta institución.</p>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br/><br/><br/><br/></td>
			</tr>
			<tr>
				<td align="center" class="firma">
					__________________________________<br/>
					{$rector}<br/>
					{$etiqueta_rector}
				</td>
				<td align="center" class="firma">
					__________________________________<br/>
					{$secretario}<br/>
					{$etiqueta_secretario}
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('cert_matricula.pdf', 'I');
?>
