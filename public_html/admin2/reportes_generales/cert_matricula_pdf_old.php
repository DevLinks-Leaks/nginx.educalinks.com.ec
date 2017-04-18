<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='certificado_matricula.pdf'");
	session_start();
	
	require_once ('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php');
	include ('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
			
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
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis'];
			$this->Image($logo_minis, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_distr = '../'.$_SESSION['ruta_foto_logo_distr'];
			$this->Image($logo_distr, 180, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}

		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
		}
	}
		 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
		$fecha_hoy=date("d/m/y");
		$tbl=<<<EOF
		<style>
		.titulo
		{
			letter-spacing: 5px;
			text-align: center;
			font-size: 24px;
			font-weight: bold;
			font-family: sans-serif;
		}
		.subtitulo
		{
			text-align: center;
			font-size: 16px;
			font-family: sans-serif;
		}
		.texto
		{
			font-size: 16px;
			text-align:justified;
			letter-spacing: 2px;
			line-height: 200%;
			font-family: sans-serif;
		}
		.firma
		{
			font-size: 12px;
			font-weight: bold;
			text-align: center;
			font-family: sans-serif;
		}
		</style>
		<table width="650" border="0">
			<tr>
				<td colspan="2" align="center">
					<img src="../{$_SESSION['ruta_foto_logo_web']}" width="100" height="120"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">UNIDAD EDUCATIVA</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">{$_SESSION['cliente']}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">CERTIFICADO DE MATRICULA</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">AÑO LECTIVO: {$alumno["periodo"]}</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">MATRÍCULA Nº {$alumno["matricula"]}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">CERTIFICO: </td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					<p>Que el estudiante <b>{$alumno["apellidos"]} {$alumno["nombres"]}</b> 
					ha sido matriculado en {$alumno["detalle"]} de este Plantel con fecha 
					{$fecha_matricula}, previo al cumplimiento de los requisitos legales y reglamentarios.</p>
					<p>Así consta en el folio Nº {$alumno["folio"]} del libro de Matrículas.</p>
					<p>Guayaquil, {$fecha_hoy}</p>
					<br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td align="center" class="firma">
					__________________________________<br/>
					{$rector}<br/>
					Rector(a)
				</td>
				<td align="center" class="firma">
					__________________________________<br/>
					{$secretario}<br/>
					Secretario(a)
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('cert_matricula.pdf', 'I');
?>
