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
	$jornada = mb_strtoupper(para_sist(35),'UTF-8');
	$sexo_rector=para_sist(51);
	$sexo_secretaria=para_sist(52);
	$nombre_legal=pasarMayusculas(para_sist(53));
	if($sexo_rector =='F'){$sexo_rector_art='la';}else{$sexo_rector_art='el';}
	if($sexo_secretaria =='F'){$sexo_secretaria_art='la';}else{$sexo_secretaria_art='el';}
	
		
	$sql="{call cert_promocion_cons(?,?,?)}";
	$params = array($_GET['curso_paralelo'], $_GET['alumno'],$_GET['peri_dist_codi']);
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
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis_long']; //derecho
			$this->Image($logo_minis, 150, 30, '', 23, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_distr = '../'.$_SESSION['ruta_foto_escudo_ecuador']; //izquierdo
			$this->Image($logo_distr, 23, 30, '', 21, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
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
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$arrDatos=array();
	$arrMatriculaTemp=array();
	while ($alumno=sqlsrv_fetch_array($stmt))
	{
		$arrDatos[]=$alumno;
		$arrMatriculaTemp[]=$alumno["matricula"];
	}

	$arrMatricula=array_unique($arrMatriculaTemp);

	foreach ($arrMatricula as $valMatricula)
	{
		$i=0;
		$flag=1;
		$suma=0;
		$cont_materias=0;
		$nota_comportamiento=-1;
		$calificaciones='<table border="0.7" cellpadding="3">
							<tr>
								<td rowspan="2" class="encabezado_asignaturas" width="30%"><b>ÁREAS</b></td>
								<td rowspan="2" class="encabezado_asignaturas" width="30%"><b>ASIGNATURAS</b></td>
								<td colspan="2" class="encabezados" width="40%"><b>CALIFICACIONES</b></td>
							</tr>
							<tr>
								<td class="encabezados" width="15%"><b>NÚMEROS</b></td>
								<td class="encabezados" width="25%"><b>LETRAS</b></td>
							</tr>';
		$pdf->AddPage();
		$area_anterior='';
		while ($i<count($arrDatos))
		{
			if ($valMatricula==$arrDatos[$i]['matricula'])
			{
				
				$anio_lectivo=$arrDatos[$i]['periodo'];
				$estudiante_nombres=$arrDatos[$i]['apellidos'].' '.$arrDatos[$i]['nombres'];
				$estudiante_curso=$arrDatos[$i]['detalle'];
				$estudiante_curso_promovido=($arrDatos[$i]['curso_promovido']=='')?'CURSO INMEDIATO SUPERIOR':$arrDatos[$i]['curso_promovido'];
				if (($arrDatos[$i]['mate_tipo']<>"D") and ($arrDatos[$i]['mate_tipo']<>"P"))
				{
					if($area_anterior!=$arrDatos[$i]['area_deta']){
						$pot=0;
						$j=$i;
						$area_anterior=$arrDatos[$i]['area_deta'];
						while(($arrDatos[$j]['area_deta']==$area_anterior) and ($arrDatos[$j]['matricula']==$arrDatos[$i]['matricula'])){
							$area_anterior=$arrDatos[$j]['area_deta'];
							$pot++;
							$j++;

						}
						$calificaciones.='<tr>';
						$calificaciones.='<td width="30%" rowspan="'.$pot.'" class="materias"> '.$arrDatos[$i]['area_deta'].'</td>';
						$calificaciones.='<td width="30%" class="materias"> '.$arrDatos[$i]['materia_detalle'].'</td>';
						
						if ($arrDatos[$i]['mate_tipo']=='C')
						{
							$calificaciones.='<td width="15%" class="calificaciones"> '.str_replace(".",",",$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='<td width="25%" class="enletras"> '.pasarMayusculas(AifLibNumber::toWord($arrDatos[$i]['materia_calificacion'])).'</td>';
							$cont_materias++;
							$suma+=$arrDatos[$i]['materia_calificacion'];
						}
						else
						{
							$calificaciones.='<td width="15%" class="calificaciones"> '.notas_prom_quali($_SESSION['peri_codi'],$arrDatos[$i]['mate_tipo'],$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='<td width="25%" class="enletras"> '.notas_prom_quali_deta($_SESSION['peri_codi'],$arrDatos[$i]['mate_tipo'],$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='</tr>';
						}
							$calificaciones.='</tr>';
					}else{

						$calificaciones.='<tr>';
						$calificaciones.='<td width="30%" class="materias"> '.$arrDatos[$i]['materia_detalle'].'</td>';
						if ($arrDatos[$i]['mate_tipo']=='C')
						{
							$calificaciones.='<td width="15%" class="calificaciones"> '.str_replace(".",",",$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='<td width="25%" class="enletras"> '.pasarMayusculas(AifLibNumber::toWord($arrDatos[$i]['materia_calificacion'])).'</td>';
							$cont_materias++;
							$suma+=$arrDatos[$i]['materia_calificacion'];
						}
						else
						{
							$calificaciones.='<td width="15%" class="calificaciones"> '.notas_prom_quali($_SESSION['peri_codi'],$arrDatos[$i]['mate_tipo'],$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='<td width="25%" class="enletras"> '.notas_prom_quali_deta($_SESSION['peri_codi'],$arrDatos[$i]['mate_tipo'],$arrDatos[$i]['materia_calificacion']).'</td>';
							$calificaciones.='</tr>';
						}
							$calificaciones.='</tr>';
					}
					
				}
				else
				{
					if ($arrDatos[$i]['mate_tipo']=="D")
					{
						$nota_comportamiento=$arrDatos[$i]['materia_calificacion'];
						$tipo_mate_comp = $arrDatos[$i]['mate_tipo'];
					}
					else
					{
						$nota_proyecto=$arrDatos[$i]['materia_calificacion'];
						$tipo_mate_proy = $arrDatos[$i]['mate_tipo'];
					}
				}
				$area_anterior=$arrDatos[$i]['area_deta'];
			}
			$i++;
		}
		/*if ($_SERVER['HTTP_HOST']=="moderna.educalinks.com.ec")
		{
			$texto_princ = '<p>De conformidad con lo prescrito en el Art. 197 del Reglamento General a la Ley Orgánica 
							de Educación Intercultural y demás normativas vigentes, certifica que el(la) estudiante: <br/>
							<p align="center"><b>'.$estudiante_nombres.'</b></p><br/> Del '.$estudiante_curso.'<br/> Obtuvo las siguientes calificaciones 
							durante el presente año lectivo.</p>';
			$bajar ="<br/>";
			$class_texto_comp ="materia_comportamiento_moderna bordes_anchos";
			$class_texto_prom ="promedio_general_moderna bordes_anchos";
		}
		else
		{*/
			$texto_princ = "<p>De conformidad con lo prescrito en el Art. 197 del Reglamento General a la Ley Orgánica 
							de Educación Intercultural y demás normativas vigentes, certifica que el(la) estudiante 
							<b>$estudiante_nombres,</b> del <b>$estudiante_curso</b>, obtuvo las siguientes calificaciones 
							durante el presente año lectivo.</p>";
			$bajar ="<br/>";
			//$class_texto_comp ="materia_comportamiento_otros bordes_anchos";
			$class_texto_comp ="materia_comportamiento_otros";
			//$class_texto_prom ="promedio_general_otros bordes_anchos";
			$class_texto_prom ="promedio_general_otros";
		//}
		
		/*if ($_SERVER['HTTP_HOST']=="liceopanamericano.educalinks.com.ec" or $_SERVER['HTTP_HOST']=="liceopanamericanosur.educalinks.com.ec")
			$class_texto = "texto bordes_anchos";
		else
			$class_texto = "materias bordes_anchos";
		*/	
			//Promedio general
			$calificaciones.='<tr>';
			$calificaciones.='<td width="30%" class="'.$class_texto_prom.'"> <b>PROMEDIO GENERAL</b></td>';
			$calificaciones.='<td width="30%" class="'.$class_texto_prom.'"></td>';
			$calificaciones.='<td width="15%" class="'.$class_texto_prom.' centrar"> <b>'.str_replace(".",",",number_format(truncar($suma/$cont_materias),2)).'</b></td>';
			$calificaciones.='<td width="25%" class="'.$class_texto_prom.'"> <b>'.pasarMayusculas(AifLibNumber::toWord(number_format(truncar($suma/$cont_materias),2))).'</b></td>';
			$calificaciones.='</tr>';
			

			//Clubes
			if ($nota_proyecto<>'')
			{
				$calificaciones.='<tr>';
				$calificaciones.='<td width="30%" class="materias">EVALUACIÓN DE PROYECTOS EDUCATIVOS</td>';
				$calificaciones.='<td width="30%" class="'.$class_texto_prom.'"></td>';
				$calificaciones.='<td width="15%" class="calificaciones"> '.notas_prom_quali($_SESSION['peri_codi'],$tipo_mate_proy,$nota_proyecto).'</td>';
				$calificaciones.='<td width="25%" class="enletras"> '.notas_prom_quali_deta_2($_SESSION['peri_codi'],$tipo_mate_proy,$nota_proyecto).'</td>';
				$calificaciones.='</tr>';
			}
			
			//Comportamiento
			$calificaciones.='<tr>'; 
			$calificaciones.='<td width="30%" class="materias"> EVALUACIÓN DEL COMPORTAMIENTO</td>';
			$calificaciones.='<td width="30%" class="materias"></td>';
			$calificaciones.='<td width="15%" class="materias centrar">'.substr(notas_prom_quali($_SESSION['peri_codi'],$tipo_mate_comp,$nota_comportamiento),0,1).'</td>';
			$calificaciones.='<td width="25%" class="materias"> '.notas_prom_quali_deta_2($_SESSION['peri_codi'],$tipo_mate_comp,$nota_comportamiento).'</td>';
			$calificaciones.='</tr>';
					
			
		
		
			
			$calificaciones.='</table>';

		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_TIME, 'spanish');
		$fecha_hoy=strftime("%d de %B de %Y");
		
		if($estudiante_curso_promovido=='CURSO INMEDIATO SUPERIOR'){
			$text_promovido='';
		}else{
			$text_promovido='Por lo tanto es promovido(a) a <b>'.$estudiante_curso_promovido.'</b>';
		}
		
		$tbl=<<<EOF
		<style>
		.encabezados
		{
			text-align: center;
			font-family: arial;
			font-size: 11px;
			line-height:20px;
		}
		.encabezado_asignaturas
		{
			text-align: center;
			font-family: arial;
			font-size: 11px;

		}
		.centrar
		{
			text-align: center;
		}
		.titulo
		{
			letter-spacing: 0.5px;
			text-align: center;
			font-size: 12px;
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
		</style>
		
		<table  border="0">
			<tr>
				
				<td colspan="2" class="titulo" >COORDINACIÓN ZONAL</td>
				
			</tr>
			<tr>
				
				<td colspan="2" class="titulo" >{$antes_del_distrito} {$nombre_distrito}</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">&nbsp;</td>
			</tr>
			<tr>
				
				<td colspan="2" class="titulo" >{$antes_del_nombre} <br/> "{$nombre_legal}"</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">CERTIFICADO DE PROMOCIÓN</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">AÑO LECTIVO {$anio_lectivo}</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">JORNADA {$jornada}</td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					{$texto_princ}
				</td>
			</tr>
			<tr>
				<td colspan="2"><br /></td>
			</tr>
			<tr>
				<td colspan="2">
					{$calificaciones}
				</td>
			</tr>
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					{$text_promovido}, para constancia suscriben en unidad de acto {$sexo_rector_art} {$etiqueta_rector_min} con {$sexo_secretaria_art} {$etiqueta_secretario_min} del Plantel que certifica.
				</td>
			</tr>
			<tr>
				<td colspan="2"><br /></td>
			</tr>
			<!--<tr>
				<td colspan="2" class="texto" align="right"><p>{$ciudad}, {$fecha_hoy}</p></td>
			</tr>-->
			<tr>
			<td colspan="2"><br/><br/><br/></td>
			</tr>
			<tr>
				<td align="center" class="firma">
					__________________________________<br/>
					{$rector}<br/>
					{$etiqueta_rector_mayus}
				</td>
				<td align="center" class="firma">
					__________________________________<br/>
					{$secretario}<br/>
					{$etiqueta_secretario_mayus}
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('cert_promocion.pdf', 'I');
?>
