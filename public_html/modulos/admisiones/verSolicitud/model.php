<?php
require_once('../../../core/db_abstract_model.php');

class Solicitud extends DBAbstractModel{
    #propiedades
    protected $id_solicitud;
	
	public function get_solicitud_admision_especifica( $id_solicitud = "")
	{   $this->parametros = array( $id_solicitud );
		$this->sp = "str_admisiones_solicitud_especifica";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Solicitud encontrada.";
        }else{
            $this->mensaje="Solicitud no encontrada.";
        }
        return $this->rows;
	}
	public function get_solicitud_persona_consulta( $id_solicitud, $alum_per_codi )//trae estudiante, 1 fila
	{   $this->parametros = array( $id_solicitud, $alum_per_codi );
		$this->sp = "str_admisiones_solicitud_persona_consulta";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Solicitud encontrada.";
        }else{
            $this->mensaje="Solicitud no encontrada.";
        }
        return $this->rows;
	}
	public function get_solicitud_repr_consulta( $alum_per_codi )//trae representantes, 1+ fila(s)
	{   $this->parametros = array( $alum_per_codi );
		$this->sp = "str_admisiones_solicitud_repr_consulta";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Representante encontrado.";
        }else{
            $this->mensaje="Representante no encontrado.";
        }
        return $this->rows;
	}
	public function get_solicitud_repr_consulta_especifica( $alum_per_codi, $repr_per_codi )
	{   $this->parametros = array( $alum_per_codi, $repr_per_codi );
		$this->sp = "str_admisiones_solicitud_repr_consulta_especifica";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Representante encontrado.";
        }else{
            $this->mensaje="Representante no encontrado.";
        }
        return $this->rows;
	}
	public function get_solicitudes( $soli_estado = "zzz", $soli_codi = "zzz" , $id_repr_acad = "zzz" , $curso_aplicado = 0 , 
									 $fini_ingreso = "zzz" , $ffin_ingreso = "zzz" , $num_intento = -1, $peri_codi = 0 )
	{   if ( $num_intento == "" )
			$num_intento = "-1";
		if( $soli_estado == '' )
			$soli_estado = 'zzz';
		if( $soli_codi == '' )
			$soli_codi = 'zzz';
		if( $id_repr_acad == '' )
			$id_repr_acad = 'zzz';
		if( $curso_aplicado == '' )
			$curso_aplicado = '0';
		if( $fini_ingreso == '' )
			$fini_ingreso = 'zzz';
		if( $ffin_ingreso == '' )
			$ffin_ingreso = 'zzz';
		if( $peri_codi == '' )
			$peri_codi = '0';
		$this->parametros = array( $soli_estado, $soli_codi, $id_repr_acad, $curso_aplicado, 
									 $fini_ingreso, $ffin_ingreso, $num_intento, $peri_codi);
		$this->sp = "str_admisiones_solicitud_consulta_general";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Solicitud(es) encontrada(s).";
        }else{
            $this->mensaje="Solicitud(es) no encontrada(s).";
        }
        return $this->rows;
	}
	public function get_documentosPdtes_cabecera( $peri_codi )
    {   $this->parametros = array( );
        $this->query = "select docu_descr 
						  from Documento_periodo b
						  left join Documento c on ( b.docu_codi = c.docu_codi and c.docu_estado = 'A')
						 where b.docu_peri_estado = 'A'
						   and ( ( b.peri_codi <> '0' AND b.peri_codi = '".$peri_codi."' ) OR
								 ( '".$peri_codi."' = '0' ) )
						 order by docu_descr;";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Documento(s) encontrado(s)";
        }else
		{   $this->mensaje="Documento(s) no encontrado(s)";
        }
        return $this;
    }
	public function get_documentosPdtes( $soli_estado = "zzz", $soli_codi = "zzz" , $id_repr_acad = "zzz" , $curso_aplicado = 0 , 
									 $fini_ingreso = "zzz" , $ffin_ingreso = "zzz" , $num_intento = -1, $peri_codi = 0 )
	{   if ( $num_intento == "" )
			$num_intento = "-1";
		if( $soli_estado == '' )
			$soli_estado = 'zzz';
		if( $soli_codi == '' )
			$soli_codi = 'zzz';
		if( $id_repr_acad == '' )
			$id_repr_acad = 'zzz';
		if( $curso_aplicado == '' )
			$curso_aplicado = '0';
		if( $fini_ingreso == '' )
			$fini_ingreso = 'zzz';
		if( $ffin_ingreso == '' )
			$ffin_ingreso = 'zzz';
		if( $peri_codi == '' )
			$peri_codi = '0';
		$this->parametros = array( $soli_estado, $soli_codi, $id_repr_acad, $curso_aplicado, 
									 $fini_ingreso, $ffin_ingreso, $num_intento, $peri_codi);
		$this->sp = "str_acad_documentosPdtes_busq";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Búsqueda exitosa";
        }else{
            $this->mensaje="Búsqueda no exitosa";
        }
        return $this->rows;
	}
	public function get_alum_info_docu( $alum_codi, $peri_codi )
	{   $this->parametros = array( $alum_codi, $peri_codi );
		$this->sp = "alum_info_docu";
        $this->executeSPConsulta();

        if (count($this->rows)>0){
            $this->mensaje="Documento(s) encontrado(s).";
        }else{
            $this->mensaje="Documento(s) no encontrado(s).";
        }
        return $this->rows;
	}
	public function get_Curso( $curs_codi )
    {   $this->parametros = array( );
        $this->query = "select curs_deta from cursos where curs_codi = '".$curs_codi."' order by curs_orden";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Curso(s) encontrado(s)";
        }else
		{   $this->mensaje="Curso(s) no encontrado(s)";
        }
    }
	public function get_Cursos( )
    {   $this->parametros = array( );
        $this->query = "select curs_codi, curs_deta from cursos order by curs_orden";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen categorias en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Curso al que aplica',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Curso al que aplica',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_Periodos2( )
    {   $this->parametros = array( );
        $this->query = "select peri_codi, peri_deta from periodos";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existen períodos en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione un período',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione un período',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function get_Periodos( )
    {   $this->parametros = array( );
        $this->query = "select peri_codi, peri_deta from periodos";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Documento(s) encontrado(s).";
        }else
		{   $this->mensaje="Documento(s) no encontrado(s).";
        }
        return $this->rows;
    }
	public function get_Catalogo_by_idPadre( $idpadre )
    {   //$this->parametros = array( $idpadre );
        //$this->sp = "cata_hijo_view";
        //$this->executeSPConsulta();
		$this->parametros = array( );
        $this->query = "select idcatalogo codigo, descripcion from catalogo where idpadre = ".$idpadre; //id que se manda es 2
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="No existe este catálogo en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
        }
		else
		{	$rol = array();
            array_pop($rol);
            array_push($rol, array(0 => '', 
                                   1 => 'Seleccione...',
                                   3 => ''));
            foreach($this->rows as $categorias)
			{	array_push($rol, array_values($categorias));
            }
            $this->rows = $rol;
            unset($rol);
        }
    }
	public function set_solicitud_preadmision (
		$id_solicitud,					$per_codi,					$soli_foto,
		$cmb_per_tipo_identificacion, 	$per_numero_identificacion,	$per_nomb,	$per_nomb_seg,
		$per_apel,						$per_apel_mat,				$per_dir,	$per_telf,
		$per_fecha_nac,					$per_rdb_genero,			$per_email_personal,
		$cmb_pais_per_lugar_nac,		$cmb_provincia_per_lugar_nac,
		$cmb_ciudad_per_lugar_nac,		$cmb_curso_aplica,			$cmb_pais_colegio_anterior,	
		$cmb_provincia_colegio_anterior,$cmb_ciudad_colegio_anterior,
		$cmb_colegio_anterior,			$ckb_colegio_no_encontrado,	$per_col_anterior,
		$per_col_anterior_dir,			$per_num_hermanos,			$ckb_tiene_hermanos_en_colegio,
		$per_tiene_hermanos_en_colegio,	$per_con_quien_vive,		$ckb_preadmision_anterior,
		$cmb_per_preadmision_anterior,	$ckb_matriculado_anteriormente,
		$per_vive_casa,					$per_tiempo_residencia,		$per_como_se_entero,
		$peri_codi,						$usua_ingr, 				$ip,
		$soli_estado = "")
	{	$this->id_solicitud_out = 0;
		if( $per_fecha_nac == "" )
			$per_fecha_nac = "1900-01-01";
		$this->parametros =	array(
			$id_solicitud,					$per_codi,					$soli_foto,
			$cmb_per_tipo_identificacion, 	$per_numero_identificacion,	$per_nomb,	$per_nomb_seg,
			$per_apel,						$per_apel_mat,				$per_dir,	$per_telf,
			$per_fecha_nac,					$per_rdb_genero,			$per_email_personal,
			$cmb_pais_per_lugar_nac,		$cmb_provincia_per_lugar_nac,
			$cmb_ciudad_per_lugar_nac,		$cmb_curso_aplica,			$cmb_pais_colegio_anterior,	
			$cmb_provincia_colegio_anterior,$cmb_ciudad_colegio_anterior,
			$cmb_colegio_anterior,			$ckb_colegio_no_encontrado,	$per_col_anterior,
			$per_col_anterior_dir,			$per_num_hermanos,			$ckb_tiene_hermanos_en_colegio,
			$per_tiene_hermanos_en_colegio,	$per_con_quien_vive,		$ckb_preadmision_anterior,
			$cmb_per_preadmision_anterior,	$ckb_matriculado_anteriormente,
			$per_vive_casa,					$per_tiempo_residencia,		$per_como_se_entero,
			$peri_codi,						$usua_ingr, 				$ip,
			$soli_estado);
        $this->sp = "str_admisiones_solicitud_new";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Solicitud y datos de postulante guardados. Su código es: '".$this->rows[0]['ID_SOLICITUD']."'.";
			$this->id_solicitud_out = $this->rows[0]['ID_SOLICITUD'];
			$this->per_codi_out = $this->rows[0]['PER_CODI'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar guardar datos del estudiante y la solicitud. Por favor, intente en unos minutos.";
        }
		return $this;
    }
	public function set_solicitud_representante (
		$id_solicitud,					$estudiante_per_codi,		$repr_codi,
		$cmb_repr_tipo_identificacion,	$repr_numero_identificacion,
		$repr_nomb,						$repr_nomb_seg,				$repr_apel,				$repr_apel_mat,
		$repr_dir,						$repr_telf,					$repr_email_personal,
		$repr_fecha_nac,
		$cmb_pais_repr_lugar_nac,		$cmb_provincia_repr_lugar_nac,						$cmb_ciudad_repr_lugar_nac,
		$cmb_estado_civil_repr,			$cmb_profesion_repr,
		
		$inst_codi = "",				$per_inst_codi="",
		$repr_empr_nomb,				$repr_empr_ruc,			$repr_empr_dir,			
		$repr_empr_cargo,				$repr_empr_ingreso_mensual,	$repr_empr_telf,		$repr_empr_mail,

		$ckb_repr_es_exalumno,			$repr_cmb_es_exalumno,		$ckb_repr_es_extrabajador,
		$repr_es_extrabajador_fecha_ini,$repr_es_extrabajador_fecha_fin,					$relacion,
		$peri_codi,						$usua_ingr, 				$ip)
	{	$this->id_solicitud_out = 0;
		if( $repr_empr_ingreso_mensual == "" )
			$repr_empr_ingreso_mensual = 0;
		if( $repr_fecha_nac == "" )
			$repr_fecha_nac = "1900-01-01";
		$this->parametros =	array(
			$id_solicitud,					$estudiante_per_codi,	$repr_codi,
			$cmb_repr_tipo_identificacion,	$repr_numero_identificacion,
			$repr_nomb,						$repr_nomb_seg,			$repr_apel,				$repr_apel_mat,
			$repr_dir,						$repr_telf,				$repr_email_personal,
			$repr_fecha_nac,
			$cmb_pais_repr_lugar_nac,		$cmb_provincia_repr_lugar_nac,					$cmb_ciudad_repr_lugar_nac,
			$cmb_estado_civil_repr,			$cmb_profesion_repr,
			
			$inst_codi,						$per_inst_codi,
			$repr_empr_nomb,				$repr_empr_ruc,			$repr_empr_dir,			
			$repr_empr_cargo,				$repr_empr_ingreso_mensual,	$repr_empr_telf,		$repr_empr_mail,

			$ckb_repr_es_exalumno,			$repr_cmb_es_exalumno,		$ckb_repr_es_extrabajador,
			$repr_es_extrabajador_fecha_ini,$repr_es_extrabajador_fecha_fin,				$relacion,
			$peri_codi,						$usua_ingr, 				$ip);
        $this->sp = "str_admisiones_solicitud_repr_new";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Datos representante, guardado.";
			$this->per_codi_out = $this->rows[0]['PER_CODI'];
			$this->inst_codi_out = $this->rows[0]['INST_CODI'];
			$this->per_inst_codi_out = $this->rows[0]['PER_INST_CODI'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al guardar datos del representante. Por favor, asegúrese de ingresar los datos correctamente.";
        }
		return $this;
    }
	public function delete_solicitud_maint( $id_solicitud, $usua_ingr, $ip )
	{	$this->parametros = array( );
        //$this->query = "update tbl_solicitud set soli_estado = 'ELIMINADO' where soli_codi = '".$id_solicitud."';"; //CAG20160003, CAG20160008
        $this->query = "delete from tbl_solicitud where soli_codi = '".$id_solicitud."';
						delete from tbl_solicitud_fecha_examend where soli_codi = '".$id_solicitud."';
						delete from tbl_historial_estadod where soli_codi = '".$id_solicitud."';
						delete from tbl_solicitud_sintesisd where soli_codi = '".$id_solicitud."';
						delete from tbl_solicitud_repr_inf_adicionald where soli_codi = '".$id_solicitud."';
						delete from tbl_solicitudd where soli_codi = '".$id_solicitud."';";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="Solicitud eliminada";
        }else
		{   $this->mensaje="¡Error! Solicitud no encontrada";
        }
		return $this;
    }
	public function set_solicitud_estado_maint( $id_solicitud, $soli_estado, $usua_ingr, $ip )
	{	$this->parametros = array( );
        $this->query = "update tbl_solicitud set soli_estado = '".$soli_estado."' where soli_codi = '".$id_solicitud."';";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Estado de solicitud cambiada";
        }else
		{   $this->mensaje="¡Error! Solicitud no encontrada";
        }
		return $this;
    }
	public function set_solicitud_estado( $id_solicitud, $estado, $soli_observacion = "", $usua_ingr, $ip )
	{	$this->id_solicitud_out = 0;
		$this->parametros =	array( $id_solicitud, $estado, $soli_observacion, $usua_ingr, $ip );
        $this->sp = "str_admisiones_solicitud_estado";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Solicitud guardada. Su código es: '".$this->rows[0]['ID_SOLICITUD']."'.";
			$this->id_solicitud_out = $this->rows[0]['ID_SOLICITUD'];
			$this->estado_out = $this->rows[0]['ESTADO'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar procesar su solicitud. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function set_solicitud_fecha($soli_codi,					$soli_fex_codi = "",
										$soli_fex_fecha_asignada ,	$soli_fex_actividad ="",
										$usuario_o_ip_forwarded,	$ip_remote,
										$cambiar_estado = 0 )
	{	$this->id_solicitud_out = 0;
		$this->parametros =	array( 	$soli_codi,					$soli_fex_codi,
									$soli_fex_fecha_asignada ,	$soli_fex_actividad,
									$usuario_o_ip_forwarded,	$ip_remote,
									$cambiar_estado );
        $this->sp = "str_admisiones_asignar_fecha_examen";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Fecha asignada correctamente.";
			$this->id_solicitud_out = $this->rows[0]['soli_fex_codi'];
			$this->estado_out = $this->rows[0]['fecha_reg'];
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar procesar su solicitud. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function solicitud_fecha_examen_ver( $soli_codi )
	{	$this->parametros =	array( $soli_codi );
        $this->sp = "str_admisiones_fecha_examen_ver";
        $this->executeSPConsulta();
        if (count($this->rows)>0)
        {   $this->mensaje="¡Exito! Fecha(s) encontrada(s).";
        }
        else
        {    $this->mensaje="¡Error! Hubo un problema al intentar procesar su solicitud. Por favor, intente nuevamente luego de unos minutos.";
        }
		return $this;
    }
	public function solicitud_fecha_examen_borrar( $soli_codi, $soli_fex_codi, $usuario_o_ip_forwarded, $ip_remote )
	{   $this->parametros = array( $soli_codi, $soli_fex_codi, $usuario_o_ip_forwarded, $ip_remote );
		$this->sp = "str_admisiones_fecha_examen_erase";
		$this->executeSPConsulta();
		if(count($this->rows)>0)
		{   $this->mensaje="¡Exito! Fecha borrada exitosamente.";
		}
		else
		{   $this->mensaje="¡Error! No se pudo borrar la fecha.";
		}
		return $this;
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