<?php
require_once('../../../core/db_abstract_model.php');

class Persona extends DBAbstractModel{
    #propiedades
    protected $per_codi;
	protected $per_nomb;
	protected $per_nomb_seg;
	protected $per_apel;
	protected $per_apel_mat;
	/*	LISTADO DE FUNCIONES: 
	
		get_infoAdicionalCliente
		get_personas_listado
		get_persona
		set_persona
		
		set_actividad_extra
		del_actividad_extra
		get_actividad_extra
		
		set_ele_protex
		del_ele_protex
		get_ele_protex
		
		set_datos_laborales
		del_datos_laborales
		get_datos_laborales
		
		set_rie_lab
		del_rie_lab
		get_rie_lab
		
		set_acc_lab
		del_acc_lab
		get_acc_lab
	*/
	public function get_infoAdicionalCliente( $per_codi, $peri_codi, $tipo_persona )
	{   $this->parametros = array( $per_codi, $peri_codi, $tipo_persona );
		$this->sp = "str_consultaDatosAdicionalesCliente_info";
		$this->executeSPConsulta();

        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Datos encontrados";
        }
		else
		{   $this->mensaje="¡Error! Datos no encontrados";
        }
    }
	public function get_personas_listado($filtros=array())
	{	if (array_key_exists('nombres',$filtros))
		{	$this->parametros = array( 'nombres', $filtros['nombres'], $filtros['tipo_persona'] ); 
        }
		else
		{	$this->parametros = array( 'numeroIdentificacion', $filtros['numeroIdentificacion'], $filtros['tipo_persona'] ); 
        }
        $this->sp = "str_common_persona_list_cons";
        $this->executeSPConsulta();

        if (count($this->rows)>0)
		{	$this->mensaje="¡Exito! Persona(s) encontrada(s).";
        }
		else
		{	$this->mensaje="Error! Persona(s) no encontrada(s).";
        }
    }
	public function get_persona( $per_codi, $tipo_persona = 4 )
	{	$this->parametros =	array( $per_codi, $tipo_persona ); //0. Sin especificar, 1. Alumno, 2. Representante, 3. Empleado, 4. Cliente externo.
        $this->sp = "str_common_persona_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Persona encontrada.";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function get_persona_mini( $per_codi, $tipo_persona = 4 )
	{	$this->parametros =	array( $per_codi, $tipo_persona, $_SESSION['peri_codi'] ); //0. Sin especificar, 1. Alumno, 2. Representante, 3. Empleado, 4. Cliente externo.
        $this->sp = "str_common_persona_mini_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Persona encontrada.";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function set_persona (
		$tipo_persona,					$per_codi,
		$cmb_per_tipo_identificacion,	$per_numero_identificacion,
		$per_nomb,						$per_nomb_seg,				$per_apel,				$per_apel_mat,
		$per_genero,
		
		$cmb_pais_per_residencia,		$cmb_provincia_per_residencia,						$cmb_ciudad_per_residencia, 
		$parroquia,
		
		$per_dir,						$per_telf,					$per_email_personal,
		$per_fecha_nac,
		$cmb_pais_per_lugar_nac,		$cmb_provincia_per_lugar_nac,						$cmb_ciudad_per_lugar_nac,
		
		$cmb_estado_civil_per,			$cmb_profesion_per,			$cmb_lateralidad_per,	$per_ingreso_mensual=0,
		$per_num_hijos = 0,
		
		$empl_codi,						$empl_tipo_empleado,
		$cmb_area_per,					$cmb_dept_per,				$cmb_cargo_per,
		$empr_turno_empl_de,			$empr_turno_empl_a,			$cmb_jornada_per,
		$per_fecha_ini_c,				$per_fecha_fin_c,			$per_empl_ext,			$per_empl_mail,
		$usua_ingr, 					$ip)
	{	if( $per_ingreso_mensual == '' )
			$per_ingreso_mensual = 0;
		$this->parametros =	array(
			$tipo_persona,					$per_codi,
			$cmb_per_tipo_identificacion,	$per_numero_identificacion,
			$per_nomb,						$per_nomb_seg,				$per_apel,				$per_apel_mat,
			$per_genero,
			
			$cmb_pais_per_residencia,		$cmb_provincia_per_residencia,						$cmb_ciudad_per_residencia, 
			$parroquia,
			
			$per_dir,						$per_telf,					$per_email_personal,
			$per_fecha_nac,
			$cmb_pais_per_lugar_nac,		$cmb_provincia_per_lugar_nac,						$cmb_ciudad_per_lugar_nac,
			
			$cmb_estado_civil_per,			$cmb_profesion_per,			$cmb_lateralidad_per,	$per_ingreso_mensual,
			$per_num_hijos,
			
			$empl_codi,						$empl_tipo_empleado,
			$cmb_area_per,					$cmb_dept_per,				$cmb_cargo_per,
			$empr_turno_empl_de,			$empr_turno_empl_a,			$cmb_jornada_per,
			$per_fecha_ini_c,				$per_fecha_fin_c,			$per_empl_ext,			$per_empl_mail,
			$usua_ingr, 					$ip);
        $this->sp = "str_common_persona_new";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   if(!empty( $this->rows[0]['PER_CODI'] ) )
			{   if( $this->rows[0]['PER_CODI'] == -1 )
				{   $this->mensaje="¡Error! No se pudo guardar. Número de identificación ya existe.";
				}
				else
				{   $this->mensaje="¡Exito! Datos de ".$per_nomb." ".$per_nomb_seg." ".$per_apel." ".$per_apel_mat." guardados.";
					$this->per_codi_out = $this->rows[0]['PER_CODI'];
					$this->empl_codi_out = $this->rows[0]['EMPL_CODI'];
				}			
			}
			else
			{    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
								" Si el problema persiste, comuníquese con soporte técnico.";
			}
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	/* --------------------------------
	ACTIVIDAD EXTRALABORAL
	-----------------------------------
	*/
	public function set_actividad_extra( $per_act_ext_codi="", $per_codi, $per_act_ext_detalle, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array( $per_act_ext_codi, $per_codi, $per_act_ext_detalle, $usua_codi, $ip );
        $this->sp = "str_common_persona_act_ext_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Actividad extralaboral guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['per_act_ext_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_actividad_extra( $per_act_ext_codi="", $per_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_persona_act_extralaboral]
						 where [per_codi] = ".$per_codi."
						   and [per_act_ext_codi] = ".$per_act_ext_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Actividad extralaboral eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar actividad extralaboral";
        }
		return $this;
    }
	public function get_actividad_extra( $per_codi = -1, $act_extra_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = "select [per_act_ext_codi], [per_act_ext_detalle]
						  from [dbo].[tbl_persona_act_extralaboral]
					 	 where [per_codi] = ".$per_codi."
						   and ( ( [per_codi] != -1 		and [per_codi] = ".$per_codi." ) 				or ( ".$per_codi." = -1 ) )
						   and ( ( [per_act_ext_codi] != -1 and [per_act_ext_codi] = ".$act_extra_codi." ) 	or ( ".$act_extra_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Actividad(es) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Actividad(es) no encontrada(s)";
        }
    }
	/* --------------------------------
	ELEMENTOS DE PROTECCIÓN
	-----------------------------------
	*/
	public function set_ele_protex( $per_codi, $ele_protex_codi, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array(  $per_codi, $ele_protex_codi, $usua_codi, $ip );
        $this->sp = "str_common_persona_ele_protex_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Elemento de protección guardado correctamente.";
			$this->id_actividad_out = $this->rows[0]['per_ele_protex_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_ele_protex( $per_ele_protex_codi="", $per_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_persona_elemento_proteccion]
						 where [per_codi] = ".$per_codi."
						   and [per_ele_protex_codi] = ".$per_ele_protex_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Elemento de protección eliminado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar elemento de protección";
        }
		return $this;
    }
	public function get_ele_protex( $per_codi = -1, $per_ele_protex_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select per_ele_protex_codi, b.ele_protex_nombre
						   from tbl_persona_elemento_proteccion a
						   left join tbl_elemento_proteccion b
						     on b.ele_protex_codi = a.ele_protex_codi
					 	  where [per_codi] = ".$per_codi."
						    and ( ( [per_codi] != -1 		and [per_codi] = ".$per_codi." ) 							or ( ".$per_codi." = -1 ) )
						    and ( ( [per_ele_protex_codi] != -1 and [per_ele_protex_codi] = ".$per_ele_protex_codi." ) 	or ( ".$per_ele_protex_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Elemento(s) de protección encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Elemento(es) de protección no encontrada(s)";
        }
    }
	/* --------------------------------
	DATOS LABORALES
	-----------------------------------
	*/
	public function set_datos_laborales($per_codi="", $empr_codi, $per_per_empr_codi, $per_empr_nomb, $per_empr_ruc, 
										$per_empr_dir, $per_empr_cargo, $per_empr_telf, $per_empr_mail, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array( 		$per_codi, $empr_codi, $per_per_empr_codi, $per_empr_nomb, $per_empr_ruc, 
										$per_empr_dir, $per_empr_cargo, $per_empr_telf, $per_empr_mail, $usua_codi, $ip );
        $this->sp = "str_common_persona_inst_new";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Datos laborales guardados correctamente.";
			$this->id_actividad_out = $this->rows[0]['per_ele_protex_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_datos_laborales( $per_inst_codi="" )
	{	$this->parametros = array(  );
        $this->query = "delete from tbl_persona_institucion
						 where [per_inst_codi] = ".$per_inst_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Datos laborales eliminados correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudieron eliminar los datos laborales";
        }
		return $this;
    }
	public function get_datos_laborales( $per_codi = -1, $per_inst_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = "  select per_inst_codi, 
								 b.inst_nombre, 
								 b.inst_ruc,
								 a.per_inst_cargo,
								 isnull(c.cont_det_numero,'') as cont_det_numero, 
								 isnull( per_inst_email_inst,'' ) as per_inst_email_inst
							from tbl_persona_institucion a 
							left join tbl_institucion b 
							  on a.inst_codi = b.inst_codi
							left join tbl_contacto_detalle c
							  on (c.contact_codi = b.inst_codi and 
								  c.cont_det_tipo_contact = 2 and 
								  c.cont_det_tipo_numero = 2)
						   where ( ( a.per_codi != -1 		and a.per_codi = ".$per_codi." ) 			or ( ".$per_codi." = -1 ) )
						     and ( ( [per_inst_codi] != -1	and [per_inst_codi] = ".$per_inst_codi." ) 	or ( ".$per_inst_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Datos laborales encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Datos laborales no encontrado(s)";
        }
    }
	public function get_datos_laborales_por_persona_SelectFormat( $per_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select per_inst_codi as value,
								 isnull(a.per_inst_cargo,'') + ' - ' +
								 isnull(b.inst_nombre,'') as text
							from tbl_persona_institucion a
							join tbl_institucion b
							  on a.inst_codi = b.inst_codi
						 where a.per_inst_estado = 'A'
						   and ( ( a.per_codi != -1 		and a.per_codi = ".$per_codi." ) 			or ( ".$per_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen departamentos ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione categoría -',
                                   3 => ''));
        }
		else
		{	$rol = array(  );
            array_pop( $rol );
            array_push( $rol, array(0 => '0', 
                                   1 => '- Seleccione categoría -',
                                   3 => '' ) );
            foreach($this->rows as $categorias)
			{	array_push( $rol, array_values( $categorias ) );
            }
            $this->rows = $rol;
            unset( $rol );
        }
    }
	/* --------------------------------
	RIESGOS LABORALES
	-----------------------------------
	*/
	public function set_rie_laborales(  $inst_risk_codi="", $per_inst_codi, $risk_fisico, $risk_fisicomecanico, $risk_quimico, 
										$risk_biologico, $risk_disergonomico, $risk_psicosocial, $usuario, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array( 		$inst_risk_codi, $per_inst_codi, $risk_fisico, $risk_fisicomecanico, $risk_quimico, 
										$risk_biologico, $risk_disergonomico, $risk_psicosocial, $usuario, $ip );
        $this->sp = "str_common_persona_rie_laborales_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Datos de riesgos laborales guardados correctamente.";
			$this->id_actividad_out = $this->rows[0]['inst_risk_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_rie_laborales( $inst_risk_codi="" )
	{	$this->parametros = array(  );
        $this->query = "delete from [tbl_persona_institucion_riesgo]
						 where [inst_risk_codi] = ".$inst_risk_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Datos de riesgos laborales eliminados correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudieron eliminar los Datos de riesgos laborales";
        }
		return $this;
    }
	public function get_rie_laborales( $per_codi = -1, $inst_risk_codi = -1 )
	{	$this->parametros = array(  );
       $this->query = "SELECT [inst_risk_codi]
							  ,c.inst_nombre
							  ,[risk_fisico]
							  ,[risk_fisicomecanico]
							  ,[risk_quimico]
							  ,[risk_biologico]
							  ,[risk_disergonomico]
							  ,[risk_psicosocial]
						  FROM [dbo].[tbl_persona_institucion_riesgo] a
						  left join tbl_persona_institucion b on b.per_inst_codi = a.per_inst_codi
						  left join tbl_institucion c on c.inst_codi = b.inst_codi
						 where ( ( inst_risk_codi != -1 and inst_risk_codi = ".$inst_risk_codi." ) 	or ( ".$inst_risk_codi." = -1 ) )
						   and ( ( b.per_codi  != -1	and  b.per_codi = ".$per_codi." ) 	or ( ".$per_codi." = -1  ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Datos de riesgos laborales encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Datos de riesgos laborales no encontrado(s)";
        }
    }
	/* --------------------------------
	ACCIDENTES LABORALES
	-----------------------------------
	*/
	public function set_acc_laborales(	$inst_acc_codi="", $per_inst_codi, $acc_fecha_siniestro, $acc_causa, $acc_tipo_lesion,
										$acc_parte_afectada, $acc_incapacidad, $acc_secuelas, $usuario, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array( 		$inst_acc_codi, $per_inst_codi, $acc_fecha_siniestro, $acc_causa, $acc_tipo_lesion,
										$acc_parte_afectada, $acc_incapacidad, $acc_secuelas, $usuario, $ip );
        $this->sp = "str_common_persona_acc_laborales_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Datos de accidentes guardados correctamente.";
			$this->id_actividad_out = $this->rows[0]['inst_acc_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_acc_laborales( $inst_acc_codi="" )
	{	$this->parametros = array(  );
        $this->query = "delete from [tbl_persona_institucion_accidente]
						 where [inst_acc_codi] = ".$inst_acc_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Datos de accidentes eliminados correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudieron eliminar los Datos de accidentes";
        }
		return $this;
    }
	public function get_acc_laborales( $per_codi = -1, $inst_acc_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = "SELECT [inst_acc_codi]
							  ,c.inst_nombre
							  ,convert(varchar, [acc_fecha_siniestro], 103) AS acc_fecha_siniestro
							  ,[acc_causa]
							  ,[acc_tipo_lesion]
							  ,[acc_parte_afectada]
							  ,[acc_incapacidad]
							  ,[acc_secuelas]
						  FROM [dbo].[tbl_persona_institucion_accidente] a
						  left join tbl_persona_institucion b on b.per_inst_codi = a.per_inst_codi
						  left join tbl_institucion c on c.inst_codi = b.inst_codi
						 where ( ( inst_acc_codi != -1  and  inst_acc_codi = ".$inst_acc_codi." ) 	or ( ".$inst_acc_codi." = -1 ) )
						   and ( ( b.per_codi  != -1	and  b.per_codi = ".$per_codi." ) 	or ( ".$per_codi." = -1  ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Datos de accidentes encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Datos de accidentes no encontrado(s)";
        }
    }
	
    # Método constructor
    function __construct() {
        //$this->db_name = 'EDUCALINKS_ADMISIONES';
    }
    # Método destructor del objeto
    function __destruct() {
        unset($this);
    }
}
?>