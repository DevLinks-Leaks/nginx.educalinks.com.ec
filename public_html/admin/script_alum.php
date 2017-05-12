<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'carga_dscto':
		$alum_codi=$_POST['alum_codi'];
		$tipo_dscto=$_POST['tipo_dscto'];
		
		$sql_opc = "{call str_consultaDescuentoalumnos_tipo(?,?)}";
		$params_opc= array($alum_codi,$tipo_dscto);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} 
		
		$res = sqlsrv_fetch_array($stmt_opc);
		echo $res['porcentaje'];
		
		
	break;
	case 'add':
		$alum_resp_form_banc_tarj_nume = $_POST['alum_resp_form_banc_tarj_nume'];
		if($alum_resp_form_banc_tarj_nume==''){
			$alum_resp_form_banc_tarj_nume_encrypt='';
		
		}else{
			/*Codigo de encriptado de Número de tarjeta de crédito*/
			$iv = base64_decode($_SESSION['clie_iv']);
			$alum_resp_form_banc_tarj_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume, MCRYPT_MODE_CBC, $iv);
			$alum_resp_form_banc_tarj_nume_encrypt =base64_encode($alum_resp_form_banc_tarj_nume_encrypt);
			/*FIN*/
		}
		$alum_tiene_seguro = ($_POST['alum_tiene_seguro']=='true'?1:0);
		$alum_condicionado = ($_POST['alum_condicionado']=='true'?1:0);
		$alum_tiene_discapacidad = ($_POST['alum_tiene_discapacidad']=='true'?1:0);
		$alum_genero = ($_POST['alum_genero']=='Hombre'?1:0);
		$alum_fech_naci=substr($_POST['alum_fech_naci'],6,4)."".substr($_POST['alum_fech_naci'],3,2)."".substr($_POST['alum_fech_naci'],0,2);
		$alum_fech_vcto=substr($_POST['alum_resp_form_fech_vcto'],6,4)."".substr($_POST['alum_resp_form_fech_vcto'],3,2)."".substr($_POST['alum_resp_form_fech_vcto'],0,2);
		$sql_opc = "{call alum_add(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array($alum_fech_naci,
							$_POST['alum_apel'],
							$_POST['alum_nomb'],
							$alum_genero,
							$_POST['alum_mail'],
							$_POST['alum_celu'],
							$_POST['alum_telf'],
							$_POST['alum_domi'],
							$_POST['alum_ciud'],
							$_POST['alum_pais'],
							$_POST['alum_cedu'],
							$_POST['alum_tipo_iden'],
							$_POST['alum_telf_emerg'],
							$_POST['alum_ex_plantel'],
							$_POST['alum_usua'], 
							$_POST['alum_parroquia'], 
							$_POST['alum_vive_con'], 
							$_POST['alum_movilizacion'], 
							$_POST['alum_motivo_cambio'], 
							$alum_tiene_discapacidad,
							$_POST['alum_discapacidad'], 
							$alum_condicionado, 
							$_POST['alum_conducta'], 
							$_POST['alum_ultimo_anio'], 
							$_POST['alum_nacionalidad'], 
							$_POST['alum_motivo_condicion'], 
							$_POST['alum_resp_form_pago'], 
							$_POST['alum_resp_form_banc_tarj'], 
							$alum_resp_form_banc_tarj_nume_encrypt, 
							$_POST['alum_resp_form_banc_tipo'], 
							$_POST['alum_resp_form_cedu'], 
							$_POST['alum_resp_form_tipo_iden'],
							$_POST['alum_resp_form_nomb'],
							//$_POST['alum_desc_porcentaje'],
							//$_POST['alum_desc_tipo'],
							$_SESSION['usua_codi'],
							$_SESSION['peri_codi'],
							'A',
							$_POST['alum_grup_econ'],
							$alum_fech_vcto,
							$_POST['idreligion'],
							$_POST['idparentescovivecon'],
							$_POST['idestadocivilpadres'],
							$_POST['alum_activ_deportiva'],
							$_POST['alum_activ_artistica'],
							$_POST['alum_enfermedades'],
							$_POST['alum_banc_emisor'],
							$_POST['alum_parentesco_emerg'],
							$_POST['alum_pers_emerg'],
							$_POST['alum_tipo_sangre'],
							$_POST['alum_prov_naci'],
							$_POST['alum_ciud_naci'],
							$_POST['alum_parr_naci'],
							$_POST['alum_sect_naci'],
							$_POST['alum_ex_plantel_dire'],
							$_POST['alum_ingreso_familiar'],
							$_POST['alum_hijo_ex_cadete'],
							$_POST['alum_hno_ex_cadete'],
							$_POST['alum_etnia'],
							$_POST['curs_prom'],
							$_POST['alum_prov'],
							$alum_tiene_seguro);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{	echo "¡Error! No se pudo hacer el ingreso";
			die( );
			//die( print_r( sqlsrv_errors(), true));
		} 
		
		$res = sqlsrv_fetch_array($stmt_opc);
		$alum_codi_resp=$res["alum_codi"];
		if($alum_codi_resp>0)
		{   //Para auditoría
			$detalle="Código: ".$alum_codi_resp;
			$detalle.=" Nombres: ".$_POST['alum_apel'].' '.$_POST['alum_nomb'];
			$detalle.=" Fecha ncto: ".$alum_fech_naci;
			$detalle.=" Género: ".($_POST['alum_genero']?'Hombre':'Mujer');
			$detalle.=" Cédula: ".$_POST['alum_cedu'];
			$detalle.=" e-Mail: ".$_POST['alum_mail'];
			$detalle.=" Celular: ".$_POST['alum_celu'];
			$detalle.=" Teléfono: ".$_POST['alum_telf'];
			$detalle.=" Domicilio: ".$_POST['alum_domi'];
			$detalle.=" Ciudad: ".$_POST['alum_ciud'];
			$detalle.=" Religión: ".$_POST['alum_reli'];
			$detalle.=" País: ".$_POST['alum_pais'];
			$detalle.=" Estado civil padres: ".$_POST['alum_estado_civil_padres'];
			$detalle.=" Teléfono emergencia: ".$_POST['alum_telf_emerg'];
			$detalle.=" Plantel anterior: ".$_POST['alum_ex_plantel'];
			$detalle.=" Usuario: ".$_POST['alum_usua'];
			$detalle.=" Forma Pago: ".$_POST['alum_resp_form_pago'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj'];
			// iNFO NUMERO CUENTA
			if(strpos($alum_resp_form_banc_tarj_nume, 'X') ===true)
				$detalle.=" # Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj_nume'];
			else{ 
				if (is_numeric($_POST['alum_resp_form_banc_tarj_nume']))
					$detalle.=" # Banco/Tarjeta: ".$alum_resp_form_banc_tarj_nume_encrypt;
				else
					$detalle.=" # Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj_nume'];
			}
			$detalle.=" Tipo Cuenta: ".($_POST['alum_resp_form_banc_tipo']=='C'?'Corriente':'Ahorro');
			$detalle.=" Responsable económico: ".$_POST['alum_resp_form_cedu'].' '.$_POST['alum_resp_form_nomb'];
			//$detalle.=" Descuento tipo: ".$_POST['alum_desc_tipo'];
			//$detalle.=" Descuento %: ".$_POST['alum_desc_porcentaje'];
			$detalle.=" Grupo económico: ".$_POST['alum_grup_econ'];
			$detalle.=" Grupo estado: ".$_POST['alum_estado'];
			registrar_auditoria (3, $detalle);
			// echo "¡Exito! Datos guardados correctamente";
			echo $alum_codi_resp;
		}
		else
		{   
			// echo "¡Error! No se pudo hacer el ingreso";
			echo "-1";
		}
	break; //FIN DE 'add'
	case 'add_curs_para':
		$sql_opc = "{call alum_curs_para_add(?,?,?,?,?)}";
		$params_opc= array($_POST['curs_para_codi'],$_POST['alum_codi'],$_POST['alum_curs_para_codi'],$_POST['esta_codi'],$_SESSION['peri_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al aplicar el estado.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			$detalle="Código curso paralelo: ".$_POST['curs_para_codi'];
			$detalle.=" Código alumno: ".$_POST['alum_codi'];
			$detalle.=" Código estado: ".$_POST['esta_codi'];
			$detalle.=" Código alumno_curso_paralelo: ".$_POST['alum_curs_para_codi'];
			registrar_auditoria (22, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Estado aplicado con éxito.' ));
		} 
		echo $result;
	break;
	case 'del_curs_para':
		$sql_opc = "{call alum_matri_del(?,?)}";
		$params_opc= array($_POST['curs_para_codi'],$_POST['alum_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "KO";
		} 
		$row = sqlsrv_fetch_array($stmt_opc);
		$respuesta = $row['veri'];
		if($respuesta>=0)
		{
			echo $respuesta;
		}
	break;
	case 'veri_usua':
		$sql_opc = "{call alum_veri_usua(?)}";
		$params_opc= array($_POST['alum_usua']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if($stmt_opc === false)
		{   echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} 
		$alum_view_opc = sqlsrv_fetch_array($stmt_opc);
		if($_POST['alum_usua']!="")
		{   if($alum_view_opc['veri']>0)
			{   $mensaje = "<span style='color:red;font-size:small;'><span class='icon-user'></span>
								Nombre de usuario ya existe.</span>";
				$data = array(	"MENSAJE"=>$mensaje,
								"VERIFIED"=> '0');
				echo json_encode( $data, true );
			}
			else
			{   $mensaje = "<span style='color:green;font-size:small;' class='icon-user'></span><span style='color:green;font-size:small;' class='icon-checkbox-checked'></span>";
				$data = array(	"MENSAJE"=>$mensaje,
								"VERIFIED"=> '1');
				echo json_encode( $data, true );
			}
		}
		else
		{   echo "";
		}
	break;
	case 'veri_bloq':
	
		$sql_opc = "{call alum_veri_usua(?)}";
		$params_opc= array($_POST['alum_usua']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		
		if  ($stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$alum_view_opc = sqlsrv_fetch_array($stmt_opc);
		
		if  ($alum_view_opc['cc']>0)   echo "A";
		else   echo"N";
		
	break;
	case 'desmask':
		include_once ('../framework/funciones.php');
		$flag = $_POST['flag'];
		$params = array($_POST['alum_codi']);
		$sql="{call alum_info(?)}";
		$stmt = sqlsrv_query($conn, $sql, $params);
		if( $stmt === false ){
			echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
		} 
		$alum_view= sqlsrv_fetch_array($stmt);
		/*descencriptar numero tarjeta*/
		if($alum_view['alum_resp_form_banc_tarj_nume']!=null and !is_numeric($alum_view['alum_resp_form_banc_tarj_nume'])){
			$alum_resp_form_banc_tarj_nume_dec=base64_decode($alum_view['alum_resp_form_banc_tarj_nume']);
			$iv = base64_decode($_SESSION['clie_iv']);
			$alum_resp_form_banc_tarj_nume = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume_dec, MCRYPT_MODE_CBC, $iv );
			// $alum_resp_form_banc_tarj_nume=rtrim($alum_resp_form_banc_tarj_nume,"\0");
			$alum_resp_form_banc_tarj_nume=preg_replace('/[^A-Za-z0-9\-]/', '',$alum_resp_form_banc_tarj_nume);
			if($flag=='false' and permiso_activo(21))
				$alum_resp_form_banc_tarj_nume =  creditCardMask($alum_resp_form_banc_tarj_nume,4,8);
		}else{
			$alum_resp_form_banc_tarj_nume=$alum_view['alum_resp_form_banc_tarj_nume'];
		}
		if($flag=='true'){
			$detalle='Alumno Código: '.$_POST['alum_codi'];
			registrar_auditoria (119, $detalle);
		}
		echo $alum_resp_form_banc_tarj_nume;
	break;
	case 'edi':
		$alum_resp_form_banc_tarj_nume = $_POST['alum_resp_form_banc_tarj_nume'];
		if($alum_resp_form_banc_tarj_nume==''){
			$alum_resp_form_banc_tarj_nume_encrypt='';
		
		}else{
			 if(strpos($alum_resp_form_banc_tarj_nume, 'X') ===false){
				/*Codigo de encriptado de Número de tarjeta de crédito*/
				$iv = base64_decode($_SESSION['clie_iv']);
				$alum_resp_form_banc_tarj_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume, MCRYPT_MODE_CBC, $iv);
				$alum_resp_form_banc_tarj_nume_encrypt =base64_encode($alum_resp_form_banc_tarj_nume_encrypt);
				/*FIN*/
			}else{
				$alum_resp_form_banc_tarj_nume_encrypt=null;
			}
		}
		$alum_tiene_seguro = ($_POST['alum_tiene_seguro']=='true'?1:0);
		$alum_tiene_discapacidad = ($_POST['alum_tiene_discapacidad']=='true'?1:0);
		$alum_condicionado = ($_POST['alum_condicionado']=='true'?1:0);
		$alum_genero = ($_POST['alum_genero']=='Hombre'?1:0);
		$alum_fech_naci=substr($_POST['alum_fech_naci'],6,4)."".substr($_POST['alum_fech_naci'],3,2)."".substr($_POST['alum_fech_naci'],0,2);
		$alum_fech_vcto=substr($_POST['alum_resp_form_fech_vcto'],6,4)."".substr($_POST['alum_resp_form_fech_vcto'],3,2)."".substr($_POST['alum_resp_form_fech_vcto'],0,2);
		$sql_opc = "{call alum_upd(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array( $_POST['alum_codi'],
							$alum_fech_naci,
							$_POST['alum_apel'],
							$_POST['alum_nomb'],
							$alum_genero,
							$_POST['alum_mail'],
							$_POST['alum_celu'],
							$_POST['alum_telf'],
							$_POST['alum_domi'],
							$_POST['alum_ciud'],
							$_POST['alum_pais'],
							$_POST['alum_cedu'],
							$_POST['alum_tipo_iden'],
							$_POST['alum_telf_emerg'],
							$_POST['alum_ex_plantel'],
							$_POST['alum_usua'], 
							$_POST['alum_parroquia'], 
							$_POST['alum_vive_con'], 
							$_POST['alum_movilizacion'], 
							$_POST['alum_motivo_cambio'], 
							$alum_tiene_discapacidad,
							$_POST['alum_discapacidad'], 
							$alum_condicionado, 
							$_POST['alum_conducta'], 
							$_POST['alum_ultimo_anio'], 
							$_POST['alum_nacionalidad'], 
							$_POST['alum_motivo_condicion'], 
							$_POST['alum_resp_form_pago'], 
							$_POST['alum_resp_form_banc_tarj'], 
							$alum_resp_form_banc_tarj_nume_encrypt, 
							$_POST['alum_resp_form_banc_tipo'], 
							$_POST['alum_resp_form_cedu'],
							$_POST['alum_resp_form_tipo_iden'],  
							$_POST['alum_resp_form_nomb'],
							//$_POST['alum_desc_porcentaje'],
							//$_POST['alum_desc_tipo'],
							$_SESSION['usua_codi'],
							$_SESSION['peri_codi'],
							'A',
							$_POST['alum_grup_econ'],
							$alum_fech_vcto,
							$_POST['idreligion'],
							$_POST['idparentescovivecon'],
							$_POST['idestadocivilpadres'],
							$_POST['alum_activ_deportiva'],
							$_POST['alum_activ_artistica'],
							$_POST['alum_enfermedades'],
							$_POST['alum_banc_emisor'],
							$_POST['alum_parentesco_emerg'],
							$_POST['alum_pers_emerg'],
							$_POST['alum_tipo_sangre'],
							$_POST['alum_prov_naci'],
							$_POST['alum_ciud_naci'],
							$_POST['alum_parr_naci'],
							$_POST['alum_sect_naci'],
							$_POST['alum_ex_plantel_dire'],
							$_POST['alum_ingreso_familiar'],
							$_POST['alum_hijo_ex_cadete'],
							$_POST['alum_hno_ex_cadete'],
							$_POST['alum_etnia'],
							$_POST['alum_prov'],
							$alum_tiene_seguro);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if($stmt_opc === false)
		{   echo "¡Error! No se pudo hacer el ingreso";
			//die( print_r( sqlsrv_errors(), true));
			die( );
		}
		else
		{   $alum_view_opc = $_POST['alum_codi'];
		}
		if( !empty( $alum_view_opc ) )
		{   		
			//Para auditoría
			$detalle ="Código: ".$_POST['alum_codi'];
			$detalle.=" Nombres: ".$_POST['alum_apel'].' '.$_POST['alum_nomb'];
			$detalle.=" Fecha ncto: ".$alum_fech_naci;
			$detalle.=" Cédula: ".$_POST['alum_cedu'];
			$detalle.=" e-Mail: ".$_POST['alum_mail'];
			$detalle.=" Celular: ".$_POST['alum_celu'];
			$detalle.=" Teléfono: ".$_POST['alum_telf'];
			$detalle.= " Domicilio: ".$_POST['alum_domi'];
			$detalle.=" Ciudad: ".$_POST['alum_ciud'];
			$detalle.=" Religión: ".$_POST['alum_reli'];
			$detalle.=" País: ".$_POST['alum_pais'];
			$detalle.=" Estado civil padres: ".$_POST['alum_estado_civil_padres'];
			$detalle.=" Teléfono emergencia: ".$_POST['alum_telf_emerg'];
			$detalle.=" Plantel anterior: ".$_POST['alum_ex_plantel'];
			$detalle.=" Usuario: ".$_POST['alum_usua'];
			$detalle.=" Forma Pago: ".$_POST['alum_resp_form_pago'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj'];
			// iNFO NUMERO CUENTA
			if(strpos($alum_resp_form_banc_tarj_nume, 'X') ===true)
				$detalle.=" # Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj_nume'];
			else{ 
				if (is_numeric($_POST['alum_resp_form_banc_tarj_nume']))
					$detalle.=" # Banco/Tarjeta: ".$alum_resp_form_banc_tarj_nume_encrypt;
				else
					$detalle.=" # Banco/Tarjeta: ".$_POST['alum_resp_form_banc_tarj_nume'];
			}
			$detalle.=" Tipo Cuenta: ".($_POST['alum_resp_form_banc_tipo']=='C'?'Corriente':'Ahorro');
			$detalle.=" Responsable económico: ".$_POST['alum_resp_form_cedu'].' '.$_POST['alum_resp_form_nomb'];
			//$detalle.=" Descuento tipo: ".$_POST['alum_desc_tipo'];
			//$detalle.=" Descuento %: ".$_POST['alum_desc_porcentaje'];
			$detalle.=" Grupo económico: ".$_POST['alum_grup_econ'];
			$detalle.=" Grupo estado: ".$_POST['alum_estado'];
			registrar_auditoria (4, $detalle);

			echo "¡Exito! Datos guardados correctamente";
			//echo $alum_view_opc;
		}
		else
		{   //echo "¡Advertencia! Los datos fueron guardados pero hubo un problema al tratar de guardar la auditoria";
			echo "¡Error! No se pudo hacer el ingreso";
			//echo -1;
		}
		
	break;
	case 'alum_delete':
		$sql_opc = "{call alum_delete(?)}";
		$params_opc= array($_POST['alum_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die (print_r( sqlsrv_errors(), true));
		} 
		$alum_view_opc=$_POST['alum_codi'];
		
		$detalle="Código: ".$_POST['alum_codi'];
		registrar_auditoria (5, $detalle);
		
		echo $alum_view_opc;

	break;
	case 'alum_del':
		$sql_opc = "{call alum_del(?,?)}";
		$params_opc= array($_POST['alum_codi'], $_POST['alum_curs_para_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die (print_r( sqlsrv_errors(), true));
		} 
		$alum_view_opc=$_POST['alum_codi'];
		
		echo $alum_view_opc;
		
		//Para auditoría
		$detalle="Código: ".$_POST['alum_codi'];
		registrar_auditoria (5, $detalle);
		/////////////////////////////////////
		////////////////////////////////////PENDIENTE
		//Para Registro de Estado.
		$alum_est_peri_codi=-1;
		$alum_codi=$alum_view_opc;
		/*$sql_opc = "{call alum_add_alum_est_peri_reg(?,?,?,?,?)}";
		$params_opc= array($alum_est_peri_codi, $alum_codi, $_SESSION['peri_codi'], $_SESSION['usua_codi'],$_SESSION['USUA_TIPO']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} */
		$alum_view_opc=0;
		$alum_view_opc=lastId($stmt_opc);
		if($alum_view_opc>0)
		{
			echo $alum_view_opc;
			//Para auditoría
			$detalle="Registro Tabla Alumnos_Alumno_Estado_Periodo. Código: ".$alum_view_opc;
			$detalle.=" Estado: ".$_POST['alum_estado'];
			registrar_auditoria (4, $detalle);
		}
		else
		{
			echo "-1";
		}
	break;
	case 'add_repre':
		$sql_opc = "{call repre_add(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array($_POST['alum_fech_naci'],
							$_POST['alum_apel'],
							$_POST['alum_nomb'],
							$_POST['alum_mail'],
							$_POST['alum_celu'],
							$_POST['alum_telf'],
							$_POST['alum_domi'],
							$_POST['alum_ciud'],
							$_POST['alum_reli'],
							$_POST['alum_pais'],
							$_POST['alum_cedu'],
							$_POST['alum_estado_civil_padres'],
							$_POST['alum_telf_emerg'],
							$_POST['alum_ex_plantel'],
							$_POST['alum_usua']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		} 
		$repre_view_opc=0;
		$repre_view_opc=lastId($stmt_opc);
		if($repre_view_opc>0){echo $repre_view_opc;}else{echo "-1";}
	break;
	
	case 'alum_ret'://Retiro de alumno
		$params = array($_POST['alum_curs_para_codi'],$_POST['check']);
		$sql = "{call alum_curs_para_retiro(?,?)}";
		$stmt = sqlsrv_query( $conn, $sql, $params);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al retirar al alumno.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			sqlsrv_next_result($stmt);
			$res = sqlsrv_fetch_array($stmt);

			$alum_codi_result = $res['alum_codi'];
			//Para auditoría
			$detalle="Código: ".$alum_codi_result;
			$detalle.=" Check: ".$_POST['check'];
			registrar_auditoria (56, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Retiro de alumno con éxito.' ));
		}
		echo $result;
		
	break;
	
	case 'alum_curs_para_obse_upd'://Retiro de alumno
		$params = array($_POST['alum_curs_para_codi'],$_POST['obse']);
		$sql = "{call alum_curs_para_obse_upd(?,?)}";
		$stmt = sqlsrv_query( $conn, $sql, $params);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al guardar la observación al alumno.',
						'console'=> sqlsrv_errors() ));
		}else{
			$result= json_encode(array ('state'=>'success',
					'result'=>'Observación guardada con éxito.' ));
		}
		echo $result;
		
	break;

	case 'camb_curs_para'://Cambio de paralelo del alumno
		$params = array($_POST['alum_curs_para_codi'], $_POST['curs_para_codi']);
		$sql = "{call alum_curs_para_cambio(?,?)}";
		$stmt = sqlsrv_query( $conn, $sql, $params);
		if ($stmt===false)
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			echo "1";
		}
	break;
	case 'alum_add_alum_est_peri_reg':
		//Para Registro de Cambio de estado.
		$alum_est_peri_codi=$_POST['alum_est_peri_codi'];
		$alum_codi=$_POST['alum_codi'];
		$peri_codi=$_POST['peri_codi'];
		$sql_opc = "{call alum_add_alum_est_peri_reg(?,?,?,?,?)}";
		$options =  array( "Scrollable" => "buffered" );
		$params_opc= array($alum_est_peri_codi, $alum_codi, $peri_codi, $_SESSION['usua_codi'], $_SESSION['USUA_TIPO']);
		$stmt_opc = sqlsrv_query($conn, $sql_opc, $params_opc, $options);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while($row_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC)) 
			{	echo $alum_est_peri_codi;
				//Para auditoría
				$detalle="Registro Tabla Alumnos_Alumno_Estado_Periodo. Código: ".$alum_est_peri_codi;
				$detalle.=" Estado: ".$_POST['alum_alum_est_peri_codi'];
				registrar_auditoria (3, $detalle);
			}			
		}
		else
		{
			echo "Exec alum_add_alum_est_peri_reg ".$alum_est_peri_codi." ".$alum_codi." ".$peri_codi." ".$_SESSION['usua_codi']." ".$_SESSION['USUA_TIPO'];
		}
	break;
	case 'alum_info_alum_est_check':
		$sql_opc="{call alum_info_alum_est_check(?,?,?,?,?)}";
		$check= ($_POST['check']=='true') ? 0 : 1;
		$params_opc = array($_POST['check'], $_POST['alum_curs_para_codi'], $_POST['columna'], $_SESSION['usua_codi'], $_SESSION['USUA_TIPO']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}else{
			echo 1;
			$detalle2=" Columna: ".$_POST['columna'];
			$detalle2+=" Valor del visto: ".$check;
			$detalle2+=" Alumno Curso Paralelo: ".$_POST['alum_curs_para_codi'];
			registrar_auditoria (49, $detalle2);			
		}
	break;
	case 'alum_info_docu_check':
		$sql_opc="{call alum_info_docu_check(?,?,?,?)}";
		$params_opc = array($_POST['check'], $_POST['alum_codi'], $_POST['peri_codi'], $_POST['docu_peri_codi']);
		$options_tareas =  array( "Scrollable" => "buffered" );
		$stmt_opc = sqlsrv_query( $conn, $sql_opc, $params_opc, $options_tareas);
		$row_count_tareas = sqlsrv_num_rows($stmt_opc);
		if( $stmt_opc === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if($row_count_tareas>0)
		{	while( $row_alum_docu = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC) ) 
			{	echo $row_count_tareas;
				$detalle2=" Codigo: ".$row_alum_docu['docu_peri_codi'];
				$detalle2.=" Valor del visto: ".$row_alum_docu['visto'];
				$detalle2.=" Alumno Codigo: ". $_POST['alum_codi'];
				//$detalle2+=" Fecha registro: ".$row_alum_docu['fecha_reg'];
				registrar_auditoria (49, $detalle2);
			}			
		}
		else
		{
			echo $row_count_tareas;
		}
	break;
	case 'alum_moti_bloq_opci_view':
		$alum_codi	= $_POST['alum_codi'];
		$sql		= "{call alum_bloq_opc_all(?)}";
		$params		= array($alum_codi);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		echo "<table class='table_striped' id='tbl_alum_bloq'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Motivo</th>";
		echo "<th>Opción Bloqueada</th>";
		echo "<th>Periodo</th>";
		echo "<th>Opciones</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = sqlsrv_fetch_array($stmt))
		{	echo "<tr>";
			echo "<td>".$row["moti_bloq_deta"]."</td>";
			echo "<td>".$row["opci_deta"]."</td>";
			echo "<td>".$row["peri_deta"]."</td>";
			echo "<td>";
			echo "<div class='menu_options'>";
			echo "<ul>";
			if (permiso_activo(520)){
				echo "<li><a class=\"option\" onclick=\"alum_bloq_moti_opci_del('div_bloqueos',".$alum_codi.",".$row["alum_moti_bloq_opci_codi"].",'alum_moti_bloq_opci_view')\"><span class='icon-remove icon'></span> Quitar</a><li>";
			}
			echo "</ul>";
			echo "</div>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	break;
	case 'alum_moti_bloq_opci_only_view':
		$sql		= "{call alum_bloq_opc_all(?)}";
		$options	= array("scrollable"=>"buffered");
		$params		= array($_POST['alum_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params, $options);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if (sqlsrv_has_rows($stmt))
		{	echo "<table class='table_striped' id='tbl_alum_bloq'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Motivo</th>";
			echo "<th>Opción Bloqueada</th>";
			echo "<th>Periodo</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = sqlsrv_fetch_array($stmt))
			{	echo "<tr>";
				echo "<td>".$row["moti_bloq_deta"]."</td>";
				echo "<td>".$row["opci_deta"]."</td>";
				echo "<td>".$row["peri_deta"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		else
		{	echo "No Mora";
		}
	break;
	case 'alum_moti_bloq_opci_add':
		$sql		= "{call alum_moti_bloq_opci_add(?,?,?,?)}";
		$params		= array($_POST['alum_codi'],$_POST['moti_bloq_codi'],$_POST['opci_codi'],$_SESSION['peri_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params);
		$rows_count	= sqlsrv_rows_affected($stmt);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if ($rows_count===false)
		{	die( print_r( sqlsrv_errors(), true));
		}
		if ($rows_count>0)
		{	$detalle = "Código: ".$_POST['alum_codi'];
			//$detalle.= " (moti_bloq_codi=".$_POST['moti_bloq_codi'].")";
			//$detalle.= " (opci_codi=".$_POST['opci_codi'].")";
			//$detalle.= " (peri_codi=".$_SESSION['peri_codi'].")";
			registrar_auditoria (54, $detalle);
			echo $rows_count;
		}
	break;
	case 'alum_moti_bloq_opci_del':
		$sql		= "{call alum_moti_bloq_opci_del(?)}";
		$params		= array($_POST['alum_moti_bloq_opci_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params);
		$rows_count	= sqlsrv_rows_affected($stmt);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if ($rows_count===false)
		{	die( print_r( sqlsrv_errors(), true));
		}
		if ($rows_count>0)
		{	
			$detalle = "Código: ".$_POST['alum_codi'];
			//$detalle.= " (alum_moti_bloq_opci_codi=".$_POST['alum_moti_bloq_opci_codi'].")";
			registrar_auditoria (55, $detalle);
			echo $rows_count;
		}
	break;
	case 'alum_deudaMatricula':
		$sql		= "{call str_common_deudasMatricula_cons(?)}";
		$options	= array("scrollable"=>"buffered");
		$params		= array($_POST['alum_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params, $options);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if (sqlsrv_has_rows($stmt))
		{	$row = sqlsrv_fetch_array($stmt);
			if( $row["totalDeuda"] != '0.00' )
			{   echo "<div class='alert alert-warning'>
					  <strong>¡Deuda pendiente!</strong>".
					  "<center>No se puede matricular. Tiene una deuda pendiente de $".$row["totalDeuda"].".<br>
					  <span class='icon icon-file'></span>&nbsp;".
					  "<a href='../modulos/finan/clientes/controller.php?event=print_report&codigoAlumno=".$_POST['alum_codi'].
					  "&codigoPeriodo=&fechaInicio=&fechaFin=' target='_blank'>Ver estado de cuenta</a></center>
				  </div>";
			}
			else
			{	echo "<center>Alumno no tiene deudas financieras pendientes.</center>";
			}
		}
		else
		{	echo "<center>Alumno no tiene deudas financieras pendientes.</center>";
		}
	break;
	case 'alum_curs_para_info':
		$sql		= "{call alum_curs_para_info(?)}";
		$params		= array($_POST['alum_curs_para_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params);
		if( $stmt === false )
		{	echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		if (sqlsrv_has_rows($stmt))
		{	$row = sqlsrv_fetch_array($stmt);
			$result = array ("error"=>"no",
							 "alum_codi"=>$row["alum_codi"],
							 "alum_nomb"=>$row["alum_nomb"],
							 "alum_apel"=>$row["alum_apel"],
							 "curs_deta"=>$row["curs_deta"],
							 "para_deta"=>$row["para_deta"]);
		}
		else
		{	$result = array ("error"=>"si",
							 "mensaje"=>"No existe un registro con el código ".$_POST["alum_curs_para_codi"]);
		}
		echo json_encode($result);
	break;
	case 'alum_change_course':
		$sql		= "{call alum_curs_para_change(?,?)}";
		$params		= array($_POST['curs_para_codi'],$_POST['alum_curs_para_codi']);
		$stmt	 	= sqlsrv_query( $conn, $sql, $params);
		if( $stmt === false )
		{	
			// echo "Error in executing statement .\n";
			// die( print_r( sqlsrv_errors(), true));
			$result = array ("state"=>"error",
							 "mensaje"=>"Ocurrió un error al cambiar curso.");
		}
		if (sqlsrv_has_rows($stmt))
		{	$row = sqlsrv_fetch_array($stmt);
			$result = array ("state"=>$row['estado'],
							 "mensaje"=>$row["mensaje"]);
		}
		else
		{	$result = array ("state"=>"error",
							 "mensaje"=>"Ocurrió un error al cambiar curso.");
		}
		echo json_encode($result);
	break;
}
?>