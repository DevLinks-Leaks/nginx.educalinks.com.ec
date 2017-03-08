<?php
session_start();
include("../../../framework/dbconf_main.php");
require_once('../../../Framework/funciones.php');
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
require_once('../../common/persona/model.php');
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
    $event 			= get_actualEvents( array( VIEW_GET_ALL, VIEW_FORMULARIO_MED, PRINT_FICHA_MED_PDF ), VIEW_GET_ALL );
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
		case GET_FICHA_MED_LISTADO_INDIVIDUAL:
			global $diccionario;
			$ficha_medica = new Ficha_medica();
			$ficha_medica->get_ficha_medica_listado( $_POST['fmex_codi'],$_POST['alum_codi'],$_POST['tipo_ficha'] );
			if( ( count( $ficha_medica->rows ) ) > 0 )
			{	$opciones['Editar'] = 	" <button type='button' onclick='js_ficha_med_formulario_pdf( \"modal_ficha_med_print_pdf_result\" , \"{codigo}\",".'"'.$diccionario['rutas_head']['ruta_html_medic'].'/ficha_nuevo/controller.php"'.")' ".
										" 	class='btn btn-default' aria-hidden='true' id='{codigo}_pdf' " .
											" onmouseover='$(this).tooltip(\"show\")' title='Ver PDF' data-placement='left'><i style='color:red;' class='fa fa-file-pdf-o' ></i></button>";
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
		case GET_FICHA_MED_LISTADO:
			global $diccionario;
			$ficha_medica = new Ficha_medica();
			$ficha_medica->get_ficha_medica_listado( );
			if( ( count( $ficha_medica->rows ) ) > 0 )
			{	$opciones['Editar'] = 	" <button type='button' onclick='js_ficha_med_formulario_edit( \"span_button_save_medical_record\" ,".
										"	\"div_ficha_med_bandeja_consulta\", \"fmex\", \"{codigo}\" )' ".
										" 	aria-hidden='true' id='{codigo}_editar' ".
											" class='btn btn-default' onmouseover='$(this).tooltip(\"show\")' title='Editar ficha' data-placement='left'>
												<span class='btn_opc_lista_editar glyphicon glyphicon-pencil'></span></button>&nbsp;".
										" <button type='button' onclick='js_ficha_med_formulario_pdf( \"modal_ficha_med_print_pdf_result\" , \"{codigo}\",".'"'.$diccionario['rutas_head']['ruta_html_medic'].'/ficha_nuevo/controller.php"'.")' ".
										" 	class='btn btn-default' aria-hidden='true' id='{codigo}_pdf' " .
											" onmouseover='$(this).tooltip(\"show\")' title='Ver PDF' data-placement='left'><i style='color:red;' class='fa fa-file-pdf-o' ></i></button>";
				/*data-toggle='modal' data-target='#modal_ficha_med_print_pdf'*/
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
		case PRINT_FICHA_MED_PDF:
			global $diccionario;
			
			$v_domain = explode( '.', $domain );
			$ficha_medica->get_ficha_medica_PDF( $user_data['fmex_codi'] );
			
			if( ( count( $ficha_medica->rows )-1 )>0 )
			{	$data = sub_constructor_formulario_med_pdf( $ficha_medica, '0', $data, 'fmex', 'per' );
			}
			else
			{   $data[ 'PDF' ]=  "No se encontraron resultados";
			}
			
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='ficha_medica_".$user_data['fmex_codi'].".pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Ficha medica");
			$pdf->SetSubject("Ficha medica");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 8, '', 'false');
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			
			$pdf->Image( $_SESSION['dir_logo_cliente'], 'C', 15, '', 10, 'PNG', '', 'C', false, 300, 'C', false, false, 0, false, false, false);
			
			$datosInst = new General();
			$datosInst->getDatosInstitucion_info();
			
			$tipo_ficha = "";
			
			if( empty( $ficha_medica->rows[$c]['fmex_tipo_ficha'] ) )
			{   $tipo_ficha = 'OCUPACIONAL';
			}
			else
			{   if( $ficha_medica->rows[$c]['fmex_tipo_ficha'] == 'OTRO' )
					$tipo_ficha = 'GENARAL';
				
				if( $ficha_medica->rows[$c]['fmex_tipo_ficha'] == 'PRE' )
					$tipo_ficha = 'PRE-OCUPACIONAL';
				
				if( $ficha_medica->rows[$c]['fmex_tipo_ficha'] == 'OCU' )
					$tipo_ficha = 'OCUPACIONAL';
				
				if( $ficha_medica->rows[$c]['fmex_tipo_ficha'] == 'POST' )
					$tipo_ficha = 'POST-OCUPACIONAL';
			}
			
			$html = ' 
                     <table border="0" >
						<tr style="text-align:center;">
                          <td width="30%" style="text-align:left;vertical-align:top;">
							<span style="font-size:10px;"><strong>'.$datosInst->rows[0]['empr_razonSocial'].'</strong></span><br>
							<span style="font-size:10px;"><strong>RUC:</strong> '.$datosInst->rows[0]['empr_ruc'].'</span><br>
							<span style="font-size:10px;"><strong>Dirección:</strong> '.$datosInst->rows[0]['empr_direccionMatriz'].'</span><br>
							<span style="font-size:10px;"><strong>Telf.:</strong> '.$datosInst->rows[0]['empr_contactoTelefono'].'</span>
						  </td>
						  <td width="40%" style="vertical-align:top;"><strong>FICHA MEDICA<BR>'.$tipo_ficha.'</strong></td>
						  <td width="30%" style="text-align:right;vertical-align:top;font-size:10px;"><strong>'.$desc_periodo.'</strong>
							<br>
							'.str_replace( 'Fecha','<br>Fecha',print_usua_info() ).'
						  </td>
                        </tr>
                     </table></br><div /></br>'; //print_usua_info es llamado desde funciones.php.
			
			$html .= $data[ 'PDF' ];
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('ficha_medica_'.$user_data['fmex_codi'].'.pdf', 'I');
			break;
        default:
			echo "default";
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
		$ficha_medica->rows[$c]['fmex_tipo_ficha'],					$ficha_medica->rows[$c]['nombre'],
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
	$tipo_ficha = "OCU",		$paciente_nombre,
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
	
	if ( $paciente_nombre == "" )
		$data[ 'per_paciente_nombre' ] = "";
	else
		$data[ 'per_paciente_nombre' ] = '<br>PACIENTE: '.$paciente_nombre;
	
	if( empty( $reflex_tendinoso ) )
		$data[ 'per_reflex_tendinoso_normal' ] = " checked ";
	else
	{   if( $reflex_tendinoso == 'A' )
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
/*
	--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		UPDATE - 05701/2017. PDF DE FICHA MEDICA
	--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/
function sub_constructor_formulario_med_pdf( $ficha_medica, $c, $data, $per, $per_ctrl )
{   $data[ 'PDF' ] = "";
	
	$label_conclusiones = "";
	
	if ( $ficha_medica->rows[$c]['nombre'] == 3 )
		$label_conclusiones = "CONCLUSIONES/APTITUD PARA EL TRABAJO";
	else
		$label_conclusiones = "CONCLUSIONES";
	
	/* 	-------------------------
		ANTECEDENTES PERSONALES 
		------------------------- */
	$foto = '-SIN IMAGEN-';
	
	/*if( $solicitud->rows[0]['soli_foto'] != "")
	{   $soli_foto = '../../../documentos/solicitudes_fotos/'.$solicitud->rows[0]['soli_codi'].'/'.$solicitud->rows[0]['soli_foto'];
		if(file_exists($soli_foto))
		{   $foto = '<div><img src="'.utf8_encode($soli_foto).'" style="max-width:75%;max-height:100%;"></div>';
		}
		else
			$foto = '-SIN IMAGEN-';
	}
	else
		$foto = ' FOTO ';
				
	$data[ 'PDF' ] .= '<table align="center"><tr><td colspan="12"><b>DATOS PERSONALES</b></td></tr></table>';
	
	$data[ 'PDF' ] .='<table cellspacing="0" cellpadding="2" border="1" width="100%">';
	$data[ 'PDF' ] .='<tr><td colspan="10"><b>Nombre y Apellido:</b> '. $ficha_medica->rows[$c]['nombre'] .'</td>
				 <td colspan="2" rowspan="8" style="text-align:center;">'.$foto.'</td></tr>';
	$data[ 'PDF' ] .='	<tr><td width="50%" colspan="5"><b>Tipo ID.:</b> '. $ficha_medica->rows[$c]['per_tipo_id'] .'</td>
							<td width="33.3%" colspan="5"><b>ID:</b> ' . $ficha_medica->rows[$c]['per_id'] . '</td></tr>
						<tr><td colspan="5"><b>Código sistema:</b> '. $ficha_medica->rows[$c]['per_codi'] .'</td>
							<td colspan="5"><b>Género:</b> '. $ficha_medica->rows[$c]['per_genero'] .'</td></tr>
						<tr><td colspan="5"><b>Dirección:</b> '. $ficha_medica->rows[$c]['per_dir_personal'] .'</td>
							<td colspan="5"><b>Teléfono:</b> ' . $ficha_medica->rows[$c]['cont_det_numero'] . '</td></tr>
						<tr><td colspan="5"><b>E-mail:</b> '. $ficha_medica->rows[$c]['per_email_personal'] .'</td>
							<td colspan="5"><b>Fecha de nacimiento:</b> ' . $ficha_medica->rows[$c]['per_fecha_nac'] . '</td></tr>';
	
	if ( $ficha_medica->rows[$c]['tipo_persona'] <> 1 )
	{	$data[ 'PDF' ] .='
						<tr><td colspan="5"><b>Profesión:</b> '. $ficha_medica->rows[$c]['per_profesion'] .'</td>
							<td colspan="5"><b>Estado civil:</b> ' . $ficha_medica->rows[$c]['per_estado_civil'] . '</td></tr>
						<tr><td colspan="5"><b>Ingreso mensual:</b> '. $ficha_medica->rows[$c]['per_ingreso_mensual'] .'</td>
							<td colspan="5"><b>Num. de hijos:</b> ' . $ficha_medica->rows[$c]['per_num_hijos'] . '</td></tr>';
	}
	*/
	
	$data[ 'PDF' ] .= '<table align="center"><tr><td colspan="12"><b>DATOS PERSONALES</b></td></tr></table>';
	
	$data[ 'PDF' ] .='<table cellspacing="0" cellpadding="2" border="1" width="100%">';
	$data[ 'PDF' ] .='<tr><td colspan="12"><b>Nombre completo:</b> '. $ficha_medica->rows[$c]['nombre'] .'</td></tr>';
	$data[ 'PDF' ] .='	<tr><td width="50%" colspan="6"><b>Tipo ID.:</b> '. $ficha_medica->rows[$c]['per_tipo_id'] .'</td>
							<td colspan="6"><b>ID:</b> ' . $ficha_medica->rows[$c]['per_id'] . '</td></tr>
						<tr><td colspan="6"><b>Código sistema:</b> '. $ficha_medica->rows[$c]['per_codi'] .'</td>
							<td colspan="6"><b>Género:</b> '. $ficha_medica->rows[$c]['per_genero'] .'</td></tr>
						<tr><td colspan="6"><b>Dirección:</b> '. $ficha_medica->rows[$c]['per_dir_personal'] .'</td>
							<td colspan="6"><b>Teléfono:</b> ' . $ficha_medica->rows[$c]['cont_det_numero'] . '</td></tr>
						<tr><td colspan="6"><b>E-mail:</b> '. $ficha_medica->rows[$c]['per_email_personal'] .'</td>
							<td colspan="6"><b>Fecha de nacimiento:</b> ' . $ficha_medica->rows[$c]['per_fecha_nac'] . '</td></tr>';
	
	if ( $ficha_medica->rows[$c]['tipo_persona'] <> 1 )
	{	$data[ 'PDF' ] .='
						<tr><td colspan="6"><b>Profesión:</b> '. $ficha_medica->rows[$c]['per_profesion'] .'</td>
							<td colspan="6"><b>Estado civil:</b> ' . $ficha_medica->rows[$c]['per_estado_civil'] . '</td></tr>
						<tr><td colspan="6"><b>Ingreso mensual:</b> '. $ficha_medica->rows[$c]['per_ingreso_mensual'] .'</td>
							<td colspan="6"><b>Num. de hijos:</b> ' . $ficha_medica->rows[$c]['per_num_hijos'] . '</td></tr>';
	}
	
	$data[ 'PDF' ] .='
						<tr><td colspan="6"></td>
							<td colspan="6"><b>Lateralidad:</b> ' . $ficha_medica->rows[$c]['per_lateralidad'] . '</td></tr>
					</table>
					<br>
					<table cellspacing="0" cellpadding="2" border="1" width="100%">
						<tr><td colspan="12"><b>DATOS NACIONALIDAD</b></td></tr>
						<tr><td colspan="6"><b>Pais Nacionalidad:</b> '. $ficha_medica->rows[$c]['per_pais_nacionalidad'] .'</td>
							<td colspan="6"><b>Provincia:</b> ' . $ficha_medica->rows[$c]['per_provincia'] . '</td></tr>
						<tr><td colspan="6"><b>Ciudad:</b> '. $ficha_medica->rows[$c]['per_ciudad'] .'</td>
							<td colspan="6"></td></tr>
						<tr><td colspan="12"><b>DATOS RESIDENCIA</b></td></tr>
						<tr><td colspan="6"><b>Pais residencia:</b> '. $ficha_medica->rows[$c]['per_pais_residencia'] .				'</td>
							<td colspan="6"><b>Provincia:</b> ' . $ficha_medica->rows[$c]['per_provincia_residencia'] . 			'</td></tr>
						<tr><td colspan="6"><b>Ciudad:</b> '. $ficha_medica->rows[$c]['per_ciudad_residencia'] .'</td>
							<td colspan="6"><b>Parroquia:</b> ' . $ficha_medica->rows[$c]['per_parroquia_residencia'] . 			'</td></tr>
						<tr><td colspan="6"><b>Vive en casa propia:</b> '. $ficha_medica->rows[$c]['per_vive_en_casa_propia'] .		'</td>
							<td colspan="6"><b>Tiempo de reidencia:</b> ' . $ficha_medica->rows[$c]['per_tiempo_de_recidencia'] .	'</td></tr>
					</table>
					<br>';
	if ( $ficha_medica->rows[$c]['tipo_persona'] == 3)
	{	$data[ 'PDF' ] .= '<br><table align="center"><tr><td colspan="12"><b>DATOS DE EMPLEADO</b></td></tr></table>';
		
		$data[ 'PDF' ] .='
					<table cellspacing="0" cellpadding="2" border="1" width="100%">
						<tr><td colspan="12"><b>DATOS DE EMPLEADO</b></td></tr>
						
						<tr><td colspan="6"><b>Código empleado:</b> '. $ficha_medica->rows[$c]['empl_codi'] .'</td>
							<td colspan="6"><b>Tipo empleado:</b> ' . $ficha_medica->rows[$c]['empl_tipo_empleado'] . '</td></tr>
						<tr><td colspan="6"><b>Área:</b> '. $ficha_medica->rows[$c]['empl_area'] .'</td>
							<td colspan="6"><b>Depto.:</b> ' . $ficha_medica->rows[$c]['empl_dpto'] . '</td></tr>
						<tr><td colspan="6"><b>Cargo:</b> '. $ficha_medica->rows[$c]['empl_cargo'] .'</td>
							<td colspan="6"><b>Jornada:</b> ' . $ficha_medica->rows[$c]['empl_jornada'] . '</td></tr>
						<tr><td colspan="6"><b>Fecha inicio contrato:</b> '. $ficha_medica->rows[$c]['empl_fini_contrato'] .'</td>
							<td colspan="6"><b>Fecha fin contrato:</b> ' . $ficha_medica->rows[$c]['empl_ffin_contrato'] . '</td></tr>
						<tr><td colspan="6"><b>Horario entrada:</b> '. $ficha_medica->rows[$c]['empl_turno_ini'] .'</td>
							<td colspan="6"><b>Horario salida:</b> ' . $ficha_medica->rows[$c]['empl_turno_fin'] . '</td></tr>
						<tr><td colspan="6"><b>Extensión:</b> '. $ficha_medica->rows[$c]['empl_ext'] .'</td>
							<td colspan="6"><b>Correo institucional:</b> ' . $ficha_medica->rows[$c]['empl_email_inst'] . '</td></tr>
					</table>
					<br>';
		
		$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ELEMENTOS DE PROTECCIÓN PARA TRABAJO ACTUAL</b></td></tr></table>';
		
		$ele_protex = new Persona();
		$ele_protex->get_ele_protex( $ficha_medica->rows[$c]['per_codi'] );
		
		if ( count($ele_protex->rows)-1 > 0) 
		{	
			$data["PDF"] .= '
						<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">';
			foreach( $ele_protex->rows as $row )
			{	if ( !empty( $row ) )
				{	$data["PDF"] .='
								<tr align="left">
									<td>'.$row['ele_protex_nombre'].'</td>
								</tr>';
				}
			}
			$data[ 'PDF' ] .= '</table><br>';
		}
		else
			$data[ 'PDF' ] .= '<p style="font-size:small;">(sin elemntos de protección)</p>';
		
		$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>DATOS LABORALES</b></td></tr></table>';
			
		$datos_lab = new Persona();
		$datos_lab->get_datos_laborales( $ficha_medica->rows[$c]['per_codi'] );
		
		if ( count($datos_lab->rows)-1 > 0) 
		{	
			$data["PDF"] .= '
						<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Nombre empresa</b></td>'.
								'<td><b>RUC</b></td>'.
								'<td><b>Cargo</b></td>'.
								'<td><b>Telf.</b></td>'.
								'<td><b>Mail</b></td>
							</tr>';
			foreach( $datos_lab->rows as $row )
			{	if ( !empty( $row ) )
				{	$data["PDF"] .='
								<tr align="center">
									<td>'.$row['inst_nombre'].'</td>
									<td>'.$row['inst_ruc'].'</td>
									<td>'.$row['per_inst_cargo'].'</td>
									<td>'.$row['cont_det_numero'].'</td>
									<td>'.$row['per_inst_email_inst'].'</td>
								</tr>';
				}
			}
			$data[ 'PDF' ] .= '</table><br>';
		}
		else
			$data[ 'PDF' ] .= '<p style="font-size:small;">(sin datos laborales)</p>';
		
		$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ACTIVIDADES  EXTRALABORALES</b></td></tr></table>';
		
		$act_ext = new Persona();
		$act_ext->get_actividad_extra( $ficha_medica->rows[$c]['per_codi'] );
		
		if ( count($act_ext->rows)-1 > 0) 
		{	
			$data["PDF"] .= '
						<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">';
			foreach( $act_ext->rows as $row )
			{	if ( !empty( $row ) )
				{	$data["PDF"] .='
								<tr align="center">
									<td>'.$row['per_act_ext_detalle'].'</td>
								</tr>';
				}
			}
			$data[ 'PDF' ] .= '</table><br>';
		}
		else
			$data[ 'PDF' ] .= '<p style="font-size:small;">(sin actividades extralaborales)</p>';
		
		$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ANTECEDENTES DE RIESGOS LABORALES</b></td></tr></table>';
		
		$rie_lab = new Persona();
		$rie_lab->get_rie_laborales($ficha_medica->rows[$c]['per_codi'] );
		
		if ( count($rie_lab->rows)-1 > 0) 
		{	
			$data["PDF"] .= '
						<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Nombre empresa</b></td>'.
								'<td><b>Riesgo F&iacute;sico</b></td>'.
								'<td><b>R. Fisicomec&aacute;nico</b></td>'.
								'<td><b>R. Qu&iacute;mico</b></td>'.
								'<td><b>R. Biol&oacute;gico</b></td>'.
								'<td><b>R. Disergon&oacute;mico</b></td>'.
								'<td><b>R. Psicosocial</b></td>
							</tr>';
			foreach( $rie_lab->rows as $row )
			{	if ( !empty( $row ) )
				{	$data["PDF"] .='
								<tr align="center">
									<td>'.$row['inst_nombre'].'</td>
									<td>'.$row['risk_fisico'].'</td>
									<td>'.$row['risk_fisicomecanico'].'</td>
									<td>'.$row['risk_quimico'].'</td>
									<td>'.$row['risk_biologico'].'</td>
									<td>'.$row['risk_disergonomico'].'</td>
									<td>'.$row['risk_psicosocial'].'</td>
								</tr>';
				}
			}
			$data[ 'PDF' ] .= '</table><br>';
		}
		else
			$data[ 'PDF' ] .= '<p style="font-size:small;">(sin riesgos laborales)</p>';
		
		$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ANTECEDENTES DE ACCIDENTES LABORALES</b></td></tr></table>';
		
		$acc_lab = new Persona();
		$acc_lab->get_acc_laborales($ficha_medica->rows[$c]['per_codi'] );
		
		if ( count($acc_lab->rows)-1 > 0) 
		{	
			$data["PDF"] .= '
						<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Nombre empresa</b></td>'.
								'<td><b>Causa de accidente</b></td>'.
								'<td><b>Tipo de lesión</b></td>'.
								'<td><b>Parte afectada</b></td>'.
								'<td><b>Incapacidad</b></td>'.
								'<td><b>Secuelas</b></td>'.
								'<td><b>Fecha de siniestro</b></td>
							</tr>';
			foreach( $acc_lab->rows as $row )
			{	if ( !empty( $row ) )
				{	$data["PDF"] .='
								<tr align="center">
									<td>'.$row['inst_nombre'].'</td>
									<td>'.$row['acc_causa'].'</td>
									<td>'.$row['acc_tipo_lesion'].'</td>
									<td>'.$row['acc_parte_afectada'].'</td>
									<td>'.$row['acc_incapacidad'].'</td>
									<td>'.$row['acc_secuelas'].'</td>
									<td>'.$row['acc_fecha_siniestro'].'</td>
								</tr>';
				}
			}
			$data[ 'PDF' ] .= '</table><br>';
		}
		else
			$data[ 'PDF' ] .= '<p style="font-size:small;">(sin riesgos laborales)</p>';
		
		/* FIN DE DATOS DE EMPLEADO */
	}
	
	$data[ 'PDF' ] .= '<br><table align="center"><tr><td colspan="12"><b>DATOS MEDICOS</b></td></tr></table>';
	
	$data[ 'PDF' ] .='	
					<table cellspacing="0" cellpadding="2" border="1" width="100%">
						<tr><td colspan="12"><b>ANTECEDENTES PERSONALES</b></td></tr>
						<tr><td colspan="6"><b>Tabaco:</b> '. $ficha_medica->rows[$c]['fmex_tabaco'] .'</td>
							<td colspan="6"><b>Alcohol:</b> ' . $ficha_medica->rows[$c]['fmex_alcohol'] . '</td></tr>
						<tr><td colspan="6"><b>Drogas:</b> '. $ficha_medica->rows[$c]['fmex_drogas'] .'</td>
							<td colspan="6"></td></tr>
						</table>
					<br>';
	/* SUBCONSULTAS DE ALERGIA, VACUNAS Y ENFEREMDADES */
	
	/* 1. ALERGIAS */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ALERGIAS</b></td></tr></table>';
	
	$alergia = new Ficha_medica();
	$alergia->get_alergia( $ficha_medica->rows[$c]['fmex_codi'] );
	
	if ( count($alergia->rows)-1 > 0) 
	{
		$data["PDF"] .= '<br>
					<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
						<tr align="center">
							<td><b>Nombre</b></td>'.
							'<td><b>Reacción</b></td>
						</tr>';
		foreach( $alergia->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['ale_nombre'].'</td>
								<td>'.$row['ale_desc_reaccion'].'</td>
							</tr>';
			}
		}
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin alergias)</p>';
	
	/* 2. VACUNAS */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>VACUNAS</b></td></tr></table>';
	
	$vacuna = new Ficha_medica();
	$vacuna->get_vacuna( $ficha_medica->rows[$c]['fmex_codi'] );
	
	if ( count($vacuna->rows)-1 > 0) 
	{	
		$data["PDF"] .= '
					<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
						<tr align="center">
							<td><b>Vacuna</b></td>'.
							'<td><b>Fecha</b></td>'.
							'<td><b>Reacción</b></td>
						</tr>';
		
		foreach( $vacuna->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['vac_nombre'].'</td>
								<td>'.$row['vac_fecha_apli'].'</td>
								<td>'.$row['vac_obs'].'</td>
							</tr>';
			}
		}
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin vacunas)</p>';
							
	/* 3. ANTECEDENTES PATOLOGICOS FAMILIARES */
	
	$data[ 'PDF' ] .= '<br><table width="100%" align="left"><tr><td colspan="12"><b>ANTECEDENTES PATOLOGICOS FAMILIARES</b></td></tr></table>';
	
	$enfermedad_familia = new Ficha_medica();
	$enfermedad_familia->get_enfermedad( $ficha_medica->rows[$c]['fmex_codi'], 'F', -1 );
	
	if ( count($enfermedad_familia->rows)-1 > 0) 
	{	
		$data["PDF"] .= '
					<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
						<tr align="center">
							<td><b>Enfermedad</b></td>'.
							'<td><b>Tiene</b></td>'.
							'<td><b>Tuvo</b></td>'.
							'<td><b>Tratamiento</b></td>'.
							'<td><b>Parentesco</b></td>'.
							'<td><b>Observaciones</b></td>
						</tr>';
	
		foreach( $enfermedad_familia->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['enf_nombre'].'</td>
								<td>'.$row['enf_tiene'].'</td>
								<td>'.$row['enf_tuvo'].'</td>
								<td>'.$row['enf_tratamiento'].'</td>
								<td>'.$row['enf_parentesco'].'</td>
								<td>'.$row['enf_desc_tratamiento'].'</td>
							</tr>';
			}
		}
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin antecedentes familiares)</p>';
	
	/* 4. ANTECEDENTES PATOLOGICOS PERSONALES */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>ANTECEDENTES PATOLOGICOS PERSONALES</b></td></tr></table>';
	
	$enfermedad_personal = new Ficha_medica();
	$enfermedad_personal->get_enfermedad( $ficha_medica->rows[$c]['fmex_codi'], 'T', -1  );
	
	if ( count($enfermedad_familia->rows)-1 > 0) 
	{	
		$data["PDF"] .= '
					<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
						<tr align="center">
							<td><b>Enfermedad</b></td>'.
							'<td><b>Tiene</b></td>'.
							'<td><b>Tuvo</b></td>'.
							'<td><b>Tratamiento</b></td>'.
							'<td><b>Observaciones</b></td>
						</tr>';
						
		foreach( $enfermedad_personal->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['enf_nombre'].'</td>
								<td>'.$row['enf_tiene'].'</td>
								<td>'.$row['enf_tuvo'].'</td>
								<td>'.$row['enf_tratamiento'].'</td>
								<td>'.$row['enf_desc_tratamiento'].'</td>
							</tr>';
			}
		}
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin antecedentes personales)</p>';
	
	$data[ 'PDF' ] .='<br><table cellspacing="0" cellpadding="2" border="1" width="100%">
						<tr><td colspan="12"><b>EXAMEN FISICO</b></td></tr>
						<tr><td colspan="6"><b>Condición física:</b> '. $ficha_medica->rows[$c]['fmex_con_fisica'] .'</td>
							<td colspan="6"><b>Actividad sicomotora:</b> ' . $ficha_medica->rows[$c]['fmex_act_sicomotora'] . '</td></tr>
						<tr><td colspan="6"><b>Deambulación:</b> '. $ficha_medica->rows[$c]['fmex_deambulacion'] .'</td>
							<td colspan="6"><b>Expresión verbal:</b> ' . $ficha_medica->rows[$c]['fmex_exp_verbal'] . '</td></tr>
						<tr><td colspan="6"><b>Estado nutricional:</b> '. $ficha_medica->rows[$c]['fmex_estado_nutricional'] .'</td>
							<td colspan="6"><b>Estatura:</b> ' . $ficha_medica->rows[$c]['fmex_estatura'] . '</td></tr>
						<tr><td colspan="6"><b>Peso:</b> '. $ficha_medica->rows[$c]['fmex_peso'] .'</td>
							<td colspan="6"><b>Temperatura bucal:</b> ' . $ficha_medica->rows[$c]['fmex_temp_bucal'] . '</td></tr>
						<tr><td colspan="6"><b>Pulso:</b> '. $ficha_medica->rows[$c]['fmex_pulso'] .'</td>
							<td colspan="6"><b>Presión arterial :</b> ' . $ficha_medica->rows[$c]['fmex_presion_arterial'] . '</td></tr>
							
						<tr><td colspan="12"><b>EXAMEN REGIONAL</b></td></tr>
						<tr><td colspan="12"><b>GENERAL</b></td></tr>
						<tr><td colspan="6"><b>Piel:</b> '. $ficha_medica->rows[$c]['fmex_piel'] .'</td>
							<td colspan="6"><b>Ganglios:</b> ' . $ficha_medica->rows[$c]['fmex_ganglios'] . '</td></tr>
						<tr><td colspan="6"><b>Cabeza:</b> '. $ficha_medica->rows[$c]['fmex_cabeza'] .'</td>
							<td colspan="6"><b>Cuello:</b> ' . $ficha_medica->rows[$c]['fmex_cuello'] . '</td></tr>
						<tr><td colspan="12"><b>CARA</b></td></tr>	
						<tr><td colspan="6"><b>Ojos:</b> '. $ficha_medica->rows[$c]['fmex_ojos'] .'</td>
							<td colspan="6"><b>Oídos:</b> ' . $ficha_medica->rows[$c]['fmex_oidos'] . '</td></tr>
						<tr><td colspan="6"><b>Boca:</b> '. $ficha_medica->rows[$c]['fmex_boca'] .'</td>
							<td colspan="6"><b>Nariz:</b> ' . $ficha_medica->rows[$c]['fmex_nariz'] . '</td></tr>
						<tr><td colspan="6"><b>Dentadura:</b> '. $ficha_medica->rows[$c]['fmex_dentadura'] .'</td>
							<td colspan="6"><b>Garganta:</b> ' . $ficha_medica->rows[$c]['fmex_garganta'] . '</td></tr>
						<tr><td colspan="12"><b>TORAX</b></td></tr>	
						<tr><td colspan="6"><b>Corazón:</b> '. $ficha_medica->rows[$c]['fmex_corazon'] .'</td>
							<td colspan="6"><b>Torax:</b> ' . $ficha_medica->rows[$c]['fmex_torax'] . '</td></tr>
						<tr><td colspan="6"><b>Pulmones:</b> '. $ficha_medica->rows[$c]['fmex_pulmones'] .'</td>
							<td colspan="6"><b>Mamas:</b> ' . $ficha_medica->rows[$c]['fmex_mamas'] . '</td></tr>
						<tr><td colspan="12"><b>ABDOMEN</b></td></tr>	
						<tr><td colspan="6"><b>Hígado:</b> '. $ficha_medica->rows[$c]['fmex_higado'] .'</td>
							<td colspan="6"><b>Vesícula Biliar:</b> ' . $ficha_medica->rows[$c]['fmex_ves_biliar'] . '</td></tr>
						<tr><td colspan="6"><b>Bazo:</b> '. $ficha_medica->rows[$c]['fmex_bazo'] .'</td>
							<td colspan="6"><b>Estómago:</b> ' . $ficha_medica->rows[$c]['fmex_estomago'] . '</td></tr>
						<tr><td colspan="6"><b>Intestinos:</b> '. $ficha_medica->rows[$c]['fmex_intestinos'] .'</td>
							<td colspan="6"><b>Apéndice:</b> ' . $ficha_medica->rows[$c]['fmex_apendice'] . '</td></tr>
						<tr><td colspan="6"><b>Ano:</b> '. $ficha_medica->rows[$c]['fmex_ano'] .'</td>
							<td colspan="6"></td></tr>
						<tr><td colspan="12"><b>CONDUCTOS Y ANILLO</b></td></tr>	
						<tr><td colspan="6"><b>Cordón Umbilical:</b> '. $ficha_medica->rows[$c]['fmex_umbilical'] .'</td>
							<td colspan="6"><b>Crural:</b> ' . $ficha_medica->rows[$c]['fmex_rurales'] . '</td></tr>
						<tr><td colspan="6"><b>Inguinal derecha:</b> '. $ficha_medica->rows[$c]['fmex_inguinal_derecha'] .'</td>
							<td colspan="6"><b>Inguinal izquierda:</b> ' . $ficha_medica->rows[$c]['fmex_inguinal_izquierda'] . '</td></tr>
						<tr><td colspan="12"><b>COLUMNA VERTEBRAL</b></td></tr>	
						<tr><td colspan="6"><b>Deformaciones:</b> '. $ficha_medica->rows[$c]['fmex_deformaciones'] .'</td>
							<td colspan="6"><b>Masas musculares:</b> ' . $ficha_medica->rows[$c]['fmex_masas_musculares'] . '</td></tr>
						<tr><td colspan="6"><b>Movibildad:</b> '. $ficha_medica->rows[$c]['fmex_movibilidad'] .'</td>
							<td colspan="6"><b>Puntos dolorosos:</b> ' . $ficha_medica->rows[$c]['fmex_puntos_dolorosos'] . '</td></tr>
						<tr><td colspan="12"><b>REGION URGO-GENITAL</b></td></tr>
						<tr><td colspan="6"><b>Tracto urinario:</b> '. $ficha_medica->rows[$c]['fmex_tracto_urinario'] .'</td>
							<td colspan="6"><b>Tracto genital masculino:</b> ' . $ficha_medica->rows[$c]['fmex_tracto_genital_masculino'] . '</td></tr>
						<tr><td colspan="6"><b>Espermaquia:</b> '. $ficha_medica->rows[$c]['fmex_espermaquia'] .'</td>
							<td colspan="6"></td></tr>
						<tr><td colspan="6"><b>Tracto genital femenino:</b> '. $ficha_medica->rows[$c]['fmex_tracto_genital_femenino'] .'</td>
							<td colspan="6"><b>Menstruación:</b> ' . $ficha_medica->rows[$c]['fmex_menstruacion'] . '</td></tr>
						<tr><td colspan="6"><b>Menarquia:</b> '. $ficha_medica->rows[$c]['fmex_menarquia'] .'</td>
							<td colspan="6"><b>Menapmia:</b> ' . $ficha_medica->rows[$c]['fmex_menapmia'] . '</td></tr>
						<tr><td colspan="6"><b>Gesta:</b> '. $ficha_medica->rows[$c]['fmex_gesta'] .'</td>
							<td colspan="6"><b>Partos:</b> ' . $ficha_medica->rows[$c]['fmex_partos'] . '</td></tr>
						<tr><td colspan="6"><b>Aborto:</b> '. $ficha_medica->rows[$c]['fmex_aborto'] .'</td>
							<td colspan="6"><b>Cesárea:</b> ' . $ficha_medica->rows[$c]['fmex_cesarea'] . '</td></tr>
						<tr><td colspan="12"><b>EXTREMIDADES</b></td></tr>	
						<tr><td colspan="6"><b>Superior derecha:</b> '. $ficha_medica->rows[$c]['fmex_superior_derecha'] .'</td>
							<td colspan="6"><b>Superior izquierda:</b> ' . $ficha_medica->rows[$c]['fmex_superior_izquierda'] . '</td></tr>
						<tr><td colspan="6"><b>Inferior derecha:</b> '. $ficha_medica->rows[$c]['fmex_inferior_derecha'] .'</td>
							<td colspan="6"><b>Inferior izquierda:</b> ' . $ficha_medica->rows[$c]['fmex_inferior_izquierda'] . '</td></tr>
						<tr><td colspan="12"><b>ORGANO DE LOS SENTIDOS</b></td></tr>	
						<tr><td colspan="6"><b>Ojo derecho:</b> '. $ficha_medica->rows[$c]['fmex_ojo_derecho'] .'</td>
							<td colspan="6"><b>Ojo izquierdo:</b> ' . $ficha_medica->rows[$c]['fmex_ojo_izquierdo'] . '</td></tr>
						<tr><td colspan="6"><b>Oído derecho:</b> '. $ficha_medica->rows[$c]['fmex_oido_derecho'] .'</td>
							<td colspan="6"><b>Oído izquierdo:</b> ' . $ficha_medica->rows[$c]['fmex_oido_izquierdo'] . '</td></tr>
						<tr><td colspan="12"><b>EXAMEN NEUROLOGICO</b></td></tr>	
						<tr><td colspan="6"><b>Reflejos tendinosos:</b> '. $ficha_medica->rows[$c]['fmex_reflex_tendinosos'] .'</td>
							<td colspan="6"><b>Reflejos pupilares:</b> ' . $ficha_medica->rows[$c]['fmex_reflex_pupilares'] . '</td></tr>
						<tr><td colspan="6"><b>Marcha:</b> '. $ficha_medica->rows[$c]['fmex_marcha'] .'</td>
							<td colspan="6"><b>Sensibilidad Superficial:</b> ' . $ficha_medica->rows[$c]['fmex_sens_superficial'] . '</td></tr>
						<tr><td colspan="6"><b>Profundidad Romberg:</b> '. $ficha_medica->rows[$c]['fmex_profunda_romberg'] .'</td>
							<td colspan="6"></td></tr>
						<tr><td colspan="12"><b>ESTADO MENTAL</b></td></tr>	
						<tr><td colspan="6"><b>Estado mental:</b> '. $ficha_medica->rows[$c]['fmex_estado_mental'] .'</td>
							<td colspan="6"><b>Memoria:</b> ' . $ficha_medica->rows[$c]['fmex_memoria'] . '</td></tr>
						<tr><td colspan="6"><b>Irritabilidad:</b> '. $ficha_medica->rows[$c]['fmex_irritabilidad'] .'</td>
							<td colspan="6"><b>Depresión:</b> ' . $ficha_medica->rows[$c]['fmex_depresion'] . '</td></tr>
					</table>
					<br>';
	
	/*  CRadiografía/Ex. clínicos */
	
	/* 1. Cirugías */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>CIRUGÍAS</b></td></tr></table>';
	
	$cirugia = new Ficha_medica();
	$cirugia->get_cirugia( $ficha_medica->rows[$c]['fmex_codi'] );
	
	if ( count($cirugia->rows)-1 > 0) 
	{
		$data["PDF"] .= '<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Cirugía</b></td>'.
								'<td><b>Localización</b></td>
								<td><b>Extensión</b></td>
								<td><b>Propósito</b></td>
								<td><b>Fecha</b></td>
							</tr>';
		
		foreach( $cirugia->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['cir_nombre_desc'].'</td>
								<td>'.$row['cir_localizacion'].'</td>
								<td>'.$row['cir_extension'].'</td>
								<td>'.$row['cir_proposito'].'</td>
								<td>'.$row['cir_fecha'].'</td>
							</tr>';
			}
		}
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin cirugías)</p>';
	
	
	/* 2. Exámenes de laboratorio */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>EXAMENES DE LABORATORIO</b></td></tr></table>';
	
	$ex_lab_clinico = new Ficha_medica();
	$ex_lab_clinico->get_ex_lab_clinico( $ficha_medica->rows[$c]['fmex_codi'] );
	
	if ( count($ex_lab_clinico->rows)-1 > 0) 
	{
		$data["PDF"] .= '<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Examen</b></td>'.
								'<td><b>Resultado</b></td>
								<td><b>Fecha del examen</b></td>
							</tr>';
	
		foreach( $ex_lab_clinico->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['lab_nombre_ES'].'</td>
								<td>'.$row['lab_desc_resultado'].'</td>
								<td>'.$row['lab_fecha'].'</td>
							</tr>';
			}
		}
		
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin exámenes clínicos)</p>';
	
	/* 3. Radiografías */
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>RADIOGRAFIAS</b></td></tr></table>';
	
	$radiografia = new Ficha_medica();
	$radiografia->get_radiografia( $ficha_medica->rows[$c]['fmex_codi'] );
	
	if ( count($radiografia->rows)-1 > 0) 
	{
		$data["PDF"] .= '<table cellspacing="0" cellpadding="2" border="1" width="100%" style="font-size:small;">
							<tr align="center">
								<td><b>Radiografía</b></td>
								<td><b>Localización en el cuerpo</b></td>
								<td><b>Fecha de la radiografía</b></td>
							</tr>';
		
		foreach( $radiografia->rows as $row )
		{	if ( !empty( $row ) )
			{	$data["PDF"] .='
							<tr align="center">
								<td>'.$row['rad_nombre_desc'].'</td>
								<td>'.$row['rad_localizacion'].'</td>
								<td>'.$row['rad_fecha'].'</td>
							</tr>';
			}
		}
		
		$data[ 'PDF' ] .= '</table><br>';
	}
	else
		$data[ 'PDF' ] .= '<p style="font-size:small;">(sin radiografía)</p>';
	
	/* CONCLUSIONES */
	
	$data[ 'PDF' ] .= '<br><table><tr><td colspan="12"><b>' . $label_conclusiones . '</b></td></tr></table><br>';
	
	$data[ 'PDF' ] .= '<table cellspacing="0" cellpadding="2" border="1" width="100%">
						<tr><td colspan="12">'. $ficha_medica->rows[$c]['fmex_aptitud_trabajo'] .'</td></tr>';
	
	$data[ 'PDF' ] .= '</table>';
	
	return $data;
}