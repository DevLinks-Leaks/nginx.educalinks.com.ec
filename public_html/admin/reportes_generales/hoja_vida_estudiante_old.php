<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='ficha_estudiante.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php');

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_web, 13, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->MultiCell(160, 5, '', 0, 'C', 0, 1, '', '', true);
			$this->MultiCell(180, 5, para_sist(3), 0, 'C', 0, 1, '', '', true);
			$this->MultiCell(180, 5, 'AÑO LECTIVO '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);
			$this->MultiCell(180, 5, 'HOJA DE VIDA ESTUDIANTIL', 0, 'C', 0, 1, '', '', true);
		}

		public function Footer()
		{
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
	$pdf->AddPage();

	$alum_curs_para_codi = $_GET['alum_curs_para_codi'];

	/*Datos del estudiante*/
	$params = array($alum_curs_para_codi);
	$sql = "{call alum_info_curs_para(?)}";
	$stmt = sqlsrv_query($conn, $sql,$params);
	if ( $conn === false)
	{
		echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
	}
	$row_alum_info = sqlsrv_fetch_array($stmt);

	/*Historial de observaciones*/
	$params = array($alum_curs_para_codi);
	$sql = "{call observacion_alum_info(?)}";
	$stmt = sqlsrv_query($conn, $sql,$params);
	if( $conn === false)
	{
		echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
	}

	$tabla_historial=
		'
			<table border="1" width="650" cellpadding="100%">
				<thead>
					<tr>
						<th class="etiquetas_historial" width="15%">Tipo Observación</th>
						<th class="etiquetas_historial" width="45%">Observación</th>
						<th class="etiquetas_historial" width="20%">Ingresado por</th>
						<th class="etiquetas_historial" width="10%">Rol</th>
						<th class="etiquetas_historial" width="10%">Fecha</th>
					</tr>
				</thead>
				<tbody>
		';
	while ($row_historial=sqlsrv_fetch_array($stmt))
	{
		$tabla_historial .=
			'
					<tr>
						<td class="historial_registro" width="15%">'.$row_historial['obse_tipo_deta'].'</td>
						<td class="historial_registro" width="45%">'.$row_historial['obse_deta'].'</td>
						<td class="historial_registro" width="20%">'.$row_historial['usua_deta'].'</td>
						<td class="historial_registro" width="10%">'.$row_historial['usua_tipo'].'</td>
						<td class="historial_registro" width="10%">'.date_format($row_historial['obse_fech'],'d-m-Y').'</td>
					</tr>
			';
	}
	$tabla_historial.=
		'
				</tbody>
			</table>
		';
	/*Foto alumno*/
	$alum_foto_ruta = '../'.$_SESSION['ruta_foto_alumno'].$row_alum_info["alum_codi"].".jpg";
	if (!file_exists($alum_foto_ruta))
		$alum_foto_ruta = '../'.$_SESSION['foto_default'];

	$ncto = date_format($row_alum_info["alum_fech_naci"], "d/m/Y");
	$tbl=<<<EOF
	<style>
	.etiquetas
	{
		font-weight: bold;
		font-size: 10px;
		text-align:justified;
		font-family: sans-serif;
	}
	.etiquetas_historial
	{
		background-color: #66B2FF;
		font-weight: bold;
		font-size: 10px;
		text-align:justified;
		font-family: sans-serif;
	}
	.datos_personales
	{
		font-size: 10px;
		text-align:justified;
		line-height: 130%;
		font-family: sans-serif;
	}
	.historial_registro
	{
		font-size: 9px;
		text-align:justified;
		line-height: 130%;
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
	<br/><br/><br/>
	<table width="650" border="0">
		<tr>
			<td width="25%" class="etiquetas">Código:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["alum_codi"]}</td>
			<td width="25%" class="cuadro_foto" rowspan="7" align="right"><img src="{$alum_foto_ruta}" border="0" height="80" width="80" align="top" /></td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Nombres:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["alum_nomb"]}</td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Apellidos:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["alum_apel"]}</td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Domicilio:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["alum_domi"]}</td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Teléfono:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["alum_telf"]}</td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Curso:</td>
			<td width="50%" class="datos_personales">{$row_alum_info["curs_deta"]}, Paralelo: {$row_alum_info["para_deta"]}</td>
		</tr>
		<tr>
			<td width="25%" class="etiquetas">Fecha de nacimiento:</td>
			<td width="50%" class="datos_personales">{$ncto}</td>
		</tr>
	</table>
	<br/><br/>
	{$tabla_historial}
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		$pdf->Output('hoja_vida_estudiantil.pdf', 'I');
?>
