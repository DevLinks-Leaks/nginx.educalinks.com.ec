<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_claves_usuarios.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php');
	require_once ('../../framework/funciones.php'); 
	
	$fecha_hoy=date("d/m/y");
	$clie_nomb = para_sist(3);
	
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
			/*$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_web, 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->MultiCell(150, 5, para_sist(3), 0, 'C', 0, 1, '', '', true);
			$this->MultiCell(180, 5, 'AÑO LECTIVO: '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);*/
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
	
	$pdf->SetMargins(35, 5, 0,true);
	$pdf->SetAutoPageBreak(TRUE, 20);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	
	//$pdf->setEqualColumns(2, 200); 

	$pdf->AddPage();
			//$this->MultiCell(150, 5, para_sist(3), 0, 'C', 0, 1, '', '', true);
			//$this->MultiCell(180, 5, 'AÑO LECTIVO: '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);
			//$this->Image($logo_web, 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	
	
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		
		$alumnos .= '<table width="100%" border="1" >';
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>CÓDIGO:</strong></td>';
		$alumnos.="<td> ".$alumno['alum_codi']."</td>";
		$alumnos.="</tr>";
		
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>APELLIDOS:</strong></td>';
		$alumnos.="<td> ".$alumno['alum_apel']."</td>";
		$alumnos.="</tr>";
		
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>NOMBRES:</strong></td>';
		$alumnos.="<td> ".$alumno['alum_nomb']."</td>";
		$alumnos.="</tr>";
		
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>CURSO:</strong></td>';
		$alumnos.="<td> ".strtoupper($curs_info['curs_deta'])."</td>";
		$alumnos.="</tr>";
		
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>PARALELO:</strong></td>';
		$alumnos.="<td> ".strtoupper($curs_info['para_deta'])."</td>";
		$alumnos.="</tr>";

		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>USUARIO:</strong></td>';
		$alumnos.="<td> ".strtoupper($alumno['alum_usua'])."</td>";
		$alumnos.="</tr>";
		
		$alumnos.='<tr class="letras_pequenas">';
		$alumnos.='<td width="20%"><strong>CLAVE:</strong></td>';
		$alumnos.="<td> ".$alumno['alum_pass']."</td>";
		$alumnos.="</tr>";


		$alumnos.= "</table>";

		$alumnos.="<br/>";
		$alumnos.="<br/>";
		
		
		//$pdf->AddPage();
	
		

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
			width: 100%;
		}
		.letras_pequenas
		{
			font-size: 10px;
			text-align: justify;
		}
		</style>
		<div class="contenedor">
			{$alumnos}
			
		</div>
EOF;
		$pdf->writeHTML($tbl, false, false, true, false, '');
	$pdf->Output('cert_claves_usuarios.pdf', 'I');

?>