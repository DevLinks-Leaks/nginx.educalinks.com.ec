<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../../common/general/model.php');
require_once('constants.php');
require_once('../../common/persona/model.php');
require_once('/../../common/catalogo/model.php');
//require_once('/../colegio/model.php'); //Referencia, para cuando se expanda 'Persona' para las diferentes subclases (empleado y alumno).
require_once('/../../common/profesion/model.php');
require_once('/../../common/Region/model.php');
require_once('/../../common/area/model.php');
require_once('/../../common/departamento/model.php');
require_once('/../../common/cargo/model.php');
require_once('/../../common/representantes/model.php');
require_once('/../../common/elemento_protex/model.php');
require_once('view.php');
require_once('../../../Framework/funciones.php');

function handler()
{   $event 			= get_actualEvents(array(VIEW_GET_ALL, VIEW_SET, VIEW_SET_HOME, VIEW_FORMULARIO_PER, VIEW_DATOS_LABORALES), VIEW_GET_ALL);
    $user_data 		= get_frontData();
    //$permiso 		= get_mainObject('General'); //Referencia, para cuando se expanda 'Persona' para las diferentes subclases (empleado y alumno).
	//$cursos 		= get_mainObject('Catalogo'); //Referencia, para cuando se expanda 'Persona' para las diferentes subclases (empleado y alumno).
	$profesion 		= get_mainObject('Profesion');
	$pais 			= get_mainObject('Region');
	$provincia 		= get_mainObject('Region');
	$ciudad 		= get_mainObject('Region');
	//$colegio		= get_mainObject('Colegio'); //Referencia, para cuando se expanda 'Persona' para las diferentes subclases (empleado y alumno).
	$estado_civil	= get_mainObject('Catalogo');
	$parentesco		= get_mainObject('Catalogo');
	$persona		= get_mainObject('Persona');
	
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "cliente_table";}else{$tabla =$_POST['tabla'];}
	
    switch ($event)
	{   case GET_CLIENTE_INFO_ADICIONAL:
            # Consulta los datos del titular de facturacion de un cliente especifico
            $persona->get_infoAdicionalCliente( $user_data['codigoCliente'], $_SESSION['peri_codi'], $user_data['tipo_persona']);
            array_pop($persona->rows);
            echo json_encode($persona->rows);
            break;
		case FORMULARIO_PER:
			$data = constructor_formulario_per( $user_data['procedencia_formulario'], $data, $user_data['perX'], 'per', $user_data['tipo_persona'] );
			retornar_formulario( VIEW_FORMULARIO_PER, $data );
			break;
		/* 	------------------------------------------------
			SETEAR REGISTROS ADICIONALES
			------------------------------------------------
		*/
		case SET_DATOS_LABORALES:
			$resultado = $persona->set_datos_laborales($user_data['per_codi'], $user_data['per_empr_codi'], $user_data['per_per_empr_codi'],
														$user_data['per_empr_nomb'], $user_data['per_empr_ruc'], $user_data['per_empr_dir'],
														$user_data['per_empr_cargo'], $user_data['per_empr_telf'], $user_data['per_empr_mail'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		case SET_ACT_EXTRALABORALES:
			if ( !empty( $user_data['per_act_ext_detalle'] ) )
			{   $resultado = $persona->set_actividad_extra($user_data['per_act_ext_codi'], $user_data['per_codi'], $user_data['per_act_ext_detalle'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe ingresar el nombre de la actividad.";
			}
			echo json_encode($data, true);
			break;
		case SET_PROTEX_ESP:
			if ( !empty( $user_data['ele_protex_codi'] ) )
			{   $resultado = $persona->set_ele_protex( $user_data['per_codi'], $user_data['ele_protex_codi'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar un elemento de protección.";
			}
			echo json_encode($data, true);
			break;
		case SET_ANT_RIE_LAB:
			if ( !empty( $user_data['per_inst_codi'] ) )
			{   $resultado = $persona->set_rie_laborales( 	$user_data['inst_risk_codi'], $user_data['per_inst_codi'], $user_data['inst_risk_fisico'], 
															$user_data['inst_risk_fisicomec'], $user_data['inst_risk_quimico'], 
															$user_data['inst_risk_biologico'], $user_data['inst_risk_disergon'], $user_data['inst_risk_psicosocial'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar algún lugar donde previamente haya trabajado.";
			}
			echo json_encode($data, true);
			break;
		case SET_ANT_ACC_LAB:
			if ( !empty( $user_data['per_inst_codi'] ) )
			{   $resultado = $persona->set_acc_laborales(	$user_data['inst_acc_codi'], $user_data['per_inst_codi'], $user_data['inst_acc_fecha'], $user_data['inst_acc_causa'], 
															$user_data['inst_acc_tipo_lesion'], $user_data['inst_acc_parte_afectada'], $user_data['inst_acc_incapacidad'], 
															$user_data['inst_acc_secuelas'], $_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar algún lugar donde previamente haya trabajado.";
			}
			echo json_encode($data, true);
			break;
		/* 	------------------------------------------------
			BORRA REGISTROS ADICIONALES
			------------------------------------------------
		*/
		case ERASE_ACT_EXTRALABORALES:
			$resultado = $persona->del_actividad_extra($user_data['per_act_ext_codi'], $user_data['per_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		case ERASE_PROTEX_ESP:
			$resultado = $persona->del_ele_protex($user_data['per_ele_protex_codi'], $user_data['per_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		case ERASE_DATOS_LABORALES:
			$resultado = $persona->del_datos_laborales($user_data['per_inst_codi'], $user_data['per_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		case ERASE_ANT_RIE_LAB:
			$resultado = $persona->del_rie_laborales($user_data['inst_risk_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		case ERASE_ANT_ACC_LAB:
			$resultado = $persona->del_acc_laborales($user_data['inst_acc_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	------------------------------------------------
			CARGA TABLAS
			------------------------------------------------
		*/
		case CONS_ACT_EXTRALABORALES:
			if ( !empty( $user_data['per_codi'] ) )
			{   $act_ext = new Persona();
				$act_ext->get_actividad_extra( $user_data['per_codi'] );
				$opciones["Editar"] = "<span onclick='js_persona_add_act_ext(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";
				$opciones["Eliminar"] = "<span onclick='js_persona_del_act_ext(\"".$user_data['div_show_result']."\",\"".$user_data['per_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_act_ext}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_act_ext",
															"name"		=> $user_data['perX']."_tbl_act_ext",
															"datos"     => $act_ext->rows,
															"encabezado"=> array("Referencia",
																				  "Actividad",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "per_act_ext_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case CONS_PROTEX_ESP:
			if ( !empty( $user_data['per_codi'] ) )
			{   $ele_protex = new Persona();
				$ele_protex->get_ele_protex( $user_data['per_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_persona_del_ele_protex(\"".$user_data['div_show_result']."\",\"".$user_data['per_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_ele_protex}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_ele_protex",
															"name"		=> $user_data['perX']."_tbl_ele_protex",
															"datos"     => $ele_protex->rows,
															"encabezado"=> array("Referencia",
																				  "Elemento de protecci&oacute;n",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "per_ele_protex_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case CONS_DATOS_LABORALES:
			if ( !empty( $user_data['per_codi'] ) )
			{   $datos_lab = new Persona();
				$datos_lab->get_datos_laborales( $user_data['per_codi'] );
				/*$opciones["Editar"] = "<span onclick='js_persona_add_act_ext(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
				$opciones["Eliminar"] = "<span onclick='js_persona_del_datos_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['per_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_datos_laborales}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_datos_laborales",
															"name"		=> $user_data['perX']."_tbl_datos_laborales",
															"datos"     => $datos_lab->rows,
															"encabezado"=> array("Referencia",
																				  "Nombre empresa",
																				  "RUC",
																				  "Cargo",
																				  "Telf.",
																				  "Mail",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "per_inst_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case CONS_ANT_RIE_LAB:
			if ( !empty( $user_data['per_codi'] ) )
			{   $rie_lab = new Persona();
				$rie_lab->get_rie_laborales( $user_data['per_codi'] );
				/*$opciones["Editar"] = "<span onclick='js_persona_add_rie_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
				$opciones["Eliminar"] = "<span onclick='js_persona_del_rie_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['per_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_rie_laborales}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_rie_laborales",
															"name"		=> $user_data['perX']."_tbl_rie_laborales",
															"datos"     => $rie_lab->rows,
															"encabezado"=> array("Referencia",
																				 "Nombre instituci&oacute;n",
																				 "F&iacute;sico",
																				 "Fisicomec&aacute;nico",
																				 "Qu&iacute;mico",
																				 "Biol&oacute;gico",
																				 "Disergon&oacute;mico",
																				 "Psicosocial",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "inst_risk_codi");
			}
							   
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case CONS_ANT_ACC_LAB:
			if ( !empty( $user_data['per_codi'] ) )
			{   $acc_lab = new Persona();
				$acc_lab->get_acc_laborales( $user_data['per_codi'] );
				/*$opciones["Editar"] = "<span onclick='js_persona_add_acc_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
				$opciones["Eliminar"] = "<span onclick='js_persona_del_acc_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['per_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_acc_laborales}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_acc_laborales",
															"name"		=> $user_data['perX']."_tbl_acc_laborales",
															"datos"     => $acc_lab->rows,
															"encabezado"=> array("Referencia",
																				  "Nombre empresa",
																				  "Fecha siniestro",
																				  "Causa",
																				  "Tipo lesión",
																				  "Parte afectada",
																				  "Incapacidad",
																				  "Secuelas",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "inst_acc_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		/* 	------------------------------------------------
			MOSTRAR VISTA DE MODALES
			------------------------------------------------
		*/
		case VIEW_DATOS_LABORALES:
			$data = constructor_datos_laborales_per($data, $user_data['perX'], 'per', $empr_codi, $per_empr_codi, $empr_nomb , 
													$empr_ruc, $empr_dir, $empr_cargo, $empr_telf, $empr_mail, 
													$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR'] );
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['per_codi'] = $user_data['per_codi'];
			$data['div_show_result'] = $user_data['div_show_result'];
			retornar_formulario( VIEW_DATOS_LABORALES, $data );
			break;
		case VIEW_ACT_EXTRALABORALES:
			if( trim($user_data['per_act_ext_codi']) != "" )
			{   $act_ext = new Persona();
				$act_ext->get_actividad_extra( $user_data['per_codi'], $user_data['per_act_ext_codi'] );
				if($act_ext->rows >0)
				{   foreach ($act_ext->rows as $act_ext_row )
					{	if( !empty( $act_ext_row ) )
						{   $data = constructor_act_ext_per( $data, $user_data['perX'], 'per', $user_data['per_codi'], $act_ext_row['per_act_ext_detalle']);
						}
					}
				}
			}
			else
			{   $data = constructor_act_ext_per( $data, $user_data['perX'], 'per' );
			}
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['per_codi'] = $user_data['per_codi'];
			$data['per_act_ext_codi'] = $user_data['per_act_ext_codi'];
			retornar_formulario( VIEW_ACT_EXTRALABORALES, $data );
			break;
		case VIEW_PROTEX_ESP:
			$data = constructor_protex_esp_per( $data, $user_data['perX'], 'per' );
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['per_codi'] = $user_data['per_codi'];
			retornar_formulario( VIEW_PROTEX_ESP, $data );
			break;
		case VIEW_DEBT_BANCARIO:
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			retornar_formulario( VIEW_DEBT_BANCARIO, $data );
			break;
		case VIEW_ANT_RIE_LAB:
			$data = constructor_rie_laborales( $data, $user_data['perX'], 'per', $user_data['per_codi']  );
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['inst_risk_codi'] = $user_data['inst_risk_codi'];
			$data['per_codi'] = $user_data['per_codi'];
			retornar_formulario( VIEW_ANT_RIE_LAB, $data );
			break;
		case VIEW_ANT_ACC_LAB:
			$data = constructor_acc_laborales( $data, $user_data['perX'], 'per', $user_data['per_codi'] );
			
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['inst_acc_codi'] = $user_data['inst_acc_codi'];
			$data['per_codi'] = $user_data['per_codi'];
			retornar_formulario( VIEW_ANT_ACC_LAB, $data );
			break;
		case GET_PER_ESPECIFICO:
			global $diccionario;
			$persona->get_persona( $user_data['per_codi'], $user_data['tipo_persona'] );
			if( ( count( $persona->rows )-1 )>0 )
			{	$data = sub_constructor_formulario_per_load( $user_data['procedencia_formulario'], $user_data['tipo_persona'], $persona, '0', $data, $user_data['perX'], 'per' );
				retornar_formulario( VIEW_FORMULARIO_PER, $data );
			}
			else
			{   echo "No se encontraron resultados";
			}
			break;
		case GET_PER_ESPECIFICO_2:
			global $diccionario;
			$persona->get_persona_mini( $user_data['per_codi'], $user_data['tipo_persona'] );
			if( ( count( $persona->rows )-1 )>0 )
			{	if ( !empty( $persona->rows[0] ) )
				{   $data["MENSAJE"] 	= $persona->mensaje;
					$data["per_codi"] 	= $persona->rows[0]['per_codi'];
					$data["cedula"] 	= $persona->rows[0]['cedula'];
					$data["nombre"] 	= $persona->rows[0]['nombre'];
					$data["dir"] 		= $persona->rows[0]['dir'];
					$data["telf"] 		= $persona->rows[0]['telf'];
					if( $user_data['tipo_persona'] == 1 )
						$data["curso"] = $persona->rows[0]['curso'];
					else
						$data["curso"] = "";
				}
				else
				{   $data["MENSAJE"] = "¡Error! No se encontraron resultados";
				}
			}
			else
			{   echo "¡Error! No se encontraron resultados";
			}
			echo json_encode($data, true);
			break;
		case SET_PER_ESPECIFICO:
			if ( !empty( $user_data[ $user_data['perX'].'_numero_identificacion'] ) )
			{   $resultado = set_persona( $user_data, $user_data['perX'] );
				$data["MENSAJE"] = $resultado->mensaje;
				$data["PER_CODI"] = $resultado->per_codi_out;
				$data["EMPL_CODI"] = $resultado->empl_codi_out;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe ingresar un número de identificación.";
			}
			echo json_encode($data, true);
			break;
		case VIEW_GET_PERSON:
            # Modal de búsqueda (busqueda) de la persona
            $data["{tablaPersona}"] = array("elemento"  => "tabla",
											"clase" 	=> "table table-striped table-bordered",
											"id"		=> "persona_table",
											"datos"     => array(),
											"encabezado"=> array("Codigo",
																  "Identificacion",
																  "Nombres"),
											"options"   => array(),
											"campo"  	=> "");
			$data['div_buttons'] = $user_data['div_buttons'];
			$data['procedencia_formulario'] = $user_data['procedencia_formulario'];
			$data['div_show_result'] = $user_data['div_show_result'];
            retornar_formulario( VIEW_GET_PERSON, $data );
            break;
		case VIEW_GET_PERSON_2:
            $data["{tablaPersona}"] = array("elemento"  => "tabla",
											"clase" 	=> "table table-striped table-bordered",
											"id"		=> "persona_table",
											"datos"     => array(),
											"encabezado"=> array("Codigo",
																  "Identificacion",
																  "Nombres"),
											"options"   => array(),
											"campo"  	=> "");
			$data['div_buttons'] = $user_data['div_buttons'];
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['js'] = $user_data['js'];
            retornar_formulario( VIEW_GET_PERSON_2, $data );
            break;
		case GET_LIST_PERSONA:
			# Listado por cada presión/presionado/keypress/tecla en el input 'nombre_busq'
			$persona->get_personas_listado( $user_data );
            $data = array('{tablaPersona}' => array("elemento"  => "tabla",
                                                    "clase" => "table table-striped table-bordered",
                                                    "id"=> "persona_table",  
                                                    "datos"     => $persona->rows,
                                                    "encabezado" => array("Codigo",
                                                                          "Identificacion",
                                                                          "Nombres"),
                                                    "options"   => array(),
                                                    "campo"  => ""));
            retornar_result($data);
            break;
		default:
			echo "default";
	}
}
handler();
function constructor_combo_tipo_id( $nombre, $completo, $tipo = "" )
{	$selected = array();
	if ( $tipo == "1" ) //CI
	{ 	$selected[0] = ' selected="selected" ';
	}
	else if ( $tipo == "2" ) //RUC
	{ 	$selected[1] = ' selected="selected" ';
	}
	else if ( $tipo == "3" ) //PAS
	{ 	$selected[2] = ' selected="selected" ';
	}
	else if ( $tipo == "4" ) //CF
	{ 	$selected[3] = ' selected="selected" ';
	}
	else if ( $tipo == "5" ) //IDE
	{ 	$selected[4] = ' selected="selected" ';
	}
	else if ( $tipo == "6" ) //PLC
	{ 	$selected[5] = ' selected="selected" ';
	}
	if ( $completo == 1 )
		$whole_set = '
				<option '.$selected[1].' value="2">RUC</option>
				<option '.$selected[3].' value="4">Consumidor final</option>
				<option '.$selected[4].' value="5">Exterior</option>
				<option '.$selected[5].' value="6">Placa</option>';
	
	return '<select id="'.$nombre.'" name="'.$nombre.'" class="form-control">
				<option value="">Tipo de identificaci&oacute;n</option>
				<option '.$selected[0].' value="1">Cédula</option>
				<option '.$selected[2].' value="3">Pasaporte</option>'
				.$whole_set.'
			</select>';
}
function set_persona( $user_data, $per )
{	//Registra una persona nueva en la base.
	$persona = new Persona();
	$persona->set_persona(
		$user_data[ $per.'_tipo'], //tipo persona ( 0. Sin especificar, 1. Alumno, 2. Representante, 3. Empleado ).
		$user_data[ $per.'_codi'], //vacío si es insert, lleno si es update.
		$user_data[ 'cmb_'.$per.'_tipo_identificacion' ],
		$user_data[ $per.'_numero_identificacion' ],
		$user_data[ $per.'_nomb' ],
		$user_data[ $per.'_nomb_seg' ],
		$user_data[ $per.'_apel' ],
		$user_data[ $per.'_apel_mat' ],
		$user_data[ $per.'_rdb_genero' ],
		$user_data[ 'cmb_pais_'.$per.'_residencia' ],
		$user_data[ 'cmb_provincia_'.$per.'_residencia' ],
		$user_data[ 'cmb_ciudad_'.$per.'_residencia' ],
		$user_data[ $per.'_parroquia' ],
		$user_data[ $per.'_dir' ],
		$user_data[ $per.'_telf' ],
		$user_data[ $per.'_email_personal' ],
		$user_data[ $per.'_fecha_nac' ],
		$user_data[ 'cmb_pais_'.$per.'_lugar_nac' ],
		$user_data[ 'cmb_provincia_'.$per.'_lugar_nac' ],
		$user_data[ 'cmb_ciudad_'.$per.'_lugar_nac' ],
		
		//sin especificar, representante, empleado
		$user_data[ 'cmb_estado_civil_'.$per ],
		$user_data[ 'cmb_profesion_'.$per ],
		$user_data[ 'cmb_lateralidad_'.$per ],
		$user_data[ $per.'_empr_ingreso_mensual' ],
		$user_data[ $per.'_num_hijos' ],
		
		//empleado
		$user_data[ $per.'_empl_codi'],
		$user_data[ $per.'_rdb_tipo_empl'],
		$user_data[ 'cmb_area_'.$per ],
		$user_data[ 'cmb_dept_'.$per ],
		$user_data[ 'cmb_cargo_'.$per ],
		$user_data[ $per.'_empr_turno_empl_de' ],
		$user_data[ $per.'_empr_turno_empl_a' ],
		$user_data[ 'cmb_jornada_'.$per ],
		$user_data[ $per.'_fecha_ini_c' ],
		$user_data[ $per.'_fecha_fin_c' ],
		$user_data[ $per.'_empl_ext' ],
		$user_data[ $per.'_empl_mail' ],
		//datos del registro
		$_SESSION['usua_codi'],
		$_SERVER['REMOTE_ADDR'] );
	return $persona;
}
function sub_constructor_formulario_per_load( $procedencia_formulario, $tipo_persona, $persona, $c, $data, $per, $per_ctrl )
{   $data = constructor_formulario_per( $procedencia_formulario, $data, $per, $per_ctrl,
		$tipo_persona,											$persona->rows[$c]['per_codi'],
		
		$persona->rows[$c]['per_tipo_id'],						$persona->rows[$c]['per_id'],
		$persona->rows[$c]['per_nomb'],							$persona->rows[$c]['per_nomb_seg'], 
		$persona->rows[$c]['per_apel'],							$persona->rows[$c]['per_apel_mat'],
		$persona->rows[$c]['per_genero'],
		
		$persona->rows[$c]['per_pais_residencia'], 				$persona->rows[$c]['per_provincia_residencia'],
		$persona->rows[$c]['per_ciudad_residencia'], 			$persona->rows[$c]['per_parroquia_residencia'], 
		
		$persona->rows[$c]['per_dir_personal'],					$persona->rows[$c]['cont_det_numero'],
		$persona->rows[$c]['per_email_personal'],				$persona->rows[$c]['per_fecha_nac'], 
		
		$persona->rows[$c]['per_pais_nacionalidad'], 			$persona->rows[$c]['per_provincia'], 
		$persona->rows[$c]['per_ciudad'], 						$persona->rows[$c]['per_estado_civil'],
		$persona->rows[$c]['per_profesion'],					$persona->rows[$c]['per_lateralidad'],
		$persona->rows[$c]['per_ingreso_mensual'],				$persona->rows[$c]['per_num_hijos'],
		
		
		$persona->rows[$c]['empl_codi'],						$persona->rows[$c]['empl_tipo_empleado'],
		$persona->rows[$c]['empl_area'],
		$persona->rows[$c]['empl_dpto'],						$persona->rows[$c]['empl_cargo'],
		$persona->rows[$c]['empl_jornada'],						
		$persona->rows[$c]['empl_fini_contrato'],				$persona->rows[$c]['empl_ffin_contrato'], 
		
		$persona->rows[$c]['empl_turno_ini'],					$persona->rows[$c]['empl_turno_fin'],
		$persona->rows[$c]['empl_ext'],							$persona->rows[$c]['empl_email_inst']);
		
	return $data;
}
function constructor_formulario_per( $procedencia_formulario, $data, $per, $per_ctrl = "", 		
	$tipo_persona = 0, 			$per_codi,
	$tipo_id = "", 				$numero_id = "",
	$nomb = "", 				$nomb_seg = "",
	$apel = "",					$apel_mat = "",				$genero,
	$pais_res = 'ECU', 			$prov_res = 10,				$ciudad_res = 4376,			$parroquia = "",
	$dir = "", 					$telf = "",					$email_personal = "",		$fecha_nac = "", 
	
	$pais_nac = 'ECU', 			$prov_nac = 10,				$ciudad_nac = 4376, 
	$s_est_civil = 0,			$s_profesion = 0,			$lateralidad = 'D',			$per_ingreso_mensual = "",
	$per_num_hijos = 0,
	$empl_codi,					$empl_tipo_empleado,
	$empl_area = "0",			$empl_dpto = "0",			$empl_cargo = "",			$empl_jornada = "M",
	$empl_ini_c,				$empl_fin_c,
	$empl_turno_ini = "8:30 AM",$empl_turno_fin = "5:30 PM",$empl_ext, 					$empl_mail)
{	
	global $diccionario;
	$profesion 		= new Profesion();
	$pais 			= new Region();
	$provincia_nac 	= new Region();
	$ciudad_nac 	= new Region();
	$provincia_rec 	= new Region();
	$ciudad_rec 	= new Region();
	$estado_civil	= new Catalogo();
	$datosInst 		= new General();
	$profesion->get_ProfesionSelectFormat( );
	$pais->get_PaisSelectFormat( );
	$provincia_nac->get_CiudadDistritoSelectFormat( $pais_nac );
	$ciudad_nac->get_CiudadSelectFormat( $pais_nac, $prov_nac );
	$provincia_rec->get_CiudadDistritoSelectFormat( $pais_res );
	$ciudad_rec->get_CiudadSelectFormat( $pais_res, $prov_res );
	$estado_civil->get_all_sons(1);
	
	if( $per_ctrl == "" ) $per_ctrl = $per;
	
	/*-------------------------------------------------------------------------------------
		VALIDACIÓN PARA CARGAR EL FORMULARIO CORRECTAMENTE. DEPENDIENDO DEL TIPO PERSONA, MUESTRO LOS SIGUIENTES 'TABS'.
		DE LA MISMA MANERA, AL MOMENTO DE 'GUARDAR', AL ENVIAR POR JAVASCRIPT, PARA NO PREGUNTAR POR 'CAMPOS DE MÁS', ES DECIR, POR
		CAMPOS QUE NO CORRESPONDA PREGUNTAR A UNA PERSONA (EJEMPLO: TIPO ALUMNO NO LE PREGUNTO DATOS LABORALES), GUARDO EL CAMPO 'TIPO_PERSONA'
		EN UNA VARIABLE PARA QUE EL SISTEMA SEPA 'QUÉ TIPO DE PERSONA' GUARDAR.
	  -------------------------------------------------------------------------------------*/
	
	if ( $tipo_persona == 0 ) //CUANDO EL TIPO PERSONA ES '0', SE ABREN TODAS LAS OPCIONES.
	{	$data['display_datos_laborales'] = '<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-suitcase"></i><span class="hidden-xs hidden-sm"> Datos laborales</span></a></li>';
		$data['display_datos_empleado'] = '<li><a href="#tab_3" data-toggle="tab"><i class="fa fa-wrench"></i><span class="hidden-xs hidden-sm"> Datos del empleado</span></a></li>';
		$data['display_datos_academicos'] = '<li><a href="#tab_4" data-toggle="tab"><i class="fa fa-graduation-cap"></i><span class="hidden-xs hidden-sm"> Datos académicos</span></a></li>';
		$data['display_datos_debitos_bancarios'] = '<li><a href="#tab_5" data-toggle="tab"><i class="fa fa-credit-card"></i><span class="hidden-xs hidden-sm"> Débitos bancarios</span></a></li>';
	}
	if ( $tipo_persona == 1 ) //ALUMNO
	{	$data['display_datos_laborales'] = '';
		$data['display_datos_empleado'] = '';
		$data['display_datos_academicos'] = '<li><a href="#tab_4" data-toggle="tab"><i class="fa fa-graduation-cap"></i><span class="hidden-xs hidden-sm"> Datos académicos</span></a></li>';
		$data['display_datos_debitos_bancarios'] = '<li><a href="#tab_5" data-toggle="tab"><i class="fa fa-credit-card"></i><span class="hidden-xs hidden-sm"> Débitos bancarios</span></a></li>';
	}
	if ( $tipo_persona == 2 ) //REPRESENTANTE
	{	$data['display_datos_laborales'] = '<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-suitcase"></i><span class="hidden-xs hidden-sm"> Datos laborales</span></a></li>';
		$data['display_datos_empleado'] = '';
		$data['display_datos_academicos'] = '';
		$data['display_datos_debitos_bancarios'] = '';
	}
	if ( $tipo_persona == 3 ) //EMPLEADO
	{	$data['display_datos_laborales'] = '<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-suitcase"></i><span class="hidden-xs hidden-sm"> Datos laborales</span></a></li>';
		$data['display_datos_empleado'] = '<li><a href="#tab_3" data-toggle="tab"><i class="fa fa-wrench"></i><span class="hidden-xs hidden-sm"> Datos del empleado</span></a></li>';
		$data['display_datos_academicos'] = '';
		$data['display_datos_debitos_bancarios'] = '';
	}
	if ( $tipo_persona == 4 ) //CLIENTE EXTERNO
	{	$data['display_datos_laborales'] = '';
		$data['display_datos_empleado'] = '';
		$data['display_datos_academicos'] = '';
		$data['display_datos_debitos_bancarios'] = '';
	}
	
	$data['mensaje_datos_laborales'] = 'Ingrese sus antecedentes laborales e indique en cuál se encuentra actualmente laborando.';
	
	/*-------------------------------------------------------------------------------------
		VALIDANDO QUÉ MOSTRAR DEPENDIENDO DEL LUGAR DE DONDE SE LLAME EL FORMULARIO
		
		para hacerlo dinamico, se puede hacer que por cada vez que se cree un lugar nuevo de donde se quiere usar el formulario,
		se puede hacer una consulta en la base desde una nueva table que actualmente no existe, en la que se tendria
		un campo en donde se designa qué 'bloqueo' desea manipular y si desea mostrarlo o no.
		
		Cosa que con un foreach se manejaría así: $data[ $row_bloqueo['bloque_nombre'] ] = "style='display:".$row_bloqueo['display_estado'].";' ";
	  -------------------------------------------------------------------------------------*/
	 
	if ( $_SESSION['modulo'] == 'medic' )
	{	if( $procedencia_formulario == 'paciente' )
		{   $data['bloqueo_mensaje_inicial_multiples_tipos_persona'] = ' style="display:inline;" ';
			$data['bloqueo_ingreso_mensual'] = ' style="display:none;" ';
			$data['bloqueo_num_hijos'] = ' style="display:inline;" ';
			$data['bloqueo_datos_personales_explicitos'] = ' style="display:inline;" ';
		}
	}
	if ( $_SESSION['modulo'] == 'finan' )
	{	if( $procedencia_formulario == 'genera_deuda' )
		{   $data['bloqueo_mensaje_inicial_multiples_tipos_persona'] = ' style="display:none;" ';
			$data['bloqueo_ingreso_mensual'] = ' style="display:none;" ';
			$data['bloqueo_num_hijos'] = ' style="display:none;" ';
			$data['bloqueo_datos_personales_explicitos'] = ' style="display:none;" ';
		}
	}
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE LA NUEVA PERSONA
	  -------------------------------------------------------------------------------------*/
	$data['{cmb_pais_'.$per_ctrl.'_residencia}'] = array(	"elemento"  => 	"combo", 
															"datos"     => 	$pais->rows, 
															"options"   => 	array(	"name"		=>"cmb_pais_".$per."_residencia",
																					"id"		=>"cmb_pais_".$per."_residencia",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=> "js_region_cargaCiudadDistrito('div_ciudad_".$per."_residencia','div_provincia_".$per."_residencia','cmb_ciudad_".$per."_residencia','cmb_provincia_".$per."_residencia','cmb_pais_".$per."_residencia','".$diccionario['rutas_head']['ruta_html_common']."/region/controller.php')"),
															"selected"  => 	$pais_res);
	$data['{cmb_provincia_'.$per_ctrl.'_residencia}'] = array(  "elemento"  => 	"combo", 
																"datos"     => 	$provincia_rec->rows,
																"options"   => 	array(	"name"		=>"cmb_provincia_".$per."_residencia",
																						"id"		=>"cmb_provincia_".$per."_residencia",
																						"required"	=>"required",
																						"class"		=>"form-control",
																						"onChange"	=>	"js_region_cargaCiudad('div_ciudad_".$per."_residencia','cmb_ciudad_".$per."_residencia','cmb_provincia_".$per."_residencia','cmb_pais_".$per."_residencia','".$diccionario['rutas_head']['ruta_html_common']."/region/controller.php')"),
														"selected"  => 	$prov_res);
	$data['{cmb_ciudad_'.$per_ctrl.'_residencia}'] = array( "elemento"  => 	"combo", 
															"datos"     => 	$ciudad_rec->rows, 
															"options"   => 	array(	"name"		=>"cmb_ciudad_".$per."_residencia",
																					"id"		=>"cmb_ciudad_".$per."_residencia",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>	""),
															"selected"  => 	$ciudad_res);
															
	$data['{cmb_pais_'.$per_ctrl.'_lugar_nac}'] = array(	"elemento"  => 	"combo", 
															"datos"     => 	$pais->rows, 
															"options"   => 	array(	"name"		=>"cmb_pais_".$per."_lugar_nac",
																					"id"		=>"cmb_pais_".$per."_lugar_nac",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=> "js_region_cargaCiudadDistrito('div_ciudad_".$per."_lugar_nac','div_provincia_".$per."_lugar_nac','cmb_ciudad_".$per."_lugar_nac','cmb_provincia_".$per."_lugar_nac','cmb_pais_".$per."_lugar_nac','".$diccionario['rutas_head']['ruta_html_common']."/region/controller.php')"),
															"selected"  => 	$pais_nac);
	$data['{cmb_provincia_'.$per_ctrl.'_lugar_nac}'] = array(  "elemento"  => 	"combo", 
																"datos"     => 	$provincia_nac->rows,
																"options"   => 	array(	"name"		=>"cmb_provincia_".$per."_lugar_nac",
																						"id"		=>"cmb_provincia_".$per."_lugar_nac",
																						"required"	=>"required",
																						"class"		=>"form-control",
																						"onChange"	=>	"js_region_cargaCiudad('div_ciudad_".$per."_lugar_nac','cmb_ciudad_".$per."_lugar_nac','cmb_provincia_".$per."_lugar_nac','cmb_pais_".$per."_lugar_nac','".$diccionario['rutas_head']['ruta_html_common']."/region/controller.php')"),
														"selected"  => 	$prov_nac);
	$data['{cmb_ciudad_'.$per_ctrl.'_lugar_nac}'] = array( "elemento"  => 	"combo", 
															"datos"     => 	$ciudad_nac->rows, 
															"options"   => 	array(	"name"		=>"cmb_ciudad_".$per."_lugar_nac",
																					"id"		=>"cmb_ciudad_".$per."_lugar_nac",
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>	""),
															"selected"  => 	$ciudad_nac);
	if ( $tipo_persona != 1 )
	{   $data['{cmb_profesion_'.$per_ctrl.'}'] = array("elemento"  => 	"combo", 
														"datos"     => 	$profesion->rows, 
														"options"   => 	array(	"name"		=>"cmb_profesion_".$per,
																				"id"		=>"cmb_profesion_".$per,
																				"required"	=>"required",
																				"class"		=>"form-control",
																				"onChange"	=>	""),
														"selected"  => 	$s_profesion);
		$data['{cmb_estado_civil_'.$per_ctrl.'}'] = array( "elemento"  => 	"combo", 
															"datos"     => 	$estado_civil->rows, 
															"options"   => 	array(	"name"		=>"cmb_estado_civil_".$per,
																					"id"		=>"cmb_estado_civil_".$per,
																					"required"	=>"required",
																					"class"		=>"form-control",
																					"onChange"	=>	""),
														"selected"  => 	$s_est_civil);
		$data['bloqueo_alumno'] = "";
	}
	else
	{	$data['{cmb_profesion_'.$per_ctrl.'}'] = "";
		$data['{cmb_estado_civil_'.$per_ctrl.'}'] = "";
		$data['bloqueo_alumno'] = "style='display:none;'";
	}
	$lat_opc = array();
	array_push($lat_opc, array(0 => -1, 1 => 'Seleccione...', 	3 => ''));
	array_push($lat_opc, array(0 =>  'D', 1 => 'Diestro', 		3 => ''));
	array_push($lat_opc, array(0 =>  'Z', 1 => 'Zurdo', 			3 => ''));
	array_push($lat_opc, array(0 =>  'A', 1 => 'Ambidiestro', 	3 => ''));
	array_push($lat_opc, array( ) );
	$data['{cmb_lateralidad_'.$per_ctrl.'}']= array("elemento"  => 	"combo", 
													"datos"     => 	$lat_opc,
													"options"   => 	array(	"name"		=>"cmb_lateralidad_".$per,
																			"id"		=>"cmb_lateralidad_".$per,
																			"class"		=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	$lateralidad);
	
	/*-------------------------------------------------------------------------------------
		VARIABLES (Están al inicio de persona_formulario_per.php)
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_tipo'] = $tipo_persona;
	$data[ $per_ctrl.'_codi'] = $per_codi;
	$data[ $per_ctrl.'_empl_codi'] = $empl_codi;
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS PERSONALES DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$data['cmb_'.$per_ctrl.'_tipo_identificacion' ] = constructor_combo_tipo_id('cmb_'.$per.'_tipo_identificacion', 1, $tipo_id);
	$data[ $per_ctrl.'_numero_identificacion' ] = $numero_id;
	$data[ $per_ctrl.'_apel' ] = $apel;
	$data[ $per_ctrl.'_apel_mat' ] = $apel_mat;
	$data[ $per_ctrl.'_nomb' ] = $nomb;
	$data[ $per_ctrl.'_nomb_seg' ] = $nomb_seg;
	$data[ 'per_genero_m' ] = " checked ";
	$data[ 'per_genero_f' ] = "";
	$data[ $per_ctrl.'_parroquia' ] = $parroquia;
	$data[ $per_ctrl.'_dir' ] = $dir;
	$data[ $per_ctrl.'_telf' ] = $telf;
	$data[ $per_ctrl.'_email_personal' ] = $email_personal;
	$data[ $per_ctrl.'_fecha_nac' ] = $fecha_nac;
	$data[ 'cmb_estado_civil_'.$per_ctrl.'_selected' ] = '';
	$data[ 'cmb_profesion_'.$per_ctrl.'_selected' ] = '';
	$data[ $per_ctrl.'_empr_ingreso_mensual' ] = $per_ingreso_mensual;
	$data[ $per_ctrl.'_num_hijos' ] = $per_num_hijos;
	
	if( $genero == 'M' )
	{   $data[ 'per_genero_m' ] = " checked ";
		$data[ 'per_genero_f' ] = " ";
	}
	if( $genero == 'F' )
	{   $data[ 'per_genero_m' ] = " ";
		$data[ 'per_genero_f' ] = " checked ";
	}
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA NUEVA PERSONA
	  -------------------------------------------------------------------------------------*/
	$data['{div_resultado_tbl_datos_laborales}']=array(	"elemento"=>"tabla",
														"clase"=>"table table-bordered table-hover",
														"id"=>"tbl_datos_laborales_".$per_ctrl,
														"datos" => array(),
														"encabezado" => array(	"Ref. interna",
																				"Nombre empresa",
																				"RUC",
																				"Cargo",
																				"Telf.",
																				"Mail",
																				"Opciones"),
														"options" => array( ),
														"campo" => "codigo" );
	$data['{div_resultado_tbl_act_ext}'] = "";
	$data['{div_resultado_tbl_protex}'] = "";
	$data['{cmb_jornada_'.$per_ctrl.'}']= "";
	if ( $tipo_persona == 3 || $tipo_persona == 0 ) //EMPLEADO
	{	
		$area 		= new Area(  );
		$dept 		= new Departamento( );
		$cargo		= new Cargo(  );
		
		$area->get_Area_SelectFormat( -1 );
		$dept->get_Dept_SelectFormat( -1, $empl_area );
		$cargo->get_Cargo_SelectFormat( -1, $empl_dpto );
		$datosInst->getDatosInstitucion_info();
		
		//Estos datos sólo son para mostrarse, no se guardan, ni se manipulan.
		$data[ $per_ctrl.'_empr_nomb_empl'] = $datosInst->rows[0]['empr_razonSocial'];
		$data[ $per_ctrl.'_empr_ruc_empl'] = $datosInst->rows[0]['empr_ruc'];
		$data[ $per_ctrl.'_empr_dir_empl'] = $datosInst->rows[0]['empr_direccionMatriz'];
		$data[ $per_ctrl.'_empr_telf_empl'] = $datosInst->rows[0]['empr_contactoTelefono'];
		// .
		
		if( $empl_tipo_empleado == '1' )
		{   $data[ 'empl_tipo_empleado_prof' ] = " checked ";
			$data[ 'empl_tipo_empleado_mant' ] = "";
			$data[ 'empl_tipo_empleado_admin' ] = "";
		}
		if( $empl_tipo_empleado == '2' )
		{   $data[ 'empl_tipo_empleado_prof' ] = "";
			$data[ 'empl_tipo_empleado_mant' ] = " checked ";
			$data[ 'empl_tipo_empleado_admin' ] = "";
		}
		if( $empl_tipo_empleado == '3' )
		{   $data[ 'empl_tipo_empleado_prof' ] = "";
			$data[ 'empl_tipo_empleado_mant' ] = "";
			$data[ 'empl_tipo_empleado_admin' ] = " checked ";
		}
		
		$data[ $per_ctrl.'_empl_ext'] = $empl_ext;
		$data[ $per_ctrl.'_empl_mail'] = $empl_mail;
		$data[ $per_ctrl.'_fecha_ini_c'] = $empl_ini_c;
		$data[ $per_ctrl.'_fecha_fin_c'] = $empl_fin_c;
		
		$data[ $per_ctrl.'_empl_turno_fin'] = $empl_turno_fin;
		$data[ $per_ctrl.'_empl_turno_ini'] = $empl_turno_ini;
		
		$data['bloqueo_empleado'] = " disabled='disabled'";
		
		$act_ext = new Persona();
	    $act_ext->get_actividad_extra( $per_codi );
		//QUEMADO DIV_SHOW_RESULT con div_tbl_act_ext
		$opciones["Editar"] = "<span onclick='js_persona_add_act_ext(\"div_tbl_act_ext\",\"".$per.
											"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";
		$opciones["Eliminar"] = "<span onclick='js_persona_del_act_ext(\"div_tbl_act_ext\",\"".$per_codi."\",\"".$per.
									"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
		$data["{div_resultado_tbl_act_ext}"]=array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_act_ext",
													"name"		=> $per."_tbl_act_ext",
													"datos"     => $act_ext->rows,
													"encabezado"=> array("Referencia",
																		  "Actividad",
																		  ""),
													"options"   => array( $opciones ),
													"campo"  	=> "per_act_ext_codi");
		
		$ele_protex = new Persona();
		$ele_protex->get_ele_protex( $per_codi );
		//QUEMADO DIV_SHOW_RESULT CON div_tbl_ele_protex.
		$opciones_ele_protex["Eliminar"] = "<span onclick='js_persona_del_ele_protex(\"div_tbl_ele_protex\",\"".$per_codi."\",\"".$per.
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
		$data["{div_resultado_tbl_ele_protex}"]=array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_ele_protex",
													"name"		=> $per."_tbl_ele_protex",
													"datos"     => $ele_protex->rows,
													"encabezado"=> array("Referencia",
																		  "Elemento de protecci&oacute;n",
																		  ""),
													"options"   => array( $opciones_ele_protex ),
													"campo"  	=> "per_ele_protex_codi");
		$datos_lab = new Persona();
		$datos_lab->get_datos_laborales( $per_codi );
		/*$opciones["Editar"] = "<span onclick='js_persona_add_act_ext(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
									"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
		$opciones_datos_lab["Eliminar"] = "<span onclick='js_persona_del_datos_laborales(\"div_tbl_datos_laborales\",\"".$per_codi."\",\"".$per.
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
		$data["{div_resultado_tbl_datos_laborales}"]=array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_datos_laborales",
													"name"		=> $per."_tbl_datos_laborales",
													"datos"     => $datos_lab->rows,
													"encabezado"=> array("Referencia",
																		  "Nombre empresa",
																		  "RUC",
																		  "Cargo",
																		  "Telf.",
																		  "Mail",
																		  ""),
													"options"   => array( $opciones_datos_lab ),
													"campo"  	=> "per_inst_codi");
		$rie_lab = new Persona();
		$rie_lab->get_rie_laborales( $per_codi );
		/*$opciones_rie["Editar"] = "<span onclick='js_persona_add_rie_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
									"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
		$opciones_rie["Eliminar"] = "<span onclick='js_persona_del_rie_laborales(\"div_tbl_rie_laborales\",\"".$per_codi."\",\"".$per.
									"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
		$data["{div_resultado_tbl_rie_laborales}"]=array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_rie_laborales",
													"name"		=> $per."_tbl_rie_laborales",
													"datos"     => $rie_lab->rows,
													"encabezado"=> array("Referencia",
																		 "Nombre instituci&oacute;n",
																		 "F&iacute;sico",
																		 "Fisicomec&aacute;nico",
																		 "Qu&iacute;mico",
																		 "Biol&oacute;gico",
																		 "Disergon&oacute;mico",
																		 "Psicosocial",
																		  ""),
													"options"   => array( $opciones_rie ),
													"campo"  	=> "inst_risk_codi");
		$acc_lab = new Persona();
		$acc_lab->get_acc_laborales( $per_codi );
		/*$opciones_acc["Editar"] = "<span onclick='js_persona_add_acc_laborales(\"".$user_data['div_show_result']."\",\"".$user_data['perX'].
									"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
		$opciones_acc["Eliminar"] = "<span onclick='js_persona_del_acc_laborales(\"div_tbl_acc_laborales\",\"".$per_codi."\",\"".$per.
									"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
									" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
		$data["{div_resultado_tbl_acc_laborales}"]=array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_acc_laborales",
													"name"		=> $per."_tbl_acc_laborales",
													"datos"     => $acc_lab->rows,
													"encabezado"=> array("Referencia",
																		  "Nombre empresa",
																		  "Fecha siniestro",
																		  "Causa",
																		  "Tipo lesión",
																		  "Parte afectada",
																		  "Incapacidad",
																		  "Secuelas",
																		  ""),
													"options"   => array( $opciones_acc ),
													"campo"  	=> "inst_acc_codi");
		$data['{cmb_area_per}'] = array("elemento"  => 	"combo", 
													"datos"     => 	$area->rows,
													"options"   => 	array(	"name"		=>"cmb_area_".$per,
																			"id"		=>"cmb_area_".$per,
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=>"js_departamento_cargaDept_SelectFormat('div_cmb_dept','cmb_dept_".$per."','div_cmb_cargo','cmb_cargo_".$per."',this.value);"),
													"selected"  => 	$empl_area );
		$data['{cmb_dept_per}'] = array("elemento"  => 	"combo", 
													"datos"     => 	$dept->rows,
													"options"   => 	array(	"name"		=>"cmb_dept_".$per,
																			"id"		=>"cmb_dept_".$per,
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=>"js_cargo_cargaCargo_SelectFormat('div_cmb_cargo','cmb_cargo_".$per."',this.value);"),
													"selected"  => 	$empl_dpto );
		$data['{cmb_cargo_per}'] = array("elemento"  => 	"combo", 
													"datos"     => 	$cargo->rows,
													"options"   => 	array(	"name"		=>"cmb_cargo_".$per,
																			"id"		=>"cmb_cargo_".$per,
																			"required"	=>"required",
																			"class"		=>"form-control",
																			"onChange"	=>""),
													"selected"  => 	$empl_cargo );
													
		$jor_opc = array();
		array_push($jor_opc, array(0 =>   -1, 1 => '- Seleccione jornada -', 3 => ''));
		array_push($jor_opc, array(0 =>  'M', 1 => 'Matutino', 		3 => ''));
		array_push($jor_opc, array(0 =>  'V', 1 => 'Vespertino', 	3 => ''));
		array_push($jor_opc, array(0 =>  'D', 1 => 'Diurno', 		3 => ''));
		array_push($jor_opc, array( ) );
		$data['{cmb_jornada_'.$per_ctrl.'}']= array("elemento"  => 	"combo", 
													"datos"     => 	$jor_opc,
													"options"   => 	array(	"name"		=>"cmb_jornada_".$per,
																			"id"		=>"cmb_jornada_".$per,
																			"class"		=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	$empl_jornada);
	}
	
	$data['per'] = $per;
	return $data;
}
function constructor_datos_laborales_per( 
	$data, 				$per, 				$per_ctrl = "",
	$empr_codi="", 		$per_empr_codi="",
	$empr_nomb="", 		$empr_ruc="",
	$empr_dir="",		$empr_cargo="",
	$empr_telf="", 		$empr_mail="" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_empr_codi'] = $empr_codi;
	$data[ $per_ctrl.'_per_empr_codi'] = $per_empr_codi;
	$data[ $per_ctrl.'_empr_nomb'] = $empr_nomb;
	$data[ $per_ctrl.'_empr_ruc'] = $empr_ruc;
	$data[ $per_ctrl.'_empr_dir'] = $empr_dir;
	$data[ $per_ctrl.'_empr_cargo'] = $empr_cargo;
	$data[ $per_ctrl.'_empr_telf'] = $empr_telf;
	$data[ $per_ctrl.'_empr_mail'] = $empr_mail;
	$data['per'] = $per;
	return $data;
}
function constructor_act_ext_per( $data, $per, $per_ctrl = "", $per_codi, $act_ext_nombre="" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE ACTIVIDADES EXTRALABORALES
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_act_ext_nombre'] = $act_ext_nombre;
	$data['per'] = $per;
	return $data;
}
function constructor_protex_esp_per( $data, $per, $per_ctrl = "", $per_codi, $protex_esp_tipo="0", $protex_esp_nombre="0" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE PROTECCIÓN ESPECIAL
	  -------------------------------------------------------------------------------------*/
	
	$protex = new Elemento_protex();
	$protex->get_tipo_SelectFormat( -1 );
	$data['{cmb_protex_esp_tipo}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$protex->rows, 
											"options"   => 	array(	"name"		=>"cmb_protex_esp_tipo_".$per,
																	"id"		=>"cmb_protex_esp_tipo_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>"js_elemento_protex_cargaElemento_SelectFormat('div_cmb_protex_esp_nombre','cmb_protex_esp_".$per."',this.value);"),
											"selected"  => 	$protex_esp_tipo);
	$protex2 = new Elemento_protex();
	$protex2->get_subtipo_SelectFormat( -1, $protex_esp_tipo );
	$data['{cmb_protex_esp_nombre}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$protex2->rows, 
											"options"   => 	array(	"name"		=>"cmb_protex_esp_".$per,
																	"id"		=>"cmb_protex_esp_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$protex_esp_nombre);
	$data[ $per_ctrl.'_protex_esp_per_codi'] = $per_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_rie_laborales( $data, $per, $per_ctrl = "", $per_codi = -1, $inst_risk_codi = 0,
									$inst_risk_fisico, $inst_risk_fisicomec, $inst_risk_quimico, $inst_risk_biologico, 
									$inst_risk_disergon, $inst_risk_psicosocial )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	$datos_lab = new Persona();
	$datos_lab->get_datos_laborales_por_persona_SelectFormat( $per_codi );
	$data['{cmb_datos_laborales}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$datos_lab->rows, 
											"options"   => 	array(	"name"		=>"cmb_datos_laborales_rie_".$per,
																	"id"		=>"cmb_datos_laborales_rie_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  =>  $inst_risk_codi );
											
	$data[ $per_ctrl.'_inst_risk_fisico'] = $inst_risk_fisico;
	$data[ $per_ctrl.'_inst_risk_fisicomec'] = $inst_risk_fisicomec;
	$data[ $per_ctrl.'_inst_risk_quimico'] = $inst_risk_quimico;
	$data[ $per_ctrl.'_inst_risk_biologico'] = $inst_risk_biologico;
	$data[ $per_ctrl.'_inst_risk_disergon'] = $inst_risk_disergon;
	$data[ $per_ctrl.'_inst_risk_psicosocial'] = $inst_risk_psicosocial;
	$data['per'] = $per;
	return $data;
}
function constructor_acc_laborales( $data, $per, $per_ctrl = "", $per_codi = -1, 
									$inst_acc_codi = 0, $inst_acc_fecha, $inst_acc_causa, 
									$inst_acc_tipo_lesion, $inst_acc_parte_afectada, $inst_acc_incapacidad, $inst_acc_secuelas )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	$datos_lab = new Persona();
	$datos_lab->get_datos_laborales_por_persona_SelectFormat( $per_codi );
	$data['{cmb_datos_laborales}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$datos_lab->rows, 
											"options"   => 	array(	"name"		=>"cmb_datos_laborales_acc_".$per,
																	"id"		=>"cmb_datos_laborales_acc_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$inst_acc_codi );
											
	$data[ $per_ctrl.'_inst_acc_fecha'] = $inst_acc_fecha;
	$data[ $per_ctrl.'_inst_acc_causa'] = $inst_acc_causa;
	$data[ $per_ctrl.'_inst_acc_tipo_lesion'] = $inst_acc_tipo_lesion;
	$data[ $per_ctrl.'_inst_acc_parte_afectada'] = $inst_acc_parte_afectada;
	$data[ $per_ctrl.'_inst_acc_incapacidad'] = $inst_acc_incapacidad;
	$data[ $per_ctrl.'_inst_acc_secuelas'] = $inst_acc_secuelas;
	$data['per'] = $per;
	return $data;
}
?>