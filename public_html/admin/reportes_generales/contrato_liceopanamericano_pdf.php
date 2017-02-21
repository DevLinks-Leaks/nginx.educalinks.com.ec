<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='contrato.pdf'");
	session_start();

	require_once ('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
	require_once ('../../framework/AifLibNumber.php'); 
		
	ini_set('memory_limit', '640M');
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
		{	$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 12, 5, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$this->SetFont('helvetica', '', 6);
			$this->Cell(0,10,'Código: R13-08 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,15,'Versión: 5 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,20,'Nov/2016', 0, false, 'R', 0, '', 0, false, 'T', 'M');

			//FORMATO
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
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
	$pdf->SetMargins(PDF_MARGIN_LEFT, 25, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, 17);
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
		
		$sql2="{call repr_info_vida(?,?)}";
		$params2 = array($alumno["alum_codi"], "F");
		$stmt_repr_fina = sqlsrv_query($conn, $sql2, $params2);
	
		if( $stmt_repr_fina === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} 
		$representante_fina=sqlsrv_fetch_array($stmt_repr_fina);

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
	<table >
		<tr>
			<td class="centrar"><h1>CONVENIO DE PRESTACIÓN DE SERVICIOS</h1></td>
			<!--<td class="derecha" style="font-size: 8px" width="25%">R13-08 <br/>Versión 5 <br/>Sep/2016</td>-->
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento, el Convenio de Prestación de Servicios el mismo que se celebra al tenor de las siguientes cláusulas:
	<br/>
	<strong>PRIMERA: INTERVINIENTES:</strong> 
	Participan en forma libre y voluntaria en la celebración del presente convenio, por una parte el (la) señor (a) {$representante["nombres"]}, a nombre y en representación del (la) menor {$alumno["nombres"]} {$alumno["apellidos"]} ; y, por otra parte, el señor Julio Córdova Empuño, por los derechos que representa en calidad de Representante Legal de la Comunidad Unidad Educativa {$nombre_colegio} quien es la Promotora de la {$antes_del_nombre} {$nombre_colegio}, a quienes en lo posterior y para efectos del presente instrumento se los podrá denominar como "el (la) representante", "el (la) estudiante" y la “Unidad Educativa" o "la Institución”, respectivamente.
	<br/>
	<strong>SEGUNDA: ANTECEDENTES: </strong> UNO:
	La {$antes_del_nombre} {$nombre_colegio}, es una Unidad Educativa auto financiada, de carácter particular, legalmente reconocida y autorizada por las autoridades de educación, sin fines de lucro, que brinda servicios educativos en la forma y modo señalado en la Constitución y Leyes de la República del Ecuador, recibiendo como contraprestación del servicio educativo el monto económico fijado en legal forma por concepto de pensiones y matrícula, el cual constituye, su única fuente de ingreso para brindar educación de calidad.
	<br/>
	DOS:
	El (la) representante, conocedor de la misión, visión, filosofía, principios, Proyecto Educativo Institucional - PEI, Código de Convivencia, y demás reglamentación y normatividad interna de la Unidad Educativa y luego de una serie de análisis y comparaciones de su oferta educativa con la de otras instituciones, ha solicitado matrícula en la Institución para su representado el (la) estudiante (referidos en la cláusula anterior), para el periodo lectivo {$alumno["periodo"]} en el {$alumno["curs_deta"]} de {$alumno["nive_deta"]}, para lo cual ha presentado la solicitud de matrícula que está como anexo al presente instrumento contractual, el cual, no genera derecho alguno, sino que constituye una mera expectativa.
	<br/>
	<strong>TERCERA: OBJETO DEL CONVENIO:</strong>
	El presente convenio tiene como objeto regular las relaciones contractuales entre las partes, una vez que ha sido aceptada la matriculación y se hubiere pagado el valor de la misma y que en definitiva está relacionado al proceso de enseñanza aprendizaje y al pago que como contraprestación a este servicio realizan los padres de familia.
	<br/>
	<strong>CUARTA: CONTRAPRESTACIÓN DEL SERVICIO EDUCATIVO:</strong> 
	Se entiende como servicio educativo, la oferta que efectúa la institución en la formación y educación, bajo el sistema escolarizado de los niños y jóvenes de conformidad a su PEI, y comprende las actividades y servicios de clases en todo su sistema de educación, controles y seguridad interna, materiales de uso común como laboratorios de computación, (de) química y biología, enfermería y médico, implementos deportivos, canchas, biblioteca, tutorías, asesoría estudiantil, servicio pedagógico, psicopedagógico y toda actividad propia del sistema educativo programado en el PEI. Como contraprestación del servicio educativo que brinda la institución, al (la) estudiante, el (la) representante se obliga a pagar los valores fijados por concepto de matrícula y pensiones, por cada año lectivo, de conformidad a las siguientes consideraciones:
	<br/>
	4.1. LA MATRÍCULA: De conformidad a la normativa legal vigente, la matricula corresponde al 75% del valor de la pensión neta fijada por las Autoridades Educativas. En este sentido, este valor deberá ser cancelado en el mes de abril del 2017, se exceptúan aquellos padres de familia que bajo su responsabilidad y petición expresa celebren Convenio de Mandato con este fin y  salvo disposición en contrario del Nivel Central de la Autoridad Educativa Nacional.
	<br/>
		El valor por concepto de matrícula, podrá ser cancelado hasta antes del primer día de clases y sólo con el cumplimiento de dicho pago a través de los medios pertinentes, se formalizará la matrícula, por ende, el aspirante adquiere la calidad de estudiante. Se dará preferencia en la reserva y otorgamiento de cupos para matrículas a los representantes de nuestros estudiantes o sus familiares, siempre que hayan manifestado durante el periodo señalado para el efecto, su voluntad de estudiar o continuar en La Institución.
	<br/>
	4.2. VALOR DE LA PENSIÓN: Este rubro fijado por las Autoridades Educativas corresponde a la contraprestación del servicio educativo por el año lectivo {$alumnos["periodo"]} que el representante del estudiante pagará en diez cuotas, durante los cinco primeros días hábiles de cada mes, para sujetarse a los beneficios institucionales sobre el tema.
	<br/>
		El pago de los valores referidos en los numerales precedentes será efectuado mediante débito bancario automático o recurrente a cuenta corriente o de ahorro, o mediante tarjeta de débito o de crédito, en la caja correspondiente del Banco que autorice La Institución, emitiéndose como constancia el comprobante respectivo, el mismo que se constituye en única evidencia de cumplimiento.
	<br/>
	4.3. SERVICIO INCLUSIVO: El servicio educativo de la Institución es inclusivo para niños y jóvenes con dificultad en el aprendizaje que se encuentren consideradas como leves y dentro del primer grado de dificultad, siempre que no sean combinadas. No es un centro de educación especial, por lo que, si el estudiante necesita más apoyo para mejorar o superar su conducta o aprendizaje, se podrá autorizar que ingresen y laboren, profesionales o personas especializadas en esas áreas para brindarles atención complementaria con servicio fijo o itinerante, en los casos más serios o complejos, para efectuar acompañamiento y apoyo personalizado al estudiante, a costa y bajo responsabilidad del representante y la Institución no adquiere ninguna obligación o compromiso con los mismos.
	<br/>
		Para poder aplicar o sujetarse al programa de inclusión, es necesario que así se determine en el respectivo convenio y contar con evaluaciones externas iniciales y periódicas, para verificar el avance del programa y su conveniencia para la formación, aprendizaje y continuidad del estudiante en el programa inclusivo. De no existir las evaluaciones y compromiso del representante se aplicará el programa escolarizado general o regular.
	<br/>
		Si luego de haberse matriculado el menor, se estableciere que necesita apoyo especial del programa de inclusión, su representante deberá cumplir con el programa de inclusión de la Institución, sus condiciones y requisitos. La no aceptación o implementación del programa de inclusión, deslinda toda responsabilidad a la institución, por el poco o deficiente avance educativo en el proceso formativo escolarizado.
	<br/>
	<strong>QUINTA: COMPROMISOS Y OBLIGACIONES</strong>
	Entendiéndose que el pago de la matrícula y pensiones como contraprestación del servicio educativo, sirve para poder cubrir los costos del proceso enseñanza aprendizaje, que genera los gastos corrientes y operativos, las partes establecen, se comprometen y obligan a lo siguiente:
	<br/>
	5.1.1. El representante
	<ol type="a">
	<li>
		Cumplir la Constitución de la República, la Ley y la reglamentación en materia educativa;
	</li>
	<li> 
	Garantizar que sus representados asistan regularmente y correctamente uniformados a los centros educativos, durante el periodo de educación obligatoria, de conformidad con la modalidad educativa;
	</li>
	<li>
	Apoyar y hacer seguimiento al aprendizaje de sus representados y atender los llamados y requerimientos de las y los profesores y autoridades de plantel;  
	</li>
	<li>
	Participar en la evaluación de las y los docentes y de la gestión de las instituciones educativas;
	</li>
	<li>
	Respetar leyes, reglamentos y normas de convivencia en su relación con las instituciones educativas;
	</li>
	<li>
	Propiciar un ambiente de aprendizaje adecuado en su hogar, organizando espacios dedicados a las obligaciones escolares y a la recreación y esparcimiento, en el marco del uso adecuado del tiempo;
	</li>
	<li>
	Participar en las actividades extracurriculares que complementen el desarrollo emocional, físico y psico - social de sus representados y representadas;
	</li>
	<li>
	Apoyar y motivar a sus representados y representadas, especialmente cuando existan dificultades en el proceso de aprendizaje, de manera constructiva y creativa;
	</li>
	<li>
	Participar con el cuidado, mantenimiento y mejoramiento de las instalaciones físicas de las instituciones educativas, sin que ello implique erogación económica;
	</li>
	<li>
	Contribuir y participar activamente en la aplicación permanente de los derechos y garantías constitucionales.
	</li>
	<li>
	Pagar puntualmente los valores de pensiones y matrículas;
	</li>
	<li>
	Controlar que sus representados al salir de sus casas, hacia la institución se encuentren aseados y bien uniformados, con sus implementos de estudio, tareas o trabajos; al igual que enviar el lunch recomendado, para una correcta dieta alimenticia; por tanto, estos deben ser realizados al inicio de la jornada académica (clases) no durante las mismas;
	</li>
	<li>
	Controlar que sus representados no traigan  a la institución sustancias u objetos prohibidos o que no tengan relación con la actividad educativa;
	</li>
	<li>
	Aceptar la distribución de profesores, materias y horarios de conformidad a la oferta educativa de la institución, así como la asignación o cambio de paralelo que se le asigne por circunstancia formativas, académicas o disciplinarias, sin que exista derecho a reclamo alguna por dicha medida;
	</li>
	<li>
	Mantener actualizada la información relacionada a teléfono, dirección domiciliaria, correo electrónico y demás datos personales;
	</li>
	<li>
	A revisar el correo electrónico y el aula virtual por ser la vía acordada para mantener una comunicación fluida con el representante del estudiante, dándole a conocer sobre el accionar diario, hoja de vida, tareas, citaciones, noticias, comunicaciones y demás asuntos relacionados con el accionar educativo, a la vez, los representantes podrán comunicarse con los directivos y profesores, simplificando la interrelación entre la Unidad Educativa y el representante, por lo cual se comprometen a revisarlos día a día, en forma periódica;
	</li>
	<li>
	Presentar dentro de los plazos señalados para el efecto, la solicitud de matrícula para al siguiente periodo lectivo;
	</li>
	<li>
	Hacer seguimiento y responder a los llamados que envía el establecimiento educativo, por intermedio del internet o el aula virtual;
	</li>
	<li>
	Acatar estrictamente, lo dispuesto en el literal t) artículo 2 de la Ley Orgánica de Educación Intercultural, que determina la convivencia pacífica y respetuosa en el trato de las relaciones internas de la comunidad educativa, y su inobservancia así como la mora en las obligaciones de contraprestación de servicios causará la perdida de los beneficios otorgados voluntariamente por la institución, como becas y descuentos en pensiones, así como, que se convierte en causal para la no concesión de matrícula para el próximo año lectivo.
	</li>
	<li>
	Cumplir con lo dispuesto en el presente convenio.
	</li>
	</ol>
	<br/>
	5.2. La Unidad Educativa:
	<ol type="a">
	<li>
	Cumplir la Constitución de la República, la Ley y la reglamentación en materia educativa;
	</li>
	<li>
	Cumplir con lo dispuesto en el presente convenio;
	</li>
	<li>
	Brindar una educación de calidad y de calidez, en la forma y modo constante en su Proyecto Educativo Institucional (PEI), Código de Convivencia, en sujeción  a lo determinado en la Constitución de la República del Ecuador y demás normativa que rige al Sistema Nacional de Educación;
	</li>
	<li>
	Ser actores fundamentales en una educación pertinente, de calidad y calidez con las y los estudiantes a su cargo;
	</li>
	<li>
	Respetar el derecho de las y los estudiantes y de los miembros de la comunidad educativa, a expresar sus opiniones fundamentadas y promover la convivencia armónica y la resolución pacífica de los conflictos;
	</li>
	<li>
	Fomentar una actitud constructiva en sus relaciones interpersonales en la institución educativa;
	</li>
	<li>
	Atender y evaluar a las y los estudiantes de acuerdo con su diversidad cultural y lingüística y las diferencias individuales y comunicarles oportunamente, presentando argumentos pedagógicos sobre el resultado de las evaluaciones;
	</li>
	<li>
	Dar apoyo y seguimiento pedagógico a las y los estudiantes, para superar el rezago y dificultades en los aprendizajes y en el desarrollo de competencias, capacidades, habilidades y destrezas;
	</li>
	<li>
	Cuidar la privacidad e intimidad propias y respetar la de sus estudiantes y de los demás actores de la comunidad educativa;
	</li>
	<li>
	Mantener el servicio educativo en funcionamiento de acuerdo con la Constitución y la normativa vigente;
	</li>
	<li>
	Vincular la gestión educativa al desarrollo de la comunidad, asumiendo y promoviendo el liderazgo social que demandan las comunidades y la sociedad en general;
	</li>
	<li>
	Promover la interculturalidad y la pluralidad en los procesos educativos;
	</li>
	<li>
	Difundir el conocimiento de los derechos y garantías constitucionales de los niños, niñas, adolescentes y demás actores del sistema; y,
	</li>
	<li>
	Respetar y proteger la integridad física, psicológica y sexual de las y los estudiantes, y denunciar cualquier afectación ante las autoridades judiciales y administrativas competentes.
	</li>
	</ol>
	
	<strong>SEXTA: DURACIÓN.</strong>
	El presente convenio tiene una duración de un año lectivo, el cual, podrá ser renovado siempre que exista la voluntad manifiesta de las partes, dentro de los plazo que para el efecto indique la Unidad Educativa.
	<br/>
	<strong>SÉPTIMA: DE LA TERMINACIÓN DEL CONVENIO:</strong>
	El presente convenio concluirá por las siguientes causas: 
	<br/>
	1) Por el vencimiento del plazo, caso en el cual, culminará de pleno derecho.
	<br/>
	2) Por voluntad o acuerdo de ambas partes.
	<br/> 
	3) Por fallecimiento del (la) estudiante.  
	<br/>
	4) Por fallecimiento del representante del estudiante, a menos que otra persona con derecho suficiente asuma la representación del educando. En lo relativo al pago de pensiones, se estará a lo establecido en la Ley Orgánica de Educación Intercultural.
	<br/>
	5) Por suspensión de actividades de la unidad educativa por más de sesenta días o por cierre definitivo.
	<br/>  
	6) Por voluntad del representante. Si una vez matriculado el alumno, sus progenitores o representantes deciden retirarlo de la institución, deberán comunicar de inmediato a los directivos del centro educativo. No se podrá solicitar el reembolso de la matrícula ni de las pensiones que hayan sido devengadas. El Representante se compromete a cancelar los valores correspondientes a los servicios educativos y adicionales voluntarios recibidos a favor del estudiante que representa, hasta el último período mensual de asistencia al plantel.
	<br/>
	7) Por incumplimiento de cualquiera de las cláusulas que se establecen en este convenio, Código de Convivencia, o por incumplimiento de disposiciones emanadas de las autoridades de la institución y que correspondan al desarrollo de los programas educativos.  
	<br/>
	8) Por voluntad de una de las partes, manifiesta dentro del término legal.
	<br/>
	9) Por las demás causas previstas en el ordenamiento jurídico del país, Código de Convivencia y Reglamentos de la institución.
	<br/>
	<strong>OCTAVA: DE LA MORA DEL REPRESENTANTE LEGAL DEL ESTUDIANTE:</strong>
	La mora del  primer mes será considerado como un atraso. Si no paga el segundo mes, el representante será requerido para el pago de lo adeudado como contraprestación del servicio educativo y si persiste en la falta de pago, cumplido el tercer mes de mora, ante la imposibilidad de cumplir con su compromiso en el pago de la pensión como contraprestación del servicio educativo, para evitar problemas familiares, psicológicos, de estrés, o conflictividad con el sistema, el  (la) representante se obliga a cambiarlo a una institución fiscal gratuita o a otra institución particular acorde sus posibilidades, para lo cual deberá solicitar el pase a otra institución educativa, o solicitar en forma directa la documentación del estudiante. Sin perjuicio de las acciones legales que se tomen para el cobro de las pensiones adeudadas.
	<br/>
	Si el representante, no cumple con cambiar de institución educativa al estudiante, para evitarle problemas psicológicos, al tener que asistir a la Institución a sabiendas que su representante no ha cumplido su compromiso contractual, lo que podría acarrear  trastornos en su comportamiento y que afectaría su proceso formativo, sobre todo en su  rendimiento y  comportamiento, la institución recurrirá al Centros de Mediación y Arbitraje de la Universidad de Especialidades Espíritu Santo – UEES, explicando el caso mediante escrito, al que se adjuntará copia certificada del presente convenio como justificativo para el cumplimiento de lo acordado mediante un proceso de mediación. Se deja a salvo el derecho de la Institución para cobrar al representante las pensiones adeudadas.
	<br/>
	En caso de falta de pago o mora en las pensiones u obligaciones para con la Institución, no se podrá otorgar o renovar matrícula al estudiante para el próximo año lectivo, por lo que, el representante lo matriculará en otra institución, para que no se conculque o vulnere el derecho a la educación a su representado.
	<br/>
	<strong>NOVENA: DEL SEGURO DE ACCIDENTES PERSONALES:</strong> 
	De conformidad a la normativa expedida por el Ministerio de Educación, en el Acuerdo Ministerial MINEDUC-ME-2015-00094-A y sus reformas, se pone a consideración de los padres de familia un seguro de accidentes personales, en aras de cubrir posibles lesiones que pueda tener el estudiante dentro de la institución educativa. En caso de que el padre o representante no acepte dicho seguro, deslinda de responsabilidad a la Unidad Educativa y su Promotor, en relación al posible accidente y sus consecuencias.
	<br/>
	La institución educativa solamente se compromete, en caso de accidente a llamar al ECU-911, para que brinde la asistencia que sea del caso.
	<br/>
	<strong>DÉCIMA: DE LOS SERVICIOS COMPLEMENTARIOS:</strong>
	Existen otros valores que se cobran en forma periódica o esporádica y que han sido solicitados y aceptados en forma expresa y voluntaria por el (la) representante legal del (la) estudiante, que corresponden a servicios no educativos o complementarios, que son prestados por la institución o facilitados para que los preste otras personas naturales o jurídicas dentro de la Institución, como son, entre otros,  los servicios de alimentación, bar, transporte escolar, o de apoyo profesional para educación especial, los que no constituyen elemento propio de la prestación del servicio de educación y no están comprendidos o cubiertos dentro del concepto de pensión y matrícula, por lo que tienen que ser pagados en forma directa por los padres o representantes legales de los estudiantes. Tampoco están cubiertos o considerados dentro de los valores de matrículas y pensiones, los libros, cuadernos, y demás útiles escolares, o implementos o materiales de trabajo de aprendizaje, uniformes, disfraces de presentación para eventos u obras de arte, o equipos para eventos deportivos, sistemas externos de apoyo educativo tecnológico, computadoras personales, IPad o Tabletas, o programas internacionales de estudio (BI) que voluntariamente los padres o representantes aprueben y que se utilicen dentro del sistema educativo como apoyo al mismo, o alquiler de locales o escenarios para incorporaciones, ceremonias o baile de graduados; los cuales deberán ser pagados en forma directa por el representante legal del estudiante al proveedor del bien o servicio, o por intermedio de la Institución, si es que se brinda esa facilidad en beneficio del representante.
	<br/>
	<strong>DÉCIMA PRIMERA: SOBRE LAS EXCURSIONES Y GIRAS DE OBSERVACION:</strong>
	De conformidad a la normativa vigente las instituciones educativas pueden realizar excursiones y giras de observación. En este sentido los representantes legales se comprometen a dar respuesta a las solicitudes de permiso, así como ha cubrir los valores que por concepto de estas actividades se generen, siempre que los mismos, no contravengan normativa de igual o mayor jerarquía expedida.
	<br/>
	<strong>DÉCIMA SEGUNDA: TRÁMITE Y COMPETENCIA: CLÁUSULA COMPROMISORIA:</strong>
	Cualquiera cuestión o controversia originadas en este convenio o relacionadas con él, serán resueltas por arbitraje en la Cámara de Arbitraje y Mediación de la Universidad de Especialidades Espíritu Santo  de acuerdo con las reglas de la Ley de Arbitraje y Mediación y del Reglamento de dicho Centro. Las partes convienen además en lo siguiente:
	<br/>
	a.-Los árbitros serán seleccionados conforme lo establecido en la Ley de Arbitraje y Mediación.
	<br/>
	b.-Las partes renuncian a la jurisdicción ordinaria, se obligan a acatar el laudo que expida el Tribunal Arbitral  y se compromete a no interponer ningún recurso en contra del mismo. 
	<br/>
	c.-Para la ejecución de  medidas cautelares el Tribunal Arbitral está facultado  para solicitar de los funcionarios públicos, judiciales, policiales y administrativos su cumplimiento, sin que sea necesario recurrir a juez ordinario alguno.
	<br/>
	d.-El Tribunal Arbitral está integrado por -uno o tres  árbitros- (establecer el número de árbitros que integrará el tribunal arbitral)
	<br/>
	e.-El procedimiento arbitral será confidencial.
	<br/>
	f.-El lugar de arbitraje será las instalaciones de la Cámara de Arbitraje y Mediación de la Universidad de Especialidades Espíritu Santo" 
	</p>

	<p class="letras_pequenas">
	<table>
	<tr>
	<td colspan="2">
	Para constancia de lo acordado, las partes suscriben el presente convenio en la ciudad de {$fecha_hoy}
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	FIRMAS DEL CONVENIO CIVIL DE PRESTACIÓN DE SERVICIOS. 
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<br/><br/><br/><br/>
	</td>
	</tr>
	<tr>
	<td class="centrar">
	f)_______________________________________________<br/>
	{$representante["nombres"]}<br/>
	El (la) Representante.<br/>
	{$representante["domicilio"]}<br/>
	{$representante["telefono"]}<br/>
	{$representante["correo"]}
	</td>
	<td class="centrar">
	f)_______________________________________________<br/>
	{$nombre_financiero}<br/>
	REPRESENTANTE LEGAL<br/>
	COMUNIDAD UNIDAD EDUCATIVA LICEO PANAMERICANO
	</td>
	</tr>
	</table> 
	</p>        
	</div>
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
}
	
$pdf->Output('convenio_matricula.pdf', 'I');
?>
