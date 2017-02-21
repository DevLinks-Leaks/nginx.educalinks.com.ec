<?php
require_once('../../../core/db_abstract_model.php');

class Vacuna extends DBAbstractModel{
    //put your code here
    protected $alergia_codi;
	public $alergia_nombre;
	public $alergia_estado;

	protected $alergia_tipo_codi;
	public $alergia_tipo_nombre;
	public $alergia_tipo_estado;
	
	public function set_tipo( $nombre )
	{   $this->parametros = array( $nombre );
        $this->query = "insert into tbl_vacuna
						values ( '".$nombre."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar el tipo de elemento";
        }
    }
	public function delete_tipo( $tipo_codi )
	{   $this->parametros = array( $tipo_codi );
        $this->query = "update tbl_vacuna
						set vac_estado = 'I'
						where vac_codi = ".$tipo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar el tipo de elemento";
        }
    }
	public function get_tipo( $tipo_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select vac_codi, vac_nombre
						  from tbl_vacuna
						 where vac_estado = 'A' 
						   and ( ( vac_codi != -1 and vac_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Tipo de elemento(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Tipo de elemento(s) no encontrado(s)";
        }
    }
	public function get_tipo_SelectFormat( $tipo_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select vac_codi, vac_nombre
						  from tbl_vacuna
						 where vac_estado = 'A' 
						   and ( ( vac_codi != -1 and vac_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen vacunas ingresados en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione tipo de vacuna -',
                                   3 => ''));
        }
		else
		{	$rol = array(  );
            array_pop( $rol );
            array_push( $rol, array(0 => '0', 
                                   1 => '- Seleccione tipo de alergia -',
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