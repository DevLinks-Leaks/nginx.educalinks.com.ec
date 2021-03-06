<?php
session_start();
include("../../../framework/dbconf_main.php");
$params = array($domain);

$sql="{call dbo.clie_info_domain(?)}";
$resu_login = sqlsrv_query($conn, $sql, $params);  
$row = sqlsrv_fetch_array($resu_login);
$_SESSION['host']=$row['clie_instancia_db'];
$_SESSION['user']=$row['clie_user_db'];
$_SESSION['pass']=$row['clie_pass_db'];
$_SESSION['dbname']=$row['clie_base'];
$_SESSION['IN']= (isset($_SESSION['usua_codi']))?'OK':'KO';
$_SESSION['usua_codigo']=$_SESSION['usua_codi'];
$_SESSION['usua_pass']=$_SESSION['usua_pass'];
$_SESSION['modulo']='medic';

require_once('../../../core/controllerBase.php');
require_once('../../common/catalogo/model.php');
require_once('../../medic/alergia/model.php');
require_once('../../medic/vacuna/model.php');
require_once('../../medic/enfermedad/model.php');
require_once('../../medic/ex_lab_clinico/model.php');
require_once('../../medic/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler() {
    require('../../../core/rutas.php');
    $permiso 		= get_mainObject('General');
    $event 			= get_actualEvents( array( VIEW_GET_ALL, VIEW_FORMULARIO_MED ), VIEW_GET_ALL );
    $user_data 		= get_frontData();
	$ficha_medica	= get_mainObject('Ficha_medica');
	
    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla = "facturasPendiente_table";}else{$tabla =$_POST['tabla'];}
    switch ($event) {
		case VIEW_GET_ALL:
            #  Presenta la pagina inicial
            global $diccionario;
            if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case PRINTREPVISOR:
			echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-ficha-medica" src="'.$user_data['url'].'"></iframe>
				</div>';
			break;
		case VIEW_FORMULARIO_MED:
			$data = constructor_formulario_med( $data, $user_data['perX'], 'per', '', $user_data['per_codi'], $user_data['tipo_persona'] );
			$data['mensaje']="Formulario de Ficha médica";
			retornar_formulario( VIEW_FORMULARIO_MED, $data );
			break;
		case SET_FICHA_MED_ESPECIFICO:
				$resultado = set_ficha_medica( $user_data, $user_data['perX'] );
				$data["MENSAJE"] = $resultado->mensaje;
				$data["fmex_codi"] = $resultado->fmex_codi_out;
			echo json_encode($data, true);
			break;
		case GET_FICHA_MED_ESPECIFICO:
			global $diccionario;
			$ficha_medica->get_ficha_medica( $user_data['fmex_codi'] );
			if( ( count( $ficha_medica->rows )-1 )>0 )
			{	$data = sub_constructor_formulario_med_load( $ficha_medica, '0', $data, $user_data['perX'], 'per' );
				retornar_formulario( VIEW_FORMULARIO_MED, $data );
			}
			else
			{   echo "No se encontraron resultados";
			}
			break;
		case GET_FICHA_MED_LISTADO:
			global $diccionario;
			$ficha_medica = new Ficha_medica();
			$ficha_medica->get_ficha_medica_listado( );
			if( ( count( $ficha_medica->rows ) ) > 0 )
			{	$opciones['Editar'] = 	" <span onclick='js_ficha_med_formulario_edit( \"span_button_save_medical_record\" ,".
										"	\"div_ficha_med_bandeja_consulta\", \"fmex\", \"{codigo}\" )' ".
										" 	class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Editar ficha' data-placement='left'></span>&nbsp;";
				$data["{resultado}"] = array(  "elemento" => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> "tbl_ficha_med_consulta",
												"datos"     => $ficha_medica->rows,
												"encabezado"=> array(	"Ficha médica",
																		"Persona",
																		"Nombre",
																		"Tipo",
																		"Ficha médica",
																		"Fecha registro",
																		"Usuario registro",
																		"Estado",
																		""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_codi");
				if( $user_data['is_back'] == 1 )
					retornar_result( $data );
				else
					retornar_vista( VIEW_CONSULTA, $data );
			}
			else
			{   $data["{resultado}"] = "<div style='text-align:center;'><span class='fa fa-user'></span><br>No se encontraron resultados";
				if( $user_data['is_back'] == 1 )
					retornar_result( $data );
				else
					retornar_vista( VIEW_CONSULTA, $data );
			}
			break;
		/* 	---------------------------------------------------------------
			ALERGIA
			---------------------------------------------------------------
		*/
		case VIEW_ALERGIA:
			if( trim($user_data['fmex_ale_codi']) != "" )
			{   $alergia = new Ficha_medica();
				$alergia->get_alergia( $user_data['fmex_codi'], $user_data['fmex_ale_codi'] );
				if($alergia->rows >0)
				{   foreach ($alergia->rows as $ale_row )
					{	if( !empty( $ale_row ) )
						{   $data = constructor_alergia_per( $data, $user_data['perX'], 'per', 
								$user_data['fmex_codi'], $ale_row['ale_tipo'], $ale_row['ale_codi'], $ale_row['ale_desc_reaccion']);
						}
					}
				}
			}
			else
			{   $data = constructor_alergia_per( $data, $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_ALERGIA, $data );
			break;
		case SET_ALERGIA:
			$alergia = new Ficha_medica();
			if ( !empty( $user_data['ale_codi'] ) )
			{   $resultado = $alergia->set_alergia( $user_data['fmex_codi'], $user_data['ale_codi'],$user_data['ale_reaccion'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar una alergia.";
			}
			echo json_encode($data, true);
			break;
		case CONS_ALERGIA:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $alergia = new Ficha_medica();
				$alergia->get_alergia( $user_data['fmex_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_alergia(\"".$user_data['div_show_result']."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_alergia}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_alergia",
															"name"		=> $user_data['perX']."_tbl_alergia",
															"datos"     => $alergia->rows,
															"encabezado"=> array("Referencia",
																				  "Alergia",
																				  "Reacción",
																				  "Alergia Referencia",
																				  "Alergia Tipo",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "fmex_ale_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_ALERGIA:
			$alergia = new Ficha_medica();
			$resultado = $alergia->del_alergia($user_data['fmex_ale_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	---------------------------------------------------------------
			VACUNA
			---------------------------------------------------------------
		*/
		case VIEW_VACUNA:
			if( trim($user_data['fmex_vac_codi']) != "" )
			{   $vacuna = new Ficha_medica();
				$vacuna->get_vacuna( $user_data['fmex_codi'], $user_data['fmex_vac_codi'] );
				if($vacuna->rows >0)
				{   foreach ($vacuna->rows as $vac_row )
					{	if( !empty( $vac_row ) )
						{   $data = constructor_vacuna_per( $data, $user_data['perX'], 'per', 
								$user_data['fmex_codi'], $vac_row['vac_codi'], $vac_row['vac_ficha'], $vac_row['vac_desc'] );
						}
					}
				}
			}
			else
			{   $data = constructor_vacuna_per( $data, $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_VACUNA, $data );
			break;
		case SET_VACUNA:
			$vacuna = new Ficha_medica();
			if ( !empty( $user_data['vac_codi'] ) )
			{   $resultado = $vacuna->set_vacuna( $user_data['fmex_codi'], $user_data['vac_codi'], $user_data['vac_fecha'],
													$user_data['vac_desc'], $_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar una vacuna.";
			}
			echo json_encode($data, true);
			break;
		case CONS_VACUNA:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $vacuna = new Ficha_medica();
				$vacuna->get_vacuna( $user_data['fmex_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_vacuna(\"".$user_data['div_show_result']."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_vacuna}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_vacuna",
															"name"		=> $user_data['perX']."_tbl_vacuna",
															"datos"     => $vacuna->rows,
															"encabezado"=> array( "Referencia",
																				  "Vacuna",
																				  "Fecha",
																				  "Reacción",
																				  "Tipo",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "fmex_vac_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_VACUNA:
			$vacuna = new Ficha_medica();
			$resultado = $vacuna->del_vacuna($user_data['fmex_vac_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	---------------------------------------------------------------
			ENFERMEDAD
			---------------------------------------------------------------
		*/
		case VIEW_ENFERMEDAD:
			if( trim($user_data['fmex_enf_codi']) != "" )
			{   $enfermedad = new Ficha_medica();
				$enfermedad->get_enfermedad( $user_data['fmex_codi'], $user_data['titular'], $user_data['fmex_enf_codi'] );
				if($enfermedad->rows >0)
				{   foreach ($enfermedad->rows as $vac_row )
					{	if( !empty( $vac_row ) )
						{   $data = constructor_enfermedad_per( $data, $vac_row['enf_titular'], $user_data['perX'], 'per', 
								$user_data['fmex_codi'], $vac_row['enf_codi'], $vac_row['enf_tiene'], $vac_row['enf_tuvo'],
								$vac_row['enf_tratamiento'], $vac_row['enf_desc_tratamiento'],$vac_row['enf_parentesco'] );
						}
					}
				}
			}
			else
			{   $data = constructor_enfermedad_per( $data, $user_data['titular'], $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_ENFERMEDAD, $data );
			break;
		case SET_ENFERMEDAD:
			$vacuna = new Ficha_medica();
			if ( !empty( $user_data['enf_codi'] ) )
			{   $resultado=$vacuna->set_enfermedad(	$user_data['fmex_codi'], $user_data['enf_codi'], $user_data['enf_tiene'], $user_data['enf_tuvo'],
													$user_data['enf_titular'],$user_data['enf_parentesco'],
													$user_data['enf_tratamiento'], $user_data['enf_desc_tratamiento'], $_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar una enfermedad.";
			}
			echo json_encode($data, true);
			break;
		case CONS_ENFERMEDAD:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $enfermedad = new Ficha_medica();
				$enfermedad->get_enfermedad( $user_data['fmex_codi'], $user_data['titular'] );
				$tbl_nombre = $div_tbl_enfermedad = "";
				if ( $user_data['titular'] == 'T' )
				{   $tbl_nombre = "_tbl_enfermedad";
					$div_tbl_enfermedad = "div_tbl_enfermedad";
					$headers =  array("Referencia",
									  "Enfermedad",
									  "Tiene",
									  "Tuvo",
									  "Tratamiento",
									  "Observaciones",
									  "Enf. referencia",
									  "");
				}
				if ( $user_data['titular'] == 'F' )
				{   $tbl_nombre = "_tbl_enfermedad_familia";
					$div_tbl_enfermedad = "div_tbl_enfermedad_familia";
					$headers =  array("Referencia",
									  "Enfermedad",
									  "Tiene",
									  "Tuvo",
									  "Tratamiento",
									  "Parentesco",
									  "Observaciones",
									  "Enf. referencia",
									  "");
				}
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_enfermedad(\"".$div_tbl_enfermedad."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\",\"".$user_data['titular']."\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_enfermedad}"]= array( "elemento"  => "tabla",
																"clase" 	=> "table table-striped table-bordered",
																"id"		=> $user_data['perX'].$tbl_nombre,
																"name"		=> $user_data['perX'].$tbl_nombre,
																"datos"     => $enfermedad->rows,
																"encabezado"=> $headers,
																"options"   => array( $opciones ),
																"campo"  	=> "fmex_enf_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_ENFERMEDAD:
			$enfermedad = new Ficha_medica();
			$resultado = $enfermedad->del_enfermedad($user_data['fmex_enf_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	---------------------------------------------------------------
			CIRUGIA
			---------------------------------------------------------------
		*/
		case VIEW_CIRUGIA:
			if( trim($user_data['fmex_cir_codi']) != "" )
			{   $cirugia = new Ficha_medica();
				$cirugia->get_cirugia( $user_data['fmex_codi'], $user_data['fmex_cir_codi'] );
				if($cirugia->rows >0)
				{   foreach ($cirugia->rows as $ale_row )
					{	if( !empty( $ale_row ) )
						{   $data = constructor_cirugia_per( $data, $user_data['perX'], 'per', 
								$user_data['fmex_codi'], $user_data['cir_nombre_desc'],$user_data['cir_fecha'],
													$user_data['cir_localizacion'],$user_data['cir_extension'],$user_data['cir_proposito']);
						}
					}
				}
			}
			else
			{   $data = constructor_cirugia_per( $data, $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_CIRUGIA, $data );
			break;
		case SET_CIRUGIA:
			$cirugia = new Ficha_medica();
			if ( !empty( $user_data['cir_nombre_desc'] ) )
			{   $resultado = $cirugia->set_cirugia( $user_data['fmex_codi'], $user_data['cir_nombre_desc'],$user_data['cir_fecha'],
													$user_data['cir_localizacion'],$user_data['cir_extension'],$user_data['cir_proposito'],
															$_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe escribir el nombre y/o descripción de una cirugía.";
			}
			echo json_encode($data, true);
			break;
		case CONS_CIRUGIA:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $cirugia = new Ficha_medica();
				$cirugia->get_cirugia( $user_data['fmex_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_cirugia(\"".$user_data['div_show_result']."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_cirugia}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_cirugia",
															"name"		=> $user_data['perX']."_tbl_cirugia",
															"datos"     => $cirugia->rows,
															"encabezado"=> array( "Referencia",
																				  "Cirugía",
																				  "Fecha",
																				  "Localización",
																				  "Extensión",
																				  "Propósito",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "fmex_cir_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_CIRUGIA:
			$cirugia = new Ficha_medica();
			$resultado = $cirugia->del_cirugia($user_data['fmex_cir_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	---------------------------------------------------------------
			EXAMEN DE LABORATORIO CLINICO
			---------------------------------------------------------------
		*/
		case VIEW_EX_LAB_CLINICO:
			if( trim($user_data['fmex_cir_codi']) != "" )
			{   $ex_lab_clinico = new Ficha_medica();
				$ex_lab_clinico->get_ex_lab_clinico( $user_data['fmex_codi'], $user_data['fmex_cir_codi'] );
				if($ex_lab_clinico->rows >0)
				{   foreach ($ex_lab_clinico->rows as $ale_row )
					{	if( !empty( $ale_row ) )
						{   $data = constructor_ex_lab_clinico_per( $data, $user_data['perX'], 'per', 
										$user_data['fmex_codi'], $user_data['lab_codi'],
										$user_data['lab_resultado'],$user_data['lab_fecha'] );
						}
					}
				}
			}
			else
			{   $data = constructor_ex_lab_clinico_per( $data, $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_EX_LAB_CLINICO, $data );
			break;
		case SET_EX_LAB_CLINICO:
			$ex_lab_clinico = new Ficha_medica();
			if ( !empty( $user_data['lab_codi'] ) )
			{   $resultado = $ex_lab_clinico->set_ex_lab_clinico( $user_data['fmex_codi'], $user_data['lab_codi'],$user_data['lab_resultado'],
													$user_data['lab_fecha'], $_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe seleccionar un examen de laboratorio cl&iacute;nico.";
			}
			echo json_encode($data, true);
			break;
		case CONS_EX_LAB_CLINICO:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $ex_lab_clinico = new Ficha_medica();
				$ex_lab_clinico->get_ex_lab_clinico( $user_data['fmex_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_ex_lab_clinico(\"".$user_data['div_show_result']."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_ex_lab_clinico}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_ex_lab_clinico",
															"name"		=> $user_data['perX']."_tbl_ex_lab_clinico",
															"datos"     => $ex_lab_clinico->rows,
															"encabezado"=> array("Referencia",
																				  "Examen",
																				  "Resultado",
																				  "Fecha",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "fmex_cir_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_EX_LAB_CLINICO:
			$ex_lab_clinico = new Ficha_medica();
			$resultado = $ex_lab_clinico->del_ex_lab_clinico($user_data['fmex_lab_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
		/* 	---------------------------------------------------------------
			RADIOGRAFÍAS
			---------------------------------------------------------------
		*/
		case VIEW_RADIOGRAFIA:
			if( trim($user_data['fmex_rad_codi']) != "" )
			{   $radiografia = new Ficha_medica();
				$radiografia->get_radiografia( $user_data['fmex_codi'], $user_data['fmex_rad_codi'] );
				if($radiografia->rows >0)
				{   foreach ($radiografia->rows as $ale_row )
					{	if( !empty( $ale_row ) )
						{   $data = constructor_radiografia_per( $data, $user_data['perX'], 'per', 
										$user_data['fmex_codi'], $user_data['rad_nombre_desc'],
										$user_data['rad_fecha'],$user_data['rad_localizacion'] );
						}
					}
				}
			}
			else
			{   $data = constructor_radiografia_per( $data, $user_data['perX'], 'per' );
			}
			if ( trim($user_data['per_nombre_completo'] ) == "" )
				$data['per_nombre_completo'] = "la persona";
			else
				$data['per_nombre_completo'] = $user_data['per_nombre_completo'];
			
			$data['div_show_result'] = $user_data['div_show_result'];
			$data['fmex_codi'] = $user_data[ 'fmex_codi'];
			retornar_formulario( VIEW_RADIOGRAFIA, $data );
			break;
		case SET_RADIOGRAFIA:
			$radiografia = new Ficha_medica();
			if ( !empty( $user_data['rad_nombre_desc'] ) )
			{   $resultado = $radiografia->set_radiografia( $user_data['fmex_codi'], $user_data['rad_nombre_desc'],$user_data['rad_fecha'],
													$user_data['rad_localizacion'], $_SESSION['usua_codi'], $_SERVER['REMOTE_ADDR']);
				$data["MENSAJE"] = $resultado->mensaje;
			}
			else
			{   $data["MENSAJE"] = "¡Error! Debe escribir el nombre o descripción de la radiografía.";
			}
			echo json_encode($data, true);
			break;
		case CONS_RADIOGRAFIA:
			if ( !empty( $user_data['fmex_codi'] ) )
			{   $radiografia = new Ficha_medica();
				$radiografia->get_radiografia( $user_data['fmex_codi'] );
				$opciones["Eliminar"] = "<span onclick='js_ficha_del_radiografia(\"".$user_data['div_show_result']."\",\"".$user_data['fmex_codi']."\",\"".$user_data['perX'].
											"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
											" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
				$data["{div_resultado_tbl_radiografia}"]=array( "elemento"  => "tabla",
															"clase" 	=> "table table-striped table-bordered",
															"id"		=> $user_data['perX']."_tbl_radiografia",
															"name"		=> $user_data['perX']."_tbl_radiografia",
															"datos"     => $radiografia->rows,
															"encabezado"=> array( "Referencia",
																				  "Radiografía",
																				  "Fecha de la radiografía",
																				  "Localización",
																				  ""),
															"options"   => array( $opciones ),
															"campo"  	=> "fmex_rad_codi");
			}
			else
			{   $data["MENSAJE"] = "¡Error! No se ha proveído el código interno de la persona.";
			}
			retornar_result( $data );
			break;
		case ERASE_RADIOGRAFIA:
			$radiografia = new Ficha_medica();
			$resultado = $radiografia->del_radiografia($user_data['fmex_rad_codi'], $user_data['fmex_codi']);
			$data["MENSAJE"] = $resultado->mensaje;
			echo json_encode($data, true);
			break;
        default:
			echo "defauñt";
            break;
    }
}
handler();
function set_ficha_medica( $user_data, $per )
{
	$ficha_medica = new Ficha_medica();
	$ficha_medica->set_ficha_medica(
		$user_data[ $per.'_fmex_codi'],					$user_data[ $per.'_per_codi'],				$user_data[ $per.'_tipo'],
		$user_data[ $per.'_rdb_tipo_ficha'],
		$user_data[ $per.'_rdb_tabaco'],				$user_data[ $per.'_rdb_alcohol'],			$user_data[ $per.'_rdb_drogas'],
		$user_data[ $per.'_con_fisica'],				$user_data[ $per.'_act_sicomotora'],		$user_data[ $per.'_deambulacion'],
		$user_data[ $per.'_exp_verbal'],				$user_data[ $per.'_estado_nutricional'],	$user_data[ $per.'_estatura'],
		$user_data[ $per.'_peso'],						$user_data[ $per.'_temp_bucal'],			$user_data[ $per.'_pulso'],
		$user_data[ $per.'_presion_arterial'],			$user_data[ $per.'_piel'],					$user_data[ $per.'_ganglios'],
		$user_data[ $per.'_cabeza'],					$user_data[ $per.'_cuello'],				$user_data[ $per.'_ojos'],
		$user_data[ $per.'_oidos'],						$user_data[ $per.'_boca'],					$user_data[ $per.'_nariz'],
		$user_data[ $per.'_dentadura'],					$user_data[ $per.'_garganta'],				$user_data[ $per.'_corazon'],
		$user_data[ $per.'_torax'],						$user_data[ $per.'_pulmones'],				$user_data[ $per.'_mamas'],
		$user_data[ $per.'_higado'],					$user_data[ $per.'_ves_biliar'],			$user_data[ $per.'_bazo'],
		$user_data[ $per.'_estomago'],					$user_data[ $per.'_intestinos'],			$user_data[ $per.'_apendice'],
		$user_data[ $per.'_ano'],
		$user_data[ $per.'_umbilical'],					$user_data[ $per.'_rurales'],				$user_data[ $per.'_inguinal_derecha'],
		$user_data[ $per.'_inguinal_izquierda'],		$user_data[ $per.'_deformaciones'],			$user_data[ $per.'_masas_musculares'],
		$user_data[ $per.'_movibilidad'],				$user_data[ $per.'_puntos_dolorosos'],		$user_data[ $per.'_tracto_urinario'],
		$user_data[ $per.'_espermaquia'],				$user_data[ $per.'_tracto_genital_masculino'],
		$user_data[ $per.'_tracto_genital_femenino'],
		$user_data[ $per.'_menstruacion'],				$user_data[ $per.'_menarquia'],				$user_data[ $per.'_menapmia'],
		$user_data[ $per.'_gesta'],						$user_data[ $per.'_partos'],				$user_data[ $per.'_aborto'],
		$user_data[ $per.'_cesarea'],					$user_data[ $per.'_superior_derecha'],		$user_data[ $per.'_superior_izquierda'],
		$user_data[ $per.'_inferior_derecha'],			$user_data[ $per.'_inferior_izquierda'],	$user_data[ $per.'_ojo_derecho'],
		$user_data[ $per.'_ojo_izquierdo'],				$user_data[ $per.'_oido_derecho'],			$user_data[ $per.'_oido_izquierdo'],
		$user_data[ $per.'_rdb_reflex_tendinosos'],		$user_data[ $per.'_rdb_reflex_pupilares'],	$user_data[ $per.'_marcha'],
		$user_data[ $per.'_sens_superficial'],			$user_data[ $per.'_profunda_romberg'],		$user_data[ $per.'_estado_mental'],
		$user_data[ $per.'_memoria'],					$user_data[ $per.'_irritabilidad'],			$user_data[ $per.'_depresion'],
		$user_data[ $per.'_aptitud_trabajo'],			$_SESSION['usua_codi'],						$_SERVER['REMOTE_ADDR'] );
	return $ficha_medica;
}
function sub_constructor_formulario_med_load( $ficha_medica, $c, $data, $per, $per_ctrl )
{   $data = constructor_formulario_med(
		$data, 														$per, 													$per_ctrl,
		$ficha_medica->rows[$c]['fmex_codi'],						$ficha_medica->rows[$c]['per_codi'],					$ficha_medica->rows[$c]['tipo_persona'],
		$ficha_medica->rows[$c]['fmex_tipo_ficha'],
		$ficha_medica->rows[$c]['fmex_tabaco'],						$ficha_medica->rows[$c]['fmex_alcohol'],				$ficha_medica->rows[$c]['fmex_drogas'],
		$ficha_medica->rows[$c]['fmex_con_fisica'],					$ficha_medica->rows[$c]['fmex_act_sicomotora'],			$ficha_medica->rows[$c]['fmex_deambulacion'],
		$ficha_medica->rows[$c]['fmex_exp_verbal'],					$ficha_medica->rows[$c]['fmex_estado_nutricional'],		$ficha_medica->rows[$c]['fmex_estatura'],
		$ficha_medica->rows[$c]['fmex_peso'],						$ficha_medica->rows[$c]['fmex_temp_bucal'],				$ficha_medica->rows[$c]['fmex_pulso'],
		$ficha_medica->rows[$c]['fmex_presion_arterial'],			$ficha_medica->rows[$c]['fmex_piel'],					$ficha_medica->rows[$c]['fmex_ganglios'],
		$ficha_medica->rows[$c]['fmex_cabeza'],						$ficha_medica->rows[$c]['fmex_cuello'],					$ficha_medica->rows[$c]['fmex_ojos'],
		$ficha_medica->rows[$c]['fmex_oidos'],						$ficha_medica->rows[$c]['fmex_boca'],					$ficha_medica->rows[$c]['fmex_nariz'],
		$ficha_medica->rows[$c]['fmex_dentadura'],					$ficha_medica->rows[$c]['fmex_garganta'],				$ficha_medica->rows[$c]['fmex_corazon'],
		$ficha_medica->rows[$c]['fmex_torax'],						$ficha_medica->rows[$c]['fmex_pulmones'],				$ficha_medica->rows[$c]['fmex_mamas'],
		$ficha_medica->rows[$c]['fmex_higado'],						$ficha_medica->rows[$c]['fmex_ves_biliar'],				$ficha_medica->rows[$c]['fmex_bazo'],
		$ficha_medica->rows[$c]['fmex_estomago'],					$ficha_medica->rows[$c]['fmex_intestinos'],				$ficha_medica->rows[$c]['fmex_apendice'],
		$ficha_medica->rows[$c]['fmex_ano'],
		$ficha_medica->rows[$c]['fmex_umbilical'],					$ficha_medica->rows[$c]['fmex_rurales'],				$ficha_medica->rows[$c]['fmex_inguinal_derecha'],
		$ficha_medica->rows[$c]['fmex_inguinal_izquierda'],			$ficha_medica->rows[$c]['fmex_deformaciones'],			$ficha_medica->rows[$c]['fmex_masas_musculares'],
		$ficha_medica->rows[$c]['fmex_movibilidad'],				$ficha_medica->rows[$c]['fmex_puntos_dolorosos'],		$ficha_medica->rows[$c]['fmex_tracto_urinario'],
		$ficha_medica->rows[$c]['fmex_espermaquia'],				$ficha_medica->rows[$c]['fmex_tracto_genital_masculino'],
		$ficha_medica->rows[$c]['fmex_tracto_genital_femenino'],
		$ficha_medica->rows[$c]['fmex_menstruacion'],				$ficha_medica->rows[$c]['fmex_menarquia'],				$ficha_medica->rows[$c]['fmex_menapmia'],
		$ficha_medica->rows[$c]['fmex_gesta'],						$ficha_medica->rows[$c]['fmex_partos'],					$ficha_medica->rows[$c]['fmex_aborto'],
		$ficha_medica->rows[$c]['fmex_cesarea'],					$ficha_medica->rows[$c]['fmex_superior_derecha'],		$ficha_medica->rows[$c]['fmex_superior_izquierda'],
		$ficha_medica->rows[$c]['fmex_inferior_derecha'],			$ficha_medica->rows[$c]['fmex_inferior_izquierda'],		$ficha_medica->rows[$c]['fmex_ojo_derecho'],
		$ficha_medica->rows[$c]['fmex_ojo_izquierdo'],				$ficha_medica->rows[$c]['fmex_oido_derecho'],			$ficha_medica->rows[$c]['fmex_oido_izquierdo'],
		$ficha_medica->rows[$c]['fmex_reflex_tendinosos'],			$ficha_medica->rows[$c]['fmex_reflex_pupilares'],		$ficha_medica->rows[$c]['fmex_marcha'],
		$ficha_medica->rows[$c]['fmex_sens_superficial'],			$ficha_medica->rows[$c]['fmex_profunda_romberg'],		$ficha_medica->rows[$c]['fmex_estado_mental'],			
		$ficha_medica->rows[$c]['fmex_memoria'],					$ficha_medica->rows[$c]['fmex_irritabilidad'],			$ficha_medica->rows[$c]['fmex_depresion'],
		$ficha_medica->rows[$c]['fmex_aptitud_trabajo']);		
	return $data;
}
function constructor_formulario_med( 
	$data, 						$per, 					$per_ctrl = "",
	
	$fmex_codi,					$per_codi,				$tipo_persona = 0,
	$tipo_ficha = "OCU",
	$tabaco,					$alcohol,				$drogas,
	$con_fisica,				$act_sicomotora,		$deambulacion,
	$exp_verbal,				$estado_nutricional,	$estatura=0,
	$peso=0,					$temp_bucal=0,			$pulso=0,
	$presion_arterial=0,		$piel,					$ganglios,
	$cabeza,					$cuello,				$ojos,
	$oidos,						$boca,					$nariz,
	$dentadura,					$garganta,				$corazon,
	$torax,						$pulmones,				$mamas,
	$higado,					$ves_biliar,			$bazo,
	$estomago,					$intestinos,			$apendice,
	$ano,
	$umbilical,					$rurales,				$inguinal_derecha,
	$inguinal_izquierda,		$deformaciones,			$masas_musculares,
	$movibilidad,				$puntos_dolorosos,		$tracto_urinario,
	$espermaquia,				$tracto_genital_masculino,
	$tracto_genital_femenino,
	$menstruacion,				$menarquia,				$menapmia,
	$gesta,						$partos,				$aborto,
	$cesarea,					$superior_derecha,		$superior_izquierda,
	$inferior_derecha,			$inferior_izquierda,	$ojo_derecho,
	$ojo_izquierdo,				$oido_derecho,			$oido_izquierdo,
	$reflex_tendinoso,			$reflex_pupilares,		$marcha,
	$sens_superficial,			$profunda_romberg,		$estado_mental,
	$memoria,					$irritabilidad,			$depresion,
	$aptitud_trabajo,			$usua_ingr,				$ip )
{	
	global $diccionario;
	
	if( $per_ctrl == "" ) $per_ctrl = $per;
	
	/*-------------------------------------------------------------------------------------
		VARIABLES (Están al inicio de ficha_nuevo_formulario_med.php)
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_fmex_codi'] = $fmex_codi;
	$data[ $per_ctrl.'_tipo'] = $tipo_persona;
	$data[ $per_ctrl.'_codi'] = $per_codi;
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DEL NUEVO REPRESENTANTE
	  -------------------------------------------------------------------------------------*/
	
	/*$lat_opc = array();
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
													"selected"  => 	$lateralidad);*/
	
	
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS PERSONALES DE LA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$data[ $per_ctrl.'_con_fisica' ] = $con_fisica;
	$data[ $per_ctrl.'_act_sicomotora' ] = $act_sicomotora;
	$data[ $per_ctrl.'_deambulacion' ] = $deambulacion;
	$data[ $per_ctrl.'_exp_verbal' ] = $exp_verbal;
	$data[ $per_ctrl.'_estado_nutricional' ] = $estado_nutricional;
	$data[ $per_ctrl.'_estatura' ] = $estatura;
	$data[ $per_ctrl.'_peso' ] = $peso;
	$data[ $per_ctrl.'_temp_bucal' ] = $temp_bucal;
	$data[ $per_ctrl.'_pulso' ] = $pulso;
	$data[ $per_ctrl.'_presion_arterial' ] = $presion_arterial;
	
	$data[ $per_ctrl.'_piel' ] = $piel;
	$data[ $per_ctrl.'_ganglios' ] = $ganglios;
	$data[ $per_ctrl.'_cabeza' ] = $cabeza;
	$data[ $per_ctrl.'_cuello' ] = $cuello;
	$data[ $per_ctrl.'_ojos' ] = $ojos;
	$data[ $per_ctrl.'_oidos' ] = $oidos;
	$data[ $per_ctrl.'_boca' ] = $boca;
	$data[ $per_ctrl.'_nariz' ] = $nariz;
	$data[ $per_ctrl.'_dentadura' ] = $dentadura;
	$data[ $per_ctrl.'_garganta' ] = $garganta;
	
	$data[ $per_ctrl.'_corazon' ] = $corazon;
	$data[ $per_ctrl.'_torax' ] = $torax;
	$data[ $per_ctrl.'_pulmones' ] = $pulmones;
	$data[ $per_ctrl.'_mamas' ] = $mamas;
	$data[ $per_ctrl.'_higado' ] = $higado;
	$data[ $per_ctrl.'_ves_biliar' ] = $ves_biliar;
	$data[ $per_ctrl.'_bazo' ] = $bazo;
	$data[ $per_ctrl.'_estomago' ] = $estomago;
	$data[ $per_ctrl.'_intestinos' ] = $intestinos;
	$data[ $per_ctrl.'_apendice' ] = $apendice;
	$data[ $per_ctrl.'_ano' ] = $ano;
	
	
	$data[ $per_ctrl.'_umbilical' ] = $umbilical;
	$data[ $per_ctrl.'_rurales' ] = $rurales;
	$data[ $per_ctrl.'_inguinal_derecha' ] = $inguinal_derecha;
	$data[ $per_ctrl.'_inguinal_izquierda' ] = $inguinal_izquierda;
	$data[ $per_ctrl.'_deformaciones' ] = $deformaciones;
	$data[ $per_ctrl.'_masas_musculares' ] = $masas_musculares;
	$data[ $per_ctrl.'_movibilidad' ] = $movibilidad;
	$data[ $per_ctrl.'_puntos_dolorosos' ] = $puntos_dolorosos;
	$data[ $per_ctrl.'_tracto_urinario' ] = $tracto_urinario;
	
	$data[ $per_ctrl.'_espermaquia' ] = $espermaquia;
	$data[ $per_ctrl.'_tracto_genital_masculino' ] = $tracto_genital_masculino;
	$data[ $per_ctrl.'_tracto_genital_femenino' ] = $tracto_genital_femenino;
	$data[ $per_ctrl.'_menstruacion' ] = $menstruacion;
	$data[ $per_ctrl.'_menarquia' ] = $menarquia;
	$data[ $per_ctrl.'_menapmia' ] = $menapmia;
	$data[ $per_ctrl.'_gesta' ] = $gesta;
	$data[ $per_ctrl.'_partos' ] = $partos;
	$data[ $per_ctrl.'_aborto' ] = $aborto;
	$data[ $per_ctrl.'_cesarea' ] = $cesarea;
	
	$data[ $per_ctrl.'_superior_derecha' ] = $superior_derecha;
	$data[ $per_ctrl.'_superior_izquierda' ] = $superior_izquierda;
	$data[ $per_ctrl.'_inferior_derecha' ] = $inferior_derecha;
	$data[ $per_ctrl.'_inferior_izquierda' ] = $inferior_izquierda;
	$data[ $per_ctrl.'_ojo_derecho' ] = $ojo_derecho;
	$data[ $per_ctrl.'_ojo_izquierdo' ] = $ojo_izquierdo;
	$data[ $per_ctrl.'_oido_derecho' ] = $oido_derecho;
	$data[ $per_ctrl.'_oido_izquierdo' ] = $oido_izquierdo;
	
	$data[ $per_ctrl.'_marcha' ] = $marcha;
	$data[ $per_ctrl.'_sens_superficial' ] = $sens_superficial;
	$data[ $per_ctrl.'_profunda_romberg' ] = $profunda_romberg;
	$data[ $per_ctrl.'_estado_mental' ] = $estado_mental;
	$data[ $per_ctrl.'_memoria' ] = $memoria;
	$data[ $per_ctrl.'_irritabilidad' ] = $irritabilidad;
	$data[ $per_ctrl.'_depresion' ] = $depresion;
	
	$data[ $per_ctrl.'_aptitud_trabajo' ] = $aptitud_trabajo;
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS EN FORMATO RADIO BUTTON
	  -------------------------------------------------------------------------------------*/
	  
	if( $tabaco== 'S' )
	{   $data[ 'per_tabaco_si' ] = " checked ";
		$data[ 'per_tabaco_no' ] = " ";
	}
	else
	{   $data[ 'per_tabaco_si' ] = " ";
		$data[ 'per_tabaco_no' ] = " checked ";
	}
	if( $alcohol== 'S' )
	{   $data[ 'per_alcohol_si' ] = " checked ";
		$data[ 'per_alcohol_no' ] = " ";
	}
	else
	{   $data[ 'per_alcohol_si' ] = " ";
		$data[ 'per_alcohol_no' ] = " checked ";
	}
	if( $drogas == 'S' )
	{   $data[ 'per_drogas_si' ] = " checked ";
		$data[ 'per_drogas_no' ] = " ";
	}
	else
	{   $data[ 'per_drogas_si' ] = " ";
		$data[ 'per_drogas_no' ] = " checked ";
	}
	
	if( empty( $tipo_ficha ) )
	{   $data[ 'per_tipo_ficha_pre' ] = "";
		$data[ 'per_tipo_ficha_ocu' ] = " checked ";
		$data[ 'per_tipo_ficha_post' ] = "";
	}
	else
	{   if( $tipo_ficha == 'OTRO' )
			$data[ 'per_tipo_ficha_otro' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_otro' ] = " ";
		
		if( $tipo_ficha == 'PRE' )
			$data[ 'per_tipo_ficha_pre' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_pre' ] = " ";
		
		if( $tipo_ficha == 'OCU' )
			$data[ 'per_tipo_ficha_ocu' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_ocu' ] = " ";
		
		if( $tipo_ficha == 'POST' )
			$data[ 'per_tipo_ficha_post' ] = " checked ";
		else
			$data[ 'per_tipo_ficha_post' ] = " ";
	}
	
	if( empty( $reflex_tendinoso ) )
		$data[ 'per_reflex_tendinoso_normal' ] = " checked ";
	else
	{   if( $reflex_tendinoso== 'A' )
			$data[ 'per_reflex_tendinoso_a' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_a' ] = " ";
		if( $reflex_tendinoso == 'HIPO' )
			$data[ 'per_reflex_tendinoso_hipo' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_hipo' ] = " ";
		if( $reflex_tendinoso == 'NORMAL' )
			$data[ 'per_reflex_tendinoso_normal' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_normal' ] = " ";
		if( $reflex_tendinoso == 'HIPER' )
			$data[ 'per_reflex_tendinoso_hiper' ] = " checked ";
		else
			$data[ 'per_reflex_tendinoso_hiper' ] = " ";
		
	}
	
	if( empty( $reflex_pupilares ) )
		$data[ 'per_reflex_pupilares_normal' ] = " checked ";
	else
	{   if( $reflex_pupilares == 'A' )
			$data[ 'per_reflex_pupilares_a' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_a' ] = " ";
		if( $reflex_pupilares == 'HIPO' )
			$data[ 'per_reflex_pupilares_hipo' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_hipo' ] = " ";
		if( $reflex_pupilares == 'NORMAL' )
			$data[ 'per_reflex_pupilares_normal' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_normal' ] = " ";
		if( $reflex_pupilares == 'HIPER' )
			$data[ 'per_reflex_pupilares_hiper' ] = " checked ";
		else
			$data[ 'per_reflex_pupilares_hiper' ] = " ";
	}
	
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE TRABAJO DE LA NUEVA PERSONA
	  -------------------------------------------------------------------------------------*/
	
	$alergia = new Ficha_medica();
	$alergia->get_alergia( $fmex_codi );
	//QUEMADO DIV_SHOW_RESULT con div_tbl_alergia
	
		//FASE. Editar funciona. sólo es de editar el procedimiento para que actualice en vez de insertar un nuevo registro.
	/*$opciones["Editar"] = "<span onclick='js_ficha_add_alergia(\"div_tbl_alergia\",\"".$per.
										"\",\"{codigo}\")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' id='{codigo}_editar' ".
										" onmouseover='$(this).tooltip(\"show\")' title='Editar' data-placement='left'></span>&nbsp;";*/
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_alergia(\"div_tbl_alergia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_alergia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_alergia",
												"name"		=> $per."_tbl_alergia",
												"datos"     => $alergia->rows,
												"encabezado"=> array("Referencia",
																	  "Alergia",
																	  "Reacción",
																	  "Alergia Referencia",
																	  "Alergia Tipo",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_ale_codi");
	$vacuna = new Ficha_medica();
	$vacuna->get_vacuna( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_vacuna(\"div_tbl_vacuna\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_vacuna}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_vacuna",
												"name"		=> $per."_tbl_vacuna",
												"datos"     => $vacuna->rows,
												"encabezado"=> array("Referencia",
																	  "Vacuna",
																	  "Fecha",
																	  "Reacción",
																	  "Tipo",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_vac_codi");
	$enfermedad = new Ficha_medica();
	$enfermedad->get_enfermedad( $fmex_codi,'T' );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_enfermedad(\"div_tbl_enfermedad\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\",\"T\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_enfermedad}"]= array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_enfermedad",
													"name"		=> $per."_tbl_enfermedad",
													"datos"     => $enfermedad->rows,
													"encabezado"=> array( "Referencia",
																		  "Enfermedad",
																		  "Tiene",
																		  "Tuvo",
																		  "Tratamiento",
																		  "Descr. Tratamiento",
																		  "Enf. referencia",
																		  ""),
													"options"   => array( $opciones ),
													"campo"  	=> "fmex_enf_codi");
	$enfermedad = new Ficha_medica();
	$enfermedad->get_enfermedad( $fmex_codi,'F' );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_enfermedad(\"div_tbl_enfermedad_familia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\",\"F\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_enfermedad_familia}"]= array( "elemento"  => "tabla",
													"clase" 	=> "table table-striped table-bordered",
													"id"		=> $per."_tbl_enfermedad_familia",
													"name"		=> $per."_tbl_enfermedad_familia",
													"datos"     => $enfermedad->rows,
													"encabezado"=> array( "Referencia",
																		  "Enfermedad",
																		  "Tiene",
																		  "Tuvo",
																		  "Tratamiento",
																		  "Parentesco",
																		  "Observaciones",
																		  "Enf. referencia",
																		  ""),
													"options"   => array( $opciones ),
													"campo"  	=> "fmex_enf_codi");
	$cirugia = new Ficha_medica();
	$cirugia->get_cirugia( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_cirugia(\"div_tbl_cirugia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_cirugia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_cirugia",
												"name"		=> $per."_tbl_cirugia",
												"datos"     => $cirugia->rows,
												"encabezado"=> array( "Referencia",
																	  "Cirugía",
																	  "Fecha",
																	  "Localización",
																	  "Extensión",
																	  "Propósito",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_cir_codi");
															
	$ex_lab_clinico = new Ficha_medica();
	$ex_lab_clinico->get_ex_lab_clinico( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_ex_lab_clinico(\"div_tbl_ex_lab_clinico\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_ex_lab_clinico}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_ex_lab_clinico",
												"name"		=> $per."_tbl_ex_lab_clinico",
												"datos"     => $ex_lab_clinico->rows,
												"encabezado"=> array("Referencia",
																	  "Examen",
																	  "Resultado",
																	  "Fecha",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_lab_codi");
	
	$radiografia = new Ficha_medica();
	$radiografia->get_radiografia( $fmex_codi );
	$opciones["Eliminar"] = "<span onclick='js_ficha_del_radiografia(\"div_tbl_radiografia\",\"".$fmex_codi."\",\"".$per.
								"\",\"{codigo}\")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' ".
								" onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>";
	$data["{div_resultado_tbl_radiografia}"]=array( "elemento"  => "tabla",
												"clase" 	=> "table table-striped table-bordered",
												"id"		=> $per."_tbl_radiografia",
												"name"		=> $per."_tbl_radiografia",
												"datos"     => $radiografia->rows,
												"encabezado"=> array("Referencia",
																	  "Radiografía",
																	  "Fecha de la radiografía",
																	  "Localización",
																	  ""),
												"options"   => array( $opciones ),
												"campo"  	=> "fmex_rad_codi");
	$data['per'] = $per;
	return $data;
}
function constructor_alergia_per( $data, $per, $per_ctrl = "", $fmex_ale_codi, $ale_tipo="0", $ale_nombre="0", $ale_desc_reaccion )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE ALERGIA
	  -------------------------------------------------------------------------------------*/
	
	$alergia = new Alergia();
	$alergia->get_tipo_SelectFormat( -1 );
	$data['{cmb_alergia_tipo}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$alergia->rows, 
											"options"   => 	array(	"name"		=>"cmb_ale_tipo_".$per,
																	"id"		=>"cmb_ale_tipo_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>"js_alergia_cargaAlergia_SelectFormat('div_cmb_ale_nombre','cmb_ale_".$per."',this.value);"),
											"selected"  => 	$ale_tipo);
	$alergia2 = new Alergia();
	$alergia2->get_subtipo_SelectFormat( -1, $ale_tipo );
	$data['{cmb_alergia_nombre}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$alergia2->rows, 
											"options"   => 	array(	"name"		=>"cmb_ale_".$per,
																	"id"		=>"cmb_ale_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$ale_nombre);
	$data[ $per_ctrl.'_ale_reaccion']  = $ale_desc_reaccion;
	$data[ $per_ctrl.'_fmex_ale_codi'] = $fmex_ale_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_vacuna_per( $data, $per, $per_ctrl = "", $fmex_vac_codi, $vac_nombre="0", $vac_fecha='', $vac_desc )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE VACUNA
	  -------------------------------------------------------------------------------------*/

	$vacuna = new Vacuna();
	$vacuna->get_tipo_SelectFormat( -1 );
	$data['{cmb_vacuna_nombre}'] = array( "elemento"  => 	"combo", 
											"datos"     => 	$vacuna->rows, 
											"options"   => 	array(	"name"		=>"cmb_vac_".$per,
																	"id"		=>"cmb_vac_".$per,
																	"required"	=>"required",
																	"class"		=>"form-control",
																	"onChange"	=>""),
											"selected"  => 	$vac_nombre);
	$data[ $per_ctrl.'_vac_fecha']  = $vac_fecha;
	$data[ $per_ctrl.'_vac_desc']  = $vac_desc;
	$data[ $per_ctrl.'_fmex_vac_codi'] = $fmex_vac_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_enfermedad_per( $data, $titular = "T" , $per, $per_ctrl = "", $fmex_enf_codi, $enf_nombre="0",
									$enf_tiene="", $enf_tuvo="", $_enf_tratamiento="", $enf_desc_tratamiento="", $enf_parentesco="0" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE ENFERMEDAD
	  -------------------------------------------------------------------------------------*/
	
	$enfermedad = new Enfermedad();
	$enfermedad->get_tipo_SelectFormat( -1 );
	$data['{cmb_enfermedad_nombre}']=array( "elemento"  => 	"combo",
											"datos"     => 	$enfermedad->rows,
											"options"   => 	array(	"name"		=> "cmb_enf_".$per,
																	"id"		=> "cmb_enf_".$per,
																	"required"	=> "required",
																	"class"		=> "form-control",
																	"style"		=> "width: 100%;",
																	"onChange"	=> ""),
											"selected"  => 	$enf_nombre );
	$parentesco = new catalogo();
	$parentesco->get_all_sons( 2 );
	$data['{cmb_enfermedad_parentesco}']=array( "elemento"  => 	"combo",
												"datos"     => 	$parentesco->rows,
												"options"   => 	array(	"name"		=>"cmb_enf_parentesco_".$per,
																		"id"		=>"cmb_enf_parentesco_".$per,
																		"required"	=>"required",
																		"class"		=>'form-control input-sm',
																		"onChange"	=> $enf_parentesco ),
												"selected"  => 	0 );
	$data['titular'] = $titular;
	
	if ( $titular == 'F' ) 
		$data['display_div_enf_parentesco'] = " style='display:inline;' ";
	else
		$data['display_div_enf_parentesco'] = " style='display:none;' ";
	
	if( $enf_tiene == 'S' )
		$data[ $per_ctrl.'_enf_tiene']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tiene']  = "";
	
	if( $enf_tuvo == 'S' )
		$data[ $per_ctrl.'_enf_tuvo']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tuvo']  = "";
	
	if( $_enf_tratamiento == 'S' )
		$data[ $per_ctrl.'_enf_tratamiento']  = " checked ";
	else
		$data[ $per_ctrl.'_enf_tratamiento']  = "";
	
	$data[ $per_ctrl.'_enf_desc_tratamiento']  = $enf_desc_tratamiento;
	$data[ $per_ctrl.'_fmex_enf_codi'] = $fmex_enf_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_cirugia_per( $data, $per, $per_ctrl = "", $fmex_cir_codi, $cir_nombre_desc="",
									$cir_fecha="", $cir_localizacion="", $cir_extension="", $cir_proposito="" )
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE CIRUGIA
	  -------------------------------------------------------------------------------------*/
	
	if( $cir_localizacion == 'S' )
		$data[ $per_ctrl.'_cir_localizacion']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_localizacion']  = "";
	
	if( $cir_extension == 'S' )
		$data[ $per_ctrl.'_cir_extension']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_extension']  = "";
	
	if( $cir_proposito == 'S' )
		$data[ $per_ctrl.'_cir_proposito']  = " checked ";
	else
		$data[ $per_ctrl.'_cir_proposito']  = "";
	
	$data[ $per_ctrl.'_cir_fecha']  = $cir_fecha;
	$data[ $per_ctrl.'_cir_nombre_desc'] = $cir_nombre_desc;
	$data[ $per_ctrl.'_fmex_cir_codi'] = $fmex_cir_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_radiografia_per( $data, $per, $per_ctrl = "", $fmex_rad_codi, $rad_nombre_desc="",
									$rad_fecha="", $rad_localizacion="")
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE RADIOGRAFÍA
	  -------------------------------------------------------------------------------------*/
	  
	$data[ $per_ctrl.'_rad_nombre_desc'] = $rad_nombre_desc;
	$data[ $per_ctrl.'_rad_fecha']  = $rad_fecha;
	$data[ $per_ctrl.'_rad_localizacion'] = $rad_localizacion;
	$data[ $per_ctrl.'_fmex_rad_codi'] = $fmex_rad_codi;
	$data['per'] = $per;
	return $data;
}
function constructor_ex_lab_clinico_per( $data, $per, $per_ctrl = "", $fmex_lab_codi, $lab_codi="",
									$lab_resultado="", $lab_fecha="")
{
	/*-------------------------------------------------------------------------------------
		BLANQUEANDO DATOS DE EXÁMENES DE LABORATORIOS CLÍNICOS
	  -------------------------------------------------------------------------------------*/
	$ex_lab_clinico = new Ex_Lab_Clinico();
	$ex_lab_clinico->get_tipo_SelectFormat( -1 );
	$data['{cmb_ex_lab_clinico_nombre}']=array( "elemento"  => 	"combo",
												"datos"     => 	$ex_lab_clinico->rows,
												"options"   => 	array(	"name"		=>"cmb_lab_".$per,
																		"id"		=>"cmb_lab_".$per,
																		"required"	=>"required",
																		"class"		=>"form-control",
																		"onChange"	=>""),
												"selected"  => 	$lab_codi);
	$data[ $per_ctrl.'_lab_fecha']  = $lab_fecha;
	$data[ $per_ctrl.'_lab_resultado'] = $lab_resultado;
	$data[ $per_ctrl.'_fmex_lab_codi'] = $fmex_lab_codi;
	$data['per'] = $per;
	return $data;
}