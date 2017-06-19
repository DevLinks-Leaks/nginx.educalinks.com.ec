<?php
//set_time_limit(200);
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('funciones.php');
require_once('../../finan/items/model.php');
require_once('../../finan/puntos_emision/model.php');
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
    $gene_data 	= helper_data();	//variables que llegan por post desde el javascript
	$user_data 	= get_frontData(); //variables que llegan por post desde el javascript
    $general 	= set_obj();
	$gene		= set_obj();
	$cursos 	= set_obj();
	$periodos 	= set_obj();
	$periodo 	= get_mainObject('Periodo');
	$permiso 	= set_obj();
	$pensiones 	= set_obj();
    $apikey 	= set_obj();
	$deuda 		= set_obj();
	$item 		= get_mainObject('Item');
    $sucursales = get_mainObject('PtoEmision');
	
    switch ($event) 
	{	case MAIN:
			$general->login($gene_data['usua_codigo'],$gene_data['usua_clave']);
            global $diccionario;
			
			$apikey->getapikey();
            $gene->apertura_caja($gene_data['usua_codigo']);
			
			$_SESSION['caja_codi']=$gene->caja_codi;
			$_SESSION['caja_fecha']=$gene->caja_fecha;
			
			$periodo->get_all_selectFormat();
			$cmb_sidebar_periodo = 
			'<select name="cmb_sidebar_periodo" id="cmb_sidebar_periodo" required="required" class="form-control input-sm"
						onchange="js_general_change_periodo(document.getElementById(\'ruta_html_common\').value + \'/general/controller.php\' )" 
						onmouseover="$(this).tooltip(\'show\');"
						title="Período activo"
						data-placement="left"
						style="margin-top:7px">';
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
				
				$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_red'];
				$_SESSION['dir_logo_educalinks_long_small'] = $_SESSION['dir_logo_educalinks_long_white_small'];
				
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
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='1305';
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
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
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					break;
				case  "dev.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['contribuyente_especial']='9999';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='dev.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
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
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					break;
				case  "liceonaval.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceonaval;
					$_SESSION['passllaveactiva']=$clavellaveliceonaval;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='liceonaval.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceonaval;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceonaval;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceonaval_bg;
					break;
				case  "liceonavalvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceonaval;
					$_SESSION['passllaveactiva']=$claveliceonaval;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='liceonavalvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceonaval;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceonaval;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceonaval_bg;
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					break;
				case  "novus.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavenovus;
					$_SESSION['passllaveactiva']=$clavellavenovus;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['contribuyente_especial']='';
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='novus.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_novus;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_novus;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_novus_bg;
					break;
				case  "preprod.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=1;
					$_SESSION['contribuyente_especial']='1305';
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='preprod.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
				}
				$data['usua_permiso']=$_SESSION['usua_permiso'];
				
				
				$general -> get_datos_home();
				$home_datos = $general->rows;
				$deuda_minitabla = new General();
				$deuda_minitabla -> get_datos_home_deudas_minitabla();
				$html1 = $html2 ="";
				$i=$j=0;
				$color = "blue,red,green,yellow,aqua";
				$totalDeudas = $totalPagadas = 0;
				$colors = explode(",", $color);
				foreach($deuda_minitabla->rows as $row)
				{	if( !empty( $row ) )
					{   
						$width = (($row[1]*100)/$row[2]);
						
						$totalPagadas = $totalPagadas + $row[1] ;
						$totalDeudas = $totalDeudas + $row[2] ;
						
						$html2.= '<div class="progress-group">
									<span class="progress-text">'.$row[0].'</span>
									<span class="progress-number"><b>'.$row[1].'</b>/'.$row[2].'</span>

									<div class="progress sm">
									<div class="progress-bar progress-bar-'.$colors[$i].'" style="width: '.$width.'%"></div>
									</div>
									</div>';
						if( $row[1] != $row[2] )
						{
							$html1.= '<div class="progress-group">
										<span class="progress-text">'.$row[0].'</span>
										<span class="progress-number"><b>'.$row[1].'</b>/'.$row[2].'</span>

										<div class="progress sm">
										<div class="progress-bar progress-bar-'.$colors[$j].'" style="width: '.$width.'%"></div>
										</div>
										</div>';
							$j++;
							if( $j == '5' )
							$j=0;
						}
						$i++;
						if( $i == '5' )
							$i=0;
					}
				}
			
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
                'numPagos'=>$home_datos[0][0],
                'totalPagos'=>$home_datos[0][1],
                'numFacturas'=>$home_datos[0][2],
                'numCajas'=>$home_datos[0][3],
                'deudaMiniTabla'=>$html1,
                'deudaMiniTabla2'=>$html2,
                'totalPagadas'=>$totalPagadas,
                'totalDeudas'=>$totalDeudas,
				'{combo_periodo}' => array(	"elemento"  => "combo", 
											"datos"     => $periodo->rows, 
                                            "options"   => array("name"=>"periodos","id"=>"periodos","required"=>"required", "class"=>"form-control input-sm",
                                            "onChange"=>"cargaNivelesEconomicos('resultadoNivelEcon','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php');"),
											"selected"  => $_SESSION['peri_codi'] ),
													  
													  
													  
				'{combo_cursos}' => array("elemento"  => "combo", 
														
                                                      "datos"     => array(0 => array(0 => -1, 
                                                                                      1 => '- Seleccione curso -',
                                                                                      3 => ''), 
                                                                           1=> array()),
                                                      "options"   => array("name"=>"curso","id"=>"curso","required"=>"required", "class"=>"form-control input-sm",
													  "onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
													  "selected"  => -1)
				);
				$item->get_item_selectFormat('');
				$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-placeholder='- Seleccione producto -' style='width:320px;'>";
				
				foreach( $item->rows as $options )
				{   if (!empty($options))
					{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
					}
				}
				$select.= "</select>";
				
				$data['combo_producto'] = $select;
				$niveles = new General();
				$niveles->get_all_niveles_economicos();
				$data['{combo_nivel}']	= array(	
											"elemento"  => 	"combo", 
											"datos"     => 	$niveles->rows, 
											"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																	"id"=>"cmb_nivelesEconomicos",
																	"required"=>"required",
																	"class"=>"form-control input-sm",
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
			$general -> get_datos_home();
			$home_datos = $general->rows;
			$deuda_minitabla = new General();
			$deuda_minitabla -> get_datos_home_deudas_minitabla();
			$html1 = $html2 ="";
			$i=$j=0;
			$color = "blue,red,green,yellow,aqua";
			$totalDeudas = $totalPagadas = 0;
			$colors = explode(",", $color);
			foreach($deuda_minitabla->rows as $row)
			{	if( !empty( $row ) )
				{   
					$width = (($row[1]*100)/$row[2]);
					
					$totalPagadas = $totalPagadas + $row[1] ;
					$totalDeudas = $totalDeudas + $row[2] ;
					
					$html2.= '<div class="progress-group">
								<span class="progress-text">'.$row[0].'</span>
								<span class="progress-number"><b>'.$row[1].'</b>/'.$row[2].'</span>

								<div class="progress sm">
								<div class="progress-bar progress-bar-'.$colors[$i].'" style="width: '.$width.'%"></div>
								</div>
								</div>';
					if( $row[1] != $row[2] )
					{
						$html1.= '<div class="progress-group">
									<span class="progress-text">'.$row[0].'</span>
									<span class="progress-number"><b>'.$row[1].'</b>/'.$row[2].'</span>

									<div class="progress sm">
									<div class="progress-bar progress-bar-'.$colors[$j].'" style="width: '.$width.'%"></div>
									</div>
									</div>';
						$j++;
						if( $j == '5' )
						$j=0;
					}
					$i++;
					if( $i == '5' )
						$i=0;
				}
			}
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
                'numPagos'=>$home_datos[0][0],
                'totalPagos'=>$home_datos[0][1],
                'numFacturas'=>$home_datos[0][2],
                'numCajas'=>$home_datos[0][3],
                'deudaMiniTabla'=>$html1,
                'deudaMiniTabla2'=>$html2,
                'totalPagadas'=>$totalPagadas,
                'totalDeudas'=>$totalDeudas,
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
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
															"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control input-sm"),
										"selected"  => -1);
			
			$item->get_item_selectFormat('');
			$select = "<select multiple='multiple' id=\"cmb_producto\" name=\"cmb_producto[]\" class='form-control' data-placeholder='- Seleccione producto -' style='width:320px;'>";
			
			foreach( $item->rows as $options )
			{   if (!empty($options))
				{   $select .= "<option value='".$options[0]."' >".$options[1]."</option>";
				}
			}
			$select.= "</select>";
			
			$data['combo_producto'] = $select;
			$niveles = new General();
			$niveles->get_all_niveles_economicos();
			$data['{combo_nivel}']	= array(	
										"elemento"  => 	"combo", 
										"datos"     => 	$niveles->rows, 
										"options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																"id"=>"cmb_nivelesEconomicos",
																"required"=>"required",
																"class"=>"form-control input-sm",
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
		case CONFIG_PAGOWEB:
			$general->get_pagoweb_config();
			$para="";
			$sucursales->get_all_sucursales($para);
			$data = array(
				'pto_prefijo_web_value'=>$general->puntVent_prefijo,
                'pto_secuencia_web_value'=>$general->puntVent_secuencia);
			
			if ( $general->cajeroweb != 'A' )
			{	$data['dsbld'] = ' checked="checked" ';
				$data['pto_secuencia_web_dsbld'] = ' disabled="disabled" ';
				$data['pto_prefijo_web_dsbld'] = ' disabled="disabled" ';
				$data['{combo_sucursal}'] = array("elemento"  => "combo",
														   "datos"     => $sucursales->rows,
														   "options"   => array("name"=>"pto_sucursal_web",
																				"id"=>"pto_sucursal_web",
																				"required"=>"required",
																				"class"=>"form-control",
																				"disabled"  => "disabled"),
														   "selected"  => $general->puntVent_codigoSucursal);
			}
			else
			{   $data['enbld'] = ' checked="checked" ';
				$data['pto_secuencia_web_dsbld'] = '';
				$data['pto_prefijo_web_dsbld'] = '';
				$data['{combo_sucursal}'] = array("elemento"  => "combo", 
														   "datos"     => $sucursales->rows, 
														   "options"   => array("name"=>"pto_sucursal_web",
																				"id"=>"pto_sucursal_web",
																				"required"=>"required",
																				"class"=>"form-control"), 
														   "selected"  => $general->puntVent_codigoSucursal);
			}
			retornar_formulario(VIEW_CONFIG_PAGOS_WEB, $data);
		break;
		case SET_PAGOWEB:
			$general->set_pagoweb_config( $user_data['active_web'], $user_data['puntVent_prefijo'], 
										  $user_data['puntVent_codigoSucursal'], $user_data['puntVent_secuencia'] );
			print_r($general->mensaje);
		break;
		case CONFIG_CHANGE:
			$general->get_prontopago();
			if ($general->usa_pp_dv=='S')
				$disabled_usa_pp_dv='checked=checked';
			else
				$usa_pp_dv_disable_txtpp=' disabled="disabled" ';
			if ($general->enviar_fac_sri_en_cobro=='S')
				$disabled_enviar_fac_sri_en_cobro='checked=checked';
			if ($general->enviar_cheque_a_bandeja=='S')
				$enviar_cheque_a_bandeja='checked=checked';
			if ($general->bloqueo=='true')
				$disabled_bloqueo='checked=checked';
			if ($general->generar_deuda_matricula=='S')
				$disabled_gdm='checked=checked';
			if ($general->bloquear_matricula_deuda=='S')
				$disabled_bmpd='checked=checked';
			if ($general->biblio_genera_multa_por_mora=='S')
				$disabled_bgmpm='checked=checked';
			if ($general->biblio_bloquea_prestamo_por_deuda=='S')
				$disabled_bbppp='checked=checked';
			$permiso->permiso_activo($_SESSION['usua_codigo'], 226);
			if ( $permiso->rows[0]['veri'] == 1 )
				$display_config_contifico = " style='display:inline;' ";
			else
				$display_config_contifico = " style='display:none;' ";
            $data = array(
				'usa_pp_dv'=>$disabled_usa_pp_dv,
				'usa_pp_dv_disable_txtpp'=>$usa_pp_dv_disable_txtpp,
				'prontopago'=>$general->prontopago,
				'prepago'=>$general->prepago,
				'enviar_fac_sri_en_cobro'=>$disabled_enviar_fac_sri_en_cobro,
				'enviar_cheque_a_bandeja'=>$enviar_cheque_a_bandeja,
				'bloqueo'=>$disabled_bloqueo,
				'apikey'=>$general->apikeycontifico,
				'apikeytoken'=>$general->apikeytoken,
				'genera_deuda_matr'=>$disabled_gdm,
				'bloqueo_matr_por_deuda'=>$disabled_bmpd,
				'biblio_genera_multa_por_mora'=>$disabled_bgmpm,
				'biblio_bloquea_prestamo_por_deuda'=>$disabled_bbppp,
				'cliente_contifico'=>$display_config_contifico,
				);
			if ( $general->metodo_descuento_alumno == 'desc_sobre' )
				$data['desc_sobre'] = 'checked';
			else if ( $general->metodo_descuento_alumno == 'desc_sumado' )
				$data['desc_sumado'] = 'checked';
			else
				$data['desc_sumado'] = 'checked';
			retornar_formulario(VIEW_CONFIG_SIS, $data);
		break;
		case SET_SETTINGS:
			if ( $user_data['usa_pp_dv'] == 'true' )
				$usa_pp_dv = 'S';
			else
				$usa_pp_dv = 'N';
			if ( $user_data['enviar_fac_sri_en_cobro'] == 'true' )
				$enviar_fac_sri_en_cobro = 'S';
			else
				$enviar_fac_sri_en_cobro = 'N';
			if ( $user_data['enviar_cheque_a_bandeja'] == 'true' )
				$enviar_cheque_a_bandeja = 'S';
			else
				$enviar_cheque_a_bandeja = 'N';
			if ( $user_data['gdm'] == 'true' )
				$gdm = 'S';
			else
				$gdm = 'N';
			if ( $user_data['bmpd'] == 'true' )
				$bmpd = 'S';
			else
				$bmpd = 'N';
			if ( $user_data['bgmpm'] == 'true' )
				$bgmpm = 'S';
			else
				$bgmpm = 'N';
			if ( $user_data['bbppp'] == 'true' )
				$bbppp = 'S';
			else
				$bbppp = 'N';
			$general->change_settings(	$usa_pp_dv,
										$user_data['prontopago'],
										$user_data['iva'],
										$enviar_fac_sri_en_cobro,
										$enviar_cheque_a_bandeja,
										$user_data['rdb_metodo_descuento'],
										$user_data['bloqueo'],
										$user_data['apikey'],
										$user_data['apikeytoken'],
										$gdm,
										$bmpd,
										$bgmpm,
										$bbppp,
										$_SESSION['usua_codigo']);
			$_SESSION['apikey'] = $user_data['apikey'];
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
																"class"=>"form-control input-sm",
																"onChange"	=>	"cargaCursosPorNivelEconomico('resultadoCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
										"selected"  => -1);
			retornar_result($data);
            break;
		case UNSET_CURSO:
			global $diccionario;
			$data['{combo_cursos}'] = array(
										"elemento"  => "combo", 
										"datos"     => array(0 => array(0 => -1, 
																		1 => '- Seleccione curso -',
																		3 => ''), 
                                                                        2=> array()),
										"options"   => array("name"=>"curso","id"=>"curso","required"=>"required","class"=>"form-control input-sm",
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
																			"class"=>"form-control input-sm",
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
																"class"=>"form-control input-sm",
																"onChange"=>"cargaDeudores('resultado','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"
															),
                                            "selected"  => -1);
			retornar_result($data);
            break;
		case GET_DEUDORES: //IMPRIME LA TABLA PRINCIPAL
			if ( $user_data['peri_codi'] == "" )
				$peri_codi = $_SESSION['peri_codi'];
			else
				$peri_codi = $user_data['peri_codi'];
			
			if(!isset($user_data['prod_codigo']))
				$prod_codigo = '';
			else 
			{   $true=0;
				$productos = json_decode($user_data['prod_codigo'], true);
				$prod_codigo='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				foreach ( $productos as $producto )
				{   if( $producto!= '' )
					{   $prod_codigo.='<producto id="'.$producto.'" />';
						$true=1;
					}
				}
				$prod_codigo.="</productos>";
				if ( $true == 0 )
					$prod_codigo = '<?xml version="1.0" encoding="iso-8859-1"?><producto></producto>';
			}
			//$true es para que si no selecciona un producto, traiga todo el catálogo de productos.
			$pensiones->get_all_productos( $peri_codi, $prod_codigo );
			$test=$pensiones->rows;
			$encabezado=array();
			$i=0;
			foreach($test as $a)
			{	$encabezado[$i]=$a[0]; 
				$i++;
			}
           	$deuda->get_all_deudores(	$user_data['curs_codi'],	$user_data['nivelEcon_codi'],	$user_data['peri_codi'],
										$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],	$user_data['quienes'],
										$prod_codigo );
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
								"href"=>"#/",
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
			$construct_table .= "</tbody></table>";//.$deuda->ErrorToString();
            $data['tabla'] = $construct_table;
			retornar_formulario(VIEW_TBL_DEUDA, $data);
            break;
		case PRINTREP_DEUDORES: //IMPRIME EL PDF DE LA TABLA PRINCIPAL
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
			
			if(!isset($user_data['productos']))
				$prod_codigo = '';
			else
			{   $xml_productos='<?xml version="1.0" encoding="iso-8859-1"?><productos>';
				$productos = explode(',', $user_data['productos'] );
				foreach ( $productos as $producto )
				{
					$xml_productos.='<producto id="'.$producto.'" />';
				}
				$xml_productos.="</productos>";
			}
			
			$deuda->get_all_deudores(	$user_data['curs_codi'],	$user_data['nivelEcon_codi'],	$user_data['peri_codi'],
										$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],	$user_data['quienes'], 
										$xml_productos );
			$pensiones->get_all_productos( $peri_codi, $xml_productos );
			$test=$pensiones->rows;
			array_pop($test);
			$tranx = $deuda->rows;
			
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
		
			$html .= '<h2>Reporte de deudores - Deuda por producto/servicio</h2>';
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
			$html .='<tr><td></td><td colspan="2" align="center"><b><small>TOTAL PRODUCTO/SERVICIO</small></b></td>';
			for($aux=4;$aux<($col2+1);$aux++)
			{	$html .= "<td align=\"right\"><font size=\"8\"><b>$".number_format($total_mensual[$aux],2,'.',',')."</b></font></td>";
			}
			
			$html .="</tr>";
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportedeudores.pdf', 'I');
			break;
		case PRINTREP_DEUDORES_REPT_XLS:
			$hoy = getdate();
			if(strlen($user_data['fechavenc_ini'])>0) $fini=$user_data['fechavenc_ini']; else $fini='n/a';
			if(strlen($user_data['fechavenc_fin'])>0) $ffin=$user_data['fechavenc_fin']; else $ffin='n/a';
			
			$titulo = $subtitulo = "";
			switch($user_data['quienes'])
			{	case 'P':
					$subtitulo='Deudas pagadas';
				break;
				case 'PC':
					$subtitulo='Deudas por cobrar';
				break;
				case 'T':
					$subtitulo='Todas las deudas (Pagadas/Por cobrar/Anuladas)';
				break;
			}
			switch($user_data['eventox'])
			{	case 'print_deudores_curso':
					$deuda->get_all_deudores_curso($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='Reporte de Deudores - Curso';
				break;
				case 'print_deudores_curso_detalle':
					$deuda->get_all_deudores_persona($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='Reporte de Deudores - Curso (detallado)';
				break;
				case 'print_deudores_mensual':
					$deuda->get_all_deudores_mensual($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='Reporte de Deudores - Por Producto';
				break;
				case 'print_deudores_mensual_detalle':
					$deuda->get_all_deudores_mensual_detalle($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='Reporte de Deudores - Mensual (detallado)';
				break;
				case 'print_deudores_resumen':
					$deuda->get_all_deudores_resumen($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='Reporte de Deudores - Resumen';
				break;
			}
			require_once('../../../includes/common/PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
			->setCreator('Redlinks')
			->setLastModifiedBy('Redlinks')
			->setTitle($titulo)
			->setSubject($titulo)
			->setDescription("Fecha de vencimiento del: ".$fini.", hasta el: ".$ffin.".");
			
			//Escala de impresión
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(55);
			//Horizontal
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			
			//Márgenes
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.25);
			
			//ESPACIO AMPLIO PARA CABECERAS
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$styleTitulo = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'000000'),
								'size' => 14,
								'bold' => true,
								'name' => 'Helvetica')
			);
			$styleEncabezado = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 11,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '5A8FDC'))
			);
			$styleCabeceras = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('size' => 9,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'E1EAF8'))
			);
			$styleTotalFinal = array(
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'font' => array('color' => array('rgb'=>'FFFFFF'),
								'size' => 12,
								'bold' => true,
								'name' => 'Helvetica'),
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => '20529b'))
			);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 1, $titulo );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 2, 'Fecha de impresión: '.$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.' );
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( 0, 3, "Fecha de vencimiento del: ".$fini.", hasta el: ".$ffin.". ".$subtitulo );
			$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
			$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( $styleTitulo );
			
			$objPHPExcel->getActiveSheet()->getColumnDimension( A )->setWidth(50);
				
			$column = 'A';
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold( true );
			
			$latestBLColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$column = 'A';
			$row = 4;
			$i_deta_fila=4;
			
			$tranx = $deuda->rows;
			
			// Datos
			$cursoactual="";
			$contadorcabec=0;
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			if( $user_data['eventox'] == 'print_deudores_curso_detalle' )
			{	
				$cabeceras ='F. creación,T. Bruto,T. Dscto.,T. I.V.A.,T. Neto,T. Abonado,T. N/C,T. Pendiente,% Pdte.,Teléfono';
				$cabecera = explode( ",", $cabeceras );
				
				for($i=0;$i<count($tranx)-1;$i++)
				{	if($curso!=$tranx[$i][10])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][10];
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$curso."");
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
				
						$i_deta_fila=$i_deta_fila+1;
					}
					if($grupo!=$tranx[$i][0])
					{	$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][10];
						
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$i_cabe=1;//Contador de cabeceras
						$column = 'B';
						
						foreach($cabecera as $head)
						{	if( !empty( $head ) )
							{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$i_cabe=$i_cabe+1;
								$column++;
							}
						}
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
						$l++;
					}
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$tranx[$i][1]."" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Fecha creación deuda
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "".$tranx[$i][2]."" );
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					for( $aux=2; $aux<=8; $aux++ )
					{   //Valores monetarios
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $aux, $i_deta_fila, "$".number_format($tranx[$i][($aux+1)],2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					}
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					//Teléfono
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "".$tranx[$i][11]."" );
					$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle( 10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
						
					$sumatotal				=$sumatotal				+ $tranx[$i][3];
					$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
					$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
					$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
					$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
					$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
					$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
					
					$i_deta_fila=$i_deta_fila+1;
					$k++;
					if($grupo!=$tranx[$i+1][0])
					{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
						$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
						
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Subtotal de ".$k." deuda(s):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Fecha creación deuda
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Teléfono
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
					}
					if($curso!=$tranx[$i+1][10])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total (".$curso."):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Fecha creación deuda
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($total,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($totaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($totaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($totalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($totalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($totalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($totalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Teléfono
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$i_deta_fila=$i_deta_fila+1;
					}
				}
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total de ".$l." alumno(s) y ".$i." deuda(s):" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Fecha creación deuda
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "" );
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Valores monetarios
				
				//1
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($finaltotal,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//2
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($finaltotaldescuentos,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//3
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($finaltotaliva,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//4
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($finaltotalneto,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//5
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($finaltotalrecaudado,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//6
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalnc,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//7
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//. Valores monetarios
				
				//% Pdte.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 9, $i_deta_fila, "".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%" );
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(9, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Teléfono
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 10, $i_deta_fila, "" );
				$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(10, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total por Cobrar:" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Total Por Cobrar $X
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',') );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':K'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				$objPHPExcel->getActiveSheet()->setTitle('Reporte deudores');
				$objPHPExcel->setActiveSheetIndex(0);
			}
			else
			{   $cabeceras ='T. Bruto,T. Dscto.,T. I.V.A.,T. Neto,T. Abonado,T. N/C,T. Pendiente,% Pdte.';
				$cabecera = explode( ",", $cabeceras );
				
				for($i=0;$i<count($tranx)-1;$i++)
				{	if($curso!=$tranx[$i][9])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][9];
						
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$curso."");
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle( 0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleEncabezado );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
				
						$i_deta_fila=$i_deta_fila+1;
						$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][9];
						
						$detalle_header = $grupo;
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$i_cabe=1;//Contador de cabeceras
						$column = 'B';
						
						foreach($cabecera as $head)
						{	if( !empty( $head ) )
							{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
								$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
								$i_cabe=$i_cabe+1;
								$column++;
							}
						}
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleCabeceras );
						$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
						
						$i_deta_fila=$i_deta_fila+1;
					}else
					{   if($grupo!=$tranx[$i][0])
						{	$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							
							$detalle_header = $grupo;
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$grupo."" );
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$i_cabe=1;//Contador de cabeceras
							$column = 'B';
							
							foreach($cabecera as $head)
							{	if( !empty( $head ) )
								{   $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow( $i_cabe, $i_deta_fila, $head );
									$objPHPExcel->getActiveSheet()->getColumnDimension( $column )->setWidth(15);
									$i_cabe=$i_cabe+1;
									$column++;
								}
							}
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleCabeceras );
							$objPHPExcel->getActiveSheet()->getStyle($i_deta_fila)->getFont()->setBold( true );
							
							$i_deta_fila=$i_deta_fila+1;
						}
					}
					//Nombre alumno
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "".$tranx[$i][1]."" );
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					for( $aux=1; $aux<=7; $aux++ )
					{   //Valores monetarios
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $aux, $i_deta_fila, "$".number_format($tranx[$i][($aux+1)],2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle($aux, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					}
					//% Pdte.
					$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($tranx[$i][8]*100)/$tranx[$i][5],2,'.',',')."%" );
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
					$sumatotal				=$sumatotal				+ $tranx[$i][2];
					$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][3];
					$sumatotaliva			=$sumatotaliva			+ $tranx[$i][4];
					$sumatotalneto			=$sumatotalneto			+ $tranx[$i][5];
					$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][6];
					$sumatotalnc			=$sumatotalnc			+ $tranx[$i][7];
					$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][8];
					
					$i_deta_fila=$i_deta_fila+1;
					
					$k++;
					$l++;
					if($grupo!=$tranx[$i+1][0] )
					{	$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
													
						if ( $user_data['eventox'] == 'print_deudores_curso' || $user_data['eventox'] == 'print_deudores_mensual_detalle' )
						{	if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
							else
								$detalle_subtotal="Subtotal (1 alumnos):";
						}
						else
						{   if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." cursos):";
							else
								$detalle_subtotal="Subtotal (1 curso):";
						}
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_subtotal );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
					
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
						$i_deta_fila=$i_deta_fila+1;
					}
					else
					{   if ( ( $user_data['eventox'] == 'print_deudores_mensual_detalle' ) && ( $curso!=$tranx[$i+1][9] ) )
						{	$total				= $total			+ $sumatotal;
							$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
							$totaliva			= $totaliva			+ $sumatotaliva;
							$totalneto			= $totalneto		+ $sumatotalneto;
							$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
							$totalnc			= $totalnc			+ $sumatotalnc;
							$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
							
							if ($k>1)
									$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
								else
									$detalle_subtotal="Subtotal (1 alumnos):";
							//Nombre alumno
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_subtotal );
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							//Valores monetarios
							
							//1
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($sumatotal,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//2
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($sumatotaldescuentos,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//3
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($sumatotaliva,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//4
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($sumatotalneto,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//5
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($sumatotalrecaudado,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//6
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($sumatotalnc,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							//7
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($sumatotalporrecaudar,2,'.',',')."" );
							$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
							//. Valores monetarios
							
							//% Pdte.
							$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%" );
							$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							
							$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
							$i_deta_fila=$i_deta_fila+1;
						}
					}
					if($curso!=$tranx[$i+1][9])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						
						//Nombre alumno
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total (".$curso."):" );
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//Valores monetarios
						
						//1
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($total,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//2
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($totaldescuentos,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//3
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($totaliva,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//4
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($totalneto,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//5
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($totalrecaudado,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//6
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($totalnc,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						//7
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($totalporrecaudar,2,'.',',')."" );
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						//. Valores monetarios
						
						//% Pdte.
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%" );
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						
						$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
						$i_deta_fila=$i_deta_fila+1;
					}
				}
				if ( $user_data['eventox'] == 'print_deudores_curso')
				{	if ($i>1)
						$detalle_total="Total (de entre ".$i." alumnos):";
					else
						$detalle_total="Total (1 alumnos):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual_detalle' )
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." deudas):";
					else
						$detalle_total="Total (1 deuda):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual' )
				{   if ($l>1)
						$detalle_total="Total (de entre ".$l." productos):";
					else
						$detalle_total="Total (1 producto):";
				}
				else
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." cursos):";
					else
						$detalle_total="Total (1 curso):";
				}
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, $detalle_total );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Valores monetarios
				
				//1
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 1, $i_deta_fila, "$".number_format($finaltotal,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(1, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//2
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 2, $i_deta_fila, "$".number_format($finaltotaldescuentos,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(2, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//3
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 3, $i_deta_fila, "$".number_format($finaltotaliva,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(3, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//4
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 4, $i_deta_fila, "$".number_format($finaltotalneto,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(4, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//5
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 5, $i_deta_fila, "$".number_format($finaltotalrecaudado,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(5, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//6
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 6, $i_deta_fila, "$".number_format($finaltotalnc,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(6, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				//7
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',')."" );
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(7, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//. Valores monetarios
				
				//% Pdte.
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 8, $i_deta_fila, "".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%" );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				//Nombre alumno
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 0, $i_deta_fila, "Total por Cobrar:" );
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(0, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				//Total Por Cobrar $X
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( 7, $i_deta_fila, "$".number_format($finaltotalporrecaudar,2,'.',',') );
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle(8, $i_deta_fila)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
				$objPHPExcel->getActiveSheet()->getStyle( 'A'.$i_deta_fila.':I'.$i_deta_fila )->applyFromArray( $styleTotalFinal );
				$i_deta_fila=$i_deta_fila+1;
				
				$objPHPExcel->getActiveSheet()->setTitle('Reporte de deudores');
				$objPHPExcel->setActiveSheetIndex(0);
			}
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Reportedeudoresresumen.xlsx"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
			break;
		case PRINTREP_DEUDORES_REPT:
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reportedeudoresresumen.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Deudores - Curso (detallado)");
			$pdf->SetSubject("Reporte de Deudores - Curso (detallado)");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$titulo = $subtitulo = "";
			switch($user_data['quienes'])
			{	case 'P':
					$subtitulo='<h3>Deudas pagadas</h3> ';
				break;
				case 'PC':
					$subtitulo='<h3>Deudas por cobrar</h3> ';
				break;
				case 'T':
					$subtitulo='<h3>Todas las deudas (Pagadas/Por cobrar/Anuladas)</h3>';
				break;
			}
			switch($user_data['eventox'])
			{	case 'print_deudores_curso':
					$deuda->get_all_deudores_curso($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='<h2>Reporte de Deudores - Curso</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_curso_detalle':
					$deuda->get_all_deudores_persona($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='<h2>Reporte de Deudores - Curso (detallado)</h2>';
					$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_mensual':
					$deuda->get_all_deudores_mensual($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='<h2>Reporte de Deudores - Por Producto</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_mensual_detalle':
					$deuda->get_all_deudores_mensual_detalle($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='<h2>Reporte de Deudores - Mensual (detallado)</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
				case 'print_deudores_resumen':
					$deuda->get_all_deudores_resumen($user_data['curs_codi'],$user_data['nivelEcon_codi'],$user_data['peri_codi'],$user_data['fechavenc_ini'],$user_data['fechavenc_fin'],$user_data['quienes']);
					$titulo='<h2>Reporte de Deudores - Resumen</h2>';
					$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				break;
			}
			$tranx = $deuda->rows;
			$html .= $titulo;
			$html .= $subtitulo;
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
			$detalle_subtotal="";
			$grupo="";
			$curso="";
			$k=$l=0;
			$sumatotal=0;
			$sumatotalrecaudado=0;
			$sumatotaldescuentos=0;
			$sumatotaliva=0;
			$sumatotalneto=0;
			$sumatotalnc=0;
			$sumatotalporrecaudar=0;
			$total=0;
			$totalrecaudado=0;
			$totaldescuentos=0;
			$totaliva=0;
			$totalneto=0;
			$totalnc=0;
			$totalporrecaudar=0;
			$finaltotal=0;
			$finaltotalrecaudado=0;
			$finaltotaldescuentos=0;
			$finaltotaliva=0;
			$finaltotalneto=0;
			$finaltotalnc=0;
			$finaltotalporrecaudar=0;
			if( $user_data['eventox'] == 'print_deudores_curso_detalle' )
			{
				for($i=0;$i<count($tranx)-1;$i++)
				{	$col=0;
					if($curso!=$tranx[$i][10])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][10];
						$html .="
						<tr ><td height=\"25\" colspan=\"6\" ><font size=\"14\"><strong>".$curso."</strong></font></td></tr>
						<tr><td colspan=\"11\"><hr/></td></tr>";
					}
					if($grupo!=$tranx[$i][0])
					{	$k=0;
						$sumatotal_per_recaudado=0;
						$total_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$grupo=$tranx[$i][0];
						$curso=$tranx[$i][10];
						$html .= "<tr>";	
							$html .= "<td width=\"35%\"><font size=\"9\"><strong>".$grupo."</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>F. creación</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Abonado</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>T. Pendiente</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>% Pdte.</strong></font></td>";
							$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\"><strong>Teléfono</strong></font></td>";
						$html .= "</tr>";
						$l++;
					}
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"8\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".$tranx[$i][2]."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][6],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][7],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][8],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][9],2,'.',',')."</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".number_format(($tranx[$i][9]*100)/$tranx[$i][6],2,'.',',')."%</font></td>";
						$html .= "<td width=\"6.5%\" align=\"right\"><font size=\"5\">".$tranx[$i][11]."</font></td>";
						
						$sumatotal				=$sumatotal				+ $tranx[$i][3];
						$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][4];
						$sumatotaliva			=$sumatotaliva			+ $tranx[$i][5];
						$sumatotalneto			=$sumatotalneto			+ $tranx[$i][6];
						$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][7];
						$sumatotalnc			=$sumatotalnc			+ $tranx[$i][8];
						$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][9];
					$html .= "</tr>";
					$k++;
					if($grupo!=$tranx[$i+1][0])
					{	$total_per_recaudado = $total_per_recaudado + $sumatotal_per_recaudado;
						$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
						$html .="
						<tr >
							<td><font size=\"8\" ><strong>Subtotal de ".$k." deuda(s):</strong></font> </td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
						</tr>";
					}
					if($curso!=$tranx[$i+1][10])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						$html .="
						<tr >
							<td ><font size=\"5\" ><strong>Total (".$curso."):</strong></font> </td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($total,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%</strong></font></td>
						</tr>";
					}
				}
				$html .="
						<tr >
							<td ><font size=\"9\" ><strong>Total de ".$l." alumno(s) y ".$i." deuda(s):</strong></font> </td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($finaltotalporrecaudar*100)/$finaltotalneto,2,'.',',')."%</strong></font></td>
						</tr>";
				$html .= "<tr >
							<td colspan=\"2\"><font size=\"9\" ><strong>Total por Cobrar:</strong></font></td>
							<td align=\"right\" height=\"30\" colspan=\"7\" ><font size=\"8\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td></td></tr>";
				$html .= "</table>";
			}
			else
			{   for($i=0;$i<count($tranx)-1;$i++)
				{	$col=0;
					if($curso!=$tranx[$i][9])
					{	$k=0;
						$l=0;
						$sumatotal_per_recaudado=0;
						$sumatotal=0;
						$sumatotalrecaudado=0;
						$sumatotaldescuentos=0;
						$sumatotaliva=0;
						$sumatotalneto=0;
						$sumatotalporrecaudar=0;
						$sumatotalnc=0;
						$total=0;
						$totalrecaudado=0;
						$totaldescuentos=0;
						$totaliva=0;
						$totalneto=0;
						$totalnc=0;
						$totalporrecaudar=0;
						$curso=$tranx[$i][9];
						$html .="<tr><td colspan=\"9\"></td></tr>
						<tr ><td height=\"25\" colspan=\"9\" ><font size=\"8\"><strong>".$curso."</strong></font></td></tr>
						<tr><td colspan=\"9\"><hr/></td></tr>";
						$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							/*if ($grupo==$curso)
								$detalle_header = $grupo;
							else
								$detalle_header = "";*/
							$detalle_header = $grupo;
							$html .= "<tr>";	
								$html .= "<td width=\"35%\"><font size=\"6\"><strong>".$detalle_header."</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Abono</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Pdte</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>% Pdte</strong></font></td>";
							$html .= "</tr>";
					}else
					{   if($grupo!=$tranx[$i][0])
						{	$k=0;
							$sumatotal_per_recaudado=0;
							$total_per_recaudado=0;
							$sumatotal=0;
							$sumatotalrecaudado=0;
							$sumatotaldescuentos=0;
							$sumatotaliva=0;
							$sumatotalneto=0;
							$sumatotalporrecaudar=0;
							$sumatotalnc=0;
							$grupo=$tranx[$i][0];
							$curso=$tranx[$i][9];
							/*if ($grupo==$curso)
								$detalle_header = $grupo;
							else
								$detalle_header = "";*/
							$detalle_header = $grupo;
							$html .= "<tr>";	
								$html .= "<td width=\"35%\"><font size=\"6\"><strong>".$detalle_header."</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Bruto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Dscto.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. I.V.A.</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Neto</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Abono</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. N/C</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>T. Pdte</strong></font></td>";
								$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\"><strong>% Pdte</strong></font></td>";
							$html .= "</tr>";
						}
					}
					$html .= "<tr>";	
						$html .= "<td width=\"35%\"><font size=\"5\">".$tranx[$i][1]."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][2],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][3],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][4],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][5],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][6],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][7],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">$".number_format($tranx[$i][8],2,'.',',')."</font></td>";
						$html .= "<td width=\"8.125%\" align=\"right\"><font size=\"5\">".number_format(($tranx[$i][8]*100)/$tranx[$i][5],2,'.',',')."%</font></td>";
						
						$sumatotal				=$sumatotal				+ $tranx[$i][2];
						$sumatotaldescuentos	=$sumatotaldescuentos	+ $tranx[$i][3];
						$sumatotaliva			=$sumatotaliva			+ $tranx[$i][4];
						$sumatotalneto			=$sumatotalneto			+ $tranx[$i][5];
						$sumatotalrecaudado		=$sumatotalrecaudado	+ $tranx[$i][6];
						$sumatotalnc			=$sumatotalnc			+ $tranx[$i][7];
						$sumatotalporrecaudar	=$sumatotalporrecaudar	+ $tranx[$i][8];
					$html .= "</tr>";
					
					$k++;
					$l++;
					if($grupo!=$tranx[$i+1][0] )
					{	$total				= $total			+ $sumatotal;
						$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
						$totaliva			= $totaliva			+ $sumatotaliva;
						$totalneto			= $totalneto		+ $sumatotalneto;
						$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
						$totalnc			= $totalnc			+ $sumatotalnc;
						$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
													
						if ( $user_data['eventox'] == 'print_deudores_curso' || $user_data['eventox'] == 'print_deudores_mensual_detalle' )
						{	if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
							else
								$detalle_subtotal="Subtotal (1 alumnos):";
						}
						else
						{   if ($k>1)
								$detalle_subtotal="Subtotal (de entre ".$k." cursos):";
							else
								$detalle_subtotal="Subtotal (1 curso):";
						}
						$html .="
						<tr >
							<td><font size=\"5\" ><strong>".$detalle_subtotal."</strong></font> </td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
						</tr>
						<tr><td colspan=\"9\"><hr/></td></tr>";
					}
					else
					{   if ( ( $user_data['eventox'] == 'print_deudores_mensual_detalle' ) && ( $curso!=$tranx[$i+1][9] ) )
						{	$total				= $total			+ $sumatotal;
							$totaldescuentos	= $totaldescuentos	+ $sumatotaldescuentos;
							$totaliva			= $totaliva			+ $sumatotaliva;
							$totalneto			= $totalneto		+ $sumatotalneto;
							$totalrecaudado		= $totalrecaudado	+ $sumatotalrecaudado;
							$totalnc			= $totalnc			+ $sumatotalnc;
							$totalporrecaudar	= $totalporrecaudar	+ $sumatotalporrecaudar;
							
							if ($k>1)
									$detalle_subtotal="Subtotal (de entre ".$k." alumnos):";
								else
									$detalle_subtotal="Subtotal (1 alumnos):";
								
							$html .="
							<tr >
								<td><font size=\"8\" ><strong>".$detalle_subtotal."</strong></font> </td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotal,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaldescuentos,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotaliva,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalneto,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalrecaudado,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalnc,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>$".number_format($sumatotalporrecaudar,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\"  ><font size=\"5\"><strong>".number_format(($sumatotalporrecaudar*100)/$sumatotalneto,2,'.',',')."%</strong></font></td>
							</tr>
							<tr><td colspan=\"9\"><hr/></td></tr>";
						}
					}
					if($curso!=$tranx[$i+1][9])
					{   $finaltotal				= $finaltotal			+ $total;
						$finaltotaldescuentos	= $finaltotaldescuentos	+ $totaldescuentos;
						$finaltotaliva			= $finaltotaliva		+ $totaliva;
						$finaltotalneto			= $finaltotalneto		+ $totalneto;
						$finaltotalrecaudado	= $finaltotalrecaudado	+ $totalrecaudado;
						$finaltotalnc			= $finaltotalnc			+ $totalnc;
						$finaltotalporrecaudar	= $finaltotalporrecaudar+ $totalporrecaudar;
						/*if ( $grupo!=$curso )
						{*/   $html .="
							<tr >
								<td ><font size=\"5\" ><strong>Total (".$curso."):</strong></font> </td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($total,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaldescuentos,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totaliva,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalneto,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalrecaudado,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalnc,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>$".number_format($totalporrecaudar,2,'.',',')."</strong></font></td>
								<td align=\"right\" height=\"30\" ><font size=\"5\"><strong>".number_format(($totalporrecaudar*100)/$totalneto,2,'.',',')."%</strong></font></td>
							</tr>";
						/*}*/
					}
				}
				if ( $user_data['eventox'] == 'print_deudores_curso')
				{	if ($i>1)
						$detalle_total="Total (de entre ".$i." alumnos):";
					else
						$detalle_total="Total (1 alumnos):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual_detalle' )
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." deudas):";
					else
						$detalle_total="Total (1 deuda):";
				}
				else if ( $user_data['eventox'] == 'print_deudores_mensual' )
				{   if ($l>1)
						$detalle_total="Total (de entre ".$l." curso):";
					else
						$detalle_total="Total (1 curso):";
				}
				else
				{   if ($i>1)
						$detalle_total="Total (de entre ".$i." cursos):";
					else
						$detalle_total="Total (1 curso):";
				}
				$html .="
						<tr >
							<td ><font size=\"5\" ><strong>".$detalle_total."</strong></font> </td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotal,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotaldescuentos,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotaliva,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalneto,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalrecaudado,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalnc,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td align=\"right\" ><font size=\"5\"><strong>".number_format(($finaltotalporrecaudar*100)/$finaltotalneto ,2,'.',',')."%</strong></font></td>
						</tr>";
				$html .= "
						<tr >
							<td colspan=\"2\"><font size=\"5\" ><strong>Total por Cobrar:</strong></font></td>
							<td colspan=\"6\" align=\"right\" ><font size=\"5\"><strong>$".number_format($finaltotalporrecaudar,2,'.',',')."</strong></font></td>
							<td></td>
						</tr>";
				$html .= "</table>";
			}
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportedeudoresresumen_curso_detalle.pdf', 'I');
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
			$_SESSION['ui_skin'] = $user_data['cls'];
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
		case CHANGE_STATUS_BAR:
			if ( $user_data['bar'] == 'true')
				$_SESSION['sidebar_status'] ='sidebar-collapse';
			else
				$_SESSION['sidebar_status'] ='';
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