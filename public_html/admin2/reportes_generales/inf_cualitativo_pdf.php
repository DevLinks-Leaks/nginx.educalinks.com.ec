<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_promocion.pdf'");
	
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once ('../../framework/AifLibNumber.php');
	require_once('../../framework/dbconf.php');	
	require_once('../../framework/funciones.php');	

	$rector = para_sist(5);
	$secretario = para_sist(6);
	$etiqueta_rector_mayus=strtoupper(para_sist(33));
	$etiqueta_secretario_mayus=strtoupper(para_sist(34));
	$etiqueta_rector_min = ucwords(strtolower($etiqueta_rector_mayus));
	$etiqueta_secretario_min = ucwords(strtolower($etiqueta_secretario_mayus));
	$etiqueta_rector=para_sist(33);
	$etiqueta_secretario=para_sist(34);
	$ciudad = para_sist (31);
	$nombre_colegio = mb_strtoupper(para_sist(3),'UTF-8');
	$antes_del_nombre = mb_strtoupper(para_sist(36),'UTF-8');
	$nombre_distrito = mb_strtoupper(para_sist(56),'UTF-8');
	$antes_del_distrito = mb_strtoupper(para_sist(55),'UTF-8');
	$nombre_coordinacion_zonal=mb_strtoupper(para_sist(60),'UTF-8');
	$codigo_amie=para_sist(61);
	$jornada = mb_strtoupper(para_sist(35),'UTF-8');
	$sexo_rector=para_sist(51);
	$sexo_secretaria=para_sist(52);
	$nombre_legal=pasarMayusculas(para_sist(53));
	if($sexo_rector =='F'){$sexo_rector_art='la';}else{$sexo_rector_art='el';}
	if($sexo_secretaria =='F'){$sexo_secretaria_art='la';}else{$sexo_secretaria_art='el';}
	
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$firma_foto='../'.$_SESSION["ruta_foto_firma"];

	class MYPDF extends TCPDF 
	{
		public function Header() 
		{
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis_long']; //derecho
			$this->Image($logo_minis, 150, 10, '', 23, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_distr = '../'.$_SESSION['ruta_foto_escudo_ecuador']; //izquierdo
			$this->Image($logo_distr, 23, 9, '', 21, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			//$logo_web = '../'.$_SESSION['ruta_foto_escudo_ecuador']; //centro
			//$this->Image($logo_web, 100, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

			//FORMATO
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		}
	
		public function Footer() 
		{
			
		}
	}
	 
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator($_SESSION['cliente']);
	$pdf->SetAuthor($_SESSION['cliente']);
	$pdf->SetTitle($_SESSION['cliente']);
	$pdf->SetSubject($_SESSION['cliente']);
	$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	date_default_timezone_set('America/Guayaquil');
	setlocale(LC_TIME, 'spanish');
	$fecha_hoy=strftime("%d de %B de %Y");

	$sql="{call inf_cualitativo_cons(?,?,?)}";
	$params = array($_GET['curso_paralelo'], $_GET['alumno'],$_GET['peri_dist_codi']);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	while ($row_alumnos=sqlsrv_fetch_array($stmt))
	{
		
		$anio_lectivo=$row_alumnos['periodo'];
		$estudiante_nombres=$row_alumnos['apellidos'].' '.$row_alumnos['nombres'];
		$estudiante_curso=$row_alumnos['detalle'];
		$fecha_nacimiento=$row_alumnos['fecha_naci'];
		$para_deta=$row_alumnos['para_deta'];
		$nive_deta=$row_alumnos['nive_deta'];
		$peri_dist_deta=$row_alumnos['peri_dist_deta'];
		
		
		$sql="{call inf_cualitativo_cons_notas(?,?,?)}";
		$params = array($_GET['curso_paralelo'], $row_alumnos['alum_curs_para_codi'],$_GET['peri_dist_codi']);
		$stmt2 = sqlsrv_query($conn, $sql, $params);

		if( $stmt2 === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		/*Dinamico pero cambia el formato**
		$reporte_tabla='<table border="0.7" cellpadding="5">
							<tr>
								<td class="titulo centrar" width="5%"><b>No.</b></td>
								<td class="titulo centrar" width="50%"><b>ÁMBITOS DE DESARROLLO Y APRENDIZAJE</b></td>';
		$params = array('I', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
		while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
		{	$reporte_tabla.= '<td class="titulo centrar" width="15%"><b> '
									.strtoupper($row_nota_peri_cual_tipo_view['nota_peri_cual_deta']).
								'</b></td>';
		}
		$reporte_tabla.='</tr>';*/

		$reporte_tabla='<table border="0.7" cellpadding="5">
							<tr>
								<td class="titulo centrar" width="5%"><b>No.</b></td>
								<td class="titulo centrar" width="50%"><b>ÁMBITOS DE DESARROLLO Y APRENDIZAJE</b></td>
								<td class="titulo centrar" width="15%"><b>INICIADA</b></td>
								<td class="titulo centrar" width="15%"><b>EN PROCESO</b></td>
								<td class="titulo centrar" width="15%"><b>ADQUIRIDA</b></td>
							</tr>';

		$materias_proyecto_conteo=0;
		$cc=1;
		$cuerpo_proy='';
		while ($row_materias=sqlsrv_fetch_array($stmt2))
		{
			if($row_materias['nota']!=NULL)
				$nota_cuali=nota_peri_cual_cons($_SESSION['peri_codi'],$row_materias['nota_refe_cab_cod'],$row_materias['nota']);
			else
				$nota_cuali='';
			if($row_materias['nota_refe_cab_tipo']=='I'){
				$reporte_tabla.='<tr>';
				$reporte_tabla.='<td class="texto centrar" width="5%">'.$cc.'</td>';
				$reporte_tabla.='<td class="texto" width="50%">'.$row_materias['mate_deta'].'</td>';
				if($nota_cuali=='I')
					$reporte_tabla.='<td class="centrar" width="15%">X</td>';
				else
					$reporte_tabla.='<td width="15%"></td>';
				if($nota_cuali=='P')
					$reporte_tabla.='<td class="centrar" width="15%">X</td>';
				else
					$reporte_tabla.='<td width="15%"></td>';
				if($nota_cuali=='A')
					$reporte_tabla.='<td class="centrar" width="15%">X</td>';
				else
					$reporte_tabla.='<td width="15%"></td>';
				$reporte_tabla.='</tr>';
				$cc++;
			}elseif ($row_materias['nota_refe_cab_tipo']=='IP'){
				$materias_proyecto_conteo++;
				$cuerpo_proy='<tr>';
				$cuerpo_proy.='<td class="texto centrar" >'.$materias_proyecto_conteo.'</td>';
				$cuerpo_proy.='<td class="texto" >'.$row_materias['mate_deta'].'</td>';
				$params = array('IP', $_SESSION['peri_codi']);
				$sql="{call nota_peri_cual_tipo_view(?,?)}";
				$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
				while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
				{	
					if($nota_cuali==$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'])
						$cuerpo_proy.= '<td class="centrar">X</td>';
					else
						$cuerpo_proy.= '<td class="centrar"></td>';
				}
				$cuerpo_proy.= '</tr>';
			}
		}
		$reporte_tabla.='</table>';
		$reporte_tabla_proy='';
		if($materias_proyecto_conteo>0){
			$reporte_tabla_proy='<tr>
									<td colspan="2">
										&nbsp;
									</td>
								</tr>
								<tr>';
			$reporte_tabla_proy.='<table border="0.7" cellpadding="5">
									<tr>
										<td class="titulo centrar" width="5%"><b>No.</b></td>
										<td class="titulo centrar" width="35%"><b>PROYECTO</b></td>';
			$params = array('IP', $_SESSION['peri_codi']);
			$sql="{call nota_peri_cual_tipo_view(?,?)}";
			$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
			while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
			{	$reporte_tabla_proy.= '<td class="titulo centrar" width="15%"><b> '
										.strtoupper($row_nota_peri_cual_tipo_view['nota_peri_cual_deta']).
									'</b></td>';
			}
			$reporte_tabla_proy.='</tr>';
			$reporte_tabla_proy.= $cuerpo_proy.'</table></tr>';
		}

		

		$pdf->AddPage();
		$tbl=<<<EOF
		<style>
		.encabezados
		{
			text-align: center;
			font-family: arial;
			font-size: 11px;
			line-height:20px;
		}
		.asignaturas
		{
			font-size: 13px;

		}
		.centrar
		{
			text-align: center;
		}
		.titulo
		{
			letter-spacing: 0.5px;
			font-size: 12px;
			font-weight: bold;
			font-family: arial;
		}
		.tituloG
		{
			letter-spacing: 0.5px;
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			font-family: arial;
		}
		.tituloG2
		{
			letter-spacing: 0.5px;
			text-align: center;
			font-size: 18px;
			font-weight: bold;
			font-family: arial;
		}
		.tituloG3
		{
			letter-spacing: 0.5px;
			text-align: center;
			font-size: 15px;
			font-weight: bold;
			font-family: arial;
		}
		.subtitulo
		{
			text-align: center;
			font-size: 11px;
			font-family: arial;
		}
		.texto
		{
			font-size: 12px;
			text-align:justified;
			letter-spacing: 0.5px;
			line-height: 120%;
			font-family: arial;
		}
		.materias
		{
			font-size: 10px;
			line-height: 170%;
			font-family: arial;
		}
		.materia_comportamiento_moderna
		{
			font-size: 10px;
			font-family: arial;
		}
		.materia_comportamiento_otros
		{
			font-size: 10px;
			font-family: arial;
			font-weight: bold;
			line-height: 18px;
		}
		.promedio_general_moderna
		{
			font-size: 10px;
			font-family: arial;
			line-height: 30px;
		}
		.promedio_general_otros
		{
			font-size: 10px;
			font-family: arial;
			font-weight: bold;
			line-height: 30px;
		}
		.calificaciones
		{
			font-size: 12px;
			text-align: center;
			line-height: 130%;
			font-family: arial;
		}
		.enletras
		{
			font-size: 10px;
			text-align: justify;
			line-height: 130%;
			font-family: arial;
		}
		.firma
		{
			font-size: 12px;
			font-weight: bold;
			text-align: center;
			font-family: arial;
		}
		.bordes_anchos
		{
			border-style: solid;
			border-left-width:  1.5px;
			border-bottom-width:  1.5px;
			border-top-width:  1.5px;
			border-right-width:  1.5px;
			border-color: black;
		}
		.escala{
			border: 1px solid black;
		}
		</style>
		
		<table  border="0">
			<tr>
				<td colspan="2" class="tituloG" >REPÚBLICA DEL ECUADOR</td>
			</tr>
			<tr>
				<td colspan="2" class="tituloG" >MINISTERIO DE EDUCACIÓN</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="tituloG2">INFORME CUALITATIVO FINAL DE {$peri_dist_deta}</td>
			</tr>
			<tr>
				<td colspan="2" class="tituloG2">{$nive_deta}</td>
			</tr>
			<tr>
				<td colspan="2" class="tituloG3">{$estudiante_curso}</td>
			</tr>
			<tr>
				<td width="70%" class="titulo">COORDINACIÓN ZONAL: {$nombre_coordinacion_zonal}</td>
				<td width="30%" class="titulo">DISTRITO: {$nombre_distrito}</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">&nbsp;</td>
			</tr>
			<tr>
				<td width="70%" class="titulo">INSTITUCIÓN: {$antes_del_nombre} "{$nombre_legal}"</td>
				<td width="30%" class="titulo">CODIGO AMIE: {$codigo_amie}</td>
			</tr>
			<tr>
				<td width="70%" class="titulo">JORNADA: {$jornada}</td>
				<td width="30%" class="titulo">PARALELO: {$para_deta}</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo centrar">AÑO LECTIVO {$anio_lectivo}</td>
			</tr>
			
			<tr>
				<td width="70%" class="titulo">Nombres y Apellidos del Infante:</td>
				<td width="30%" class="titulo">Fecha de nacimiento:</td>
			</tr>
			<tr>
				<td width="70%" class="texto">{$estudiante_nombres}</td>
				<td width="30%" class="texto">{$fecha_nacimiento}</td>
			</tr>
			<tr>
				<td colspan="2"><br /></td>
			</tr>
			<tr>
				<table border="0.6">
					<th class="tituloG2 centrar">REPORTE DE DESARROLLO INTEGRAL</th>
				</table>
			</tr>
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<tr>
				{$reporte_tabla}
			</tr>
			{$reporte_tabla_proy}
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<table style="border: 1px solid black;" width="70%" cellpadding="2">
						<tr>
							<th class="titulo escala">ESCALA DE ESTIMACIÓN CUALITATIVA DE DESTREZAS:</th>
						</tr>
						<tr>
							<td class="texto">
								<b>INICIADA:</b> Inicia el desarrollo de destrezas
							</td>
						</tr>
						<tr>
							<td class="texto">
								<b>EN PROCESO:</b> En proceso de desarrollo de destrezas
							</td>
						</tr>
						<tr>
							<td class="texto">
								<b>ADQUIRIDA:</b> Adquiere el desarrollo de destrezas
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br /></td>
			</tr>
			<tr>
				<td colspan="6" class="titulo"><b>RECOMENDACIONES:</b></td>
			</tr>
			<tr>
				<td colspan="6">____________________________________________________________________________</td>
			</tr>
			<tr>
				<td colspan="6">____________________________________________________________________________</td>
			</tr>
			<tr>
				<td colspan="1"></td>
				<td colspan="5" class="texto" align="right">Lugar y fecha: {$ciudad}, {$fecha_hoy}</td>
			</tr>
			<tr>
			<td colspan="2"><br/></td>
			</tr>
			<tr width="100%">
				<td width="50%" align="center" class="firma">
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					__________________________________<br/>
					Tutor(a)
				</td>
				<td width="50%" align="center" class="firma">
					<img width="100" height="50" src="{$firma_foto}" />
					__________________________________<br/>
					{$rector}<br/>
					{$etiqueta_rector_mayus}
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('inf_cualitativo.pdf', 'I');
?>
