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
			$this->Image($logo_minis, 145, 5, 50, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
	$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
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
	<table width="755">
		<tr>
			<td width="" class="centrar"><h2>{$antes_del_nombre} {$nombre_colegio}</h2></td>
		</tr>
		<tr>
			<td class="centrar"><h1><u>CONTRATO DE PRESTACIONES DE SERVICIOS EDUCATIVOS</u></h1></td>
		</tr>
	</table>
	<p class="letras_pequenas">
	Comparecen a la celebración del presente contrato, los siguientes intervinientes: <b>1) {$nombre_legal},</b> debidamente representada por su Presidente y representante legal, <b>{$nombre_financiero}; 2) UNIDAD EDUCATIVA AMERICANO DE GUAYAQUIL,</b> debidamente representada por su Rectora, <b> Mgs. Amelina Montenegro de Gallardo,</b> parte a quienes en lo sucesivo se podrá denominar conjuntamente como el <b>“COLEGIO” ;</b> y <b>3)</b> El / la señor(a) {$representante["nombres"]} {$representante["apellidos"]} portador(a) de la <b>cédula de ciudadanía/cédula de identidad/pasaporte</b> No {$representante["cedula"]} representante del/la estudiante, {$alumno["nombres"]} {$alumno["apellidos"]}, quien cursará el {$alumno["curs_deta"]} para el periodo lectivo 2017-2018 , parte a quien en lo posterior se podrá denominar simplemente como el/la <b>"REPRESENTANTE",</b>", acuerdan  celebrar el presente Contrato de Prestación de Servicios Educativos, que se sujetará a las siguientes cláusulas:
	<br/>
	<u><strong>CLÁUSULA PRIMERA.- ANTECEDENTES:</strong></u>
	La <b>{$nombre_legal}</b> es promotora de la <b>UNIDAD EDUCATIVA AMERICANO DE GUAYAQUIL,</b> conocida como <b>"Colegio Americano de Guayaquil"</b>,  una institución educativa particular, debidamente autorizada para prestar el servicio de educación, la misma que cuenta con una larga trayectoria institucional durante más de 70 años, brindando a la comunidad una educación bilingüe, de excelencia académica con proyección internacional.  Además, del Programa de Bachillerato Internacional debidamente avalado por los respectivos organismos e instituciones educativas nacionales y/o extranjeras.
	<br/>
	El <b>COLEGIO</b> cuenta con amplias y cómodas instalaciones que cumplen con todos los estándares exigidos por la Ley y están ubicadas en un terreno de más de 12.000 mts2, en la Av. Juan Tanca Marengo, km. 61/2 y Av. Gómez Gault, en la ciudad de Guayaquil.
	<br/>
	Vale mencionar que la Promotora, la <b>{$nombre_legal},</b> es una persona jurídica de derecho privado, sin fines de lucro, que tiene entre sus principales objetivos la creación de unidades educativas que fomenten la educación y la cultura.
	<br/>
	Dentro de su estructura organizacional se encuentra la figura del Director Académico, quien en representación de la Promotora, supervigila el correcto funcionamiento de la unidad educativa.
	<br/>
	<u><strong>CLÁUSULA SEGUNDA.- CONTRATO DE PRESTACIÓN DE SERVICIOS  EDUCATIVOS:</strong></u>
	Con tales antecedentes, el/la <b>REPRESENTANTE,</b> contrata -libre y voluntariamente- los servicios educativos que ofrece la <b>UNIDAD EDUCATIVA AMERICANO DE GUAYAQUIL,</b> los que son aceptados por el <b>REPRESENTANTE</b>, en los términos, plazos y condiciones previstos en la Ley, reglamentos y en este contrato, por lo que el Colegio se compromete a brindar el servicio de educación al/la representado(a) del <b>REPRESENTANTE,</b> quien será matriculado(a) en <b>GRADO/CURSO {$alumno["curs_deta"]}</b> durante el periodo lectivo 2017-2018.
	<br/>
	Por su parte, el/la <b>REPRESENTANTE</b> manifiesta expresamente estar de acuerdo con la normativa, reglamentos y políticas internas del <b>COLEGIO</b>, y se obliga a sí mismo y a nombre de su <b>REPRESENTADO(A)</b>, a cumplir y respetarlos, por coincidir con sus principios, creencias y valores, de conformidad con lo que dispone el art. 330 de la Ley Orgánica de Educación Intercultural vigente. Además, deberá revisar en la página web del <b>COLEGIO</b> los documentos antes mencionados, los que en su expedición de nuevas Normativas educativas o que inciden sobre las instituciones educativas, se ven por consiguiente, sujetos a cambios .En tal virtud, el/la <b>REPRESENTANTE</b> será quien suscriba la respectiva Hoja de Matrícula.
	<br/>
	<u><strong>CLÁUSULA TERCERA.- VALOR DE MATRICULA Y PENSION:</strong></u>
	El valor de la matrícula y pensión para el periodo lectivo 2017-2018, será el autorizado por la Junta Distrital Reguladora de Pensiones y Matrículas de la Educación Particular y Fiscomisional o quien haga sus veces.
	<br/>
	Es menester señalar que solo en los casos en que el <b>REPRESENTANTE</b> que mantenga pensiones educativas adeudadas del año lectivo anterior, para poder otorgar la Matricula del nuevo año lectivo deberá pagar la totalidad de las pensiones educativas adeudadas a la fecha en Efectivo, Tarjeta de Crédito o con Cheque Certificado, caso contrario se negará el cupo de acuerdo a lo que establece la Ley.
	<br/>
	<u><strong>CLÁUSULA CUARTA.- PLAZO DEL CONTRATO:</strong></u>
	El plazo que tendrá el presente contrato será el que corresponda al periodo lectivo 2017-2018, conforme lo haya dispuesto el Ministerio de Educación.
	<br/>
	Este Contrato de Prestación de Servicios Educativos deberá ser suscrito al comienzo de todo año lectivo, no obstante operar la matrícula automática prevista en la Ley.
	<br/>
	<u><strong>CLÁUSULA QUINTA.- OBLIGACIONES DE LAS PARTES:</strong></u>
	Las partes contratantes estarán obligadas a lo siguiente:
	<ol>
	<li>
	<b>COLEGIO:</b>
		<ul>
		<li>
		Cumplir y hacer cumplir lo dispuesto en la Constitución de la República del Ecuador (C.R.E); en la Ley Orgánica de Educación Intercultural (L.O.E.I.) y en su Reglamento General; en el Código de la Niñez y Adolescencia, así como toda normativa erga omnes que expida el Ministerio de Educación y demás ministerios competentes.
		</li>
		<li>
		Respetar, cumplir y hacer cumplir el Código de la Convivencia.
		</li>
		<li>
		Cumplir con lo acordado en este Contrato de Prestación de Servicios Educativos.
		</li>
		<li>
		Ofrecer un servicio excelente  acorde con la política estatal, sin alejarse de la mística que ha caracterizado a la institución a lo largo de su vasta trayectoria.
		</li>
		<li>
		Mantener una saludable y fluida comunicación entre el <b>COLEGIO</b> y el <b>REPRESENTANTE,</b> a fin que se encuentre debida y oportunamente, informado de la situación académica, disciplinaria y psicológica de su representado y a su vez, el <b>COLEGIO</b> reciba la respectiva retroalimentación.
		</li>
		<li>
		Velar por el desarrollo integral del estudiante, garantizando su seguridad física y psíqui¬ca, afectiva, sexual; atendiendo el principio de su interés superior y que sus derechos prevalecerán a los de las demás personas.
		</li>
		</ul>
	</li>
	<li>
	<b>REPRESENTANTE:</b>
		<ul style="margin: 0px; padding: 0px;">
		<li>
		Cumplir y hacer cumplir la Constitución de la República del Ecuador (C.R.E), en la Ley Orgánica de Educación Intercultural (L.O.E.I.) y en su Reglamento General, en el Código de la Niñez y Adolescencia, así toda normativa erga omnes que expida el Minis¬terio de Educación y demás ministerios competentes.
		</li>
		<li>
		Cumplir con lo establecido en el Código de Convivencia.
		</li>
		<li>
		Cumplir con lo acordado en este Contrato de Prestación de Servicios Educativos.
		</li>
		<li>
		Acatar las disposiciones que, con arreglo a la normativa antes mencionada, expidan las Autoridades del <b>COLEGIO,</b> para el normal y efectivo desenvolvimiento de las actividades educativas; así como las recomendaciones que hagan los directivos, docentes y DECE, en beneficio del progreso y bienestar del estudiante.
		</li>
		<li>
		Acudir personalmente a las convocatorias hechas por el <b>COLEGIO.</b>
		</li>
		<li>
		Comprometerse a suscribir las Actas de Compromiso necesarias para el progreso y mejoramiento académico y disciplinario del estudiante.
		</li>
		<li>
		Pagar el valor íntegro de la pensión mensual dentro de los <b>10 primeros días del mes correspondiente a través de débito en cuenta bancaria y tarjeta de crédito,</b> como contraprestación del servicio educativo que recibe su representado, así como pagar cualquier otro valor que no se contraponga con la legislación vigente; caso contrario, se constituirá en mora de pago. El <b>COLEGIO</b> no estará en la obligación de aceptar pagos parciales.
		</li>
		<li>
		Pagar el valor integro de la matrícula  a través de los medios de pago indicados anteriormente.
		</li>
		<li>
		Además, de los medios de pago indicados anteriormente, <b>la matrícula podrá ser cancelada mediante efectivo, tarjeta de crédito o cheque certificado.</b>
		</li>
		<li>
		En caso de atraso en el pago de las  pensiones   mensuales   durante el periodo lectivo, el <b>REPRESENTANTE</b> se obliga a pagar la totalidad de lo adeudado hasta antes de finalizar el año lectivo.
		</li>
		<li>
		Hacerse responsable por cualquier daño material que el estudiante ocasione a los bienes pertenecientes tanto a la institución, como de cualquier otro miembro de la comunidad educativa.
		</li>
		</ul>
	</li>
	</ol>
	<br/>
	<u><strong>CLÁUSULA SEXTA.- :</strong></u>
	El/la REPRESENTANTE autoriza al COLEGIO la publicación de foto¬grafías, audios y videos en los que aparezca su representado, realizando actividades escolares y en representa¬ción del COLEGIO en  revistas y publicidad elegida por el COLEGIO.
	<br/>
	<u><strong>CLÁUSULA SÉPTIMA.- RETIRO DEL ESTUDIANTE ANTES DE LA FINALIZA¬CIÓN DEL AÑO LECTIVO:</strong></u>
	En caso que el/la REPRESENTANTE decida retirar a su representado, antes de la finalización del respectivo periodo lectivo, deberá haber pagado la totalidad de las pensiones mensuales que se encuentre adeudando.
	<br/>
	<u><strong>CLÁUSULA OCTAVA.- MORA EN EL PAGO DE PENSIONES MENSUALES:</strong></u>
	En caso de mora del REPRESENTANTE en el pago de la pensión mensual, el COLEGIO le notificará a fin de que concurra dentro de las 48 horas posteriores a dicha notificación, con el objeto de que realice el pago correspondiente o proponga una modalidad de pago, que deberá ser debidamente aceptada por el COLEGIO.
	<br/>
	En caso que el REPRESENTANTE no concurra o no pague dentro del plazo indicado, esto facultará al COLEGIO a derivar el caso a cualquier Centro de Mediación avalado por el Consejo de la Judicatura, previo a iniciar acciones Judiciales por el Cobro de las pensiones educativas adeudadas, sin perjuicio de las acciones administrativas que se inicien en el Distrito seis del Ministerio de Educación.
	<br/>
	No obstante, el COLEGIO no renuncia a sus legítimos derechos, por lo que de conformidad con lo que establece el Artículo 32 de la Ley de Arbitraje y mediación en concordancia con el 370 del Código Orgánico General de Procesos, en caso de que una vez firmada el Acta de mediación entre el COLEGIO y el REPRESENTANTE no se haya dado cumplimiento en el tiempo establecido, faculta al COLEGIO tomar acciones legales por la vía correspondiente a la Ejecución del Acta de Mediación suscrita de conformidad con lo establece el Código Orgánico General de Procesos.
	<br/>
	De la misma forma si el REPRESENTANTE no concurre a las invitaciones a la Mediación, se entenderá que existe Imposibilidad de Mediar por lo que se tomará las acciones que franquea la Ley.
	<br/>
	Para constancia de lo estipulado, las partes se ratifican en el contenido de este contrato, para cuyo efecto lo suscriben en dos ejemplares de igual tenor y valor, en Guayaquil, el {$fecha_hoy}.
	<br/>
	<u><strong>CLÁUSULA NOVENA.- CONSENTIMIENTO EXPRESO:</strong></u>
	El REPRESENTANTE declara aceptar en forma libre y voluntaria que -en caso de no haber cancelado todos los valores concernientes a los rubros estipulados en la cláusula tercera de este contrato con la institución educativa  hasta finalizar el año lectivo 2017-2018-, el Colegio Americano de Guayaquil podrá incluir a su representado en el listado que enviará al Distrito 6 de Educación al finalizar el año lectivo, nómina a partir de la cual el Organismo Gubernamental asignará cupo en otro establecimiento educativo fiscal cercano a su domicilio. Dicha declaratoria se hace en conformidad a lo establecido  en el Memorando Nro. MINEDUC-SASRE-2014-00908-M del 08 de diciembre de 2014,   suscrito por  el   Mgs. Wilson Rosalino Ortega   Mafla,  Subsecretario de Apoyo, Seguimiento y Regulación de la Educación, y no conllevará reclamo alguno hacia el Colegio Americano ni a sus representantes.
	<br/> 
	Esto es que,  en caso de no haber cancelado todos los valores “<i>al momento de la culminación del año lectivo, esta circunstancia podría determinar la necesidad de salida de varios estudiantes de dichas instituciones, lo que evidentemente significa que ya no podrán continuar el siguiente año lectivo en el mismo establecimiento por no renovarse la relación de prestación de servicios existente con la institución educativa</i>”. (Memorando Nro. MINEDUC-SASRE-2014-00908-M del 8 de diciembre de 2014).
	<br/>
	Por lo descrito anteriormente, “<i>…es indispensable reiterar a los padres, madres o representantes legales de estudiantes la obligación civil contraída por parte de ellos para cumplir con el pago de dichos valores autorizados, mismos que se deben legítimamente a los establecimientos educativos, en atención a la relación de derecho civil que se adquiere con los representantes, y que son plenamente exigibles por ellos para su pago, incluso por vía judicial y/o extrajudicial</i>”. (Memorando Nro. MINEDUC-VGE-2016-00130-M)
	<br/><br/><br/>
	<b>Dado y firmado, el {$fecha_hoy}</b>
	<br/>
	</p>
	<p class="letras_pequenas">
	<table>
	<tr>
	<td colspan="2">
	<br/><br/><br/><br/>
	</td>
	</tr>
	<tr>
	<td class="">
	___________________________________________<br/>
	{$rector}<br/>
	{$etiqueta_rector}
	</td>
	<td class="">
	___________________________________________<br/>
	Representante {$representante["nombres"]}<br/>
	C.C. No. {$representante["cedula"]}
	</td>
	</tr>
	<tr>
	<td class="centrar" colspan="2">
	<br/><br/><br/><br/><br/><br/>
	___________________________________________<br/>
	{$nombre_financiero}<br/>
	Presidente
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
