<?php
# Importar modelo de abstracción de base de datos
session_start();
require_once('../../../core/db_abstract_model.php');

class General extends DBAbstractModel{
    #propiedades
    public $usua_nombres;
    public $usua_apellidos;
    public $usua_correoElectronico;
    protected $usua_codigo;
    public $usua_estado;
    public $usua_codigoRol;
    public $usua_fechaNacimiento;
    public $login_mensaje;
    public $puntVent_codigo;
	public $permiso;
	public $veri;
	public $caja_codi;
	public $caja_fecha;
	public $prontopago;
   
    #metodos
    /*
     * Consulta un usuario especifico
     * @param string Correo Electronico del usuario
     * @access public
     */
    public function login($codigo="",$clave="")
	{	if($codigo!="")
		{	$this->parametros = array($codigo,$clave);
            $this->sp = "str_consultaMain_logi_finan";
            $this->executeSPConsulta();
        }
        if (count($this->rows)>1)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
            //$this->mensaje="OK";
        }
		else
		{	//$this->mensaje=$this->login_mensaje;
        }
    }
	public function getDatosInstitucion_info(){
        $this->parametros = array();
        $this->sp = "str_consultaDatosInstitucion_info";
        $this->executeSPConsulta();
        if (count($this->rows)>0){
            $this->mensaje="¡Exito! Datos de la institución encontrados.";
        }else{
            $this->mensaje="¡Exito! Datos no encontrados.";
        }
    }
	public function apertura_caja($codigo="")
	{	$this->parametros = array($codigo);
		$this->sp = "str_consultaCajaCierre_open";
		$this->executeSPConsulta();
		if (count($this->rows)>1)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
            //$this->mensaje="OK";
        }
		else
		{	//$this->mensaje=$this->login_mensaje;
        }
	}
	
	public function get_datos_home(){
        $this->parametros = array();
        $this->sp = "str_consulta_finan_main";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $home){
                array_push($tmp, array_values($home));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="¡Error! Datos no encontrados";
        }
    }
	public function get_datos_home_deudas_minitabla(){
        $this->parametros = array();
        $this->sp = "str_consulta_finan_main_producto";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $tmp = array();
            foreach($this->rows as $home){
                array_push($tmp, array_values($home));
            }

            $this->rows = $tmp;
            unset($tmp);
        }else{
            $this->mensaje="¡Error! Datos no encontrados";
        }
    }
    public function get_all_cursos($busq="")
    {	$this->parametros = array($busq);
        $this->sp = "str_consultaCursosrpt_cons";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione curso -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione curso -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get_all_cursos_by_econ_level($busq="",$niveles="")
    { 
        $this->parametros = array($busq,$niveles);
        $this->sp = "str_consultaCursosPorNivelrpt_cons";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione curso -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione curso -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get_all_niveles_economicos($periodo=0)
    {	$this->parametros = array();
        $this->sp = "str_consultaNivelEconomico_cons";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="No existen niveles economicos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione nivel -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
        }
		else
		{	$rol = array();

            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione nivel -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
            foreach($this->rows as $niveles_economicos)
			{	array_push($rol, array_values($niveles_economicos));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
    public function get_all_alumnos($busq="")
    {	$this->parametros = array($busq);
        $this->sp = "str_consultaAlumnosrpt_cons";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione alumno -',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione alumno -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_all_financial_users($rol_final = 0, $rol_deta = '&', $rol_estado = 'A')
	{	$this->parametros = array($rol_finan, $rol_deta, $rol_estado);
        $this->sp = "str_consulta_usuarios_financieros";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen usuarios financieros en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione usuario -',
                                   3 => '')
								);
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione usuario -',
                                   3 => ''));
			array_push($rol, array(0 => 0, 
                                   1 => 'Todos',
                                   3 => ''));
            foreach($this->rows as $usuarios)
			{	array_push($rol, array( 0 => $usuarios['usua_codi'], 
										1 => $this->PrimeraMayuscula($usuarios['nombre'])));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_all_periodos()
	{	$this->parametros = array();
        $this->sp = "str_consultaPeriodos";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione período -',
                                   3 => '')
								);
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => -1, 
                                   1 => '- Seleccione período -',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_all_productos( $peri_codi = -1, $producto = '' )
	{	if( ( $peri_codi == NULL ) || ( $peri_codi == "" ) ) 
			$peri_codi = -1;
		$this->parametros = array( $peri_codi, $producto );
        $this->sp = "str_consultaProductorpt_cons";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen productos en la BD.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
			array_pop($producto);
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_resumen($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T' )
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudoresresumen";
        $this->executeSPConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_mensual($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudoresmensual";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_mensual_detalle($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudoresmensual_detalle";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_curso($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudorescurso";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores_persona($curs_codi=-1, $niveEcon_codi=-1, $peri_codi=-1, $fechvenc_ini='', $fechvenc_fin='', $quienes='T')
	{	if ( $curs_codi == 0 || $curs_codi == '' )
			$curs_codi = -1;
		if ( $niveEcon_codi == 0 || $niveEcon_codi == '' )
			$niveEcon_codi = -1;
		if ( $peri_codi == 0 || $peri_codi == '' )
			$peri_codi = -1;
		
		$this->parametros = array($curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes);
        $this->sp = "str_consultarpt_deudorespersona";
        $this->executeSPConsulta();

        if (count($this->rows)<=0)
		{	$this->mensaje="Error al obtener datos.";
        }
		else
		{	$producto = array();
            foreach($this->rows as $productos)
			{	array_push($producto, array_values($productos));
            }
            $this->rows = $producto;
            unset($producto);
        }
    }
	public function get_all_deudores( 	$curs_codi=0, 		$niveEcon_codi=0, $peri_codi=0, 
										$fechvenc_ini='', 	$fechvenc_fin='', $quienes='', 
										$prod_codigo='' )
	{	$this->parametros = array( $curs_codi, $niveEcon_codi, $peri_codi, $fechvenc_ini, $fechvenc_fin, $quienes, $prod_codigo );
        $this->sp = "str_consultareptDeudores_busq";
        $this->executeSPConsulta();
		if (count($this->rows)>0)
		{	//array_pop($permiso);
			foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
			}
			$this->mensaje="Datos obtenidos correctamente.";
		}
		else
		{	$this->mensaje="Error al obtener datos.";
		}
    }
	
	public function get_clientes($filtros=array())
	{	if (array_key_exists('nombres',$filtros))
		{	$this->parametros = array('nombres',$filtros['nombres']); 
        }
		else
		{	$this->parametros = array('numeroIdentificacion',$filtros['numeroIdentificacion']); 
        }
        $this->sp = "str_consultaClienteParaCobro";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{	$this->mensaje="Clientes encontrados";
        }
		else
		{	$this->mensaje="Clientes no encontrados";
        }
    }
	public function permisos_generales($rol="")
	{	$this->parametros = array($rol);
		$this->sp = "str_consultaPermisosRoles";
		$this->executeSPConsulta();
		if (count($this->rows)>1)
		{	$permiso = array();
            foreach($this->rows as $permisos)
			{	array_push($permiso, array_values($permisos));
            }
            // Agregar la opcion de ninguna categoria padre
            array_pop($permiso);
            array_push($permiso, array());

            $this->rows = $permiso;
            unset($permiso);
        }
		else
		{	//$this->mensaje=$this->login_mensaje;
        }
			$this->permiso=$this->rows;
	}
    public function login_error($codigo="",$ip_access="")
	{	$this->parametros = array($codigo,$ip_access);
        $this->sp = "str_consultaLogErr_add";
        $this->executeSPConsulta();
        if (count($this->rows)>1)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
            $this->mensaje=$this->login_mensaje;
        }
		else
		{	$this->mensaje="Error al mostrar mensaje de inicio de sesión.";
        }
    }
    public function login_success($codigo="")
	{   $this->parametros = array($codigo);
        $this->sp = "str_consultaLogScs_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
    }
    public function change_pass($pass_old="",$pass_new="",$usua_codigo="")
	{	$this->parametros = array($pass_old,$pass_new,$usua_codigo);        
        $this->sp = "str_consultaUsuario_pass_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="Su contraseña ha sido cambiada.";
        }
		else
		{	$this->mensaje="Ocurrió un problema con el cambio de contraseña";
        }
    }
	public function change_settings($usa_pp_dv = "", $prontopago = "", $iva = "", $enviar_fac_sri_en_cobro = "", $enviar_cheque_a_bandeja="", $rb_forma_aplica_descuento='desc_sobre', $bloqueo = "", 
									$apikey = "", $apikeytoken = "", $gdm = "", $bmpd = "", $bgmpm = "", $bbppp = "", $usua_codigo = "" )
	{	$this->parametros = array( $usa_pp_dv, $prontopago, $iva, $enviar_fac_sri_en_cobro, $enviar_cheque_a_bandeja, $rb_forma_aplica_descuento, $bloqueo, $apikey, $apikeytoken, $gdm, $bmpd, $bgmpm, $bbppp, $usua_codigo );
        $this->sp = "str_consultaProntopago_upd";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="¡Exito! Su configuración ha sido cambiada.";
        }
		else
		{	$this->mensaje="¡Error! Ocurrió un problema con el cambio de la configuración";
        }
    }
	public function get_prontopago()
	{   $this->parametros = array();
        $this->sp = "str_consultaProntopago_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
        }
		else
		{	$this->mensaje="KO";
        }
    }
	public function get_pagoweb_config()
	{   $this->parametros = array();
        $this->sp = "str_consultaPtoVenta_web";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
        }
		else
		{	$this->mensaje="KO";
        }
    }
	public function set_pagoweb_config( $active_web = "N", $puntVent_prefijo='001', $puntVent_codigoSucursal, $puntVent_secuencia = '1' )
	{	if ( $puntVent_prefijo == '' )
			$puntVent_prefijo = '001';
		if ( $puntVent_secuencia == '' )
			$puntVent_secuencia = '1';
		
		$this->parametros = array( $active_web, $puntVent_prefijo, $puntVent_codigoSucursal, $puntVent_secuencia ); 
        $this->sp = "str_consultaPtoVenta_web_add";
        $this->executeSPAccion();
        if($this->filasAfectadas>0)
		{	$this->mensaje="¡Exito! Su configuración ha sido cambiada.";
        }
		else
		{	$this->mensaje="¡Error! Ocurrió un problema con el cambio de la configuración";
        }
    }
    public function permiso_activo($usua_codi="",$perm_codi=0)
	{   $this->parametros = array($usua_codi, $perm_codi);
        $this->sp = "usua_permi_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[0] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
			$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
    }
	public function para_sist($para_sist_codi)
	{	$this->parametros = array($para_sist_codi);
        $this->sp = "para_sist_info";
        $this->executeSPConsulta();
        if(count($this->rows)>0)
		{	foreach($this->rows[1] as $propiedad=>$valor)
			{	$this->$propiedad=$valor;
            }
			$this->mensaje="OK";
        }
		else
		{	$this->mensaje="KO";
        }
		//return $this->$propiedad;
	}
	public function getapikey(){
        $this->parametros = array();
        $this->sp = "str_consultapikey";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje=1;
        }else{
            $this->mensaje=0;
        }
	}
	public function get_fecha_head_reportes()
	{	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fecha_det='Guayaquil, '.$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y'). '.';
		return $fecha_det;
	}
	public function pasarMayusculas($cadena)
	{   $cadena = str_replace("ñ", "Ñ", $cadena); 
		$cadena = str_replace("á", "Á", $cadena); 
		$cadena = str_replace("é", "É", $cadena); 
		$cadena = str_replace("í", "Í", $cadena); 
		$cadena = str_replace("ó", "Ó", $cadena); 
		$cadena = str_replace("ú", "Ú", $cadena); 
		return ($cadena); 
	}	
	public function pasarMinusculas($cadena)
	{   $cadena = str_replace("Ñ", "ñ", $cadena); 
		$cadena = str_replace("Á", "á", $cadena); 
		$cadena = str_replace("É", "é", $cadena); 
		$cadena = str_replace("Í", "í", $cadena); 
		$cadena = str_replace("Ó", "ó", $cadena); 
		$cadena = str_replace("Ú", "ú", $cadena); 
		return ($cadena); 
	}
	public function validarTildeHTML($cadena)
	{   $cadena = str_replace("Ñ", "&Ntilde;", $cadena);
		$cadena = str_replace("Á", "&Aacute;", $cadena);
		$cadena = str_replace("É", "&Eacute;", $cadena);
		$cadena = str_replace("Í", "&Iacute;", $cadena);
		$cadena = str_replace("Ó", "&Oacute;", $cadena);
		$cadena = str_replace("Ú", "&Uacute;", $cadena);
		$cadena = str_replace("ñ", "&ntilde;", $cadena); 
		$cadena = str_replace("á", "&Aacute;", $cadena);
		$cadena = str_replace("é", "&Eacute;", $cadena);
		$cadena = str_replace("í", "&Iacute;", $cadena);
		$cadena = str_replace("ó", "&Oacute;", $cadena);
		$cadena = str_replace("ú", "&Uacute;", $cadena); 
		return ($cadena); 
	}
	public function PrimeraMayuscula($string)
	{	$string = ucwords($this->pasarMinusculas($string));
		foreach (array('-', '\'') as $delimiter)
		{	if (strpos($string, $delimiter)!==false)
			{	$string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
			}
		}
		return $string;
	}
    # Método constructor
    function __construct() {
        //$this->db_name = 'URBALINKS_FINAN';
    }

    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
require_once('../../../includes/common/tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{	
	public function Header() 
	{	/*$logo_minis = '../'.$_SESSION['ruta_foto_logo_index'];
		$this->Image($logo_minis, 12, 5, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

		if ($this->page == 1) {
		$this->SetFont('helvetica', '', 6);
		$this->Cell(0,10,'Código: R13-08 Versión: 4 ', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,15,'Feb/2016', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}elseif ($this->page==5){
		$this->SetFont('helvetica', '', 6);
		$this->Cell(0,10,'Código: R13-05 Versión: 2.0', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,15,'Noviembre/2015', 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}*/

		//FORMATO
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
	}

	public function Footer() 
	{
		$this->SetY(-15);
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
class MYPDF_noheadfoot extends TCPDF
{	public function Header() 
	{}
	public function Footer() 
	{}
}
?>