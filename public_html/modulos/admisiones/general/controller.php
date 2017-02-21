<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('funciones.php');
function handler() {
	require('../../../core/rutas.php');
	
    if (!isset($_POST['event']))
	{	if(!isset($_GET['event']))
		{	$event = INDEX;
		}
		else
		{	$event =$_GET['event'];
		}
	}
	else
	{	$event =$_POST['event'];
	}
	if (!isset($_POST['tabla']))
	{	$tabla= "tabla_rptDeudores";
	}
	else
	{	$tabla=$_POST['tabla'];
	}
	 
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED,PRINTREP_DEUDORES,PRINTREPVISOR,VIEW_CONFIG_SIS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    $gene_data = helper_data();	//variables que llegan por post desde el javascript
	$user_data = get_frontData(); //variables que llegan por post desde el javascript
    $general = set_obj();
	$gene= set_obj();
	$cursos = set_obj();
	$periodos = set_obj();
	$periodo = get_mainObject('Periodo');
	$pensiones = set_obj();
    $apikey =set_obj();
	$deuda = set_obj();
	
    switch ($event) 
	{	case MAIN:
			$general->login($gene_data['usua_codigo'],$gene_data['usua_clave']);
            global $diccionario;
			
			$apikey->getapikey();
            $gene->apertura_caja($gene_data['usua_codigo']);
			
			$_SESSION['caja_codi']=$gene->caja_codi;
			$_SESSION['caja_fecha']=$gene->caja_fecha;
			
			$periodo->get_all_selectFormat();
			$cmb_sidebar_periodo = '<select name="cmb_sidebar_periodo" id="cmb_sidebar_periodo" required="required" class="form-control">';	
			for($i=0;$i<count($periodo->rows)-1;$i++){
				if(trim($periodo->rows[$i][0])==trim(''))
				{   $sel="selected='selected'";
				}else
				{ $sel="";
				}
				$cmb_sidebar_periodo .= "<option value='".$periodo->rows[$i][0]."'". $sel." >".$periodo->rows[$i][1]."</option>";
			}
			$cmb_sidebar_periodo .= "</select>";
		
			$data = array(
			'usua_codigo'=>$gene_data['usua_codigo'],
			'usua_nombres'=>$general->usua_nombres,
			'usua_apellidos'=>$general->usua_apellidos,
			'usua_correoElectronico'=>$general->usua_correoElectronico,
			'usua_codigoRol'=>$general->usua_codigoRol,
			'puntVent_codigo'=>$general->puntVent_codigo,
			'cmb_sidebar_periodo' => $cmb_sidebar_periodo );
			if(count($general->rows)>1){
				$_SESSION['IN']="OK";
				if( empty( $_SESSION['sidebar_status'] ) )
					$_SESSION['sidebar_status']='sidebar-collapse';
				$_SESSION['ui_skin']='skin-blue';
				$_SESSION['toggle_fullscreen']='false';
				$_SESSION['apikey']=$apikey->rows[0]['apikey'];
				$_SESSION['usua_codigo']=$data['usua_codigo'];
				$_SESSION['usua_nombres']=$data['usua_nombres'];
				$_SESSION['usua_apellidos']=$data['usua_apellidos'];
				$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
				$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
				$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
				$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
				$general->login_success($gene_data['usua_codigo']);	
				$general->permisos_generales($_SESSION['usua_codigoRol']);
				$_SESSION['usua_permiso']=$general->permiso;

				$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
				
				$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
				$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
				$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
				$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
				$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
				
				$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white_red'];
				$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_red_small'];
				
				$_SESSION['dir_logo_redlinks_black']=$ruta_logo_redlinks_black;
				$_SESSION['dir_logo_redlinks_white']=$ruta_logo_redlinks_white;
				$_SESSION['dir_logo_links_md']=$ruta_logo_links_md;
				$_SESSION['dir_logo_links']=$ruta_logo_links;
				$_SESSION['print_dir_logo_educalinks']=$print_ruta_logo_educalinks;
				$_SESSION['print_dir_logo_educalinks_long_sm']=$print_ruta_logo_educalinks_long_small;
				$_SESSION['print_dir_logo_redlinks_black']=$print_ruta_logo_redlinks_black;
				$_SESSION['print_dir_logo_redlinks_white']=$print_ruta_logo_redlinks_white;
				$_SESSION['print_dir_logo_links_md']=$print_ruta_logo_links_md;
				$_SESSION['print_dir_logo_links']=$print_ruta_logo_links;
				$_SESSION['ruta_documentos_requisitos'] = $ruta_documentos_requisitos;
				$_SESSION['ruta_documentos_sintesis'] = $ruta_documentos_sintesis;
				switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "ecobabdemo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='ecobabdemo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "contifico.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='contifico.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "desarrollo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='desarrollo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
				}
				$data['usua_permiso']=$_SESSION['usua_permiso'];
				
				$today=new DateTime('yesterday');
				$tomorrow=new DateTime('today');
				$data = array(
                'usua_codigo'=>$_SESSION['usua_codigo'],
				'usua_nombres'=>$_SESSION['usua_nombres'],
                'usua_apellidos'=>$_SESSION['usua_apellidos'],
				'usua_correoElectronico'=>$_SESSION['usua_correoElectronico'],
				'usua_codigoRol'=>$_SESSION['usua_codigoRol'],
				'txt_fecha_ini'=>$today->format('d/m/Y'),
				'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
				'{combo_periodo}' => array(	"elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos","required"=>"required", "class"=>"form-control",
                                            "onChange"=>"cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => $_SESSION['peri_codi'] ),
													  
													  
													  
				'{combo_cursos}' => array("elemento"  => "combo", 
														
                                                      "datos"     => array(0 => array(0 => -1, 
                                                                                      1 => 'Seleccione...',
                                                                                      3 => ''), 
                                                                           1=> array()),
                                                      "options"   => array("name"=>"curso","id"=>"curso","required"=>"required", "class"=>"form-control",
													  "onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
													  "selected"  => -1)
				);
				$niveles = new General();
				$niveles->get_all_niveles_economicos();
				$data['{combo_nivel}']	= array(	
											"elemento"  => 	"combo", 
											"datos"     => 	$niveles->rows, 
											"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																	"id"=>"cmb_nivelesEconomicos",
																	"required"=>"required",
																	"class"=>"form-control",
																	"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
				//$data['tabla']="¡Haga clic en b&uacute;squeda para filtrar la busqueda de tablas y reportes!";
				$construct_table="
						<table id='".$tabla."' class='table table-striped table-bordered'>
							<thead>
								<th style='font-size:small;'>Curso</th>
								<th style='font-size:small;'>Código</th>
								<th style='font-size:small;'>Alumno</th>
							</thead>
							<tbody>
							<tr><td style='font-size:small;'></td>
								<td style='font-size:small;'></td>
								<td style='font-size:small;'></td>
							</tr></tbody></table>";
				$data['tabla']=$construct_table;
				retornar_vista_general(VIEW_HOME, $data);
			}else{
				$_SESSION['IN']="KO";
				$general->login_error($gene_data['usua_codigo'],$_SERVER['REMOTE_ADDR']);
				$data['mensaje']=$general->login_mensaje;
				$_SESSION['ERROR_MSG']=$data['mensaje'];	
				retornar_vista_general(VIEW_INDEX, $data);
			}
        break;
		case INDEX:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			
			global $diccionario;
			$periodo -> get_all_selectFormat();
			
			$today = new DateTime('yesterday');
			$tomorrow = new DateTime('today');
			$data = array(
                'usua_codigo'=>$_SESSION['usua_codigo'],
				'usua_nombres'=>$_SESSION['usua_nombres'],
                'usua_apellidos'=>$_SESSION['usua_apellidos'],
				'usua_correoElectronico'=>$_SESSION['usua_correoElectronico'],
				'usua_codigoRol'=>$_SESSION['usua_codigoRol'],
				'txt_fecha_ini'=>$today->format('d/m/Y'),
				'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
				'{combo_periodo}' => array(
										"elemento"  => "combo", 
										"datos"     => $periodo->rows, 
                                        "options"   => array(
														"name"		=> "periodos",
														"id"		=> "periodos",
														"required"	=> "required",
														"class"		=> "form-control",
														"onChange"	=> "cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
										"selected"  => $_SESSION['peri_codi'] )
				);
			$data['{combo_cursos}'] = array(
										"elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => 'Seleccione...',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control"),
										"selected"  => -1);
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{combo_nivel}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"));
			//$data['tabla']="<small>¡Haga clic en b&uacute;squeda para cargar la consulta de deudas!</small>";
			$construct_table="
						<table id='".$tabla."' class='table table-striped table-bordered'>
							<thead>
								<th style='font-size:small;'>Curso</th>
								<th style='font-size:small;'>Código</th>
								<th style='font-size:small;'>Alumno</th>
							</thead>
							<tbody>
							<tr><td style='font-size:small;'></td>
								<td style='font-size:small;'></td>
								<td style='font-size:small;'></td>
							</tr></tbody></table>";
			$data['tabla']=$construct_table;
			retornar_vista_general(VIEW_HOME, $data);
		break;
		case EXCEL:
			$datos=$deuda->rows;
			$test=$pensiones->rows;
			$encabezado=array();
			$i=0;
			foreach($test as $a)
			{	$encabezado[$i]=$a[0]; 
				$i++;
			}
			$construct_table="
						<table id='".$tabla."' class='table table-striped table-bordered'>
							<thead><tr>";
			foreach ($test as $campo)
			{	
				$construct_table.= "<th style='font-size:small;'>".$campo[0]."</th>";
			}
			$construct_table.= "</tr></thead><tbody>";
			for($j=0;$j<count($datos)-1;$j++)
			{	$construct_table .= "<tr>";
				$c=0;
				foreach ($datos[$j] as $campo)
				{	if(($c==0) || ($c==1) || ($c==2))
					{
						$construct_table .= "<td style='font-size:small;'>".$campo."</td>";
					}
					else
					{
						$construct_table .= "<td style='font-size:small;'>$".number_format($campo,2,'.',',')."</td>";
					}
					$c++;
				}
				$construct_table .= "</tr>";
			}
			$construct_table .= "</tbody></table>";
			break;
        case PASS_CHANGED:
			$general->change_pass($gene_data['usua_clave'],$gene_data['pass_new'],$_SESSION['usua_codigo']);
			print_r($general->mensaje);
		break;
		case PASSWORD_CHANGE:
			$data = array(
                'password'=>'<h3>Cambio de contraseña de "'.$_SESSION['usua_codigo'].'"</h3>');
			retornar_vista_general(VIEW_PASSWORD, $data);
		break;
		case CONFIG_CHANGE:
			$general->get_prontopago();
			if ($general->bloqueo=='true')
			{$disabled='checked=checked';}
            $data = array(
				'prontopago'=>$general->prontopago,
				'prepago'=>$general->prepago,
				'bloqueo'=>$disabled,
                //'config'=>'<h3>Cambio de parámetros del sistema</h3>',
				);
			retornar_formulario(VIEW_CONFIG_SIS, $data);
		break;
		case SET_SETTINGS:
	
			$general->change_settings($user_data['prontopago'],$user_data['prepago'],$user_data['bloqueo'],$_SESSION['usua_codigo']);
			print_r($general->mensaje);
		break;
		case USER_INFO:
			$data = array(
                'datos'=>'<h3>Datos personales del usuario '.$_SESSION['usua_codigo'].'</h3>');
			retornar_vista_general(VIEW_INFO_USER, $data);
		break;
		
		case GET_NIVELECON:
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			global $diccionario;
			$data['{combo_nivel}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
										"selected"  => -1);
			retornar_result($data);
            break;
		case UNSET_CURSO:
			global $diccionario;
			$data['{combo_cursos}'] = array(
										"elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => 'Seleccione...',
																		3 => ''), 
                                                                        2=> array()),
										"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control",
															 "onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
										"selected"  => -1);
			retornar_result($data);
            break;
		case GET_ALL_CURSOS_BY_ECON_LEVEL_LIST:
			global $diccionario;
			//var_dump($saldosafavor_data);
			$cursos->get_all_cursos_by_econ_level($user_data['cod_peri'],$user_data['nivel_economico']);
            $data['{combo}'] = array(				"elemento"  => 	"combo", 
													"datos"     => 	$cursos->rows, 
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"curso",
																			"required"=>"required",
																			"class"=>"form-control",
																			"onChange"	=>	""),
													"selected"  => 	0);
			retornar_result($data);
            break;
		case GET_CURSO:
            $cursos->get_all_cursos($user_data['cod_peri']);
            global $diccionario;
            $data['{combo_cursos}'] = array("elemento"  => "combo", 
                                            "datos"     => $cursos->rows,
                                            "options"   => array("name"=>"curso",
                                                                "id"=>"curso",
                                                                "required"=>"required",
																"class"=>"form-control",
																"onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"
															),
                                            "selected"  => -1);
			retornar_result($data);
            break;
		case GET_DEUDORES:
			if ( $user_data['peri_codi'] == "" )
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			
			$pensiones->get_all_productos( $peri_codi );
			$test=$pensiones->rows;
			$encabezado=array();
			$i=0;
			foreach($test as $a)
			{	$encabezado[$i]=$a[0]; 
				$i++;
			}
           	$deuda->get_all_deudores($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin']);
			$datos=$deuda->rows;
			global $diccionario;
			
			$aux=count($test);
			$toggle_column="";
			for($c=0;$c<$aux;$c++)
			{	$toggle_column.="{a_".$c."}";
				if($c<($aux-1))
				{	$toggle_column.=" - ";
				}
				else
				{	$toggle_column.=".";
				}
			}
			$data['{toggle_vis}'] = array(
								"elemento"  => "div",
								"content"   => $toggle_column);
			$c=0;
			foreach($test as $a)
			{	$data["{a_".$c."}"] = array(	
								"elemento"=>"a",
								"href"=>"#",
                                "content"=>$a[0],
								"optional"=>array(
											"class"			=> "toggle-vis",
											"data-column"	=> $c
									));
				$c++;
			}
			
			$construct_table="
						<table id='".$tabla."' class='table table-striped table-bordered'>
							<thead><tr>";
			foreach ($test as $campo)
			{	
				$construct_table.= "<th style='font-size:small;text-align:center;'>".$campo[0]."</th>";
			}
			$construct_table.= "</tr></thead><tbody>";
			for($j=0;$j<count($datos)-1;$j++)
			{	$construct_table .= "<tr>";
				$c=0;
				foreach ($datos[$j] as $campo)
				{	if(($c==0) || ($c==1) || ($c==2))
					{
						$construct_table .= "<td style='font-size:small;'>".$campo."</td>";
					}
					else
					{
						$construct_table .= "<td style='font-size:small;'>$".number_format($campo,2,'.',',')."</td>";
					}
					$c++;
				}
				$construct_table .= "</tr>";
			}
			$construct_table .= "</tbody></table>";
            $data['tabla'] = $construct_table;
			retornar_formulario(VIEW_TBL_DEUDA, $data);
            break;
		case PRINTREP_DEUDORES:
				$hoy = getdate();
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename='Reportedeudores.pdf'");
				
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator("Redlinks");
				$pdf->SetAuthor("Redlinks");
				$pdf->SetTitle("Reporte de Deudores");
				$pdf->SetSubject("Reporte de Deudores");
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('Helvetica', '', 9, '', 'false');
				
				if ( $user_data['peri_codi'] == "" )
					$peri_codi = $_SESSION['peri_codi'];
				else
					$peri_codi = $user_data['peri_codi'];
				
				$deuda->get_all_deudores($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin']);
				$pensiones->get_all_productos( $peri_codi );
				$test=$pensiones->rows;
				array_pop($test);
				$tranx = $deuda->rows;
				
				$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			
				$html .= '<h2>Reporte completo de Deudores</h2>';
				$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
				if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
				if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
				$html .= '<h5>Fecha de vencimiento del: '.$fini.', hasta el: '.$ffin.'.</h5>';
				$html .='<table cellspacing="0" cellpadding="1" border="1">';
				$col=0;
				// Datos
				$cursoactual="";
				$contadorcabec=0;
				for($i=0;$i<count($tranx)-1;$i++)
				{	$html .= "<tr>";
					$col2=0;
					foreach ($tranx[$i] as $valor)
					{	$col2=$col2+1;
						if ($col2==3)
						{	$html .= '<td colspan="2"><small>'.$valor."</small></td>";
						}
						elseif($col2==2)
						{	$html .= '<td colspan="1" align="center"><small>'.$valor."</small></td>";
						}
						elseif($col2>3)
						{	$html .= "<td align=\"right\"><font size=\"8\" >$".number_format($valor,2,'.',',')."</font></td>";
							$total_mensual[$col2] = $total_mensual[$col2] + $valor;
						}
						else
						{	if($cursoactual!=$valor)
							{	$contadorcabec=count($tranx[$i]);
								$html .= '<td style="font-size:12; "height="30" colspan="'.$contadorcabec.'"><b>'.$valor."</b></td></tr><tr>";
								$col=0;
								foreach($test as $campocabe){
									$col=$col+1;
									if($col==1)
									{
										//nothing;
									}
									else if($col==3)
									{
										$html .='<td colspan="2" align="center" style="font-size:small;"><strong>'.$campocabe[0]."</strong></td>";
									}
									else
									{
										$html .='<td align="center" style="font-size:small;"><strong>'.$campocabe[0]."</strong></td>";
									}
								}
								$html .='<td align="center" valign="center" style="font-size:small;"><b>Total</b></td></tr>';
								$html .="<tr>";
								$cursoactual=$valor;
							}
						}
					}
					$html .= "</tr>";
				}
				//Total por mes
				$html .='<tr><td></td><td colspan="2" align="center"><b><small>TOTAL MENSUAL</small></b></td>';
				for($aux=4;$aux<($col2+1);$aux++)
				{	$html .= "<td align=\"right\"><font size=\"8\"><b>$".number_format($total_mensual[$aux],2,'.',',')."</b></font></td>";
				}
				
				$html .="</tr>";
				$html .= "</table>";
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->Output('Reportedeudores.pdf', 'I');
				break;
			case PRINTREP_DEUDORES_RESUMEN:
				$hoy = getdate();
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename='Reportedeudoresresumen.pdf'");
				
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator("Redlinks");
				$pdf->SetAuthor("Redlinks");
				$pdf->SetTitle("Reporte de Deudores - Resumen");
				$pdf->SetSubject("Reporte de Deudores - Resumen");
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('Helvetica', '', 9, '', 'false');
				
				$deuda->get_all_deudores_resumen($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin']);

				$tranx = $deuda->rows;
				$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				
				$html .= '<h2>Reporte de Deudores - Resumen </h2> ';	 
				$html .= '<h3>Reporte de Deudores - Resumen</h3> ';
				$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
				if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
				if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
				$html .= '<h5>Fecha de vencimiento del: '.$fini.', hasta el: '.$ffin.'.</h5>';
				$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';
				$html .='<table cellspacing="0" cellpadding="2" border="0">';
				$col=0;
				//Datos
				$cursoactual="";
				$contadorcabec=0;
				
				$grupo="";
			  	$sumatotal=0;
				$sumatotalrecaudado=0;
				$sumatotaldescuentos=0;
				$sumatotalporrecaudar=0;
				$sumatoria=0;
				for($i=0;$i<count($tranx)-1;$i++)
				{
				  $col=0;
					if($grupo!=$tranx[$i][0])
					{
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotalporrecaudar=0;
						$grupo=$tranx[$i][0];
						$html .="<tr><td colspan=\"5\"></td></tr>
						<tr ><td height=\"30\" colspan=\"5\" ><font size=\"14\"><strong>".$grupo."</strong></font></td></tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
						
						$html .= "<tr>";	
							$html .= "<td width=\"35%\"><font size=\"8\"></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total de Facturas</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Recaudado</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Descuentos</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total por Recaudar</strong></font></td>";
						$html .= "</tr>";
					}
					
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][2],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
					
						$sumatotal=$sumatotal+$tranx[$i][2];
						$sumatotalrecaudado=$sumatotalrecaudado+$tranx[$i][3];
						$sumatotaldescuentos=$sumatotaldescuentos+$tranx[$i][4];
						$sumatotalporrecaudar=$sumatotalporrecaudar+$tranx[$i][5];
					$html .= "</tr>";
					if($grupo!=$tranx[$i+1][0])
					{	$sumatoria=$sumatoria+$sumatotalporrecaudar;
						$html .="<tr><td ></td><td colspan=\"4\" ><hr/></td></tr>
						<tr ><td><font size=\"10\" ><strong>Total:</strong></font> </td><td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
						
						</tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
					}
				}
				$html .="
						<tr ><td colspan=\"2\"><font size=\"10\" ><strong>Total por Cobrar:</strong></font> </td><td align=\"right\" height=\"30\" colspan=\"4\" ><font size=\"12\"><strong>$".number_format($sumatoria,2,'.',',')."</strong></font></td></tr>";
				$html .= "</table>";
			
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->Output('Reportedeudoresresumen.pdf', 'I');
			
			break;
		case PRINTREP_DEUDORES_MENSUAL:
				$hoy = getdate();
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename='Reportedeudoresresumen.pdf'");
				
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator("Redlinks");
				$pdf->SetAuthor("Redlinks");
				$pdf->SetTitle("Reporte de Deudores - Resumen");
				$pdf->SetSubject("Reporte de Deudores - Resumen");
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('Helvetica', '', 9, '', 'false');

				$deuda->get_all_deudores_mensual($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin']);
				$tranx = $deuda->rows;
				
				$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			
				$html .= '<h2>Reporte de Deudores - Mensual </h2> ';	 
				$html .= '<h3>Reporte de Deudores - Mensual</h3> ';
				$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
				if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
				if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
				$html .= '<h5>Fecha de vencimiento del: '.$fini.', hasta el: '.$ffin.'.</h5>';
				$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';
				$html .='<table cellspacing="0" cellpadding="2" border="0">';
				$col=0;
				// Datos
				$cursoactual="";
				$contadorcabec=0;
			 
				$grupo="";
			  	$sumatotal=0;
				$sumatotalrecaudado=0;
				$sumatotaldescuentos=0;
				$sumatotalporrecaudar=0;
				$sumatoria=0;
				for($i=0;$i<count($tranx)-1;$i++)
				{
				  $col=0;
					if($grupo!=$tranx[$i][0])
					{
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotalporrecaudar=0;
						$grupo=$tranx[$i][0];
						$html .="<tr><td colspan=\"5\"></td></tr>
						<tr ><td height=\"30\" colspan=\"5\" ><font size=\"14\"><strong>".$grupo."</strong></font></td></tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
						
						$html .= "<tr>";	
							$html .= "<td width=\"35%\"><font size=\"8\"></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total de Facturas</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Recaudado</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Descuentos</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total por Recaudar</strong></font></td>";
						$html .= "</tr>";
					}
					
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][2],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
					
						$sumatotal=$sumatotal+$tranx[$i][2];
						$sumatotalrecaudado=$sumatotalrecaudado+$tranx[$i][3];
						$sumatotaldescuentos=$sumatotaldescuentos+$tranx[$i][4];
						$sumatotalporrecaudar=$sumatotalporrecaudar+$tranx[$i][5];
					$html .= "</tr>";
					if($grupo!=$tranx[$i+1][0])
					{	$sumatoria=$sumatoria+$sumatotalporrecaudar;
						$html .="<tr><td ></td><td colspan=\"4\" ><hr/></td></tr>
						<tr ><td><font size=\"10\" ><strong>Total:</strong></font> </td><td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
						
						</tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
					}
				}
				$html .="
						<tr ><td colspan=\"2\"><font size=\"10\" ><strong>Total por Cobrar:</strong></font> </td><td align=\"right\" height=\"30\" colspan=\"4\" ><font size=\"12\"><strong>$".number_format($sumatoria,2,'.',',')."</strong></font></td></tr>";
				$html .= "</table>";

				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->Output('Reportedeudoresresumen_mensual.pdf', 'I');
			
			break;
		case PRINTREP_DEUDORES_CURSO:
				$hoy = getdate();
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename='Reportedeudoresresumen.pdf'");
				
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator("Redlinks");
				$pdf->SetAuthor("Redlinks");
				$pdf->SetTitle("Reporte de Deudores - Curso");
				$pdf->SetSubject("Reporte de Deudores - Curso");
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('Helvetica', '', 9, '', 'false');
				
				$deuda->get_all_deudores_curso($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin']);
				$tranx = $deuda->rows;
				
				$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			
				$html .= '<h2>Reporte de Deudores - Curso </h2> ';	 
				$html .= '<h3>Reporte de Deudores - Curso</h3> ';
				$html .= '<h5>Fecha de impresi&oacute;n: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3> ';
				if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
				if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
				$html .= '<h5>Fecha de vencimiento del: '.$fini.', hasta el: '.$ffin.'.</h5>';
				$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';
				$html .='<table cellspacing="0" cellpadding="2" border="0">';
				$col=0;
				// Datos
				$cursoactual="";
				$contadorcabec=0;
			 
				$grupo="";
			  	$sumatotal=0;
				$sumatotalrecaudado=0;
				$sumatotaldescuentos=0;
				$sumatotalporrecaudar=0;
				$sumatoria=0;
				for($i=0;$i<count($tranx)-1;$i++)
				{
				  $col=0;
					if($grupo!=$tranx[$i][0])
					{
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotalporrecaudar=0;
						$grupo=$tranx[$i][0];
						$html .="<tr><td colspan=\"5\"></td></tr>
						<tr ><td height=\"30\" colspan=\"5\" ><font size=\"14\"><strong>".$grupo."</strong></font></td></tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
						
						$html .= "<tr>";	
							$html .= "<td width=\"35%\"><font size=\"8\"></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total de Facturas</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Recaudado</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total Descuentos</strong></font></td>";
							$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\"><strong>Total por Recaudar</strong></font></td>";
						$html .= "</tr>";
					}
					
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][2],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"16,25%\" align=\"right\"><font size=\"8\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
					
						$sumatotal=$sumatotal+$tranx[$i][2];
						$sumatotalrecaudado=$sumatotalrecaudado+$tranx[$i][3];
						$sumatotaldescuentos=$sumatotaldescuentos+$tranx[$i][4];
						$sumatotalporrecaudar=$sumatotalporrecaudar+$tranx[$i][5];
					$html .= "</tr>";
					if($grupo!=$tranx[$i+1][0])
					{	$sumatoria=$sumatoria+$sumatotalporrecaudar;
						$html .="<tr><td ></td><td colspan=\"4\" ><hr/></td></tr>
						<tr ><td><font size=\"10\" ><strong>Total:</strong></font> </td><td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
						<td align=\"right\" height=\"30\"  ><font size=\"10\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
						
						</tr>
						<tr><td colspan=\"5\"><hr/></td></tr>";
					}
				}
				$html .="
						<tr ><td colspan=\"2\"><font size=\"10\" ><strong>Total por Cobrar:</strong></font> </td><td align=\"right\" height=\"30\" colspan=\"4\" ><font size=\"12\"><strong>$".number_format($sumatoria,2,'.',',')."</strong></font></td></tr>";
				$html .= "</table>";

				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->Output('Reportedeudoresresumen_curso.pdf', 'I');
			
			break;
		case PRINTREPVISOR:
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$gene_data['url'].'"></iframe>
				  </div>';
			
			break;
		case CHANGE_PERIODO:
			$_SESSION['peri_codi']=$user_data['peri_codi'];
			$_SESSION['peri_deta']=$user_data['peri_deta'];
			echo "¡Exito! Período activo cambiado correctamente.";
			break;
		case CHANGE_LOGO:
			$_SESSION['skin'] = $user_data['cls'];
			if ($user_data['logo'] == 'WHITE')
			{  	$_SESSION['dir_logo_educalinks_long'] = "/../".$_SESSION['dir_logo_educalinks_long_white'];
				$_SESSION['dir_logo_educalinks_long_small'] = "/../".$_SESSION['dir_logo_educalinks_long_white_small'];
			}
			if ($user_data['logo'] == 'RED')
			{  	$_SESSION['dir_logo_educalinks_long'] = "/../".$_SESSION['dir_logo_educalinks_long_red'];
				$_SESSION['dir_logo_educalinks_long_small'] = "/../".$_SESSION['dir_logo_educalinks_long_red_small'];
			}
			if ($user_data['logo'] == 'WHITE_RED')
			{  	$_SESSION['dir_logo_educalinks_long'] = "/../".$_SESSION['dir_logo_educalinks_long_white_red'];
				$_SESSION['dir_logo_educalinks_long_small'] = "/../".$_SESSION['dir_logo_educalinks_long_red_small'];
			}
			$data = '<span class="logo-mini"><div style="margin-top:10px" id="div_nav_logo_small" name="div_nav_logo_small"><img src=\'..'.
						$_SESSION['dir_logo_educalinks_long_small'].'\' alt=\'Educalinks\'></div></span>'.
					'<span class="logo-lg"><div style="margin-left:-10px;margin-top:10px" id="div_nav_logo" name="div_nav_logo"><img src=\'..'.
						$_SESSION['dir_logo_educalinks_long'].'\' alt=\'EL\'></div></span>';
			echo $data;
			break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
			header("Location:".$domain);
		break;
    }
}


function set_obj() {
    $obj = new General();
    return $obj;
}

function helper_data() {
    $gene_data = array();
    if($_POST) {
        if(array_key_exists('usua_codigo', $_POST)) { 
            $gene_data['usua_codigo'] = $_POST['usua_codigo']; 
        }
		if(array_key_exists('usua_clave', $_POST)) { 
            $gene_data['usua_clave'] = $_POST['usua_clave']; 
        }
		if(array_key_exists('pass_new', $_POST)) { 
            $gene_data['pass_new'] = $_POST['pass_new']; 
        }
		if(array_key_exists('url', $_POST)) { 
            $gene_data['url'] = $_POST['url']; 
        }
		if(array_key_exists('fecha', $_POST)) { 
            $gene_data['fecha'] = $_POST['fecha']; 
        }
		if(array_key_exists('curso', $_POST)) { 
            $gene_data['curso'] = $_POST['curso']; 
        }
		if(array_key_exists('prontopago', $_POST)) { 
            $gene_data['prontopago'] = $_POST['prontopago']; 
        }
    } else if($_GET) {
        if(array_key_exists('usua_codigo', $_GET)) { 
            $gene_data['usua_codigo'] = $_GET['usua_codigo']; 
        }
		if(array_key_exists('usua_clave', $_GET)) { 
            $gene_data['usua_clave'] = $_GET['usua_clave']; 
        }
		if(array_key_exists('pass_new', $_GET)) { 
            $gene_data['pass_new'] = $_GET['pass_new']; 
        }
		if(array_key_exists('url', $_GET)) { 
            $gene_data['url'] = $_GET['url']; 
        }
		if(array_key_exists('fecha', $_GET)) { 
            $gene_data['fecha'] = $_GET['fecha']; 
        }
		if(array_key_exists('curso', $_GET)) { 
            $gene_data['curso'] = $_GET['curso']; 
        }
		if(array_key_exists('prontopago', $_GET)) { 
            $gene_data['prontopago'] = $_GET['prontopago']; 
        }
    }
    return $gene_data;
}

handler();
?>