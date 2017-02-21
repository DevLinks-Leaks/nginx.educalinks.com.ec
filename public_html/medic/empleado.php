<?php
require_once('../../core/db_abstract_model.php');

class Empleado extends DBAbstractModel{
    #propiedades
    protected $empl_codi;
	
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
    {   $this->parametros = array( );
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