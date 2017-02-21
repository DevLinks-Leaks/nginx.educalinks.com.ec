 <?php 
	session_start();
	
	if (isset($_SESSION['erro'])) unset($_SESSION['erro']);
	include('dbconf.php'); 
	include ('funciones.php'); 
	include ('lenguaje.php');
	
	setcookie('tipo',$_POST['tipo'], time() + (86400 * 30), "/");
	
	$_SESSION['current_language'] = current_language();
	if (!isset($_SESSION['current_language'])) $_SESSION['current_language']='ESP';
	
	if(isset($_POST['que2'])){	
		if($_POST['que2'] == 'IN_API'){	
			$params = array($_POST["usua"],$_POST["pass"],$_POST["tipo"]);
			$sql="{call dbo.main_logi(?,?,?)}";
			$resu_login = sqlsrv_query($conn, $sql, $params);  
			if ($row = sqlsrv_fetch_array($resu_login)){ 
				echo "llega";
				 // Valida que el ingreso este OK
				if  ( $row['RESU']== 'OK')  {

					/* 	1 alumnos  //  2 repre  //  3 docente  // 4 admin  */
					////////   ALUMNOS ////////////////////
					if  ($_POST['tipo'] == '1')  {
						
						header('Location: ../index_mante.php');
						//Carga periodo activos para el perfil 
						PeriodoActivo(tipo_por_etapa($_POST['tipo']));
					 	
						
						$params2 = array($_POST["usua"],$_POST["pass"],$_SESSION['peri_codi']);
						$sql2="{call alum_info_usua(?,?,?)}";
						$resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
						$row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info);
						
						$_SESSION['alum_codi']=$row_resu_alum_info['alum_codi'];
						$_SESSION['alum_nomb']=$row_resu_alum_info['alum_nomb'];
						$_SESSION['alum_apel']=$row_resu_alum_info['alum_apel'];
						$_SESSION['alum_mail']=$row_resu_alum_info['alum_mail'];
						$_SESSION['alum_usua']=$row_resu_alum_info['alum_usua'];
						$_SESSION['alum_celu']=$row_resu_alum_info['alum_celu'];
						$_SESSION['alum_fech_naci']=date_format($row_resu_alum_info['alum_fech_naci'],'d/m/Y');
						$_SESSION['alum_domi']=$row_resu_alum_info['alum_domi'];
						$_SESSION['alum_telf']=$row_resu_alum_info['alum_telf'];
						$_SESSION['alum_cedu']=$row_resu_alum_info['alum_cedu'];
						$_SESSION['alum_ciud']=$row_resu_alum_info['alum_ciud'];
						$_SESSION['alum_reli']=$row_resu_alum_info['alum_reli'];
						$_SESSION['alum_pais']=$row_resu_alum_info['alum_pais'];
						$_SESSION['alum_estado_civil_padres']=$row_resu_alum_info['alum_estado_civil_padres'];
						$_SESSION['alum_telf_emerg']=$row_resu_alum_info['alum_telf_emerg'];
						$_SESSION['alum_ex_plantel']=$row_resu_alum_info['alum_ex_plantel'];
						$_SESSION['curs_para_codi']=$row_resu_alum_info['curs_para_codi'];
						$_SESSION['curs_codi']=$row_resu_alum_info['curs_codi'];
						$_SESSION['para_codi']=$row_resu_alum_info['para_codi'];
						$_SESSION['repr_codi']=$row_resu_alum_info['repr_codi'];
						$_SESSION['peri_dist_cab_tipo']=$row_resu_alum_info['peri_dist_cab_tipo'];
						
						$_SESSION['ISBIEN_ALUM'] = 'YESIN';
						$_SESSION['ISBIEN_ADMIN'] = 'NOTIN';
						$_SESSION['ISBIEN_PROF'] = 'NOTIN';
						
						$_SESSION['USUA_TIPO'] = 'A';
						$_SESSION['USUA_TIPO_CODI'] = $_POST['tipo'];
						$_SESSION['USUA_DE']=$row_resu_alum_info['alum_codi'];
						header('Location: ../alumnos/index.php');
					
					}
					
					
					////////   REPRESENTANTES ////////////////////
					if  ($_POST['tipo'] == '2')  {
						
						header('Location: ../index_mante.php');
						
						//Carga periodo activos para el perfil 
						PeriodoActivo(tipo_por_etapa($_POST['tipo']));
						
						 
						$params2 = array($_POST["usua"]);
						$sql2="{call repr_info_usua(?)}";
						$repr_info_usua = sqlsrv_query($conn, $sql2, $params2);  
						$row_repr_info_usua = sqlsrv_fetch_array($repr_info_usua);
						
								
						$_SESSION['repr_codi']=$row_repr_info_usua['repr_codi'];
						$_SESSION['repr_nomb']=$row_repr_info_usua['repr_nomb'];
						$_SESSION['repr_apel']=$row_repr_info_usua['repr_apel'];
						$_SESSION['repr_mail']=$row_repr_info_usua['repr_email'];
						$_SESSION['repr_usua']=$row_repr_info_usua['repr_usua'];
						$_SESSION['repr_cedula']=$row_repr_info_usua['repr_cedula'];
						$_SESSION['repr_telf']=$row_repr_info_usua['repr_telf'];
						$_SESSION['repr_domi']=$row_repr_info_usua['repr_domi'];
						$_SESSION['repr_celular']=$row_repr_info_usua['repr_celular'];
						$_SESSION['repr_pass']=$row_repr_info_usua['repr_pass'];
						$_SESSION['repr_estado_civil']=$row_repr_info_usua['repr_estado_civil'];
						$_SESSION['repr_parentesco']=$row_repr_info_usua['repr_parentesco'];
						
						//seccion de datos del representado mayor
						$params2 = array($_SESSION['repr_codi'],$_SESSION['peri_codi']);
						$sql2="{call repr_alum_info_princ_usua(?,?)}";
						$resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
						$row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info);
						
						$_SESSION['alum_codi']=$row_resu_alum_info['alum_codi'];
						$_SESSION['alum_nomb']=$row_resu_alum_info['alum_nomb'];
						$_SESSION['alum_apel']=$row_resu_alum_info['alum_apel'];
						$_SESSION['alum_mail']=$row_resu_alum_info['alum_mail'];
						$_SESSION['alum_usua']=$row_resu_alum_info['alum_usua'];
						$_SESSION['alum_celu']=$row_resu_alum_info['alum_celu'];
						$_SESSION['alum_fech_naci']=date_format($row_resu_alum_info['alum_fech_naci'],'d/m/Y');
						$_SESSION['alum_domi']=$row_resu_alum_info['alum_domi'];
						$_SESSION['alum_telf']=$row_resu_alum_info['alum_telf'];
						$_SESSION['alum_cedu']=$row_resu_alum_info['alum_cedu'];
						$_SESSION['alum_ciud']=$row_resu_alum_info['alum_ciud'];
						$_SESSION['alum_reli']=$row_resu_alum_info['alum_reli'];
						$_SESSION['alum_pais']=$row_resu_alum_info['alum_pais'];
						$_SESSION['alum_estado_civil_padres']=$row_resu_alum_info['alum_estado_civil_padres'];
						$_SESSION['alum_telf_emerg']=$row_resu_alum_info['alum_telf_emerg'];
						$_SESSION['alum_ex_plantel']=$row_resu_alum_info['alum_ex_plantel'];
						$_SESSION['curs_para_codi']=$row_resu_alum_info['curs_para_codi'];
						$_SESSION['curs_codi']=$row_resu_alum_info['curs_codi'];
						$_SESSION['para_codi']=$row_resu_alum_info['para_codi'];
						$_SESSION['peri_dist_cab_tipo']=$row_resu_alum_info['peri_dist_cab_tipo'];
						
						//datos de usuario representante
						$_SESSION['ISBIEN_ALUM'] = 'YESIN';
						$_SESSION['ISBIEN_ADMIN'] = 'NOTIN';
						$_SESSION['ISBIEN_PROF'] = 'NOTIN';
						
						$_SESSION['USUA_TIPO'] = 'R';
						$_SESSION['USUA_TIPO_CODI'] = $_POST['tipo'];
						$_SESSION['USUA_DE']=$row_repr_info_usua['repr_codi'];
						header('Location: ../alumnos/index.php');
					
					}
					
					
					
					
					////////   DOCENTES ////////////////////
					if  ($_POST['tipo'] == '3')  {
						//Carga periodo activos para el perfil 
						PeriodoActivo(tipo_por_etapa($_POST['tipo']));
					 
						 
						$params2 = array($_POST["usua"]);
						$sql2="{call prof_info_usua(?)}";
						$resu_prof_info = sqlsrv_query($conn, $sql2, $params2);  
						$row_resu_prof_info = sqlsrv_fetch_array($resu_prof_info);
						
								
						$_SESSION['prof_codi']=$row_resu_prof_info['prof_codi'];
						$_SESSION['prof_nomb']=$row_resu_prof_info['prof_nomb'];
						$_SESSION['prof_apel']=$row_resu_prof_info['prof_apel'];
						$_SESSION['prof_mail']=$row_resu_prof_info['prof_mail'];
						$_SESSION['prof_dire']=$row_resu_prof_info['prof_dire'];
						$_SESSION['prof_telf']=$row_resu_prof_info['prof_telf'];
						$_SESSION['prof_cedu']=$row_resu_prof_info['prof_cedu'];
						$_SESSION['prof_usua']=$row_resu_prof_info['prof_usua'];
						
						$_SESSION['ISBIEN_PROF'] = 'YESIN';
						$_SESSION['ISBIEN_ADMIN'] = 'NOTIN';
						$_SESSION['ISBIEN_ALUM'] = 'NOTIN';
						
						$_SESSION['USUA_TIPO'] = 'D';
						$_SESSION['USUA_TIPO_CODI'] = $_POST['tipo'];
						$_SESSION['USUA_DE'] =  $row_resu_prof_info['prof_codi'];
						
						if (es_tutor($row_resu_prof_info['prof_codi'], $_SESSION['peri_codi'])>0)
							$_SESSION['es_tutor'] = true;
						else
							$_SESSION['es_tutor'] = false;
							
						header('Location: ../docentes/index.php');
					
					}
					
					////////   ADMINISTRATIVOS ////////////////////
					if  ($_POST['tipo'] == '4')  {
						//Carga periodo ctivos para el perfil 
						PeriodoActivo(tipo_por_etapa($_POST['tipo']));
					 							
						//Carga informacion de Adminitrador - 
						include ('../admin/script_admi.php');
						admin_sesion($_POST["usua"]);
																		
						$_SESSION['ISBIEN_ADMIN'] = 'YESIN';
						$_SESSION['ISBIEN_ALUM'] = 'NOTIN';
						$_SESSION['ISBIEN_PROF'] = 'NOTIN';
						
						$_SESSION['USUA_TIPO'] = tipo_por_etapa($_POST['tipo']);
						$_SESSION['USUA_TIPO_CODI'] = $_POST['tipo'];
						 
						//header('Location: ../modulo.php?usua_codigo='.$_POST['usua']);
						header('Location: ../modulo.php');
					
					}
					///////// CARGA DE PERMISOS ///////////
					
					//Para auditoría
					$ua = getBrowser();
					$detalle="Ip: ".$_SERVER['REMOTE_ADDR'];
					$detalle.=" Navegador: ".$ua['name'];
					$detalle.=" Versión: ".$ua['version'];
					$detalle.=" Plataforma: ".$ua['platform'];
					registrar_auditoria (1, $detalle);
				}else{
					$_SESSION['erro'] = 'La informaci&oacute;n de usuario o contrase&ntilde;a es incorrecta';
					header('Location: ../index.php'); 
				}	
			}
  
		}
	}
	else{
		$_SESSION['erro'] = 'La informaci&oacute;n de usuario o contrase&ntilde;a es incorrecta';
		header('Location: ../index.php'); 
	}
	
	
	//seccion de seteo de variable globales obligatorias
	//$_SESSION['ruta_foto_alumno']="../fotos/alumnos/".$_SESSION['peri_codi']."/";
	
	$_SESSION['ruta_foto_alumno']="../fotos/".$_SESSION['directorio']."/alumnos/".$_SESSION['peri_codi']."/";
	$_SESSION['ruta_foto_docente']="../fotos/".$_SESSION['directorio']."/docentes/";
	$_SESSION['ruta_foto_repre']="../fotos/representantes/".$_SESSION['peri_codi']."/";
	$_SESSION['ruta_foto_admin']="../fotos/".$_SESSION['directorio']."/admin/";
	
	$_SESSION['ruta_foto_escudo_ecuador']="../imagenes/clientes/".$_SESSION['directorio']."/escudo_ecuador.png";
	$_SESSION['ruta_foto_logo_web']="../imagenes/clientes/".$_SESSION['directorio']."/logo_inicial.png";
	$_SESSION['ruta_foto_firma']="../imagenes/clientes/".$_SESSION['directorio']."/firma.png";
	$_SESSION['ruta_foto_logo_index']="../imagenes/clientes/".$_SESSION['directorio']."/logo_inicial_long.png";
	$_SESSION['ruta_foto_logo_title']="../imagenes/clientes/".$_SESSION['directorio']."/logo_inicial_title.png";
	$_SESSION['ruta_foto_logo_bg']="../imagenes/clientes/".$_SESSION['directorio']."/logo_inicial_bg.png";
	$_SESSION['ruta_foto_logo_rep']="../imagenes/clientes/".$_SESSION['directorio']."/logo_inicial.png";
	$_SESSION['ruta_foto_logo_minis']="../imagenes/clientes/".$_SESSION['directorio']."/logo_minis.png";
	$_SESSION['ruta_foto_logo_minis_long']="../imagenes/clientes/".$_SESSION['directorio']."/logo_minis_long.png";
	$_SESSION['ruta_foto_logo_libreta'] = "../imagenes/reportes/".$_SESSION['directorio']."/logo_libreta.png";
	$_SESSION['ruta_foto_logo_distr']="../imagenes/clientes/".$_SESSION['directorio']."/logo_distr.png";
	$_SESSION['ruta_foto_logo_subse']="../imagenes/clientes/".$_SESSION['directorio']."/logo_subse.png";
	$_SESSION['ruta_foto_usuario']="";
	$_SESSION['foto_default']="../fotos/".$_SESSION['directorio']."/default.jpg";
	$_SESSION['ruta_materiales_carga']="../files/".$_SESSION['directorio'].'/'.$_SESSION['peri_codi']."/";
	switch($_POST['tipo']){
		case '1':
			$_SESSION['ruta_foto_usuario']=$_SESSION['ruta_foto_alumno'];
		break;
		case '2':
			$_SESSION['ruta_foto_usuario']=$_SESSION['ruta_foto_repre'];
		break;
		case '3':
			$_SESSION['ruta_foto_usuario']=$_SESSION['ruta_foto_docente'];
		break;
		case '4':
			$_SESSION['ruta_foto_usuario']="../fotos/".$_SESSION['directorio']."/admin/";
		break;
		default: 
			$_SESSION['ruta_foto_usuario']="../fotos/".$_SESSION['directorio']."/admin/";
		break;
	}
	
	?> 
 