<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_claves_usuarios.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
	
	$fecha_hoy=date("d/m/y");
	$clie_nomb = para_sist(3);
	
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			//$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			//$this->Image($logo_web, 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			//$this->MultiCell(150, 5, para_sist(3), 0, 'C', 0, 1, '', '', true);
			//$this->MultiCell(180, 5, 'AÑO LECTIVO: '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);
		}

		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
		
	$sql="{call usua_busq(?)}";
	$params = array('');
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);

	$pdf->SetMargins(35, 15, 0,true);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	

	//$pdf->setEqualColumns(2, 100); 

	$pdf->AddPage();
	
	while ($usuario=sqlsrv_fetch_array($stmt))
	{
		$usuarios.= '<table width="100%" border="1">';
		$usuarios.='<tr class="letras_pequenas">';
		$usuarios.='<td width="20%"><strong>APELLIDOS</strong></td>';
		$usuarios.="<td> ".$usuario['usua_apel']."</td>";
		$usuarios.="</tr>";
		
		$usuarios.='<tr class="letras_pequenas">';
		$usuarios.='<td width="20%"><strong>NOMBRES</strong></td>';
		$usuarios.="<td> ".$usuario['usua_nomb']."</td>";
		$usuarios.="</tr>";
		
		$usuarios.='<tr class="letras_pequenas">';
		$usuarios.='<td width="20%"><strong>USUARIO</strong></td>';
		$usuarios.="<td> ".$usuario['usua_codi']."</td>";
		$usuarios.="</tr>";
		
		$usuarios.='<tr class="letras_pequenas">';
		$usuarios.='<td width="20%"><strong>CLAVE</strong></td>';
		$usuarios.="<td> ".$usuario['usua_pass']."</td>";
		$usuarios.="</tr>";
		
		$usuarios.= "</table>";
		
		$usuarios.="<br/>";
		$usuarios.="<br/>";

	}
	$tbl=<<<EOF
		<style>
		table{
		}
		h1
		{
			font-size: 12px;
			text-align: left;
		}
		h2
		{
			font-size: 12px;
			text-align: left;
		}
		.cabecera
		{
			background-color: #D0C8C8;
			font-size: 12px;
			font-weight: bold;
		}
		.centrar
		{
			text-align: center;
		}
		.contenedor
		{
			margin-left:200px;
			width: 100%;
		}
		.letras_pequenas
		{
			font-size: 10px;
			text-align: justify;
		}
		</style>
		<div class="contenedor">
			{$usuarios}
		</div>
EOF;
	$pdf->writeHTML($tbl, true, false, true, false, '');
	$pdf->Output('cert_claves_usuarios.pdf', 'I');
?>
