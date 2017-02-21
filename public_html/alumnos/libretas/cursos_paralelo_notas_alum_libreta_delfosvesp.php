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
if(isset($_GET['curs_para_codi']))
	$curs_para_codi = $_GET['curs_para_codi'];
else
	$curs_para_codi = 0;
/*alum_codi*/
if(isset($_GET['alum_codi']))
	$alum_codi = $_GET['alum_codi'];
else
	$alum_codi = 0;

class MYPDF extends TCPDF 
{	private $codigo;
	private $nombre;
	private $apellido;
	private $curso;
	private $periodo;
	private $jornada;
	public function Header() 
	{	$logo_cole = '../../'.$_SESSION['ruta_foto_logo_libreta'];
		$this->Image($logo_cole, 130, 10, 52, 18, 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 8);
		$this->MultiCell(70, 10, '', 0, 'C', 0, 1, '', '', true);
		$this->MultiCell(70, 5, 'BOLETÍN DE CALIFICACIONES', 0, 'L', 0, 1, '', '', true);
		$this->MultiCell(0, 5, mb_strtoupper($this->periodo,'utf8'), 0, 'L', 0, 1, '', '', true);
		$this->MultiCell(0, 5, mb_strtoupper($this->curso,'utf8'), 0, 'L', 0, 1, '', '', true);
		$this->MultiCell(0, 5, 'AÑO LECTIVO '.$_SESSION['peri_deta'], 0, 'L', 0, 1, '', '', true);
		$this->SetFont('helvetica', 'B', 8);
		$this->MultiCell(0, 0, 'JORNADA: '.mb_strtoupper($this->jornada), 0, 'L', 0, 1, 230, 10, true);
		$this->SetFont('helvetica', '', 8);
		$this->MultiCell(0, 0, mb_strtoupper(substr($this->nombre.' '.$this->apellido,0,45),'utf8'), 0, 'L', 0, 1, 230, 17, true);
		$this->MultiCell(0, 0, $this->codigo, 0, 'L', 0, 1, 230, 22, true);
	}
	public function Footer()
	{	$this->SetY(-15);
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y, H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 10, 'Impreso por '.$_SESSION['usua_codi'], 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	public function setCodigo($value)
	{	$this->codigo=$value;
	}
	public function setNombre($value)
	{	$this->nombre=$value;
	}
	public function setApellido($value)
	{	$this->apellido=$value;
	}
	public function setCurso($value)
	{	$this->curso=$value;
	}
	public function setPeriodo($value)
	{	$this->periodo=$value;
	}
	public function setJornada($value)
	{	$this->jornada=$value;
	}
}
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(5, 27, 5);
$pdf->SetAutoPageBreak(TRUE, 2);
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
/*Alumnos*/
$params = array($alum_codi);
$sql="{call alum_info(?)}";
$alum_info = sqlsrv_query($conn, $sql, $params);
$row_alum_info = sqlsrv_fetch_array($alum_info);
/*Representante principal*/
$sql = "{call repr_info_vida(?,?)}";
$params = array($alum_codi, "R");
$stmt = sqlsrv_query($conn, $sql, $params);
$repr_info =sqlsrv_fetch_array($stmt);
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
/*Misión*/
$tabla_mision = '<table width="100%" border="1" cellpadding="3" cellspacing="0">';
$tabla_mision.= '<tr>';
$tabla_mision.= '<td class="cabecera_notas centrar"><b>MISIÓN</b></td>';
$tabla_mision.= '</tr>';
$tabla_mision.= '<tr>';
$tabla_mision.= '<td class="cuerpo_notas">Formar con valores éticos y morales en cada una de las áreas del conocimiento. Integrando a niños, jóvenes con habilidades múltiples y necesidades educativas para alcanzar un verdadero desarrollo; comprometidos con la mejora continua, buscando la excelencia institucional.</td>';
$tabla_mision.= '</tr>';
$tabla_mision.= '</table>';
/*Visión*/
$tabla_vision = '<table width="100%" border="1" cellpadding="3" cellspacing="0">';
$tabla_vision.= '<tr>';
$tabla_vision.= '<td class="cabecera_notas centrar"><b>VISIÓN</b></td>';
$tabla_vision.= '</tr>';
$tabla_vision.= '<tr>';
$tabla_vision.= '<td class="cuerpo_notas">Ser una de las mejores unidades educativas de la ciudad de Guayaquil, entregando a la sociedad jóvenes capaces de enfrentar los desafíos del mundo actual. </td>';
$tabla_vision.= '</tr>';
$tabla_vision.= '</table>';
/*Valores*/
$tabla_valores = '<table width="100%" border="1" cellpadding="3" cellspacing="0">';
$tabla_valores.= '<tr>';
$tabla_valores.= '<td class="cabecera_notas centrar"><b>VALORES</b></td>';
$tabla_valores.= '</tr>';
$tabla_valores.= '<tr>';
$tabla_valores.= '<td class="cuerpo_notas">Respeto, Solidaridad, Lealtad, Honestidad, Responsabilidad: Puntualidad y Constancia. </td>';
$tabla_valores.= '</tr>';
$tabla_valores.= '</table>';
/*Equivalencia Comportamiento*/
$tabla_comportamiento = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_comportamiento.= '<tr>';
$tabla_comportamiento.= '<td class="cabecera_notas centrar"><b>EQUIVALENCIA COMPORTAMIENTO</b></td>';
$tabla_comportamiento.= '</tr>';
$params = array('D', $_SESSION['peri_codi']);
$sql="{call nota_peri_cual_tipo_view(?,?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_comportamiento.='<tr>';
	$tabla_comportamiento.='<td class="cuerpo_notas"> ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</td>';
	$tabla_comportamiento.='</tr>';
}
$tabla_comportamiento.='</table>';
/*Equivalencia Cuantitativa*/
$tabla_cuantitativa = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_cuantitativa.= '<tr>';
$tabla_cuantitativa.= '<td class="cabecera_notas centrar" colspan="3"><b>EQUIVALENCIAS CUALITATIVAS DEL APRENDIZAJE</b></td>';
$tabla_cuantitativa.= '</tr>';
$params = array('C', $_SESSION['peri_codi']);
$sql="{call nota_peri_cual_tipo_view(?,?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_cuantitativa.= '<tr><td class="cuerpo_notas" width="20%"> '.
						truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_ini']).' - '.
						truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_fin']).'</td><td class="cuerpo_notas" width="20%"> ('.
						$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</td><td class="cuerpo_notas" width="60%"> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].
						'</td></tr>';
}
$tabla_cuantitativa.='<tr class="cuerpo_notas" colspan="3"> * Calificación menor al mínimo requerido.</tr>';
$tabla_cuantitativa.='</table>';
/*Equivalencia de Proyectos*/
if ($row_curs_info['curs_orden']==11 || $row_curs_info['curs_orden']==12 || $row_curs_info['curs_orden']==13)
{	$params = array('P', $_SESSION['peri_codi']);
	$tabla_proyecto = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
	$tabla_proyecto.= '<tr>';
	$tabla_proyecto.= '<td class="cabecera_notas centrar"><b>EQUIVALENCIA PROYECTOS</b></td>';
	$tabla_proyecto.= '</tr>';
	$sql="{call nota_peri_cual_tipo_view(?,?)}";
	$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
	while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
	{	$tabla_proyecto.='<tr>';
		$tabla_proyecto.='<td class="cuerpo_notas"> ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</td>';
		$tabla_proyecto.='</tr>';
	}
	$tabla_proyecto.='</table>';
}
/*Faltas/Inasistencias*/
$tabla_inasistencias = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_inasistencias.= '<tr>';
$tabla_inasistencias.= '<td class="cabecera_notas centrar" colspan="2"><b>INASISTENCIAS Y ATRASOS</b></td>';
$tabla_inasistencias.= '</tr>';
$sql_falt="{call falt_grup_tipo_alum_view(?,?,?,?)}";
$params_falt = array($_SESSION['peri_codi'], $peri_dist_codi,$curs_para_codi, $alum_codi);
$stmt_falt = sqlsrv_query($conn, $sql_falt, $params_falt);
if( $stmt_falt === false )
{	echo "Error in executing statement .\n";
	die( print_r( sqlsrv_errors(), true));
}
while ($faltas=sqlsrv_fetch_array($stmt_falt))
{	$tabla_inasistencias.='<tr>';
	$tabla_inasistencias.='<td class="cuerpo_notas" width="70%"> '.$faltas['falt_tipo_deta'].'</td>';
	$tabla_inasistencias.='<td class="cuerpo_notas" width="30%"> '.$faltas['num_faltas'].'</td>';
	$tabla_inasistencias.='</tr>';
}
$tabla_inasistencias.='</table>';
/*Observaciones*/
$tabla_observaciones = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_observaciones.= '<tr>';
$tabla_observaciones.= '<td class="cabecera_notas centrar"><b>OBSERVACIONES</b></td>';
$tabla_observaciones.= '</tr>';
$sql_obs="{call nota_obse_view(?,?)}";
$params_obs = array($alum_codi, $peri_dist_codi);
$stmt_obs = sqlsrv_query($conn, $sql_obs, $params_obs);
if( $stmt_obs === false )
{	echo "Error in executing statement .\n";
	die( print_r( sqlsrv_errors(), true));
}
$observaciones=sqlsrv_fetch_array($stmt_obs);
$tabla_observaciones.='<tr>';
$tabla_observaciones.='<td class="cuerpo_notas" height="58" rowspan="4"> '.$observaciones['nota_obse_deta'].'</td>';
$tabla_observaciones.='</tr>';
$tabla_observaciones.='</table>';
/*Firmas*/
$tabla_firmas = '<table>';
$tabla_firmas.= '<tr>';
$tabla_firmas.= '<td class="firmas centrar"><img width="100" height="50" src="../../'.$_SESSION["ruta_foto_firma"].'" /></td>';
$tabla_firmas.= '<td class="firmas centrar"></td>';
$tabla_firmas.= '</tr>';
$tabla_firmas.= '<tr>';
$tabla_firmas.= '<td class="firmas centrar">________________________________<br/>'.para_sist(5).'<br/>'.para_sist(33).'</td>';
$tabla_firmas.= '<td class="firmas centrar">________________________________<br/>Tutor(a)</td>';
$tabla_firmas.= '</tr>';
$tabla_firmas.= '</table>';
/*Contraseñas*/
if (para_sist(7))
{	$tabla_contraseñas = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
	$tabla_contraseñas.= '<tr>';
	$tabla_contraseñas.= '<td class="cabecera_notas centrar"><b>ALUMNO</b></td>';
	$tabla_contraseñas.= '<td class="cabecera_notas centrar"><b>REPRESENTANTE</b></td>';
	$tabla_contraseñas.= '</tr>';
	$tabla_contraseñas.='<tr>';
	$tabla_contraseñas.='<td class="cuerpo_notas"> <b>Usuario:</b> '.$row_alum_info['alum_usua'].' - <b>Clave:</b> '.$row_alum_info['alum_pass'].'</td>';
	$tabla_contraseñas.='<td class="cuerpo_notas"> <b>Usuario:</b> '.$repr_info['usuario'].' - <b>Clave:</b> '.$repr_info['clave'].'</td>';
	$tabla_contraseñas.='</tr>';
	$tabla_contraseñas.='</table>';
}
/*Ancho de asignaturas*/
$asign_ancho = 100-($num_cols*6)-13;
/*Calificaciones*/
$calificaciones = '
<table width="100%" border="1" cellpadding="1" cellspacing="0">
  <tr>
	<td class="cabecera_notas" align="center" width="'.$asign_ancho.'%">ASIGNATURAS</td>';
$cabecera = array();
while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
{   $calificaciones.='<td class="cabecera_notas centrar" width="6%">'.$row_peri_dist_padr_view['peri_dist_abre'].'</td>';
	if( $row_peri_dist_padr_view['peri_dist_nota_tipo'] == 'VW' )
	{   $cabecera[] = str_replace('%', '', $row_peri_dist_padr_view['peri_dist_abre'] );
	}else
	{	$cabecera[] = 100;
	}
}
$calificaciones.='<td class="cabecera_notas centrar" width="6%">CUAL.</td>';
$calificaciones.='</tr>';
while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) 
{ 
	$cc +=1;
	if (!($row_alum_nota_peri_dist_view["mate_padr"]>0 and $row_alum_nota_peri_dist_view["mate_tipo"]=='P'))
	{	$calificaciones.='<tr><td class="cuerpo_notas">';
		if ($row_alum_nota_peri_dist_view["mate_padr"] >0)
			$calificaciones.='   ';
			if ($row_alum_nota_peri_dist_view["mate_padr"]>0)
			{	$calificaciones.= ucwords(mb_strtolower($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8'));
			}
			else
			{	$calificaciones.= ' '.mb_strtoupper($row_alum_nota_peri_dist_view['mate_deta'],'UTF-8');
			} 
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
			if ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0 and $row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<>null)
			{	switch ($row_alum_nota_peri_dist_view['mate_tipo'])
				{	case "C":
					$calificaciones.= (truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12])==0)?'':truncar($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
					if(($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]>0) and ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]<$mayor_aceptable))
					{	$calificaciones.= '*';
					}
					break;
					case "D":
					$calificaciones.= notas_prom_quali($_SESSION['peri_codi'],'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
					break;
					case "P":
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
		$calificaciones.='<td class="cuerpo_notas centrar" width="6%">'.$row_alum_nota_peri_dist_view['nota_peri_cual_refe'].'</td>';
		$calificaciones.='</tr>';
	}
}
/*Promedios en columna*/
/*
$calificaciones.='<tr>';
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
	$calificaciones.= (truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]))==0)?'':truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]));
	$prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index];
	$calificaciones.='</td>';
	$CC_COLUM_index+=1;
}
$calificaciones.='<td class="cuerpo_notas centrar">'.notas_prom_quali($_SESSION['peri_codi'],'C',$prom_rend).'</td>';
$calificaciones.='</tr>';*/
$calificaciones.='</table>';

$pdf->setCodigo($row_alum_info['alum_codi']);
$pdf->setNombre($row_alum_info['alum_nomb']);
$pdf->setApellido($row_alum_info['alum_apel']);
$pdf->setPeriodo($cab_row['nivel_1']."  ".$cab_row['nivel_2']);
$pdf->setCurso($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');
$pdf->setJornada(para_sist(35));
$pdf->AddPage();
$tbl=<<<EOF
<style>
.cabecera_notas
{	background-color: #D0E6F2;
	border: solid 4px black;
	color: #015C87;
	font-family: sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.centrar
{	text-align: center;
}
.cuerpo_notas
{	border: solid 0.5px black;
	font-family: sans-serif;
	font-size: 10px;
}
.firmas
{	font-family: sans-serif;
	font-size: 10px;
	line-height: 150%;
}
.mala_nota
{	color: #FF0000;
}
</style>
<br/><br/>
{$calificaciones}
<br/><br/>
<table width="99%">
<tr>
<td width="45%">{$tabla_mision}</td>
<td width="35%"> {$tabla_vision}</td>
<td width="20%"> {$tabla_valores}</td>
</tr>
</table>
<br/><br/>
<table width="99%">
<tr>
<td width="20%">{$tabla_comportamiento}</td>
<td width="60%"> {$tabla_cuantitativa}</td>
<td width="20%"> {$tabla_proyecto}</td>
</tr>
</table>
<br/><br/>
<table width="99%">
<tr>
<td width="25%">{$tabla_inasistencias}</td>
<td width="25%"> {$tabla_observaciones}</td>
<td width="49%"> {$tabla_firmas}</td>
</tr>
</table> 
<table width="50%">
<tr>
<td>{$tabla_contraseñas}</td>
</tr>
</table> 
EOF;
if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi'])  and !alum_tiene_deuda_vencida($_SESSION['alum_codi'],$_SESSION['peri_codi']))
	{
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output($alum_codi.'.pdf', 'FI');
}
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='".$alum_codi.".pdf'");