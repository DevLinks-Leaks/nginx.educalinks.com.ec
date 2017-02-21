<?
	header("Content-type:application/pdf");
	header("Content-Disposition:attachment;filename='cert_promocion.pdf'");
	
	require_once('../../framework/tcpdf/tcpdf.php');
	require_once('../../framework/EnLetras.php');
	require_once('../../framework/dbconf.php');	
	require_once('../../framework/funciones.php');		
	
	$rector = para_sist(5);
	$secretario = para_sist(6);
		
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
			$logo_minis = '../'.$_SESSION['ruta_foto_logo_minis'];
			$this->Image($logo_minis, 13, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_distr = '../'.$_SESSION['ruta_foto_logo_distr'];
			$this->Image($logo_distr, 180, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$logo_web = '../'.$_SESSION['ruta_foto_logo_web'];
			$this->Image($logo_web, 100, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
	$letras = new EnLetras();

	foreach ($arrMatricula as $valMatricula)
	{
		$i=0;
		$flag=1;
		$suma=0;
		$cont_materias=0;
		$nota_comportamiento=-1;
		$calificaciones='<table border="1">
							<tr>
								<td rowspan="2" class="encabezados" width="60%">ASIGNATURAS</td>
								<td colspan="2" class="encabezados" width="40%">CALIFICACIONES</td>
							</tr>
							<tr>
								<td class="encabezados" width="10%">NÚMERO</td>
								<td class="encabezados" width="30%">LETRAS</td>
							</tr>';
		$pdf->AddPage();
		
		while ($i<count($arrDatos))
		{
			if ($valMatricula==$arrDatos[$i]['matricula'])
			{
				$anio_lectivo=$arrDatos[$i]['periodo'];
				$estudiante_nombres=$arrDatos[$i]['apellidos'].' '.$arrDatos[$i]['nombres'];
				$estudiante_curso=$arrDatos[$i]['detalle'];
				$estudiante_curso_promovido=($arrDatos[$i]['curso_promovido']=='')?'CURSO INMEDIATO SUPERIOR':$arrDatos[$i]['curso_promovido'];
				if (($arrDatos[$i]['materia_detalle']<>"COMPORTAMIENTO") and (substr($arrDatos[$i]['materia_detalle'],0,4)<>"CLUB"))
				{
					$calificaciones.='<tr>';
					$calificaciones.='<td width="60%" class="materias"> '.$arrDatos[$i]['materia_detalle'].'</td>';
					if ($arrDatos[$i]['mate_tipo']=='C')
					{
						$calificaciones.='<td width="10%" class="calificaciones"> '.number_format($arrDatos[$i]['materia_calificacion'],2,',','').'</td>';
						$calificaciones.='<td width="30%" class="enletras"> '.strtoupper($letras->ValorEnLetras($arrDatos[$i]['materia_calificacion'], "")).'</td>';
						$calificaciones.='</tr>';
						$cont_materias++;
						$suma+=$arrDatos[$i]['materia_calificacion'];
					}
					else
					{
						$calificaciones.='<td width="10%" class="calificaciones"> '.notas_prom_quali(1,'Q',$arrDatos[$i]['materia_calificacion']).'</td>';
						$calificaciones.='<td width="30%" class="enletras"> '.notas_prom_quali_deta(1,'Q',$arrDatos[$i]['materia_calificacion']).'</td>';
						$calificaciones.='</tr>';
					}
				}
				else
				{
					if ($arrDatos[$i]['materia_detalle']=="COMPORTAMIENTO")
						$nota_comportamiento=$arrDatos[$i]['materia_calificacion'];
					else
						$nota_club=$arrDatos[$i]['materia_calificacion'];
				}
			}
			$i++;
		}
		//Promedio general
		$calificaciones.='<tr>';
		$calificaciones.='<td width="60%" class="materias"> <b>PROMEDIO GENERAL</b></td>';
		$calificaciones.='<td width="10%" class="calificaciones"> <b>'.number_format(($suma/$cont_materias),2,',','').'</b></td>';
		$calificaciones.='<td width="30%" class="enletras"> <b>'.strtoupper($letras->ValorEnLetras(($suma/$cont_materias), "")).'</b></td>';
		$calificaciones.='</tr>';
		
		//Comportamiento
		$calificaciones.='<tr>';
		$calificaciones.='<td width="60%" class="materias"> <b>EVALUACIÓN DEL COMPORTAMIENTO</b></td>';
		$calificaciones.='<td width="10%" class="calificaciones"> <b>'.notas_prom_quali($_SESSION['peri_codi'],'D',$nota_comportamiento).'</b></td>';
		$calificaciones.='<td width="30%" class="enletras"> <b>'.notas_prom_quali_deta($_SESSION['peri_codi'],'D',$nota_comportamiento).'</b></td>';
		$calificaciones.='</tr>';
				
		$calificaciones.='</table>';
		
		//Clubes
		if ($nota_club<>'')
		{
			$calificaciones.='<p><table><tr>';
			$calificaciones.='<td width="60%" class="materias" style="border-bottom: none !important;"> <b>CLUBES</b></td>';
			$calificaciones.='<td width="10%" class="calificaciones"> <b>'.notas_prom_quali(1,'Q',$nota_club).'</b></td>';
			$calificaciones.='<td width="30%" class="enletras"> <b>'.notas_prom_quali_deta(1,'Q',$nota_club).'</b></td>';
			$calificaciones.='</tr></table></center></p>';
		}
		
		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_TIME, 'spanish');
		$fecha_hoy=strftime("%d de %B de %Y");
		
		$tbl=<<<EOF
		<style>
		.encabezados
		{
			text-align: center;
			font-family: sans-serif;
			font-size: 12px;
		}
		.titulo
		{
			letter-spacing: 5px;
			text-align: center;
			font-size: 20px;
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
			font-size: 12px;
			text-align:justified;
			letter-spacing: 2px;
			line-height: 100%;
			font-family: sans-serif;
		}
		.materias
		{
			font-size: 12px;
			text-align:justified;
			line-height: 130%;
			font-family: sans-serif;
		}
		.calificaciones
		{
			font-size: 12px;
			text-align: center;
			line-height: 130%;
			font-family: sans-serif;
		}
		.enletras
		{
			font-size: 10px;
			text-align: justify;
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
		</style>
		<table width="650" border="0">
			<tr>
				<td rowspan="2" width="10%">
					<img src="../{$_SESSION['ruta_foto_logo_subse']}" width="50" height="50">
				</td>
				<td class="titulo" width="80%">UNIDAD EDUCATIVA</td>
				<td rowspan="2" width="10%"></td>
			</tr>
			<tr>
				<td class="titulo">{$_SESSION['cliente']}</td>
			</tr>
		</table>
		<table>
			<tr>
				<td colspan="2" class="titulo">CERTIFICADO DE PROMOCIÓN</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">AÑO LECTIVO: {$anio_lectivo}</td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo">JORNADA MATUTINA</td>
			</tr>
			<tr>
				<td colspan="2"><br/></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					<p>De conformidad con lo escrito en el Art. 197 del Reglamento General a la Ley Orgánica 
					de Educación Intercultural y demás normativas vigentes, certifica que el(la) estudiante 
					<b>{$estudiante_nombres},</b> del {$estudiante_curso}, obtuvo las siguientes calificaciones 
					durante el presente periodo lectivo.</p>
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
				<td colspan="2"><br /></td>
			</tr>
			<tr>
				<td colspan="2" class="texto">
					<p>Por lo tanto es promovido(a) a <b>{$estudiante_curso_promovido}</b>.</p>
					<p>Para certificar suscriben en unidad de acto la Rectora con la Secretaria quien certifica.</p>
				</td>
			</tr>
			<tr>
				<td colspan="2"><br /></td>
			</tr>
			<tr>
				<td colspan="2" class="texto"><p>Guayaquil, {$fecha_hoy}</p></td>
			</tr>
			<tr>
			<td colspan="2"><br/><br/></td>
			</tr>
			<tr>
				<td align="center" class="firma">
					__________________________________<br/>
					{$rector}<br/>
					Rector(a)
				</td>
				<td align="center" class="firma">
					__________________________________<br/>
					{$secretario}<br/>
					Secretario(a)
				</td>
			</tr>
		</table>
EOF;
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	$pdf->Output('cert_promocion.pdf', 'I');
?>
