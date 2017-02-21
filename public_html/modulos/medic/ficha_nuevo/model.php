<?php
require_once('../../../core/db_abstract_model.php');

class Ficha_medica extends DBAbstractModel{
    #propiedades
    public $numero;
    public $codigo;
    public $codigoCliente;
    public $nombreTitular;
    public $direccionTitular;
    public $telefonoTitular;
    public $emailTitular;
	public $estado;
	/*
		get_ficha_medica_listado
		get_ficha_medica
		set_ficha_medica
		
		set_enfermedad
		del_enfermedad
		get_enfermedad
		
		set_vacuna
		del_vacuna
		get_vacuna
		
		set_alergia
		del_alergia
		get_alergia
		
		set_cirugia
		del_crugia
		get_cirugia
		
		set_lab_ex_clinico
		del_lab_ex_clinico
		get_lab_ex_clinico
		
		set_radiografia
		del_radiografia
		get_radiografia
	*/
	public function get_ficha_medica_listado_individual( $fmex_codi='-1', $alum_codi='-1', $tipo_ficha='-1' )
	{	$this->parametros =	array( $fmex_codi, $alum_codi, $tipo_ficha );
        $this->sp = "str_medic_ficha_medica_list_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Ficha(s) m&eacute;dica(s) encontrada(s).";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
    }
	public function get_ficha_medica_listado( $fmex_codi='-1' )
	{	$this->parametros =	array( $fmex_codi );
        $this->sp = "str_medic_ficha_medica_list_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Ficha(s) m&eacute;dica(s) encontrada(s).";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
    }
	public function get_ficha_medica( $fmex_codi )
	{	$this->parametros =	array( $fmex_codi );
        $this->sp = "str_medic_ficha_medica_cons";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Ficha m&eacute;dica encontrada.";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function get_ficha_medica_PDF( $fmex_codi )
	{	$this->parametros =	array( $fmex_codi );
        $this->sp = "str_medic_ficha_medica_cons_pdf";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Ficha m&eacute;dica encontrada.";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function set_ficha_medica (
			$fmex_codi,					$per_codi,					$tipo_persona,
			$fmex_tipo_ficha = 'NORM',
			$fmex_tabaco,				$fmex_alcohol,				$fmex_drogas,
			$fmex_con_fisica,			$fmex_act_sicomotora,		$fmex_deambulacion,
			$fmex_exp_verbal,			$fmex_estado_nutricional,	$fmex_estatura=0,
			$fmex_peso=0,				$fmex_temp_bucal=0,			$fmex_pulso=0,
			$fmex_presion_arterial=0,	$fmex_piel,					$fmex_ganglios,
			$fmex_cabeza,				$fmex_cuello,				$fmex_ojos,
			$fmex_oidos,				$fmex_boca,					$fmex_nariz,
			$fmex_dentadura,			$fmex_garganta,				$fmex_corazon,
			$fmex_torax,				$fmex_pulmones,				$fmex_mamas,
			$fmex_higado,				$fmex_ves_biliar,			$fmex_bazo,
			$fmex_estomago,				$fmex_intestinos,			$fmex_apendice,
			$fmex_ano,
			$fmex_umbilical,			$fmex_rurales,				$fmex_inguinal_derecha,
			$fmex_inguinal_izquierda,	$fmex_deformaciones,		$fmex_masas_musculares,
			$fmex_movibilidad,			$fmex_puntos_dolorosos,		$fmex_tracto_urinario,
			$fmex_espermaquia,			$fmex_tracto_genital_masculino,
			$fmex_tracto_genital_femenino,
			$fmex_menstruacion,			$fmex_menarquia,			$fmex_menapmia,
			$fmex_gesta,				$fmex_partos,				$fmex_aborto,
			$fmex_cesarea,				$fmex_superior_derecha,		$fmex_superior_izquierda,
			$fmex_inferior_derecha,		$fmex_inferior_izquierda,	$fmex_ojo_derecho,
			$fmex_ojo_izquierdo,		$fmex_oido_derecho,			$fmex_oido_izquierdo,
			$fmex_reflex_tendinosos,	$fmex_reflex_pupilares,		$fmex_marcha,
			$fmex_sens_superficial,		$fmex_profunda_romberg,		$fmex_estado_mental,
			$fmex_memoria,				$fmex_irritabilidad,		$fmex_depresion,
			$fmex_aptitud_trabajo,		$usua_ingr,					$ip)
	{	if( $fmex_estatura == '' )
			$fmex_estatura = 0;
		if( $fmex_peso == '' )
			$fmex_peso = 0;
		if( $fmex_temp_bucal == '' )
			$fmex_temp_bucal = 0;
		if( $fmex_pulso == '' )
			$fmex_pulso = 0;
		if( $fmex_presion_arterial == '' )
			$fmex_presion_arterial = 0;
		$this->parametros =	array(
			$fmex_codi,					$per_codi,					$tipo_persona,
			$fmex_tipo_ficha,
			$fmex_tabaco,				$fmex_alcohol,				$fmex_drogas,
			$fmex_con_fisica,			$fmex_act_sicomotora,		$fmex_deambulacion,
			$fmex_exp_verbal,			$fmex_estado_nutricional,	$fmex_estatura,
			$fmex_peso,					$fmex_temp_bucal,			$fmex_pulso,
			$fmex_presion_arterial,		$fmex_piel,					$fmex_ganglios,
			$fmex_cabeza,				$fmex_cuello,				$fmex_ojos,
			$fmex_oidos,				$fmex_boca,					$fmex_nariz,
			$fmex_dentadura,			$fmex_garganta,				$fmex_corazon,
			$fmex_torax,				$fmex_pulmones,				$fmex_mamas,
			$fmex_higado,				$fmex_ves_biliar,			$fmex_bazo,
			$fmex_estomago,				$fmex_intestinos,			$fmex_apendice,
			$fmex_ano,
			$fmex_umbilical,			$fmex_rurales,				$fmex_inguinal_derecha,
			$fmex_inguinal_izquierda,	$fmex_deformaciones,		$fmex_masas_musculares,
			$fmex_movibilidad,			$fmex_puntos_dolorosos,		$fmex_tracto_urinario,
			$fmex_espermaquia,			$fmex_tracto_genital_masculino,
			$fmex_tracto_genital_femenino,
			$fmex_menstruacion,			$fmex_menarquia,			$fmex_menapmia,
			$fmex_gesta,				$fmex_partos,				$fmex_aborto,
			$fmex_cesarea,				$fmex_superior_derecha,		$fmex_superior_izquierda,
			$fmex_inferior_derecha,		$fmex_inferior_izquierda,	$fmex_ojo_derecho,
			$fmex_ojo_izquierdo,		$fmex_oido_derecho,			$fmex_oido_izquierdo,
			$fmex_reflex_tendinosos,	$fmex_reflex_pupilares,		$fmex_marcha,
			$fmex_sens_superficial,		$fmex_profunda_romberg,		$fmex_estado_mental,
			$fmex_memoria,				$fmex_irritabilidad,		$fmex_depresion,
			$fmex_aptitud_trabajo,		$usua_ingr,					$ip);
        $this->sp = "str_medic_ficha_medica_new";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   if(!empty( $this->rows[0]['fmex_codi'] ) )
			{   $this->mensaje="¡Exito! Ficha m&eacute;dica guardada.";
				$this->fmex_codi_out = $this->rows[0]['fmex_codi'];
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
	ALERGIAS
	-----------------------------------
	*/
	public function set_alergia( $fmex_codi, $ale_codi, $ale_reaccion, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array(  $fmex_codi, $ale_codi, $ale_reaccion, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_alergia_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Alergia guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_ale_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_alergia( $fmex_ale_codi="", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_alergia]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_ale_codi] = ".$fmex_ale_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Alergia eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar alergia";
        }
		return $this;
    }
	public function get_alergia( $fmex_codi = -1, $fmex_ale_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select fmex_ale_codi, b.ale_nombre, a.ale_desc_reaccion, b.ale_codi, b.ale_tipo
						   from tbl_ficha_alergia a
						   left join tbl_alergia b
						     on b.ale_codi = a.ale_codi
					 	  where [fmex_codi] = ".$fmex_codi."
						    and ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and ( ( [fmex_ale_codi] != -1 and [fmex_ale_codi] = ".$fmex_ale_codi." ) 	or ( ".$fmex_ale_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Alergia(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Alergia(s) no encontrada(s)";
        }
    }
	/* --------------------------------
	VACUNAS
	-----------------------------------
	*/
	public function set_vacuna( $fmex_codi, $vac_codi, $vac_fecha, $vac_obs, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array(  $fmex_codi, $vac_codi, $vac_fecha, $vac_obs, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_vacuna_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Vacuna guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_vac_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_vacuna( $fmex_vac_codi="", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_vacuna]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_vac_codi] = ".$fmex_vac_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Vacuna eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar vacuna";
        }
		return $this;
    }
	public function get_vacuna( $fmex_codi = -1, $fmex_vac_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select fmex_vac_codi, b.vac_nombre,  convert(varchar,a.vac_fecha_apli,103) as vac_fecha_apli, a.vac_obs, b.vac_codi
						   from tbl_ficha_vacuna a
						   left join tbl_vacuna b
						     on b.vac_codi = a.vac_codi
					 	  where [fmex_codi] = ".$fmex_codi."
						    and ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and ( ( [fmex_vac_codi] != -1 and [fmex_vac_codi] = ".$fmex_vac_codi." ) 	or ( ".$fmex_vac_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Vacuna(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Vacuna(s) no encontrada(s)";
        }
    }
	/* --------------------------------
	ENFERMEDADES
	-----------------------------------
	*/
	public function set_enfermedad( $fmex_codi, $enf_codi, $enf_tiene, $enf_tuvo, $enf_titular = "T", $enf_parentesco="", $enf_tratamiento, $enf_obs, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array(  $fmex_codi, $enf_codi, $enf_tiene, $enf_tuvo, $enf_titular, $enf_parentesco, $enf_tratamiento, $enf_obs, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_enfermedad_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Enfermedad guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_enf_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_enfermedad( $fmex_enf_codi = "", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_enfermedad]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_enf_codi] = ".$fmex_enf_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Enfermedad eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar enfermedad";
        }
		return $this;
    }
	public function get_enfermedad( $fmex_codi = -1, $titular = 'T', $fmex_enf_codi = -1 )
	{	if ( $titular == 'F' )
			$columna_parentesco = " case isnull( c.descripcion, '' ) 
									when '' then '- No especificó -'
									else isnull( c.descripcion, '' ) 
									end as enf_parentesco, ";
		else 
			$columna_parentesco = "";
		
		$this->parametros = array(  );
        $this->query = " select fmex_enf_codi, b.enf_nombre, 
								case a.enf_tiene when 'S' then 'Si' else 'No' END as enf_tiene, 
								case a.enf_tuvo when 'S' then 'Si' else 'No' END as enf_tuvo,
								case a.enf_tratamiento when 'S' then 'Si' else 'No' END as enf_tratamiento,
								".$columna_parentesco."
								a.enf_desc_tratamiento, b.enf_codi
						   from tbl_ficha_enfermedad a
						   left join tbl_enfermedad b
						     on b.enf_codi = a.enf_codi
						   left join catalogo c on ( c.idpadre = 2 and c.idcatalogo = a.enf_parentesco )
					 	  where ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and [enf_titular] = '".$titular."'
						    and ( ( [fmex_enf_codi] != -1 and [fmex_enf_codi] = ".$fmex_enf_codi." ) 	or ( ".$fmex_enf_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Enfermedad(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Enfermedad(s) no encontrada(s)";
        }
    }
	/* --------------------------------
	CIRUGIAS
	-----------------------------------
	*/
	public function set_cirugia( $fmex_codi, $cir_nombre_desc, $cir_fecha, $cir_localizacion, $cir_extension, $cir_proposito, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros=array( $fmex_codi, $cir_nombre_desc, $cir_fecha, $cir_localizacion, $cir_extension, $cir_proposito, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_cirugia_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Cirugia guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_enf_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_cirugia( $fmex_enf_codi = "", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_cirugia]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_cir_codi] = ".$fmex_enf_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Cirugia eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar cirugia";
        }
		return $this;
    }
	public function get_cirugia( $fmex_codi = -1, $fmex_cir_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select fmex_cir_codi, cir_nombre_desc, convert(varchar,cir_fecha,103) as cir_fecha, 
								case cir_localizacion
									when 'INT' then 'Interna'
									when 'EXT' then 'Externa'
									else 'No indicó'
								end as cir_localizacion, 
								case cir_extension
									when 'MAY' then 'Mayor'
									when 'MEN' then 'Menor'
									else 'No indicó'
								end as cir_extension,
								case cir_proposito 
									when 'CUR' then 'Curativas'
									when 'REP' then 'Reparadoras'
									when 'PAL' then 'Paliativas'
									when 'COS' then 'Cosméticas'
									else 'No indicó'
								end as cir_proposito 
						   from tbl_ficha_cirugia
					 	  where ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and ( ( [fmex_cir_codi] != -1 and [fmex_cir_codi] = ".$fmex_cir_codi." ) 	or ( ".$fmex_cir_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Cirugia(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Cirugia(s) no encontrada(s)";
        }
    }
	/* --------------------------------
	EXÁMENES DE LABORATORIO CLÍNICO
	-----------------------------------
	*/
	public function set_ex_lab_clinico( $fmex_codi, $lab_codi, $lab_desc_resultado, $lab_fecha, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array( 		$fmex_codi, $lab_codi, $lab_desc_resultado, $lab_fecha, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_ex_lab_clinico_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Examen de laboratorio cl&iacute;nico guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_lab_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_ex_lab_clinico( $fmex_lab_codi = "", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_ex_lab_clinico]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_lab_codi] = ".$fmex_lab_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Examen de laboratorio clínico eliminado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar examen de laboratorio clínico";
        }
		return $this;
    }
	public function get_ex_lab_clinico( $fmex_codi = -1, $fmex_lab_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select fmex_lab_codi, lab_nombre_ES, lab_desc_resultado, convert(varchar, lab_fecha, 103) as lab_fecha
						   from tbl_ficha_ex_lab_clinico a
						   left join tbl_ex_lab_clinico b
							 on a.lab_codi = b.lab_codi
					 	  where ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and ( ( [fmex_lab_codi] != -1 and [fmex_lab_codi] = ".$fmex_lab_codi." ) 	or ( ".$fmex_lab_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Examen(es) de laboratorio clínico encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Examen(es) de laboratorio clínico no encontrada(s)";
        }
    }
	/* --------------------------------
	RADIOGRAFÍAS
	-----------------------------------
	*/
	public function set_radiografia( $fmex_codi, $rad_nombre_desc, $rad_fecha, $rad_localizacion, $usua_codi, $ip )
	{	$this->id_actividad_out = 0;
		$this->parametros =	array(   $fmex_codi, $rad_nombre_desc, $rad_fecha, $rad_localizacion, $usua_codi, $ip );
        $this->sp = "str_medic_ficha_med_radiografia_set";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Radiografia guardada correctamente.";
			$this->id_actividad_out = $this->rows[0]['fmex_rad_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema. Por favor, intente nuevamente luego de unos minutos.".
							" Si el problema persiste, comuníquese con soporte técnico.";
        }
		return $this;
    }
	public function del_radiografia( $fmex_rad_codi = "", $fmex_codi )
	{	$this->parametros = array( $tipo_codi );
        $this->query = "delete from [dbo].[tbl_ficha_radiografia]
						 where [fmex_codi] = ".$fmex_codi."
						   and [fmex_rad_codi] = ".$fmex_rad_codi." ;";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Radiografia eliminada correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo eliminar radiografia";
        }
		return $this;
    }
	public function get_radiografia( $fmex_codi = -1, $fmex_rad_codi = -1 )
	{	$this->parametros = array(  );
        $this->query = " select fmex_rad_codi, rad_nombre_desc, convert(varchar, rad_fecha, 103) as rad_fecha, rad_localizacion
						   from tbl_ficha_radiografia
					 	  where ( ( [fmex_codi] != -1 		and [fmex_codi] = ".$fmex_codi." )			or ( ".$fmex_codi." = -1 ) )
						    and ( ( [fmex_rad_codi] != -1 and [fmex_rad_codi] = ".$fmex_rad_codi." ) 	or ( ".$fmex_rad_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Radiografia(s) encontrada(s)";
        }else
		{   $this->mensaje="¡Error! Radiografia(s) no encontrada(s)";
        }
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
?>