<?php
require_once('../../../core/db_abstract_model.php');

class Enfermedad extends DBAbstractModel{
    //put your code here
    protected $alergia_codi;
	public $alergia_nombre;
	public $alergia_estado;

	protected $alergia_tipo_codi;
	public $alergia_tipo_nombre;
	public $alergia_tipo_estado;
	
	public function set_tipo( $nombre, $se_puede_heredar )
	{   $this->parametros = array( $nombre, $se_puede_heredar );
        $this->query = "insert into tbl_enfermedad
						values ( '".$nombre."', '".$se_puede_heredar."', 'A' );";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento ingresado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo ingresar la enfermedad";
        }
    }
	public function delete_tipo( $tipo_codi )
	{   $this->parametros = array( $tipo_codi );
        $this->query = "update tbl_enfermedad
						set enf_estado = 'I'
						where enf_codi = ".$tipo_codi.";";
        $this->executeSentenciaAccion();
        if($this->filasAfectadas>0)
		{   $this->mensaje="¡Exito! Tipo de elemento inactivado correctamente";
        }else
		{   $this->mensaje="¡Error! No se pudo inactivar la enfermedad";
        }
    }
	public function get_tipo( $tipo_codi = -1 )
	{   $this->parametros = array(  );
        $this->query = "select enf_codi, enf_nombre
						  from tbl_enfermedad
						 where enf_estado = 'A' 
						   and ( ( enf_codi != -1 and enf_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)>0)
		{   $this->mensaje="¡Exito! Tipo de elemento(s) encontrado(s)";
        }else
		{   $this->mensaje="¡Error! Tipo de elemento(s) no encontrado(s)";
        }
    }
	public function get_tipo_SelectFormat( $tipo_codi = -1 )
    {   $this->parametros = array(  );
        $this->query = "select enf_codi, enf_nombre
						  from tbl_enfermedad
						 where enf_estado = 'A' 
						   and ( ( enf_codi != -1 and enf_codi = ".$tipo_codi." ) or ( ".$tipo_codi." = -1 ) );";
        $this->executeSentenciaConsulta();
        if (count($this->rows)<=0)
		{	$this->mensaje="¡Error! No existen enfermedades ingresadas en la BD.";
            array_pop($rol);
            array_push($rol, array(0 => '0', 
                                   1 => '- Seleccione enfermedad -',
                                   3 => ''));
        }
		else
		{	$rol = array(  );
            array_pop( $rol );
            array_push( $rol, array(0 => '0', 
                                   1 => '- Seleccione enfermedad -',
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