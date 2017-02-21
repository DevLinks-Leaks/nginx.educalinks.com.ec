<?php
session_start();
require_once('/../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../../../Framework/funciones.php');
//require_once('/../../includes/tcpdf/tcpdf.php');

function handler() {
  $solicitud = get_mainObject('Solicitud');
  $event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET, VIEW_SET_HOME), VIEW_GET_ALL);
  $user_data = get_frontData();
  //$permiso = get_mainObject('General');
  
	if (!isset($_POST['busq'])){ $user_data['busq'] = ""; }else{ $user_data['busq'] = $_POST['busq']; }
	if (!isset($_POST['tabla'])){ $tabla = "tbl_solicitud"; }else{ $tabla = $_POST['tabla']; }

    switch ($event)
	{   case VIEW_GET_ALL:
			if( empty( $user_data['soli_estado'] ) )
				$soli_estado = 'ENVIADA';
			else
				$soli_estado = $user_data['soli_estado'];
			$solicitud->get_solicitudes( $soli_estado );
            if(count($solicitud->rows)>0)
			{	$data['tabla'] = construct_table_solicitud( $tabla, $solicitud, $soli_estado );
                $data['mensaje'] = "Bandeja de solicitudes";
				$data['soli_estado'] = $soli_estado;
            }
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
			break;
		case GET_ALL:
			if( empty( $user_data['soli_estado'] ) )
				$soli_estado = 'ENVIADA';
			else
				$soli_estado = $user_data['soli_estado'];
			$solicitud->get_solicitudes( $soli_estado );
            if(count($solicitud->rows)>0)
			{	$data['tabla'] = construct_table_solicitud( $tabla, $solicitud, $soli_estado );
            }
			else
			{   $data = array('mensaje'=>$usuario->mensaje.$usuario->ErrorToString());
            }
            retornar_result( $data );
			break;
		case SET_ESTADO:
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_estado($user_data['soli_codi'],
																			$user_data['soli_estado'],
																			$user_data['soli_observacion'],
																			$_SERVER['HTTP_X_FORWARDED_FOR'],
																			$_SERVER['REMOTE_ADDR'] );
			$data = array("MENSAJE"=>$resultado_ingreso_solicitud->mensaje,
						  "ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "ESTADO"	=> $resultado_ingreso_solicitud->per_codi_out);
			echo json_encode( $data, true );
			break;
		case SET_FECHA_ASIGN:
			$resultado_ingreso_solicitud = $solicitud->set_solicitud_fecha( $user_data['soli_codi'], 
																			"",
																			$user_data['soli_fex_fecha_asignada'], 
																			$user_data['soli_fex_actividad'],
																			$_SERVER['HTTP_X_FORWARDED_FOR'],
																			$_SERVER['REMOTE_ADDR'],
																			$user_data['cambiar_estado'] );
			$data = array("MENSAJE"=>$resultado_ingreso_solicitud->mensaje,
						  "ID_SOLICITUD"=> $resultado_ingreso_solicitud->id_solicitud_out,
						  "ESTADO"	=> $resultado_ingreso_solicitud->per_codi_out);
			echo json_encode( $data, true );
			break;
		case FECHA_EXAMEN_VER:
			global $diccionario;
			$solicitud->solicitud_fecha_examen_ver( $user_data['soli_codi'] );
			if( ( count( $solicitud->rows )-1 )>0 )
			{	$lista= "<b>Fechas de exámenes/activiades asignadas</b><br><br>".
						"<div style='background-color:#e5e5e5;height:300px;overflow-y:scroll;'>";
				$c=1;
				$tabla = array ();
				foreach ($solicitud->rows as $row)
				{   if( !empty( $row ) )
					{   $quitar= "<td width='10%'><span style='color:red;cursor:pointer;' class='fa fa-times' id='quitar_".$row['soli_fex_codi']."' ".
									" name='quitar_".$row['soli_fex_codi']."' ".
									" title='Quitar fecha' onclick=\"js_verSolicitud_fecha_examen_borrar( '".$row['soli_codi']."', '".$row['soli_fex_codi']."','modal_asign_fecha_bandeja', '".$diccionario['rutas_head']['ruta_html']."/verSolicitud/controller.php');\"></span></td>";
						if ( $row['soli_fex_actividad'] == "") 
						{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row['soli_fex_fecha_asignada']."</td><td>-No hay detalles-</td>".$quitar;
						}
						else
						{	$tabla[]= "<td width='10%'>".$c.".</td><td>".$row['soli_fex_fecha_asignada']."</td><td> ".$row['soli_fex_actividad']."</td>".$quitar;
						}
						$c++;
					}
				}
				$lista.= genera_tabla_por_columnas($tabla, 1, 0)."</div>";
			    print $lista;
			}
			else
			{   $data= '<div class="callout callout-info">
							<h4><strong><li class="fa fa-exclamation"></li></strong></h4>
							-No se encontraron fechas de ex&aacute;menes/actividades asignadas para este postulantes en el sistema-.
						</div>';
			    print $data;
			}
			break;
		case FECHA_EXAMEN_BORRAR:
			global $diccionario;
			$resultado = $solicitud->solicitud_fecha_examen_borrar( $user_data['soli_codi'],
																	$user_data['soli_fex_codi'],
																	$_SERVER['HTTP_X_FORWARDED_FOR'],
																	$_SERVER['REMOTE_ADDR'] );
			echo $resultado->mensaje;
			break;
    }
}
handler();
/*	'GUARDADA'
	'ENVIADA' --BANDEJA LORENA --REVISA DOCUMENTOS, REVISA FORMULARIO. DOS OPCIONES: GENERAR DEUDA, DEVOLVER.
		'DEVUELTA'
	'PDTE. PAGO' --BANDEJA CAJERA -- MARCAR COMO PAGADO, DAR DE BAJA LA DEUDA PORQUE 'NO LE INTERESA'.
		'NO INTERESADO'
	'PAGADA' --BANDEJA LUPITA --ASIGNAR UNA FECHA DE EXAMEN. (MAS DE 1 DIA). --MOSTRAR LAS PAGADAS Y LOS 'EX. REPROBADOS'
	'FECHA ASIGNADA' -- BANDEJA LORENA, SUBE SINTESIS ESCANEADAS. DOS OPCIONES: APRB, REPR.
		'EX. REPROBADO' --CAMPO 'SOLI_NUM_SOLICITUD' AUMENTAR +1. SI ES 4 PONERLE, NO ADMITIDO.
		'NO ADMITIDO'
	'EX A.PROBADO' --BANDEJA DIRECTORES -- 2 OPCIONES: APROBAR, NO ADMITIDO
		no 'REPROBADO DIRECTORES'
		'NO ADMITIDO'
	'APROBADO DIRECTORES'  --BANDEJA CONSEJO -- 2 OPCIONES: ADMITIDO, NO ADMITIDO
		no 'REPROBADO CONSEJO'
		'NO ADMITIDO'
	'ADMITIDO' --BANDEJA LORENA -- ESTUDIANTES ADMITIDOS. REPORTES, FORMULARIOS, ETC.
*/
function construct_table_solicitud( $tabla, $solicitud, $soli_estado )
{	global $diccionario;
	$body= "<table id='".$tabla."' name='".$tabla."' class='display'>";
	/*  0 solicitud.soli_codi --
	  , 1 tbl_solicitud.per_codi
	  , 2 tbl_solicitud.peri_codi--
	  , 3 repr.per_id --
	  , 4 repr_nombre --
	  , 5 alum_nombre --
	  , 6 a.per_fecha_nac --
	  , 7 soli_num_por_per --
	  , 8 soli_curso_aplicado --
	  , 9 soli_fecha_ingr --
	  , 10 soli_estado--
	*/
	$body.= "<thead>".
				"<th style='text-align:center;font-size:small;'>Código solicitud</th>".
				//"<th style='text-align:center;font-size:small;'>Ref. persona</th>".
				//"<th style='text-align:center;font-size:small;'>Período</th>".
				//"<th style='text-align:center;font-size:small;'>Id. repr. académico</th>".
				"<th style='text-align:center;font-size:small;'>Repr. académico</th>".
				"<th style='text-align:center;font-size:small;'>Estudiante</th>".
				"<th style='text-align:center;font-size:small;'>F. Nacimiento</th>".
				//"<th style='text-align:center;font-size:small;'>Reprobado examen</th>".
				"<th style='text-align:center;font-size:small;'>Curso aplica</th>".
				"<th style='text-align:center;font-size:small;'>F. envío solicitud</th>".
				//"<th style='text-align:center;font-size:small;'>Estado</th>".
				"<th style='text-align:center;font-size:small;'>Opciones</th>".
			"</thead>";
	$body.="<tbody>";
	//o poner un if con varios TD dependiendo del estado.
	$c=0;
	$aux=0;
	foreach($solicitud->rows as $row)
	{	$aux++;
	}
	foreach($solicitud->rows as $row)
	{	if($c<($aux-1))
		{	$body.= "<tr>";
			$x = 0;
			$soli_codi = "";
			$alum_codi = "";
			$peri_codi = "";
			$id_repr_acad = "";
			$num_soli = "";
			$soli_estado = "";
			foreach($row as $column)
			{	if( $x == 0 ) $soli_codi = $column;
				if( $x == 1 ) $alum_codi = $column;
				if( $x == 2 ) $peri_codi = $column;
				if( $x == 3 ) $id_repr_acad = $column;
				if( $x == 7 ) $num_soli = $column;
				if( $x == 10 )$soli_estado = $column;
				if( ( $x == 0 ) )
				{   $body.="<td style='text-align:center;font-size:small;'>{".$column."}</td>";
				}
				if( ( $x != 0 ) && ( $x != 1 ) && ( $x != 2 ) && ( $x != 3 ) && ( $x != 7 ) && ( $x != 10 ) )
				{   $body.="<td style='text-align:center;font-size:small;'>".$column."</td>";
				}
				$x++;
			}
			$tt_table = "<div style=\"text-align:left\"><table>";
			$tt_table.= "<tr><td><b>Id. repr.:</b>&nbsp;</td><td>". $id_repr_acad."</td></tr>";
			$tt_table.= "<tr><td><b>No. veces reprobado:</b>&nbsp;</td><td>". $num_soli."</td></tr>";
			$tt_table.= "<tr><td><b>Estado solicitud:</b>&nbsp;</td><td>". $soli_estado."</td></tr>";
			$tt_table.= "</table></div>";
			$var_tooltip="<span class='detalle' id='".$soli_codi."_soli_tooltip' onmouseover='$(this).tooltip(".'"show"'.")' title='".$tt_table."' data-placement='bottom'>".
						$soli_codi."</span>";
			$body = str_replace( "{".$soli_codi."}", $var_tooltip, $body );
			$body.="<td style='text-align:center'>".get_solicitud_opciones( $soli_estado, $soli_codi, $alum_codi, $num_soli, $diccionario['rutas_head']['ruta_html'], 'span' )."</td>";
		}
		$body.="</tr>";
		$c++;
	}
	$body.="</tbody>";
	$body.="</table>";
	return $body;
}
function get_solicitud_opciones($estado, $soli_codi, $alum_codi, $num_soli, $ruta, $type='span')//Dependiendo del ESTADO, carga opciones.
{	if($type=='span')
	{	$tag=''; 
		$space='&nbsp;';
	}
	if($type=='button')
	{	$tag='button'; 
		$space='';
	}
	$opciones="";
	if( $estado == 'ENVIADA' || $estado == 'DEVUELTA' || $estado == 'NO INTERESADO')
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$codigoCliente."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripción'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"PDTE. PAGO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"DEVUELTA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'PDTE. PAGO' ) //OPCIONES: 1. PAGADA. 2. NO INTERESADO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"PAGADA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-usd cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Marcar como cobrado' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"NO INTERESADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='No está interesado en pagar' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'PAGADA' || $estado == 'EX. REPROBADO') //OPCIONES: 1. FECHA ASIGNADA
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_asignar_fecha(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"modal_asign_fecha"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.", 1)' class='fa fa-calendar-check-o cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Asignar fecha(s)'  data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"FECHA ASIGNADA"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Marcar como con fechas asignadas' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
	}
	if( $estado == 'FECHA ASIGNADA' ) //OPCIONES:  SUBIR SINTESIS. 1. EX. APROBADO. 2. EX. REPROBADO (ALT. (si ha repr. 2 veces) NO ADMITIDO.
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 1)' class='fa fa-upload cursorlink' aria-hidden='true'  id='".$codigoCliente."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Subir síntesis al sistema' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"EX. APROBADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobó exámenes' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		if( $num_soli < 2 ) $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"EX. REPROBADO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Reprobó exámenes' data-placement='left'>".$space."</".$type.">";
		else 				$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='No fue admitido' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'EX. APROBADO' ) //OPCIONES: 1. APROBADO DIRECTORES, 2. NO ADMITIDO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 0)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$codigoCliente."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver síntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"APROBADO DIRECTORES"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'APROBADO DIRECTORES' ) //OPCIONES: 1. ADMITIDO, 2. NO ADMITIDO
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 0)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$codigoCliente."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver síntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-check cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Aprobar solicitud' data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"NO ADMITIDO"'.",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:red' class='fa fa-times cursorlink' aria-hidden='true' id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Rechazar solicitud' data-placement='left'>".$space."</".$type.">";
	}
	if( $estado == 'ADMITIDO' ) //OPCIONES: REPORTES, FORMULARIOS, ETC.
	{   $opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_carga_formulario(\"".$soli_codi."\",\"".$alum_codi."\",\"resultado\",".'"'.$ruta.'/enviarSolicitud/controller.php"'.", 1 )' style='color:#F0AD4E;' class='fa fa-folder cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'  id='".$codigoCliente."_asignar' onmouseover='$(this).tooltip(".'"show"'.");' title='Formulario de preinscripción'  data-placement='left'>".$space."</".$type.">&nbsp;&nbsp;";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_subir_sintesis(\"".$soli_codi."\",\"".$num_soli."\",".'"modal_subir_archivo"'.",".'"'.$ruta.'/documentos_admision/controller.php"'.", 0)' class='fa fa-download cursorlink' aria-hidden='true'  id='".$codigoCliente."_subirSintesis' onmouseover='$(this).tooltip(".'"show"'.");' title='Ver síntesis del estudiante' data-placement='left'>".$space."</".$type.">";
		$opciones.= "<".$type." ".$tag." onclick='js_verSolicitud_procesar_mensaje(\"".$soli_codi."\",".'"resultado"'.",".'"'.$ruta.'/verSolicitud/controller.php"'.")' style='color:green' class='fa fa-group cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign_repr'  id='".$codigoCliente."_asignar_repr' onmouseover='$(this).tooltip(".'"show"'.");'  title='Reporte de familiares' data-placement='left'>".$space."</".$type.">";
	}
	return $opciones;
}
function genera_tabla_por_columnas($array_con_td, $num_columnas=2, $border=0, $width='100%', $align='center')
{	//Lo que hace esta función es 'construir' una tabla con 'X' columnas, dependiendo de la variable '$num_columnas', que por default es 2.
	//Si num_columnas es 2, devuelve una tabla con 2 columnas, etc.
	$aux = 0;
	$c = count($array_con_td);
	$body = "";
	$body.='<tr style="vertical-align:top;">';
	while ($aux < $c)
	{	$body.=  $array_con_td[$aux];
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) $body.='</tr><tr style="vertical-align:top;">';
	}
	$body.='</tr>';
	
	$table= "<table class='table table-bordered table-condensed table-responsive' style=\"table-layout: fixed;\" cellspacing='0' cellpadding='0' ".
			" width='".$width."' align='".$align."' border='".$border."'><tbody>";
	$table.= $body;
	$table.= "</tbody></table>";
	
	return $table;
}
?>