<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_asistencia.pdf'");
	
	session_start();
	require_once('../../framework/tcpdf/tcpdf.php');
	include ('../../framework/dbconf.php');	
	include ('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
	
	$sql="{call cert_asistencia_cons(?,?)}";
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
			$logo_cole = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_cole, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_escudo = '../'.$_SESSION['ruta_foto_escudo_ecuador'];
			$this->Image($logo_escudo, 180, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
	
		public function Footer() 
		{
			
		}
	}
	 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		$pdf->AddPage();
		
		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_TIME, 'spanish');
		$fecha_hoy=strftime("$ciudad, %d de %B de %Y");
		$tbl=<<<EOF
		<style>
		.titulo
		{
			letter-spacing: 2px;
			text-align: center;
			font-size: 16px;
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
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">{$antes_del_nombre}</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">{$nombre_colegio}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">CERTIFICADO DE ASISTENCIA</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">AÑO LECTIVO: {$alumno["periodo"]}</td>
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
					<p>Que el estudiante <b>{$alumno["apellidos"]} {$alumno["nombres"]},</b> 
					del {$alumno["detalle"]}, {$alumno["resultado"]} en el presente periodo lectivo.</p>
					<p>{$fecha_hoy}</p>
				</td>
			</tr>
			<tr>
			<td colspan="2"><br/><br/><br/><br/><br/></td>
			</tr>
			<tr>
				<td align="center" class="firma" colspan="2">
					__________________________________<br/>
					{$secretario}<br/>
					{$etiqueta_secretario}
				</td>
			</tr>
		
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('cert_asistencia.pdf', 'I');
?>
