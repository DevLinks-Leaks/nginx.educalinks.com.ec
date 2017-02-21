<?php
require_once('../../../core/db_abstract_model.php');

class Ex_Lab_Clinico extends DBAbstractModel{
    //put your code here
    protected $lab_codi;
	public $lab_desc_resultado;
	public $lab_fecha;
	
	public function set_tipo( $nombre )
	{   $this->parametros = array( $nombre );
        $this->query = "insert into tbl_ex_lab_clinico (lab_nombre_ES, lab_usua_ingr, lab_ip_ingr, lab_estado)
						values ( '".$nombre."'getdate(), '".$_SESSION['usua_codi']."', '".$_SERVER['REMOTE_ADDR']."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Examen de laboratorio clínico ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el examen de laboratorio clínico";
        }
    }
	public function delete_tipo( $tipo_codi )
	{   $this->parametros = array( $tipo_codi );
        $this->query = "update tbl_ex_lab_clinico
						set lab_estado = 'I'
						where lab_codi = ".$tipo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Examen de laboratorio clínico inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el examen de laboratorio clínico";
        }
    }
	public function get_tipo( $tipo_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select lab_codi, lab_nombre_ES
						  from tbl_ex_lab_clinico
						 where lab_estado = 'A' 
						   and ( ( lab_codi != -1 and lab_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Examen(es) de laboratorio clínico encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Examen(es) de laboratorio clínico no encontrado(s)";
        }
    }
	public function get_tipo_SelectFormat( $tipo_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select lab_codi, lab_nombre_ES
						  from tbl_ex_lab_clinico
						 where lab_estado = 'A' 
						   and ( ( lab_codi != -1 and lab_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen vacunas ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione examen de laboratorio -',
                                   3 => ''));
        }
		else
		{	$rol = array(  );
            array_pop( $rol );
            array_push( $rol, array(0 => '0', 
                                   1 => '- Seleccione examen de laboratorio -',
                                   3 => '' ) );
            foreach($this->rows as $categorias)
			{	array_push( $rol, array_values( $categorias ) );
            }
            $this->rows = $rol;
            unset( $rol );
        }
    }
	# Método constructor
    function __construct()
	{   //$this->db_name = 'URBALINKS_FINAN';
    }
    # Método destructor del objeto
    function __destruct()
	{   unset($this);
    }
}
?>