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
$_SESSION['modulo']='alumnos';
require_once('../../../core/controllerBase.php');
require_once('../../common/periodo/model.php');
require_once('../../common/catalogo/model.php');
require_once('../../finan/clientes/model.php');
require_once('../../finan/pagos/model.php');
//require_once('../../finan/general/model.php');

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
    $peticiones = array(MAIN, VIEW_MAIN,PASS_CHANGED, 	PRINTREP_DEUDORES, PRINTREPVISOR, 
						VIEW_CONFIG_SIS,GET_DEBT, VIEW_HOME, VIEW_DEBT, VIEW_DEBT_ANS);
	
    foreach ($peticiones as $peticion)
	{	$uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true )
		{	$event = $peticion;
        }
    }
    //$gene_data 		= helper_data();	//variables que llegan por post desde el javascript
	$user_data 		= get_frontData(); //variables que llegan por post desde el javascript
    $general 		= set_obj();
	$gene			= set_obj();
	$cursos 		= set_obj();
	$periodos 		= set_obj();
	$periodo 		= get_mainObject('Periodo');
	$pensiones 		= set_obj();
    $apikey 		= set_obj();
	$deuda 			= set_obj();
	$permiso 		= get_mainObject('General');
	$tablacliente 	= get_mainObject('General');
	$pago 			= get_mainObject('Pagos');
	//echo "no locoxs asdadas";
    switch ($event) 
	{	case MAIN:
			global $diccionario;
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			
			$cmb_sidebar_periodo = '<select name="alum_sel" id="alum_sel" required="required" class="form-control">';	
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
				
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white'];
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
			
			$_SESSION['sgn_vps_pub'] = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
			"TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
			"Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
			"DRr1jPeilfsiFwiO8wIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
			$_SESSION['sgn_com_priv'] = '-----BEGIN RSA PRIVATE KEY-----\n'.
				'MIICXAIBAAKBgQDRcvWTo1vb3B1qimCJIU7E6TYe+TYdT/beT6L2XhK4CFw0srcT\n'.
				'8AnznPHEDF2NdjkgmIeemkNfZq16wPxuttAOM1RlzoS6lZ/pvzbWNj9squkppklE\n'.
				'OSc21IWo7qMYSXqJI0rym+TNt1BOsKXl6/YSxHXwrjUFaVugfzbnr4wk5wIDAQAB\n'.
				'AoGAN+85gioYOAj6mh9GVJjejluxpmfrebyHMyuVW7IX0an55eDsX5i1L6f0MOUU\n'.
				'ftjZvMi/Py33XBzxq1yqjW6o9QXFGNOw8KT+dVl1Usf1QdvcGQ7CIZ0CssRAzdij\n'.
				'GiBmQUG5B9ZNGCi5ptwrK89v6M2FcTvSxx4l29T91NU4ApECQQD7/RdFxdXNMhE0\n'.
				'Hrn/VNg6O8km9Hs5pXAWQlVsDf/0L1lOuv3jNabyGFT5svJs8bVEUWDDrgKdItO2\n'.
				'hxd3Q6P9AkEA1MiCn6ehyu3EiPLlWEtapcYGRCIkMdkhpm1rxQh9eIn4dAVFJl9P\n'.
				'o/016+1dLmXOXrs8yZ3fpn/bkuxXj9PXswJAYqx9s32/tgVYBT/O97QCo/MLVqy/\n'.
				'oBgvZxf8mT52LulnoFPK3XEB+aUbiVfQZGbV43W2XYnDTkL4Am6t+q7LBQJANytF\n'.
				'st9js5myO0++5wWimxicx02S1NnXP69fIdbxsS8UnABBzZEotPwR3vnMDxuWRjmF\n'.
				'qUClnCXKaG2exkvGwQJBANWIbuIYhC3s+3f119bDLsJDsE4t4B+MyU20ZYPohli2\n'.
				'EWQBSsVWyKSMULk3ICvAGYUK0LQ4A1NPE5ixkbEyTTI=\n'.
				'-----END RSA PRIVATE KEY-----';
				
			$_SESSION['domain'] = $domain;
			
			switch($domain){
				case  "ecobab.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobab.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobab;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_ecobab_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobab;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobab_bg;
					$_SESSION['id_commerce_pagos_web'] = '6924';
					break;
				case  "desarrollo.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedesarrollo;
					$_SESSION['passllaveactiva']=$clavellavedesarrollo;
					$_SESSION['rutallave']=$rutallavedesarrollo;
					$_SESSION['ambiente']=1;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='desarrollo.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_desarrollo;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_desarrollo_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '7822';
					break;
				case  "ecobabvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavebabahoyo;
					$_SESSION['passllaveactiva']=$clavellavebabahoyo;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='factura@ecomundobabahoyo.com.ec';
					$_SESSION['visor']='ecobabvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_ecobabvesp;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_ecobabvesp_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_ecobabvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_ecobabvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7058';
					break;
				case  "liceopanamericano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericano;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_liceopanamericano_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericano;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericano_bg;
					$_SESSION['id_commerce_pagos_web'] = '6921';
					break;
				case  "liceopanamericanosur.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llaveliceopanamericano;
					$_SESSION['passllaveactiva']=$clavellaveliceopanamericano;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='e-electronica@liceopanamericano.edu.ec';
					$_SESSION['visor']='liceopanamericanosur.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_liceopanamericanosur;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_liceopanamericanosur_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_liceopanamericanosur;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_liceopanamericanosur_bg;
					$_SESSION['id_commerce_pagos_web'] = '7056';
					break;
				case  "delfos.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfos.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfos;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_delfos_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfos;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfos_bg;
					$_SESSION['id_commerce_pagos_web'] = '6923';
					break;
				case  "delfosvesp.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavedelfos;
					$_SESSION['passllaveactiva']=$clavellavedelfos;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='delfosvesp.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_delfosvesp;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_delfosvesp_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_delfosvesp;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_delfosvesp_bg;
					$_SESSION['id_commerce_pagos_web'] = '7057';
					break;
				case  "moderna.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavemoderna;
					$_SESSION['passllaveactiva']=$clavellavemoderna;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='malvear@redlinks.com.ec';
					$_SESSION['visor']='moderna.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_moderna;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_moderna_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_moderna;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_moderna_bg;
					$_SESSION['id_commerce_pagos_web'] = '6922';
					break;
				case  "americano.educalinks.com.ec":
					$_SESSION['llaveactiva']=$llavecolegioamericanoguayaquil;
					$_SESSION['passllaveactiva']=$clavecolegioamericanoguayaquil;
					$_SESSION['rutallave']=$rutallave;
					$_SESSION['ambiente']=2;
					$_SESSION['correofacturas']='pablo.villao@colegioamericano.edu.ec';
					$_SESSION['visor']='americano.educalinks.com.ec/finan/visor';
					$_SESSION['dir_logo_cliente']=$ruta_logo_cag;
					$_SESSION['dir_logo_cliente_bg']=$ruta_logo_americano_bg;
					$_SESSION['print_dir_logo_cliente']=$print_ruta_logo_cag;
					$_SESSION['print_dir_logo_cliente_bg']=$print_ruta_logo_cag_bg;
					break;
				default:
					$_SESSION['llaveactiva']='default';
				break;
			}
			$tablaclientePaid = new General();
			$tablacliente->get_botonpago_deudas_listas( $_SESSION['alum_codi'], 'PC' );
			$tablaclientePaid->get_botonpago_deudas_listas( $_SESSION['alum_codi'], 'P' );
			$tabla_deudas_pdtes = tabla_deudas( $tablacliente, 'PC');
			$tabla_deudas_pasadas = tabla_deudas( $tablaclientePaid, 'P' );
			
			if ( $tabla_deudas_pdtes == '0' )
				$data['deudas_pdtes'] =  "No hay deudas pendientes de cobro.";
			else
				$data['deudas_pdtes'] =  $tabla_deudas_pdtes;
			
			if ( $tabla_deudas_pasadas == '0' )
				$data['deudas_pasadas'] = "No hay registro de deudas pagadas.";
			else
				$data['deudas_pasadas'] = $tabla_deudas_pasadas;
			retornar_vista_general(VIEW_HOME, $data);
        break;
		case GET_DEBT:
			global $diccionario;
			include("../../../includes/common/vpos_plugin.php");
			
			if( !isset( $_POST['ckb_deud_codigo'] ) )
				$deud_codigo = '';
			else 
			{   $true=0;
				$deud_codigo='<?xml version="1.0" encoding="iso-8859-1"?><deudas>';
				foreach ( $_POST['ckb_deud_codigo']  as $deuda )
				{   if( $deuda!= '' )
					{   $deud_codigo.='<deuda id="'.$deuda.'" />';
						$true=1;
					}
				}
				$deud_codigo.="</deudas>";
				if ( $true == 0 )
					$deud_codigo = "";
			}
			
			$general->get_deuda_informacion( $_SESSION['alum_codi'], $_SESSION['repr_codi'], $deud_codigo );
			$deuda = $general->rows;
			$vector = "F1A06EE948DC5B1A";
			
            //Llave Publica Crypto de Alignet. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Publica de ellos
			//Privada de ellos nunca usamos
			
            $llaveVPOSCryptoPub = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC0t0Cnbne8gQoeGK4nG6O3zfwh\n".
			"q8u9Wp5zHjyVYbvx2zudSOlBnJ5qU74BcTGypbn6W7jjvSNE7AmncOAVh4RxuRXO\n".
			"+bINFIyQ7/ErH/v1YpDFk8knC/NuvFpfHqhJ/5j2I8y+WmyF0MZmGtm074nUGv4d\n".
			"qlbUMT9aYUQ+RzMO7QIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
            //Llave Firma Privada del Comercio. Nota olvidar ingresar los saltos de linea detallados con el valor \n
			//Privada nuestra
            $llaveComercioFirmaPriv = "-----BEGIN RSA PRIVATE KEY-----\n".
			"MIICXQIBAAKBgQC6otIGv2UaX6HSxS6OX/c8iMtsKKC4YSn9oLgk8/yNgrlqbDGV\n".
			"Fq16EXmcpWXQL91pCz57Gtkf/ATL2QIpG1t7KXPr8PuCur3j6AtExNHq88m2DLJ6\n".
			"1fbaj3+iEKpCrfx+c3e9/ZHejvM3wWLZZP7BRKSlt6PNLGn1j5iXNVDvVwIDAQAB\n".
			"AoGBAKINDd/d/6NOteuUWkA1Ay8Ed9yJykNN2m/mRP2Q/BDDGMtW9hZFgosi8T0a\n".
			"P7TsWosCwFWTkkM7R87XthCLOHnUgTxLduoLzs+U30dT8OCuCIxc6+0sW4U1c7Ik\n".
			"fSee3aDm0gXI2IeEZEr3pf4uKuJ+gWreIm8w5bev6FA8yWoBAkEA3NDla14L03zE\n".
			"ZNSbuikKk2KxcukwebYkyyYUL2yPYkpXpVM33MM94/nL8nCtP2vXosprUdoqPIwt\n".
			"CLgUX9LO4QJBANhfuEHwSiesZTWfjbXdgnt/aKEpvETR4286ddZgBErFxHWX0Qwe\n".
			"xtTi0m91guaoZVxx/l4ZCx1DojUtvvN3HTcCQHCd2WO4wy9JIqCKDiITbGFepEGG\n".
			"zEJGst0ovoKxSy9F2w1mM8dTi+0JKQqsjK8bwQ41TiagrYnTs+QOfdWhHgECQBOE\n".
			"zwJjwszBaH/l3MrDKLorTCz9rtYmePXXuDmWf8ye+pIBGAKX5CfgLkuPtjdIiZxF\n".
			"TEUAzVfeeguCDO+5lxECQQCCKyKRGRS+oKPDkEs2u4lTLeljXL5mNeuGNZ5ZQ6He\n".
			"DSDSeovwi9WQKg1fvqbpbb3ycY8f12EZWu4gug8m8vI2\n".
			"-----END RSA PRIVATE KEY-----";
			$deud_totalPendiente = 0; $deud_aux = 0;
			foreach ( $deuda as $row)
			{   $deud_totalPendiente = $deud_totalPendiente + $row['deud_totalPendiente'];
				$deud_aux++;
			}
            //Envío de Parametros a V-POS
            $array_send['acquirerId'] = '17'; //no cambia
            $array_send['commerceId'] = $_SESSION['id_commerce_pagos_web'];
            $array_send['purchaseOperationNumber'] = $row['pon_code'];
            //Monto incluido con impuestos
            $array_send['purchaseAmount'] = $deud_totalPendiente*100;
            $array_send['purchaseCurrencyCode'] = '840';
            $array_send['commerceMallId'] = '0';
            $array_send['language'] = 'SP';
            $array_send['billingFirstName'] = $row['repr_nomb'];
            $array_send['billingLastName'] = $row['repr_apel'];
            $array_send['billingEMail'] = $row['repr_email'];
            $array_send['billingAddress'] = $row['repr_domi'];
            $array_send['billingZIP'] = '090150';
            $array_send['billingCity'] = 'Guayaquil';
            $array_send['billingState'] = 'Guayaquil';
            $array_send['billingCountry'] = 'EC';
            $array_send['billingPhone'] = $row['repr_telf'];
            $array_send['shippingAddress'] = $row['repr_domi'];
            $array_send['terminalCode'] = '00000000';
            $array_send['reserved11'] = 'liceopanamericano';
			
			//Monto Grava VIA
            
            //Parametros Taxes Sobre Inclusión de Impuestos IVA
            $array_send['tax_1_name'] = 'Adicional';
            $array_send['tax_1_amount'] = '000';
            $array_send['tax_2_name'] = 'Monto Fijo';
            $array_send['tax_2_amount'] = '000';
            $array_send['tax_3_name'] = 'Monto IVA';
            $array_send['tax_3_amount'] = '000';
            $array_send['tax_4_name'] = 'Adicional';
            $array_send['tax_4_amount'] = '000';
            $array_send['tax_5_name'] = 'Adicional';
            $array_send['tax_5_amount'] = '000';
            $array_send['tax_6_name'] = 'Adicional';
            $array_send['tax_6_amount'] = '000';
            $array_send['tax_7_name'] = 'Adicional';
            $array_send['tax_7_amount'] = '000';
            $array_send['tax_8_name'] = 'Adicional';
            $array_send['tax_8_amount'] = '000';
            $array_send['tax_9_name'] = 'Monto No Grava IVA';
            $array_send['tax_9_amount'] = $deud_totalPendiente*100; //6000
            $array_send['tax_10_name'] = 'Monto Grava IVA';
            $array_send['tax_10_amount'] = '000';
            
            //Ejemplo envío campos reservados en parametro reserved1.
            $array_send['reserved1'] = 'SP';
            $array_send['reserved2'] = '000'; //Monto Grava IVA
            $array_send['reserved3'] = '000'; //Monto IVA
            $array_send['reserved4'] = '000';
            $array_send['reserved5'] = '000';
            $array_send['reserved9'] = '000';
            $array_send['reserved10']= '000'; //Monto Grava VIA
			
            /*
			
			//Envío de Parametros a V-POS
            $array_send['acquirerId'] = '17';//no cambia
            $array_send['commerceId'] = $_SESSION['id_commerce_pagos_web'];
            $array_send['purchaseOperationNumber'] = $row['pon_code'];
            //Monto incluido con impuestos
            $array_send['purchaseAmount']='10000';
            $array_send['purchaseCurrencyCode']='840';
            $array_send['commerceMallId']='0';
            $array_send['language']='SP';
            $array_send['billingFirstName']='Juan';
            $array_send['billingLastName']='Perez';
            $array_send['billingEMail']='test@test.com';
            $array_send['billingAddress']='Direccion ABC';
            $array_send['billingZIP']='1234567890';
            $array_send['billingCity']='Quito';
            $array_send['billingState']='Quito';
            $array_send['billingCountry']='EC';
            $array_send['billingPhone']='123456789';
            $array_send['shippingAddress']='Direccion ABC';
            $array_send['terminalCode']='00000000';
            $array_send['reserved11']='Valor Reservado ABC'; //Monto Grava VIA
			
			//Parametros Taxes Sobre Inclusión de Impuestos IVA
            $array_send['tax_1_name']='Adicional';
            $array_send['tax_1_amount']='000';
            $array_send['tax_2_name']='Monto Fijo';
            $array_send['tax_2_amount']='000';
            $array_send['tax_3_name']='Monto IVA';
            $array_send['tax_3_amount']='1400';
            $array_send['tax_4_name']='Adicional';
            $array_send['tax_4_amount']='000';
            $array_send['tax_5_name']='Adicional';
            $array_send['tax_5_amount']='000';
            $array_send['tax_6_name']='Adicional';
            $array_send['tax_6_amount']='000';
            $array_send['tax_7_name']='Adicional';
            $array_send['tax_7_amount']='000';
            $array_send['tax_8_name']='Adicional';
            $array_send['tax_8_amount']='000';
            $array_send['tax_9_name']='Monto No Grava IVA';
            $array_send['tax_9_amount']='000';
            $array_send['tax_10_name']='Monto Grava IVA';
            $array_send['tax_10_amount']='8600';
			
			$array_send['reserved2']='8600'; //Monto Grava IVA
            $array_send['reserved3']='1400'; //Monto IVA
            $array_send['reserved4']='000';
            $array_send['reserved5']='000';
            $array_send['reserved9']='000';
            $array_send['reserved10']='8600'; //Monto Grava VIA*/
            
            //Parametros de Solicitud de Autorización a Enviar
            $array_get['XMLREQ']="";
            $array_get['DIGITALSIGN']="";
            $array_get['SESSIONKEY']="";

            //Ejecución de Creación de Valores para la Solicitud de Autorización
			
			$data['datos_deuda'] = 
			'<div class="panel panel-info">
				<div class="panel-heading">Datos personales</div>
				<div class="panel-body" style="text-align:left;background-color:#f4f4f4;">'.
					'<br> <b>Nombre de venta:</b> ' . $row['repr_nomb'] . ' ' . $row['repr_apel'] .
					'<br> <b>E-mail:</b> ' . $row['repr_email'] .
					'<br> <b>Domicilio:</b> ' . $row['repr_domi'] .
					'<br> <b>Ciudad:</b> Guayaquil' .
					'<br> <b>Estado:</b> Guayaquil' .
					'<br> <b>País:</b> Ecuador' .
					'<br> <b>Teléfono:</b> ' . $row['repr_telf'] .
				'</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10">
					<div style="color:red">
						<b>Por favor, revisar que los datos del representante estén correctos para la impresión de factura.
						En caso de encontrar una novedad, comuníquese con la unidad educativa.</b>
					</div>
				</div>
			</div>';
				
			foreach ( $deuda as $row )
			{   $data['frm_pago_details'].= 
				'<br><b><span style="font-size:16px;color:#0066c0;">'.$row['prod_nombre'].'</span></b>'.
				' <span style="font-size:small">(código deuda: '.$row['deud_codigo'].')</span>'.
				'<br> Valor: ' . $row['deud_totalPendiente'] ;
			}
			
			if ( $deud_aux == '1' ) 
				$data['cantidad_total'] = '1 pensión';
			else
				$data['cantidad_total'].= $deud_aux . ' pensiones';
			
			$data['valor_total'] = " $".$deud_totalPendiente;
			
			VPOSSend($array_send,$array_get,$llaveVPOSCryptoPub,$llaveComercioFirmaPriv,$vector);
			//$privres = openssl_pkey_get_private(array($privatekey,null));
			
			$data['frm_pago_sbmt'] = '
				<!--<form name="frmVPOS" method="POST" action="https://integracion.alignetsac.com/VPOS/MM/transactionStart20.do">-->
				<form name="frmVPOS" method="POST" action="https://vpayment.verifika.com/VPOS/MM/transactionStart20.do">
				<!--<form name="frmVPOS" method="POST" action="../pagos_respuesta/">-->
					<input TYPE="hidden" NAME="IDACQUIRER" 	ID="IDACQUIRER" 	value="'.$array_send['acquirerId'].'">
					<input TYPE="hidden" NAME="IDCOMMERCE" 	ID="IDCOMMERCE"		value="'.$array_send['commerceId'].'">
					<input TYPE="hidden" NAME="XMLREQ" 	 	ID="XMLREQ"			value="'.$array_get['XMLREQ'].'">
					<input TYPE="hidden" NAME="DIGITALSIGN" 	ID="DIGITALSIGN" 	value="'.$array_get['DIGITALSIGN'].'">
					<input TYPE="hidden" NAME="SESSIONKEY" 	ID="SESSIONKEY"		value="'.$array_get['SESSIONKEY'].'">
					<input TYPE="hidden" NAME="url" 			ID="url"			value="'.$_SESSION['id_commerce_pagos_web'].'">
					<input TYPE="hidden" NAME="name" 			ID="name"			value="'.$row['pon_code'].'">
					<input TYPE="hidden" NAME="ape" 			ID="ape"			value="'.$row['repr_nomb'].$row['repr_apel'].'">
					<input TYPE="hidden" NAME="email" 		ID="email"			value="'.$row['repr_email'].'">
					<input TYPE="hidden" NAME="valordeuda" 	ID="valordeuda"		value="'.($deud_totalPendiente*100).'">
					
					<button class="btn btn-warning" type="submit" NAME="btn_pagar" ID="btn_pagar">Pagar pensión</button>
					<br>
					<img width="25%" src="../../imagenes/mcvisa.png">
				</form>';
            
			retornar_vista_general(VIEW_DEBT, $data);
			break;
		case GET_DEBT_ANS:
			global $diccionario;
			$_SESSION['IN']="OK";
			if( empty( $_SESSION['sidebar_status'] ) )
				$_SESSION['sidebar_status']='';
			
			$cmb_sidebar_periodo = '<select name="alum_sel" id="alum_sel" required="required" class="form-control">';	
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
				
			$_SESSION['ui_skin']='skin-blue';
			$_SESSION['toggle_fullscreen']='false';
			$_SESSION['usua_codigo']=$data['usua_codigo'];
			$_SESSION['usua_nombres']=$data['usua_nombres'];
			$_SESSION['usua_apellidos']=$data['usua_apellidos'];
			$_SESSION['cmb_sidebar_periodo']=$data['cmb_sidebar_periodo'];
			$_SESSION['usua_correoElectronico']=$data['usua_correoElectronico'];
			$_SESSION['usua_codigoRol']=$data['usua_codigoRol'];
			$_SESSION['puntVent_codigo']=$data['puntVent_codigo'];		
			
			$_SESSION['dir_logo_educalinks']=$ruta_logo_educalinks;
			
			$_SESSION['dir_logo_educalinks_long_red']=$ruta_logo_educalinks_long_red;
			$_SESSION['dir_logo_educalinks_long_red_small']=$ruta_logo_educalinks_long_red_sm;
			$_SESSION['dir_logo_educalinks_long_white']=$ruta_logo_educalinks_long_white;
			$_SESSION['dir_logo_educalinks_long_white_small']=$ruta_logo_educalinks_long_white_sm;
			$_SESSION['dir_logo_educalinks_long_white_red']=$ruta_logo_educalinks_long_white_red;
			
			$_SESSION['dir_logo_educalinks_long'] = $_SESSION['dir_logo_educalinks_long_white'];
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
			
			$_SESSION['sgn_vps_pub'] = "-----BEGIN PUBLIC KEY-----\n".
			"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDTJt+hUZiShEKFfs7DShsXCkoq\n".
			"TEjv0SFkTM04qHyHFU90Da8Ep1F0gI2SFpCkLmQtsXKOrLrQTF0100dL/gDQlLt0\n".
			"Ut8kM/PRLEM5thMPqtPq6G1GTjqmcsPzUUL18+tYwN3xFi4XBog4Hdv0ml1SRkVO\n".
			"DRr1jPeilfsiFwiO8wIDAQAB\n".
			"-----END PUBLIC KEY-----";
			
			$_SESSION['sgn_com_priv'] = '-----BEGIN RSA PRIVATE KEY-----\n'.
				'MIICXAIBAAKBgQDRcvWTo1vb3B1qimCJIU7E6TYe+TYdT/beT6L2XhK4CFw0srcT\n'.
				'8AnznPHEDF2NdjkgmIeemkNfZq16wPxuttAOM1RlzoS6lZ/pvzbWNj9squkppklE\n'.
				'OSc21IWo7qMYSXqJI0rym+TNt1BOsKXl6/YSxHXwrjUFaVugfzbnr4wk5wIDAQAB\n'.
				'AoGAN+85gioYOAj6mh9GVJjejluxpmfrebyHMyuVW7IX0an55eDsX5i1L6f0MOUU\n'.
				'ftjZvMi/Py33XBzxq1yqjW6o9QXFGNOw8KT+dVl1Usf1QdvcGQ7CIZ0CssRAzdij\n'.
				'GiBmQUG5B9ZNGCi5ptwrK89v6M2FcTvSxx4l29T91NU4ApECQQD7/RdFxdXNMhE0\n'.
				'Hrn/VNg6O8km9Hs5pXAWQlVsDf/0L1lOuv3jNabyGFT5svJs8bVEUWDDrgKdItO2\n'.
				'hxd3Q6P9AkEA1MiCn6ehyu3EiPLlWEtapcYGRCIkMdkhpm1rxQh9eIn4dAVFJl9P\n'.
				'o/016+1dLmXOXrs8yZ3fpn/bkuxXj9PXswJAYqx9s32/tgVYBT/O97QCo/MLVqy/\n'.
				'oBgvZxf8mT52LulnoFPK3XEB+aUbiVfQZGbV43W2XYnDTkL4Am6t+q7LBQJANytF\n'.
				'st9js5myO0++5wWimxicx02S1NnXP69fIdbxsS8UnABBzZEotPwR3vnMDxuWRjmF\n'.
				'qUClnCXKaG2exkvGwQJBANWIbuIYhC3s+3f119bDLsJDsE4t4B+MyU20ZYPohli2\n'.
				'EWQBSsVWyKSMULk3ICvAGYUK0LQ4A1NPE5ixkbEyTTI=\n'.
				'-----END RSA PRIVATE KEY-----';
				
			$_SESSION['domain'] = $domain;
			
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
					$_SESSION['id_commerce_pagos_web'] = '6924';
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
					$_SESSION['id_commerce_pagos_web'] = '7822';
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
					$_SESSION['id_commerce_pagos_web'] = '7058';
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
					$_SESSION['id_commerce_pagos_web'] = '6921';
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
					$_SESSION['id_commerce_pagos_web'] = '7056';
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
					$_SESSION['id_commerce_pagos_web'] = '6923';
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
					$_SESSION['id_commerce_pagos_web'] = '7057';
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
					$_SESSION['id_commerce_pagos_web'] = '6922';
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
			include("../../../includes/common/vpos_plugin.php");
			
			$vector = "F1A06EE948DC5B1A";
			
			//Llave Firma Publica de Alignet
            $llaveVPOSFirmaPub = "-----BEGIN PUBLIC KEY-----\n".
            "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCtvXnikeSS+H/Qs/51iL3ZYPfz\n".
            "KW94WUAz7IdZIOIcuG1zLIR3kUNUc/vdSmW120dwkIleB6pl4cVT5nDewBFJCzTS\n".
            "W6jGaWaryzl7xS3ZToKTHpVeQr3avN7H+Om9TfsccY7gBV3IOIauTg9xIpDjIg52\n".
            "fUcfyPq+Bhw0cWkDUQIDAQAB\n".
            "-----END PUBLIC KEY-----";

            //Llave Crypto Privada del Comercio
            $llaveComercioCryptoPriv = "-----BEGIN RSA PRIVATE KEY-----\n". 
            "MIICXQIBAAKBgQDBq61NkU64CLzfDg1yVY18lcy3WHtiA1JqR0AqMYdjN8VFNUhr\n".
            "cZ5E+RtP32jNVjK55eVwd6zwoOPqfghgp2wIhuRPBGgbhUNcG7ariYKewEYxvAAx\n".
            "foSnb/CVknOYTnb8N2tdZ/E7w+S+AvuEFHIKdKsf5EJYX5ayyCNfet6N5QIDAQAB\n".
            "AoGBALH8GV/Q65w8A3+mhXsO3uGhNatF+NZBoUskwfZE4Fyxk20gI7cCiuZuXMhR\n".
            "1BnpXuLzQaHTii72XZ9SRla1ZpTxE6iIbtAKrpV19oFMgNy4mm24vJpbGc/SMENi\n".
            "JBhb9+dKp4dBVcxg49pSRE/EtVvxMPe9Z1fZzPLoIL5/gyNBAkEA8F52yjeOis9c\n".
            "6+ZZHDICPzJhDRNKpNow4vpJmm1Ev3trvDKk2tXJ6KRzynHba7rY/hnOfCfe5MG2\n".
            "gWOUNugbVQJBAM5DzYqSlLdetKt/YTFpplZ3T/vANCVV+AX+Ph6CrN5bzUTRD7uO\n".
            "SwAOA8gv8uSZfQRHIHT7XmMJ8WdFVPDGSFECQEiPu7x/2P/+aUatWukwD42UX8fa\n".
            "swXg+DEM7Xs40TAcygEeKLYHI9SfEHVkuaBj322VzMeeIaNc9wNIVE3e86ECQCe+\n".
            "gNh2rhk3MnDpNn0i8l4u10aXHnUjP4tIFggi/dRKtB7SecmV/XWhPbFRK+hIewJc\n".
            "AjEIToOe4tkXTuqmCkECQQDmx8WgK2lG9+O9JuBPbt+6cnG6f0Uir63A2mGCtJ92\n".
            "vKsmAbNFCWzRu4udgfyBLB6c+wTEM8YKkpGpadrn9pl4\n".
            "-----END RSA PRIVATE KEY-----";
			
			//Parametros de Recepción de Autorización
            $arrayIn['IDACQUIRER'] = $_POST['IDACQUIRER'];
            $arrayIn['IDCOMMERCE'] = $_POST['IDCOMMERCE'];
            $arrayIn['XMLRES'] 	   = $_POST['XMLRES'];
            $arrayIn['DIGITALSIGN']= $_POST['DIGITALSIGN'];
            $arrayIn['SESSIONKEY'] = $_POST['SESSIONKEY'];
            $arrayOut = '';
                
            //Ejecución de Creación de Valores para la Solicitud de Interpretación de la Respuesta
            if(VPOSResponse($arrayIn,$arrayOut,$llaveVPOSFirmaPub,$llaveComercioCryptoPriv,$vector))
			{   $general->set_operacion_auditoria(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] );
				$general->set_operacion_respuesta(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] ); //reserved11 es el URL de procedencia de la solicitud.
				
				//$arrayOut['authorizationCode']
				if( $arrayOut['authorizationResult'] == '00') //AUTORIZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-success'>
							<h4>Exito</h4>
							Operación Autorizada.
						</div>";
				if( $arrayOut['authorizationResult'] == '01') //DENEGADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				if( $arrayOut['authorizationResult'] == '05') //RECHAZADA
					$data['frm_pago_sbmt'] = "
						<div class='bs-callout bs-callout-danger'>
							<h4>Error</h4>
							Operación Denegada.
						</div>";
				
				$data['datos_deuda'] = "
					<table>
						<tr><td>Resultado de la Transacción</td><td>".$arrayOut['authorizationResult']."</td></tr>
						<tr><td>Detalle del Resultado</td><td>". $arrayOut['errorCode'] . " - " . $arrayOut['errorMessage']."</td></tr>
						<tr><td>Número de la Tarjeta</td><td>". $arrayOut['cardNumber']."</td></tr>
						<tr><td>Marca de la Tarjeta</td><td>" . $arrayOut['cardType']."</td></tr>
						<tr><td>Número de Operacion</td><td>" . $arrayOut['purchaseOperationNumber']."</td></tr>
						<tr><td>Monto</td><td>S/. " . $arrayOut['purchaseAmount']/100 ."</td></tr>
					</table>
					<br/>
					<br/>";
				if( $arrayOut['authorizationResult'] == '00')
				{   $pagos = explode(";", $general->rows[0]['pagos']);
					$aux = 0; $html  = "";
					for ($aux = 0; $aux < count($pagos) ; $aux++ )
					{	$spanHTML="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n grande.' data-placement='left'></span>";
						$spanPDF="<span class='glyphicon glyphicon-print cursorlink' id='".$pagos[$aux]."_ver_pago_PDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Formato impresi&oacute;n punto de venta.' data-placement='left'></span>";
						$html .="Recibo de pago no " . $pagos[$aux] . ": <a href='".$diccionario['ruta_html_finan']."/finan/PDF/imprimir/pago/".$pagos[$aux]."' target='_blank'>PDF</a> | ";
						$html .="<a href='".$diccionario['ruta_html_finan']."/finan/documento/imprimir/pago/".$pagos[$aux]."' target='_blank'>HTML</a><br>";
					}
					$data['datos_deuda'] .=  $html;
				}
            }
			else
			{   $general->set_operacion_auditoria(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100,
												$arrayOut['reserved11'] );
				$general->set_operacion_respuesta(
												$arrayOut['authorizationCode'], $arrayOut['authorizationResult'],
												$arrayOut['errorCode'], $arrayOut['errorMessage'],
												$arrayOut['cardNumber'], $arrayOut['cardType'],
												$arrayOut['purchaseOperationNumber'], $arrayOut['purchaseAmount']/100 .".00",
												$arrayOut['reserved11'] );
				$data['datos_deuda'] = "Error durante el proceso de interpretación de la respuesta. "
					."Verificar los componentes de seguridad: Vector Hexadecimal y Llaves.";
				
				$data['frm_pago_sbmt'] = "
				<div class='bs-callout bs-callout-danger'>
					<h4>Error</h4>
					Verificar los componentes de seguridad.
				</div>";
            }
			$_SESSION['dominio_debt_ans'] = $arrayOut['reserved11'];
			retornar_vista_general(VIEW_DEBT_ANS, $data);
			break;
		case GET_OVERDUE_DEBT:
			global $diccionario;
			$general->get_deudasAnterioresVencidas($user_data['cabFact_codigo']);
			$json_deudas_vencidas=array();
			
			foreach($general->rows as $campo=>$valor)
			{   $json_deudas_vencidas[$campo]=$valor;
			}
			echo json_encode ($json_deudas_vencidas);
			break;
        default:
			$_SESSION['IN']="KO";
			$_SESSION['ERROR_MSG']="Por favor inicie sesión";
			echo "Resultado desconocido";
		break;
    }
}

function set_obj() {
    $obj = new General();
    return $obj;
}
handler();
function tabla_deudas( $tablacliente, $tabla_estado )
{   global $diccionario;

	$name = "";
	if ( $tabla_estado =='PC' )
	{   $name = 'tabla_estadoCuenta';
		$data = "
		<!--<form name='frmPagos' method='POST' action='".$diccionario['rutas_head']['ruta_main_ssl']."alumnos/pagos/'>-->
		<form name='frmPagos' method='POST' action='../../alumnos/pagos/'>
			<input TYPE='hidden' NAME='event' ID='evento' value='get_debt'>
			<table class='table table-bordered' id='".$name."' name='".$name."'>
				<thead>
					<tr id='tr_row_head'>
					    <th><div style='font-size:x-small;text-align:center;'>No. referencia</div></th>
					    <th><div style='font-size:x-small;text-align:center;'>Pensión</div></th>
					    <th><div style='font-size:x-small;text-align:center;'>Año lectivo</div></th>
						<th><div style='font-size:x-small;text-align:center;'>Fecha vencimiento</div></th>
						<th><div style='font-size:x-small;text-align:center;'>Valor de la deuda</div></th>
						<th id='select_deud_codigo_box' name='select_deud_codigo_box'>
							<div style='font-size:x-small;text-align:center;'>
								<input type='checkbox' id='ckb_deud_codigo_head' name='ckb_deud_codigo_head' onClick='js_pagos_select_all(this)'></input>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>";
	
		$i = 0;
		$num_linea = 0;
		foreach ( $tablacliente->rows as $row )
		{   if ( !empty( $row ) )
			{	$x = $codigoDeuda = $numeroFactura = $titularID = 0;
				if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
					$data.="<tr id='tr_row_".$num_linea."'>";
				foreach( $row as $column )
				{	if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
					{
						if ( $x == 0 )
						{   $titularID = $column;
						}
						if ( $x == 1 )
						{   $numeroFactura = $column;
						}
						if ( $x == 2 )
						{   $codigoDeuda = $column;
							/*$data = str_replace( "{yet_to_know_codigoDeuda}", $codigoDeuda, $data );
							//Hago el cambio del "{yet_to_know_codigoDeuda}" antes de saltar a la siguiente línea.
							//por ende, nunca habrá más de un "{yet_to_know_codigoDeuda}" a la vez.*/
						}
						if ( $row['estado'] == 'PAGADA' )
						{   if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 10 && $x != 9  && $x != 11 )
								$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						}
						if ( $row['estado'] == 'POR COBRAR' )
						{   if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 7 && $x != 9  && $x != 11 )
								$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						}
						$x++;
					}
				}
				if( $row['estado'] == 'POR COBRAR' && $row['totalAbonado'] == '0.00' )
				{	$i++;
					$data.="<td id='td_select_".$num_linea."' name='td_select_".$num_linea."' align='center'><div style='font-size:x-small;'>".
						"<input type='checkbox' id='ckb_deud_codigo' name='ckb_deud_codigo[]' value='".$codigoDeuda."'
							onclick='js_pagos_select_check_ind (this, ".$num_linea.")'></input>".
						"</div></td>
					</tr>";
				}
				$num_linea++;
			}
		}
		$data .= "	</tbody>".
			"	</table>".
			"<br>".
			"<button id='btn_pagar_deudas' name='btn_pagar_deudas' disabled='disabled' class='btn btn-success' type='submit' style='font-size:small;' >Pagar deudas marcadas</button>".
			"</form>";
	}
	if ( $tabla_estado =='P' )
	{   $name = 'tabla_estadoCuenta_paid';
		$data = "
				<input TYPE='hidden' NAME='event' ID='evento' value='get_debt'>
				<table class='table table-bordered' id='".$name."' name='".$name."'>
					<thead>
						<tr id='tr_row_head'>
							<th><div style='font-size:x-small;text-align:center;'>No. referencia</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Pensión</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Año lectivo</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Total Pago</div></th>
							<th><div style='font-size:x-small;text-align:center;'>Opciones</div></th>
						</tr>
					</thead>
					<tbody>";
		$num_linea = 0;
		foreach ( $tablacliente->rows as $row )
		{   if ( !empty( $row ) )
			{	$x = $codigoDeuda = $numeroFactura = $titularID = 0;
				if( $row['estado'] == 'PAGADA' )
					$data.="<tr id='tr_row_".$num_linea."'>";
				foreach( $row as $column )
				{	if( $row['estado'] == 'PAGADA' )
					{
						if ( $x == 0 )
						{   $titularID = $column;
						}
						if ( $x == 1 )
						{   $numeroFactura = $column;
						}
						if ( $x == 2 )
						{   $codigoDeuda = $column;
						}
						if( $x != 0 && $x != 1 && $x != 5 && $x != 6 && $x != 8 && $x != 9  && $x != 10 && $x != 11 )
							$data.="<td align='center'><div style='font-size:x-small;'>".$column."</div></td>";
						
						$x++;
					}
				}
				if( $row['estado'] == 'PAGADA' )
				{	$i++;
					$data.="
						<td align='center'  class='details-control'>".
							"<div style='font-size:x-small;'>".
								"<button class='btn btn-primary' id='".$codigoDeuda."_eliminar' style='font-size:small;' >Ver pago</button>".
							"</div>".
						"</td>".
					"</tr>";
				}
				$num_linea++;
			}
		}
		$data .= "	</tbody>".
			"	</table>";
	}
	if ($i == 0)
		return '0';
	else
		return $data;
}
/*function get_client_ip()
{   $ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	
	if ( $ipaddress != 'UNKNOWN' )
	{   $ipq = explode ( '.', $ipaddress );
		$ipaddress = "";
		foreach ($ipq as $cuarteto)
		{   $ipaddress += ( str_repeat("0", 3 - strlen( $cuarteto ) ) ) . $cuarteto;
		}
	}
	return $ipaddress;
}*/

?>