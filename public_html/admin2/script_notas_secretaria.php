<?php
session_start();
/*Opción*/
if (isset($_POST["opc"]))
{	$opc = $_POST["opc"];
}
else
{	$opc = "";
}
/*Código de nota refe cod*/
if (isset($_POST['nota_refe_cab_codi']))
{	$nota_refe_cab_codi = $_POST['nota_refe_cab_codi'];
}
else
{	$nota_refe_cab_codi = 0;
}
/*Tipo de materia (tipo de calificación)*/
if (isset($_POST['nota_refe_cab_tipo']))
{	$nota_refe_cab_tipo = $_POST['nota_refe_cab_tipo'];
}
else
{	$nota_refe_cab_tipo = "";
}
/*Periodo distribución*/
if (isset($_POST['peri_dist_codi']))
{	$peri_dist_codi = $_POST['peri_dist_codi'];
}
else
{	$peri_dist_codi = 0;
}
/*Alumno curso paralelo materia*/
if (isset($_POST['alum_curs_para_mate_codi']))
{	$alum_curs_para_mate_codi = $_POST['alum_curs_para_mate_codi'];
}
else
{	$alum_curs_para_mate_codi = 0;
}
/*Encargado de mapear el requerimiento solicitado*/
switch ($opc)
{	case 'consNotas':
		consNotas($alum_curs_para_mate_codi,$peri_dist_codi,$nota_refe_cab_codi,$nota_refe_cab_tipo);
	break;
	case 'saveNotas':
		saveNotas();
	break;
	default:
		echo "No existe esa opción";
	break;
}
function consNotas ($alum_curs_para_mate_codi_in, $peri_dist_codi_in, $nota_refe_cab_codi_in, $nota_refe_cab_tipo_in)
{	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	$sql 	= "{call alum_curs_para_mate_nota_view(?,?,?)}";
	$params	= array($nota_refe_cab_codi_in,$alum_curs_para_mate_codi_in,$peri_dist_codi_in);
	$stmt_notas	= sqlsrv_query($conn,$sql,$params,array("scrollable"=>SQLSRV_CURSOR_KEYSET));
	if( $stmt_notas === false )
	{	echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	} 
	//Número de ingresos
	$num_inputs=sqlsrv_num_rows($stmt_notas)-1;
	echo "<input id='num_inputs' type='hidden' value='".$num_inputs."' />";
	$td = "";
	$th = "";
	/*En caso de materias cualitativas*/
	if ($nota_refe_cab_tipo_in!='C')
	{	$nota_cual = array();
		$sql	= "{call nota_peri_cual_view(?,?)}";
		$params	= array($_SESSION['peri_codi'],$nota_refe_cab_codi_in);
		$stmt	= sqlsrv_query($conn,$sql,$params);
		while ($notas_cual[]=sqlsrv_fetch_array($stmt));
	}
	/*Fin*/
	$i=1;
	while ($row = sqlsrv_fetch_array($stmt_notas))
	{	$th.= "<th>".$row["peri_dist_abre"]."</th>";
		switch ($nota_refe_cab_tipo_in)
		{	case 'C':
			$td.= "<td>";
			/*Diver bug correción temporal*/
			if($row["nota"]==='.0000')
				$row["nota"]='0.0000';
			/*FIN*/
			if ($row["peri_dist_nota_tipo"]=="IN")
				$td.="<input class='cls_validar' onchange='TEXTVALI(this,".($row["nota"]==''?0:$row["nota"]).",".peri_nota_max($_SESSION['peri_codi']).")' id='n_".$i."' data-peri_dist_abre='".$row["peri_dist_abre"]."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."' type='text' value='".($row["nota"]==''?0:$row["nota"])."' style='width:50px'/>";
			else
				$td.=$row["nota"];
			
			$td.= "</td>";
			break;
			case 'D':
			$td.= "<td>";
			if ($row["peri_dist_nota_tipo"]=="IN")
			{	$td.= "<select id='n_".$i."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."'>";
				foreach ($notas_cual as $key=>$value)
				{	if ($value["nota_peri_cual_refe"]!='')
						$td.= "<option value='".$value["nota_peri_cual_fin"]."' ".(substr($row["nota"],0,-2)==$value["nota_peri_cual_fin"]?'selected':'').">".$value["nota_peri_cual_refe"]."</option>";
				}
				$td.= "</select>";
			}
			else
			{	/*Convertir a letra*/
				$td.=nota_peri_cual_cons($_SESSION['peri_codi'],$nota_refe_cab_codi_in,$row["nota"]);
			}
			$td.="</td>";
			break;
			case 'P':
			$td.= "<td>";
			if ($row["peri_dist_nota_tipo"]=="IN")
			{	$td.= "<select id='n_".$i."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."'>";
				foreach ($notas_cual as $key=>$value)
				{	if ($value["nota_peri_cual_refe"]!='')
						$td.= "<option value='".$value["nota_peri_cual_fin"]."' ".(substr($row["nota"],0,-2)==$value["nota_peri_cual_fin"]?'selected':'').">".$value["nota_peri_cual_refe"]."</option>";
				}
				$td.= "</select>";
			}
			else
			{	/*Convertir a letra*/
				$td.=nota_peri_cual_cons($_SESSION['peri_codi'],$nota_refe_cab_codi_in,$row["nota"]);
			}
			$td.="</td>";
			break;
			case 'I':
			$td.= "<td>";
			if ($row["peri_dist_nota_tipo"]=="IN")
			{	$td.= "<select id='n_".$i."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."'>";
				foreach ($notas_cual as $key=>$value)
				{	if ($value["nota_peri_cual_refe"]!='')
						$td.= "<option value='".$value["nota_peri_cual_fin"]."' ".(substr($row["nota"],0,-2)==$value["nota_peri_cual_fin"]?'selected':'').">".$value["nota_peri_cual_refe"]."</option>";
				}
				$td.= "</select>";
			}
			else
			{	/*Convertir a letra*/
				$td.=nota_peri_cual_cons($_SESSION['peri_codi'],$nota_refe_cab_codi_in,$row["nota"]);
			}
			$td.="</td>";
			break;
			case 'IP':
			$td.= "<td>";
			if ($row["peri_dist_nota_tipo"]=="IN")
			{	$td.= "<select id='n_".$i."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."'>";
				foreach ($notas_cual as $key=>$value)
				{	if ($value["nota_peri_cual_refe"]!='')
						$td.= "<option value='".$value["nota_peri_cual_fin"]."' ".(substr($row["nota"],0,-2)==$value["nota_peri_cual_fin"]?'selected':'').">".$value["nota_peri_cual_refe"]."</option>";
				}
				$td.= "</select>";
			}
			else
			{	/*Convertir a letra*/
				$td.=nota_peri_cual_cons($_SESSION['peri_codi'],$nota_refe_cab_codi_in,$row["nota"]);
			}
			$td.="</td>";
			break;
			case 'DI':
			$td.= "<td>";
			if ($row["peri_dist_nota_tipo"]=="IN")
			{	$td.= "<select id='n_".$i."' data-peri_dist_codi_in='".$row["peri_dist_codi_in"]."'>";
				foreach ($notas_cual as $key=>$value)
				{	if ($value["nota_peri_cual_refe"]!='')
						$td.= "<option value='".$value["nota_peri_cual_fin"]."' ".($row["nota"]==$value["nota_peri_cual_fin"]?'selected':'').">".$value["nota_peri_cual_refe"]."</option>";
				}
				$td.= "</select>";
			}
			else
			{	/*Convertir a letra*/
				$td.=nota_peri_cual_cons($_SESSION['peri_codi'],$nota_refe_cab_codi_in,$row["nota"]);
			}
			$td.="</td>";
			break;
		}
		$i++;
	}
	print "<table class='table_striped' style='width:550px'>";
	print "<thead>";
	print "<tr>";
	print $th;
	print "<tr>";
	print "</thead>";
	print "<tbody>";
	print "<tr>";
	print $td;
	print "<tr>";
	print "</tbody>";
	print "</table>";
}
function saveNotas()
{	include ('../framework/dbconf.php');
include ('../framework/funciones.php');
	$num_inputs = $_POST['num_inputs'];
	$xml = new DOMDocument('1.0','UTF-8');
	$alumno = $xml->createElement('alumno');
	$alumno->setAttribute('acpm',$_POST['alum_curs_para_mate_codi']);
	$alumno->setAttribute('pm',$_POST['peri_dist_codi']);
	$alumno->setAttribute('mp',($_POST['mate_padr']==-1?0:$_POST['mate_padr']));
	$alumno->setAttribute('u',$_SESSION['usua_codi']);
	for ($i=1;$i<=$num_inputs;$i++)
	{	$nota = $xml->createElement('nota');
		$nota->setAttribute('n',(trim($_POST['n_'.$i])==''?0:$_POST['n_'.$i]));
		$nota->setAttribute('p',$_POST['p_'.$i]);
		$alumno->appendChild($nota);
	}
	$xml->appendChild($alumno);
	/*Ingreso de notas*/
	$sql 	= "{call notas_xml_add_v2_mejorada_secr(?)}";
	$params	= array($xml->saveXML());
	$stmt	= sqlsrv_query($conn,$sql,$params);
	if ($stmt === false)
	{	 if(($errors = sqlsrv_errors())!= null)
		{	foreach ($errors as $error)
			{	$error_deta = "SQLSTATE: ".$error['SQLSTATE'];
				$error_deta.= " Código: ".$error['code'];
				$error_deta.= " Mensaje: ".$error['message'];
			}
			$result = array ("error"=>"si","mensaje"=>$error_deta);
		}
	}
	else
	{	

		$detalle="Código Alumno: ".$_POST['alum_codi'];
		$detalle.=" Curso: ".$_POST['curs_deta'];
		$detalle.=" Paralelo: ".$_POST['para_deta'];
		$detalle.=" Asignatura: ".$_POST['mate_deta'];
		$detalle.=" Parcial: ".$_POST['peri_dist_deta'];
		$detalle.=" Nota: ";
		for ($i=1;$i<=$_POST['num_inputs'];$i++)
		{
			
			if($_POST['a_'.$i]=='null')
				$detalle.=$_POST['n_'.$i]." ";
			else
				$detalle.=$_POST['a_'.$i].": ".$_POST['n_'.$i]." ";
		}
		registrar_auditoria (57, $detalle);

		$row = sqlsrv_fetch_array($stmt);
		$result = array ("error"=>"no","mensaje"=>"¡Ingreso exitoso!");
	}
	echo json_encode($result);
}
?>