﻿<?
require_once('../../../../framework/tcpdf/tcpdf.php');
/*Conexión a la BD*/
$serverName = "certuslinks.com";
$db = "Educalinks_moderna"; 
$uid = "sa";
$pwd = "R3dlink51981";
$charset = "UTF-8";
$connectionInfo = array("Database"=>$db, "UID"=>$uid, "PWD"=>$pwd, "CharacterSet"=>$charset);
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn)
{	echo "La conexión no se pudo establecer.<br/>";
	die( print_r( sqlsrv_errors(), true));
}

if (!function_exists('para_sist')) {
	function para_sist($para_sist_codi){
		$params = array($para_sist_codi);
		$sql="{call para_sist_info(?)}";
		$para_sist_info = sqlsrv_query($GLOBALS['conn'], $sql, $params);  
		$row_para_sist_info = sqlsrv_fetch_array($para_sist_info);
		return $row_para_sist_info['para_sist_valu'];
	}
}
if (!function_exists('notas_prom_quali')) {
	function notas_prom_quali($peri_codi,$mate_tipo,$prom){
		$params_permi = array($peri_codi,$mate_tipo,$prom);		
		$sql_permi="{call nota_peri_cual_prom_value(?,?,?)}";
		$nota_peri_cual_prom_value = sqlsrv_query($GLOBALS['conn'], $sql_permi, $params_permi); 
		$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);	 
		return $row_nota_peri_cual_prom_value['nota_peri_cual_refe'];
	}
}
if (!function_exists('truncar')) {
	function truncar($numero){
		return number_format(substr($numero,0,strpos($numero,".")+(para_sist(41)+1)),2);
	}
}
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
/*peri_codi*/
if(isset($_GET['peri_codi']))
	$peri_codi = $_GET['peri_codi'];

class MYPDF extends TCPDF 
{	private $codigo;
	private $nombre;
	private $apellido;
	private $curso;
	private $periodo;
	private $foto;
	
	public function Header() 
	{	$logo_cole = '../../../../imagenes/clientes/moderna/logo_inicial_long.png';
		$this->Image($logo_cole, 5, 12, 45, 12, 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
		$this->Image($this->foto, 185, 8, 16, 18, 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 7);
		$this->SetFont('helvetica', 'B', 7);
		$this->MultiCell(70, 10, '', 0, 'C', 0, 1, '', '', true);
		$this->MultiCell(70, 4, 'BOLETÍN DE CALIFICACIONES', 0, 'L', 0, 1, 55, '', true);
		$this->MultiCell(0, 4, mb_strtoupper($this->periodo,'utf8'), 0, 'L', 0, 1, 55, '', true);
		$this->MultiCell(0, 4, mb_strtoupper($this->curso,'utf8'), 0, 'L', 0, 1, 55, '', true);
		$this->MultiCell(0, 4, mb_strtoupper(substr($this->nombre.' '.$this->apellido,0,45),'utf8'), 0, 'L', 0, 1, 55, '', true);
		
		$this->SetFont('helvetica', 'B', 9);
		$this->MultiCell(0, 0, $this->codigo, 0, 'L', 0, 1, 185, 26, true);
	}
	public function Footer()
	{	$this->SetY(-15);
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 0, 'Fecha y hora: '.date('d-M-Y, H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->SetFont('helvetica', 'B', 8);
		$this->Cell(0, 0, 'CREADO DESDE LA APLICACIÓN MÓVIL "EDUCALINKS" ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
	public function setFoto($value)
	{	$this->foto=$value;
	}
}
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(5, 27, 5);
$pdf->SetAutoPageBreak(TRUE, 2);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
/*Foto del estudiante*/
$file_exi = '../../../../fotos/moderna/alumnos/'.$peri_codi.'/'.$alum_codi.'.jpg';
if (file_exists($file_exi))
{	$pp=$file_exi;
} 
else 
{	$pp='../../../../fotos/moderna/alumnos/0.jpg';
}
$pdf->setFoto($pp);
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

$params = array($alum_codi,$peri_dist_codi,'C');
$sql="{call alum_nota_peri_dist_view(?,?,?)}";
$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
$num_cols = $row_alum_nota_peri_dist_view['CC_COLUM'];
$CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
sqlsrv_next_result($alum_nota_peri_dist_view);
sqlsrv_next_result($alum_nota_peri_dist_view); 
/*Equivalencia Comportamiento*/
$tabla_comportamiento = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_comportamiento.= '<tr>';
$tabla_comportamiento.= '<td class="cabecera_notas centrar"><b>COMPORTAMIENTO</b></td>';
$tabla_comportamiento.= '</tr>';
$params = array('D', $peri_codi);
$sql="{call nota_peri_cual_tipo_view(?,?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_comportamiento.='<tr>';
	$tabla_comportamiento.='<td class="tabla_informativa"> ('.$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].'</td>';
	$tabla_comportamiento.='</tr>';
}
$tabla_comportamiento.='</table>';
/*Equivalencia Cuantitativa*/
$tabla_cuantitativa = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_cuantitativa.= '<tr>';
$tabla_cuantitativa.= '<td class="cabecera_notas centrar" colspan="3"><b>EQUIVALENCIAS CUALITATIVAS DEL APRENDIZAJE</b></td>';
$tabla_cuantitativa.= '</tr>';
$params = array('C', $peri_codi);
$sql="{call nota_peri_cual_tipo_view(?,?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_cuantitativa.= '<tr><td class="tabla_informativa" width="20%"> '.
						truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_ini']).' - '.
						truncar($row_nota_peri_cual_tipo_view['nota_peri_cual_fin']).'</td><td class="tabla_informativa" width="20%"> ('.
						$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</td><td class="tabla_informativa" width="60%"> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].
						'</td></tr>';
}
$tabla_cuantitativa.='</table>';
/*Faltas/Inasistencias*/
$tabla_inasistencias = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_inasistencias.= '<tr>';
$tabla_inasistencias.= '<td class="cabecera_notas centrar" colspan="2"><b>INASISTENCIAS Y ATRASOS</b></td>';
$tabla_inasistencias.= '</tr>';
$sql_falt="{call falt_grup_tipo_alum_view(?,?,?,?)}";
$params_falt = array($peri_codi, $peri_dist_codi,$curs_para_codi, $alum_codi);
$stmt_falt = sqlsrv_query($conn, $sql_falt, $params_falt);
if( $stmt_falt === false )
{	echo "Error in executing statement .\n";
	die( print_r( sqlsrv_errors(), true));
}
while ($faltas=sqlsrv_fetch_array($stmt_falt))
{	$tabla_inasistencias.='<tr>';
	$tabla_inasistencias.='<td class="tabla_informativa" width="70%"> '.$faltas['falt_tipo_deta'].'</td>';
	$tabla_inasistencias.='<td class="tabla_informativa" width="30%"> '.$faltas['num_faltas'].'</td>';
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
$tabla_observaciones.='<td class="tabla_informativa" height="49" rowspan="4"> '.$observaciones['nota_obse_deta'].'</td>';
$tabla_observaciones.='</tr>';
$tabla_observaciones.='</table>';
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
$asign_ancho = 100-($num_cols*6)-13-2;
/*Calificaciones*/
$calificaciones = '
<table width="100%" border="0.3" cellpadding="1" cellspacing="0">
  <tr>
	<td class="cabecera_notas" width="2%"></td>
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
{ 	$cc +=1;
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
				break;
				case "D":
				$calificaciones.= notas_prom_quali($peri_codi,'D',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
				break;
				case "P":
				$calificaciones.= notas_prom_quali($peri_codi,'P',$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]);
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
	$calificaciones.= (truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]))==0)?'':truncar(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]));
	$prom_rend=$prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index];
	$calificaciones.='</td>';
	$CC_COLUM_index+=1;
}
$calificaciones.='<td class="cuerpo_notas centrar">'.notas_prom_quali($peri_codi,'C',$prom_rend).'</td>';
$calificaciones.='</tr>';
$calificaciones.='</table>';

$pdf->setCodigo($row_alum_info['alum_codi']);
$pdf->setNombre($row_alum_info['alum_nomb']);
$pdf->setApellido($row_alum_info['alum_apel']);
$pdf->setPeriodo($cab_row['nivel_1']."  ".$cab_row['nivel_2']);
$pdf->setCurso($row_curs_info['curs_deta'].' DE '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');
$pdf->AddPage();
$tbl=<<<EOF
<style>
.cabecera_notas
{	background-color: #A6A6A6;
	border: solid 0.3px #808080;
	color: #C00000;
	font-family: sans-serif;
	font-size: 9px;
	font-weight: bold;
	height: 13px;
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
.firmas
{	font-family: sans-serif;
	font-size: 10px;
	line-height: 150%;
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
<br/><br/>
{$calificaciones}
<br/><br/>
<table width="99%">
<tr>
<td width="50%" rowspan="3">{$tabla_comportamiento}</td>
<td width="50%"> {$tabla_cuantitativa}<br/></td>
</tr>
<tr>
<td> {$tabla_observaciones}<br/></td>
</tr>
<tr>
<td> {$tabla_inasistencias}</td>
</tr>
</table>
<br/>
<table width="50%">
<tr>
<td>{$tabla_contraseñas}</td>
</tr>
</table> 
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Output($alum_codi.'.pdf', 'FI');
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='".$alum_codi.".pdf'");