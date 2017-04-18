<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='ficha_estudiante.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
		
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
		
	$sql1="{call nota_peri_distr_pendiente(?)}";
	$params = array($_GET['peri_dist_codi']);
	$stmt = sqlsrv_query($conn, $sql1, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	class MYPDF extends TCPDF 
	{
		private $nombre_colegio;
		private $antes_del_nombre;
		
		public function Header() 
		{
			$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_web, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->MultiCell(246, 5, $this->antes_del_nombre.' '.$this->nombre_colegio, 0, 'C', 0, 1, '', '', true);
			$this->MultiCell(270, 5, 'AÑO LECTIVO: '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);
		}
	
		public function Footer() 
		{
			
		}
		
		public function SetNombre ($nombre_colegio)
		{
			$this->nombre_colegio=$nombre_colegio;
		}
		
		public function SetAntesNombre ($antes_del_nombre)
		{
			$this->antes_del_nombre=$antes_del_nombre;
		}
	}
	$c=0;
	$alumnos = '<table width="100%">';
	while ($alumno=sqlsrv_fetch_array($stmt))
	{   $color1="background-color:#d3d3d3;";
		$color2="background-color:white;";
		if($c==0)
		{	$cabecera= $alumno['peri_dist_deta_sub']." CORRESPONDIENTE AL ".$alumno['peri_dist_deta'];
			$alumnos.='<tr class="letras_pequenas">';
			$alumnos.="<td width=\"8%\">codigo</td>";
			$alumnos.="<td width=\"25%\">Alumno</td>";
			$alumnos.="<td width=\"20%\">Materia</td>";
			$alumnos.="<td width=\"22%\">Profesor</td>";
			$alumnos.="<td width=\"18%\">Nota Detalle</td>";
			$alumnos.="<td>Curso Paralelo</td>";
			$alumnos.="</tr>";
		}
		$c++;
		if(($c%2)==0)
			$active_color=$color1;
		else
			$active_color=$color2;
		$alumnos.='<tr style="'.$active_color.'">';
		$alumnos.="<td width=\"8%\" style=\"font-size:xx-small;\">".$alumno['alum_codi']."</td>";
		$alumnos.="<td width=\"25%\" style=\"font-size:xx-small;\">".$alumno['alum_nombre']."</td>";
		$alumnos.="<td width=\"20%\" style=\"font-size:xx-small;\">".$alumno['mate_deta']."</td>";
		$alumnos.="<td width=\"22%\" style=\"font-size:xx-small;\">".$alumno['prof_nomb']."</td>";
		$alumnos.="<td width=\"18%\" style=\"font-size:xx-small;\">".$alumno['peri_dist_detalle']."</td>";
		$alumnos.="<td style=\"font-size:xx-small;\">".$alumno['curs_deta']." ".$alumno['para_deta']."</td>";
		$alumnos.="</tr>";
	}
	$alumnos.= "</table>";
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	$pdf->SetNombre($nombre_colegio);
	$pdf->SetAntesNombre($antes_del_nombre);
	
	$pdf->AddPage('L', 'A4');
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
	.etiquetas
	{
		font-weight: bold;
		font-size: 10px;
		text-align:justified;
		font-family: sans-serif;
	}
	.texto
	{
		font-size:10px;
		text-align:justified;
		font-family: sans-serif;
		line-height: 150%;
	}
	.firma
	{
		font-size: 12px;
		font-weight: bold;
		text-align: center;
		font-family: sans-serif;
	}
	</style>
	<table width="100%" border="0">
		<tr>
			<td colspan="6" class="subtitulo">LISTADO DE ALUMNOS CON NOTAS PENDIENTES.<br>{$cabecera}.</td>
		</tr>
		<tr>
			<td colspan="6"><hr></td>
		</tr>
	</table>
	<div class="contenedor">
	<br/><br/><br/>
		{$alumnos}
	</div>
EOF;
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output('notas_pendientes_de_ingreso.pdf', 'I');
?>