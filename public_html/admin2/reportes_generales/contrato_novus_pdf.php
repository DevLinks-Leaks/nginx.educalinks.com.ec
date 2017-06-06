<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='contrato.pdf'");
	session_start();

	require_once ('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
	require_once ('../../framework/AifLibNumber.php'); 
		
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = mb_strtoupper(para_sist(3),'UTF-8');
	$antes_del_nombre = mb_strtoupper(para_sist(36),'UTF-8');
	$nombre_financiero = para_sist(37);
	$nombre_legal = mb_strtoupper(para_sist(53),'UTF-8');
	
	$sql="{call alum_info_contrato(?)}";
	$params = array($_GET['alum_curs_para_codi']);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	$sql="{call convenio_consulta_alumInfo(?)}";
	$params = array($_GET['alum_curs_para_codi']);
	$stmt_val = sqlsrv_query($conn, $sql, $params);

	if( $stmt_val === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	$row_valores = sqlsrv_fetch_array($stmt_val);
	
	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis'];
			$this->Image($logo_minis, 12, 5, 21, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 175, 3, '', 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
	$pdf->SetMargins(PDF_MARGIN_LEFT, 28, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	$pdf->setListIndentWidth(4);

	while ($alumno=sqlsrv_fetch_array($stmt))
	{	
		$sql="{call repr_info_vida(?,?)}";
		$params = array($alumno["alum_codi"], "R");
		$stmt_repr = sqlsrv_query($conn, $sql, $params);
	
		if( $stmt_repr === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$representante=sqlsrv_fetch_array($stmt_repr);
		
		$pdf->AddPage();
		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_TIME, 'spanish');
		$fecha_hoy=strftime("%d de %B del %Y");
		$fecha_hoy2=strftime("$ciudad, %d de %B de %Y");
		
		/*Valores en letras*/
		$total = number_format($row_valores['precio_pension']*10+$row_valores["precio_matricula"],2,'.',',');
		$val_matri_let = strtoupper(AifLibNumber::toWord($row_valores['precio_matricula']));
		$val_pensi_let = strtoupper(AifLibNumber::toWord($row_valores['precio_pension']));
		$val_pront_let = strtoupper(AifLibNumber::toWord($row_valores['desc_prontopago']));
		$val_pens_tota_let = strtoupper(AifLibNumber::toWord($total));
	
	$tbl=<<<EOF
	<style>
	h1
	{
		font-size: 14px;
		text-align: center;
	}
	.centrar
	{
		text-align: center;
	}
	.izquierda
	{
		text-align: left;
	}
	.derecha
	{
		text-align: right;
	}
	.contenedor
	{
		width: 100%;
	}
	.letras_pequenas
	{
		font-size: 12px;
		text-align: justify;
	}
	.subrayado
	{
		font-weight: bolder;
		font-style: italic;
		text-decoration: underline;
	}
	</style>
	<br/>
	<div class="contenedor">
	<table >
		<tr>
			<td class="centrar"><h1><u>Contrato de Prestación de Servicios Educacionales 2017-2018</u></h1></td>
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento, el Contrato de prestación de servicios educacionales al que hace referencia la Disposición General Segunda del Acuerdo 0493-12 del Ministerio de Educación , expedido el 14 de diciembre del 2012, el mismo que se celebrará al tenor de las siguientes cláusulas:
	<br/>
	<u><strong>Primera: Intervinientes:</strong></u>
	Participan de forma libre y voluntaria en la celebración del presente contrato, por una parte el (la) Señor (a) {$representante["nombres"]} {$representante["apellidos"]} titular de cédula de identidad No. {$representante["cedula"]} con dirección domiciliaria: {$representante["telefono"]}, teléfono Celular: {$representante["repr_celular"]}, Correo electrónico: {$representante["correo"]} en calidad de representante legal. Quien en lo posterior podrá denominarse como él (la) REPRESENTANTE, quien comparece a nombre de él (la) estudiante: {$alumno["nombres"]} {$alumno["apellidos"]} de {$alumno["curs_deta"]} de Educación Inicial/Educación General Básica/Bachillerato en Ciencias. Y por otra parte el Gerente General y/o la Rectora {$rector} como representante de la {$antes_del_nombre} "{$nombre_colegio}" quien en lo posterior podrá denominarse como UNIDAD EDUCATIVA o la INSTITUCIÓN EDUCATIVA.
	<br/>
	<u><strong>SEGUNDA: Antecedentes:</strong></u>
	La {$antes_del_nombre} "{$nombre_colegio}", es una institución particular auto financiada, de Derecho Privado, legalmente reconocida por las autoridades de educación que brinda servicio educativo bajo las leyes de la República LOEI y la Constitución, la cual brinda educación integral de excelencia en los niveles de Inicial, Básico y Bachillerato recibiendo como contraprestación el monto económico fijado  por la Junta Reguladora de Costos educativos establecido en el artículo 17 del Acuerdo Ministerial No . MINEDUC-ME 2015-00094-A  por  concepto de matrícula y pensiones, siendo estos rubros su única fuente de ingreso que nos permite brindar todos los servicios ofertados  y una educación de calidad.
	<br/>
	El (la) representante, consiente y conocedor de  su responsabilidad de participar en el proceso educativo de su representado/a, ha escogido libremente el modelo educativo que ofrece INSTITUCIÓN.
	<br/>
	El REPRESENTANTE se ha informado adecuada y ampliamente de la filosofía, visión, misión, modelo Pedagógico que constan en el Código de Convivencia en el modelo educativo Institucional y en las Políticas internas vigentes en la Institución educativa e iniciado el proceso de matriculación a través de: la Inscripción, evaluaciones pedagógicas, entrevista psicológica, revisión y verificación de documentos, actualización de datos informativos personales, firma y entrega  del presente contrato de servicios, firma de libro de matrícula y  entrega documentación requerida.
	<br/>
	<u><strong>TERCERA: Objeto del Contrato:</strong></u>
	La {$antes_del_nombre} "{$nombre_colegio}", acepta otorgar la matrícula solicitada para el estudiante en mención, previo al cumplimiento de todos los procesos, aceptación y firma del presente contrato, conocimiento de nuestro Código de Convivencia; con el fin de brindarle el servicio educativo requerido,  aprobado en el Proyecto Educativo Institucional –PEI y demás normativas Institucionales.
	<br/>
	<u><strong>CUARTO: Contraprestación del servicio Educativo:</strong></u>
	El Representante se obliga a pagar los valores fijados por concepto de Matrícula y pensiones mensuales autorizado para el presente año lectivo. 
	<br/>
	<b>La Matrícula</b> se cancelará como pago único dentro del plazo establecido por el Ministerio de educación, durante el mes de abril y dicho valor no superará el 75% del valor correspondiente a la pensión autorizada.
	<br/>
	<b>El valor de las pensiones</b>, se fijará un valor prorrateado en 10 mensualidades desde mayo a febrero respectivamente, dicho valor no excederá el autorizado por la autoridad educativa, el cual deberá ser cancelado durante los 8 primeros días de cada mes, mediante depósitos utilizando el código del estudiante, o en colecturía del plantel mediante pagos  con  tarjeta de crédito o débito.
	<br/>
	<b>El valor de otros Rubros</b>, no están cubiertos o considerados dentro de los valores de matrícula y pensiones. Los libros, útiles escolares, fotocopiados, uniformes, trajes o disfraces para eventos artísticos, culturales, deportivos o sociales, programas de estudios u otra actividad extracurricular que los padres de familia autoricen y  participen de manera voluntaria, deberán ser cancelados directamente al proveedor del bien o servicio.
	<br/>
	<u><strong>QUINTA: Forma de pago, plazos, compromisos y obligaciones:</strong></u>
	La Institución se obliga a dar educación de calidad y calidez, en la forma y modo constante y permanente en su Proyecto Educativo Institucional (PEI), Código de convivencia y demás reglamentos y normativas que rige la Institución, con sujeción a la Constitución de la República, Ley Orgánica de educación intercultural, su reglamento y demás disposiciones válidas y legales de la Autoridad de educación competente.
	<br/>
	El REPRESENTANTE  del estudiante se obliga a:
	<ol>
	<li>
	Cancelar el  valor correspondiente de matrícula oportunamente.
	</li>
	<li>
	Cancelar los valores por concepto de  pensiones  mediante depósito en efectivo o cheque en  la entidad bancaria asignada, en colecturía del plantel se realizará cobros mediante  tarjeta de crédito o débito, los mismos que serán notificados a partir del primer día de cada mes y deberán realizar  oportunamente dentro de los 8 primeros días de cada mes.
	</li>
	<li>
	Se legalizará la matrícula de los estudiantes una vez  aprobada y entregada toda la documentación solicitada, en secretaría del plantel y firma del representante legal  en el libro de matrícula.
	</li>
	<li>
	Informar a la Institución Educativa, en el menor tiempo posible, cualquier situación que interfiera en el cumplimiento del presente contrato. El NO pago de la Matrícula y/o la entrega del presente Contrato de prestación de Servicios educativos dentro de las fechas establecidas por nuestra Institución educativa, será considerado como una manifestación voluntaria  de NO continuar utilizando los servicios educativos y por tanto deja en libertad a nuestra Institución de disponer del cupo, en beneficio de otro estudiante.
	</li>
	<li>
	La mora en el pago de un mes de pensión, pasados los 8 primeros días del mes, se considera un atraso, lo cual será notificado de forma verbal, vía agenda o telefónica, se notificará  al representante legal por oficio escrito y se citará a una entrevista con el abogado de la Institución para  acordar compromisos de pago y/o acudir al Centro de Mediación de la Función Judicial en la ciudad de Guayaquil para suscribir el correspondiente acuerdo de pago mediante acta de mediación, amparados en lo establecido en el artículo 190 de la Constitución de la República, artículos 44 y47 de la Ley de Arbitraje y Mediación, el Reglamento del mencionado centro y las demás normas aplicables o a la Jurisdicción Civil.
	</li>
	<li>
	En caso de que el REPRESENTANTE  incumpla el pago de los valores concernientes a los rubros estipulados en la Cláusula quinta de este contrato, deberá hacer uso de la asignación de cupo en otro establecimiento educativo que lo realice el Distrito educativo en donde esté ubicado su domicilio, para el año lectivo 20172018 en cumplimiento a lo dispuesto en el Memorando No MINEDUC-SASRE-2014-00908-M del 08 de diciembre del 2014, suscrito por el Subsecretario de Apoyo, Seguimiento y Regulación de la Educación, sin perjuicio a acciones legales que se tomen por el cobro de las pensiones adeudadas. Se adjuntará copia notariada del presente Contrato de prestación de Servicios  como justificativo para el cumplimiento de lo acordado; y en beneficio del estudiante, para que no conculque su Derecho a la educación, siendo obligación del Estado proporcionar este servicio público en forma gratuita. 
	</li>
	<li>
	El REEPRESENTANTE, Sr./Sra. {$representante["nombres"]} {$representante["apellidos"]} debe y promete que pagará, a la orden y a favor de la Institución educativa, conforme con lo que determina la ley, la suma equivalente al valor total de los 10 meses de  pensiones prorrateadas, reconociendo esta obligación suscrita y aceptada en el presente contrato, exigible en juicio ejecutivo ante uno de los jueces de lo civil del Cantón Guayaquil.
	</li>
	</ol>
	<br/>
	<u><strong>SEXTA: Retiro del estudiante o Suspensión de servicios:</strong></u>
	El REPRESENTANTE acepta expresamente que si su representado decidiere retirarse de la INSTITUCIÖN educativa, no podrá reclamar la devolución del valor de matrícula, ni los valores que cubra el costo de los servicios facturados hasta la fecha de la notificación escrita, mediante el REPRESENTANTE manifieste su voluntad de retirar al estudiante.
	<br/>
	<u><strong>SÉPTIMA: Duración:</strong></u>
	El presente contrato tiene duración de un año lectivo.
	<br/>
	<u><strong>OCTAVA: Ratificación:</strong></u>
	Las partes firman y ratifican el total contenido del presente contrato en forma libre y voluntaria y  por así convenir a sus intereses para constancia de lo cual lo suscriben en la ciudad de Guayaquil, a la fecha {$fecha_hoy}: obligándose a reconocer su firma y rúbrica ante el Juez o Notario competente, de ser requeridos.
	<br/><br/>
	</p>
	<p class="letras_pequenas">
	<table>
	<tr>
	<td colspan="2">
	<br/><br/><br/>
	</td>
	</tr>
	<tr>
	<td class="">
	Institución Educativa<br/><br/><br/><br/>
	___________________________________________<br/>
	{$rector}<br/>
	{$etiqueta_rector}
	</td>
	<td class="">
	Representante del estudiante<br/><br/><br/><br/>
	___________________________________________<br/>
	{$representante["nombres"]}<br/>
	C.C. No. {$representante["cedula"]}
	</td>
	</tr>
	</table> 
	</p>        
	</div>
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
}
	
$pdf->Output('cert_matricula.pdf', 'I');
?>
