<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='notas_ingresadas.pdf'");
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once('../../framework/EnLetras.php');
	require_once('../../framework/dbconf.php');	
	require_once('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
	$jornada = para_sist(35);

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			//$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			//$this->Image($logo_web, 100, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
	
		public function Footer() 
		{
			$this->SetY(-15);
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
	
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
	
	$params = array($curs_para_mate_codi);
	$sql="{call curs_para_mate_info_NEW(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params);
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
	
	$params = array($peri_dist_codi,$curs_para_mate_codi);
	$sql="{call peri_dist_padr_view_NEW(?,?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params);
	
	$params = array($curs_para_mate_codi,$peri_dist_codi);
	$sql="{call curs_para_nota_peri_dist_view_NEW(?,?)}";
	$curs_para_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params);
	$row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view);
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);
	$cab_row=sqlsrv_fetch_array($cab_view);
	
	//Datos del profesor
	$params = array($curs_para_mate_codi);
	$sql="{call prof_curs_para_mate_cons (?)}";
	$dat_profesor = sqlsrv_query($conn, $sql, $params);
	$prof_row=sqlsrv_fetch_array($dat_profesor);
	
	$CC_COLUM=$row_curs_para_nota_peri_dist_view['CC_COLUM'];
	
	sqlsrv_next_result($curs_para_nota_peri_dist_view);
	//sqlsrv_next_result($curs_para_nota_peri_dist_view);
	 
	$cc = 0;
	$CC_COLUM_index=0;
	
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("%d de %B de %Y");
	$nomb_size = 100-($CC_COLUM*6)-8;
	
	$tbl_notas='<table border="1" cellpadding="0" cellspacing="0" align="center" width="100%">';
	$tbl_notas.="<tr>";
	$tbl_notas.='<td class="encabezados" width="3%">N°</td>';
	$tbl_notas.='<td class="encabezados" valign="baseline" width="'.$nomb_size.'%">ALUMNOS</td>';
	
	/*Cabecera de notas*/
	while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))
	{
		$cc +=1;
		$tbl_notas.='<td class="encabezados" width="6%">'.$row_peri_dist_padr_view['peri_dist_abre'].'</td>';
	}
	$tbl_notas.="</tr>";
	$cc =0;
	
	/*Detalle de notas*/
	while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view))
	{
		$cc +=1;
		$tbl_notas.="<tr>";
		$tbl_notas.='<td class="texto"> '.$cc.'</td>';
		$tbl_notas.='<td class="texto"> '.$row_curs_para_nota_peri_dist_view['alum_codi']." - ".$row_curs_para_nota_peri_dist_view['alum_apel']." ".$row_curs_para_nota_peri_dist_view['alum_nomb']."</td>";
		$CC_COLUM_index =0;
		while($CC_COLUM_index <= $CC_COLUM )
		{
			if ($row_curs_peri_info['nota_refe_cab_tipo']=='C')
			{
				$tbl_notas.='<td class="calificaciones">'.truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10])."</td>";
			}
			else
			{
				$tbl_notas.='<td class="calificaciones">'.nota_peri_cual_cons ($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_cod'],$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]).'</td>';
			}
			$CC_COLUM_index+=1;
		}
		$tbl_notas.="</tr>";
	}
	$tbl_notas.="</table>";
	
	/*Tabla con información general*/
	$tbl_info='<table width="100%">';
	$tbl_info.='<tr>';
	$tbl_info.='<td rowspan="5" width="10%"><img width="50" src="../'.$_SESSION['ruta_foto_logo_web'].'" /></td>';
	$tbl_info.='<td colspan="2" class="titulos" width="90%">'.para_sist(36).' '.para_sist(3).'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">INFORMACIÓN DE APRENDIZAJES DEL '.$cab_row['nivel_1'].' '.$cab_row['nivel_2'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">'.$row_curs_peri_info['curs_deta'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">ASIGNATURA: '.$row_curs_peri_info['mate_deta'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='<tr>';
	$tbl_info.='<td class="titulos" colspan="2">AÑO LECTIVO '.$_SESSION['peri_deta'].'</td>';
	$tbl_info.='</tr>';
	$tbl_info.='</table>';
	
	/*Firmas*/
	$tbl_firmas='<table width="100%">';
	$tbl_firmas.='<tr>';
	$tbl_firmas.='<td class="firma" width="50%">_______________________________________</td>';
	$tbl_firmas.='<td class="firma" width="50%">_______________________________________</td>';
	$tbl_firmas.='</tr>';
	$tbl_firmas.='<tr>';
	$tbl_firmas.='<td class="firma" width="50%">PROF. '.$prof_row["prof_nomb"]." ".$prof_row["prof_apel"].'</td>';
	$tbl_firmas.='<td class="firma" width="50%">'.para_sist(6).'</td>';
	$tbl_firmas.='</tr>';
	$tbl_firmas.='<tr>';
	$tbl_firmas.='<td class="firma" width="50%">Profesor</td>';
	$tbl_firmas.='<td class="firma" width="50%">'.para_sist(34).'</td>';
	$tbl_firmas.='</tr>';
	$tbl_firmas.='</table>';
		
	$tbl=<<<EOF
	<style>
	.encabezados
	{
		text-align: center;
		font-family: sans-serif;
		font-size: 8px;
		font-weight: bold;
		line-height: 150%;
	}
	.texto
	{
		font-size: 10px;
		text-align: left;
		line-height: 130%;
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
	{$tbl_info}
	<br/><br/>
	{$tbl_notas}
	<br/><br/><br/><br/>
	{$tbl_firmas}
EOF;
	$pdf->AddPage();
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output('notas_ingresadas.pdf', 'I');
	//echo htmlentities($tbl);
?>