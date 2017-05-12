<?php
session_start();

if( isset($_POST['aten_codigo_new']) )
{	$aten_codigo = $_POST['aten_codigo_new'];
}
else
{	if(isset($_GET['aten_codigo_new']))
	{	$aten_codigo=$_GET['aten_codigo_new'];
	}
	else
	{	$aten_codigo="0";
	}
}

require_once('../../../framework/tcpdf/tcpdf.php');

class MYPDF extends TCPDF 
{	private $codigo;
	private $nombre;
	private $apellido;
	private $curso;
	private $periodo;
	private $foto;
	
	public function Header() 
	{	
	}
	public function Footer()
	{	
	}
}

/*Conexión a la BD*/
$serverName = "certuslinks.com";
$db = "Educalinks_ecobabvesp"; 
$uid = "sa";
$pwd = "R3dlink51981";
$charset = "UTF-8";
$connectionInfo = array("Database"=>$db, "UID"=>$uid, "PWD"=>$pwd, "CharacterSet"=>$charset);
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn)
{	echo "La conexión no se pudo establecer.<br/>";
	die( print_r( sqlsrv_errors(), true));
}

$params = array($aten_codigo);
$sql="{call med_atenciones_info(?)}";
$atencion_info = sqlsrv_query($conn, $sql, $params);
//$pdf_atenciones = sqlsrv_fetch_array($atencion_info);


require('../../../core/rutas.php');
global $diccionario;

switch($domain){
	case  "ecobab.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
		break;
	case  "ecobabdemo.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
		break;
	case  "desarrollo.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
		break;
	case  "ecobabvesp.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
		break;
	case  "liceopanamericano.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
		break;
	case  "liceopanamericanosur.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
		break;
	case  "delfos.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
		break;
	case  "delfosvesp.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
		break;
	case  "moderna.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
		break;
	case  "americano.educalinks.com.ec":
		$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
		break;
	default:
	break;
}

header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='comprobante_atencion.pdf'");

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("Redlinks");
$pdf->SetAuthor("Redlinks");
$pdf->SetTitle("Educalinks | Comprobante de Atención");
$pdf->SetSubject("Educalinks | Comprobante de Atención");
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP_MEDIC, PDF_MARGIN_RIGHT );
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('Helvetica', '', 9, '', 'false');

$pdf->AddPage('L', 'A6');//P:Portrait, L=Landscape
$pdf->setJPEGQuality(75);

while ($pdf_atencion=sqlsrv_fetch_array($atencion_info))
{   $fecha_atencion	  = $pdf_atencion['aten_fechaCreacion_string'];
    $curs_deta		  = $pdf_atencion['curs_deta']." - ".$pdf_atencion['para_deta'];
    $nombre_alumno	  = $pdf_atencion['alum_nomb']." ".$pdf_atencion['alum_apel'];
    $enfe_descripcion = $pdf_atencion['enfe_descripcion'];
    $aten_observacion = $pdf_atencion['aten_observacion'];
    $mate_deta		  = $pdf_atencion['mate_deta'];
    $prof_nomb		  = $pdf_atencion['prof_nomb'];
}
$file="comprobante_atencion_html.php";
$logoInstitucion='<img src="/'.$_SESSION["print_dir_logo_cliente"].'"  style="width:100px;height:45px;">';
$html=file_get_contents($file);
$html=str_replace("{logoInstitucion}",$logoInstitucion,$html);
$html=str_replace("{codigo_atencion}",$aten_codigo,$html);
$html=str_replace("{fecha_atencion}",$fecha_atencion,$html);
$html=str_replace("{nombre_alumno}",$nombre_alumno,$html);
$html=str_replace("{curso_deta}",$curs_deta,$html);
$html=str_replace("{enfe_descripcion}",$enfe_descripcion,$html);
$html=str_replace("{aten_observacion}",$aten_observacion,$html);
$html=str_replace("{mate_deta}",$mate_deta,$html);
$html=str_replace("{prof_nomb}",$prof_nomb,$html);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('comprobante_atencion.pdf', 'I');
?>