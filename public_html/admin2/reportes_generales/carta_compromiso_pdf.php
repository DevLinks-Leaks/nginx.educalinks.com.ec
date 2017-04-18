<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='carta_compromiso.pdf'");
	session_start();
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
	/*Existe un get con alum_curs_para_codi?*/
	if (isset($_GET['alum_curs_para_codi']))
		$alum_curs_para_codi=$_GET['alum_curs_para_codi'];
	else
		$alum_curs_para_codi=0;
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);

	class MYPDF extends TCPDF 
	{	public function Header() 
		{	$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 12, 0, 20, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
		public function Footer() 
		{	
		}
	}
	 
	/*Creación de objeto TCPDF*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($cliente);
	$pdf->SetAuthor($cliente);
	$pdf->SetTitle($cliente);
	$pdf->SetSubject($cliente);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	$pdf->AddPage();

/*Consulta de datos del alumno*/
$sql = "{call alum_curs_para_info(?)}";
$params=array($alum_curs_para_codi);
$stmt = sqlsrv_query($conn, $sql, $params);
$row_alum = sqlsrv_fetch_array($stmt);
$alum_fech_naci = date_format($row_alum["alum_fech_naci"],'d/m/Y');
$alum_codi = $row_alum["alum_codi"];
/*Datos del representante*/
$sql = "{call repr_info_vida(?,?)}";
$params=array($alum_codi,"R");
$stmt = sqlsrv_query($conn, $sql, $params);
$row_representante = sqlsrv_fetch_array($stmt);
	
date_default_timezone_set('America/Guayaquil');
setlocale(LC_TIME, 'spanish');
$fecha_hoy=strftime("%d de %B de %Y");

$jornada = para_sist(35);
if ($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp')
{	$jornada_lbl  = "<h1>Jornada ".$jornada."</h1>";
}
else
{	$jornada_lbl = "";
}

$html=<<<EOD
	<style>
	h1
	{	font-size: 16px;
		line-height: 100%;
		padding-bottom: 0px;
		text-align: center;
	}
	h3
	{	font-size: 12px;
		line-height: 100%;
		padding-bottom: 0px;
		text-align: center;
	}
	p
	{	padding: 0;
		margin: 0;
	}
	table
	{	font-size: 12px;
		line-height: 120%;
		text-align: justify;
	}
	.centrar
	{	text-align: center;
	}
	.derecha
	{	text-align: right;
		font-size: 14px;
	}
	.letras_normales
	{	font-size: 14px;
		line-height: 160%;
		text-align: justify;
	}
	</style>
	<br>
	<p>
	<h1>{$antes_del_nombre}</h1>
	<h1>"{$nombre_colegio}"</h1>
	{$jornada_lbl}
	<h1>{$_SESSION['peri_deta']}</h1>
	</p>
	<p>
	<h3>ACTA DE COMPROMISO PARA REPRESENTANTES LEGALES Y/O PADRES DE FAMILIA</h3>
	</p>
	<p class="derecha">
	{$ciudad}, {$fecha_hoy}
	</p>
	<p class="letras_normales">
	{$rector}<br/>
	{$etiqueta_rector} {$antes_del_nombre} "{$nombre_colegio}"<br/>
	</p>
	<p class="letras_normales">
	Presente.-
	</p>
	<p class="letras_normales">
	Yo, {$row_representante['repr_nomb']} {$row_representante['repr_apel']}, representante legal del estudiante {$row_alum['alum_nomb']} {$row_alum['alum_apel']} del {$row_alum['curs_deta']} {$row_alum['para_deta']}, me dirijo a usted para afirmar que comprendo las normas relacionadas con las faltas disciplinarias contenidas en el Art. 134 de la Ley Orgánica de Educación Intercultural, y 330 del Reglamento a la Ley Orgánica de Educación Intercultural en tal virtud, en mi calidad de representante legal me comprometo a socializar, guiar, cumplir y hacer cumplir a mi representado con el fin de que no cometa dichas faltas.
	</p>
	<p class="letras_normales">
	Afirmo además que conozco mis obligaciones como padre de familia y representante legal, constantes en los Art. 8 y 13 de la Ley Orgánica de Educación Intercultural, el contenido de los Art. 76, 77, 168, 170, 172, 173, 194, 196, 199, 208, 210, 211, 213, 214, 222, 224 y 331 del Reglamento General a la Ley Orgánica de Educación Intercultural,  los Art. 39 y 64 del Código de la Niñez y Adolescencia, por lo cual me comprometo a observar y cumplir dichas disposiciones legales; así como las obligaciones contempladas en el Código de Convivencia de la Institución.
	</p>
	<p>
	Atentamente,<br/><br/><br/>
	</p>
	<table width="100%">
	<tr>
	<td width="50%" class="centrar">
	_____________________________________<br/>
	{$row_representante["repr_nomb"]} {$row_representante["repr_apel"]}<br/>
	CI. {$row_representante["cedula"]}<br/>
	Representante
	</td>
	<td class="centrar">
	</td>
	</tr>
	</table>
	</p>
EOD;
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('carta_compromiso.pdf', 'I');
?>