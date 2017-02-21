<?php
session_start();
include("../clases/MYPDF.php");
include("../clases/medicamentos.php");
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='comprobante_atencion.pdf'");
if(isset($_POST['fecha_ini'])){$fecha_ini=$_POST['fecha_ini'];$fecha_ini_ymd=substr($_POST['fecha_ini'], 6,4).substr($_POST['fecha_ini'], 3,2).substr($_POST['fecha_ini'], 0,2);}else{$fecha_ini=date("d/m/Y");$fecha_ini_ymd=date("Ymd");}
if(isset($_POST['fecha_fin'])){$fecha_fin=$_POST['fecha_fin'];$fecha_fin_ymd=substr($_POST['fecha_fin'], 6,4).substr($_POST['fecha_fin'], 3,2).substr($_POST['fecha_fin'], 0,2);}else{$fecha_fin=date("d/m/Y");$fecha_fin_ymd=date("Ymd");}
if(isset($_POST['medicamentos'])){$medicamentos=$_POST['medicamentos'];}else{$medicamentos='0';}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("Redlinks");
$pdf->SetAuthor("Redlinks");
$pdf->SetTitle("Educalinks | Comprobante de Atención");
$pdf->SetSubject("Educalinks | Comprobante de Atención");
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP_MEDIC, PDF_MARGIN_RIGHT );
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('Helvetica', '', 9, '', 'false');
$medicinas = new Medicamentos();
$kardex = new Medicamentos();

$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape


$html='<div>
	<h1>Reporte de Inventario</h1>
	<hr>
</div>
<div>';
$html=$html."<table>";
$medicinas->get_medicamento_info($medicamentos);
foreach($medicinas->rows as $medicamento){
	$html=$html.'<tr><td colspan="3"><h3>Nombre: '.$medicamento['med_descripcion'].'</h3></td><td><h3>Stock:'.$medicamento['med_stock'].'</h3></td></tr>';
	$kardex->get_all_kardex_medicamento($medicamento['med_codigo'],$fecha_ini_ymd,$fecha_fin_ymd);
	$html=$html.'<tr><td>Fecha de Movimiento</td><td>Tipo de Movimiento</td><td>Cantidad de Ingreso/Egreso</td><td>Saldo Final</td></tr>
	<tr><td colspan="4"><hr/></td></tr>';
	foreach($kardex->rows as $movi){
		if($movi['kar_tipo_movimiento']=="I"){$tipo="Ingreso";}else{$tipo="Egreso";}
		$html=$html.'<tr><td>'.date_format($movi['kar_fecha_ingreso'],"d/m/Y").'</td><td>'.$tipo.'</td><td>'.$movi['kar_cantidad_ingreso'].'</td><td>'.$movi['kar_stock_actual'].'</td></tr>';
	}
	$html=$html.'<tr><td colspan="4">&nbsp;</td></tr>';
}
$html=$html.'</table></div><div class="row">&nbsp;</div>';
$html=$html.'<div class="row">Reporte emitido por el usuario: '.$_SESSION['usua_codi'].'. Con fecha: '.date('d/m/Y H:i:s').'</div>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('reporte_inventario.pdf', 'I');
?>