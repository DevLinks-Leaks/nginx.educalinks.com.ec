<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='listado_alumnos.pdf'");
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once('../../framework/dbconf.php');	
	require_once('../../framework/funciones.php');	
	
	if (isset($_GET['curs_para_codi']))
	{	$curs_para_codi=$_GET['curs_para_codi'];
	}
	else
	{	$curs_para_codi=0;
	}

	if (isset($_GET['curs_para_mate_prof_codi']))
	{	$curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
	}
	else
	{	$curs_para_mate_prof_codi=0;
	}
	
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);

	class MYPDF extends TCPDF 
	{	public function Header() 
		{	//$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			//$this->Image($logo_web, 100, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
	
		public function Footer() 
		{	$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Usuario que imprimió: '.strtoupper($_SESSION["usua_codi"]).'     Fecha/Hora impresión: '.date("d/m/Y H:m").'     Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
	 
	$pageDimension = array('500,300');
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$params = array($curs_para_mate_prof_codi);
	$sql="{call curs_para_prof_alums_view(?)}";
	$stmt = sqlsrv_query($conn, $sql, $params);
	
	$tbl_lista='<table border="1" cellpadding="0" cellspacing="0" align="center" width="100%">';
	$tbl_lista.="<tr>";
	$tbl_lista.='<td class="encabezados" width="5%">N°</td>';
	$tbl_lista.='<td class="encabezados" width="10%">CODALUM</td>';
	$tbl_lista.='<td class="encabezados" valign="baseline" width="40%">APELLIDOS Y NOMBRES</td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='<td class="encabezados" width="5%"></td>';
	$tbl_lista.='</tr>';
	$i=1;
	while ($row = sqlsrv_fetch_array($stmt))
	{	$tbl_lista.="<tr>";
		$tbl_lista.='<td class="texto" width="5%"> '.$i.'</td>';
		$tbl_lista.='<td class="texto" width="10%"> '.$row["alum_codi"].'</td>';
		$tbl_lista.='<td class="texto" width="40%"> '.$row["alum_apel"]." ".$row["alum_nomb"].'</td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='<td class="texto" width="5%"></td>';
		$tbl_lista.='</tr>';
		$i++;
	}
	$tbl_lista.='</table>';
	
	$params = array($curs_para_mate_prof_codi);
	$sql="{call curs_para_mate_prof_info(?)}";
	$stmt = sqlsrv_query($conn, $sql, $params);
	$row = sqlsrv_fetch_array($stmt);
    $jornada = $row['jorn_deta'];
	/*Tabla con información general*/
	$tbl_info='<table width="100%">';
	$tbl_info.='<tr>';
	$tbl_info.='<td rowspan="6" width="10%"><img width="50" src="../'.$_SESSION['ruta_foto_logo_web'].'" /></td>';
	$tbl_info.='<td colspan="2" class="titulos" width="90%">'.para_sist(36).' '.para_sist(3).'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">NÓMINA DE ESTUDIANTES</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">'.$row['curs_deta'].' DE '.$row['nive_deta'].', PARALELO: '.$row['para_deta'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">AÑO LECTIVO '.$_SESSION['peri_deta'].' ('.$jornada.')</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">PROFESOR: '.$row['prof_apel'].' '.$row['prof_nomb'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">MATERIA: '.$row['mate_deta'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='</table>';
		
	$tbl=<<<EOF
	<style>
	.encabezados
	{
		text-align: center;
		font-family: sans-serif;
		font-size: 10px;
		font-weight: bold;
		line-height: 200%;
	}
	.texto
	{
		font-size: 10px;
		text-align: left;
		line-height: 160%;
		font-family: sans-serif;
	}
	.titulos
	{
		text-align: left;
		font-family: sans-serif;
		font-size: 12px;
		font-weight: bold;
	}
	.calificaciones
	{
		font-size: 10px;
		text-align: center;
		line-height: 130%;
		font-family: sans-serif;
	}
	.firma
	{
		font-size: 10px;
		font-weight: bold;
		text-align: center;
		font-family: sans-serif;
	}
	</style>
	<br/><br/>
	{$tbl_info}
	<br/><br/><br/>
	{$tbl_lista}
EOF;
	$pdf->AddPage();
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output('listado_alumnos.pdf', 'I');
?>