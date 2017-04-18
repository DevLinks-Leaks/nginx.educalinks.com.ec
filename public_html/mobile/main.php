<?php

	include 'Classes/Representante.php';
	include 'Classes/Clientes.php';
	include 'Classes/Alumnos.php';
	include 'Classes/Agenda.php';
	include 'Classes/Notificaciones.php';
	include 'Classes/NotiUpdate.php';
	include 'Classes/Notificacionesall.php';
	include 'Classes/mensajesAll.php';
	include 'Classes/profesores.php';
	include 'Classes/mensajeNuevo.php';
	include 'Classes/mensajeEliminar.php';
	include 'Classes/mensajeUpdate.php';
        include 'Classes/facturasAutorizadas.php';
	include 'Classes/Alumnoslogin.php';
        include 'Classes/Clases.php';
        include 'Classes/Materiales.php';
        include 'Classes/Etapas.php';
        include 'Classes/NotificacionesAlumnos.php';
        include 'Classes/NotiUpdateAlumnos.php';
        include 'Classes/appUpdateAlum.php';
        include 'Classes/appUpdateRepr.php';
        include 'Classes/BotonPagoLista.php';
        include 'Classes/AlumnosBloqueo.php';
        include 'Classes/AlumnosBloqueo2.php';
        include 'Classes/DeudasVencidas.php';
        include 'Classes/PagosRealizados.php';
        include 'Classes/BotonPagoDeuda.php';
        include 'Classes/actualizaBotonPago.php';
        include 'Classes/VisitasMedicas.php';
        include 'Classes/detalleVisitasMedicas.php';
        include 'Classes/tipoObservacion.php';
        include 'Classes/observacionesPorTipo.php';
        
	if (isset($_POST["username"]))
		$username = $_POST["username"];
	else
		$username = "";
	
	if (isset($_POST["password"]))
		$password = $_POST["password"];
	else
		$password = "";
		
	if (isset($_POST["tipo_usua"]))
		$tipo_usua = $_POST["tipo_usua"];
	else
		$tipo_usua = "";
		
	if (isset($_POST["colegio"]))
		$colegio = $_POST["colegio"];
	else
		$colegio = "";
	
	if (isset($_POST["reprcodi"]))
		$reprcodi = $_POST["reprcodi"];
	else
		$reprcodi = "";
	
	if (isset($_POST["pericodi"]))
		$pericodi = $_POST["pericodi"];
	else
		$pericodi = "";
	
	if (isset($_POST["alumnocodi"]))
		$alumnocodi = $_POST["alumnocodi"];
	else
		$alumnocodi = "";
		
        if (isset($_POST["opci_codi"]))
		$opci_codi = $_POST["opci_codi"];
	else
		$opci_codi = "";	
                
        if (isset($_POST["op"]))
		$op = $_POST["op"];
	else
		$op = "";
                
        if (isset($_POST["tipoMens"]))
		$tipoMens = $_POST["tipoMens"];
	else
		$tipoMens = "";
                
        if (isset($_POST["tipoMensPara"]))
		$tipoMensPara = $_POST["tipoMensPara"];
	else
		$tipoMensPara = "";
                
        if (isset($_POST["profcodi"]))
		$profcodi = $_POST["profcodi"];
	else
		$profcodi = "";
                
        if (isset($_POST["rowCount"]))
		$rowCount = $_POST["rowCount"];
	else
		$rowCount = "1";
        
        if (isset($_POST["opcion"]))
		$opcion = $_POST["opcion"];
	else
		$opcion = "";
                
        if (isset($_POST["menstitu"]))
		$menstitu = $_POST["menstitu"];
	else
		$menstitu = "";
                
        if (isset($_POST["mensdeta"]))
		$mensdeta = $_POST["mensdeta"];
	else
		$mensdeta = "";
                
        if (isset($_POST["menscodi"]))
		$menscodi = $_POST["menscodi"];
	else
		$menscodi = "";
        //Inicio Facturas  
        if (isset($_POST["estadoElectronico"]))
		$estadoElectronico = $_POST["estadoElectronico"];
	else
		$estadoElectronico = "AUTORIZADO";
                
        if (isset($_POST["fechaemision_ini"]))
		$fechaemision_ini = $_POST["fechaemision_ini"];
	else
		$fechaemision_ini = " ";
                
        if (isset($_POST["fechaemision_fin"]))
		$fechaemision_fin = $_POST["fechaemision_fin"];
	else
		$fechaemision_fin = " ";

        //Fin Facturas          
        if (isset($_POST["alumCursParaCodi"]))
		$alumCursParaCodi = $_POST["alumCursParaCodi"];
	else
		$alumCursParaCodi = "";
                
        if (isset($_POST["cursParaMateProfCodi"]))
		$cursParaMateProfCodi = $_POST["cursParaMateProfCodi"];
	else
		$cursParaMateProfCodi = "";
                
        if (isset($_POST["periDistCabTipo"]))
		$periDistCabTipo = $_POST["periDistCabTipo"];
	else
		$periDistCabTipo = "";
                
        if (isset($_POST["periEtapCodi"]))
		$periEtapCodi = $_POST["periEtapCodi"];
	else
		$periEtapCodi = "";
                
        if (isset($_POST["cursParaCodi"]))
		$cursParaCodi = $_POST["cursParaCodi"];
	else
		$cursParaCodi = "";
                
        if (isset($_POST["deudaCodigo"]))
		$deudaCodigo = $_POST["deudaCodigo"];
	else
		$deudaCodigo = ''; 
                               
         if (isset($_POST["deud_estado"]))
		$deud_estado = $_POST["deud_estado"];
	else
		$deud_estado = "";         
           
        if (isset($_POST["deuda"]))
		$deuda = $_POST["deuda"];
	else
		$deuda = "";        
                
        if (isset($_POST["authorizationCode"]))
		$authorizationCode = $_POST["authorizationCode"];
	else
		$authorizationCode = "";       
                
        if (isset($_POST["errorCode"]))
		$errorCode = $_POST["errorCode"];
	else
		$errorCode = "";       
                
        if (isset($_POST["errorMessage"]))
		$errorMessage = $_POST["errorMessage"];
	else
		$errorMessage = "";       
                
        if (isset($_POST["cardNumber"]))
		$cardNumber = $_POST["cardNumber"];
	else
		$cardNumber = "";       
                
                   
        if (isset($_POST["purchaseOperationNumber"]))
		$purchaseOperationNumber = $_POST["purchaseOperationNumber"];
	else
		$purchaseOperationNumber = "";      
                
        if (isset($_POST["purchaseAmount"]))
		$purchaseAmount = $_POST["purchaseAmount"];
	else
		$purchaseAmount = "";   
                
        if (isset($_POST["aten_codigo"]))
		$aten_codigo = $_POST["aten_codigo"];
	else
		$aten_codigo = "";   
             
        if (isset($_POST["tipo_observacion"]))
		$tipo_observacion = $_POST["tipo_observacion"];
	else
		$tipo_observacion = "";      
                
                
                
	$clientes = new Clientes();
	$clientes->getClientInfo($colegio);
        $clientes->getClients($opci_codi);
	
      
	$alumnos = new Alumnos();	
	$alumnos->user_db=$clientes->get_usuario();
	$alumnos->pass_db=$clientes->get_clave();
	$alumnos->host_db=$clientes->get_host();
	$alumnos->name_db=$clientes->get_dbname();
	
	$agenda = new Agenda();
	$agenda->user_db=$clientes->get_usuario();
	$agenda->pass_db=$clientes->get_clave();
	$agenda->host_db=$clientes->get_host();
	$agenda->name_db=$clientes->get_dbname();
        
        $notificaciones = new Notificaciones();
	$notificaciones->user_db=$clientes->get_usuario();
	$notificaciones->pass_db=$clientes->get_clave();
	$notificaciones->host_db=$clientes->get_host();
	$notificaciones->name_db=$clientes->get_dbname();
        
        $notiUpdate = new NotiUpdate();
	$notiUpdate->user_db=$clientes->get_usuario();
	$notiUpdate->pass_db=$clientes->get_clave();
	$notiUpdate->host_db=$clientes->get_host();
	$notiUpdate->name_db=$clientes->get_dbname();
        
        $notiAll= new Notificacionesall();
	$notiAll->user_db=$clientes->get_usuario();
	$notiAll->pass_db=$clientes->get_clave();
	$notiAll->host_db=$clientes->get_host();
	$notiAll->name_db=$clientes->get_dbname();
	
	
	$representantes = new Representante();
	$representantes->user_db=$clientes->get_usuario();
	$representantes->pass_db=$clientes->get_clave();
	$representantes->host_db=$clientes->get_host();
	$representantes->name_db=$clientes->get_dbname();
        
        $alumnosLogin = new Alumnoslogin();
	$alumnosLogin->user_db=$clientes->get_usuario();
	$alumnosLogin->pass_db=$clientes->get_clave();
	$alumnosLogin->host_db=$clientes->get_host();
	$alumnosLogin->name_db=$clientes->get_dbname();
        
        $mensajes = new mensajesAll();
	$mensajes->user_db=$clientes->get_usuario();
	$mensajes->pass_db=$clientes->get_clave();
	$mensajes->host_db=$clientes->get_host();
	$mensajes->name_db=$clientes->get_dbname();
        
        $profesores = new profesores();
	$profesores->user_db=$clientes->get_usuario();
	$profesores->pass_db=$clientes->get_clave();
	$profesores->host_db=$clientes->get_host();
	$profesores->name_db=$clientes->get_dbname();
        
        $mensajeNuevo = new mensajeNuevo();
	$mensajeNuevo->user_db=$clientes->get_usuario();
	$mensajeNuevo->pass_db=$clientes->get_clave();
	$mensajeNuevo->host_db=$clientes->get_host();
	$mensajeNuevo->name_db=$clientes->get_dbname();
        
	$mensajeEliminar = new mensajeEliminar();
	$mensajeEliminar->user_db=$clientes->get_usuario();
	$mensajeEliminar->pass_db=$clientes->get_clave();
	$mensajeEliminar->host_db=$clientes->get_host();
	$mensajeEliminar->name_db=$clientes->get_dbname();
        
        $mensajeUpdate = new mensajeUpdate();
	$mensajeUpdate->user_db=$clientes->get_usuario();
	$mensajeUpdate->pass_db=$clientes->get_clave();
	$mensajeUpdate->host_db=$clientes->get_host();
	$mensajeUpdate->name_db=$clientes->get_dbname();
        
        $facturasAutorizadas = new facturasAutorizadas();
	$facturasAutorizadas->user_db=$clientes->get_usuario();
	$facturasAutorizadas->pass_db=$clientes->get_clave();
	$facturasAutorizadas->host_db=$clientes->get_host();
	$facturasAutorizadas->name_db=$clientes->get_dbname();
        
        $Clases = new Clases();
	$Clases->user_db=$clientes->get_usuario();
	$Clases->pass_db=$clientes->get_clave();
	$Clases->host_db=$clientes->get_host();
	$Clases->name_db=$clientes->get_dbname();
        
        $Materiales = new Materiales();
	$Materiales->user_db=$clientes->get_usuario();
	$Materiales->pass_db=$clientes->get_clave();
	$Materiales->host_db=$clientes->get_host();
	$Materiales->name_db=$clientes->get_dbname();
        
        $Etapas = new Etapas();
	$Etapas->user_db=$clientes->get_usuario();
	$Etapas->pass_db=$clientes->get_clave();
	$Etapas->host_db=$clientes->get_host();
	$Etapas->name_db=$clientes->get_dbname();
        
        $NotificacionesAlumnos = new NotificacionesAlumnos();
        $NotificacionesAlumnos->user_db=$clientes->get_usuario();
	$NotificacionesAlumnos->pass_db=$clientes->get_clave();
	$NotificacionesAlumnos->host_db=$clientes->get_host();
	$NotificacionesAlumnos->name_db=$clientes->get_dbname();
        
        $NotiUpdateAlumnos = new NotiUpdateAlumnos();
        $NotiUpdateAlumnos->user_db=$clientes->get_usuario();
	$NotiUpdateAlumnos->pass_db=$clientes->get_clave();
	$NotiUpdateAlumnos->host_db=$clientes->get_host();
	$NotiUpdateAlumnos->name_db=$clientes->get_dbname();
        
        $appUpdateAlum = new appUpdateAlum();
	$appUpdateAlum->user_db=$clientes->get_usuario();
	$appUpdateAlum->pass_db=$clientes->get_clave();
	$appUpdateAlum->host_db=$clientes->get_host();
	$appUpdateAlum->name_db=$clientes->get_dbname();
        
        $appUpdateRepr = new appUpdateRepr();
	$appUpdateRepr->user_db=$clientes->get_usuario();
	$appUpdateRepr->pass_db=$clientes->get_clave();
	$appUpdateRepr->host_db=$clientes->get_host();
	$appUpdateRepr->name_db=$clientes->get_dbname();
        
        $BotonPagoLista = new BotonPagoLista();
	$BotonPagoLista->user_db=$clientes->get_usuario();
	$BotonPagoLista->pass_db=$clientes->get_clave();
	$BotonPagoLista->host_db=$clientes->get_host();
	$BotonPagoLista->name_db=$clientes->get_dbname();
        
        
        $AlumnosBloqueo = new AlumnosBloqueo();
	$AlumnosBloqueo->user_db=$clientes->get_usuario();
	$AlumnosBloqueo->pass_db=$clientes->get_clave();
	$AlumnosBloqueo->host_db=$clientes->get_host();
	$AlumnosBloqueo->name_db=$clientes->get_dbname();
        
        $AlumnosBloqueo2 = new AlumnosBloqueo2();
	$AlumnosBloqueo2->user_db=$clientes->get_usuario();
	$AlumnosBloqueo2->pass_db=$clientes->get_clave();
	$AlumnosBloqueo2->host_db=$clientes->get_host();
	$AlumnosBloqueo2->name_db=$clientes->get_dbname();
        
        $DeudasVencidas = new DeudasVencidas();
	$DeudasVencidas->user_db=$clientes->get_usuario();
	$DeudasVencidas->pass_db=$clientes->get_clave();
	$DeudasVencidas->host_db=$clientes->get_host();
	$DeudasVencidas->name_db=$clientes->get_dbname();
        
        $PagosRealizados = new PagosRealizados();
	$PagosRealizados->user_db=$clientes->get_usuario();
	$PagosRealizados->pass_db=$clientes->get_clave();
	$PagosRealizados->host_db=$clientes->get_host();
	$PagosRealizados->name_db=$clientes->get_dbname();
        
        $BotonPagoDeuda = new BotonPagoDeuda();
	$BotonPagoDeuda->user_db=$clientes->get_usuario();
	$BotonPagoDeuda->pass_db=$clientes->get_clave();
	$BotonPagoDeuda->host_db=$clientes->get_host();
	$BotonPagoDeuda->name_db=$clientes->get_dbname();
        
        $actualizaBotonPago = new actualizaBotonPago();
	$actualizaBotonPago->user_db=$clientes->get_usuario();
	$actualizaBotonPago->pass_db=$clientes->get_clave();
	$actualizaBotonPago->host_db=$clientes->get_host();
	$actualizaBotonPago->name_db=$clientes->get_dbname();
    
        $VisitasMedicas = new VisitasMedicas();
        $VisitasMedicas->user_db=$clientes->get_usuario();
        $VisitasMedicas->pass_db=$clientes->get_clave();
        $VisitasMedicas->host_db=$clientes->get_host();
        $VisitasMedicas->name_db=$clientes->get_dbname();

        $detalleVisitasMedicas = new detalleVisitasMedicas();
        $detalleVisitasMedicas->user_db=$clientes->get_usuario();
        $detalleVisitasMedicas->pass_db=$clientes->get_clave();
        $detalleVisitasMedicas->host_db=$clientes->get_host();
        $detalleVisitasMedicas->name_db=$clientes->get_dbname();

        $tipoObservacion = new tipoObservacion();
        $tipoObservacion->user_db=$clientes->get_usuario();
        $tipoObservacion->pass_db=$clientes->get_clave();
        $tipoObservacion->host_db=$clientes->get_host();
        $tipoObservacion->name_db=$clientes->get_dbname();
        
        
        $observacionesPorTipo = new observacionesPorTipo();
        $observacionesPorTipo->user_db=$clientes->get_usuario();
        $observacionesPorTipo->pass_db=$clientes->get_clave();
        $observacionesPorTipo->host_db=$clientes->get_host();
        $observacionesPorTipo->name_db=$clientes->get_dbname();
        
	switch ($opcion)
	{
		case "login_representante":
			$representantes->Login ($username, $password,$tipo_usua);
			echo json_encode($representantes->resultado);
		break;
                case "login_Alumnos":
			$alumnosLogin->Login ($username, $password,$tipo_usua);
			echo json_encode($alumnosLogin->resultado);
		break;
		case "listar_clientes":
			
			$clientes->getClients($opci_codi);
			$json_colegios = array();
			foreach($clientes->rows as $cliente){
				$json_clientes[] = array("id"=>$cliente['clie_codi'],"texto"=>$cliente['clie_nomb'],"carpeta"=>$cliente['clie_carpeta']);
			}
			$array_users = array ("result"=>$json_clientes);
			echo json_encode($array_users);
		break;
		case "listar_alumnos":	
			$alumnos->getAlumnosRepr($reprcodi,$pericodi);		
			$json_alumnos = array();
			foreach($alumnos->rows as $alumno){
				$json_alumnos[] = array("codigo"=>$alumno['alum_codi'],"nombre"=>$alumno['alum_nomb'],"apellido"=>$alumno['alum_apel'],"periodo"=>$alumno['peri_codi'],"alumCursCodi"=>$alumno['alum_curs_para_codi'],"cursCodi"=>$alumno['curs_para_codi'],"curso"=>$alumno['curs_deta'],"paralelo"=>$alumno['para_deta'],"distipo"=>$alumno['peri_dist_cab_tipo'],"repr_app"=>$alumno['repr_app']);

			}
			$array_alumnos = array ("result"=>$json_alumnos);
			echo json_encode($array_alumnos);
		break;
		case "mostrar_agenda":	
			$agenda->getAgenda($alumnocodi,$pericodi);	
			$json_agenda = array();
			foreach($agenda->rows as $agendaAlum){
				$json_agenda[] = array("codigoAgenda"=>$agendaAlum['agen_codi'],"tituloAgenda"=>$agendaAlum['agen_titu'],"detalleAgenda"=>$agendaAlum['agen_deta'],"fechaIniAgenda"=>$agendaAlum['agen_fech_ini'],"fechaFinAgenda"=>$agendaAlum['agen_fech_fin'],"estadoAgenda"=>$agendaAlum['agen_esta'],"profcodi"=>$agendaAlum['prof_codi'],"detalleMateria"=>$agendaAlum['mate_deta'],"nombreProfesor"=>$agendaAlum['prof_nomb']);
			}
			$array_agenda = array ("result"=>$json_agenda);
			echo json_encode($array_agenda);
		break;
                case "mostrar_notificaciones":	
			$notificaciones->getNotificaciones($username,$tipo_usua);		
			$json_noti = array();
			foreach($notificaciones->rows as $notiall){
				$json_noti[] = array("noticodi"=>$notiall['noti_codi'],"notiDetaEsta"=>$notiall['noti_deta_esta'],"fechaRegistro"=>$notiall['noti_deta_fech_regi'],"fechaLectura"=>$notiall['noti_deta_fech_lect']);
			}
			$array_noti = array ("result"=>$json_noti);
			echo json_encode($array_noti);
		break;
                case "notificaciones_update":	
			$notiUpdate->updateNoti($username,$tipo_usua);			
			echo json_encode($notiUpdate->resultado);
		break;
                case "notificaciones_all":	
			$notiAll->getNotificacionesAll($username,$tipo_usua);		
			$json_notiall = array();
			foreach($notiAll->rows as $notiallAL){
				$json_notiall[] = array("noti_deta_fech_regi"=>$notiallAL['noti_deta_fech_regi'],"noti_deta_esta"=>$notiallAL['noti_deta_esta'],"noti_tipo_deta"=>$notiallAL['noti_tipo_deta'],"noti_deta"=>$notiallAL['noti_deta'],"noti_deta_codi"=>$notiallAL['noti_deta_codi']);
			}
			$array_notiall = array ("result"=>$json_notiall);
			echo json_encode($array_notiall);
		break;
                case "mensajes_all":	
			$mensajes->getMensajes($op,$reprcodi,$tipoMens,$rowCount);		
			$json_mensall = array();
			foreach($mensajes->rows as $mensajesTodo){
				$json_mensall[] = array("mensajeNombEmisor"=>$mensajesTodo['mens_nomb'],"mensajesNombEmisorElimin"=>$mensajesTodo['mens_de_nomb'],"codigoDe"=>$mensajesTodo['mens_de'],"codigoPara"=>$mensajesTodo['mens_para'],"mensajeTipoEmisor"=>$mensajesTodo['mens_usua_tipo_deta'],"mensajeTitulo"=>$mensajesTodo['mens_titu'],"mensajeDetalle"=>$mensajesTodo['mens_deta'],"mensajeFechaEnvio"=>$mensajesTodo['mens_fech_envi'],"mensajeFechaLect"=>$mensajesTodo['mens_fech_lect'],"mensajeCodigo"=>$mensajesTodo['mens_codi']);
			}
			$array_mensall = array ("result"=>$json_mensall);
			echo json_encode($array_mensall);
		break;
                case "profesores_lista":	
			$profesores->getListaProfesores($alumnocodi,$pericodi);		
			$json_profall = array();
			foreach($profesores->rows as $profesoresTodo){
				$json_profall[] = array("profcodi"=>$profesoresTodo['prof_codi'],"nombreProfesor"=>$profesoresTodo['prof_nombre'],"materia"=>$profesoresTodo['Materia']);
			}
			$array_profall = array ("result"=>$json_profall);
			echo json_encode($array_profall);
		break;
                case "add_message":	
			$mensajeNuevo->addMessage($reprcodi,$tipoMens,$profcodi,$tipoMensPara,$menstitu,$mensdeta,$alumnocodi);			
			echo json_encode($mensajeNuevo->resultado);
		break;
                case "erase_message":	
			$mensajeEliminar->eraseMessage($menscodi);			
			echo json_encode($mensajeEliminar->resultado);
		break;
                case "update_message":	
			$mensajeUpdate->mensajeLeido($menscodi);			
			echo json_encode($mensajeUpdate->resultado);
		break;
                case "facturas_Autorizadas":	
			$facturasAutorizadas->Facturas($estadoElectronico, $fechaemision_ini,$fechaemision_fin, $reprcodi, $username, NULL,NULL,NULL,NULL,NULL,NULL,'');	
			$json_facturasall = array();
			foreach($facturasAutorizadas->rows as $facturasTodo){
				$json_facturasall[] = array("codigoFactura"=>$facturasTodo['codigoFactura'],"totalNetoFactura"=>$facturasTodo['totalNetoFactura'],"nombresAlumno"=>$facturasTodo['nombresAlumno'],"codigoAlumno"=>$facturasTodo['codigoAlumno'],"fechaEmision"=>$facturasTodo['fechaEmision'],"estadoElectronico"=>$facturasTodo['estadoElectronico'],"prefijoSucursal"=>$facturasTodo['prefijoSucursal'],"prefijoPuntoVenta"=>$facturasTodo['prefijoPuntoVenta'],"numeroFactura"=>$facturasTodo['numeroFactura']);
			}
			$array_facturasall = array ("result"=>$json_facturasall);
			echo json_encode($array_facturasall);
		break;
                case "materiales":	
			$Materiales->getMateriales($cursParaMateProfCodi);	
			$json_materialesall = array();
			foreach($Materiales->rows as $materialesTodo){
				$json_materialesall[] = array("mater_codi"=>$materialesTodo['mater_codi'],"mater_titu"=>$materialesTodo['mater_titu'],"mater_deta"=>$materialesTodo['mater_deta'],"mater_fech_regi"=>$materialesTodo['mater_fech_regi'],"mater_file"=>$materialesTodo['mater_file']);
			}
			$array_materialesall = array ("result"=>$json_materialesall);
			echo json_encode($array_materialesall);
		break;
                case "clases_materias":	
			$Clases->getMaterias($alumCursParaCodi);	
			$json_materiasall = array();
			foreach($Clases->rows as $materiasTodo){
				$json_materiasall[] = array("alumCursParaMateCodi"=>$materiasTodo['alum_curs_para_mate_codi'],"cursParaMateCodi"=>$materiasTodo['curs_para_mate_codi'],"cursParaMateProfCodi"=>$materiasTodo['curs_para_mate_prof_codi'],"materiaCodi"=>$materiasTodo['mate_codi'],"materiaDetalle"=>$materiasTodo['mate_deta'],"profNombre"=>$materiasTodo['prof_nomb'],"profApellido"=>$materiasTodo['prof_apel'],"materCount"=>$materiasTodo['mater_count']);
			}
			$array_materiasall = array ("result"=>$json_materiasall);
			echo json_encode($array_materiasall);
		break;
                    case "obtener_Etapas":
			$Etapas->getEtapas($pericodi,$periDistCabTipo,$periEtapCodi);
                        $json_etapas = array();
			foreach($Etapas->rows as $etapasTodo){
				$json_etapas[] = array("peridistcodi"=>$etapasTodo['peri_dist_codi'],"peridistdeta"=>$etapasTodo['peri_dist_deta'],"peridistdetapadr"=>$etapasTodo['peri_dist_deta_padr']);
                                }
			$array_etapas = array ("result"=>$json_etapas);
			echo json_encode($array_etapas);
		break;
                case "notificaciones_update_alum":	
			$NotiUpdateAlumnos->updateNotiAlum($alumnocodi,$tipo_usua);			
			echo json_encode($NotiUpdateAlumnos->resultado);
		break;
                case "notificaciones_alumnos":	
			$NotificacionesAlumnos->getNotificacionesAlumnos($alumnocodi,$tipo_usua);		
			$json_notiallA = array();
			foreach($NotificacionesAlumnos->rows as $notiallALA){
				$json_notiallA[] = array("noti_deta_fech_regi"=>$notiallALA['noti_deta_fech_regi'],"noti_deta_esta"=>$notiallALA['noti_deta_esta'],"noti_tipo_deta"=>$notiallALA['noti_tipo_deta'],"noti_deta"=>$notiallALA['noti_deta'],"noti_deta_codi"=>$notiallALA['noti_deta_codi']);
			}
			$array_notiallA = array ("result"=>$json_notiallA);
			echo json_encode($array_notiallA);
		break;
                case "update_app_repr":	
			$appUpdateRepr->verificarAppRepr($reprcodi);			
			echo json_encode($appUpdateRepr->resultado);
		break;
                case "update_app_alum":	
			$appUpdateAlum->verificarAppAlum($alumnocodi);			
			echo json_encode($appUpdateAlum->resultado);
		break;
                
                case "boton_pagos_lista":
			$BotonPagoLista->getBotonPagosLista($alumnocodi,$deud_estado);
                        $json_pagos = array();
			foreach($BotonPagoLista->rows as $Lista){
				$json_pagos[] = array("numeroFactura"=>$Lista['numeroFactura'],"codigoDeuda"=>$Lista['codigoDeuda'],"descripcionDeuda"=>$Lista['descripcionDeuda'],"periodo"=>$Lista['periodo'],"totalInicial"=>$Lista['totalInicial'],"totalNotaCredito"=>$Lista['totalNotaCredito'],"totalAbonado"=>$Lista['totalAbonado'],"fechaVencimiento"=>$Lista['fechaVencimiento'],"estado"=>$Lista['estado'],"totalPendiente"=>$Lista['totalPendiente']);
                                }
			$array_pagos = array ("result"=>$json_pagos);
			echo json_encode($array_pagos);
		break;
                
                case "bloqueo_alumnos":
			$AlumnosBloqueo->alumno_bloqueo($alumnocodi,$cursParaCodi);
                        $json_bloqueos = array();
			foreach($AlumnosBloqueo->rows as $Lista){
				$json_bloqueos[] = array("alum_tiene_deuda"=>$Lista['alum_tiene_deuda']);
                                }
			$array_bloqueos = array ("result"=>$json_bloqueos);
			echo json_encode($array_bloqueos);
		break;
                
                case "bloqueo_alumnos2":
			$AlumnosBloqueo2->alumno_bloqueo2($alumnocodi,$pericodi);
                        $json_bloqueos2 = array();
			foreach($AlumnosBloqueo2->rows as $Lista2){
				$json_bloqueos2[] = array("tiene_deuda"=>$Lista2['tiene_deuda']);
                                }
			$array_bloqueos2 = array ("result"=>$json_bloqueos2);
			echo json_encode($array_bloqueos2);
		break;
                
                case "deudas_pendientes":
			$DeudasVencidas->deudasPendVencidas($deudaCodigo);
                        $json_pendientes = array();
			foreach($DeudasVencidas->rows as $ListaPend){
				$json_pendientes[] = array("descripcionDeuda"=>$ListaPend['descripcionDeuda'],"deud_totalPendiente"=>$ListaPend['deud_totalPendiente'],"deud_codigo"=>$ListaPend['deud_codigo']);
                                }
			$array_pendientes = array ("result"=>$json_pendientes);
			echo json_encode($array_pendientes);
		break;
                
                case "pagos_realizados":
			$PagosRealizados->getPagosRealizados("","","","","","","","","","","","","","","",0,0,"","","","","",$deuda);
                        $json_pagosrealizados = array();
			foreach($PagosRealizados->rows as $ListaPagRealizados){
				$json_pagosrealizados[] = array("totalPago"=>$ListaPagRealizados['totalPago'],"formaPago"=>$ListaPagRealizados['formaPago'],"codigoPago"=>$ListaPagRealizados['codigoPago']);
                                }
			$array_pagosRealizados = array ("result"=>$json_pagosrealizados);
			echo json_encode($array_pagosRealizados);
		break;               


                case "boton_pagos_deudas":			
                        $noSale = $BotonPagoDeuda->getBotonPagoDeuda($alumnocodi,$reprcodi,$deudaCodigo);                        
                        $json_pagosDeudas = array();
			foreach($noSale->rows as $ListaPagosDeudas){
				$json_pagosDeudas[] = array("deud_codigo"=>$ListaPagosDeudas['deud_codigo'],
                                                            "pon_code"=>$ListaPagosDeudas['pon_code'],
                                                            "prod_nombre"=>$ListaPagosDeudas['prod_nombre'],
                                                            "deud_totalPendiente"=>$ListaPagosDeudas['deud_totalPendiente'],
                                                            "repr_nomb"=>$ListaPagosDeudas['repr_nomb'],
                                                            "repr_apel"=>$ListaPagosDeudas['repr_apel'],
                                                            "repr_email"=>$ListaPagosDeudas['repr_email'],
                                                            "repr_telf"=>$ListaPagosDeudas['repr_telf'],
                                                            "repr_domi"=>$ListaPagosDeudas['repr_domi']);
                                }
			$array_pagosDeudas = array ("result"=>$json_pagosDeudas);
			echo json_encode($array_pagosDeudas);
		break;
                
                case "actualiza_boton_pago":
                        $actualizaBotonPago->getActualizaBotonPago($authorizationCode,"",$errorCode,$errorMessage,$cardNumber,"",$purchaseOperationNumber,$purchaseAmount,""); 
                        $json_actualizaPago = array();
			foreach($actualizaBotonPago->rows as $ListaActualizaPago){
				$json_actualizaPago[] = array("repr_nomb"=>$ListaActualizaPago['repr_nomb'],
                                                            "repr_apel"=>$ListaActualizaPago['repr_apel'],
                                                            "repr_codi"=>$ListaActualizaPago['repr_codi'],
                                                            "pagos"=>$ListaActualizaPago['pagos']);
                                }
			$array_actualizaPago = array ("result"=>$json_actualizaPago);
			echo json_encode($array_actualizaPago);
		break;
                               
                case "mostrar_visitasMedicas":	
			$VisitasMedicas->getVisitasMedicas($alumnocodi);	
			$json_visitas = array();
			foreach($VisitasMedicas->rows as $visitasMedicas){
				$json_visitas[] = array("enfe_descripcion"=>$visitasMedicas['enfe_descripcion'],"aten_fechaCreacion"=>$visitasMedicas['aten_fechaCreacion'],"aten_codigo"=>$visitasMedicas['aten_codigo']);
			}
			$array_visitas = array ("result"=>$json_visitas);
			echo json_encode($array_visitas);
		break;
                
                case "detalle_visitasMedicas":	
			$detalleVisitasMedicas->getDetalleVisitasMedicas($aten_codigo);	
			$json_detalleVisitas = array();
			foreach($detalleVisitasMedicas->rows as $detalleVisitas){
				$json_detalleVisitas[] = array("aten_deta_med_cantidad"=>$detalleVisitas['aten_deta_med_cantidad'],"med_descripcion"=>$detalleVisitas['med_descripcion']);
			}
			$array_detalleVisitas = array ("result"=>$json_detalleVisitas);
			echo json_encode($array_detalleVisitas);
		break;
        
                case "tipo_Observaciones":
			$tipoObservacion->getTipoObservaciones();
			$json_observaciones = array();
			foreach($tipoObservacion->rows as $observaciones){
				$json_observaciones[] = array("obse_tipo_codi"=>$observaciones['obse_tipo_codi'],"obse_tipo_deta"=>$observaciones['obse_tipo_deta']);
			}
			$array_obs = array ("result"=>$json_observaciones);
			echo json_encode($array_obs);
		break;
                
                 case "Observaciones_por_Tipo":
			$observacionesPorTipo->getObservacionesPorTipo($pericodi,$alumnocodi,$tipo_observacion);
			$json_observacionesPorTipo = array();
			foreach($observacionesPorTipo->rows as $observacionesPorTipo){
				$json_observacionesPorTipo[] = array("obse_codi"=>$observacionesPorTipo['obse_codi'],"obse_deta"=>$observacionesPorTipo['obse_deta'],"obse_fech"=>$observacionesPorTipo['obse_fech'],"obse_tipo_deta"=>$observacionesPorTipo['obse_tipo_deta'],"usua_deta"=>$observacionesPorTipo['usua_deta'],"usua_tipo"=>$observacionesPorTipo['usua_tipo']);
			}
			$array_obsPorTipo = array ("result"=>$json_observacionesPorTipo);
			echo json_encode($array_obsPorTipo);
		break;
	}
?>
