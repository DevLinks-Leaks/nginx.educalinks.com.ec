<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='ficha_estudiante.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
		
	/*Existe un get con alum_codi?*/
	if (isset($_GET['alum_codi']))
		$alum_codi=$_GET['alum_codi'];
	else
		$alum_codi=0;
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);

	class MYPDF extends TCPDF 
	{	public function Header() 
		{	$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
			$this->Image($logo_minis, 12, 0, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
		public function Footer() 
		{	$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
	 
	/*Creación de objeto TCPDF*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($cliente);
	$pdf->SetAuthor($cliente);
	$pdf->SetTitle($cliente);
	$pdf->SetSubject($cliente);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
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
$jornada = para_sist(35);
if ($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp')
{	$jornada_lbl  = "<h1>Jornada ".$jornada."</h1>";
}
else
{	$jornada_lbl = "";
}

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
	{$jornada_lbl}
	<h1>INFORMACIÓN PERSONAL PARA MATRÍCULA</h1>
	<p></p>
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
			<td width="15%">{$row_madre["telefono"]}</td>
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
			<td width="15%">{$row_padre["telefono"]}</td>
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
			<td width="15%">{$row_representante["telefono"]}</td>
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
EOD;
$pdf->writeHTML($html, true, false, false, false, '');
if ($_SERVER['HTTP_HOST']=="moderna.educalinks.com.ec"){
	$file_exi='../'.$_SESSION['ruta_foto_alumno'].$alum_codi.'.jpg';
	if (file_exists($file_exi)){
	    $img_alum=$file_exi;
	}else{
	    $img_alum='../../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
	}
	$pdf->Image($img_alum, 170, 6, 25, 30, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
}else{
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
}

$pdf->Output('solicitud_matricula.pdf', 'I');
?>