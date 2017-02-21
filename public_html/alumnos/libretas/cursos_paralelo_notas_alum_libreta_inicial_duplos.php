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
	private $foto;
	
	public function Header() 
	{	$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Fecha y hora: '.date('d-M-Y, H:i').', Impreso por '.$_SESSION['usua_codi'], 0, false, 'L', 0, '', 0, false, 'T', 'M');
		//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
/*Notas Indicadores, ámbitos, ejes*/
$params = array($alum_codi,$peri_dist_codi,'I');
$sql="{call alum_nota_peri_dist_view_TipoMateria(?,?,?)}";
$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
/*Notas Comportamiento*/
$params = array($alum_codi,$peri_dist_codi,'DI');
$sql="{call alum_nota_peri_dist_view_TipoMateria(?,?,?)}";
$alum_nota_peri_dist_comp_view = sqlsrv_query($conn, $sql, $params); 

/*Equivalencia Español*/
$tabla_inicial_esp = '<table width="95%" border="1" cellpadding="1" cellspacing="0">';
$tabla_inicial_esp.= '<tr>';
$tabla_inicial_esp.= '<td class="cabecera_notas centrar" colspan="2"><b>ESCALA CUALITATIVA DE APRENDIZAJES</b></td>';
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
/*Equivalencia Inglés*/
$tabla_inicial_eng = '<table width="100%" border="1" cellpadding="1" cellspacing="0">';
$tabla_inicial_eng.= '<tr>';
$tabla_inicial_eng.= '<td class="cabecera_notas centrar" colspan="2"><b>ESCALA CUALITATIVA COMPORTAMENTAL</b></td>';
$tabla_inicial_eng.= '</tr>';
$params = array(11);
$sql="{call nota_peri_cual_tipo_view_NEW(?)}";
$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);	
while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view))
{	$tabla_inicial_eng.= '<tr><td class="tabla_informativa" width="10%"> ('.
						$row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].')</td><td class="tabla_informativa" width="90%"> '.$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'].
						'</td></tr>';
}
$tabla_inicial_eng.='</table>';
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
	$tabla_inasistencias.='<td class="tabla_informativa" width="70%"> '.$faltas['falt_tipo_deta'].'</td>';
	$tabla_inasistencias.='<td class="tabla_informativa" width="30%"> '.$faltas['num_faltas'].'</td>';
	$tabla_inasistencias.='</tr>';
}
$tabla_inasistencias.='</table>';
/*Observaciones*/
$tabla_observaciones = '<table width="95%" border="1" cellpadding="1" cellspacing="0">';
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
/*Firmas*/
$tabla_firmas = '<table width="100%">';
$tabla_firmas.= '<tr>';
$tabla_firmas.= '<td class="firmas centrar">_______________________________<br/>Firma de Docente Tutor</td>';
$tabla_firmas.= '<td class="firmas centrar">_______________________________<br/>Firma de Representante</td>';
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
$asign_ancho = 100-(3*6);
/*Calificaciones*/
$calificaciones = '
<table width="100%" border="0.3" cellpadding="1" cellspacing="0">
  <tr>
	<td class="cabecera_notas" align="center" width="'.$asign_ancho.'%"></td>';
foreach ($_SESSION['equivalencias'] as $row_eq)
{   if ($row_eq['nota_refe_cab_tipo']=='I')
		$calificaciones.='<td class="cabecera_notas centrar" width="6%">'.$row_eq['nota_peri_cual_refe'].'</td>';
}
$calificaciones.='</tr>';
while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) 
{ 	$cc +=1;
	if ($row_alum_nota_peri_dist_view["nivel"]<=4) //Para que presente las materias desde nivel 4 hasta el 1
	{	if ($row_alum_nota_peri_dist_view["nivel"]<>4 || $row_alum_nota_peri_dist_view["nota_peri_cual_refe"]<>"") //Para que solo presente las de nivel 4 que tengan notas ingresadas
		{	$calificaciones.='<tr><td class="cuerpo_notas">';
			$sangria=($row_alum_nota_peri_dist_view["nivel"]-1)*5;
			$espacio='';
			for($ii=1;$ii<=$sangria;$ii++) $espacio.="&nbsp;";
			if ($row_alum_nota_peri_dist_view["nivel"]>1) 
				$calificaciones.= $espacio.$row_alum_nota_peri_dist_view['mate_deta'];
			else 
				$calificaciones.= ' <b>'.$espacio.$row_alum_nota_peri_dist_view['mate_deta'].'</b>';
			
			$calificaciones.='</td>';
			$CC_COLUM_index =0; 
			foreach ($_SESSION['equivalencias'] as $row_eq)
			{   if ($row_eq['nota_refe_cab_tipo']=='I')
				{	$calificaciones.='<td width="6%" class="cuerpo_notas centrar ';
					$calificaciones.= '">';
					switch ($row_alum_nota_peri_dist_view['mate_tipo'])
					{	case "I":
						if ($row_alum_nota_peri_dist_view['PM']==0 or $row_alum_nota_peri_dist_view["es_padre"])
							$calificaciones.= "";
						else
							if ($row_alum_nota_peri_dist_view['nota_peri_cual_refe']==$row_eq['nota_peri_cual_refe'])
								$calificaciones.="X";
						break;
						}
					$calificaciones.='</td>';
					$CC_COLUM_index+=1;
				}
			}
			$calificaciones.='</tr>';
		}
	}
}
$calificaciones.='</table>';

/*Matriz comportamental*/
$calificaciones_comp = '
<table width="100%" border="0.3" cellpadding="1" cellspacing="0">
  <tr>
	<td class="cabecera_notas" colspan="2" align="center" width="100%">MATRIZ COMPORTAMENTAL</td>';
	$calificaciones_comp.='</tr>';
while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_comp_view)) 
{ 	$cc +=1;
	if ($row_alum_nota_peri_dist_view["nivel"]<=4)
	{	$calificaciones_comp.='<tr><td width="94%" class="cuerpo_notas">';
		$sangria=($row_alum_nota_peri_dist_view["nivel"]-1)*5;
		$espacio='';
		for($ii=1;$ii<=$sangria;$ii++) $espacio.="&nbsp;";
		if ($row_alum_nota_peri_dist_view["nivel"]>1) 
			$calificaciones_comp.= $espacio.$row_alum_nota_peri_dist_view['mate_deta'];
		else 
			$calificaciones_comp.= ' <b>'.$espacio.$row_alum_nota_peri_dist_view['mate_deta'].'</b>';
		
		$calificaciones_comp.='</td>';
		$calificaciones_comp.='<td width="6%" class="cuerpo_notas centrar ';
		$calificaciones_comp.= '">';
		$calificaciones_comp.=$row_alum_nota_peri_dist_view['nota_peri_cual_refe'];
		$calificaciones_comp.='</td>';
	}
$calificaciones_comp.='</tr>';	
}
$calificaciones_comp.='</table>';
/*Foto del estudiante*/
$file_exi = '../'.$_SESSION['ruta_foto_alumno'].$alum_codi.'.jpg';
if (file_exists($file_exi))
{	$pp=$file_exi;
} 
else 
{	$pp='../../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
}
$pdf->setFoto($pp);
$pdf->setCodigo($row_alum_info['alum_codi']);
$pdf->setNombre($row_alum_info['alum_nomb']);
$pdf->setApellido($row_alum_info['alum_apel']);
$pdf->setPeriodo($cab_row['nivel_1']."  ".$cab_row['nivel_2']);
$pdf->setCurso($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"');


$logo_cole = '../'.$_SESSION['ruta_foto_logo_index'];

$cabecera = '<table border="0" width="100%">
				<tr>
					<td class="centrar_vertical_img_logo" rowspan="5" width="25%"><img height="70px" width="70px" src="'.$logo_cole.'" /></td>
					<td class="cabecera" width="60%">BOLETÍN DE CALIFICACIONES</td>
					<td class="centrar_vertical_img_foto" rowspan="4" width="15%"><img height="45px" width="45px" src="'.$pp.'" /></td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($cab_row['nivel_1']."  ".$cab_row['nivel_2'],'utf8').'</td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].' "'.$row_curs_info['para_deta'].'"','utf8').'</td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($row_alum_info['alum_apel']." ".$row_alum_info['alum_nomb'],'utf8').'</td>
				</tr>
				<tr>
					<td class="cabecera" width="60%">'.mb_strtoupper($_SESSION['peri_deta'],'utf8').'</td>
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
{	background-color: #2F4DA1;
	border: solid 0.3px #808080;
	color: #FFFFFF;
	font-family: sans-serif;
	font-size: 9px;
	font-weight: bold;
	line-height: 180%;
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
.leyenda
{	font-family: sans-serif;
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
{$cabecera}
<br/><br/>
{$calificaciones}
<br/><br/>
{$calificaciones_comp}
<br/><br/>
<table width="100%">
<tr>
<td width="60%">{$tabla_inicial_eng}<br/></td>
<td width="40%"> {$tabla_inicial_esp}</td>
</tr>
<tr>
<td width="45%">{$tabla_inasistencias}</td>
<td width="55%"> {$tabla_observaciones}<br/></td>
</tr>
<tr>
<td class="leyenda centrar" width="100%">Este es un documento informativo, no válido para trámites legales.</td>
</tr>
</table>
<br/>
<table width="50%">
<tr>
<td>{$tabla_contraseñas}</td>
</tr>
</table> 
<br/><br/><br/><br/><br/>
{$tabla_firmas}
EOF;
if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi'])  and !alum_tiene_deuda_vencida($_SESSION['alum_codi'],$_SESSION['peri_codi']))
	{
	$pdf->writeHTML($tbl, true, false, false, false, '');
	$pdf->Output($alum_codi.'.pdf', 'FI');
}
header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename='".$alum_codi.".pdf'");