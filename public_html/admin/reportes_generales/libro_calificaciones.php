<?
require_once('../../framework/tcpdf/tcpdf.php');
require_once('../../framework/dbconf.php'); 
require_once('../../framework/funciones.php');
session_start();
/*Variables GET*/
/*peri_dist_codi*/
if(isset($_GET['peri_dist_codi']))
	$peri_dist_codi = $_GET['peri_dist_codi'];
else
	$peri_dist_codi = 0;
/*curs_para_codi*/
if(isset($_GET['curso_paralelo']))
	$curs_para_codi = $_GET['curso_paralelo'];
else
	$curs_para_codi = 0;
/*alum_codi*/
if(isset($_GET['alumno']))
	$alum_curs_para_codi = $_GET['alumno'];
else
	$alum_curs_para_codi = 0;

$rector = para_sist(5);
$secretario = para_sist(6);
$etiqueta_rector = para_sist(33);
$etiqueta_secretario = para_sist(34);
$ciudad = para_sist(31);
$jornada = para_sist(35);
$nombre_colegio = para_sist(3);
$antes_del_nombre = para_sist(36);

class MYPDF extends TCPDF 
{		
	public function Header() 
	{	
		// $logo_cole = '../'.$_SESSION['ruta_foto_logo_web'];
		// $this->Image($logo_cole, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		// $logo_escudo = '../'.$_SESSION['ruta_foto_escudo_ecuador'];
		// $this->Image($logo_escudo, 180, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}
	public function Footer()
	{	
		// $this->SetY(-15);
		// $this->SetFont('helvetica', 'I', 8);
		// $this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y, H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		// $this->Cell(0, 10, 'Impreso por '.$_SESSION['usua_codi'], 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator($_SESSION['cliente']);
$pdf->SetAuthor($_SESSION['cliente']);
$pdf->SetTitle($_SESSION['cliente']);
$pdf->SetSubject($_SESSION['cliente']);
$pdf->SetMargins(PDF_MARGIN_LEFT, 4, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

/*Consultas a la BD*/
/*Quimestre y Parcial*/
$params = array($peri_dist_codi);
$sql="{call peri_dist_peri_codi (?)}";
$cab_view = sqlsrv_query($conn, $sql, $params);  
$cab_row=sqlsrv_fetch_array($cab_view);
/*Información del curso*/
$params = array($curs_para_codi);
$sql="{call curs_para_info(?)}";
$curs_info = sqlsrv_query($conn, $sql, $params);
$row_curs_info = sqlsrv_fetch_array($curs_info);
/*Aumnos*/
$params = array($curs_para_codi,$alum_curs_para_codi,$peri_dist_codi);
$sql ="{call libro_calificacion(?,?,?)}";
$libro_calificaciones = sqlsrv_query($conn, $sql, $params); 
while ($alumno = sqlsrv_fetch_array($libro_calificaciones))
{	$alum_codi=$alumno['alum_codi'];
			unset($prom);
			unset($prom_cc);
			/*Foto*/
			/*Alumno*/
			$params = array($alum_codi);
			$sql="{call alum_info(?)}";
			$alum_info = sqlsrv_query($conn, $sql, $params);
			$row_alum_info = sqlsrv_fetch_array($alum_info);
			/*Notas*/
			$params = array($peri_dist_codi, 'C');
			$sql="{call peri_dist_padr_libr_view(?,?)}";
			$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
			$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
			$params = array($alum_codi,$peri_dist_codi,'C');
			$sql="{call alum_nota_peri_dist_view(?,?,?)}";
			$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
			$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
			$num_cols = $row_alum_nota_peri_dist_view['CC_COLUM'];
			$CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
			sqlsrv_next_result($alum_nota_peri_dist_view);
			sqlsrv_next_result($alum_nota_peri_dist_view); 
			
			/*Ancho de asignaturas*/
			$asign_ancho = 100-($num_cols*6)-13-2;
			/*Calificaciones*/
			$calificaciones = '
			<table width="100%" border="0.3" cellpadding="1" cellspacing="0">
			  <tr>
				<td rowspan="2" class="cabecera_notas" width="2%"></td>
				<td rowspan="2" class="cabecera_notas" align="center" width="'.$asign_ancho.'%">ASIGNATURAS</td>
				<td colspan="8" class="cabecera_notas" align="center" width="48%">PROMEDIO DE APROBACIÓN</td></tr><tr>';
			$cabecera = array();
			while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
			{   $calificaciones.='<td class="cabecera_notas centrar" width="6%">'.$row_peri_dist_padr_view['peri_dist_abre'].'</td>';
				if( $row_peri_dist_padr_view['peri_dist_nota_tipo'] == 'VW' )
				{   $cabecera[] = str_replace('%', '', $row_peri_dist_padr_view['peri_dist_abre'] );
				}else
				{	$cabecera[] = 100;
				}
			}
			// $calificaciones.='<td class="cabecera_notas centrar" width="6%">CUAL.</td>';
			$calificaciones.='</tr>';
			$conteo_prom=0;
			while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) 
			{ 	
				if($row_alum_nota_peri_dist_view["mate_padr"] ==-1){
					$cc +=1;
					if($row_alum_nota_peri_dist_view['mate_tipo']!='D'){
						$calificaciones.='<tr><td class="cuerpo_notas centrar">';
						if ($row_alum_nota_peri_dist_view["mate_prom"] =='A')
							$calificaciones.='*';
						$calificaciones.='</td>';
						$calificaciones.='<td class="cuerpo_notas">';
						if ($row_alum_nota_peri_dist_view["mate_padr"] >0)
							$calificaciones.='   ';
							if ($row_alum_nota_peri_dist_view["mate_padr"]>0)
							{	$calificaciones.= ucwords(mb_strtolower($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8'));
							}
							else
							{	$calificaciones.= ' '.mb_strtoupper($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8');
							}
						if ($row_alum_nota_peri_dist_view['mate_tipo']!='C')
							$conteo_prom+=1;
						$calificaciones.='</td>';
						$CC_COLUM_index =0; 
						while($CC_COLUM_index <= $CC_COLUM )  
						{   $calificaciones.='<td width="6%" class="cuerpo_notas centrar ';
							if ($row_alum_nota_peri_dist_view['mate_tipo']=='C')
							{	$perc = (int)$cabecera[ $CC_COLUM_index ];
								$mayor_aceptable = ( ( 7 * $perc ) / 100 );
								if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
								{   $calificaciones.= ' mala_nota';
								}
							}
							$calificaciones.= '">';
							if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>=0 and $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<>null)
							{	switch ($row_alum_nota_peri_dist_view['mate_tipo'])
								{	case "C":
									
									$calificaciones.= (truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])<=0)?'':truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
									case "D":
									if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0)
									$calificaciones.= notas_prom_quali($_SESSION['peri_codi'],'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
									case "P":
									if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0)
									$calificaciones.= notas_prom_quali($_SESSION['peri_codi'],'P',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
								}
							}
									
							if ($row_alum_nota_peri_dist_view["mate_prom"] =='A')
							{	$prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1; 
								$prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
							 }
							$calificaciones.='</td>';
							$CC_COLUM_index+=1;
						}
						// $calificaciones.='<td class="cuerpo_notas centrar" width="6%">'.$row_alum_nota_peri_dist_view['nota_peri_cual_refe'].'</td>';
						$calificaciones.='</tr>';
					}else{
						$materia_comportamiento='<tr><td class="cuerpo_notas centrar">';
						if ($row_alum_nota_peri_dist_view["mate_prom"] =='A')
							$materia_comportamiento.='*';
						$materia_comportamiento.='</td>';
						$materia_comportamiento.='<td class="cuerpo_notas">';
						if ($row_alum_nota_peri_dist_view["mate_padr"] >0)
							$materia_comportamiento.='   ';
							if ($row_alum_nota_peri_dist_view["mate_padr"]>0)
							{	$materia_comportamiento.= ucwords(mb_strtolower($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8'));
							}
							else
							{	$materia_comportamiento.= ' '.mb_strtoupper($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8');
							} 
						$materia_comportamiento.='</td>';
						$CC_COLUM_index =0; 
						while($CC_COLUM_index <= $CC_COLUM )  
						{   $materia_comportamiento.='<td width="6%" class="cuerpo_notas centrar ';
							if ($row_alum_nota_peri_dist_view['mate_tipo']=='C')
							{	$perc = (int)$cabecera[ $CC_COLUM_index ];
								$mayor_aceptable = ( ( 7 * $perc ) / 100 );
								if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
								{   $materia_comportamiento.= ' mala_nota';
								}
							}
							$materia_comportamiento.= '">';
							if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>=0 and $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<>null)
							{	switch ($row_alum_nota_peri_dist_view['mate_tipo'])
								{	case "C":
									
									$materia_comportamiento.= (truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])<=0)?'':truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
									case "D":
									if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0)
									$materia_comportamiento.= notas_prom_quali($_SESSION['peri_codi'],'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
									case "P":
									if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0)
									$materia_comportamiento.= notas_prom_quali($_SESSION['peri_codi'],'P',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
									break;
								}
							}
									
							
							$materia_comportamiento.='</td>';
							$CC_COLUM_index+=1;
						}
						// $materia_comportamiento.='<td class="cuerpo_notas centrar" width="6%">'.$row_alum_nota_peri_dist_view['nota_peri_cual_refe'].'</td>';
						$materia_comportamiento.='</tr>';
					}
				}
			}
			/*Promedios en columna*/
			$calificaciones.='<tr><td class="cuerpo_notas"></td>';
			$calificaciones.='<td class="cuerpo_notas"> <b>PROMEDIO</b></td>';
			$CC_COLUM_index =0; 
			while($CC_COLUM_index <= $CC_COLUM )  
			{	$calificaciones.='<td class="cuerpo_notas centrar';
				$perc = (int)$cabecera[ $CC_COLUM_index ];
				$mayor_aceptable = ( ( 7 * $perc ) / 100 );
				if( ( $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12] ) < $mayor_aceptable )
				{   $calificaciones.=' mala_nota_escuela_liceopanamericano';
				}
				$calificaciones.='">';
				if($CC_COLUM_index== $CC_COLUM)
					$calificaciones.= (truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]))<0)?'':truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]));
				$prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index];
				$calificaciones.='</td>';
				$CC_COLUM_index+=1;
			}
			// $calificaciones.='<td class="cuerpo_notas centrar">'.notas_prom_quali($_SESSION['peri_codi'],'C',$prom_rend).'</td>';
			$calificaciones.='</tr>';
			/*comportamiento*/
			$calificaciones.=$materia_comportamiento;
			/**/
			$calificaciones.='</table>';

			// $pdf->setCodigo($row_alum_info['alum_codi']);
			// $pdf->setNombre($row_alum_info['alum_nomb']);
			// $pdf->setApellido($row_alum_info['alum_apel']);
			// $pdf->setCurso($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');
			$pdf->AddPage();
			$tbl=<<<EOF
			<style>
			.titulo
			{
				letter-spacing: 2px;
				text-align: center;
				font-size: 16px;
				font-weight: bold;
				font-family: sans-serif;
			}
			.subtitulo
			{
				text-align: center;
				font-size: 14px;
				font-family: sans-serif;
			}
			.detalle
			{
				text-align: left;
				font-size: 12px;
				font-family: sans-serif;
			}
			.texto
			{
				font-size: 16px;
				text-align:justified;
				letter-spacing: 2px;
				line-height: 200%;
				font-family: sans-serif;
			}
			.cabecera_notas
			{	
				border: solid 0.3px #808080;
				
				font-family: sans-serif;
				font-size: 9px;
				font-weight: bold;
			}
			.centrar
			{	text-align: center;
			}
			.cuerpo_notas
			{	border: solid 0.5px #808080;
				font-family: sans-serif;
				font-size: 9px;
				line-height: 180%;
			}
			.mala_nota
			{	color: #FF0000;
			}
			.tabla_informativa
			{	border: solid 0.5px #808080;
				font-family: sans-serif;
				font-size: 8px;
			}
			</style>
			<table width="650" border="0">
			<tr>
				<td colspan="2" class="titulo">{$antes_del_nombre}</td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">{$nombre_colegio}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="subtitulo"><b>AÑO LECTIVO:</b> {$alumno["peri_deta"]}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2" class="titulo">LIBRO DE CALIFICACIONES</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td width="10%" class="detalle"><b>Curso:</b> </td><td  width="90%" class="detalle">{$alumno["curs_deta"]} DE {$alumno["nive_deta"]}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td  width="10%" class="detalle"><b>Paralelo:</b></td><td width="90%" class="detalle"> {$alumno["para_deta"]}</td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td  width="10%" class="detalle"><b>Alumno:</b></td><td width="90%" class="detalle"> {$alumno["alum_apel"]} {$alumno["alum_nomb"]} </td>
			</tr>
			<tr>
				<td colspan="2"><BR/></td>
			</tr>
			<tr>
				<td colspan="2">{$calificaciones}</td>
			</tr>
		</table>
EOF;
			$pdf->writeHTML($tbl, true, false, false, false, '');
		//}
	
}
$pdf->Output($row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta'].'.pdf', 'I');
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='".$row_curs_info['curs_deta'].' - '.$row_curs_info['para_deta'].".pdf'");