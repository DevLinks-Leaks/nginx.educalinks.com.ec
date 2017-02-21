<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='ficha_estudiante.pdf'");
	session_start();
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php'); 
	/*Existe un get con alum_curs_para_codi?*/
	if (isset($_GET['alum_curs_para_codi']))
		$alum_curs_para_codi=$_GET['alum_curs_para_codi'];
	else
		$alum_curs_para_codi=0;
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = para_sist(3);
	$antes_del_nombre = para_sist(36);
	$nombre_legal = para_sist(53);
	$dominio = $_SERVER['HTTP_HOST'];

	class MYPDF extends TCPDF 
	{	public function Header() 
		{	$this->SetFont('helvetica', 'N', 10);
			$this->Cell(20, 10, date('d.m.Y'), 0, 0, 'C', false, 1, 0, false, 'T', 'M');
		}
		public function Footer() 
		{	
		}
	}
	 
	/*Creación de objeto TCPDF*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($cliente);
	$pdf->SetAuthor($cliente);
	$pdf->SetTitle($cliente);
	$pdf->SetSubject($cliente);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	 
	$pdf->AddPage();

	
/*Consulta de datos del alumno*/
$sql = "{call alum_curs_para_info(?)}";
$params=array($alum_curs_para_codi);
$stmt = sqlsrv_query($conn, $sql, $params);
$row_alum = sqlsrv_fetch_array($stmt);
$alum_fech_naci = date_format($row_alum["alum_fech_naci"],'d/m/Y');
$alum_codi = $row_alum["alum_codi"];
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
	{	font-size: 16px;
		line-height: 100%;
		padding-bottom: 0px;
		text-align: center;
	}
	h3
	{	font-size: 18px;
		text-align: left;
	}
	p
	{	padding: 0;
		margin: 0;
	}
	table
	{	font-size: 12px;
		line-height: 120%;
		text-align: justify;
	}
	.centrar
	{	text-align: center;
	}
	.contenedor
	{	width: 100%;
	}
	.derecha
	{	text-align: right;
	}
	.letras_pequenas
	{	font-size: 9px;
		text-align: justify;
	}
	.letras_normales
	{	font-size: 14px;
		text-align: justify;
	}
	.negrita
	{	font-weight: bold;
	}
	.nombre_alumno
	{	font-size: 16px;
		font-weight: bold;
		text-align: center;
	}
	</style>
	<br>
	<p>
	<h1>{$antes_del_nombre}</h1>
	<h1>"{$nombre_legal}"</h1>
	<h1>{$_SESSION['peri_deta']}</h1>
	</p>
	<p>
	<table width="100%">
	<tr>
	<td class="negrita" width="80%"><h3>Acta de matrícula N° {$row_alum["alum_curs_para_folio"]}</h3></td>
	<td class="negrita"><h3>Cod.: {$row_alum["alum_codi"]}</h3></td>
	</tr>
	<tr>
	<td class="negrita" width="50%"><h3>Folio y tomo N° {$row_alum["alum_curs_para_folio"]}</h3></td>
	<td></td>
	</tr>
	</table>
	</p>
	<br/><br/>
	<p class="letras_normales">En la {$antes_del_nombre} {$nombre_colegio} de conformidad con el Reglamento General de Educación se matricula el alumno:</p>
	<p class="nombre_alumno">{$row_alum["alum_apel"]} {$row_alum["alum_nomb"]}</p>
	<p><h3>En el curso {$row_alum["curs_deta"]} {$row_alum["para_deta"]}</h3></p>
	<p>
	<table width="100%">
		<tr>
			<td width="25%" class="negrita">Fecha de nacimiento:</td>
			<td>{$alum_fech_naci}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Nacionalidad:</td>
			<td>{$row_alum["alum_nacionalidad"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Domicilio:</td>
			<td>{$row_alum["alum_domi"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Teléfono y celular:</td>
			<td>{$row_alum["alum_telf"]} - {$row_alum["alum_celu"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">N° de cédula:</td>
			<td>{$row_alum["alum_cedu"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Plantel de procedencia:</td>
			<td>{$row_alum["alum_ex_plantel"]}</td>
		</tr>
	</table>
	</p>
	<table border="1" width="100%">
		<tr>
			<td width="25%" class="negrita">Nombre del padre:</td>
			<td width="50%">{$row_padre["repr_apel"]} {$row_padre["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="15%">{$row_padre["cedula"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Lugar de trabajo:</td>
			<td width="50%">{$row_padre["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="15%"></td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Profesión:</td>
			<td width="50%">{$row_padre["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="15%"> {$row_padre["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Correo:</td>
			<td colspan="3">{$row_padre["correo"]}</td>
		</tr>
	</table><br/><br/>
	<table border="1" width="100%">
		<tr>
			<td width="25%" class="negrita">Nombre del madre:</td>
			<td width="50%">{$row_madre["repr_apel"]} {$row_madre["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="15%">{$row_madre["cedula"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Lugar de trabajo:</td>
			<td width="50%">{$row_madre["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="15%"></td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Profesión:</td>
			<td width="50%">{$row_madre["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="15%"> {$row_madre["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Correo:</td>
			<td colspan="3">{$row_madre["correo"]}</td>
		</tr>
	</table><br/><br/>
	<table border="1" width="100%">
		<tr>
			<td width="25%" class="negrita">Representante:</td>
			<td width="50%">{$row_representante["repr_apel"]} {$row_representante["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="15%">{$row_representante["cedula"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Lugar de trabajo:</td>
			<td width="50%">{$row_representante["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="15%"></td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Profesión:</td>
			<td width="50%">{$row_representante["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="15%"> {$row_representante["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="25%" class="negrita">Correo:</td>
			<td colspan="3">{$row_representante["correo"]}</td>
		</tr>
	</table>
	<p>
	<table width="100%">
	<tr>
	<td class="negrita">Observaciones:</td>
	</tr>
	</table>
	</p>
	<p>
	<table width="100%">
	<tr>
	<td width="50%" class="centrar">
	_____________________________________<br/>
	{$row_representante["repr_nomb"]} {$row_representante["repr_apel"]}<br/>
	Representante
	</td>
	<td class="centrar">
	_____________________________________<br/>
	{$secretario}<br/>
	{$etiqueta_secretario}
	</td>
	</tr>
	</table>
	</p>
EOD;
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->SetFont('helvetica', 'I', 7);
$pdf->MultiCell(25,
		  	30,
		  	'Foto',
		  	1,
		  	 'C',
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
?>