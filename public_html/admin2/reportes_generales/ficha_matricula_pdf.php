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
	$jornada = para_sist(35);
	$nombre_legal = para_sist(53);
	$dominio = $_SERVER['HTTP_HOST'];

	class MYPDF extends TCPDF 
	{	private $url_colegio;
		public function Header() 
		{	if ($this->url_colegio == "liceonaval.educalinks.com.ec" || $this->url_colegio == "liceonavalvesp.educalinks.com.ec"){
				$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
				$this->Image($logo_web, 15, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				
				$logo_distr = '../'.$_SESSION['ruta_foto_logo_distr'];
				$this->Image($logo_distr, 175, 13, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			}
			
			if ($this->url_colegio != "liceonaval.educalinks.com.ec" && $this->url_colegio != "liceonavalvesp.educalinks.com.ec"){
				$this->SetFont('helvetica', 'N', 10);
				$this->Cell(12, 10, date('d.m.Y'), 0, 0, 'C', false, 1, 0, false, 'T', 'M');
			}
		}
		public function Footer() 
		{	
		}
		public function setURLColegio($value){
			$this->url_colegio = $value;
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
	$pdf->setURLColegio($dominio);
	
	$sql="{call ficha_matricula_cons(?,?)}";
	$params = array($_GET['curso_paralelo'],$alum_curs_para_codi);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	while ($row_alum = sqlsrv_fetch_array($stmt)){
		$pdf->AddPage();

		$alum_fech_naci = date_format($row_alum["alum_fech_naci"],'d/m/Y');
		$alum_codi = $row_alum["alum_codi"];
		/*Datos de la madre*/
		$sql = "{call repr_info_vida(?,?)}";
		$params=array($alum_codi,"M");
		$stmt1 = sqlsrv_query($conn, $sql, $params);
		$row_madre = sqlsrv_fetch_array($stmt1);
		/*Datos de la padre*/
		$sql = "{call repr_info_vida(?,?)}";
		$params=array($alum_codi,"P");
		$stmt2 = sqlsrv_query($conn, $sql, $params);
		$row_padre = sqlsrv_fetch_array($stmt2);
		/*Datos del representante*/
		$sql = "{call repr_info_vida(?,?)}";
		$params=array($alum_codi,"R");
		$stmt3 = sqlsrv_query($conn, $sql, $params);
		$row_representante = sqlsrv_fetch_array($stmt3);

		if ($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp')
		{	$jornada_lbl  = "<h1>Jornada ".$jornada."</h1>";
		}
		else
		{	$jornada_lbl = "";
		}

		/*No intentar esto en casa*/
		if ($dominio=='duplos.educalinks.com.ec' or $dominio=='arcoiris.educalinks.com.ec')
		{	$genero  = "<tr>";
			$genero .= '<td width="25%" class="negrita">';
			$genero .= "Género:";
			$genero .= "</td>";
			$genero .= "<td>";
			$genero .= ($row_alum["alum_genero"]?"M":"F");
			$genero .= "</td>";
			$genero .= "</tr>";
		}
		else
		{	$genero .= "";
		}
		if ($dominio=='duplos.educalinks.com.ec' or $dominio=='arcoiris.educalinks.com.ec')
		{	$emergencia  = "<tr>";
			$emergencia .= '<td width="25%" class="negrita">';
			$emergencia .= "Emergencia:";
			$emergencia .= "</td>";
			$emergencia .= "<td>";
			$emergencia .= $row_alum["alum_telf_emerg"]." - ".$row_alum["alum_pers_emerg"]." (".$row_alum["alum_paren_emerg"].")";
			$emergencia .= "</td>";
			$emergencia .= "</tr>";
		}
		else
		{	$genero .= "";
		}
		if ($dominio=='duplos.educalinks.com.ec' or $dominio=='arcoiris.educalinks.com.ec')
		{	$observacion = "El infraescrito representante del estudiante matriculado, declara que se encuentra conforme con los datos que anteceden y además está dispuesto a colaborar y asistir a todas las actividades y reuniones a las que sea convocado.";
		}
		else
		{	$observacion = "Observación:";
		}
		if ($dominio=='duplos.educalinks.com.ec' or $dominio=='arcoiris.educalinks.com.ec')
		{	$firma  = "_____________________________________<br/>";
			$firma .= $rector."<br/>";
			$firma .= $etiqueta_rector;
		}
		else
		{	$firma  = "_____________________________________<br/>";
			$firma .= $secretario."<br/>";
			$firma .= $etiqueta_secretario;
		}
		if ($dominio=='moderna.educalinks.com.ec')
		{	$curso_nive_para ='<p><h4>En el curso '.$row_alum["curs_deta"].' DE '.$row_alum["nive_deta"].' "'.$row_alum["para_deta"].'"</h4></p>';
		}else
		{
			$curso_nive_para ='<p><h4>En el curso '.$row_alum["curs_deta"].' '.$row_alum["para_deta"].'</h4></p>';
		}
		$size_h1 = "14px";
		if ($dominio != "liceonaval.educalinks.com.ec" && $dominio != "liceonaval.educalinks.com.ec"){
			$nombre_legal = '"'.$nombre_legal.'"';
			$size_h1 = "16px";
		}

		/*Fin*/
	
$html=<<<EOD
	<style>
	h1
	{	font-size: {$size_h1};
		line-height: 100%;
		padding-bottom: 0px;
		text-align: center;
	}
	h3
	{	font-size: 18px;
		text-align: left;
	}
	h3
	{	font-size: 15px;
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
	<h1>{$nombre_legal}</h1>
	{$jornada_lbl}
	<h1>{$_SESSION['peri_deta']}</h1>
	</p>
	<p>
	<table width="100%">
	<tr>
	<td class="negrita" width="80%"><h3>Acta de matrícula N° {$row_alum["alum_curs_para_folio"]}</h3></td>
	<td class="negrita"><h3>Cód. : {$row_alum["alum_codi"]}</h3></td>
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
	{$curso_nive_para}
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
		{$genero}
		{$emergencia}
	</table><br/><br/>
	<table border="1" width="100%">
		<tr>
			<td width="20%" class="negrita">Nombre del padre:</td>
			<td width="40%">{$row_padre["repr_apel"]} {$row_padre["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="30%">{$row_padre["cedula"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Lugar de trabajo:</td>
			<td width="40%">{$row_padre["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Profesión:</td>
			<td width="40%">{$row_padre["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="30%"> {$row_padre["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Correo:</td>
			<td colspan="3">{$row_padre["correo"]}</td>
		</tr>
	</table><br/><br/>
	<table border="1" width="100%">
		<tr>
			<td width="20%" class="negrita">Nombre del madre:</td>
			<td width="40%">{$row_madre["repr_apel"]} {$row_madre["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="30%">{$row_madre["cedula"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Lugar de trabajo:</td>
			<td width="40%">{$row_madre["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Profesión:</td>
			<td width="40%">{$row_madre["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="30%"> {$row_madre["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Correo:</td>
			<td colspan="3">{$row_madre["correo"]}</td>
		</tr>
	</table><br/><br/>
	<table border="1" width="100%">
		<tr>
			<td width="20%" class="negrita">Representante:</td>
			<td width="40%">{$row_representante["repr_apel"]} {$row_representante["repr_nomb"]}</td>
			<td width="10%" class="negrita">Cédula:</td>
			<td width="30%">{$row_representante["cedula"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Lugar de trabajo:</td>
			<td width="40%">{$row_representante["lugar_trabajo"]}</td>
			<td width="10%" class="negrita">Telf. Tbj: </td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Profesión:</td>
			<td width="40%">{$row_representante["profesion"]}</td>
			<td width="10%" class="negrita">Celular:</td>
			<td width="30%"> {$row_representante["repr_celular"]}</td>
		</tr>
		<tr>
			<td width="20%" class="negrita">Correo:</td>
			<td colspan="3">{$row_representante["correo"]}</td>
		</tr>
	</table>
	<p>
	<table width="100%">
	<tr>
	<td class="negrita">{$observacion}</td>
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
	{$firma}
	</td>
	</tr>
	</table>
	</p>
EOD;
		$pdf->writeHTML($html, true, false, false, false, '');
		if ($_SERVER['HTTP_HOST']=="moderna.educalinks.com.ec" || $_SERVER['HTTP_HOST']=="liceonaval.educalinks.com.ec" || $_SERVER['HTTP_HOST']=="liceonavalvesp.educalinks.com.ec"){
			$file_exi='../'.$_SESSION['ruta_foto_alumno'].$alum_codi.'.jpg';
			if (file_exists($file_exi)){
			    $img_alum=$file_exi;
			}else{
			    $img_alum='../../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
			}
			$pdf->Image($img_alum, 165, 30, 20, 25, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
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
	}
$pdf->Output('solicitud_matricula.pdf', 'I');
?>