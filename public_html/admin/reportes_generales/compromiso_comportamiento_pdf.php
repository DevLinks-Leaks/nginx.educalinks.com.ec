<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='compromiso_comportamiento.pdf'");
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
			$this->SetFont('helvetica', '', 8);
			$this->Cell(0,45,'Gestión de Matriculación ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
			$this->Image($logo_minis, 12, 5, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->SetFont('helvetica', '', 6);
			
			$this->Cell(0,10,'Código: R13-11 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,15,'Versión: 2.0 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,20,'Octubre 2015', 0, false, 'R', 0, '', 0, false, 'T', 'M');

			//FORMATO
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		}

		public function Footer() 
		{
			// $this->SetY(-15);
			// $this->SetFont('helvetica', 'I', 8);
			// $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
		$fecha_hoy_3=strftime("$ciudad, a los %d días del mes de %B del %Y");
		
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
			<td class="centrar"><h1>{$antes_del_nombre} {$nombre_colegio}</h1><br/></td>
		</tr>
		<tr>
			<td class="centrar"><h1>COMPROMISO EDUCATIVO DE COMPORTAMIENTO</h1></td>
			<!--<td class="derecha" style="font-size: 8px" width="25%">R13-08 <br/>Versión 5 <br/>Sep/2016</td>-->
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento, el Compromiso Educativo de <b>COMPORTAMIENTO</b>, que se celebra al tenor de las siguientes cláusulas:
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA PRIMERA: INTERVINIENTES:</strong>
	El presente Compromiso, se celebra entre la {$antes_del_nombre} "{$nombre_colegio}" y el/a señor/a {$representante["nombres"]} en su calidad de {$representante["parentesco"]} del/a estudiante {$alumno["nombres"]} {$alumno["apellidos"]} para quien ha solicitado matrícula para el {$alumno["curs_deta"]} año/curso, por el periodo lectivo {$alumno["periodo"]}; y que a efecto de la relación con el “{$nombre_colegio}”, será quien represente legalmente al/a referido/a estudiante;  a quienes en lo posterior, para los efectos del presente documento, se los podrá denominar como el/a) “estudiante y representante” o por separado “el/ a) estudiante”, y “el/a) representante”.
	</p>
	
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEGUNDA: OBJETIVO GENERAL: </strong>
	El presente Convenio tiene por objetivo  dejar sentado el compromiso del/a “estudiante” a cumplir y de su “representante” a velar y hacer que su representado/a cumpla, con las disposiciones legales y reglamentarias referente al comportamiento, que se observa en el Centro de Estudios, durante todo el proceso educativo y actividades que se desarrollen en el período lectivo para el cual  ha solicitado y se le ha concedido la matrícula, bajo el condicionamiento que se cumpla con los preceptos establecidos en la Ley Orgánica de Educación Intercultural Art. 134 y su Reglamento General, Arts. 221 a 226 y Arts. 330 y 331, y los acuerdos y compromisos establecidos en el Código de Convivencia del Plantel vigente a la presente fecha.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA TERCERA: COMPROMISO ESPECÍFICO DEL ESTUDIANTE:</strong>
	El estudiante, reconociendo  que en el año lectivo anterior, su incumplimiento de las normas de comportamiento establecidas en la Ley y Reglamento de Educación, así como en el Código de Convivencia del Liceo Panamericano, ha afectado en forma directa a su comportamiento y se transmite a la comunidad educativa, produciendo mal ejemplo en los demás y malestar en el plantel, se compromete en forma expresa a:
	<br/>
	<br/><b>1.-</b> <u>Llegar e ingresar en forma puntual al establecimiento y a las clases respectivas, en acatamiento al horario establecido</u>.
	<br/><b>2.-</b> <u>Asistir a clases correctamente vestido, con el uniforme que corresponda</u>.
	<br/><b>3.-</b> <u>Demostrar un buen comportamiento en  el aula, patios y demás dependencias del plantel</u>, en observancia a sus deberes determinados en la Ley de Educación y su Reglamento y  del Código de Convivencia del plantel.
	<br/><b>4.-</b> <u>Respetar y demostrar cultura y buenos modales en el trato con directivos, docentes y más miembros de la comunidad educativa</u>.
	<br/><b>5.-</b> Cuidar del aseo y presentación personal, usando el cabello corto y  bien peinado, los varones; las damas, igual en su presentación, sin peinados  escandalosos.
	<br/><b>6.-</b> Cuidar y no manchar o dañar las paredes, puertas, mobiliario, equipos, máquinas y demás enseres del plantel.
	<br/><b>7.-</b> Observar en todo momento y circunstancia, dentro y fuera del plantel, buena conducta, en acatamiento a las Leyes y Reglamentos, así como de las normas sociales, éticas y morales.
	<br/><b>8.-</b> Mantener buen comportamiento dentro del plantel, de tal forma que se haga acreedor <b>de por lo menos la evaluación de “B”, equivalente a satisfactorio</b>, en cada una de las evaluaciones de  las unidades de estudio. 
	<br/><b>9.-</b> Comunicar a su representante, tutor, orientador o directivos del plantel, cuando tenga conocimiento de alguna actuación ilegal, inmoral o ajena a la ley o a las buenas costumbres, por parte de otra persona, que pretenda inducir a un comportamiento no correcto  a algún miembro de nuestra comunidad educativa.

	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA CUARTA: COMPROMISO ESPECÍFICO DEL/A REPRESENTANTE:</strong> 
	Ante el compromiso adquirido por el/a estudiante, con autorización expresa de su representante, <u>se determina por las partes, como condición aceptada, el cumplimiento del mismo para el otorgamiento de la matrícula y su permanencia en el Centro de Estudios</u>, motivo por el  cual el/a representante se compromete a respetar y hacer respetar por parte de su representado  la condición establecida en la cláusula anterior, además que se obliga a: 
	<br/>
	<br/><b>1.-</b> Apoyar, vigilar y estimular al/a representado/a, en el cumplimiento del compromiso adquirido.
	<br/><b>2.-</b> Acudir a toda convocatoria que le hiciere el plantel, para tratar asuntos de su representación.
	<br/><b>3.-</b> Controlar y supervigilar las actividades de su representado fuera de casa y del Centro de Estudios, para evitar influencia negativa  de otras personas. 
	<br/><b>4.-</b> <u>Recabar en forma periódica del docente tutor y de los  docentes</u> la información correspondiente al comportamiento  del/a  estudiante, así como el grado de cumplimiento del presente compromiso.
	<br/><b>5.-</b> Respetar y hacer respetar, de palabra y obra, a la institución, sus autoridades, docentes, y más miembros de nuestra comunidad educativa.
	<br/><b>6.-</b> Apoyar los esfuerzos demostrados por el Centro de Estudios, para la permanencia del/a estudiante en el plantel.

	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA QUINTA: INCUMPLIMIENTO:</strong>
	<u>En caso de no cumplirse lo establecido en las cláusulas segunda, tercera y cuarta del presente Convenio</u>, quedará demostrada la falta de compromiso tanto del/a estudiante y su representante, al sistema  disciplinario del Liceo Panamericano, <u>motivo por  el cual el representante retirará voluntariamente al estudiante y la documentación pertinente del Centro de Estudios</u>, para evitar que su comportamiento no satisfactorio, le pueda ocasionar extrañamiento del establecimiento. Si el representante, una vez notificado con el incumplimiento del/a estudiante, no hiciere nada para cumplir con la presente cláusula, el Centro de Estudios queda facultado a la aplicación de la normatividad prevista para cada caso, incluso la separación del plantel sin que se pueda alegar vulneración de los derechos del estudiante.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEXTA: COMPROMISO DEL CENTRO DE ESTUDIOS:</strong>
	<u>En caso de incumplimiento de los compromisos contraídos por el/a estudiante y  representante en el presente Convenio</u>, se aplicará en forma inmediata la cláusula quinta, para lo cual el Centro de Estudios, una vez cumplidas con todas las obligaciones para con el plantel, se compromete a entregar al representante la documentación correspondiente para que el/a estudiante pueda ser matriculado/a en otro establecimiento educativo, sin que se alegue vulneración de los derechos del estudiante.
	</p>
	<p class="letras_pequenas">
	Leído  que ha sido el presente Compromiso y comprendido el significado y alcance del contenido de todas y cada una de sus cláusulas, para constancia y aceptación de lo acordado, las partes intervinientes suscriben el presente documento, y el/a estudiante lo hace con expresa autorización de su representante, para que como parte de su formación, comprenda lo que es un compromiso y adquiera responsabilidades, en la ciudad de {$fecha_hoy_3}
	</p>

	<p class="letras_pequenas">
	<table>
	<tr>
	<td colspan="2">
	<br/>
	</td>
	</tr>
	<tr>
	<td class="centrar">
	_______________________________________________<br/>
	{$representante["nombres"]}<br/>
	El (la) Representante.<br/>
	</td>
	<td class="centrar">
	_______________________________________________<br/>
	{$alumno["nombres"]} {$alumno["apellidos"]}<br/>
	El (la) Estudiante.<br/>
	</td>
	</tr>
	<tr>
	<td class="centrar" colspan="2">
	_______________________________________________<br/>
	Por {$nombre_colegio}
	</td>
	</tr>
	</table> 
	</p>        
	</div>
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
}
	
$pdf->Output('compromiso_comportamiento.pdf', 'I');
?>
