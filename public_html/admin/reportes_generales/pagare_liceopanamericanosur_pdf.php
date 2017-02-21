<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='pagare.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/AifLibNumber.php'); 
	require_once ('../../framework/funciones.php'); 
	require_once ('../../framework/dbconf.php'); 
	
	/*Parámetros del convenio*/
	$nombre_legal = para_sist(53);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
	$nombre_financiero = para_sist(37);
	$ciudad = para_sist (31);
	$direccion = para_sist(57);
	
	if (isset($_GET['alum_curs_para_codi']))
	{	$alum_curs_para_codi = $_GET['alum_curs_para_codi'];
	}
	else
	{	$alum_curs_para_codi = 0;
	}
	$sql="{call alum_info_contrato(?)}";
	$params = array($_GET['alum_curs_para_codi']);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if( $stmt === false )
	{	echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	$sql		= "{call convenio_consulta_alumInfo(?)}";
	$params 	= array($alum_curs_para_codi);
	$options 	= array("scrollable"=>"buffered");
	$stmt_val	= sqlsrv_query($conn, $sql, $params, $options);
	if( $stmt_val === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	if (sqlsrv_has_rows($stmt_val))
	{	/*Valores en letras*/
		$row_valores = sqlsrv_fetch_array($stmt_val);
		$total_pension = number_format(($row_valores['precio_pension']-$row_valores['desc_pension'])*10,2,'.',',');
		$total_pension_letras = strtoupper(AifLibNumber::toWord(number_format($row_valores['precio_pension']-$row_valores['desc_pension'],2,'.',',')*10));
		$pension = number_format(($row_valores['precio_pension']-$row_valores['desc_pension']),2,'.',',');
		$pension_let = strtoupper(AifLibNumber::toWord(number_format($row_valores['precio_pension']-$row_valores['desc_pension'],2,'.',',')));
	}

	class MYPDF extends TCPDF 
	{	public function Header() 
		{}

		public function Footer() 
		{	$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
	 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	$pdf->AddPage();
	$alumno=sqlsrv_fetch_array($stmt);
	$sql	="{call repr_info_vida(?,?)}";
	$params = array($alumno["alum_codi"], "R");
	$stmt_r	= sqlsrv_query($conn, $sql, $params);
	if( $stmt_r === false )
	{	echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	$representante=sqlsrv_fetch_array($stmt_r);
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("$ciudad, el día %d de %B del año %Y");
	
	$sql 	= "{call str_common_consulta_alumPensiones(?)}";
	$params = array($alum_curs_para_codi);
	$stmt	= sqlsrv_query($conn,$sql,$params);
	if( $stmt === false )
	{	echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	$i=0;
	while ($row_pensiones = sqlsrv_fetch_array($stmt))
	{	$i++;
		$tbl_pensiones.= "<tr>";
		$tbl_pensiones.= '<td class="texto_centrar_tabla">'.$i.'</td>';
		$tbl_pensiones.= '<td class="letras_pequenas"> '.$row_pensiones["prod_nombre"].'</td>';
		$tbl_pensiones.= '<td class="texto_centrar_tabla">'.date_format($row_pensiones["detaAnioPeri_fechaFin"],"d-m-y").'</td>';
		$tbl_pensiones.= '<td class="texto_centrar_tabla"> $ '.number_format($row_pensiones["precio_pension"],2,',','.').'</td>';
		$tbl_pensiones.= "</tr>";	
	}
	
	$tbl=<<<EOF
	<style>
	h1
	{	font-size: 12px;
		text-align: center;
	}
	.cabecera_tabla
	{	font-size: 10px;
		font-weight: bold;
		text-align: center;
	}
	.centrar
	{	text-align: center;
	}
	.contenedor
	{	width: 100%;
	}
	.letras_pequenas
	{	font-size: 10px;
		text-align: justify;
	}
	.texto_centrar_tabla
	{	font-size: 10px;
		text-align: center;
	}
	</style>
	<div class="contenedor">
	<h1>PAGARÉ CON VENCIMIENTOS SUCESIVOS</h1>
	<h6 align="right">Pagaré N° 1/1</h6>
	<p class="letras_pequenas">
	Debo(emos) y pagaré(mos) solidaria e incondicionalmente a la orden de “{$nombre_legal}” a 10 meses vista, en la ciudad de {$ciudad}, en {$direccion}, en las oficinas de la {$antes_del_nombre} "{$nombre_colegio}",la cantidad de {$total_pension} ({$total_pension_letras}) dólares de los Estados Unidos de América, plazo que corre desde la fecha de suscripción hasta la fecha de vencimiento, suma de dinero que pagaré(mos) mediante 10 cuotas iguales y sucesivas de <span class="subrayado">$ {$pension} (US $ {$pension_let})</span> dólares de los Estados Unidos de América cada una, que corresponden al pago de capital, debiendo pagarse irrevocablemente de acuerdo a la tabla de amortización siguiente:
	</p>
	<table border="1" width="100%">
		<tr>
			<td class="cabecera_tabla" width="10%">N° Cuota</td>
			<td class="cabecera_tabla" width="55%">Pensión</td>
			<td class="cabecera_tabla" width="20%">Fecha de pago</td>
			<td class="cabecera_tabla" width="15%">Valor</td>
		</tr>
		{$tbl_pensiones}
	</table>
	<p class="letras_pequenas">
	En caso de mora en el pago de uno o más de los valores de capital, el acreedor podrá declarar de plazo vencido anticipado todas las obligaciones que estuvieren vigentes, aún cuando no estuvieren vencidas, y proceder al recaudo judicial de todo lo debido, bastando para ello la simple afirmación que el acreedor hiciere respecto de la mora en el escrito de demanda.
	</p>
	<p class="letras_pequenas">
	Me (nos) obligo (amos) además a cubrir todos los impuestos, tasas, gastos judiciales y extrajudiciales, inclusive honorarios profesionales de abogados del acreedor, que ocasione el cobro de este pagaré, siendo suficiente prueba para establecer tales gastos la mera aseveración del acreedor.
	</p>
	<p class="letras_pequenas">
	Al fiel cumplimiento de lo convenido me (nos) obligo (amos) con todos mis (nuestros) bienes presentes y futuros. Renuncio (amos) domicilio y a toda ley, beneficio de exclusión o excepción, o cualquier tipo de recurso o beneficio que pudiere favorecerme (nos) en juicio o fuera de él. 
	</p>
	<p class="letras_pequenas">
	Renuncio (amos) también al derecho de interponer el recurso de apelación y el de hecho de las providencias que se expidieren en el juicio o juicios que, en relación al presente documento, se diere(n) lugar. 
	</p>
	<p class="letras_pequenas">
	Sin protesto. Exímase de presentación para el pago y de avisos por falta del mismo.
	</p>
	<p class="letras_pequenas">
	Quedo (amos) sometido (s) a los jueces o tribunales a los que elija el acreedor, para cuyo efecto renuncio (amos) fuero, jurisdicción, domicilio y vecindad.
	Dejo (amos) constancia que el presente documento que firmo (amos) es totalmente negociable y transferible.
	</p>
	<p class="letras_pequenas">
	En el evento de ser el deudor una persona jurídica las declaraciones constantes en el presente documento se entienden efectuadas por su representante legal a nombre de ella.
	</p>
	<p class="letras_pequenas">
	Para constancia se firma en la ciudad de {$fecha_hoy}.
	</p>
	<p class="letras_pequenas">
	<table>
	<tr>
	<td colspan="2">
	<br/><br/><br/><br/>
	</td>
	</tr>
	<tr>
	<td class="centrar">
	f)___________________________________________<br/>
	{$representante["nombres"]}<br/>
	El (la) Representante 
	</td>
	<td class="centrar">
	f)___________________________________________<br/>
	{$nombre_financiero}<br/>
	{$nombre_legal}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/><br/>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	Cédula: {$representante["cedula"]}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	Dirección Domicilio: {$representante["domicilio"]}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	Telefono: {$representante["telefono"]}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	ACEPTO TODAS LAS CONDICIONES Y OBLIGACIONES.-
	VISTO BUENO.- Sin protesto.- Fecha Up Supra.-
	</td>
	</tr>
	</table> 
	</p>   
	</div>
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Output('pagare.pdf', 'I');
?>