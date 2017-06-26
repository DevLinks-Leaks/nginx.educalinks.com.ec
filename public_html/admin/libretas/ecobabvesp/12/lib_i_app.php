<?	
require_once('../../../../framework/tcpdf/tcpdf.php');
/*Conexión a la BD*/
$serverName = "certuslinks.com";
$db = "Educalinks_ecobabvesp"; 
$uid = "sa";
$pwd = "$3cur!ty@@";
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
	{	$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y, H:i'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
                $this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'CREADO DESDE LA APLICACIÓN MÓVIL "EDUCALINKS" ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	public function Footer()
	{	
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
$pdf->SetMargins(15, 10, 5);
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
$params = array($peri_dist_codi, 'I');
$sql="{call peri_dist_padr_libr_view_NEW(?,?)}";
$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
$params = array($alum_codi,$peri_dist_codi,'I');
$sql="{call alum_nota_peri_dist_view_NEW(?,?,?)}";
$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
$num_cols = $row_alum_nota_peri_dist_view['CC_COLUM'];
$CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
sqlsrv_next_result($alum_nota_peri_dist_view);
sqlsrv_next_result($alum_nota_peri_dist_view); 

/*Equivalencia Español*/
$tabla_inicial_esp = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_inicial_esp.= '<tr>';
$tabla_inicial_esp.= '<td class="cabecera_notas centrar" colspan="2"><b>EQUIVALENCIAS CUALITATIVAS</b></td>';
$tabla_inicial_esp.= '</tr>';
$params = array(9);
$sql="{call nota_peri_cual_tipo_view_NEW(?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_inicial_esp.= '<tr><td class="tabla_informativa" width="20%"> ('.
						$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</td><td class="tabla_informativa" width="80%"> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].
						'</td></tr>';
}
$tabla_inicial_esp.='</table>';
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
/*Firmas*/
$tabla_firmas = '<table width="100%">';
$tabla_firmas.= '<tr>';
$tabla_firmas.= '<td class="firmas centrar" width="33%">_______________________________<br/>'.para_sist(5).'<br/>'.para_sist(33).'</td>';
$tabla_firmas.= '<td class="firmas centrar" width="33%">_______________________________<br/>Tutor(a)</td>';
$tabla_firmas.= '<td class="firmas centrar" width="33%">_______________________________<br/>Representante</td>';
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
$asign_ancho = 100-($num_cols*6);
/*Calificaciones*/
$calificaciones = '
<table width="100%" border="0.3" cellpadding="1" cellspacing="0">
  <tr>
	<td class="cabecera_notas" align="center" width="'.$asign_ancho.'%">INDICADORES ESENCIALES</td>';
$cabecera = array();
while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view)) 
{   $calificaciones.='<td class="cabecera_notas centrar" width="6%">'.$row_peri_dist_padr_view['peri_dist_abre'].'</td>';
}
$calificaciones.='</tr>';
while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) 
{ 	$cc +=1;
	$calificaciones.='<tr><td class="cuerpo_notas">';
	$sangria=($row_alum_nota_peri_dist_view["nivel"]-1)*5;
	$espacio='';
	for($ii=1;$ii<=$sangria;$ii++) $espacio.="&nbsp;";
	if ($row_alum_nota_peri_dist_view["nivel"]>1) 
		$calificaciones.= $espacio.$row_alum_nota_peri_dist_view['mate_deta'];
	else 
		$calificaciones.= ' <b>'.$espacio.$row_alum_nota_peri_dist_view['mate_deta'].'</b>';
	
    $calificaciones.='</td>';
    $CC_COLUM_index =0; 
	while($CC_COLUM_index < $CC_COLUM )  
	{   $calificaciones.='<td width="6%" class="cuerpo_notas centrar ';
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
				case "I":
				$calificaciones.=  ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]==0 or $row_alum_nota_peri_dist_view["es_padre"])?
                 '':notas_prom_quali($peri_codi, 
				 						$row_alum_nota_peri_dist_view['mate_tipo'], 
										$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]); 
				break;
				case "E":
				$calificaciones.=  ($row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]==0 or $row_alum_nota_peri_dist_view["es_padre"])?
                 '':notas_prom_quali($peri_codi, 
				 						$row_alum_nota_peri_dist_view['mate_tipo'], 
										$row_alum_nota_peri_dist_view[$CC_COLUM_index + 12]); 
				break;
			}
		}
        $calificaciones.='</td>';
        $CC_COLUM_index+=1;
	}
	$calificaciones.='</tr>';
}
$calificaciones.='</table>';
/*Foto del estudiante*/
$file_exi = '../../../../fotos/ecobabvesp/alumnos/'.$peri_codi.'/'.$alum_codi.'.jpg';
if (file_exists($file_exi))
{	$pp=$file_exi;
} 
else 
{	$pp='../../../../fotos/ecobabvesp/alumnos/0.jpg';
}
$pdf->setFoto($pp);
$pdf->setCodigo($row_alum_info['alum_codi']);
$pdf->setNombre($row_alum_info['alum_nomb']);
$pdf->setApellido($row_alum_info['alum_apel']);
$pdf->setPeriodo($cab_row['nivel_1']."  ".$cab_row['nivel_2']);
$pdf->setCurso($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');


$cabecera = '<table border="0" width="100%">
				<tr>
					<td class="centrar_vertical_img_logo" rowspan="5" width="25%"><img height="50px" width="130px" src="'.$logo_cole.'" /></td>
					<td class="cabecera" width="60%">LIBRETA DE INFORMACIÓN DEL DESARROLLO INTEGRAL DEL NIÑO(A)</td>
					<td class="centrar_vertical_img_foto" rowspan="4" width="15%"><img height="45px" width="45px" src="'.$pp.'" /></td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($cab_row['nivel_1'],'utf8').'</td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"','utf8').'</td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($row_alum_info['alum_apel']." ".$row_alum_info['alum_nomb'],'utf8').'</td>
				</tr>
				<tr>
					<td></td>
					<td class="cabecera centrar" width="15%">'.$row_alum_info['alum_codi'].'</td>
				</tr>
			</table>';

$pdf->AddPage();
$tbl=<<<EOF
<style>
.cabecera
{	color: black;
	font-family: sans-serif;
	font-size: 10px;
	font-weight: bold;
	line-height: 150%;
}
.cabecera_notas
{	background-color: #409E2C;
	border: solid 0.3px #808080;
	color: #FFFFFF;
	font-family: sans-serif;
	font-size: 9px;
	font-weight: bold;
	height: 13px;
}
.centrar
{	text-align: center;
}
.centrar_vertical_img_foto
{	text-align: center;
	line-height: 400%;
}
.centrar_vertical_img_logo
{	text-align: center;
	line-height: 500%;
}
.cuerpo_notas
{	border: solid 0.1px #DEDEDE;
	font-family: sans-serif;
	font-size: 9px;
	line-height: 170%;
	padding-left: 5px;
}
.firmas
{	font-family: sans-serif;
	font-size: 9px;
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
{$cabecera}
<br/><br/>
{$calificaciones}
<br/><br/>
<table>
<tr>
	<td width="25%">{$tabla_inicial_esp}</td>
	<td width="50%"> {$tabla_observaciones}</td>
	<td width="25%"> {$tabla_inasistencias}</td>
</tr>
</table>
<br><br>
<table>
<tr>
	<td width="100%"><br><br>{$tabla_firmas}</td>
</tr>
</table>
EOF;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Output($alum_codi.'.pdf', 'FI');
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='".$alum_codi.".pdf'");