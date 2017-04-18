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
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
	$nombre_financiero = para_sist(37);
	$nombre_legal = para_sist(53);
	
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
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 

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
		$fecha_hoy=strftime("$ciudad, el día %d de %B del año %Y");
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
		font-size: 10px;
		text-align: justify;
	}
	.subrayado
	{
		font-weight: bolder;
		font-style: italic;
		text-decoration: underline;
	}
	</style>
	
	<div class="contenedor">
	<table width="755">
		<tr>
			<td width="20%"><img width="50px" height="50px" src="../{$_SESSION['ruta_foto_logo_web']}" /></td>
			<td class="centrar"><h1>CONTRATO DE PRESTACIONES DE SERVICIOS</h1></td>
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento, el Contrato de Prestaciones de Servicios el mismo que se celebra al tenor de las siguientes cláusulas:
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA PRIMERA: INTERVINIENTES:</strong> 
	Participan en forma libre y voluntaria en la celebración del presente contrato, por una parte el (la) señor (a) {$representante["nombres"]} {$representante["apellidos"]} quien, en lo posterior podrá denominarse como "el (la) representante", quien comparece a nombre y en representación del (la) menor {$alumno["nombres"]} {$alumno["apellidos"]}  quien en lo posterior podrá denominarse como "el (la) estudiante"; y por la otra parte, el/la  {$nombre_financiero} por los derechos que representa  de {$antes_del_nombre} {$nombre_legal} propietaria de la {$antes_del_nombre} {$nombre_colegio} en su calidad de Gerente  y a quien en lo posterior podrá denominarse como "UNIDAD EDUCATIVA " o "la Institución".
	</p>
	
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEGUNDA: ANTECEDENTES: UNO:</strong> 
	El (la) representante, conocedor de la misión, visión, filosofía, principios, Proyecto Educativo  Institucional - PEI, Código de Convivencia y demás reglamentación y normatividad interna de la {$antes_del_nombre} {$nombre_colegio} y luego de una serie de análisis y comparación de su oferta educativa con la de otras instituciones, ha solicitado matrícula en la Institución para su representado el (la) estudiante (referidos en la cláusula anterior), para el {$alumno["detalle"]} correspondientes, documentos y declaraciones que forman parte integrante del presente contrato de prestaciones de servicios educacionales.
	<br/>
	<b>DOS:</b>
	{$antes_del_nombre} {$nombre_colegio}, es una Unidad Educativa auto financiada, de carácter particular, legalmente reconocida y autorizada por las autoridades de educación, sin fines de lucro que pertenece a la compañía {$antes_del_nombre} {$nombre_legal}, que brinda servicios educativos en la forma y modo señalado en la Constitución y Leyes de la República del Ecuador, recibiendo como contraprestación del servicio educativo el monto económico fijado en legal forma por concepto de pensiones y matrícula y es su única fuente de ingreso para brindar educación de calidad.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA TERCERA: OBJETO DEL CONTRATO:</strong>
	Luego del análisis de la solicitud de matrícula y la documentación presentada, así como de los datos consignados en ella y de las pruebas y valoraciones efectuadas, LA {$antes_del_nombre} {$nombre_colegio} acepta otorgar la matricula solicitada para el (la) estudiante, para brindarle el servicio educativo comprobado, conforme a su oferta constante en el Proyecto Educativo Institucional - PEI y con sujeción al Código de Convivencia y demás normatividad interna institucional.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA CUARTA: CONTRAPRESTACIÓN DEL SERVICIO EDUCATIVO:</strong> 
	Se entiende como servicio educativo, la oferta que efectúa la {$antes_del_nombre} {$nombre_colegio}, de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} en la formación y educación, bajo el sistema escolarizado de los niños y jóvenes de conformidad a su PEI, y comprende las actividades y servicios de clases en todo su sistema de educación, controles y seguridad interna, materiales de uso común como laboratorios de computación, (de) química, y biología, implementos deportivos, canchas, biblioteca, tutorías, asesoría estudiantil, servicio pedagógico, psicopedagógico, médico y toda actividad propia del sistema educativo programado en el PEI. Como contraprestación del servicio educativo que brinda {$antes_del_nombre} {$nombre_colegio},  de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} al (la) estudiante, el (la) representante se obliga a pagar los valores fijados por concepto de matrícula y pensiones, para cada año lectivo.
	<br/>
	<b>LA MATRÍCULA:</b> Se pagará una sola vez al año en el periodo señalado para el efecto.
	<br/>
	<b>VALOR DE LA PENSIÓN:</b> Se fijará un valor de pago prorrateado en 10 mensualidades, que corresponde a la contraprestación del servicio educativo que se otorga al (la) estudiante y en el que se incluye todos los servicios de educación (educativos): pensión que no excederá el monto autorizado por la Autoridad Educativa Nacional para el rango que le corresponde a la {$antes_del_nombre} {$nombre_colegio}, de propiedad de la compañía {$antes_del_nombre} {$nombre_legal}.<br/>   
	Para el {$_SESSION['peri_deta']}, la pensión fijada para cada uno de los diez periodos mensuales, será de $ {$row_valores["precio_pension"]}, pagaderos dentro de los 10 primeros días hábiles de cada período mensual.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SÉPTIMA: FORMA DE PAGO,  PLAZOS, COMPROMISOS Y OBLIGACIONES:</strong> 
	Entendiéndose que el pago de la matrícula y pensiones como contraprestación del servicio educativo, sirve para poder cubrir los costos del proceso de enseñanza aprendizaje, que genera los gastos comunes como: remuneraciones a profesores, energía eléctrica, internet, agua potable, materiales e insumos, pagos de seguros, proveedores, y costo de dividendo de préstamos, las partes establecen, (y) se comprometen y obligan al siguiente proceso y plazos:
	<ol>
	<li>
	La institución se obliga a dar educación comprobada, en la forma y modo constante en su Proyecto Educativo Institucional (PEI), Código de Convivencia de {$antes_del_nombre} {$nombre_colegio},  de propiedad de la compañía  {$antes_del_nombre} {$nombre_legal} y demás normatividad que rigen a la {$antes_del_nombre} {$nombre_colegio}, de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} con sujeción a la Constitución de la República, Ley de Educación, su Reglamento y demás normatividad y disposición válida y legal, de la Autoridad de Educación competente. Todo valor pagado a la {$antes_del_nombre} {$nombre_colegio} de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} deberá ser efectuado en dinero efectivo o cheques certificados a través de las ventanillas del banco que la Institución indique,  emisión de voucher de tarjeta de crédito pagando cuotas mensuales y/o autorización de débito automático de una tarjeta de crédito o débito a una cuenta corriente o de ahorro y quien lo reciba, emitirá el comprobante (recibo) respectivo a nombre de la institución.
	</li>
	<li>
	El valor por concepto de matrícula, deberá ser cancelada hasta antes del primer día de clases (siempre que exista el cupo) y sólo con el cumplimiento de dicho requisito indispensable, se formalizará la matrícula y el aspirante adquiere la calidad de estudiante. Se dará preferencia en la reserva y otorgamiento de cupos para matrículas a los representantes de nuestros estudiantes o sus familiares, siempre que hayan manifestado su voluntad de estudiar o continuar en la {$antes_del_nombre} {$nombre_colegio} de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} durante el periodo señalado para el efecto.
	</li>
	<li>
	El no actualizar los datos o reservar el cupo mediante el contrato de prestación de servicios educativos dentro de las fechas señaladas por la “UNIDAD EDUCATIVA" es considerado como la manifestación de voluntad de no continuar utilizando los servicios educativos que oferta la Institución y por tanto, desisten del cupo para el próximo año, lo cual (que), nos deja en libertad a la {$antes_del_nombre} {$nombre_colegio} de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} de disponerlo, en beneficio de otro estudiante.
	</li>
	<li>
	El pago de la pensión será durante los 10 primeros días de cada periodo mensual, sea que este se contabilice del 1 al 30 de cada mes, en cuyo caso pagará hasta el día 5; o se contabilice del día 15 de un mes al 14 del otro mes, en cuyo caso el pago será hasta el 20, sin que esto, pueda considerarse pago adelantado, sino que permitirá (para) cubrir los valores de gastos que la contraprestación del servicio genere durante dicho período mensual que ya decurre.
	</li>
	<li>
	No se aumentará la pensión o cuota mensual acordada, durante el año lectivo que rige el presente contrato. Para el ajuste de la pensión, se estará pendiente de (a) la normativa expedida por la autoridad educativa.
	</li>
	<li>
	El representante acepta que la {$antes_del_nombre} {$nombre_colegio}, acorde a las buenas prácticas administrativas financieras puede ejecutar procedimientos de cobranza de las obligaciones económicas dentro de lo que las leyes permiten.
	</li>
	<li>
	Las circulares a través de correos electrónicos, página web, diario escolar son las vías acordadas para mantener una intercomunicación fluida con el representante del estudiante, dándole a conocer sobre el accionar diario, hoja de vida, tareas y demás asuntos, noticias o comunicaciones relacionados con el accionar educativo, a la vez, ustedes podrán comunicarse con los directivos, tutores, inspectores y profesores, simplificando la interrelación entre la Unidad Educativa y la madre o el padre de familia o representante, por lo cual (el representante) se compromete a revisarlo día a día, en forma periódica.<br/>
	Para los casos de justificaciones de asistencia y de solicitud de exámenes atrasadas, estos deberán ser notificados al Establecimiento Educativo, vía escrita, adjuntando los respectivos documentos de soporte.
	</li>
	<li>
	Es obligación y se compromete el representante, a revisar diariamente el contenido de los maletines, maletas, portafolios y mochilas del educando, para evitar que traigan a la institución objetos, como  armas, sustancias prohibidas o nocivas a la salud física o mental, (y) materiales extraños al proceso educativo o de mucho valor.
	</li>
	</ol>
	<p>
	El servicio educativo de {$antes_del_nombre} {$nombre_colegio}, de propiedad de la compañía {$antes_del_nombre} {$nombre_legal} es inclusivo para niños y jóvenes con necesidades educativas especiales que se encuentren consideradas como leves y dentro del primer grado de dificultad, siempre que no sean combinadas. No es un centro de estudios de educación especial, por lo que, si el estudiante necesita más apoyo para mejorar o superar  su conducta o aprendizaje, se podrá autorizar que ingresen y laboren, profesionales o personas especializadas en esas áreas (educación especial) para brindarles atención complementaria con servicio fijo o itinerante, en los casos más serios o complejos, para efectuar acompañamiento y apoyo personalizado al estudiante, a costa y responsabilidad del representante.
	</p>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEXTA: DURACIÓN:</strong> 
	El presente contrato tiene duración de un año lectivo, pero podrá ser renovado por mutuo acuerdo, donde se proceda a reservar o solicitar la matrícula para el próximo año lectivo, actualizando los datos correspondientes para las notificaciones. Se entenderá renovado en todas sus partes, si no existe pronunciamiento alguno sobre la voluntad de dejarlo sin efecto, y en ese caso, el costo de la pensión se reajustará al que se fijare legalmente para el año que corresponda o recurra, según el rango.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SÉPTIMA: DE LA TERMINACIÓN DEL CONTRATO:</strong>
	El presente contrato concluirá por las siguientes causas:
	<ol>
	<li>Por el vencimiento del plazo, caso en el cual, culminará de pleno derecho.</li>
	<li>Por voluntad o acuerdo de ambas partes.</li>
	<li>Por fallecimiento del (la) estudiante.</li>
	<li>Por fallecimiento del representante del estudiante, a menos que otra persona con derecho suficiente asuma la representación del educando. En lo relativo al pago de pensiones, se estará a lo establecido en los Art. 7 literal J) y 135 de la LOEI.</li>
	<li>Por suspensión de actividades de la unidad educativa por más de sesenta días o por cierre definitivo.</li>
	<li>Por voluntad del representante. Si una vez matriculado el alumno, sus progenitores o representantes deciden retirarlo de {$nombre_colegio}, deberán comunicar de inmediato a los directivos de la institución. No se podrá solicitar el reembolso de la matrícula ni de las pensiones que hayan sido devengadas. El Representante se obliga a cancelar los valores correspondientes a los servicios educativos y adicionales voluntarios recibidos a favor del estudiante que representa, hasta el último periodo mensual de asistencia al plantel.</li>
	<li>Por incumplimiento de cualquiera de las cláusulas que se establecen en este contrato, Código de Convivencia, o por incumplimiento de disposiciones emanadas de las autoridades de la institución y que correspondan al desarrollo de los programas educativos.</li>
	<li>Por incurrir sus representados en las faltas que establece el Art. 134 de la Ley Orgánica de Educación Intercultural.</li>
	<li>9)	Por las demás causas previstas en el ordenamiento jurídico del país, Código de Convivencia y Reglamentos de la institución.</li>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA OCTAVA: DE LA MORA DEL REPRESENTANTE LEGAL DEL ESTUDIANTE:</strong> 
	El representante legal, que no cumpla sus obligaciones de pago de pensiones, entrará en mora. Ante esta situación la Institución procederá a realizar tres notificaciones de recordatorio de pago. En caso de persistir el incumplimiento, se notificará al Área Legal de la Unidad Educativa, con el propósito que inicie las medidas judiciales que dieren a lugar de conformidad a la normativa vigente, para cobrar los valores adeudados, más los gastos que la Institución Educativa deba incurrir, tales como, honorarios profesionales y demás.
	En caso de que el representante legal continúe en mora una vez finalizado el Periodo Lectivo, la Unidad Educativa se reservará el derecho de conceder matrícula para Año Escolar venidero, así mismo, se brindarán las facilidades en aras que pueda inscribir a su representado en una Institución Educativa de sostenimiento fiscal.  
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA NOVENA: DEL SEGURO DE ACCIDENTES PERSONALES:</strong> 
	De conformidad a la normativa expedida por el Ministerio de Educación, en el Acuerdo Ministerial 387-13 y su reforma, se pone a consideración de los padres de familia un seguro de accidentes personales, en aras de cubrir posibles lesiones que pueda tener el estudiantes dentro de la institución educativa. En caso de que el padre de familia no acepte dicho seguro, deslinda de responsabilidad a la Institución Educativa, en relación al posible accidente. 
	La institución educativa solamente se compromete, en caso de accidente a llamar al ECU-911, para que brinde la asistencia que sea del caso.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA DÉCIMA: TRÁMITE Y COMPETENCIA: CLÁUSULA COMPROMISORIA:</strong> 
	Cualquier controversia, diferencia o reclamación que se derive o esté relacionada con la interpretación o ejecución del presente convenio, en atención a lo establecido en la Ley de Arbitraje y Mediación, será sometida a mediación de uno de los Centros de Mediación y Arbitraje, legalmente constituidos y autorizados para actuar de conformidad a la Ley de Arbitraje y Mediación y su Reglamento de aplicación,  comprometiéndose las partes a aceptar las medidas cautelares necesarias, a aceptar la mediación o conciliación en caso de que sea procedente y acatar el laudo arbitral que se expidiere, desistiendo de presentar recurso alguno respecto del mismo.
	</p>
	<p class="letras_pequenas">
	Para constancia de lo acordado, , las partes suscriben el presente contrato en la ciudad de {$fecha_hoy}
	</p>
	<p class="letras_pequenas">
	FIRMAS DEL CONTRATO DE PRESTACIONES DE SERVICIOS EDUCACIONALES.
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
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/><br/>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	Número de cédula: {$representante["cedula"]}
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
	</table> 
	<p>Reconocimiento Judicial</p>
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
	Gerente de la {$antes_del_nombre} {$nombre_colegio}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/><br/>
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
