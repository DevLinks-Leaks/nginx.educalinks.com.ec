<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='contrato.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
		
	$sql1="{call alum_info_contrato(?)}";
	$params = array($_GET['alum_curs_para_codi']);
	$stmt = sqlsrv_query($conn, $sql1, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

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
		$params = array($alumno["matricula"], "R");
		$stmt_repr = sqlsrv_query($conn, $sql, $params);
	
		if( $stmt_repr === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$representante=sqlsrv_fetch_array($stmt_repr);
		
		$pdf->AddPage();
		$fecha_hoy=date("d/m/y");
		if ($_SESSION['codi']==2)
		{
			if ($alumno["curs_orden"]==1 or $alumno["curs_orden"]==2)
			{
				$valor_matricula=89.10;
				$valor_pension=142.56;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="OCHENTA Y NUEVE CON 10/100 DÓLARES AMERICANOS";
				$valor_pension_letras="CIENTO CUARENTA Y DOS CON 56/100 DÓLARES AMERICANOS";
				$total_deuda_letras="MIL QUINIENTOS CATORCE CON 70/100 DÓLARES AMERICANOS";
			}
			if ($alumno["curs_orden"]>=3 and $alumno["curs_orden"]<=12)
			{
				$valor_matricula=93.15;
				$valor_pension=149.04;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="NOVENTA Y TRES CON 15/100 DÓLARES AMERICANOS";
				$valor_pension_letras="CIENTO CUARENTA Y NUEVE CON 04/100 DÓLARES AMERICANOS";
				$total_deuda_letras="MIL QUINIENTOS OCHENTA Y TRES CON 55/100 DÓLARES AMERICANOS";
			}
			if ($alumno["curs_orden"]>=13 and $alumno["curs_orden"]<=15)
			{
				$valor_matricula=101.25;
				$valor_pension=162.00;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="CIENTO UN CON 25/100 DÓLARES AMERICANOS";
				$valor_pension_letras="CIENTO SESENTA Y DOS CON 00/100 DÓLARES AMERICANOS";
				$total_deuda_letras="MIL SETECIENTOS VEINTI UNO CON 25/100 DÓLARES AMERICANOS";
			}
		}
		
		if ($_SESSION['codi']==11)
		{
			if ($alumno["curs_orden"]>=3 and $alumno["curs_orden"]<=9)
			{
				$valor_matricula=75.00;
				$valor_pension=55.00;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="SETENTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
				$valor_pension_letras="CINCUENTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
				$total_deuda_letras="SEISCIENTOS VEINTI CINCO CON 00/100 DÓLARES AMERICANOS";
			}
			if ($alumno["curs_orden"]>=10 and $alumno["curs_orden"]<=12)
			{
				$valor_matricula=80.00;
				$valor_pension=65.00;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="OCHENTA CON 00/100 DÓLARES AMERICANOS";
				$valor_pension_letras="SESENTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
				$total_deuda_letras="SETECIENTOS TREINTA CON 00/100 DÓLARES AMERICANOS";
			}
			if ($alumno["curs_orden"]>=13 and $alumno["curs_orden"]<=15)
			{
				$valor_matricula=85.00;
				$valor_pension=65.00;
				$valor_pension_anual=$valor_pension*10;
				$total_deuda=$valor_pension_anual+$valor_matricula;
				$valor_matricula_letras="OCHENTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
				$valor_pension_letras="SESENTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
				$total_deuda_letras="SETECIENTOS TREINTA Y CINCO CON 00/100 DÓLARES AMERICANOS";
			}
		}
	
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
	.contenedor
	{
		width: 100%;
	}
	.letras_pequenas
	{
		font-size: 10px;
		text-align: justify;
	}
	</style>
	<div class="contenedor">
	<h1>CONVENIO DE MATRICULA</h1>
	<p class="letras_pequenas">
	Conste por el presente documento, el Convenio de Matrícula al que hace referencia la Disposición General Segunda del Acuerdo 00493-12 del Ministerio de Educación, expedido el 14 de diciembre de 2012, el mismo que se celebra al tenor de las siguientes cláusulas:
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA PRIMERA: INTERVINIENTES:</strong> Participan en forma libre y voluntaria en la celebración del presente convenio, por una parte el (la) señor (a) {$representante["nombres"]} a quien en lo posterior podrá denominarse como “el (la) representante”, quien comparece a nombre y en representación del (la) menor Alumno(a): {$alumno["nombres"]} {$alumno["apellidos"]} a quien en lo posterior podrá denominarse como “el (la) estudiante”; y por la otra, el Ing. Fernando Ampuño Cucalón, por los derechos que representa de ESPIRITU DE BABAHOYO CENTRO DE ESTUDIOS EBCES S.A., propietaria de la Unidad Educativa “ECOMUNDO”, en su calidad de Gerente y a quien en lo posterior podrá denominarse como “Ecomundo” o “la institución”.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEGUNDA: ANTECEDENTES: UNO:</strong> El (la) representante, conocedor de la misión, visión, filosofía, principios, Proyecto Educativo Institucional - PEI,  Código de Convivencia y demás reglamentación  y normatividad interna de Ecomundo, y luego de una serie de análisis y comparación de su oferta educativa con la de otras instituciones,   ha solicitado matrícula en la Institución  para su representado el (la) estudiante (referidos en la cláusula anterior), para el {$alumno["detalle"]}., para lo cual ha presentado la solicitud de matrícula con los compromisos a los que se obliga y consigna los datos personales correspondientes, documentos y declaraciones que forman parte integrante del presente convenio de matrícula.
	DOS: ECOMUNDO es una Unidad Educativa autofinanciada de carácter particular, legalmente reconocida y autorizada por las autoridades de educación, que brinda servicios educativos ofertados en el PEI y en la forma y modo señalado en la Constitución y Leyes de la República del Ecuador, recibiendo como contraprestación del servicio educativo el monto económico fijado en legal forma por concepto de pensiones y matrícula, siendo esa su única fuente de ingreso para brindar educación de calidad.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA TERCERA: OBJETO DEL CONVENIO:</strong> Luego del análisis de la solicitud de matrícula y la documentación presentada, así como  de los datos consignados en ella y de las pruebas y valoraciones efectuadas, Ecomundo, acepta otorgar  la matrícula solicitada para el (la) estudiante, para brindarle el servicio educativo de calidad y calidez, conforme a su oferta constante en el Proyecto Educativo Institucional - PEI, con sujeción al Código de Convivencia y demás normatividad interna institucional. La matrícula se encuentra condicionada a que se cumplan todas las obligaciones legales, del Código de Convivencia, Reglamentos Internos y las cláusulas del presente convenio.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA CUARTA: CONTRAPRESTACIÓN DEL SERVICIO EDUCATIVO:</strong> Se entiende como servicio educativo, la oferta que efectúa Ecomundo para la formación y educación, bajo el sistema escolarizado de los niños, niñas y jóvenes de conformidad a su PEI,  y comprende las actividades y servicios de clases en todo su sistema de educación, controles y seguridad interna, seguro de accidentes, implementos de uso común como laboratorios de computación, de física - química, biología y anatomía, implementos deportivos y canchas, tutorías, asesoría y consejería estudiantil, servicio pedagógico, y primeros auxilios, y toda actividad propia del sistema educativo programado y que conste en el PEI. Como contraprestación del servicio educativo que brinda Ecomundo al (la/los) estudiante (s), el (la) representante se obliga a pagar los valores fijados por la autoridad educativa por concepto de matrícula y pensiones prorrateadas a 10 meses, para cada año lectivo. 
	LA MATRÍCULA: Se pagará una sola vez al año en el periodo señalado para el efecto y el valor no podrá ser superior al 75% de la cuota mensual de la pensión que cobre Ecomundo. 
	VALOR DE LA PENSIÓN: Se fijará un valor de pago prorrateado en 10 mensualidades o periodos mensuales, que corresponde a la contraprestación del servicio de educación que se otorga al (la) estudiante y en el que se incluye todos los servicios de educación; pensión que no excederá el monto autorizado por la Autoridad Educativa para el rango que le corresponde a Ecomundo.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA QUINTA: OBLIGACION DE PAGO POR LOS SERVICIOS EDUCATIVOS.</strong>
	Los valores que ECOMUNDO cobrará por los servicios educativos constituyen los valores correspondientes a la matrícula anual y la pensión fijada por la autoridad correspondiente, por lo que él (la) representante declara que debe y pagará, y se obliga a pagar incondicionalmente para cubrir los servicios educativos básicos, los siguientes rubros:
	<ol>
	<li>
	El valor de la matrícula es de $ {$valor_matricula} ({$valor_matricula_letras}) para el período lectivo {$_SESSION['peri_deta']}.
	</li>
	<li>
	La pensión equivale a $ {$valor_pension_anual} anual por el servicio educativo que se le brinda por el año académico {$_SESSION['peri_deta']}. Este valor será prorrateado en diez mensualidades iguales de $ {$valor_pension} ({$valor_pension_letras}) pagaderas los siete primeros días de cada período mensual.
	</li>
	<li>
	Para el cumplimiento de los términos y condiciones del pago del servicio educativo contratado, el (la) representante, Sr./Sra {$representante["nombres"]} reconoce que debe y, promete que pagará, a la orden y a favor de ESPIRITU DE BABAHOYO CENTRO DE ESTUDIOS EBCES S.A. en forma incondicional, en sus oficinas ubicadas en la Av. Enrique Ponce Luque y Calle “A”, en la ciudad de Babahoyo, donde funciona ECOMUNDO, y en la fecha que se me reconvenga,  la suma de $ {$total_deuda} ({$total_deuda_letras}) equivalente al valor total de la matrícula y los 10 meses de pensiones prorrateadas, reconociendo a esta obligación, el valor de Pagaré a la orden de ESPIRITU DE BABAHOYO CENTRO DE ESTUDIOS EBCES S.A., el mismo que se entiende suscrito y aceptado en el lugar y fecha en que se firma este contrato, sin protesto, y que constituye título de crédito con una obligación líquida, pura y de plazo vencido, exigible en juicio ejecutivo ante uno de los jueces de lo civil del cantón Babahoyo.
	</li>
	<li>
	Sólo el recibo de pago emitido por Ecomundo o la institución bancaria autorizada, será el documento probatorio que evidencie el pago de la matrícula y pensiones mensuales.
	</li>
	</ol>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEXTA: FORMA DE PAGO,  PLAZOS, COMPROMISOS Y OBLIGACIONES:</strong> Entendiéndose que el pago de la matrícula y pensiones como contraprestación del servicio educativo, sirve para poder cubrir los costos del proceso enseñanza aprendizaje, que genera los gastos comunes como: remuneraciones a profesores, energía eléctrica, agua potable, materiales e insumos, pagos de seguros y proveedores, arriendo y costo de dividendo de préstamos, las partes establecen se comprometen y obligan al siguiente proceso y plazos:
	<ol>
	<li>    
	La institución se obliga a dar educación de calidad con calidez, en la forma y modo constante en su Proyecto Educativo Institucional (PEI), Código de Convivencia de Ecomundo, Reglamentos internos y demás normatividad que rige en Ecomundo, con sujeción a la Constitución de la República, Ley de Educación, su Reglamento y demás normatividad y disposición válida y legal, de la Autoridad de Educación competente.
	</li>
	<li>
	Todo valor pagado a Ecomundo deberá ser efectuado mediante débito bancario automático o recurrente a cuenta corriente o de ahorro, o mediante tarjeta de débito o de crédito, en la caja correspondiente del Banco que autorice Ecomundo, emitiéndose como constancia el comprobante respectivo, el mismo que se constituye en única evidencia de cumplimiento.
	</li>
	<li>
	El valor por concepto de matrícula, deberá ser cancelada durante el período señalado para el efecto, hasta antes del primer día de clases y solo con el cumplimiento de dicho requisito indispensable, se formalizará la matrícula y el aspirante adquiere la calidad de estudiante. Se dará preferencia en la reserva y otorgamiento de cupos para matrículas a los representantes de nuestros estudiantes o sus familiares, siempre que hayan manifestado durante el periodo señalado para el efecto, su voluntad de estudiar o continuar en Ecomundo.
	</li>
	<li>
	El no actualizar los datos y reservar el cupo mediante  dentro de las fechas señaladas por Ecomundo, es considerado como la manifestación de voluntad de no continuar utilizando los servicios educativos que oferta la Institución y por tanto, desisten del cupo para el próximo año, lo cual deja en libertad a Ecomundo de disponerlo, en beneficio de otro estudiante. 
	</li>
	<li>
	El pago de la pensión será durante  cada periodo mensual que corresponda, sea que éste se contabilice del día 1 al 30 de cada mes, o del 15 de un mes al día 14 del otro mes. Se beneficia el “pronto pago” o “pago oportuno” con  un descuento del 7 % como estímulo para quienes cancelen las pensiones mensuales durante los 7 primeros días de cada período mensual que corresponda, sin que esto pueda considerarse pago adelantado. Si no ha cancelado la pensión terminado el período mensual, se considerará que el representante se encuentra en mora. 
	</li>
	<li>
	No se aumentará  la pensión o cuota mensual acordada, durante el año lectivo que rige el presente contrato, salvo autorización de autoridad competente. Para el cálculo y ajuste de la matrícula y pensión, se aplicará la normativa expedida por la autoridad educativa. 
	</li>
	<li>
	La mora del  primer mes será considerado como un atraso. Si no paga el segundo mes, el representante será requerido para el pago de lo adeudado como contraprestación del servicio educativo y si persiste en la falta de pago, cumplido el tercer mes de mora, el padre de familia o representante, ante la imposibilidad de cumplir con su compromiso en el pago de la pensión como contraprestación del servicio educativo, para evitar problemas familiares, psicológicos, de estrés, o conflictividad con el sistema, el representante se obliga a cambiarlo a otra institución fiscal gratuita o particular acorde sus posibilidades, para lo cual deberá solicitar el pase a otra institución educativa, o solicitar en forma directa la documentación del estudiante. Sin perjuicio de las acciones legales que se tomen para el cobro de las pensiones adeudadas.
	</li>
	<li>
	En caso de que el representante, no cumpla con cambiar de institución educativa al estudiante, para evitarle problemas psicológicos, al tener que asistir a Ecomundo a sabiendas que su representante no ha cumplido su compromiso contractual, lo que podría acarrear  trastornos en su comportamiento y que afectaría su proceso formativo, sobre todo en su  rendimiento y  comportamiento, Ecomundo  recurrirá al Centro de Mediación de la Dirección Distrital de Educación correspondiente, explicando el caso mediante escrito, al que se adjuntará copia certificada del presente convenio como justificativo para el cumplimiento de lo acordado; y en beneficio del estudiante, para que no se conculque el derecho a la educación,  siendo obligación del Estado el proporcionarle al menor éste servicio público en forma gratuita, procederá a ubicarlo o asignarle una entidad educativa fiscal que según el sector que le corresponda, donde deba continuar su proceso educativo. En este caso Ecomundo procederá a entregar la documentación del estudiante a la autoridad de mediación o la remitirá oficialmente a la entidad que se designe en el trámite correspondiente. De esa forma, se evitará que el incumplimiento en el pago interrumpa el proceso educativo del estudiante. Se deja a salvo el derecho de Ecomundo para cobrar al representante las pensiones adeudadas.
	</li>
	<li>
	En caso de falta de pago o mora en las pensiones u obligaciones para con Ecomundo, no se podrá otorgar o renovar matrícula al estudiante para el próximo año lectivo, por lo que, el representante lo matriculará en otra institución, para no conculcarle el derecho a la educación a su representado.
	</li>
	<li>
	El correo electrónico, redes sociales y el aula virtual son las  vías acordadas para mantener una intercomunicación fluida con el representante del estudiante, dándole a conocer sobre el accionar diario, hoja de vida, tareas, citaciones, noticias,  comunicaciones y demás asuntos relacionados con el accionar educativo, a la vez, los representantes podrán comunicarse con los directivos y profesores, simplificando la interrelación entre la Unidad Educativa y el representante, por lo cual se comprometen a revisarlos día a día, en forma periódica.
	</li>
	<li>
	Es obligación y se compromete el representante revisar diariamente el contenido de los maletines, maletas portafolios y mochilas del educando, para evitar que traigan a la institución objetos, sustancias, materiales extraños al proceso educativo o de mucho valor, o sustancias prohibidas o nocivas a la salud física o mental.
	</li>
	<li>
	El servicio educativo de Ecomundo es inclusivo para niños y jóvenes con necesidades educativas especiales que se encuentren consideradas como leves y dentro del primer grado de dificultad, siempre que no sean combinadas. No es un centro de educación especial, por lo que, si el estudiante necesita más apoyo para mejorar o superar su conducta o aprendizaje, se podrá autorizar que ingresen y laboren, profesionales o personas especializadas en esas áreas para brindarles atención complementaria con servicio fijo o itinerante, en los casos más serios o complejos, para efectuar acompañamiento y apoyo personalizado al estudiante, a costa y responsabilidad del representante.
	</li>
	<li>
	Para poder aplicar o sujetarse al programa de inclusión, es necesario que así se determine en el respectivo convenio y contar con evaluaciones externas iniciales y periódicas, para verificar el avance del programa y su conveniencia para la formación, aprendizaje y continuidad del estudiante en el programa inclusivo. De no existir las evaluaciones y compromiso del representante se aplicará el programa escolarizado general.
	</li>
	<li>
	Si luego de haberse matriculado el menor, se estableciere que necesita apoyo especial del programa de inclusión, su representante deberá cumplir con el programa de inclusión de Ecomundo, sus presupuestos y requisitos.
	</li>
	</ol>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEPTIMA: DURACIÓN:</strong> El presente convenio tiene duración de un año lectivo, pero podrá ser renovado por mutuo acuerdo mediante el correspondiente convenio de matrícula para el próximo año lectivo, actualizando los datos correspondientes para las notificaciones. Se entenderá renovado en todas sus partes, si  no existe pronunciamiento alguno  de una de las partes  sobre la voluntad de dejarlo sin efecto, y en ese caso, el costo de la matrícula y pensión se reajustará al que se fijare legalmente para el año que corresponda o decurra.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA OCTAVA: DE LA TERMINACIÓN DEL CONTRATO:</strong>
	El presente contrato concluirá por las siguientes causas:
	<ol>
	<li>
	Por el vencimiento del plazo, caso en el cual, culminará de pleno derecho.
	</li>
	<li>
	Por voluntad o acuerdo de ambas partes.
	</li>
	<li>
	Por fallecimiento del (la) estudiante.
	</li>
	<li>
	Por fallecimiento del representante del estudiante, a menos que otra persona con derecho suficiente asuma la representación del educando. En lo relativo al pago de pensiones, se estará a lo establecido en los Art. 7 literal J) y 135 de la LOEI.
	</li>
	<li>
	Por suspensión de actividades de la unidad educativa por más de sesenta días o por cierre definitivo.
	</li>
	<li>
	Por voluntad del representante. Si una vez matriculado el alumno, sus progenitores o representantes deciden retirarlo de ECOMUNDO, deberán comunicar de inmediato a los directivos de la institución. No se podrá solicitar el reembolso de la matrícula ni de las pensiones que hayan sido devengadas. El Representante se compromete a cancelar los valores correspondientes a los servicios educativos y adicionales voluntarios recibidos a favor del estudiante que representa, hasta el último periodo mensual de asistencia al plantel.
	</li>
	<li>
	Por incumplimiento de cualquiera de las cláusulas que se establecen en este contrato, Código de Convivencia, o de los Reglamentos Internos, o por incumplimiento de disposiciones emanadas de las autoridades de ECOMUNDO y que correspondan al desarrollo de los programas educativos.
	</li>
	<li>
	Por incurrir sus representados en las faltas que establece el Art. 134 de la Ley Orgánica de Educación Intercultural.
	</li>
	<li>
	Por las demás causas previstas en el ordenamiento jurídico del país, Código de Convivencia y Reglamentos de ECOMUNDO.
	</li>
	</ol>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA NOVENA: TRAMITE Y COMPETENCIA: CLAUSULA COMPROMISORIA:</strong> Cualquier controversia, diferencia o reclamación que se derive o esté relacionada con la interpretación o ejecución del presente convenio, en atención a lo establecido en la Ley de Arbitraje y Mediación, será sometida a mediación del Centro de Mediación de la Dirección Distrital de Educación de Los Ríos, y en caso de que las partes intervinientes no hayan podido llegar a un acuerdo, según el Artículo 47 ibídem, las partes se someten en forma expresa, para que sea resuelta por uno de  los Tribunales de Arbitraje del Centro de Arbitraje y Mediación - CAM de la Universidad de Especialidades Espíritu Santo - UEES, comprometiéndose las partes a aceptar las medidas cautelares necesarias, a aceptar la mediación o conciliación en caso de que sea procedente y acatar el laudo arbitral a expedirse, desistiendo de presentar recurso alguno respecto del mismo.
	</p>
	<p class="letras_pequenas">
	Para constancia de lo acordado, las partes suscriben el presente convenio en la ciudad de Babahoyo, el {$fecha_hoy}.
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
	Ing. Fernando Ampuño Cucalón<br/>
	Gerente Espiritu de Babahoyo EBCES S.A.
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/><br/>
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
}
	
$pdf->Output('cert_matricula.pdf', 'I');
?>
