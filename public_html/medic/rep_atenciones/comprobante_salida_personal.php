<?php
session_start();
if(isset($_POST['aten_codigo_new'])){$aten_codigo=$_POST['aten_codigo_new'];}else{if(isset($_GET['aten_codigo_new'])){$aten_codigo=$_GET['aten_codigo_new'];}else{$aten_codigo="0";}}
include("../clases/MYPDF.php");
include("../clases/Atenciones.php");
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='permiso_salida.pdf'");

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("Redlinks");
$pdf->SetAuthor("Redlinks");
$pdf->SetTitle("Educalinks | Permiso de Salida");
$pdf->SetSubject("Educalinks | Permiso de Salida");
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP_MEDIC, PDF_MARGIN_RIGHT );
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('Helvetica', '', 9, '', 'false');

$pdf->AddPage('L', 'A6');//P:Portrait, L=Landscape
$pdf->setJPEGQuality(75);
$pdf_atenciones = new Atenciones();
$pdf_atenciones->get_atenciones_info($aten_codigo);
foreach($pdf_atenciones->rows as $pdf_atencion){
    $fecha_atencion=$pdf_atencion['aten_fechaCreacion_string'];
    $nombre_personal=$pdf_atencion['pers_nomb'].' '.$pdf_atencion['pers_apel'];;
    $enfe_descripcion=$pdf_atencion['enfe_descripcion'];
    $aten_observacion=$pdf_atencion['aten_observacion'];
    
}
$file="comprobante_salida_html_personal.php";
$logoInstitucion='<img src="'.$diccionario["rutas_head"]["ruta_html_medic"]."/".$_SESSION["print_dir_logo_cliente"].'"  style="width:100px;height:45px;">';
$html=file_get_contents($file);
$html=str_replace("{logoInstitucion}",$logoInstitucion,$html);
$html=str_replace("{codigo_atencion}",$aten_codigo,$html);
$html=str_replace("{fecha_atencion}",$fecha_atencion,$html);
$html=str_replace("{nombre_personal}",$nombre_personal,$html);
$html=str_replace("{enfe_descripcion}",$enfe_descripcion,$html);
$html=str_replace("{aten_observacion}",$aten_observacion,$html);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('permiso_salida.pdf', 'I');
?>