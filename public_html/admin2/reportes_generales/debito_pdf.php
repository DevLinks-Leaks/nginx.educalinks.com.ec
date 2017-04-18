<?php
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/funciones.php');
	require_once ('../../framework/dbconf.php'); 
	session_start();
	
	ini_set('memory_limit', '640M');
	/*Begin Class*/
	class MYPDF extends TCPDF 
	{	public function Header() 
		{	$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 85, 25, 45, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// $this->SetFont('helvetica', '', 6);
			// $this->Cell(0,10,'Código: R13-09', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			// $this->Cell(0,15,'Versión 4', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			// $this->Cell(0,20,'Nov/2016', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
		public function Footer() 
		{	
			// $this->SetY(-15);
			// $this->SetFont('helvetica', 'I', 8);
			// $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}	 
	/*End Class*/

	/*Existe un get con alum_codi?*/
	if (isset($_GET['alum_curs_para_codi']))
		$alum_curs_para_codi=$_GET['alum_curs_para_codi'];
	else
		$alum_curs_para_codi=0;
	/*Código del periodo seleccionado*/
	$peri_codi=$_SESSION['peri_codi'];
	$peri_deta=$_SESSION['peri_deta'];
	/*Consulta  a la base para datos del contrato*/
	$sql = "{call alum_curs_para_info(?)}";
	$params = array($alum_curs_para_codi);
	$stmt = sqlsrv_query($conn,$sql,$params);
	if ($stmt===false)
	{	die( print_r( sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt);
	$alum_codi=$row['alum_codi'];
	/*Datos del representante Legal*/
	$sql = "{call repr_info_vida(?,?)}";
	$params=array($alum_codi,"R");
	$stmt = sqlsrv_query($conn, $sql, $params);
	$row_representante = sqlsrv_fetch_array($stmt);
	/*Datos del representante Financiero*/
	$sql = "{call repr_info_vida(?,?)}";
	$params=array($alum_codi,"F");
	$stmt = sqlsrv_query($conn, $sql, $params);
	$row_representante_fina = sqlsrv_fetch_array($stmt);
	/*Campos necesarios*/
	$cliente=$_SESSION['cliente'];
	/*Fecha*/
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("%d de %B de %Y");
	/*parametros*/
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector_mayus=strtoupper(para_sist(33));
	$etiqueta_secretario_mayus=strtoupper(para_sist(34));
	$etiqueta_rector=mb_strtoupper(para_sist(33),'UTF-8');
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = mb_strtoupper(para_sist(3),'UTF-8');
	$antes_del_nombre = mb_strtoupper(para_sist(36),'UTF-8');
	$jornada = mb_strtoupper(para_sist(35),'UTF-8');
	$sexo_rector=para_sist(51);
	$sexo_secretaria=para_sist(52);
	$nombre_legal=pasarMayusculas(para_sist(53));

	// if($sexo_rector =='F')
	// {	$sexo_rector_art='la';
	// 	$senor='Señora';
	// }
	// else
	// {	$sexo_rector_art='el';
	// 	$senor='Señor';
	// }
	// if($sexo_secretaria =='F'){$sexo_secretaria_art='la';}else{$sexo_secretaria_art='el';}

	/*descencriptar numero tarjeta*/
	if($row['alum_resp_form_banc_tarj_nume']!=null and !is_numeric($row['alum_resp_form_banc_tarj_nume']) ){
		$alum_resp_form_banc_tarj_nume_dec=base64_decode($row['alum_resp_form_banc_tarj_nume']);
		$iv = base64_decode($_SESSION['clie_iv']);
		$alum_resp_form_banc_tarj_nume=mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume_dec, MCRYPT_MODE_CBC, $iv );
		$alum_resp_form_banc_tarj_nume=preg_replace('/[^A-Za-z0-9\-]/', '', $alum_resp_form_banc_tarj_nume);
	}else{
		$alum_resp_form_banc_tarj_nume=$row['alum_resp_form_banc_tarj_nume'];
	}
	/*FIN*/
	/*Creación de bloque de información de pago*/
	$info_credito='';
	if($row['alum_resp_form_pago']==22){ 
		/*Forma de pago Banco*/
		$info_credito.='<table class="letras_normales tabla" >';
		$info_credito.='<tr><td width="50%">Institución Financiera</td>
							<td width="50%">Número de Cuenta Bancaria</td>
						</tr>';
			$info_credito.='<tr><td width="50%">'.$row["alum_resp_form_banc_tarj"].'</td>
							<td width="50%">'.$alum_resp_form_banc_tarj_nume.'</td>
						</tr>';
		$info_credito.='<tr><td class="centrar" width="33%">Cta. Ahorros</td>
							<td class="centrar" width="33%">Cta. Corriente</td>
							<td class="centrar" width="33%">Fecha de Débito</td>
						</tr>';
		$info_credito.='<tr><td class="centrar" width="33%">'.($row["alum_resp_form_banc_tipo"]=='A'?'X':'').'</td>
							<td class="centrar" width="33%">'.($row["alum_resp_form_banc_tipo"]=='C'?'X':'').'</td>
							<td  class="centrar" width="33%"> 10 DE CADA MES</td>
						</tr>';
		$info_credito.='</table>';
	} elseif($row['alum_resp_form_pago']==23){
		/*Forma de pago Tarjeta de Credito*/
		// $alum_resp_form_banc_tarj_nume =  creditCardMask($alum_resp_form_banc_tarj_nume,4,8);
		$info_credito.='<table class="letras_normales tabla" >';
		$info_credito.='<tr><td>TARJETA DE CREDITO:</td><td> '.$row["alum_resp_form_banc_tarj"].'</td>
						</tr>';
		$info_credito.='<tr><td width="50%">#: '.$alum_resp_form_banc_tarj_nume.'</td>
							<td width="50%">Fecha de Caducidad: '.date_format($row["alum_resp_form_fech_vcto"],'m/Y').'</td>
						</tr>';
		$info_credito.='<tr><td width="50%">Banco Emisor: '.$row["alum_resp_tarj_banco_emisor"].'</td>
							<td width="50%">Fecha de Débito: 10 DE CADA MES</td>
						</tr>';
		$info_credito.='';
		$info_credito.='</table>';
	}
	$jornada = para_sist(35);
	if ($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp')
	{	$jornada_lbl  = "<h5>Jornada ".$jornada."</h5><br/>";
	}
	else
	{	$jornada_lbl = "";
	}
	/*Creación de objeto TCPDF*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($cliente);
	$pdf->SetAuthor($cliente);
	$pdf->SetTitle($cliente);
	$pdf->SetSubject($cliente);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 60, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	/*Añadir nueva página*/
	$pdf->AddPage();
	$html=<<<EOF
	<style>
	h5
	{	
		text-align: center;
	}
	p
	{	padding: 0;
		margin: 0;
	}
	.centrar
	{	font-size: 10px;
		text-align: center;
	}
	.contenedor
	{	width: 100%;
	}
	.letras_pequenas
	{	font-size: 10px;
		text-align: justify;
	}
	.letras_normales
	{	font-size: 11px;
		text-align: justify;
	}
	.tabla {
		border: 1px solid #000000;
		line-height: 180%;
	}
	</style>
	{$jornada_lbl}
	<h5>AUTORIZACIÓN DE DEBITO EN CUENTA BANCARIA O TARJETA DE CREDITO</h5><br/>
	<p class="letras_normales">
	Señores</p>
	<p class="letras_normales">
	<b>{$nombre_legal}</b>
	</p>
	<p class="letras_normales">
	Ciudad.- {$ciudad}
	</p>
	<p class="letras_normales">
	Yo {$row["alum_resp_form_nomb"]} (Representante) del estudiante {$row["alum_nomb"]} {$row["alum_apel"]}<br/>
	Que está cursando el nivel {$row["curs_deta"]} de {$row["nive_deta"]}; titular de la siguiente cuenta o tarjeta de Crédito, que mantengo con la Institución Financiera:
	</p>
	<br/>
	{$info_credito}
	<br/>
	<p class="letras_normales">
	Autorizo a la institución Bancaria para que se realice los cobros interbancarios y se proceda con el débito de los valores correspondiente a pensión de mi cuenta bancaria de ahorro o corriente, o de mi tarjeta de crédito de forma mensual, de acuerdo a la opción escogida en este convenio, los mismo que serán acreditados a la <b>{$nombre_legal}</b>; y me responsabilizo en contar con los fondos suficientes para que se efectúe el respectivo descuento en las fechas que determine. Eximo a la Institución Bancaria y Educativa de cualquier inconveniente que tuviera en mi cuenta o tarjeta por lo que me obligo a estar pendiente de que se realice la transacción. En caso de no ejecutarse, me acercaré a cancelar los valores en Caja de la Institución Educativa.
	</p>
	<p class="letras_normales">
	Atentamente, 
	</p>
	<table class="letras_normales">
	<tr>
	<td>
	_______________________________________<br/><br/>
	<b>Firma del Titular</b><br/>
	</td>
	<td></td>
	</tr>
	<tr>
	<td>
	C.I. {$row["alum_resp_form_cedu"]}
	</td>
	<td>
	Fecha del Acuerdo: {$ciudad}, {$fecha_hoy}
	</td>
	</tr>
	</table>
EOF;
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('autorizacion_debito.pdf', 'I');
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='autorizacion_debito.pdf'");
?>
