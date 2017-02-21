<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../../finan/general/model.php');
require_once('../../common/periodo/model.php');
require_once('../../finan/gruposEconomico/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{   require('/../../../core/rutas.php');
    $cobranza 		= get_mainObject('Cobranzas');
    $resultado 		= get_mainObject('Cobranzas');
    $resul_detalle 	= get_mainObject('Cobranzas');
    $acercamientos 	= get_mainObject('Cobranzas');
    $permiso 		= get_mainObject('General');
	$periodo 		= get_mainObject('Periodo');
	$grupEcon 		= get_mainObject('GrupoEconomico');
	
    $event = get_actualEvents(array(SET, SET_GET_ALL, 	GET, 				DELETE, 	EDIT, GET_ALL,
                                    VIEW_SET, 			VIEW_SET_GET_ALL,	VIEW_GET, 	VIEW_DELETE, 
                                    VIEW_ACERCA, 		VIEW_GET_ALL), 		VIEW_GET_ALL);
    $user_data = get_frontData();

    if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla= "cobr_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{   case LOAD_DETA_DEUD:
            $cobranza->get_all_deud_deta($user_data['clie_codigo']);
            $data['{tabla_deuda}'] = array(	"elemento" 	=> "tabla_anidada",
											"clase"		=>"table table-striped table-bordered",
											"id"		=>"deudas_".$user_data['clie_codigo'],
											"datos"		=>$cobranza->rows,
											"encabezado"=>array("Ref. Factura",
																"Deuda Original",
																"Deuda Pendiente",
																"Fecha Vencimiento"));
            retornar_result($data);
            break;
        case LOAD_DETA_DEUD_INFO:
            $cobranza->get_all_deud_deta_info($user_data['deud_codigo']);
            $data['{tabla_deuda_info}'] = array("elemento" 	=>"tabla",
												"clase"		=>"table table-striped table-bordered",
												"id"		=>"sub_deudas_".$user_data['deud_codigo'],
												"datos"		=>$cobranza->rows,
												"encabezado"=>array("Producto",
																	"Precio Uni.",
																	"Cantidad",
																	"Tot Bruto",
																	"Descto.",
																	"Impuestos",
																	"Total Neto"));
            retornar_result($data);
            break;
        case GET:
            global $diccionario;
            $tomorrow=new DateTime('tomorrow');
            $para="";
            $resultado->get_all_resultados($para);
            $resu_codigo=current( $resultado->rows[0]);
            $resul_detalle->get_all_resul_deta($resu_codigo);
            $cobranza->get($user_data['clie_codigo']);
            $acercamientos->get_acercamientos($user_data['clie_codigo']);
			$deuda_aux1 = explode(' ',$cobranza->deud_totalPendiente);
			//$deuda_total = (int)$deuda_aux1[1];
            $data = array(
                'clie_codigo'=>$user_data['clie_codigo'],
                'clie_nombres'=>$cobranza->clie_nombres,
                'clie_correoElectronico'=>$cobranza->clie_correoElectronico,
                'clie_direccion'=>$cobranza->clie_direccion,
                'clie_telefono'=>$cobranza->clie_telefono,
                'deud_totalInicial'=>$cobranza->deud_totalInicial,
                'deud_totalPendiente'=>(int)$deuda_aux1[1],
                'txt_deud_totalPendiente'=>$cobranza->deud_totalPendiente,
                'deud_fechaVencimiento'=>$cobranza->deud_fechaVencimiento,
                'acerca_fecha_seguimiento'=>$tomorrow->format('d/m/Y'),
                '{combo_resultado}' => array("elemento"  => "combo", 
                                                "datos"     => $resultado->rows, 
                                                "options"   => array("name"=>"combo_resultado","id"=>"combo_resultado","class"=>"form-control","required"=>"required","onchange"=>"carga_detalle_resultado(this.value,'deta_crm_resul_div','".$diccionario['rutas_head']['ruta_html_finan'].'/cobranza/controller.php'."')"),
                                                "selected"  => 0),
                '{combo_detalle_resultado}' =>  array("elemento"  => "combo", 
                                                "datos"     => $resul_detalle->rows, 
                                                "options"   => array("name"=>"combo_detalle_resultado","id"=>"combo_detalle_resultado","required"=>"required","class"=>"form-control"),
                                                "selected"  => 0),
                '{tabla_acercamientos_ant}' =>  array(  "elemento"=>"tabla",
														"clase"=>"table table-striped table-bordered",
                                                        "id"=>"cobr_table_acerca",
                                                        "datos"=>$acercamientos->rows,
                                                        "encabezado" => array("F. acercamiento",
																			  "F. de próx. acercamiento",
																			  "Usuario",
																			  "Resultado",
																			  "Detalle",
																			  "Observación")));
            retornar_formulario(VIEW_ACERCA, $data);
            break;
        case LOAD_DETA_CRM:
            $resul_detalle->get_all_resul_deta($user_data['crm_resu_codigo']);
            $data = array('{combo_detalle_resultado}' => array( "elemento"  => "combo", 
																"datos"     => $resul_detalle->rows, 
																"options"   => array("name"=>"combo_detalle_resultado","id"=>"combo_detalle_resultado","required"=>"required","class"=>"form-control"),
																"selected"  => 0));
            retornar_result($data);
            break;        
        case SAVE_ACERCA:
            $cobranza->guarda_acerca($user_data);
            break;
        case VIEW_GET_ALL:
            global $diccionario;
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			$periodo->get_all_selectFormat();
			$data['{cmb_periodo}'] = array("elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos", "class"=>"form-control input-sm",
																 "onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => $_SESSION['peri_codi']);
			$grupEcon->getCategorias_selectFormat_with_all('');
			$data['{cmb_grupoEconomico}'] = array("elemento"  => "combo", 
											"datos"     => $grupEcon->rows, 
                                            "options"   => array("name"=>"cmb_grupoEconomico","id"=>"cmb_grupoEconomico", "class"=>"form-control input-sm"),
											"selected"  => 0);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{cmb_nivelEconomico}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control input-sm",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
			$data['{cmb_curso}']=array("elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
										
            $data['tabla'] = "<span style='font-size:small'>Haga clic en buscar para realizar una consulta.</span>";
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
			global $diccionario;
			if(!isset($user_data['fechanac_ini']))
				$fechanac_ini = '';
			else 
				$fechanac_ini = $user_data['fechanac_ini'];
			
			if(!isset($user_data['fechanac_fin']))
				$fechanac_fin = '';
			else 
				$fechanac_fin = $user_data['fechanac_fin'];
			if(!isset($user_data['id_titular']))
				$id_titular = '';
			else 
				$id_titular = $user_data['id_titular'];
			if(!isset($user_data['id_cliente']))
				$id_cliente = '';
			else 
				$id_cliente = $user_data['id_cliente'];
			if(!isset($user_data['cod_estudiante']))
				$cod_estudiante = '-1';
			else 
				$cod_estudiante = $user_data['cod_estudiante'];
			if(!isset($user_data['nombre_estudiante']))
				$nombre_estudiante = '';
			else 
				$nombre_estudiante = $user_data['nombre_estudiante'];
			if(!isset($user_data['nombre_repr']))
				$nombre_repr = '';
			else 
				$nombre_repr = $user_data['nombre_repr'];
			if(!isset($user_data['estado']))
				$estado = 'A';
			else 
				$estado = $user_data['estado'];
			if(!isset($user_data['periodo']))
				$periodos = '-1';
			else 
				$periodos = $user_data['periodo'];
			if(!isset($user_data['grupoEconomico']))
				$grupoEconomico = '-1';
			else 
				$grupoEconomico = $user_data['grupoEconomico'];
			if(!isset($user_data['nivelEconomico']))
				$nivelEconomico = '-1';
			else 
				$nivelEconomico = $user_data['nivelEconomico'];
			if(!isset($user_data['curso']))
				$curso = '-1';
			else 
				$curso = $user_data['curso'];
            $cobranza->get_all_deb_cob( $cod_estudiante, 		$nombre_estudiante,		$fechanac_ini, 		$fechanac_fin,
										$id_titular,			$nombre_repr,			$id_cliente,		$periodos,
										$curso,					$grupoEconomico,		$nivelEconomico,	$estado);
            if(count($cobranza->rows)>0)
			{   global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 174);
                if ($permiso->rows[0]['veri']==1)
                {
                    $opciones["Acercamiento"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_crm_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/cobranza/controller.php"'.")' class='btn_opc_lista_acercamiento glyphicon glyphicon-phone-alt cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_crm'id='{codigo}_crm'onmouseover='$(this).tooltip(".'"show"'.")' title='Acercamiento'></span>";
                }
                else
                {
                    $opciones["Acercamiento"] = "";
                }
                $data['{tabla}']= array("elemento"	=>"tabla_anidada",
                                        "clase"		=>"table table-striped table-bordered",
                                        "id"		=>$tabla,
                                        "datos"		=>$cobranza->rows,
                                        "encabezado"=>array("Código",
															"Identificación",
															"Nombre",
															"Curso",
															"Deuda Pdte.",
															"F. Vencido",
															"F. Seguimiento",
															""),
                                        "options"	=>array( $opciones ),
                                        "campo"=>"alum_codi");
            }
			else
			{   $data = array('mensaje'=>$cobranza->mensaje.$cobranza->ErrorToString());
            }
            retornar_result($data);
            break;
    }
}
handler();
?>