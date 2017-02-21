<?
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/funciones.php');
	require_once ('../../framework/dbconf.php'); 
	session_start();
	
	/*Begin Class*/
	class MYPDF extends TCPDF 
	{	public function Header() 
		{	$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 12, 0, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$this->SetY(5);
			$this->SetFont('helvetica', 'I', 6);
			$this->Cell(0, 10, 'R13-09 Versión 3 Feb/2016', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
		public function Footer() 
		{	$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}	 
	/*End Class*/

	/*Existe un get con alum_codi?*/
	if (isset($_GET['alum_codi']))
		$alum_codi=$_GET['alum_codi'];
	else
		$alum_codi=0;
	/*Código del periodo seleccionado*/
	$peri_codi=$_SESSION['peri_codi'];
	$peri_deta=$_SESSION['peri_deta'];
	/*Consulta  a la base para datos del contrato*/
	$sql = "{call alum_soli_matri_info(?,?)}";
	$params = array($alum_codi,$peri_codi);
	$stmt = sqlsrv_query($conn,$sql,$params);
	if ($stmt===false)
	{	die( print_r( sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt);
	/*Campos necesarios*/
	$cliente=$_SESSION['cliente'];
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("%d de %B de %Y");
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
	if($sexo_rector =='F')
	{	$sexo_rector_art='la';
		$senor='Señora';
	}
	else
	{	$sexo_rector_art='el';
		$senor='Señor';
	}
	if($sexo_secretaria =='F'){$sexo_secretaria_art='la';}else{$sexo_secretaria_art='el';}
	/*Creación de objeto TCPDF*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($cliente);
	$pdf->SetAuthor($cliente);
	$pdf->SetTitle($cliente);
	$pdf->SetSubject($cliente);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	/*Añadir nueva página*/
	$pdf->AddPage();
	$html=<<<EOF
	<style>
	h1
	{	font-size: 14px;
		text-align: center;
	}
	p
	{	padding: 0;
		margin: 0;
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
	.letras_normales
	{	font-size: 10px;
		text-align: justify;
	}
	</style>
	<h1>SOLICITUD DE MATRÍCULA<br/>
	ASPIRANTE A ESTUDIANTE DE {$nombre_colegio}</h1>
	<p class="letras_normales">{$ciudad}, {$fecha_hoy} </p>
	<p class="letras_normales">
	{$senor}<br/>
	{$etiqueta_rector} DE LA {$antes_del_nombre} {$nombre_colegio}<br/>
	Ciudad.
	</p>
	<p class="letras_normales">{$senor} {$etiqueta_rector}</p>
	<p class="letras_normales">
	El (la) infrascrito (a){$row["repr_nomb"]} {$row["repr_apel"]}, en mi calidad de {$row["repr_parentesco"]} del (la) menor {$row["alum_nomb"]} {$row["alum_apel"]}, considerando la visión, misión, objetivos  y principios de la Escuela de {$antes_del_nombre} {$nombre_colegio}, libre y voluntariamente solicito a usted, se sirva autorizar la respectiva matrícula para mi representado (a), que ha sido promovido (a) para  el {$row["curs_promovido"]} para el período lectivo {$peri_deta}.
	</p>
	<p class="letras_normales">
	Como representante del (la) menor anteriormente referido (a), declaro conocer la normativa legal y reglamentaria que rige el sistema educativo en el Ecuador en general y, en particular, el sistema de estudios del “{$nombre_colegio}”, su Proyecto Educativo Institucional – PEI y el Código de Convivencia, Reglamento Interno y demás Reglamentos específicos y regulaciones internas, que me han sido proporcionadas y se encuentran publicadas en la página web institucional; normatividad a la que me comprometo respetar y hacer que mi representado (a) la respete y la observe en su accionar dentro y fuera de la Institución.
	</p>
	<p class="letras_normales">
	En caso de ser aceptada mi solicitud de matrícula, expresamente me comprometo a:
	<ol>
		<li>
		Preocuparme todos los días de la formación integral de mi representado (a), es decir, a velar porque mi hogar se convierta en propulsor de los mismos anhelos y valores que propugna el {$nombre_colegio}, tanto en el aspecto espiritual y físico, como en el disciplinario y académico.
		</li>
		<li>
		Respetar a sus autoridades, personal docente, administrativo y de servicios.
		</li>
		<li>
		Acatar las decisiones y resoluciones institucionales.
		</li>
		<li>
		Cumplir con las obligaciones voluntariamente contraídas, en especial: la puntualidad en el ingreso a clases de mí representado (a), la observancia de su aseo y correcto uso del uniforme; el pago a tiempo de las expensas educativas (matrícula, pensiones por servicios educativos y valores por servicios complementarios acordados en el convenio). 
		</li>
		<li>
		Respaldar a las autoridades y proteger el buen nombre institucional.
		</li>
		<li>
		Responder por los daños que mi representado (a) causare, consciente o inconscientemente, a los bienes de la Institución o de terceras personas.
		</li>
		<li>
		Entregar en Secretaría General la documentación solicitada, debidamente legalizada, en los plazos determinados, en especial la referente a los antecedentes académicos, de conducta, de salud y cuidado médico del (la) estudiante, y a asumir todas las consecuencias que legalmente se deriven por el incumplimiento de esta obligación.
		</li>
		<li>
		Deslindar de toda responsabilidad al Centro de Estudios en el evento que se sucedieren actos insólitos, imprevistos o extraños a la vida educativa, dentro o fuera de la institución, tales como: accidentes durante paseos recreativos, recorrido del transporte escolar, giras de observación educativa; consecuencias fortuitas no esperadas, que se deriven de los primeros auxilios bajo pedido de mi representado (a): pérdida de bienes pertenecientes a los estudiantes; violación de las seguridades de los automotores dentro del aparcadero; secuestros o perjuicios graves en la integridad de los estudiantes por parte de terceras personas; accidentes de cualquier naturaleza ocurridos dentro o fuera del establecimiento; todo esto en mérito a que el {$nombre_colegio} es una Institución muy seria, respetada y responsable, a quien he confiado voluntariamente la custodia y ecuación de mi representado (a).
		</li>
		<li>
		A  asistir en el día y hora que se lo cite para tratar asuntos relacionados con el avance en la formación y educación del estudiante y se compromete a controlar su tiempo libre fuera de las aulas escolares para el cumplimiento de las tareas, estudio dirigido y las lecciones, así como el cumplimiento en sus  trabajos y deberes.
		</li>
		<li>
		Abrir todos los días la página del aula virtual del {$nombre_colegio} y mi correo electrónico, para revisar las notificaciones y citaciones que me efectúe la Institución, novedades y avances académicos de mi (s) representado (s).
		</li>
		<li>
		Finalmente me comprometo a colaborar para que esta Institución Educativa sea para mi (s) representado (a-os-as), la prolongación de mi hogar.
		</li>
	</ol>
	<p class="letras_normales">
	Para los efectos correspondiente, declaro que los datos personales del alumno (a) sus padres y del (la) representante, declarados en el reverso de esta solicitud de matrícula son verídicos; y autorizo en forma expresa para que las comunicaciones escritas, ya sea mediante circulares o misivas personales o de cualquier tipo de información me las envíen con mi representado (a); o indistintamente, la envíen a la dirección domiciliaria consignada, mensaje al teléfono celular,  o al correo electrónico que  tengo señalado en mis datos personales. 
	</p>
	<p class="letras_normales">
	Espero que la matrícula solicitada sea concedida bajo los compromisos y obligaciones anteriormente descritos, los mismos que tendrán validez durante todo el tiempo que mi representado (a) estudie en el {$nombre_colegio}, en cualquiera de sus niveles.
	</p>
	<p class="letras_normales">
	Muy atentamente.
	<br/>
	</p>
	<p class="letras_normales">
	_______________________________________<br/>
	Firma del (la) representante<br/>
	Cédula No.
	</p>
	</p>
EOF;
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->AddPage();

/*Consulta de datos del alumno*/
$sql = "{call alum_info(?)}";
$params=array($alum_codi);
$stmt = sqlsrv_query($conn, $sql, $params);
$row_alum = sqlsrv_fetch_array($stmt);
$alum_fech_naci=date_format($row_alum["alum_fech_naci"],'d/m/Y');
/*Datos de la madre*/
$sql = "{call repr_info_vida(?,?)}";
$params=array($alum_codi,"M");
$stmt = sqlsrv_query($conn, $sql, $params);
$row_madre = sqlsrv_fetch_array($stmt);
/*Datos de la padre*/
$sql = "{call repr_info_vida(?,?)}";
$params=array($alum_codi,"P");
$stmt = sqlsrv_query($conn, $sql, $params);
$row_padre = sqlsrv_fetch_array($stmt);
/*Datos del representante*/
$sql = "{call repr_info_vida(?,?)}";
$params=array($alum_codi,"R");
$stmt = sqlsrv_query($conn, $sql, $params);
$row_representante = sqlsrv_fetch_array($stmt);
/*Consulta de colaboradores*/
$sql = "{call colaboradores_cons(?)}";
$params=array($alum_codi);
$stmt = sqlsrv_query($conn, $sql, $params);
$tabla_colaboradores="<table width='100%' border='1'>";
$tabla_colaboradores.="<tr>";
$tabla_colaboradores.="<td width='35%'>Nombres</td>";
$tabla_colaboradores.="<td width='35%'>Apellidos</td>";
$tabla_colaboradores.="<td width='30%'>Cargo</td>";
$tabla_colaboradores.="</tr>";
while ($row_colab = sqlsrv_fetch_array($stmt))
{	$tabla_colaboradores.="<tr>";
	$tabla_colaboradores.="<td width='35%'>".$row_colab["repr_nomb"]."</td>";
	$tabla_colaboradores.="<td width='35%'>".$row_colab["repr_apel"]."</td>";
	$tabla_colaboradores.="<td width='30%'>".$row_colab["repr_cargo"]."</td>";
	$tabla_colaboradores.="</tr>";	
}
$tabla_colaboradores.="</table>";
$html=<<<EOD
	<style>
	h1
	{	font-size: 14px;
		text-align: center;
	}
	h3
	{	font-size: 12px;
		text-align: left;
	}
	p
	{	padding: 0;
		margin: 0;
	}
	table
	{	font-size: 10px;
		text-align: justify;
	}
	.centrar
	{	text-align: center;
	}
	.contenedor
	{	width: 100%;
	}
	.letras_pequenas
	{	font-size: 9px;
		text-align: justify;
	}
	.letras_normales
	{	font-size: 10px;
		text-align: justify;
	}
	</style>
	<br>
	<h1>INFORMACIÓN PERSONAL PARA MATRÍCULA</h1>
	<p class="letras_normales">Educación inicial _______ Educación Básica _______ Bachillerato _______</p>
	<h3>DATOS DEL (LA) ASPIRANTE</h3>
	<table width="100%" border="1">
		<tr>
			<td width="10%">Apellidos:</td>
			<td width="40%">{$row_alum["alum_apel"]}</td>
			<td width="10%">Nombres:</td>
			<td width="40%">{$row_alum["alum_nomb"]}</td>
		</tr>
		<tr>
			<td width="20%">Dirección domiciliaria:</td>
			<td width="80%">{$row_alum["alum_domi"]}</td>
		</tr>
		<tr>
			<td width="10%">Vive con:</td>
			<td width="90%">{$row_alum["alum_vive_con"]} ({$row_alum["alum_parentesco_vive_con"]})</td>
		</tr>
		<tr>
			<td width="10%">Teléfonos:</td>
			<td width="8%">Casa</td>
			<td width="22%">{$row_alum["alum_telf"]}</td>
			<td width="8%">Celular</td>
			<td width="22%">{$row_alum["alum_celu"]}</td>
			<td width="8%">Correo</td>
			<td width="22%">{$row_alum["alum_mail"]}</td>
		</tr>
		<tr>
			<td width="20%">Fecha de Nacimiento:</td>
			<td width="20%">{$alum_fech_naci}</td>
			<td width="15%">Ciudad:</td>
			<td width="15%">{$row_alum["alum_ciud"]}</td>
			<td width="15%">País:</td>
			<td width="15%">{$row_alum["alum_pais"]}</td>
		</tr>
		<tr>
			<td width="20%">Grado o curso anterior:</td>
			<td width="30%">{$row_alum["alum_ultimo_anio"]}</td>
			<td width="20%">Plantel:</td>
			<td width="30%">{$row_alum["alum_ex_plantel"]}</td>
		</tr>
		<tr>
			<td width="30%">Algún problema en el plantel anterior:</td>
			<td width="70%">{$row_alum["alum_motivo_cambio"]}</td>
		</tr>
		<tr>
			<td width="30%">Disciplina o deporte que practica:</td>
			<td width="70%">{$row_alum["alum_activ_deportiva"]}</td>
		</tr>
		<tr>
			<td width="30%">Actividad artística que practica:</td>
			<td width="70%">{$row_alum["alum_activ_artistica"]}</td>
		</tr>
		<tr>
			<td colspan="2">Enfermedades, alergias, medicinas, prohibiciones, inhabilidades o tratamiendo médico especial:</td>
		</tr>
		<tr>
			<td colspan="2">{$row_alum["alum_enfermedades"]}</td>
		</tr>
		<tr>
			<td width="100%"></td>
		</tr>
		<tr>
			<td>Colaboradores en {$nombre_colegio}</td>
		</tr>
		<tr>
			<td width="100%">
			{$tabla_colaboradores}
			</td>
		</tr>
	</table>
	<h3>DATOS DE LA MADRE</h3>
	<table border="1">
		<tr>
			<td width="10%">Apellidos:</td>
			<td width="40%">{$row_madre["repr_apel"]}</td>
			<td width="10%">Nombres:</td>
			<td width="40%">{$row_madre["repr_nomb"]}</td>
		</tr>
		<tr>
			<td width="20%">Dirección domiciliaria:</td>
			<td width="80%">{$row_madre["domicilio"]}</td>
		</tr>
		<tr>
			<td width="10%">Teléfonos:</td>
			<td width="15%">Casa</td>
			<td width="15%">{$row_madre["telefono"]}</td>
			<td width="15%">Celular</td>
			<td width="15%">{$row_madre["repr_celular"]}</td>
			<td width="15%">Correo</td>
			<td width="15%">{$row_madre["correo"]}</td>
		</tr>
		<tr>
			<td width="20%">Número de cédula:</td>
			<td width="20%">{$row_madre["cedula"]}</td>
			<td width="15%">Estado civil:</td>
			<td width="15%">{$row_madre["estado_civil"]}</td>
			<td width="15%">Nacionalidad:</td>
			<td width="15%">{$row_madre["nacionalidad"]}</td>
		</tr>
		<tr>
			<td width="20%">Empresa donde labora:</td>
			<td width="20%">{$row_madre["lugar_trabajo"]}</td>
			<td width="15%">Cargo:</td>
			<td width="15%">{$row_madre["cargo"]}</td>
			<td width="15%">Teléfono:</td>
			<td width="15%">{$row_madre["telefono"]}</td>
		</tr>
		<tr>
			<td width="25%">Dirección de trabajo:</td>
			<td width="75%">{$row_madre["direccion_trabajo"]}</td>
		</tr>
		<tr>
			<td width="25%">Profesión:</td>
			<td width="25%">{$row_madre["profesion"]}</td>
			<td width="25%">Religión:</td>
			<td width="25%">{$row_madre["religion"]}</td>
		</tr>
	</table>
	<h3>DATOS DEL PADRE</h3>
	<table border="1">
		<tr>
			<td width="10%">Apellidos:</td>
			<td width="40%">{$row_padre["repr_apel"]}</td>
			<td width="10%">Nombres:</td>
			<td width="40%">{$row_padre["repr_nomb"]}</td>
		</tr>
		<tr>
			<td width="20%">Dirección domiciliaria:</td>
			<td width="80%">{$row_padre["domicilio"]}</td>
		</tr>
		<tr>
			<td width="10%">Teléfonos:</td>
			<td width="15%">Casa</td>
			<td width="15%">{$row_padre["telefono"]}</td>
			<td width="15%">Celular</td>
			<td width="15%">{$row_padre["repr_celular"]}</td>
			<td width="15%">Correo</td>
			<td width="15%">{$row_padre["correo"]}</td>
		</tr>
		<tr>
			<td width="20%">Número de cédula:</td>
			<td width="20%">{$row_padre["cedula"]}</td>
			<td width="15%">Estado civil:</td>
			<td width="15%">{$row_padre["estado_civil"]}</td>
			<td width="15%">Nacionalidad:</td>
			<td width="15%">{$row_padre["nacionalidad"]}</td>
		</tr>
		<tr>
			<td width="20%">Empresa donde labora:</td>
			<td width="20%">{$row_padre["lugar_trabajo"]}</td>
			<td width="15%">Cargo:</td>
			<td width="15%">{$row_padre["cargo"]}</td>
			<td width="15%">Teléfono:</td>
			<td width="15%">{$row_padre["telefono"]}</td>
		</tr>
		<tr>
			<td width="25%">Dirección de trabajo:</td>
			<td width="75%">{$row_padre["direccion_trabajo"]}</td>
		</tr>
		<tr>
			<td width="25%">Profesión:</td>
			<td width="25%">{$row_padre["profesion"]}</td>
			<td width="25%">Religión:</td>
			<td width="25%">{$row_padre["religion"]}</td>
		</tr>
	</table>
	<p class="letras_normales">Relación de los padres: {$row_alum["alum_estado_civil_padres"]}</p>
	<h3>SI LA REPRESENTACIÓN EN LA INSTITUCIÓN EDUCATIVA LA EJERCERÁ UN TERCERO, DEBE LLENAR LA SIGUIENTE INFORMACIÓN:</h3>
	<h3>DATOS DEL(LA) REPRESENTANTE</h3>
	<table border="1">
		<tr>
			<td width="10%">Apellidos:</td>
			<td width="40%">{$row_representante["repr_apel"]}</td>
			<td width="10%">Nombres:</td>
			<td width="40%">{$row_representante["repr_nomb"]}</td>
		</tr>
		<tr>
			<td width="20%">Dirección domiciliaria:</td>
			<td width="80%">{$row_representante["domicilio"]}</td>
		</tr>
		<tr>
			<td width="10%">Teléfonos:</td>
			<td width="15%">Casa</td>
			<td width="15%">{$row_representante["telefono"]}</td>
			<td width="15%">Celular</td>
			<td width="15%">{$row_representante["repr_celular"]}</td>
			<td width="15%">Correo</td>
			<td width="15%">{$row_representante["correo"]}</td>
		</tr>
		<tr>
			<td width="20%">Número de cédula:</td>
			<td width="20%">{$row_representante["cedula"]}</td>
			<td width="15%">Estado civil:</td>
			<td width="15%">{$row_representante["estado_civil"]}</td>
			<td width="15%">Nacionalidad:</td>
			<td width="15%">{$row_representante["nacionalidad"]}</td>
		</tr>
		<tr>
			<td width="20%">Empresa donde labora:</td>
			<td width="20%">{$row_representante["lugar_trabajo"]}</td>
			<td width="15%">Cargo:</td>
			<td width="15%">{$row_representante["cargo"]}</td>
			<td width="15%">Teléfono:</td>
			<td width="15%">{$row_representante["telefono"]}</td>
		</tr>
		<tr>
			<td width="25%">Dirección de trabajo:</td>
			<td width="75%">{$row_representante["direccion_trabajo"]}</td>
		</tr>
		<tr>
			<td width="25%">Profesión:</td>
			<td width="25%">{$row_representante["profesion"]}</td>
			<td width="25%">Religión:</td>
			<td width="25%">{$row_representante["religion"]}</td>
		</tr>
		<tr>
			<td width="30%">Parentesco con el estudiante:</td>
			<td width="70%">{$row_representante["parentesco"]}</td>
		</tr>
	</table>
	<p class="letras_pequenas">El no existir anotaciones en el espacio correspondiente a “enfermedades, alergias, medicinas, inhabilidades o tratamiento especial”, significa que mi representado goza de muy buena salud y no necesita tratamiento especial. El ocultamiento de información o falsedad en el presente formulario, será falta extremadamente grave que será tratada de conformidad con la normatividad correspondiente. Autorizo al {$nombre_colegio} para que proceda a verificar los datos proporcionados, así como para que utilice la información consignada; y, para que las notificaciones circulares, personales o de cualquier tipo las envíe directamente con mi representado (a), las envíe a mi domicilio o por medio de mi correo electrónico declarado.<br/><b>Estas declaraciones fueron proporcionadas y el documento fue llenado por la misma persona, en la misma fecha que consta en el anverso, y como tal forma parte de la solicitud de matrícula.</b></p>
EOD;
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->SetFont('helvetica', 'I', 7);
$pdf->MultiCell(25,
		  	23,
		  	'Autorizo para que en caso de ser aceptado, se pegue en este lugar, copia de la fotografía del carné estudiantil',
		  	1,
		  	 'J',
		  	false,
		  	1,
		  	'170',
		  	'15',
		  	 true,
		  	 0,
		  	 false,
		  	 true,
		  	 0,
		  	 'T',
		  	 false 
	) ;
$pdf->Output('solicitud_matricula.pdf', 'I');
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='solicitud_matricula.pdf'");
?>
