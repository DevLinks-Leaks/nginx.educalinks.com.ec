<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_claves_usuarios.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	
	$curs_para_codi = $_GET['curs_para_codi'];
		
	$sql="{call alum_curs_para_view(?)}";
	$params = array($curs_para_codi);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	$sql="{call curs_para_info(?)}";
	$params = array($curs_para_codi);
	$stmt_curs = sqlsrv_query($conn, $sql, $params);

	if( $stmt_curs === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	$curs_info = sqlsrv_fetch_array($stmt_curs);

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			
		}
	
		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
	 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$fecha_hoy=date("d/m/y");
	$alumnos = '<table width="100%">';
	$alumnos.='<tr class="cabecera">';
	$alumnos.='<td width="10%">CÓDIGO</td>';
	$alumnos.='<td width="25%">APELLIDOS</td>';
	$alumnos.='<td width="25%">NOMBRES</td>';
	$alumnos.='<td width="20%">USUARIO</td>';
	$alumnos.='<td width="20%">CLAVE</td>';
	$alumnos.="</tr>";
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.="<td>".$alumno['alum_codi']."</td>";
		$alumnos.="<td>".$alumno['alum_apel']."</td>";
		$alumnos.="<td>".$alumno['alum_nomb']."</td>";
		$alumnos.="<td>".$alumno['alum_usua']."</td>";
		$alumnos.="<td>".$alumno['alum_pass']."</td>";
		$alumnos.="</tr>";
	}
	$alumnos.= "</table>";
	
	$pdf->AddPage();
	
	$tbl=<<<EOF
	<style>
	h1
	{
		font-size: 16px;
		text-align: center;
	}
	h2
	{
		font-size: 12px;
		text-align: center;
	}
	h3
	{
		font-size: 10px;
		text-align: left;
	}
	table tr td
	{
		border: solid 1px black;
	}
	.cabecera
	{
		background-color: #D0C8C8;
		font-size: 11px;
		font-weight: bold;
	}
	.centrar
	{
		text-align: center;
	}
	.contenedor
	{
		width: 100%;
	}
	.letras_pequenas
	{
		font-size: 10px;
		text-align: justify;
	}
	</style>
	<div class="contenedor">
		<h1>USUARIOS Y CLAVES DE ALUMNOS</h1>
		<h2>{$curs_info['nive_deta']} - {$curs_info['curs_deta']}</h2>
		<h2>AÑO LECTIVO {$_SESSION['peri_deta']}</h2>
		<h3>{$fecha_hoy}</h3>
		{$alumnos}
	</div>
EOF;
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output('cert_claves_usuarios.pdf', 'I');
?>
