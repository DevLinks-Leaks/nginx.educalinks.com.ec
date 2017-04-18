<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='compromiso_rendimiento.pdf'");
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
			$this->Cell(0,10,'Código: R13-10 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,15,'Versión: 2.0 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
			$this->Cell(0,20,'Octubre/2015', 0, false, 'R', 0, '', 0, false, 'T', 'M');

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
	$pdf->SetAutoPageBreak(TRUE, 14);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 

	$jornada = para_sist(35);
	if ($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp')
	{	$jornada_lbl  = '<tr>
							<td class="centrar"><h1>Jornada '.$jornada.'</h1><br/></td>
						</tr>';
	}
	else
	{	$jornada_lbl = "";
	}
	
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
		{$jornada_lbl}
		<tr>
			<td class="centrar"><h1>COMPROMISO EDUCATIVO DE RENDIMIENTO ACADÉMICO</h1></td>
			<!--<td class="derecha" style="font-size: 8px" width="25%">R13-08 <br/>Versión 5 <br/>Sep/2016</td>-->
		</tr>
	</table>
	<p class="letras_pequenas">
	Conste por el presente documento el compromiso educativo <b> de rendimiento académico </b> que se celebra al tenor de las siguientes cláusulas:
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA PRIMERA: INTERVINIENTES:</strong>
	El presente convenio se celebra entre la {$antes_del_nombre} "{$nombre_colegio}" y el/a señor/a {$representante["nombres"]} en su calidad de {$representante["parentesco"]} del/a estudiante {$alumno["nombres"]} {$alumno["apellidos"]} para quien ha solicitado matrícula para el {$alumno["curs_deta"]} año/curso, por el periodo lectivo {$alumno["periodo"]}; y que a efecto de la relación con el “{$nombre_colegio}”, será quien represente legalmente al/a referido/a estudiante;  a quienes en lo posterior, para los efectos del presente documento, se los podrá denominar como el/a) “estudiante y representante” o por separado “el/ a) estudiante”, y “el/a) representante”.
	</p>
	
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEGUNDA: OBJETIVO GENERAL: </strong>
	El presente convenio tiene por objeto dejar sentado el compromiso del/a   “estudiante” a cumplir y de su “representante” a velar y hacer que su representado/a cumpla, con las disposiciones legales y reglamentarias referente al rendimiento académico que se observa en el Centro de Estudios, durante todo el proceso educativo y actividades que se desarrollen en el año lectivo, para el cual  ha solicitado y se le ha concedido la matrícula, bajo el condicionamiento que se cumpla con los preceptos establecidos en la Ley Orgánica de Educación Intercultural y su Reglamento General ,en especial  lo determinado en los artículos 193,195 y 196  del Reglamento General a la Ley de Educación y los acuerdos y convenios establecidos en el Código de Convivencia del Plantel, vigente a la presente fecha .
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA TERCERA: COMPROMISO ESPECÍFICO DEL/A ESTUDIANTE:</strong>
	El/a estudiante, reconociendo que en el año lectivo anterior, su rendimiento académico no ha sido satisfactorio, en determinadas asignaturas, se compromete en forma expresa a:
	<br/>
	<br/><b>1.-</b> Demostrar una mejor predisposición al trabajo en los períodos de clases.
	<br/><b>2.-</b> Cumplir responsablemente con todas las tareas escolares.
	<br/><b>3.-</b> Destinar todas sus capacidades para la superación intelectual y el logro de los objetivos de aprendizaje correspondientes.
	<br/><b>4.-</b> Obtener puntajes superiores a 7 (Alcanza Aprendizajes Requeridos) en los promedios de evaluación de unidades y quimestres, en todas y cada una de las asignaturas.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA CUARTA: COMPROMISO ESPECÍFICO DEL/A REPRESENTANTE:</strong> 
	Ante el compromiso adquirido por el/a estudiante con autorización expresa de su representante, las partes determinan como condición exclusiva, para su permanencia en el Centro de Estudios, el/a) representante se obliga, a respetar y hacer respetar por parte de su representado, la condición establecida en la cláusula anterior, además que se obliga a:
	<br/>
	<br/><b>1.-</b> Apoyar, vigilar y estimular a su representado/a, en el cumplimiento del compromiso adquirido.
	<br/><b>2.-</b> Supervisar y facilitar en casa, el cumplimiento de las tareas escolares.
	<br/><b>3.-</b> Organizar y vigilar en casa el cumplimiento, de un horario de uso del tiempo libre, en el que conste un período de estudio.
	<br/><b>4.-</b> Recabar en forma periódica del docente tutor y de los demás docentes, la información correspondiente al avance en el estudio y rendimiento académico del/a estudiante, así como el grado de cumplimiento del presente compromiso.
	<br/><b>5.-</b> Acudir puntualmente a las convocatorias, que para tratar asuntos académicos, realice la institución
	<br/><b>6.-</b> Apoyar los esfuerzos y actividades que el Centro de Estudios realice, para mejorar el rendimiento del estudiante y facilitar su permanencia en el plantel.
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA QUINTA: INCUMPLIMIENTO:</strong>
	En caso de no cumplirse lo establecido en las cláusulas segunda, tercera y cuarta del presente convenio, quedará demostrada la falta de colaboración, del/a estudiante y su representante, al sistema académico del Liceo Panamericano, motivo por el cual el/a representante, retirará voluntariamente al/a   estudiante del Centro de Estudios, para evitar que su rendimiento no satisfactorio le pueda ocasionar su reprobación en las materias de estudio. Si el representante, una vez notificado con el/os incumplimiento/s de su representado/a, no hiciere nada para cumplir con la presente cláusula, el Centro de Estudios, queda totalmente facultado para aplicar la normatividad prevista para cada caso, deslindando de toda responsabilidad al Centro de Estudios 
	</p>
	<p class="letras_pequenas">
	<strong>CLÁUSULA SEXTA: COMPROMISO DEL CENTRO DE ESTUDIOS:</strong>
	En caso de incumplimiento de los compromisos contraídos por el/a estudiante y representante en el presente convenio, se aplicará en forma inmediata la cláusula quinta, para lo cual el Centro de Estudios, una vez cumplidas con todas las obligaciones para con el plantel, se compromete a entregar al representante la documentación correspondiente para que el/a estudiante pueda ser matriculado/a en otro establecimiento educativo.
	</p>
	<p class="letras_pequenas">
	Leído  que ha sido el presente Convenio y comprendido el significado y alcance del contenido de todas y cada una de sus cláusulas, para constancia y aceptación de lo acordado, las partes intervinientes suscriben el presente documento, y el/a estudiante, lo hace con expresa autorización de su representante, para que como parte de su formación, comprenda lo que es un compromiso y adquiera responsabilidades, en la ciudad de {$fecha_hoy_3}
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
	
$pdf->Output('compromiso_rendimiento.pdf', 'I');
?>
