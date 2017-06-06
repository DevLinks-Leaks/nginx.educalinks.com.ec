<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='certificado_matricula.pdf'");
	session_start();
	
	require_once ('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/dbconf.php');
	require_once ('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$ciudad_mayus = str_replace("ó","Ó",strtoupper($ciudad));
	$nombre_colegio = strtoupper(para_sist(53));
	$antes_del_nombre = para_sist(36);
	$etiqueta_rector_min = ucwords(strtolower($etiqueta_rector));
	$etiqueta_secretario_min = ucwords(strtolower($etiqueta_secretario));
	$jornada = strtoupper(para_sist(35));

	$sql="{call cert_matricula_cons(?,?)}";
	$params = array($_GET['curso_paralelo'], $_GET['alumno']);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis_long'];
			$this->Image($logo_minis, 10, 15, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			if ($_SESSION['directorio']=="moderna"){
				$logo_cole = '../'.$_SESSION['ruta_foto_logo_web'];
				$this->Image($logo_cole, 94, 15, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			}
			$logo_distr = '../'.$_SESSION['ruta_foto_escudo_ecuador'];
			$this->Image($logo_distr, 170, 15, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}

		public function Footer() 
		{
			$this->SetY(-15);
			$this->SetFont('helvetica', 'I', 8);
		}
	}
		 
	$pdf = new MYPDF('PORTRAIT', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(30);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$titulo_jornada='';
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("$ciudad, %d de %B de %Y");
	$fecha_hoy2=ucwords(strftime("%B, ")).strftime("%d de %Y");
	if ($_SESSION['directorio']=="ecobab" or $_SESSION['directorio']=="ecobabvesp" or $_SESSION['directorio']=="delfos" or $_SESSION['directorio']=="delfosvesp"){
		$titulo_jornada='<tr>
							<td colspan="2"><br/></td>
						</tr>
						<tr>
							<td colspan="2" class="titulo">JORNADA '.$jornada.'</td>
						</tr>';
		$linea_fecha='';
	}else{
		$linea_fecha='<tr>
						<td class="texto_info"><strong>Fecha:</strong></td>
						<td class="texto_info" colspan="3">'.$fecha_hoy.'</td>
					  </tr>';
	}

	if($_SESSION['directorio']=="moderna"){
		$encabezado = '	<tr>
							<td colspan="2" class="titulo"><br/><br/><br/>'.$antes_del_nombre.'<br/> "'.$nombre_colegio.'"</td>
						</tr>
						<tr>
							<td colspan="2" class="titulo"><br/></td>
						</tr>
						<tr>
							<td colspan="2" class="subtitulo"><br/>'.$ciudad_mayus.' - ECUADOR</td>
						</tr>
						<tr>
							<td colspan="2" class="titulo"><br/></td>
						</tr>
						<tr>
							<td colspan="2" class="titulo"><br/>CERTIFICADO DE MATRÍCULA</td>
						</tr>';
	}else{
		$encabezado = '	<tr>
							<td colspan="2" class="titulo"><br/><br/><br/><u>CERTIFICADO DE MATRÍCULA</u></td>
						</tr>
						<tr>
							<td colspan="2" class="titulo"><br/></td>
						</tr>
						<tr>
							<td colspan="2" class="titulo"><br/>'.$antes_del_nombre.'<br/> '.$nombre_colegio.'</td>
						</tr>
						'.$titulo_jornada.'
						<tr>
							<td colspan="2" class="titulo"><br/></td>
						</tr>
						<tr>
							<td colspan="2" class="subtitulo"><br/>'.$ciudad_mayus.' - ECUADOR</td>
						</tr>';
		
	}

	if($_SESSION['directorio']=="liceonaval" or $_SESSION['directorio']=="liceonavalvesp"){
		$texto='<p>LOS SUSCRITOS, '.$etiqueta_rector.' '.$rector.' Y SEÑORA '.$secretario.', EN CALIDAD DE RECTOR Y SECRETARIA GENERAL RESPECTIVAMENTE, CERTIFICAN QUE EL(A) ESTUDIANTE:</p>';
		$linea_fecha='';
		$linea_fecha2=$fecha_hoy2;
	}else{
		$linea_fecha2='';
		$texto='<p>Los suscritos, '.$etiqueta_rector_min.' y '.$etiqueta_secretario_min.', certifican que el(a) estudiante:</p>';
	}
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		// Añadir página
		$pdf->AddPage();
		$fecha_matricula=date_format($alumno["fecha"], "d/m/y");
		
		$fecha_moderna=strftime("$ciudad, %d de %B de %Y",strtotime(date_format($alumno['alum_curs_para_fech'],'y-m-d')));
		
		
		$texto_titulo="";
		if($alumno['tit_deta']=='CIENCIAS'){
			$texto_titulo='<tr>
							<td class="texto_info" width="20%"><strong>Tipo de Título:</strong></td>
							<td class="texto_info" width="30%">'.$alumno['tit_tipo_deta'].'</td>
							<td class="texto_info" width="20%"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info" width="30%">'.$alumno['curs_deta'].' "'.$alumno['para_deta'].'" '.'</td>
						</tr>
						<tr>
							<td class="texto_info" width="20%"><strong>Título:</strong></td>
							<td class="texto_info" width="30%">'.$alumno['tit_deta'].'</td>
							<td class="texto_info" width="20%"></td>
							<td class="texto_info" width="30%"></td>
						</tr>';
		}else{
			$texto_titulo='<tr>
							<td class="texto_info" width="22%"><strong>Nivel Educación:</strong></td>
							<td class="texto_info" width="28%">'.mb_strtoupper($alumno['tit_tipo_deta'],'UTF-8').'</td>
							<td class="texto_info" width="20%"><strong>Curso Paralelo:</strong></td>
							<td class="texto_info" width="30%">'.$alumno['curs_deta'].' "'.$alumno['para_deta'].'" '.'</td>
						</tr>';
		}
		
		if ($_SESSION['directorio']=="moderna"){
			$linea_fecha='<tr>
						<td class="texto_info"><strong>Fecha:</strong></td>
						<td class="texto_info" colspan="3">'.$fecha_moderna.'</td>
					  </tr>';
		}

		$tbl=<<<EOF
		<style>
		.titulo
		{
			letter-spacing: 2px;
			text-align: center;
			font-size: 18px;
			font-weight: bold;
			font-family: sans-serif;
		}
		.subtitulo
		{
			text-align: center;
			font-size: 16px;
			font-family: sans-serif;
		}
		.texto
		{
			font-size: 16px;
			text-align:justified;
			line-height: 200%;
			font-family: sans-serif;
		}
		.texto_info
		{
			font-size: 14px;
			text-align:left;
			line-height: 160%;
			font-family: sans-serif;
		}
		.firma
		{
			font-size: 12px;
			font-weight: bold;
			text-align: center;
			font-family: sans-serif;
		}
		</style>
		<table width="100%" border="0">
			{$encabezado}
			
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr>
							<td class="texto_info" width="22%"><strong>Año lectivo:</strong></td>
							<td class="texto_info" width="28%">{$alumno["periodo"]}</td>
							<td class="texto_info" width="20%"><strong>Nº matrícula:</strong></td>
							<td class="texto_info" width="30%">{$alumno["folio"]}</td>
						</tr>
						{$texto_titulo}
						{$linea_fecha}
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br/><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					{$texto}
					<p align="center"><b>{$alumno["apellidos"]} {$alumno["nombres"]}</b></p>
					<p>Previo al cumplimiento de los requisitos legales, se matriculó en el curso indicado 
					según consta en los registros de matrículas que reposan en esta institución.</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><br/><br/>{$linea_fecha2}<br/><br/><br/><br/></td>
			</tr>
			<tr>
				<td align="center" class="firma">
					__________________________________<br/>
					{$rector}<br/>
					<b>{$etiqueta_rector}</b>
				</td>
				<td align="center" class="firma">
					__________________________________<br/>
					{$secretario}<br/>
					<b>{$etiqueta_secretario}</b>
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
		if ($_SERVER['HTTP_HOST']=="moderna.educalinks.com.ec"){
			$file_exi='../'.$_SESSION['ruta_foto_alumno'].$alumno['alum_codi'].'.jpg';
			if (file_exists($file_exi)){
			    $img_alum=$file_exi;
			}else{
			    $img_alum='../../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
			}
			$pdf->Image($img_alum, 170, 50, 25, 30, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
		}
	}
	$pdf->Output('cert_matricula.pdf', 'I');
?>
