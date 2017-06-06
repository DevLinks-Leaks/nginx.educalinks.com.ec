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
		$params = array($alumno["matricula"], "R");
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
			<td width="25%"><img width="45px" height="50px" src="../{$_SESSION['ruta_foto_logo_web']}" /></td>
			<td class="centrar"><h1>CONVENIO DE MATRÍCULA</h1></td>
			<td class="derecha" style="font-size: 8px" width="25%">Código: R13-08 Versión: 3.0 <br/>Noviembre 2015</td>
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento, el Convenio de Matrícula que se celebra en forma libre y voluntaria entre las partes, al tenor de las siguientes cláusulas:
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA PRIMERA: INTERVINIENTES:</strong> 
	Participan en forma libre y voluntaria en la celebración del presente convenio, por una parte el (la) señor (a) {$representante["nombres"]}. a quien en lo posterior podrá denominarse como “el (la) representante”, quien comparece a nombre y en representación del (la) menor {$alumno["nombres"]} {$alumno["apellidos"]} a quien en lo posterior podrá denominarse como “el (la) estudiante”; y por la otra, el(la) {$nombre_financiero}, por los derechos que representa de la {$antes_del_nombre} {$nombre_colegio}, en su calidad de Director financiero y a quien en lo posterior podrá denominarse como “{$nombre_colegio}” o “la institución”.
	</p>
	
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEGUNDA: ANTECEDENTES: UNO:</strong> 
	El (la) representante, conocedor de la misión, visión, filosofía, principios, Proyecto Educativo Institucional - PEI,  Código de Convivencia, Reglamento Interno y demás reglamentación  y normatividad interna del {$nombre_colegio}, y luego de una serie de análisis y comparación de su oferta educativa con la de otras instituciones,   ha solicitado matrícula en la Institución  para su representado el (la) estudiante (referidos en la cláusula anterior), para el {$alumno["detalle"]}, para lo cual ha presentado la solicitud de matrícula con los compromisos a los que se obliga y consigna los datos personales correspondientes, documentos y declaraciones que forman parte integrante del presente convenio de matrícula.
	<br/>
	<b>DOS:</b>
	{$nombre_colegio} es una Unidad Educativa autofinanciada de carácter particular, legalmente reconocida y autorizada por las autoridades de educación, que brinda servicios educativos ofertados en el PEI y en la forma y modo señalado en la Constitución y Leyes de la República del Ecuador, recibiendo como contraprestación del servicio educativo el monto económico fijado en legal forma por concepto de pensiones y matrícula, siendo esa su única fuente de ingreso para brindar educación de calidad.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA TERCERA: OBJETO DEL CONVENIO:</strong>
	Luego del análisis de la solicitud de matrícula y la documentación presentada, así como  de los datos consignados en ella y de las pruebas y valoraciones efectuadas, {$nombre_colegio} acepta otorgar  la matrícula solicitada para el (la) representante del (la) estudiante, para brindarle el servicio educativo de calidad y calidez, conforme a su oferta constante en el Proyecto Educativo Institucional - PEI, con sujeción al Código de Convivencia y demás normatividad interna institucional; y, en especial al presente convenio que de conformidad a la normatividad legal, es considerado Ley entre las partes. La matrícula y servicio educativo, se encuentra condicionada a que se cumplan todas las obligaciones legales, del Código de Convivencia, Reglamentos Internos y las cláusulas del presente convenio.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA CUARTA: CONTRAPRESTACIÓN DEL SERVICIO EDUCATIVO:</strong> 
	Se entiende como servicio educativo, la oferta que efectúa {$nombre_colegio} en la formación y educación, bajo el sistema escolarizado de los niños (as) y jóvenes de conformidad a su PEI,  y comprende las actividades y servicios de clases en todo su sistema de educación, controles y seguridad interna, implementos de uso común como laboratorios de computación, de física, química y biología, implementos deportivos, canchas y piscina, biblioteca, tutorías, asesoría estudiantil, servicio pedagógico, psicopedagógico y médico, y toda actividad propia del sistema educativo programado en el PEI. Como contraprestación del servicio educativo que brinda Liceo Panamericano al (la) estudiante, el (la) representante se obliga a pagar los valores fijados por la autoridad educativa por concepto de matrícula y pensiones prorrateadas a 10 meses o en los meses que señale la autoridad competente, para cada año lectivo, durante los cinco primeros días de cada mes. Así mismo los valores que voluntariamente se comprometa a pagar el representante por los servicios complementarios o no educativos.
	<br/>
	<b>LA MATRÍCULA:</b> Se pagará una sola vez al año en el periodo señalado para el efecto y el valor no podrá ser superior al 75% de la cuota mensual de la pensión señalada por la autoridad de educación, pagaderos antes del inicio de clases, sin cuyo pago, no se perfecciona o no entra en vigencia el presente Convenio de Matrícula.
	<br/>
	<b>VALOR DE LA PENSIÓN:</b> Se fijará un valor de pago prorrateado en 10 mensualidades o periodos mensuales, o en el número de meses que autorice la autoridad educativa, que corresponde a la contraprestación del servicio de educación que se otorga al (la) estudiante y en el que se incluye todos los servicios educativos; pensión que no excederá el monto anual autorizado por la Autoridad Educativa. En caso que la institución aplique voluntariamente algún programa de descuento, éste no afectará ni modificará la fijación de pensiones y matrículas efectuada por la autoridad educativa, para ese período lectivo.
	<br/>
	<b>VALOR DE OTROS COBROS:</b> Existen otros valores que se cobran en forma periódica o esporádica y que han sido solicitados y aceptados en forma expresa y voluntaria por el (la) representante legal del (la) estudiante, que corresponden a servicios no educativos o complementarios, que son prestados por la institución o facilitados para que los proporcione otras personas naturales o jurídicas dentro de {$nombre_colegio}, como son, entre otros,  los servicios de alimentación, bar, transporte escolar, o de apoyo profesional para educación especial, los que no constituyen elemento propio de la prestación del servicio de educación y no están comprendidos o cubiertos dentro del concepto de pensión y matrícula, por lo que tienen que ser pagados en forma directa por los padres o representantes legales de los estudiantes. Tampoco están cubiertos o considerados dentro de los valores de matrículas y pensiones, aquellos rubros que no constan en los listados oficiales de útiles escolares y libros y serán considerados complementarios y de apoyo, los valores que correspondan a otros libros, cuadernos, y demás útiles escolares, o implementos o materiales de trabajo de aprendizaje, uniformes, disfraces de presentación para eventos u obras de arte, o equipos para eventos deportivos,  sistemas externos de apoyo educativo tecnológico, computadoras personales, IPad o Tabletas, o programas internacionales de estudio (BI) que voluntariamente los padres o representantes aprueben y que se utilicen dentro del sistema educativo como apoyo al mismo, o alquiler de locales o escenarios para incorporaciones, ceremonias o baile de graduados; los cuales deberán ser pagados en forma directa por el representante legal del estudiante al proveedor del bien o servicio, o por intermedio de {$nombre_colegio}, si es que se brinda esa facilidad en beneficio del representante.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA QUINTA:</strong>
	En el presente convenio queda establecido que el (la) representante del (la) estudiante {$alumno["nombres"]} {$alumno["apellidos"]} para el pago de pensiones es quien suscribe el presente convenio {$alumno["repr_factura"]} y la representación legal para asuntos de citaciones, notificaciones  académicos, disciplinarios, retiro de documentos y demás temas educativos que se desprendan de este documento la ejercerá(n) {$alumno["representante"]} y a quien(es) será(n) notificados con los citatorios, comunicaciones, circulares y demás documentación interna, al correo electrónico {$alumno["repr_email"]}.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEXTA: OBLIGACION DE PAGO POR LOS SERVICIOS EDUCATIVOS.</strong>
	Los valores que {$nombre_colegio} cobrará por los servicios educativos constituyen los valores correspondientes a la matrícula anual y la pensión fijada por la autoridad correspondiente, por lo que él (la) representante declara que debe y pagará, y se obliga a pagar incondicionalmente para cubrir los servicios educativos básicos, los siguientes rubros:
	<ol>
	<li>
	Los valores autorizados por el Ministerio de Educación, mediante resolución 000003709D23 de fecha 20 de marzo de 2015, para el cobro de matrículas en el periodo lectivo {$alumnos["periodo"]} es de <span class="subrayado">$ {$row_valores["precio_matricula"]} (US {$val_matri_let} DÓLARES AMERICANOS)</span> y para las pensiones es de <span class="subrayado">$ {$row_valores["precio_pension"]} (US $ {$val_pensi_let} DÓLARES AMERICANOS)</span>.
	</li>
	<li> 
	La {$antes_del_nombre} “{$nombre_colegio}” ha tomado la decisión de efectuar un descuento voluntario al representante del (la) estudiante, quedando en el valor de <span class="subrayado"> $  {$row_valores["precio_matricula"]} (US {$val_matri_let} DÓLARES AMERICANOS)</span> por concepto de matrícula, y en las pensiones mensuales, prorrateado a diez meses, por concepto de “pago oportuno”, como estímulo para quienes cancelen las pensiones mensuales durante los 5 primeros  días, quedando en el valor de <span class="subrayado">$ {$row_valores["desc_prontopago"]} (US {$val_pront_let} DÓLARES AMERICANOS)</span>, por cada mes.
	<br/>
	Si no se paga dentro de los cinco primeros días de cada mes, pierde el beneficio de pago oportuno por ese mes y se compromete a pagar el valor fijado por el Ministerio de Educación. Si por tres meses consecutivos, el (la) representante no cumple con la condición de pagar durante los cinco primeros días, pierde en forma definitiva el descuento otorgado voluntariamente, por el resto de pensiones.
	</li>
	<li>
	A su vez, el (la) representante, autoriza al banco en que mantiene su cuenta de ahorro o corriente, o a quien administra su tarjeta de crédito o débito o para que todos los meses, durante los cinco primero días de cada mes, durante los 10 meses en que se prorratea la pensión, o los meses que señale la autoridad educativa, se efectúe el descuento directo de sus cuentas, pago a Liceo Panamericano el valor que corresponde a la matrícula y pensión. Si el pago no se lo efectúa durante los cinco primeros días, autoriza que el débito se efectúe sin el descuento otorgado voluntariamente por la institución, esto es, el valor completo autorizado por la autoridad educativa.  
	</li>
	<li>
	Para el cumplimiento de los términos y condiciones del pago del servicio educativo contratado, el (la) representante, Sr./Sra  {$alumno["repr_factura"]} reconoce que debe y, promete que pagará, a la orden y a favor de {$antes_del_nombre} {$nombre_colegio}, en forma incondicional, en sus oficinas ubicadas en el Km. 3.5 de la Vía Samborondón, en el cantón {$ciudad}, donde funciona “{$nombre_colegio}”, y en la fecha que se reconvenga,  la suma de <span class="subrayado">$ {$total} (US {$val_pens_tota_let} DÓLARES AMERICANOS)</span>, equivalente al valor total de la matrícula y los 10 meses de pensiones prorrateadas autorizadas por el Ministerio de Educación, reconociendo a esta obligación, el valor de Pagaré a la orden de {$antes_del_nombre} {$nombre_colegio}, el mismo que se entiende suscrito y aceptado en el lugar y fecha en que se firma este contrato, sin protesto, y que constituye título de crédito con una obligación líquida, pura y de plazo vencido, exigible en juicio ejecutivo ante uno de los jueces de lo civil del cantón Samborondón.
	</li>
	<li>
	Sólo el recibo de pago emitido por el {$nombre_colegio} o la institución bancaria autorizada, será el documento probatorio que evidencie el pago de la matrícula y pensiones mensuales.
	</li>
	</ol>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SÉPTIMA: FORMA DE PAGO,  PLAZOS, COMPROMISOS Y OBLIGACIONES:</strong> 
	Entendiéndose que el pago de la matrícula y pensiones como contraprestación del servicio educativo, sirve para poder cubrir los costos del proceso enseñanza aprendizaje, que genera los gastos comunes como: remuneraciones a profesores, energía eléctrica, agua potable, materiales e insumos, pagos de seguros y proveedores, arriendo y costo de dividendo de préstamos, las partes establecen se comprometen y obligan al siguiente proceso y plazos:
	<ol>
	<li>
	La institución se obliga a dar educación de calidad con calidez, en la forma y modo constante en su Proyecto Educativo Institucional (PEI), Código de Convivencia de {$nombre_colegio}, Reglamentos internos y demás normatividad que rige en {$nombre_colegio}, con sujeción a la Constitución de la República, Ley de Educación, su Reglamento y demás normatividad y disposición válida y legal, de la Autoridad de Educación competente.
	</li>
	<li>
	Todo valor pagado a {$nombre_colegio} deberá ser efectuado mediante débito bancario automático o recurrente a cuenta corriente o de ahorro, o mediante tarjeta de débito o de crédito, en la caja correspondiente del Banco que autorice el {$nombre_colegio}, emitiéndose como constancia el comprobante respectivo, el mismo que se constituye en única evidencia de cumplimiento.
	</li>
	<li>
	El (la) representante suscribirá la correspondiente orden de débito automático y recurrente, para que la institución bancaria donde mantiene sus cuentas corrientes o de ahorro, o las tarjetas de crédito o debido, procedan a efectuarle el descuento directo y trasladar esos fondos a la cuenta que señale el {$nombre_colegio}. 
	</li>
	<li>
	El valor por concepto de matrícula, deberá ser cancelada durante el período señalado para el efecto, hasta antes del primer día de clases y solo con el cumplimiento de dicho requisito indispensable, se formalizará la matrícula y el aspirante adquiere la calidad de estudiante. Se dará preferencia en la reserva y otorgamiento de cupos para matrículas a los representantes de nuestros estudiantes o sus familiares, siempre que hayan manifestado durante el periodo señalado para el efecto, su voluntad de estudiar o continuar en el {$nombre_colegio}.
	</li>
	<li>
	El no actualizar los datos y reservar el cupo dentro de las fechas señaladas por el {$nombre_colegio}, es considerado como la manifestación de voluntad de no continuar utilizando los servicios educativos que oferta la Institución y por tanto, desisten del cupo para el próximo año, lo cual deja en libertad al {$nombre_colegio} de disponerlo, en beneficio de otro estudiante. 
	</li>
	<li>
	El pago de la pensión será durante cada periodo mensual que corresponda, sea que éste se contabilice del día 1 al 30 de cada mes, o del 15 de un mes al día 14 del otro mes. Se beneficia el pago oportuno con un descuento como estímulo para quienes cancelen las pensiones mensuales durante los 5 primeros días de cada período mensual que corresponda, determinado en el numeral 2 de la cláusula sexta, si no paga dentro de los cinco primeros días, pierde el beneficio por descuento y deberá cancelar lo autorizado por el Ministerio de Educación, sin que esto pueda ser considerado sanción, multa o cobro de intereses.
	</li>
	<li>
	No se aumentará la pensión o cuota mensual acordada, durante el año lectivo que rige el presente contrato, salvo aprobación de la autoridad competente. Para el cálculo y ajuste de la matrícula y pensión, se aplicará la normativa expedida por la autoridad educativa. 
	</li>
	<li>
	La mora del primer mes será considerado como un atraso. Si no paga el segundo mes, el (la) representante será requerido para el pago de lo adeudado como contraprestación del servicio educativo y si persiste en la falta de pago, cumplido el tercer mes de mora, el padre de familia o representante, ante la imposibilidad de cumplir con su compromiso en el pago de la pensión como contraprestación del servicio educativo, para evitar problemas familiares, psicológicos, de estrés, o conflictividad con el sistema, se obliga a cambiarlo a otra institución fiscal gratuita o particular acorde sus posibilidades, para lo cual deberá solicitar el pase a otra institución educativa, o solicitar en forma directa la documentación del estudiante. Sin perjuicio de las acciones legales que se tomen por parte de la institución, para el cobro de las pensiones adeudadas.
	</li>
	<li>
	En caso de que el representante, no cumpla con cambiar de institución educativa al estudiante, para evitarle problemas psicológicos, al tener que asistir al {$nombre_colegio} a sabiendas que su representante no ha cumplido su compromiso contractual, lo que podría acarrear  trastornos en su comportamiento y que afectaría su proceso formativo, sobre todo en su  rendimiento y  comportamiento, el {$nombre_colegio} a su elección, recurrirá a uno de los Centros de Mediación de la jurisdicción correspondiente o al Centro de Arbitraje y Mediación – CAM - de la Universidad de Especialidades Espíritu Santo – UEES, explicando el caso mediante escrito, al que se adjuntará copia certificada del presente convenio como justificativo para el cumplimiento de lo acordado.
	</li>
	<li>
	Si no se llegare a acuerdo alguno y en beneficio del estudiante, para que no se vulnere el derecho a la educación, siendo obligación del Estado el proporcionarle al menor éste servicio público en forma gratuita, el {$nombre_colegio} procederá a notificar el particular a la Dirección del Distrito Educativo correspondiente, para que el (la) estudiante sea ubicado en una entidad educativa fiscal que según el sector le corresponda, donde deba continuar su proceso educativo. En este caso el {$nombre_colegio} procederá a entregar la documentación del estudiante a la autoridad de educación o la remitirá oficialmente a la entidad que se designe en el trámite correspondiente. De esa forma, se evitará que el incumplimiento en el pago interrumpa el proceso educativo del estudiante. Se deja a salvo el derecho del {$nombre_colegio} para cobrar al representante las pensiones adeudadas.
	</li>
	<li>
	En caso de falta de pago o mora en las pensiones u obligaciones para con el {$nombre_colegio}, no se podrá otorgar o renovar matrícula al estudiante para el próximo año lectivo, por lo que, el representante lo matriculará en otra institución, para que no se conculque o vulnere el derecho a la educación a su representado.
	</li>
	<li>
	El correo electrónico proporcionado y el aula virtual son las  vías acordadas para mantener una intercomunicación fluida con el representante del estudiante, dándole a conocer sobre el accionar diario, hoja de vida, tareas, citaciones, noticias,  comunicaciones y demás asuntos relacionados con el accionar educativo, a la vez, los representantes podrán comunicarse con los directivos y profesores, simplificando la interrelación entre la Unidad Educativa y el representante, por lo cual se comprometen a revisarlos día a día, en forma periódica, así como mantener actualizado el correo electrónico.
	</li>
	<li>
	Es obligación y se compromete el representante revisar diariamente el contenido de los maletines, maletas portafolios y mochilas del educando, para evitar que traigan a la institución objetos, sustancias, materiales extraños al proceso educativo o de mucho valor, o sustancias prohibidas o nocivas a la salud física o mental.
	</li>
	<li>
	El servicio educativo del {$nombre_colegio} es inclusivo para niños y jóvenes con necesidades educativas especiales que se encuentren consideradas como leves y dentro del primer grado de dificultad, siempre que no sean combinadas. No es un centro de educación especial, por lo que, si el estudiante necesita más apoyo para mejorar o superar su conducta o aprendizaje, se podrá autorizar que ingresen y laboren, profesionales o personas especializadas en esas áreas para brindarles atención complementaria con servicio fijo o itinerante, en los casos más serios o complejos, para efectuar acompañamiento y apoyo personalizado al estudiante, a costa y bajo responsabilidad del representante.
	</li>
	<li>
	Para poder aplicar o sujetarse al programa de inclusión, es necesario que así se determine en el respectivo convenio y contar con evaluaciones externas iniciales y periódicas, para verificar el avance del programa y su conveniencia para la formación, aprendizaje y continuidad del estudiante en el programa inclusivo. De no existir las evaluaciones y compromiso del representante se aplicará el programa escolarizado general o regular.
	</li>
	<li>
	Si luego de haberse matriculado el menor, se estableciere que necesita apoyo especial del programa de inclusión, su representante deberá cumplir con el programa de inclusión del {$nombre_colegio}, sus presupuestos y requisitos. La no aceptación o implementación del programa de inclusión, deslinda toda responsabilidad a la institución, por el poco o deficiente avance educativo en el proceso formativo escolarizado.
	</li>
	</ol>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA OCTAVA: DURACIÓN:</strong> 
	El presente convenio tiene duración de un año lectivo, pero podrá ser renovado por mutuo acuerdo mediante el correspondiente convenio de matrícula para el próximo año lectivo, actualizando los datos correspondientes para las notificaciones. Se entenderá renovado en todas sus partes, si no existe pronunciamiento alguno de una de las partes sobre la voluntad de dejarlo sin efecto, y en ese caso, el costo de la matrícula y pensión se reajustará al que se fijare legalmente para el año que corresponda o decurra. El hecho de pagar matrícula y pagar la primera pensión por parte del representante, surtirá los efectos de la renovación tácita del contrato.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA NOVENA: DE LA TERMINACIÓN DEL CONTRATO:</strong>
	El presente contrato concluirá por las siguientes causas:
	<ol>
	<li>Por el vencimiento del plazo, caso en el cual, culminará de pleno derecho.</li>
	<li>Por voluntad o acuerdo de ambas partes.</li>
	<li>Por fallecimiento del (la) estudiante.</li>
	<li>Por fallecimiento del representante del estudiante, a menos que otra persona con derecho suficiente asuma la representación del educando. En lo relativo al pago de pensiones, se estará a lo establecido en los Art. 7 literal J) y 135 de la LOEI.</li>
	<li>Por suspensión de actividades de la unidad educativa por más de sesenta días o por cierre definitivo.</li>
	<li>Por voluntad del representante. Si una vez matriculado el alumno, sus progenitores o representantes deciden retirarlo del Liceo Panamericano, deberán comunicar de inmediato a los directivos de la institución. No se podrá solicitar el reembolso de la matrícula ni de las pensiones que hayan sido devengadas. El Representante se obliga a cancelar los valores correspondientes a los servicios educativos y adicionales voluntarios recibidos a favor del estudiante que representa, hasta el último periodo mensual de asistencia al plantel.</li>
	<li>Por incumplimiento de cualquiera de las cláusulas que se establecen en este contrato, Código de Convivencia, o de los Reglamentos Internos, o por incumplimiento de disposiciones emanadas de las autoridades del {$nombre_colegio} y que correspondan al desarrollo de los programas educativos.</li>
	<li>Por incurrir sus representados en las faltas que establece el Art. 134 de la Ley Orgánica de Educación Intercultural.</li>
	<li>Por las demás causas previstas en el ordenamiento jurídico del país, Código de Convivencia y Reglamentos del {$nombre_colegio}.</li>
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA DÉCIMA: TRÁMITE Y COMPETENCIA: CLASULA COMPROMISORIA:</strong> 
	Cualquier controversia, diferencia o reclamación que se derive o esté relacionada con la interpretación o ejecución del presente convenio, en atención a lo establecido en la Ley de Arbitraje y Mediación, las partes acuerdan renunciar a su domicilio legal fuero, sometiéndose en primera instancia al Centro de Arbitraje y Mediación – CAM - de la Universidad de Especialidades Espíritu Santo – UEES.  En caso de que las partes intervinientes no hayan podido llegar a un acuerdo en la etapa de mediación, estos resuelven al tenor de lo dispuesto en el Artículo 47 de la Ley ibídem, someterse en forma expresa, para que la problemática sea resuelta al Tribunal de Arbitraje del Centro de Arbitraje y Mediación – CAM - de la Universidad de Especialidades Espíritu Santo – UEES. En este caso, las partes se comprometen a aceptar las medidas cautelares que se disponga; a aceptar lo resuelto en la etapa de mediación; y, acatar el laudo arbitral a expedirse, desistiendo de presentar recurso alguno respecto del mismo.
	</p>
	<p class="letras_pequenas">
	Para constancia de lo acordado, luego de ser vuelto a leer en alta voz,  las partes suscriben el presente convenio en el cantón {$fecha_hoy}
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
	Gerente de la {$antes_del_nombre} {$nombre_colegio}
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
$pdf->AddPage();
$pdf->Image('../'.$_SESSION['ruta_foto_logo_web'], 10, 10, 10, 10, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
$pdf->SetFont('helvetica', '', 6);
$pdf->Write(0, 'Código: R13-05 Versión: 2.0', '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, 'Noviembre/2015', '', 0, 'R', true, 0, false, false, 0);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Write(0, $antes_del_nombre.' '.$nombre_colegio, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, 'ORDEN DE PAGO DE MATRÍCULA', '', 0, 'C', true, 0, false, false, 0);
$pdf->Line(10,28,200,28,array('width'=>0.4,'color'=>array(0,0,0)));
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 10);
$pdf->Write(0, $fecha_hoy2, '', 0, 'R', true, 0, false, false, 0);
$pdf->Ln(5);
$pdf->Write(0, 'PERÍODO DE ESTUDIO: '.$_SESSION['peri_deta'], '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'BLOQUE DE ESTUDIO: '.$alumno["detalle"], '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'ESTUDIANTE: '.$alumno["nombres"].' '.$alumno["apellidos"], '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'CÓDIGO ESTUDIANTIL: '.$alumno["alum_codi"], '', 0, 'L', true, 0, false, false, 0);
$pdf->Ln(8);
$pdf->Write(0, '_________________________', '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, '     FIRMA SECRETARIA      ', '', 0, 'R', true, 0, false, false, 0);
}
	
$pdf->Output('cert_matricula.pdf', 'I');
?>
