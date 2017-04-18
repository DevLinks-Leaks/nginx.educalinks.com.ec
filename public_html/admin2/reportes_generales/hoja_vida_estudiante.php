<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='ficha_estudiante.pdf'");
	session_start();

	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php'); 
	require_once ('../../framework/funciones.php');

	if( $stmt === false )
	{	echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	class MYPDF extends TCPDF 
	{	private $ruta_foto;
		public function Header() 
		{	if ($this->page == 1) 
			{	$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
				$this->Image($logo_web, 13, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->SetFont('helvetica', 'I', 10);
				$this->MultiCell(160, 5, '', 0, 'C', 0, 1, '', '', true);
				$this->MultiCell(180, 5, para_sist(36).' '.para_sist(3), 0, 'C', 0, 1, '', '', true);
				$this->MultiCell(180, 5, 'AÑO LECTIVO '.$_SESSION['peri_deta'], 0, 'C', 0, 1, '', '', true);
				$this->MultiCell(180, 5, 'HOJA DE VIDA ESTUDIANTIL', 0, 'C', 0, 1, '', '', true);
				$this->Image($this->ruta_foto, 175, 15, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			}
		}
		public function Footer()
		{	// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
		public function setRutaFoto($root)
		{	$this->ruta_foto=$root;
		}
	}
	 
	$alum_curs_para_codi = $_GET['alum_curs_para_codi'];
	/*Datos del estudiante*/
	$params = array($alum_curs_para_codi);
	$sql = "{call alum_info_curs_para(?)}";
	$stmt = sqlsrv_query($conn, $sql,$params);
	if ( $conn === false)
	{	echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
	}
	$row_alum_info = sqlsrv_fetch_array($stmt);
	$alum_codi = $row_alum_info["alum_codi"];
	/*Datos del alumno*/
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
	/*Historial de observaciones*/
	$params = array($alum_curs_para_codi);
	$sql = "{call observacion_alum_info(?)}";
	$stmt = sqlsrv_query($conn, $sql,$params);
	if( $conn === false)
	{
		echo "Error in connection.\n";
		die( print_r( sqlsrv_errors(), true));
	}
	/*Foto alumno*/
	$alum_foto_ruta = '../'.$_SESSION['ruta_foto_alumno'].$row_alum_info["alum_codi"].".jpg";
	if (!file_exists($alum_foto_ruta))
		$alum_foto_ruta = '../'.$_SESSION['foto_default'];
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->setRutaFoto($alum_foto_ruta);
	$pdf->AddPage();
	
	$tabla_historial=
		'
			<table border="1" width="650" cellpadding="100%">
				<thead>
					<tr>
						<th class="etiquetas_historial" width="15%">Tipo Observación</th>
						<th class="etiquetas_historial" width="45%">Observación</th>
						<th class="etiquetas_historial" width="20%">Ingresado por</th>
						<th class="etiquetas_historial" width="10%">Perfil</th>
						<th class="etiquetas_historial" width="10%">Fecha</th>
					</tr>
				</thead>
				<tbody>
		';
	while ($row_historial=sqlsrv_fetch_array($stmt))
	{
		$tabla_historial .=
			'
					<tr>
						<td class="historial_registro" width="15%">'.$row_historial['obse_tipo_deta'].'</td>
						<td class="historial_registro" width="45%">'.$row_historial['obse_deta'].'</td>
						<td class="historial_registro" width="20%">'.$row_historial['usua_deta'].'</td>
						<td class="historial_registro" width="10%">'.$row_historial['usua_tipo'].'</td>
						<td class="historial_registro" width="10%">'.date_format($row_historial['obse_fech'],'d-m-Y').'</td>
					</tr>
			';
	}
	$tabla_historial.=
		'
				</tbody>
			</table>
		';

	$ncto = date_format($row_alum_info["alum_fech_naci"], "d/m/Y");
	$tbl=<<<EOF
	<style>
	.etiquetas
	{
		font-weight: bold;
		font-size: 10px;
		text-align:justified;
		font-family: sans-serif;
	}
	.etiquetas_historial
	{
		background-color: #66B2FF;
		font-weight: bold;
		font-size: 10px;
		text-align:justified;
		font-family: sans-serif;
	}
	.datos_personales
	{
		font-size: 10px;
		text-align:justified;
		line-height: 130%;
		font-family: sans-serif;
	}
	.historial_registro
	{
		font-size: 9px;
		text-align:justified;
		line-height: 130%;
		font-family: sans-serif;
	}
	.firma
	{
		font-size: 12px;
		font-weight: bold;
		text-align: center;
		font-family: sans-serif;
	}
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
	<br/><br/>
	<h3>DATOS DEL ESTUDIANTE</h3>
	<table width="650" border="1">
		<tr>
			<td width="10%">Apellidos:</td>
			<td width="40%">{$row_alum["alum_apel"]}</td>
			<td width="10%">Nombres:</td>
			<td width="40%">{$row_alum["alum_nomb"]}</td>
		</tr>
		<tr>
			<td width="10%">Curso:</td>
			<td width="40%">{$row_alum_info["curs_deta"]}</td>
			<td width="10%">Paralelo:</td>
			<td width="40%">{$row_alum_info["para_deta"]}</td>
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
	</table>
	<h3>DATOS DE LA MADRE</h3>
	<table width="650" border="1">
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
			<td width="8%">Celular</td>
			<td width="12%">{$row_madre["repr_celular"]}</td>
			<td width="10%">Correo</td>
			<td width="30%">{$row_madre["correo"]}</td>
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
			<td width="30%">{$row_madre["lugar_trabajo"]}</td>
			<td width="10%">Cargo:</td>
			<td width="15%">{$row_madre["cargo"]}</td>
			<td width="10%">Teléfono:</td>
			<td width="15%">{$row_madre["telefono"]}</td>
		</tr>
	</table>
	<h3>DATOS DEL PADRE</h3>
	<table width="650" border="1">
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
			<td width="8%">Celular</td>
			<td width="12%">{$row_padre["repr_celular"]}</td>
			<td width="10%">Correo</td>
			<td width="30%">{$row_padre["correo"]}</td>
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
			<td width="30%">{$row_padre["lugar_trabajo"]}</td>
			<td width="10%">Cargo:</td>
			<td width="15%">{$row_padre["cargo"]}</td>
			<td width="10%">Teléfono:</td>
			<td width="15%">{$row_padre["telefono"]}</td>
		</tr>
	</table>
	<h3>SI LA REPRESENTACIÓN EN LA INSTITUCIÓN EDUCATIVA LA EJERCIERA UN TERCERO:</h3>
	<h3>DATOS DEL(LA) REPRESENTANTE</h3>
	<table width="650" border="1">
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
			<td width="8%">Celular</td>
			<td width="12%">{$row_representante["repr_celular"]}</td>
			<td width="10%">Correo</td>
			<td width="30%">{$row_representante["correo"]}</td>
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
			<td width="30%">{$row_representante["lugar_trabajo"]}</td>
			<td width="10%">Cargo:</td>
			<td width="15%">{$row_representante["cargo"]}</td>
			<td width="10%">Teléfono:</td>
			<td width="15%">{$row_representante["telefono"]}</td>
		</tr>
	</table>
	<br/><br/>
	{$tabla_historial}
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		$pdf->Output('hoja_vida_estudiantil.pdf', 'I');
?>
